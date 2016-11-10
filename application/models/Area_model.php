<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
class Area_model extends CI_Model {

    public function __construct()
    {
            parent::__construct();
    }
    function town_by_county($County_code){
		$this->db->select('Town_code, Town_name');
		$this->db->from('area_town');
		$this->db->where('Town_County_code', $County_code);
		//$this->db->where('Login_PW', $Login_PW);
		$query = $this->db->get();
		$result = $query->result();
		log_message('debug', 'town query result:');
		log_message('debug', print_r($result,true));		
		return $result;
	}

	function village_by_town($Town_code){
		$this->db->select('Village_id, Village_name');
		$this->db->from('area_village');
		$this->db->where('Village_Town_code', $Town_code);
		
		$query = $this->db->get();
		$result = $query->result();
		log_message('debug', 'village query result:');
		log_message('debug', print_r($result,true));		
		return $result;		
	}


}