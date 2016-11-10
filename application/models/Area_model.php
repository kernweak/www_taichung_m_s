<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
class Area_model extends CI_Model {

    public function __construct()
    {
            parent::__construct();
    }
    function town_by_county($County_code){
		$this->db->select('*');
		$this->db->from('area_town');
		$this->db->where('Town_County_code', $County_code);
		//$this->db->where('Login_PW', $Login_PW);
		$query = $this->db->get();
		return $query->result_array();
	}

	function village_by_town($Boy_ID_code){
		$this->db->select('*');
		$this->db->from('miliboy_table');
		$this->db->where('身分證字號', $Boy_ID_code);
		//$this->db->where('Login_PW', $Login_PW);
		$query = $this->db->get();
		return $query;
	}


}