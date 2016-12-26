<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');   
class  MY_Controller  extends  CI_Controller  {  

	public function User_Login($type = "0"){
		$this->load->library('session');
		$If_Pass = false ;
		
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
			$this->session_clear();
			$Login_ID = $this->input->post('Login_ID');
			$Login_PW = $this->input->post('Login_PW');
			//推送給AD
			//假設回傳正確

			//
			$this->load->model('user_model');
			$query = $this->user_model->Login_PW_select($Login_ID, $Login_PW);
			if ($query->num_rows() == 1){				//若抓到相同使用者成功
				if($query->row()->帳號啟用 == 1){
					$code = 1;
					$msg = "登入成功";
					$this->session_set($query);
				}
				else{
					$code = 0;
					$msg = "帳號處於停權中";
				}
				//$this->user_model->Login_PW_Update($Login_ID, $Login_PW, $this->input->ip_address(), time()) ;//更新登入活動資訊
				//$this->y5e6g2s7e9y2d3Active_log('登入成功');
			}
			else{
				$code = 0;
				$msg = "無此帳號或密碼錯誤";
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



	public function User_Logout($type="0"){						//承辦人登出
		//$this->y5e6g2s7e9y2d3Active_log('承辦人登出');
		$this->session_clear();
		if($type=="0"){
			header("Location: /"); /* Redirect browser */
			exit();
		}
	}

	public function IF_PW_Expired($in_date){	//$in_date = 某使用者上次修改密碼的日期
		$datetime1 	= new DateTime("now");
		$datetime2 	= date_create($in_date);
		$interval 	= date_diff($datetime1, $datetime2);
		$diffday 	= (int)$interval->format('%a');
		$Pw_Effective_Days = (int)$this->SC('Pw_Effective_Days');
		if($diffday > $Pw_Effective_Days){
			return 1;
		}else{
			return 0;
		}
		//過期傳回1，沒過期傳回0
	}

	public function SC($parameter)		//取出SERVER參數用
	{	
		//Auto_Logout_Time 20 自動登出的時間(分鐘)
		//Pw_Effective_Days  180  強制使用者在一定天數後，必須修改密碼。(單位:天數)
		//Pw_Faile_Cyle  2  使用者在一定時間內，密碼錯誤超過指定次數，即停權。此為時間限制(分鐘)
		//Pw_Faile_Frequency  3  使用者在一定時間內，密碼錯誤超過指定次數，即停權。此為錯誤次數限制(次數)
		//Attachment_Path  Z:\\ImgDataBase\\Prepare\\  附件檔儲存路徑(本機路徑)
		$this->load->model('server_model');
		$result = $this->server_model->get_Server_Config($parameter);
		return $result;
	}


	private function session_clear(){
		$this->load->library('session');		
		$this->session->unset_userdata('Login_ID');
		$this->session->unset_userdata('FullName');
		$this->session->unset_userdata('organization');
		$this->session->unset_userdata('department');
		$this->session->unset_userdata('User_Level');
		$this->session->unset_userdata('Last_time_CPW');
	}
	private function session_set($query){
		$this->load->library('session');
		$Login_ID = $query->row()->user_id;
		$FullName = $query->row()->姓名;
		$organization = $query->row()->機關;
		$department = $query->row()->單位;
		$User_Level = $query->row()->系統等級;
		$Last_time_CPW = $query->row()->上次修改密碼;
		$this->session->set_userdata('Login_ID', $Login_ID);
		$this->session->set_userdata('FullName', $FullName);
		$this->session->set_userdata('organization', $organization);
		$this->session->set_userdata('department', $department);
		$this->session->set_userdata('User_Level', $User_Level);
		$this->session->set_userdata('Last_time_CPW', $Last_time_CPW);
	}

	protected function log_activity($activity1="", $activity2="", $activity3=""){

		$this->load->library('session');
		$log['user_id'] = (string)$this->session->userdata('Login_ID'); //varchar 20
		$log['full_name'] = (string)$this->session->userdata('FullName'); //varchar 20
		
		$log['organization'] = $this->session->userdata('organization'); //varchar 20
		$log['department'] 	= $this->session->userdata('department'); //varchar 20

		$log['activity1']		= $activity1;
		$log['activity2']		= $activity2;
		$log['activity3']		= $activity3;

		$log['date_time'] 	= date('Y-m-d H:i:s', time());
		$log['ip'] 			= $this->input->ip_address();
		
		$this->load->model('activitylog_model');
		$this->activitylog_model->add($log);
	}
}