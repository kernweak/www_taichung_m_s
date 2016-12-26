<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {
	public function __construct() { 
        parent::__construct(); 
    }
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	//public function index()
	//{
	//	$this->load->view('welcome_message');
	//}
	public function index(){
		$this->load->library('session');
		$User_Login = $this->IF_User_Login();
		//echo $User_Login;
		if($User_Login == 1){
			$Login_ID = $this->session->userdata('Login_ID');
			$FullName = $this->session->userdata('FullName');
			$organization = $this->session->userdata('organization');
			$department = $this->session->userdata('department');
			$User_Level = $this->session->userdata('User_Level');
			$Last_time_CPW = $this->session->userdata('Last_time_CPW');
			$Auto_Logout_Time = $this->SC('Auto_Logout_Time');

			$this->load->view('TEST', Array(
				'FullName' 		=> 	$FullName,
				'organization' 		=> 	$organization,
				'User_Level' 		=> 	$User_Level,
				'Auto_Logout_Time' 	=> 	$Auto_Logout_Time,
			));

			if($this->IF_PW_Expired($Last_time_CPW)){
				$this->load->view('Javascript_command/PW_Effective_Days');    //若密碼過期，就執行這段
			}else{
				$this->load->view('Javascript_command/Normal');
			}





			
			
			$this->load->view('TEST_footer');
		}
		else{
			$this->load->view('login');
		}

	}


	public function login()
	{
		$this->load->view('login');
	}

	public function session_show()		//記得刪除
	{	
		$this->load->library('session');
		var_dump($this->session);
	}




	public function sso_2test(){					//首頁
		if(!isset($_SESSION)) 
		{ 
			session_start(); 
		} 
		/*echo php_uname('v')."<br>";
		echo substr(php_uname('v'),(stripos(php_uname('v'),'build ') + 6),(4));
		echo php_uname('v')."<br>";
		*/
		//範例1: 驗証使用者帳號與密碼是否正確，若正確則回傳該使用者姓名。 
		//註:請將主機名稱入口網網址替換成實際主機名稱 
		
		$client = new SoapClient("http://eip.taichung.gov.tw/ldapService.do?wsdl");

		//$handle1 = $client->authUser(array("in0" => "tccght5026","in1"=>"r123456789"));
		
		//$handle2 = $client->getAttr(array("in0" => "tccght5026","in1"=>"r123456789","in2"=>"department"));
		$handle2 = $client->getAttr(array("in0" => "f58213","in1"=>"Qq791029801224","in2"=>"displayName"));

		echo ((int)($handle2->out))."<br>";

		echo $handle2->out."<br>";
		
		var_dump($handle2->out);
		
		//範例2：驗証sessionId是否有效,若sessionId有效時，則回傳使用者帳號,其它情況回傳空字串
		//註:請將主機名稱入口網網址與sessionId替換成實際主機名稱與使用者的sessionId值
		/*
		$client = new SoapClient("http://eip.taichung.gov.tw/ldapService.do?wsdl");
		$handle1 = $client->verifySessionId(array("in0" => "tccght5026"));
		echo "<br>";
		echo $handle1->out;
		echo "<br>";
		var_dump($handle1);
		echo "<br>";
		var_dump($handle1->out);
		*/
	}
	public function sso(){					//首頁
		$this->load->library('session');
		if(!isset($_SESSION)) 
		{ 
			session_start(); 
		} 
		$sessionId = $this->input->post('sessionId');
		//var_dump($sessionId);
		$client = new SoapClient("http://eip.taichung.gov.tw/ldapService.do?wsdl");
		$handle1 = $client->verifySessionId(array("in0" => $sessionId));
		//$handle2 = $client->getAttr(array("in0" => "f58213","in1"=>"Qq791029801224","in2"=>"displayName"));
		//echo $handle1->out."<br>";
		//var_dump($handle1->out);
		$handle2 = $client->verifySessionIdReturnAttr(array("in0" => $sessionId,"in1"=>"displayName"));
		//var_dump($handle2->out);
		
		$id = $handle1->out;
		$name = $handle2->out;
		if($id != ""){
			$User_Login = $this->sso_login($id, $name, "1");
		}else{
			$this->load->view('login');
		}
		
		
		//echo $User_Login;
		if($User_Login == 1){
			$Login_ID = $this->session->userdata('Login_ID');
			$FullName = $this->session->userdata('FullName');
			$organization = $this->session->userdata('organization');
			$department = $this->session->userdata('department');
			$User_Level = $this->session->userdata('User_Level');
			$this->load->view('TEST', Array(
				'FullName' 		=> 	$FullName,
				'organization' 		=> 	$organization,
				'User_Level' 		=> 	$User_Level,
			));
		}
		else{
			$this->load->view('login');
		}
		
	}
	private function sso_login($id, $name, $type = "0"){
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
		if($id != "" && $id != NULL){
			//var_dump($_POST['Login_ID']);
			//有嘗試登入就要先清掉session
			$this->load->library('session');		
			$this->session->unset_userdata('Login_ID');
			$this->session->unset_userdata('FullName');
			$this->session->unset_userdata('organization');
			$this->session->unset_userdata('department');
			$this->session->unset_userdata('User_Level');

			$Login_ID = $id;
			$Login_NM = $name;
			//推送給AD
			//假設回傳正確

			//
			$this->load->model('user_model');
			$query = $this->user_model->Login_IDNM_select($Login_ID, $Login_NM);
			if ($query->num_rows() == 1){				//若抓到相同使用者成功
				$Login_ID = $query->row()->User_account;
				$FullName = $query->row()->User_name;
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

	public function User_changePW($type = "0"){
		$If_Pass = false ;
		$this->load->library('session');
		$time_L = 0	;
		$code = 0	;	//0:未登入/1:已登入
		$User_Login = $this->IF_User_Login();
		$msg="";
		//var_dump("接收到".$User_Login);
		
		if($User_Login == 1){
			$Login_ID = $this->session->userdata('Login_ID');
			$FullName = $this->session->userdata('FullName');
			$organization = $this->session->userdata('organization');
			$department = $this->session->userdata('department');
			$User_Level = $this->session->userdata('User_Level');
			

			$Login_PW0 = $this->input->post('Login_PW0');
			$Login_PW1 = $this->input->post('Login_PW1');
			$Login_PW2 = $this->input->post('Login_PW2');
			// var_dump($Login_ID);
			// var_dump($FullName);
			// var_dump($Login_PW0);
			// var_dump($Login_PW1);

			$this->load->model('user_model');
			//$query = $this->user_model->User_changePW($Login_PW0, $Login_PW1, $Login_PW2);
			$query = $this->user_model->User_checkPW($Login_ID, $FullName, $Login_PW0);
			if ($query->num_rows() == 1){				//若抓到相同使用者成功
				if($query->row()->帳號啟用 == 1){
					$query2 = $this->user_model->User_updatePW($Login_ID, $FullName, $Login_PW0, $Login_PW1);
					if($query2->num_rows() == 1){
						$code = 1;
						$msg = "密碼修改成功，請以新密碼重新登入";
						$this->User_Logout("1");
					}
				}
				else{
					$code = 0;
					$msg = "帳號處於停權中，你將被強制登出";
					$this->User_Logout("1");
				}			
			}
			else{
				$code = 0;
				$msg = "無此帳號或密碼錯誤，你將被強制登出";
				$this->User_Logout("1");
			}
		}
		else{
			//未登入，無權限修改密碼
			$code = 0;
			if ($this->session->has_userdata('Login_ID')) {
				$code = 1;
			}
		}


		$RE_array = array('Msg' => $msg , 'If_Pass' => $If_Pass, 'Code' => $code , 'Last_time' => $time_L);
		//var_dump($RE_array);
		
		if ($type == "0"){
			echo json_encode($RE_array,JSON_NUMERIC_CHECK);
		}
		else{
			return $code;
		}
		
	}
}
