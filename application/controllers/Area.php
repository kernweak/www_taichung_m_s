<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area extends MY_Controller {

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

	public function get_town()		//檢查此役男是否存在
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

	public function get_town_by_county(){
		
	}

	public function get_village_by_town(){
		
	}




}
