<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
class File_model extends CI_Model {

    public function __construct()
    {
            parent::__construct();
    }
    function insert_new_row($Boy_ID_code){
		$this->db->select('*');
		$this->db->from('miliboy_table');
		$this->db->where('身分證字號', $Boy_ID_code);
		//$this->db->where('Login_PW', $Login_PW);
		$query = $this->db->get();
		return $query;
	}
	public function update($file){
		$data = array(
			'存款本金總額' => $file->deposits,
			'投資總額' => $file->investment,
			'有價證券總額' => $file->securities,
			'其他動產總額'=> $file->others_pro,
			'總動產'=> $file->total_pro,
			'房屋棟數'=> $file->houses,
			'房屋總價'=>$file->houses_total,
			'房屋列計棟數'=>$file->houses_num,
			'房屋列計總價'=>$file->houses_listtotal,
			'土地筆數'=>$file->land,
			'土地總價'=>$file->land_total,
			'土地列計筆數'=>$file->land_num,
			'土地列計總價'=>$file->land_listtotal,
			'不動產列計總額'=>$file->total_imm,
			'薪資月所得'=>$file->salary,
			'營利月所得'=>$file->profit,
			'財產月所得'=>$file->property_inc,
			'利息月所得'=>$file->bank_inc,
			'股利月所得'=>$file->stock_inc,
			'其他月所得'=>$file->others_inc,
			'月總所得'=>$file->total_inc,
			'總列計人口'=>$file->members,
			'月所需'=>$file->need,			
			'扶助級別'=>$file->level
			);

    	$this->db->where('案件流水號', $file->key);
    	$this->db->update('files_info_table', $data);		
	}
	/*
	*	add a 初審案件
	*/
	public function add_new_file($today, $id, $county, $town, $village, $address){
		$data = array(
			'作業類別' => 1,
			'建案日期' => $today,
			'役男系統編號' => $id,
			'county'=> (int)$county,
			'town'=> (int)$town,
			'village' => (int)$village,
			'戶籍地址' => $address
			);
		$this->db->insert('files_info_table', $data);
		$index = $this->db->insert_id();
		log_message('debug', 'file table insert_id = '. $index);

		return $index;

	}

	public function read_file($file_key){
		//var_dump($file_key);
		$this->db->select('*');
		$this->db->from('files_info_table');
		$this->db->join('miliboy_table', 'miliboy_table.役男系統編號 = files_info_table.役男系統編號');
		$this->db->join('area_county', 'area_county.County_code = files_info_table.county');
		$this->db->join('area_town', 'area_town.Town_code = files_info_table.town');
		$this->db->join('area_village', 'area_village.Village_id = files_info_table.village');
		$this->db->join('files_type', 'files_type.作業類別 = files_info_table.作業類別','left');
		$this->db->where('files_info_table.案件流水號', $file_key);
		$query = $this->db->get();
		$result = $query->result();

		//var_dump($result);
		//var_dump($this->db->last_query());
		
		//var_dump($result);
		return $result;
	}

	public function read_file_list_pending($user_level, $user_organ){
		$this->db->select('*');
		$this->db->from('files_info_table');
		$this->db->join('miliboy_table', 'miliboy_table.役男系統編號 = files_info_table.役男系統編號');
		$this->db->join('area_town', 'area_town.Town_code = files_info_table.town');
		$this->db->join('area_town', 'area_town.Town_code = files_info_table.town');
	}

// miliboy_table.入伍日期// <th style="width: 8em;">入伍日期</th>
// area_town.Town_name//   	<th style="width: 7em;">行政區</th>
// miliboy_table.役男姓名 //   	<th style="width: 7em;">役男姓名</th>
// miliboy_table.身分證字號//   	<th style="width: 7.5em;">役男證號</th>
// files_info_table.審批階段//   	<th style="width: 12em;">案件進度</th>
// files_info_table.扶助級別//   	<th style="width: 8em;">審查結果</th>
// files_info_table.建案日期//   	<th style="width: 7em;">立案日期</th>
// files_info_table.主要承辦人//   	<th style="width: 7em;">主要承辦人</th>
// files_info_table.案件流水號//    案件流水號
// files_info_table.可否編修//   	可否編輯	--可編輯者要多個編輯按鈕--   檢視-編輯-同意&呈核
// files_status_code.案件階段名稱//   	作業類別
}