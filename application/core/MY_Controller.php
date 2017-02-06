<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');   
class  MY_Controller  extends  CI_Controller  {  

	public function User_Login($type = "0"){
		$this->load->library('session');
		$this->load->model('user_model');
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

			
			$query = $this->user_model->Login_PW_select($Login_ID, $Login_PW);
			if ($query->num_rows() == 1){				//若抓到相同使用者成功
				if($query->row()->帳號啟用 == 1){
					$code = 1;
					$msg = "登入成功";
					$this->session_set($query);
					$this->User_PW_Error_Write($Login_ID, 0, 1, "none");
				}
				else{
					$code = 0;
					$msg = "帳號處於停權中";
				}
				//$this->user_model->Login_PW_Update($Login_ID, $Login_PW, $this->input->ip_address(), time()) ;//更新登入活動資訊
				//$this->y5e6g2s7e9y2d3Active_log('登入成功');
			}
			else{

				//錯誤次數控管器
				$code = 0;
				$msg = "無此帳號或密碼錯誤";
				$UPEO = $this->User_PW_Error_Operate($Login_ID);
				if( $UPEO[0] == 1){
					$msg = $UPEO[1];
				}
			}
		}

		$RE_array = array('Msg' => $msg , 'Code' => $code);
		echo json_encode($RE_array,JSON_NUMERIC_CHECK);

	}


	/*
		登入時，
		若正確，錯誤次數歸零
			寫回資料庫(使用者帳號,錯誤次數,帳號有效,紀錄時間=0)
			
		若使用者存在，但密碼錯誤，
			
			(給使用者帳號) => 傳回(帳號是否存在，上次錯誤距離現在的時間，已經錯誤的次數)
			
			上次錯誤的時間距離現在有小於N秒嗎?
				有：
					錯誤次數 = 錯誤次數+1
					錯誤次數超過X次了嗎?
						有：	帳號有效 = 0
						沒有：  帳號有效 = 1
					
					寫回資料庫(使用者帳號,錯誤次數,帳號有效,紀錄時間=0)
				
				
				沒有：
					紀錄現在時間;錯誤次數 = 1
					寫回資料庫(使用者帳號,錯誤次數,帳號有效,紀錄時間=now)
					
		傳回(是否啟用錯誤次數偵測，$MSG=要給使用者的訊息)
	*/
	protected function User_PW_Error_Operate($Login_ID){
		$Fun_Enable = (int)$this->SC('Pw_Faile_Check');
		$Msg = "";

		if($Fun_Enable == 0){	//功能被關閉的話，直接回傳0
			return array(0,"");
		}
		$Error_r = $this->User_PW_Error_Read($Login_ID);
		
		if ($Error_r['rows'] > 1){				//若抓到超過一個使用者
			return array(1,"帳號發生重複性問題，請聯絡管理員解決");
		}
		if ($Error_r['rows'] == 0){				//若抓不到使用者
			return array(1,"無此帳號或密碼錯誤");
		}
		if ($Error_r['Acount_Enable'] == 0){				//若抓不到使用者
			return array(1,"此帳號已遭停用");
		}


		if ($Error_r['seconds'] <= (int)$this->SC('Pw_Faile_Cyle')){		//上次錯誤的時間距離現在有小於N秒嗎?
			$Errors = $Error_r['errors'] + 1;
			if ($Errors >= (int)$this->SC('Pw_Faile_Frequency')){
				$Acount_Enable = 0;
				$Msg = "已於時限內超過錯誤次數，帳號停權!";
			}
			else{
				$Acount_Enable = 1;
				$Msg = "時限內密碼錯誤第".$Errors."次";
			}

			$this->User_PW_Error_Write($Login_ID, $Errors, $Acount_Enable, "none");

		}else{
			$this->User_PW_Error_Write($Login_ID, 1, 1, "now");
			$Msg = "無此帳號或密碼錯誤";	//其實帳號是對的，但密碼錯誤
		}


		return array($Fun_Enable, $Msg);
		
	}

	/*
		(給使用者帳號) => 傳回(帳號是否存在，上次錯誤距離現在的時間，已經錯誤的次數)
	*/
	protected function User_PW_Error_Read($Login_ID){
		$this->load->model('user_model');
		$query = $this->user_model->User_PW_Error_Read($Login_ID);
		$datetime1 = strtotime($query->row()->上次輸錯密碼);
		$datetime2 = strtotime(date("Y-m-d H:i:s",time()));
		// var_dump($query->row()->上次輸錯密碼);
		// var_dump($datetime1);
		// var_dump($datetime2);
		$diffInSeconds = $datetime2 - $datetime1;
		return array('rows' => $query->num_rows(), 'seconds' => $diffInSeconds, 'errors' => $query->row()->累積錯誤次數, 'Acount_Enable' => $query->row()->帳號啟用);
	}

	/*
		寫回資料庫(使用者帳號,錯誤次數,帳號有效,紀錄時間=none/now)
	*/
	protected function User_PW_Error_Write($Login_ID, $Errors, $Acount_Enable = 1, $ErrTime = "none"){
		$this->load->model('user_model');

		if($ErrTime == "now"){
			$data = array(    		
	    		'累積錯誤次數' 	=> $Errors,
	    		'上次輸錯密碼' 	=> date("Y-m-d H:i:s",time()),
	    		'帳號啟用' 		=> $Acount_Enable
    		);
		}else{
			$data = array(    		
    			'累積錯誤次數' 	=> $Errors,
	    		'帳號啟用' 		=> $Acount_Enable
    		);
		}
		//var_dump($data);
		$result = $this->user_model->User_PW_Error_Write($Login_ID, $data);
	}





	protected function IF_User_Login(){
		$this->load->library('session');
		$code = 0;
		if ($this->session->has_userdata('Login_ID')) {
			$code = 1;
		}
		return $code;
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
		$this->session->unset_userdata('SSO');
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
		if($log['organization'] == NULL){
			$log['organization'] =	"";
		}
		$log['department'] 	= $this->session->userdata('department'); //varchar 20
		if($log['department'] == NULL){
			$log['department'] =	"";
		}

		$log['activity1']		= $activity1;
		$log['activity2']		= $activity2;
		$log['activity3']		= $activity3;

		$log['date_time'] 	= date('Y-m-d H:i:s', time());
		$log['ip'] 			= $this->input->ip_address();
		
		$this->load->model('activitylog_model');
		$this->activitylog_model->add($log);
	}
}