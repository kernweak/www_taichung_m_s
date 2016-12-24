<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends MY_Controller {

	public function __construct() { 
        parent::__construct(); 
        $this->load->model('file_model');
		$this->load->model('member_model');
		$this->load->model('property_model');
		$this->load->model('income_model');
     } 

    public function Access_Print_Form($file_key = 0){				//檔案應用影像列印(檔案列印.功能 )
		
		//*********安全檢查*****	

		//**********************
	
		$this->load->library('session');
		$User_Login = $this->User_Login("1");
		//echo $User_Login;
		if($User_Login == 1){
			$Login_ID = $this->session->userdata('Login_ID');
			$FullName = $this->session->userdata('FullName');
			$organization = $this->session->userdata('organization');
			$department = $this->session->userdata('department');
			$User_Level = $this->session->userdata('User_Level');

			$file_key = (int)$file_key;
			//$file_key = $this->input->post('file_key');	


			//$members = $this->member_model->get_members_for_file($file_key);		
			$files = $this->file_model->read_file($file_key);
			$file_info = $files[0];

			// $data = array(
			// 	'file_info' => $files[0],
			// 	'members' => $members
			// );
			//log_message('debug', 'get_members_file return ='. print_r($data, true));
			//echo json_encode($data);

		}
		else{
			//$this->load->view('login');
		}
	
			
			
			
			//echo $FullName;
			//echo $Department;
		//var_dump($file_info);
		//$file_info->案件流水號
			
			$this->load->view('print_page_file_info', Array(
				'file_info' 		 => 	$file_info,
				'pageTitle' 		 => 	'檔案調閱列印',
				'Department' 		 => 	$department,
				'FullName' 			 => 	$FullName,	
				'water_mark_check'   => 	"TEST_WM",	
				'OrganizationName'   => 	$organization,
			));
			
	}
		
	
}