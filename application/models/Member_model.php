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
    	$specials = explode(',',$person->special);    	

    	$data = array(
    		'案件流水號' => $file_key,
    		'稱謂' => $person->title,
    		'姓名' => $person->name,
    		'身分證字號' =>$person->code,
    		'出生日期' => $person->birthday,
    		'戶籍地址' => $person->address,
    		'職業' => $person->job,
    		'特殊身分類別' => $specials[0],
    		'特殊身分代號' => $specials[1],
    		'配偶' => $person->marriage,
    		'前配偶' => $person->marriage_ex,
    		'area' => $person->area,
    		'area_key' => $person->area_key,
    		'個人描述' => $person->comm
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
		$specials = explode(',',$person->special);
    	$data = array(    		
    		'稱謂' => $person->title,
    		'姓名' => $person->name,
    		'身分證字號' =>$person->code,
    		'出生日期' => $person->birthday,
    		'戶籍地址' => $person->address,
    		'職業' => $person->job,
    		'特殊身分類別' => $specials[0],
    		'特殊身分代號' => $specials[1],
    		'配偶' => $person->marriage,
    		'前配偶' => $person->marriage_ex,
    		'area' => $person->area,
    		'area_key' => $person->area_key,
    		'個人描述' => $person->comm
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

	public function get_members_for_file($file_key){
		$this->db->where('案件流水號', $file_key);
		$result = $this->db->get('family_members')->result_array();	
		$members=[];

		$this->load->model('property_model');
		$this->load->model('income_model');

		foreach($result as $person){
			$properties = $this->property_model->get_properties_for_member($person['成員系統編號']);
			$incomes = $this->income_model->get_incomes_for_member($person['成員系統編號']);			
			$member = array(
				'key' => $person['成員系統編號'],
				'title' => $person['稱謂'],
				'name' => $person['姓名'],
				'code'=> $person['身分證字號'],
				'birthday' =>$person['出生日期'],
				'address' => $person['戶籍地址'],
				'job' => $person['職業'],
				'specials' => $person['特殊身分類別'].','.$person['特殊身分代號'],
    			'marriage' => $person['配偶'],
    			'marriage_ex' => $person['前配偶'],
    			'area' => $person['area'],
    			'area_key' => $person['area_key'],
    			'comm' => $person['個人描述'],
    			'property' => $properties,
    			'income' => $incomes
			);  	
    		$members[] = $member;
    	}    	    
    	return $members;
	}
}