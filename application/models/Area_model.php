<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
class Area_model extends CI_Model {

    function __construct()
    {
            parent::__construct();
    }
    function military_type_list(){
		$this->db->select('name');
		$this->db->from('military_type');
		$this->db->order_by('sort');
		//$this->db->where('Login_PW', $Login_PW);
		$query = $this->db->get();
		$result = $query->result();
		log_message('debug', 'military type list:');
		log_message('debug', print_r($result,true));		
		return $result;
	}

    function town_by_county($County_code){
		$this->db->select('Town_code, Town_name');
		$this->db->from('area_town');
		$this->db->where('Town_County_code', $County_code);
		$this->db->where('Town_id <= 29');
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

	function address_by_code($county,$town,$village){
		$this->db->select('County_name');
		$this->db->from('area_county');
		$this->db->where('County_code', $county);
		$query = $this->db->get();
		$result = $query->row();
		$County_name = $result->County_name;
		//...
		$this->db->select('Town_name');
		$this->db->from('area_town');
		$this->db->where('Town_code', $town);
		$query = $this->db->get();
		$result = $query->row();
		$Town_name = $result->Town_name;
		//...
		$this->db->select('Village_name');
		$this->db->from('area_village');
		$this->db->where('Village_id', $village);
		$query = $this->db->get();
		$result = $query->row();
		$Village_name = $result->Village_name;

		return $County_name.$Town_name.$Village_name;
	}

	function get_area_group_list(){
		$this->db->select('Town_code, Town_name as name, town_group');
		$this->db->from('area_town');
		$this->db->order_by('town_group, Town_id');
		
		//$this->db->where('Login_PW', $Login_PW);
		$query = $this->db->get();
		$result = $query->result_array();
		//log_message('debug', 'town query result:');
		//log_message('debug', print_r($result,true));		
		return $result;
	}
}