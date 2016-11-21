<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
class Income_model extends CI_Model {

    public function __construct(){
    	parent::__construct();
    }

    /*	
    	add a new incomde record for a member specified by $member_key
    	return the new added record's primary key
    */
    public function add($income, $member_key){
    	$data = array(
    		'成員系統編號' => $member_key,
    		'所得類別' => $income->type,
    		'來源' => $income->from,
    		'年或月收入' => $income->m_or_y,
    		'金額' => $income->value,
    		'利率' => $income->rate,
    		'備註' => $income->note
    		);
    	$this->db->insert('family_mem_income', $data);
		$income_key = $this->db->insert_id();
		log_message('debug', 'family_mem_income insert_key = '. $income_key);

		return $income_key;
	}

	/*
		update an income record
	*/
	public function update($income){
    	$data = array(    		    		
    		'所得類別' => $income->type,
    		'來源' => $income->from,
    		'年或月收入' => $income->m_or_y,
    		'金額' => $income->value,
    		'利率' => $income->rate,
    		'備註' => $income->note
    		);
    	$this->db->where('所得系統編號', $income->key);
    	$this->db->update('family_mem_income', $data);
	}

	public function delete_all_for_member($member_key){
		$this->db->where('成員系統編號',$member_key);
		$this->db->delete('family_mem_income');
	}

 	/*
	delete some income records that are not listed for a specified member
	$member_key: the member to check
	$income_keys: the income records to keep
	*/
	public function delete_not_in($member_key, $income_keys){
		$this->db->where('成員系統編號',$member_key);
		$this->db->where_not_in('所得系統編號', $income_keys);
		$this->db->delete('family_mem_income');
	}

	public function get_incomes_for_member($member_key){
		$this->db->where('成員系統編號', $member_key);
		$result = $this->db->get('family_mem_income')->result_array();	
		$incomes = [];
		foreach ($result as $row){
			$income = array(
				'key' => $row['所得系統編號'],
				'type' => $row['所得類別'],
				'from' => $row['來源'],
				'm_or_y' => $row['年或月收入'],
				'value' => $row['金額'],
				'rate' => $row['利率'],
				'note' => $row['備註']
			);
			$incomes[] = $income;
		}
		log_message('debug', 'incomes = '.print_r($incomes, true));
		return $incomes;
	}
}