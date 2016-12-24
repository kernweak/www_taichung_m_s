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

     public function Access_Print_Form(){				//檔案應用影像列印(檔案列印.功能 )
		
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
			$this->load->view('TEST', Array(
				'FullName' 		=> 	$FullName,
				'organization' 		=> 	$organization,
				'User_Level' 		=> 	$User_Level,
			));
		}
		else{
			//$this->load->view('login');
		}
	
			
			
			
			//echo $FullName;
			//echo $Department;
			
			$this->load->view('print_page_file_info', Array(
				'pageTitle' => '檔案調閱列印',
				'Department' 		 => 	$department,
				'FullName' 			 => 	$FullName,	
				'water_mark_check'   => 	"TEST_WM",	
				'OrganizationName'   => 	$organization,
			));
			
		}
		
	}
}