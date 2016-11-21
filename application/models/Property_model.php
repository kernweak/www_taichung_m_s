<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
class Property_model extends CI_Model {

    public function __construct(){
		parent::__construct();
    }

    /*	
    	add a new property record for a member specified by $member_key
    	return the new added property's primary key
    */
    public function add($property, $member_key){
    	$data = array(
    		'成員系統編號' => $member_key,
    		'財產類別' => $property->type,
    		'位於何處' => $property->from,
    		'價值' =>$property->value,
    		'自用' => $property->self_use,
    		'備註' => $property->note
    		);
    	$this->db->insert('family_mem_property', $data);
		$property_key = $this->db->insert_id();
		log_message('debug', 'family_mem_property insert_key = '. $property_key);

		return $property_key;
	}

	/*
		update a property record
	*/
	public function update($property){
    	$data = array(    		
    		'財產類別' => $property->type,
    		'位於何處' => $property->from,
    		'價值' =>$property->value,
    		'自用' => $property->self_use,
    		'備註' => $property->note
    		);
    	$this->db->where('財產系統編號', $property->key);
    	$this->db->update('family_mem_property', $data);
	}

	public function delete_all_for_member($member_key){
		$this->db->where('成員系統編號',$member_key);
		$this->db->delete('family_mem_property');
	}

 	/*
	delete some property records for a specified member
	$member_key: the member to check
	$property_key: the property to keep
	*/
	public function delete_not_in($member_key, $property_keys){
		$this->db->where('成員系統編號',$member_key);
		$this->db->where_not_in('財產系統編號', $property_keys);
		$this->db->delete('family_mem_property');
	}

	public function get_properties_for_member($member_key){
		$this->db->where('成員系統編號', $member_key);
		$result = $this->db->get('family_mem_property')->result_array();	
		$properties = [];
		foreach ($result as $row){
			$property = array(
				'key' => $row['財產系統編號'],
				'type' => $row['財產類別'],
				'from' => $row['位於何處'],
				'value' => $row['價值'],
				'self_use' => $row['自用'],
				'note' => $row['備註']
			);
			$properties[] = $property;
		}
		log_message('debug', 'properties = '.print_r($properties, true));
		return $properties;
	}
}