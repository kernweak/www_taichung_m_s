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
		$this->load->model('area_model');
    } 

	public function check_boy_exist(){		//檢查此役男是否存在		
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

	public function read_boy_file_by_id(){		//		
		$this->load->model('boy_model');		
		$boyid = $this->input->post('boyid');		
		$query = $this->boy_model->read_boy_file_by_id($boyid);
		echo json_encode($query);
		 // 	if ($query->num_rows() >= 1){				//若抓到相同使用者成功
			// 	echo json_encode("已存在");
			// }
			// else{
			//     echo json_encode("不存在");
			// }
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
		$echelon = $this->input->post('ADF_echelon');
		$phone = $this->input->post('ADF_phone');
		$email = $this->input->post('ADF_email');
		
		$boy_key = $this->boy_model->add_new_boy($name, $id, $birthday, $begin_date, $type, $status, $echelon);
		$this->log_activity('added a boy', 'boy_key='.$boy_key);

		// create a new file record for this boy		
		$county = $this->input->post('ADF_county');
		$town = $this->input->post('ADF_town');
		$village = $this->input->post('ADF_village');
		$address = $this->input->post('ADF_address');
		$today = date("Y-m-d H:i:s");
		log_message('debug', print_r($today, true));

		$file_key = $this->file_model->add_new_file($today, $boy_key, $county, $town, $village, $address, $FullName, $organization, $department, $phone, $email);

		$this->log_activity('added a file', 'file_key='.$file_key);

		$this->boy_model->update_new_boy_file_link($boy_key, $file_key);
		
		$this->add_member_newboy($file_key,$name,$id,$birthday,$address,$county,$town,$village);

		$data= array(
			'boy_key' => $boy_key,
			'file_key' => $file_key,
			'Msg' => "success"
			);

		echo json_encode($data);
	}


	private function get_members_num_for_file($file_key){
		$members = $this->member_model->get_members_for_file($file_key);
		return sizeof($members);
	}

	public function recive_new_boy_file(){
		$this->load->library('session');
		$file_key = $this->input->post('file_key');
		$files = $this->file_model->read_file($file_key);
		$file_info = $files[0];
		//var_dump($file_info);
		//var_dump($file_info->身分證字號);

		//新增判斷，若家屬含役男之成員數為0，表示全新收到的案件，就可以增加役男本人，否則就是移轉案件，不應該再增加役男一次
		if($this->get_members_num_for_file($file_key)==0){
			//增加家屬-役男本人
			$this->add_member_newboy($file_key,$file_info->役男姓名,$file_info->身分證字號,$file_info->役男生日,$file_info->戶籍地址,$file_info->county,$file_info->town,$file_info->village);
		}
		

		//案件階段向上提升到承辦人
		$file_info = $this->file_model->progress_file($file_key,"+");

		//紀錄
		$this->progress_log($file_key, "", "接收民眾案件",$file_info);
		$this->log_activity("接收民眾案件", "file_key=$file_key");

		//更新承辦人資訊-誰接收的就由誰主承辦
		$FullName = $this->session->userdata('FullName');
		$organization = $this->session->userdata('organization');
		$department = $this->session->userdata('department');
		$this->file_model->recive_file_update_editor($file_key,$FullName,$department,$organization);
		echo json_encode("Success");
	}

	private function add_member_newboy($file_key,$name,$id,$birthday,$address,$county,$town,$village){
		$address = $this->area_model->address_by_code($county,$town,$village).$address;
		$person = new stdClass();
    	$person->title = '役男';
    	$person->name = $name;
    	$person->code = $id;
    	$person->birthday = $birthday;
    	$person->address = $address;
    	$person->job = "";
    	$person->special = "1,1";
    	$person->marriage = "";
    	$person->marriage_ex = "";
    	$person->area = "臺中市";
    	$person->area_key = "3";
    	$person->comm = '';
    	$member_key = $this->member_model->add($person, $file_key);
	}

	public function read_new_file(){
		$file_key = (int)$this->input->post('file_key');		
		$file_info = $this->file_model->read_file($file_key);
		$this->log_activity('read a file', 'file_key='.$file_key);

		echo json_encode($file_info[0]);
	}

	//列出此承辦人待處理之案件
	public function read_file_list_pending(){	
		$this->load->library('session');
		//var_dump($this->session);
		$user_level = $this->session->User_Level;
		$user_organ = $this->session->organization;		
		$file_list = $this->file_model->read_file_list_pending($user_level, $user_organ);
		$this->log_activity('list pending files');
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
		$file_list = $this->file_model->read_file_list_progress($user_level, $user_organ);
		$this->log_activity('list files in progress');		
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
		$file_list = $this->file_model->read_file_progerss_log($user_level, $user_organ, $file_key);
		$this->log_activity('read a file progress log', 'file_key='.$file_key);
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
		$file_list = $this->file_model->read_file_list_supporting($user_level, $user_organ);
		$this->log_activity('list files in supporting');
		echo json_encode($file_list);
		//承辦人 LV 1 看自己區的編輯中(1)案件ㄝ, 民眾線上申請(2)的案件
		//科長LV2、主秘LV 3 ，可看到編輯完，跑流程中的案件
		//民政局承辦 LV4 科長 LV5 ，可看到編輯完，跑流程中的案件
		//LV 7 工程模式，全部狀態都能看到
	}

	public function read_file_list_fail(){
		$this->load->library('session');
		//var_dump($this->session);
		$user_level = $this->session->User_Level;
		$user_organ = $this->session->organization;
		$file_list = $this->file_model->read_file_list_fail($user_level, $user_organ);
		$this->log_activity('list files in supporting');
		echo json_encode($file_list);
		//承辦人 LV 1 看自己區的編輯中(1)案件ㄝ, 民眾線上申請(2)的案件
		//科長LV2、主秘LV 3 ，可看到編輯完，跑流程中的案件
		//民政局承辦 LV4 科長 LV5 ，可看到編輯完，跑流程中的案件
		//LV 7 工程模式，全部狀態都能看到
	}

	public function read_file_list_delete(){
		$this->load->library('session');
		//var_dump($this->session);
		$user_level = $this->session->User_Level;
		$user_organ = $this->session->organization;
		$file_list = $this->file_model->read_file_list_delete($user_level, $user_organ);
		$this->log_activity('list files in supporting');
		echo json_encode($file_list);
		//承辦人 LV 1 看自己區的編輯中(1)案件ㄝ, 民眾線上申請(2)的案件
		//科長LV2、主秘LV 3 ，可看到編輯完，跑流程中的案件
		//民政局承辦 LV4 科長 LV5 ，可看到編輯完，跑流程中的案件
		//LV 7 工程模式，全部狀態都能看到
	}


	//新增複查檔案 + 退役處理
	private function Retired($file_key){
		$file_info = $this->file_model->read_file($file_key);
		//var_dump($file_info[0]->役男系統編號);
		$boy_key = $file_info[0]->役男系統編號;
		$this->load->model('boy_model');
		$this->boy_model->change_mili_status($boy_key, "已退役");
		$this->log_activity("役男設為退役", "boy_key=$boy_key" ,"filekey=$file_key");

	}

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
		    case "退役":
		        $act2 = 6;
		        $this->Retired($file_key);
		        echo json_encode("Success");
		        return;
		        break;
		        
		}
		//var_dump($act2);
		$new_file_key = $this->file_model->clone_file_info($file_key, $act2);
		
		$members = $this->member_model->get_members_for_file($file_key);
		$members_keys = array();
		
		foreach ($members as $member ){
		  $new_member_key = $this->file_model->clone_member_info($member['key'],$new_file_key);
		  $incomes = $this->income_model->get_incomes_for_member($member['key']);
		  $propertys = $this->property_model->get_properties_for_member($member['key']);

		  foreach ($incomes as $income){
		  	//$income['key']
		  	$new_income_key = $this->income_model->clone_income($income['key'],$new_member_key);
		  }

		  foreach ($propertys as $property){
		  	//$property['key']
		  	$new_property_key = $this->property_model->clone_property($property['key'],$new_member_key);
		  }
		}

		//$file_info = $this->file_model->progress_file($file_key,"+");
		$this->progress_log($new_file_key, $log_comment, "新增複查案", 1);		
		$this->log_activity("rebuild a file", $act ,"old_key=$file_key new_key=$new_file_key");

		echo json_encode("Success");
	}

	public function FF(){
		ini_set('xdebug.var_display_max_depth', 5);
		ini_set('xdebug.var_display_max_children', 256);
		ini_set('xdebug.var_display_max_data', 1024);
		$file_key = 25;
		$members = $this->member_model->get_members_for_file($file_key);
		var_dump($members);
	}

	public function progress_next(){
		$file_key = (int)$this->input->post('file_key');
		$log_comment = $this->input->post('log_comment');		
		$file_info = $this->file_model->progress_file($file_key,"+");
		if($file_info == 7){
			$this->progress_log($file_key, $log_comment, "案件審核完成，結案",$file_info);
		}else{
			$this->progress_log($file_key, $log_comment, "向上呈核",$file_info);
		}
		
		$this->log_activity("向上呈核", "file_key=$file_key");
		echo json_encode("Success");
	}

	public function progress_transfer(){
		$file_key = (int)$this->input->post('file_key');
		$target_code = (int)$this->input->post('target_code');
		$log_comment = $this->input->post('log_comment');		
		$file_info = $this->file_model->progress_transfer($file_key, $target_code);

		$this->progress_log($file_key, $log_comment, "轉移別區",$file_info);
		$this->log_activity("轉移別區", "file_key=$file_key");
		echo json_encode("Success");
	}

	//

	public function progress_patch(){
		$file_key = (int)$this->input->post('file_key');
		$log_comment = $this->input->post('log_comment');		
		$file_info = $this->file_model->progress_file($file_key,"p");
		$this->progress_log($file_key, $log_comment, "要求補件",$file_info);
		$this->log_activity("要求補件", "file_key=$file_key");
		echo json_encode("Success");
	}

	public function progress_patch_re(){
		$file_key = (int)$this->input->post('file_key');
		$log_comment = $this->input->post('log_comment');		
		$file_info = $this->file_model->progress_file($file_key,"r");
		$this->progress_log($file_key, $log_comment, "補件重送",$file_info);
		$this->log_activity("補件重送", "file_key=$file_key");
		echo json_encode("Success");
	}
	


	public function progress_back(){
		$file_key = (int)$this->input->post('file_key');
		$log_comment = $this->input->post('log_comment');		
		$file_info = $this->file_model->progress_file($file_key,"back");
		$this->progress_log($file_key, $log_comment, "退回機關承辦",$file_info);
		$this->log_activity("退回機關承辦", "file_key=$file_key");
		echo json_encode("Success");
	}

	public function progress_delete(){
		$file_key = (int)$this->input->post('file_key');
		$log_comment = $this->input->post('log_comment');		
		$file_info = $this->file_model->progress_file($file_key,"delete");
		$this->progress_log($file_key, $log_comment, "刪除並封存此案",$file_info);
		$this->log_activity("刪除並封存此案", "file_key=$file_key");
		echo json_encode("Success");
	}

	public function progress_reborn(){
		$file_key = (int)$this->input->post('file_key');
		$log_comment = $this->input->post('log_comment');		
		$file_info = $this->file_model->progress_file($file_key,"reborn");
		$this->progress_log($file_key, $log_comment, "取消結案狀態，發還公所承辦人",$file_info);
		$this->log_activity("取消結案狀態，發還公所承辦人", "file_key=$file_key");
		echo json_encode("Success");
	}

	public function progress_directly_close(){
		$file_key = (int)$this->input->post('file_key');
		$log_comment = $this->input->post('log_comment');		
		$file_info = $this->file_model->progress_file($file_key,"DClose");

		$this->progress_log($file_key, $log_comment, "明顯資格不符，逕行結案",$file_info);
		$this->log_activity("明顯資格不符，逕行結案", "file_key=$file_key");

		//更新承辦人資訊-誰逕行結案的就由誰主承辦
		$FullName = $this->session->userdata('FullName');
		$organization = $this->session->userdata('organization');
		$department = $this->session->userdata('department');
		$this->file_model->recive_file_update_editor($file_key,$FullName,$department,$organization);

		echo json_encode("Success");
	}
	

	public function progress_get_back(){
		$file_key = (int)$this->input->post('file_key');
		$log_comment = $this->input->post('log_comment');		
		$file_info = $this->file_model->progress_file($file_key,"-");
		$this->progress_log($file_key, $log_comment, "撤回簽呈",$file_info);
		$this->log_activity("撤回簽呈", "file_key=$file_key");
		echo json_encode("Success");
	}

	public function progress_log($file_key, $log_comment, $progress_name, $progress_level){		
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

	public function get_calc_setting_by_year(){
		$year = (int)$this->input->post('year');
		$BankRate = $this->file_model->get_calc_BankRate($year);
		$MProperty = $this->file_model->get_calc_Movable_Property($year);
		$LowIncome = $this->file_model->get_calc_LowIncome($year);
		$LowInArr = array();
		foreach ($LowIncome as $LowIn){
			$LowInArr[] = array($LowIn["縣市"],(int)$LowIn["年度"],(int)$LowIn["月均所得"],(int)$LowIn["不動產限額"]);
		}
		$data['LowIncome'] = $LowInArr;
		$data['BankRate'] = $BankRate;
		$data['MProperty'] = $MProperty;
		echo json_encode($data);		
	}

	public function updateboy(){
		$data = array();
		$data['boy_key'] 			= $this->input->post('boy_key');
		$data['CE_New_name']		= $this->input->post("CE_New_name");
		$data['CE_New_code']		= $this->input->post("CE_New_code");
		$data['CE_New_birthday']	= $this->input->post("CE_New_birthday");
		$data['CE_New_milidate']	= $this->input->post("CE_New_milidate");
		$data['CE_New_echelon']		= $this->input->post("CE_New_echelon");
		$data['CE_New_county']		= $this->input->post("CE_New_county");
		$data['CE_New_town']		= $this->input->post("CE_New_town");
		$data['CE_New_village']		= $this->input->post("CE_New_village");
		$data['CE_New_address']		= $this->input->post("CE_New_address");
		$data['CE_New_type']		= $this->input->post("CE_New_type");
		$data['CE_New_status']		= $this->input->post("CE_New_status");
		$data['CE_New_phone']		= $this->input->post("CE_New_phone");
		$data['CE_New_email']		= $this->input->post("CE_New_email");
		$this->load->model('boy_model');
		$res = $this->boy_model->updateboy($data);
		echo json_encode($res);
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
