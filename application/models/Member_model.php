<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
class Member_model extends CI_Model {

    public function __construct(){
    	parent::__construct();
    }

    /* 
    	add a new family member for a file with $file_key 
    	return the new member's primary key
    */
    public function add($person, $file_key){
    	$data = array(
    		'案件流水號' => $file_key,
    		'稱謂' => $person->title,
    		'姓名' => $person->name,
    		'身分證字號' =>$person->code,
    		'出生日期' => $person->birthday
    		);
    	$this->db->insert('family_members', $data);
		$member_key = $this->db->insert_id();
		log_message('debug', 'family_members insert_id = '. $member_key);
		
		return $member_key;
	}

	/*
		update an existing member, the member must carry a primary key 
	*/
	public function update($person){
    	$data = array(    		
    		'稱謂' => $person->title,
    		'姓名' => $person->name,
    		'身分證字號' =>$person->code,
    		'出生日期' => $person->birthday
    		);
    	$this->db->where('成員系統編號', $person->key);
    	$this->db->update('family_members', $data);
	}

	public function delete_all_for($file_key){
		$this->db->where('案件流水號',$file_key);		
		$this->db->delete('family_members');
	}

	/*
	delete some members for a specified file
	$member_keys: the members to keep
	$file_key: the specified file
	*/
	public function delete_not_in($file_key, $member_keys){
		$this->db->where('案件流水號',$file_key);
		$this->db->where_not_in('成員系統編號', $member_keys);
		$this->db->delete('family_members');
	}	
}