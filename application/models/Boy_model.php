<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
class Boy_model extends CI_Model {

    public function __construct()
    {
            parent::__construct();
    }
    function read_row_by_code($Boy_ID_code){
		$this->db->select('*');
		$this->db->from('miliboy_table');
		$this->db->where('身分證字號', $Boy_ID_code);
		//$this->db->where('Login_PW', $Login_PW);
		$query = $this->db->get();
		return $query;
	}

	function insert_row($Boy_ID_code){
		$this->db->select('*');
		$this->db->from('miliboy_table');
		$this->db->where('身分證字號', $Boy_ID_code);
		//$this->db->where('Login_PW', $Login_PW);
		$query = $this->db->get();
		return $query;
	}


}