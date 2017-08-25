<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Euser extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('useroos_model');
	}
	


	Public function SQL_basic(){
		
		$draw = $_GET['draw'];//这个值作者会直接返回给前台
		//排序
		$order_column = $_GET['order']['0']['column'];//那一列排序，从0开始
		$order_dir = $_GET['order']['0']['dir'];//ase desc 升序或者降序
		//搜索
		$search = $_GET['search']['value'];//获取前台传过来的过滤条件
		$start = $_GET['start'];//从多少开始
		$length = $_GET['length'];//数据长度
		$limitSql = '';
		/*
		$seprate = $this->input->get_post('seprate');
		if($seprate == "依檔號排序"){
			$seprate = "";
		}else{
			$seprate = "`編組`,";
		}
		*/
		$file_list = $this->useroos_model->SQL_basic($start,$length,$search,$order_column,$order_dir);
		echo json_encode(array(
		    "draw" => intval($draw),
		    "recordsTotal" => $file_list[0],
		    "recordsFiltered" => $file_list[0],
		    "data" => $file_list[1]
		),JSON_UNESCAPED_UNICODE);
	}

	public function User_Switch(){
		$User_id = $this->input->get_post('User_id');
		$type = $this->input->get_post('type');
		$this->useroos_model->User_Switch($User_id, $type);
		echo json_encode("User_Switch done!");
	}

	public function User_Level(){
		$User_id = $this->input->get_post('User_id');
		$User_level = $this->input->get_post('User_level');
		$this->useroos_model->User_level($User_id, $User_level);
		echo json_encode("User_level done!");
	}

	

}