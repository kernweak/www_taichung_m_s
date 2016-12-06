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

    public function clone_members_for_file($old_file_key,$new_file_key){
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

//$Qstring = "INSERT `files_info_table` (`作業類別`, `案件編號`, `案件版本號`, `源版本號`, `審批階段`, `建案日期`, `役男系統編號`, `town`, `county`, `village`, `戶籍地址`, `email`, `聯絡電話1`, `聯絡電話2`, `聯絡電話3`, `總列計人口`, `月所需`, `月總所得`, `薪資月所得`, `營利月所得`, `利息月所得`, `股利月所得`, `財產月所得`, `其他月所得`, `總動產`, `存款本金總額`, `投資總額`, `有價證券總額`, `其他動產總額`, `房屋棟數`, `房屋總價`, `房屋列計棟數`, `房屋列計總價`, `土地筆數`, `土地總價`, `土地列計筆數`, `土地列計總價`, `不動產列計總額`, `是否扶助`, `扶助級別`, `扶助用語`, `整體家況敘述-公所`, `整體家況敘述-局處`, `備註`, `修改人編號`, `修改人單位`, `修改人姓名`, `可否編修`) SELECT `作業類別`, `案件編號`, `案件版本號`, `源版本號`, `審批階段`, `建案日期`, `役男系統編號`, `town`, `county`, `village`, `戶籍地址`, `email`, `聯絡電話1`, `聯絡電話2`, `聯絡電話3`, `總列計人口`, `月所需`, `月總所得`, `薪資月所得`, `營利月所得`, `利息月所得`, `股利月所得`, `財產月所得`, `其他月所得`, `總動產`, `存款本金總額`, `投資總額`, `有價證券總額`, `其他動產總額`, `房屋棟數`, `房屋總價`, `房屋列計棟數`, `房屋列計總價`, `土地筆數`, `土地總價`, `土地列計筆數`, `土地列計總價`, `不動產列計總額`, `是否扶助`, `扶助級別`, `扶助用語`, `整體家況敘述-公所`, `整體家況敘述-局處`, `備註`, `修改人編號`, `修改人單位`, `修改人姓名`, `可否編修` FROM `files_info_table` WHERE `案件流水號` = ".$file_key ;




    }


}