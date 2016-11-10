<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File extends MY_Controller {

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
	public function index()
	{
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
			));
		}
		else{
			$this->load->view('login');
		}

	}


	public function login()
	{
		$this->load->view('login');
	}

	public function check_boy_exist()		//檢查此役男是否存在
	{	
		$this->load->model('boy_model');
		//$ADF_name = $this->input->post('ADF_name');
		$ADF_code = $this->input->post('ADF_code');
		// $ADF_birthday = $this->input->post('ADF_birthday');
		// $ADF_milidate = $this->input->post('ADF_milidate');
		// $ADF_type = $this->input->post('ADF_type');
		// $ADF_status = $this->input->post('ADF_status');
		 $query = $this->boy_model->read_row_by_code($ADF_code);
		 	if ($query->num_rows() == 1){				//若抓到相同使用者成功
				echo json_encode("已存在");
			}
			else{
			    echo json_encode("不存在");
			}
	}
}
