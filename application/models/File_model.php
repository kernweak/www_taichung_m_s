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

	作業類別

	案件版本號

	源版本號

	審批階段

	建案日期

	戶籍地址
}