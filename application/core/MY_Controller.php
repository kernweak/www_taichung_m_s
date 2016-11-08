<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');   
class  MY_Controller  extends  CI_Controller  {  

	public function User_Login($type = "0"){
		$If_Pass = false ;
		$this->load->library('session');
		$time_L = 0	;
		$code = 0	;	//0:未登入/1:已登入
		//------------------------------------
		//$Login_PW	= ""	;
		$Login_ID 	= "" 	;
		$FullName 	= ""	;
		$msg 		= ""	;
		//var_dump($_POST['Login_ID']);
		if(isset($_POST['Login_ID'])){
			//var_dump($_POST['Login_ID']);
			//有嘗試登入就要先清掉session
			$this->load->library('session');		
			$this->session->unset_userdata('Login_ID');
			$this->session->unset_userdata('FullName');
			$this->session->unset_userdata('organization');
			$this->session->unset_userdata('department');
			$this->session->unset_userdata('User_Level');

			$Login_ID = $this->input->post('Login_ID');
			$Login_PW = $this->input->post('Login_PW');
			//推送給AD
			//假設回傳正確

			//
			$this->load->model('user_model');
			$query = $this->user_model->Login_PW_select($Login_ID, $Login_PW);
			if ($query->num_rows() == 1){				//若抓到相同使用者成功
				$Login_ID = $query->row()->user_id;
				$FullName = $query->row()->姓名;
				$organization = $query->row()->機關;
				$department = $query->row()->單位;
				$User_Level = $query->row()->系統等級;


				if($query->row()->帳號啟用 == 1){
					$code = 1;
					$msg = "登入成功";
				}
				else{
					$code = 0;
					$msg = "帳號處於停權中";
				}
				//$this->user_model->Login_PW_Update($Login_ID, $Login_PW, $this->input->ip_address(), time()) ;//更新登入活動資訊
				$this->session->set_userdata('Login_ID', $Login_ID);
				$this->session->set_userdata('FullName', $FullName);
				$this->session->set_userdata('organization', $organization);
				$this->session->set_userdata('department', $department);
				$this->session->set_userdata('User_Level', $User_Level);
				
				//$this->y5e6g2s7e9y2d3Active_log('登入成功');
				
				
			}
			else{
				$code = 0;
				$msg = "無此帳號";
			}
		}
		else{	//內部呼叫
			$code = 0;
			if ($this->session->has_userdata('Login_ID')) {
				$code = 1;
			}
		}


		$RE_array = array('Msg' => $msg , 'If_Pass' => $If_Pass, 'Code' => $code , 'Last_time' => $time_L);


		if ($type == "0"){
			echo json_encode($RE_array,JSON_NUMERIC_CHECK);
		}
		else{
			return $code;
		}





	}


	public function User_Logout(){						//承辦人登出
		//$this->y5e6g2s7e9y2d3Active_log('承辦人登出');
		$this->load->library('session');		
		$this->session->unset_userdata('Login_ID');
		$this->session->unset_userdata('FullName');
		$this->session->unset_userdata('organization');
		$this->session->unset_userdata('department');
		$this->session->unset_userdata('User_Level');
		header("Location: /"); /* Redirect browser */
		exit();
	}





}