<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
class Boy_model extends CI_Model {

    public function __construct()
    {
            parent::__construct();
    }

    public function read_row_by_code($Boy_ID_code){
		$this->db->select('*');
		$this->db->from('miliboy_table');
		$this->db->where('身分證字號', $Boy_ID_code);
		//$this->db->where('Login_PW', $Login_PW);
		$query = $this->db->get();
		return $query;
	}

	public function add_new_boy($name, $id, $birthday, $begin_date, $mili_type, $mili_status){
		$data = array(
			'役男姓名' => $name,
			'身分證字號' => $id,
			'役男生日' => $birthday,
			'入伍日期' => $begin_date,
			'服役軍種' => $mili_type,
			'服役狀態' => $mili_status
			);
		$this->db->insert('miliboy_table', $data);
		$index = $this->db->insert_id();
		log_message('debug', 'boy table insert_id = '. $index);

		return $index;
	}

	public function update_new_boy_file_link($boy_key, $file_key){
		$data = array('最新案件流水號' => $file_key);
		$this->db->where('役男系統編號', $boy_key);
		$this->db->update('miliboy_table', $data);
	}

}