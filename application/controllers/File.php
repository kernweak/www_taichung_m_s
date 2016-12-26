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
	public function __construct() { 
        parent::__construct(); 
        $this->load->model('file_model');
		$this->load->model('member_model');
		$this->load->model('property_model');
		$this->load->model('income_model');
    } 

	public function index()
	{
		$this->load->library('session');
		$User_Login = $this->IF_User_Login();
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
		$ADF_code = $this->input->post('ADF_code');		
		$query = $this->boy_model->read_row_by_code($ADF_code);
		 	if ($query->num_rows() >= 1){				//若抓到相同使用者成功
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
		$this->load->library('session');
		//var_dump($this->session);
		$FullName = $this->session->FullName;
 		$organization  = $this->session->organization;
      	$department  = $this->session->department;



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

		$file_key = $this->file_model->add_new_file($today, $boy_key, $county, $town, $village, $address, $FullName, $organization, $department);
		
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

	//列出此承辦人待處理之案件
	public function read_file_list_pending(){	
		$this->load->library('session');
		//var_dump($this->session);
		$user_level = $this->session->User_Level;
		$user_organ = $this->session->organization;
		$this->load->model('file_model');
		$file_list = $this->file_model->read_file_list_pending($user_level, $user_organ);
		//var_dump($file_list);
		echo json_encode($file_list);
		//承辦人 LV 1 看自己區的編輯中(1)案件ㄝ, 民眾線上申請(2)的案件
		//科長LV2、主秘LV 3 ，可看到編輯完，跑流程中的案件
		//民政局承辦 LV4 科長 LV5 ，可看到編輯完，跑流程中的案件
		//LV 7 工程模式，全部狀態都能看到
	}

	public function read_file_list_progress(){	
		$this->load->library('session');
		//var_dump($this->session);
		$user_level = $this->session->User_Level;
		$user_organ = $this->session->organization;
		$this->load->model('file_model');
		$file_list = $this->file_model->read_file_list_progress($user_level, $user_organ);
		//var_dump($file_list);
		echo json_encode($file_list);
		//承辦人 LV 1 看自己區的編輯中(1)案件ㄝ, 民眾線上申請(2)的案件
		//科長LV2、主秘LV 3 ，可看到編輯完，跑流程中的案件
		//民政局承辦 LV4 科長 LV5 ，可看到編輯完，跑流程中的案件
		//LV 7 工程模式，全部狀態都能看到
	}

	

	public function read_file_progerss_log(){	
		$this->load->library('session');
		$file_key = (int)$this->input->post('file_key');
		$user_level = $this->session->User_Level;
		$user_organ = $this->session->organization;
		$this->load->model('file_model');
		$file_list = $this->file_model->read_file_progerss_log($user_level, $user_organ, $file_key);
		//var_dump($file_list);
		echo json_encode($file_list);
		//承辦人 LV 1 看自己區的編輯中(1)案件ㄝ, 民眾線上申請(2)的案件
		//科長LV2、主秘LV 3 ，可看到編輯完，跑流程中的案件
		//民政局承辦 LV4 科長 LV5 ，可看到編輯完，跑流程中的案件
		//LV 7 工程模式，全部狀態都能看到
	}





	

	//列出此公所已通過補助，役男尚未退役的之案件
	public function read_file_list_supporting(){
		$this->load->library('session');
		//var_dump($this->session);
		$user_level = $this->session->User_Level;
		$user_organ = $this->session->organization;
		$this->load->model('file_model');
		$file_list = $this->file_model->read_file_list_supporting($user_level, $user_organ);
		//var_dump($file_list);
		echo json_encode($file_list);
		//承辦人 LV 1 看自己區的編輯中(1)案件ㄝ, 民眾線上申請(2)的案件
		//科長LV2、主秘LV 3 ，可看到編輯完，跑流程中的案件
		//民政局承辦 LV4 科長 LV5 ，可看到編輯完，跑流程中的案件
		//LV 7 工程模式，全部狀態都能看到
	}

	//新增複查檔案 + 退役處理
	public function rebuildfile(){
		$file_key = (int)$this->input->post('file_key');
		$act = $this->input->post('act');
		$log_comment = $this->input->post('log_comment');

		switch ($act) {
		    case "複查":
		        $act2 = 2;
		        break;
		    case "春節複查":
		        $act2 = 3;
		        break;
		    case "端午複查":
		        $act2 = 4;
		        break;
		    case "中秋複查":
		        $act2 = 5;
		        break;
		}
		var_dump($act2);
		$new_file_key = $this->file_model->clone_file_info($file_key, $act2);

		//$file_info = $this->file_model->progress_file($file_key,"+");

		$this->progress_log($new_file_key, $log_comment, "新增複查案", 1);
		echo json_encode("Success");
	}

	public function progress_next(){
		$file_key = (int)$this->input->post('file_key');
		$log_comment = $this->input->post('log_comment');
		$this->load->model('file_model');
		$file_info = $this->file_model->progress_file($file_key,"+");
		$this->progress_log($file_key, $log_comment, "向上呈核",$file_info);
		echo json_encode("Success");
	}

	public function progress_patch(){
		$file_key = (int)$this->input->post('file_key');
		$log_comment = $this->input->post('log_comment');
		$this->load->model('file_model');
		$file_info = $this->file_model->progress_file($file_key,"p");
		$this->progress_log($file_key, $log_comment, "要求補件",$file_info);
		echo json_encode("Success");
	}

	public function progress_patch_re(){
		$file_key = (int)$this->input->post('file_key');
		$log_comment = $this->input->post('log_comment');
		$this->load->model('file_model');
		$file_info = $this->file_model->progress_file($file_key,"r");
		$this->progress_log($file_key, $log_comment, "補件重送",$file_info);
		echo json_encode("Success");
	}
	


	public function progress_back(){
		$file_key = (int)$this->input->post('file_key');
		$log_comment = $this->input->post('log_comment');
		$this->load->model('file_model');
		$file_info = $this->file_model->progress_file($file_key,"1");
		$this->progress_log($file_key, $log_comment, "退回承辦",$file_info);
		echo json_encode("Success");
	}

	public function progress_log($file_key, $log_comment, $progress_name, $progress_level){
		$this->load->model('file_model');
		$this->load->library('session');
		$Login_ID = $this->session->userdata('Login_ID');
		$FullName = $this->session->userdata('FullName');
		$organization = $this->session->userdata('organization');
		$department = $this->session->userdata('department');
		$User_Level = $this->session->userdata('User_Level');
		$datetime = date ("Y-m-d H:i:s"); 




		$this->file_model->progress_log($file_key,$log_comment, $progress_name, $progress_level,$organization,$department,$FullName,$User_Level,$datetime);
		//echo json_encode("Success");
	}

// miliboy_table.入伍日期// <th style="width: 8em;">入伍日期</th>
// area_town.Town_name//   	<th style="width: 7em;">行政區</th>
// miliboy_table.役男姓名 //   	<th style="width: 7em;">役男姓名</th>
// miliboy_table.身分證字號//   	<th style="width: 7.5em;">役男證號</th>
// files_info_table.審批階段//   	<th style="width: 12em;">案件進度</th>
// files_info_table.扶助級別//   	<th style="width: 8em;">審查結果</th>
// files_info_table.建案日期//   	<th style="width: 7em;">立案日期</th>
// files_info_table.修改人姓名//   	<th style="width: 7em;">主要承辦人</th>
// files_info_table.案件流水號//    案件流水號
// files_info_table.可否編修//   	可否編輯	--可編輯者要多個編輯按鈕--   檢視-編輯-同意&呈核
// files_status_code.案件階段名稱//   	作業類別

// 案件流水號
// 案件流程名稱
// 日期時間
// 動作者單位
// 動作者
// 動作名稱
// 動作者職級
// 動作後案件流程層級
// 動作者意見

}
