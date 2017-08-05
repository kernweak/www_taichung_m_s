<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
class Boy_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function read_row_by_code($Boy_ID_code){
		$this->db->select('*');
		$this->db->from('miliboy_table');
		$this->db->where('身分證字號', $Boy_ID_code);
		$this->db->where('役男刪除', 0);
		//$this->db->where('Login_PW', $Login_PW);
		$query = $this->db->get();
		return $query;
	}

	function read_boy_file_by_id($code){
		$this->db->select(
			'`miliboy_table`.`役男系統編號` as `役男編號`, 
			 `miliboy_table`.`役男姓名`, 
			 `miliboy_table`.`身分證字號`, 
			 `miliboy_table`.`役男生日`, 
			 `miliboy_table`.`入伍日期`, 
			 `miliboy_table`.`梯次`, 
			 `miliboy_table`.`服役軍種`, 
			 `miliboy_table`.`服役狀態`, 
			 `miliboy_table`.`補助狀態`, 
			 `miliboy_table`.`退伍日期`, 
			 `miliboy_table`.`最新案件流水號`,
			 `files_info_table`.`county`,
			 `files_info_table`.`town`,
			 `files_info_table`.`village`,
			 `files_info_table`.`戶籍地址`,
			 `files_info_table`.`email`,
			 `files_info_table`.`聯絡電話1`,
			 `files_info_table`.`聯絡電話1`,
			 `area_county`.`County_code`,
			 `area_county`.`County_name`,
			 `area_town`.`Town_code`,
			 `area_town`.`Town_name`,
			 `area_village`.`Village_id`,
			 `area_village`.`Village_name`,
			 ');
		$this->db->from('miliboy_table');
		$this->db->join('files_info_table', '`miliboy_table`.`役男系統編號` = `files_info_table`.`役男系統編號`');
		$this->db->join('area_county', 'area_county.County_code = files_info_table.county');
		$this->db->join('area_town', 'area_town.Town_code = files_info_table.town');
		$this->db->join('area_village', 'area_village.Village_id = files_info_table.village');
		$this->db->where('`miliboy_table`.`役男系統編號`', $code);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}

	function add_new_boy($name, $id, $birthday, $begin_date, $mili_type, $mili_status, $echelon){
		$data = array(
			'役男姓名' => $name,
			'身分證字號' => $id,
			'役男生日' => $birthday,
			'入伍日期' => $begin_date,
			'服役軍種' => $mili_type,
			'服役狀態' => $mili_status,
			'梯次' 		=> $echelon
		);
		$this->db->insert('miliboy_table', $data);
		$index = $this->db->insert_id();
		log_message('debug', 'boy table insert_id = '. $index);

		return $index;
	}

	function update_new_boy_file_link($boy_key, $file_key){
		$data = array('最新案件流水號' => $file_key);
		$this->db->where('役男系統編號', $boy_key);
		$this->db->update('miliboy_table', $data);
	}

	function change_mili_status($boy_key, $status){
		$data = array('服役狀態' => $status);
		$this->db->where('役男系統編號', $boy_key);
		$this->db->update('miliboy_table', $data);
	}
	
	function updateboy($indata){
		$data1 = array(
			'役男姓名' 	=> $indata['CE_New_name'],
			'身分證字號'=> $indata['CE_New_code'],
			'役男生日' 	=> $indata['CE_New_birthday'],
			'入伍日期' 	=> $indata['CE_New_milidate'],
			'梯次' 		=> $indata['CE_New_echelon'],
			'服役軍種' 	=> $indata['CE_New_type'],
			'服役狀態' 	=> $indata['CE_New_status']
		);
    	$this->db->where('役男系統編號', $indata['boy_key']);
    	$this->db->update('miliboy_table', $data1);
    	$data2 = array(
			'county' 	=> $indata['CE_New_county'],
			'town'		=> $indata['CE_New_town'],
			'village' 	=> $indata['CE_New_village'],
			'聯絡電話1' => $indata['CE_New_phone'],
			'email' 	=> $indata['CE_New_email'],
			'戶籍地址' 	=> $indata['CE_New_address']
		);
    	$this->db->where('役男系統編號', $indata['boy_key']);
    	$this->db->update('files_info_table', $data2);
    	return 1;
	}
}