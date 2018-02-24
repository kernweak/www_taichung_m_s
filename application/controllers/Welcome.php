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
		
		if($this->SC('TEST_MOD') == true){
			$this->session->set_userdata('Login_ID', "God");
			$this->session->set_userdata('FullName', "工程模式");
			$this->session->set_userdata('organization', "標竿數位文化工作室");
			$this->session->set_userdata('department', "工程部");
			$this->session->set_userdata('User_Level', 7);
			$this->session->set_userdata('Last_time_CPW', date('Y-m-d H:i:s', time()));
			$this->output->set_header('Cache-Control: max-age=2592000');	//快取儲存一個月
			$this->load->view('TEST', Array(
				'FullName' 			=> 	$this->session->userdata('FullName'),
				'organization' 		=> 	$this->session->userdata('organization'),
				'User_Level' 		=> 	$this->session->userdata('User_Level'),
				'BatchPro'			=>	$this->SC('BatchPro'),
				'Auto_Logout_Time' 	=> 	120,
			));

			$this->load->view('Javascript_command/Normal');
			//$this->output->enable_profiler(TRUE);
			$this->load->view('TEST_footer');
			
			return;
		}

		if($User_Login == 1){
			$this->load->helper('url');
			$this->load->library('user_agent');
			$Browser = $this->agent->browser();
			$Login_ID = $this->session->userdata('Login_ID');
			$FullName = $this->session->userdata('FullName');
			$organization = $this->session->userdata('organization');
			$department = $this->session->userdata('department');
			$User_Level = $this->session->userdata('User_Level');
			$Last_time_CPW = $this->session->userdata('Last_time_CPW');
			$Auto_Logout_Time = $this->SC('Auto_Logout_Time');
			$this->output->set_header('Cache-Control: max-age=2592000');	//快取儲存一個月
			$this->load->view('TEST', Array(
				'FullName' 			=> 	$FullName,
				'organization' 		=> 	$organization,
				'User_Level' 		=> 	$User_Level,
				'Auto_Logout_Time' 	=> 	$Auto_Logout_Time,
				'SSO' 				=> 	$this->session->userdata('SSO'),
				'BatchPro'			=>	$this->SC('BatchPro'),
				'Browser' 			=> 	$Browser,
			));

			if($this->IF_PW_Expired($Last_time_CPW)){
				$this->load->view('Javascript_command/PW_Effective_Days');    //若密碼過期，就執行這段
			}else{
				$this->load->view('Javascript_command/Normal');
			}
			$this->load->view('TEST_footer');
		}
		else{
			$this->load->view('login2');
			//$_SERVER['HTTP_USER_AGENT'];
			//$browser = get_browser(null,true);
			//var_dump($browser['browser']);
		}

	}

	public function IE()
	{
		$this->load->view('ie');
	}
	public function login()
	{
		$this->load->view('login2');
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
		// $handle1 = $client->authUser(array("in0" => "pinina","in1"=>"@WSXcde31024"));
		// $handle2 = $client->getAttr(array("in0" => "pinina","in1"=>"@WSXcde31024","in2"=>"displayName"));
		// $handle3 = $client->getAttr(array("in0" => "pinina","in1"=>"@WSXcde31024","in2"=>"department"));
		$handle1 = $client->authUser(array("in0" => "jck11","in1"=>"Ab1234567890"));
		$handle2 = $client->getAttr(array("in0" => "jck11","in1"=>"Ab1234567890","in2"=>"displayName"));
		$handle3 = $client->getAttr(array("in0" => "jck11","in1"=>"Ab1234567890","in2"=>"department"));

		echo ((int)($handle1->out))."<br>";

		echo $handle2->out."<br>";
		echo $handle3->out."<br>";
		
		//var_dump($handle2->out);
		
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
		$client = new SoapClient("http://eip.taichung.gov.tw/ldapService.do?wsdl");
		
		$handle1 = $client->verifySessionId(array("in0" => $sessionId));
		$handle2 = $client->verifySessionIdReturnAttr(array("in0" => $sessionId,"in1"=>"displayName"));
		$handle3 = $client->verifySessionIdReturnAttr(array("in0" => $sessionId,"in1"=>"ou"));
		$handle4 = $client->verifySessionIdReturnAttr(array("in0" => $sessionId,"in1"=>"title"));
		
		$id 	= $handle1->out;
		$name 	= $handle2->out;
		$ou 	= $handle3->out;
		$title 	= $handle4->out;

		$this->log_activity($activity1="SSO連線檢查", $activity2="id=".$id."; "."name=".$name."; "."ou=".$ou."; "."title=".$title.";", $activity3="");
		
		if($id != ""){
			$User_Login = $this->sso_login($id, $name, $ou, $title, "1");
		}else{
			$this->load->view('login2');
		}
		
		
		//echo $User_Login;
		if($User_Login == 1){
			$Login_ID = $this->session->userdata('Login_ID');
			$FullName = $this->session->userdata('FullName');
			$organization = $this->session->userdata('organization');
			$department = $this->session->userdata('department');
			$User_Level = $this->session->userdata('User_Level');
			/*$this->load->view('TEST', Array(
				'FullName' 		=> 	$FullName,
				'organization' 		=> 	$organization,
				'User_Level' 		=> 	$User_Level,
			));*/
			header("Location: /"); /* Redirect browser */
			exit();
		}
		else{
			$this->load->view('login2');
		}
		
	}
	/*
	public function sso_tt(){	//測試Find_Organ_by_OU
		//id=pinina; name=李若萌; ou=020014; title=科員;
		$ou="020015";
		$this->load->model('user_model');
		$OU = $this->user_model->Find_Organ_by_OU($ou);
		var_dump($OU);
	}
	*/
	private function sso_login($id, $name, $ou, $title, $type = "0"){
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
			$this->session->unset_userdata('Edit_Town');
			$this->session->unset_userdata('Edit_County');
			$this->session->unset_userdata('SSO');

			$Login_ID = $id;
			$Login_NM = $name;
			//推送給AD
			//假設回傳正確

			//
			$this->load->model('user_model');
			$OU = $this->user_model->Check_Dept_OU_ext($ou);
			if($OU->OU_DeptCode){
				// $ou->Town_name,
				// $ou->OU_DeptName,
				// $ou->OU_DeptCode,
				// $ou->OU_OrganName,
				// $ou->OU_OrganCode,
				$system_level = 1;
				if($OU->Organ_Level == 1){
					switch ($title) {
					    case '課長':
					        $system_level = 2;
					        break;
					    case '主任秘書':
					        $system_level = 3;
					        break;
					    case '秘書':
					        $system_level = 3;
					        break;
					    case '副區長':
					        $system_level = 3;
					        break;
					    default:
       						$system_level = 1;
					}
				}
				elseif($OU->Organ_Level == 2){
					switch ($title) {
					    case '科長':
					        $system_level = 5;
					        break;
					    case '主任秘書':
					        $system_level = 6;
					        break;
					    case '秘書':
					        $system_level = 6;
					        break;
					    case '副局長':
					        $system_level = 6;
					        break;
					    default:
       						$system_level = 4;
					}
				}

				$Insert_Val = array(
					'User_account'		=> (string)$id,
					'User_name'			=> (string)$name,
					'機關'				=> (string)$OU->Town_name,
					'單位'				=> (string)$OU->OU_DeptName,
					'系統等級'			=> (int)$system_level,
					'帳號啟用'			=> 1,
					'User_OU_code'		=> (string)$OU->OU_DeptCode,
					'User_OU_Title'		=> (string)$title,
					'User_login_time'	=> (string)date('Y-m-d H:i:s', time()),
					'IP'				=> $this->input->ip_address()
				);
					
				$Update_Val = array(						
					'機關'				=> (string)$OU->Town_name,
					'單位'				=> (string)$OU->OU_DeptName,
					'User_OU_code'		=> (string)$OU->OU_DeptCode,
					'User_OU_Title'		=> (string)$title,
					'User_login_time'	=> (string)date('Y-m-d H:i:s', time()),
					'IP'				=> $this->input->ip_address()
				);

				if($system_level == 1){
					$Insert_Val["Edit_Town"]=1;
					$Update_Val["Edit_Town"]=1;
				}elseif($system_level == 4){
					$Insert_Val["Edit_County"]=1;
					$Update_Val["Edit_County"]=1;
				}
				
				$this->user_model->Insert_Update_ON_DUPLICATE("user_oss", $Insert_Val, $Update_Val);
			}else{
				//$id, $name, $ou, $title
				$OU = $this->user_model->Find_Organ_by_OU($ou);
				if($OU->OU_OrganCode){
					//$OU->Town_name
					$Insert_Val = array(
						'User_account'		=> (string)$id,
						'User_name'			=> (string)$name,
						'機關'				=> (string)$OU->Town_name,
						'系統等級'			=> 0,
						'帳號啟用'			=> 1,
						'User_OU_code'		=> (string)$ou,
						'User_OU_Title'		=> (string)$title,
						'User_login_time'	=> (string)date('Y-m-d H:i:s', time()),
						'IP'				=> $this->input->ip_address()
					);
						
					$Update_Val = array(						
						'機關'				=> (string)$OU->Town_name,
						'User_OU_code'		=> (string)$ou,
						'User_OU_Title'		=> (string)$title,
						'User_login_time'	=> (string)date('Y-m-d H:i:s', time()),
						'IP'				=> $this->input->ip_address()
					);
					$this->user_model->Insert_Update_ON_DUPLICATE("user_oss", $Insert_Val, $Update_Val);
				}
				
				
			}


			$query = $this->user_model->Login_IDNM_select($Login_ID, $Login_NM);
			if ($query->num_rows() == 1){				//若抓到相同使用者成功
				$Login_ID = $query->row()->User_account;
				$FullName = $query->row()->User_name;
				$organization = $query->row()->機關;
				$department = $query->row()->單位;
				$User_Level = $query->row()->系統等級;
				$Edit_Town = $query->row()->Edit_Town;
				$Edit_County = $query->row()->Edit_County;
				
				$this->log_activity($activity1="試圖SSO登入", $activity2="已看到存在應用系統", $activity3="");


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
				$this->session->set_userdata('Edit_Town', $Edit_Town);
				$this->session->set_userdata('Edit_County', $Edit_County);
				$this->session->set_userdata('SSO', 1);
				
				$this->log_activity($activity1="SSO成功登入", $activity2="已看到存在應用系統", $activity3="");
				
				
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