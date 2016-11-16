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

	/*
	*	add a 初審案件
	*/
	public function add_new_file($today, $id, $county, $town, $village, $address){
		$data = array(
			'作業類別' => 1
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

	public function read_new_file($file_key){
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
}