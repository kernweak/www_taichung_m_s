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

	/*
	* create a new military boy record, and initialize his subsidy file
	*/
	public function add_new_boy_file(){
		// create a new boy record
		$this->load->model('boy_model');
		$name = $this->input->post('ADF_name');
		$id = $this->input->post('ADF_code');
		$birthday = $this->input->post('ADF_birthday');
		$begin_date = $this->input->post('ADF_milidate');
		$type = $this->input->post('ADF_type');
		$status = $this->input->post('ADF_status');
		
		$boy_key = $this->boy_model->add_new_boy($name, $id, $birthday, $begin_date, $type, $status);

		// create a new file record for this boy
		$this->load->model('file_model');
		$county = $this->input->post('ADF_county');
		$town = $this->input->post('ADF_town');
		$village = $this->input->post('ADF_village');
		$address = $this->input->post('ADF_address');
		$today = date("Y-m-d H:i:s");
		log_message('debug', print_r($today, true));

		$file_key = $this->file_model->add_new_file($today, $boy_key, $county, $town, $village, $address);
		
		$this->boy_model->update_new_boy_file_link($boy_key, $file_key);
		$data= array(
			'boy_key' => $boy_key,
			'file_key' => $file_key,
			'Msg' => "success"
			);

		echo json_encode($data);
	}

	public function read_new_file(){
		$file_key = (int)$this->input->post('file_key');
		$this->load->model('file_model');
		$file_info = $this->file_model->read_file($file_key);
		//var_dump($file_key);
		//var_dump($file_info);
		echo json_encode($file_info[0]);
	}
}
