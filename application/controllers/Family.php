<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Family extends MY_Controller {

	public function __construct() { 
        parent::__construct(); 
        $this->load->model('file_model');
		$this->load->model('member_model');
		$this->load->model('property_model');
		$this->load->model('income_model');
    } 


	public function set_members_file(){
		$members = json_decode($this->input->post('members'));
		$file_info = json_decode($this->input->post('file_info'));
		$file_key = $file_info->key;
		log_message('debug', 'received post "file_info" ='.print_r($file_info, true));
		log_message('debug', 'received post "members" ='.print_r($members, true));
		$this->set_members($members, $file_key);
		$this->file_model->update($file_info);
		$this->log_activity("儲存案件與家屬資訊", "file_key=$file_key");
		//TODO check if success??
		$data= array(			
			'Msg' => "success"
			);

		echo json_encode($data);
	}

	public function set_newboy_file(){
		$members = json_decode($this->input->post('members'));
		$file_info = json_decode($this->input->post('file_info'));
		$file_key = $file_info->key;
		log_message('debug', 'received post "file_info" ='.print_r($file_info, true));
		log_message('debug', 'received post "members" ='.print_r($members, true));
		$this->set_members($members, $file_key);
		$this->file_model->update($file_info);
		$this->log_activity("儲存案件與家屬資訊", "file_key=$file_key");
		//TODO check if success??
		$data= array(			
			'Msg' => "success"
			);

		echo json_encode($data);
	}

	public function get_members_file(){
		$file_key = $this->input->post('file_key');		
		$members = $this->member_model->get_members_for_file($file_key);		
		$files = $this->file_model->read_file($file_key);			

		$data = array(
			'file_info' => $files[0],
			'members' => $members
		);
		log_message('debug', 'get_members_file return ='. print_r($data, true));
		$this->log_activity("讀取案件與家屬資訊", "file_key=$file_key");
		echo json_encode($data);
	}

	function set_members($members, $file_key){				
		// 1. delete unlisted members
		$this->clean_members($members, $file_key);

		// 2. add new members or update existing members
		foreach ($members as $person) {
			if ($this->isNew($person)){
				// add a new member
				$member_key = $this->member_model->add($person, $file_key);
				foreach($person->property as $prty){					
					$this->property_model->add($prty, $member_key);
				}
				foreach($person->income as $income){
					$this->income_model->add($income, $member_key);
				}
			}else{
				// update an existing member
				$this->member_model->update($person);
				
				// delete unlisted property
				$this->clean_properties($person->property, $person->key);

				//add or update listed property
				foreach($person->property as $prty){
					if ($this->isNew($prty)){
						$this->property_model->add($prty, $person->key);
					}else{
						$this->property_model->update($prty);
					}					
				}

				// delete unlisted income
				$this->clean_incomes($person->income, $person->key);

				// add or update listed income
				foreach($person->income as $income){
					if ($this->isNew($income)){
						$this->income_model->add($income, $person->key);
					}else{
						$this->income_model->update($income);
					}					
				}
			}
		}		
	}


	/*
		check if the $entity(family_member/property/income)
		a new record by checking its key value
	*/	
	private function isNew($entity){		
		$key = trim($entity->key);
		if (empty($key) || strcasecmp($key, 'new')==0){
			return true;			
		}else{
			return false;
		}
	}

	/*
	delete old members, only keep members listed in $members
	when a member is deleted, mysql will automatically delete this person's income/property records, because of "delete on cascade" setting.
	*/
	private function clean_members($members, $file_key){
		$keep = [];
		foreach ($members as $person) {			
			if (!$this->isNew($person)){
				$keep[] = $person->key;
			}
		}
		log_message('debug', 'members to keep = '.print_r($keep, true));
		if (empty($keep)){
			$this->member_model->delete_all_for($file_key);
		}else{
			$this->member_model->delete_not_in($file_key, $keep);
		}
	}

	/*
	only keep $properties for $member_key, and delete other properties
	*/
	private function clean_properties($properties, $member_key){
		$keep = [];
		foreach($properties as $prty){					
			if (!$this->isNew($prty)){
				$keep[] = $prty->key;
			}
		}
		if (empty($keep)){
			$this->property_model->delete_all_for_member($member_key);
		}else{
			$this->property_model->delete_not_in($member_key, $keep);
		}
	}

	/*
	only keep $incomes for $member_key, and delete other incomes
	*/
	private function clean_incomes($incomes, $member_key){
		$keep = [];
		foreach($incomes as $income){	
			if (!$this->isNew($income)){
				$keep[] = $income->key;
			}
		}
		if (empty($keep)){					
			$this->income_model->delete_all_for_member($member_key);
		}else{
			$this->income_model->delete_not_in($member_key, $keep);
		}
	}

	/* test 為一個案件 
		add 2 new income 
		add 2 neww property
		add 2 new members
	*/
	public function set_members_test(){
		$members = $this->getMembers();
		$file_key = 1;

		$this->set_members($members, $file_key);

	}
	
	/*test 
		update an existing member
	*/
	public function set_members_test2(){
		$members = $this->getMembers();
		$members[0]->key = '15';
		$members[0]->name = '阿明新名2';
		$members[0]->birthday = '1980-08-12';

		$members[1]->key = '16';
		$members[1]->title = '爸爸';
		$members[1]->name = '阿明爸爸';
		unset($members[1]->property[0]);
		log_message('debug', 'members = '.print_r($members, true));
		// $members[1]->income=[];
		$file_key = 1;
		$this->set_members($members, $file_key);

	}

	function getMembers(){
		// two new property
		$property1 = (object)array(
			'key' => '',
			'type' =>'土地',
			'from' => '台中市西屯區',
			'value' => '1000000',
			'self_use' => 'y',
			'note'=>''
			);
		$property2 = (object)array(
			'key' => '',
			'type' =>'房屋',
			'from' => '台中市西屯區',
			'value' => '2000000',
			'self_use' => 'y',
			'note'=>''
			);
		$property = [];
		$property[] = $property1;
		$property[] = $property2;
		
		// two new income
		$income1 = (object)array(
			'key' => '',
			'type' => '利息',
			'from' => '台灣銀行-定存',
			'm_or_y' => 'y',
			'value' => '2000',
			'rate' => '0.02',
			'note' => '定存'
			);
		$income2 = (object)array(			
			'key' => '',
			'type' => '租金',
			'from' => '南京東路住家的房間',
			'm_or_y' => 'm',
			'value' => '6000',
			'rate' => '',
			'note' => '雅房出租'
			);
		$income= [];
		$income[] = $income1;
		$income[] = $income2;

		// 役男, 沒有property, 沒有income
		$boy = (object)array(
			'key' => '',
			'title' => '役男',
			'name' => '阿明',
			'code' => 'S1234',
			'birthday' => '1980-08-10',
			'property' => [],
			'income' => []
			);
		// 役男的媽媽, 2筆 property, 2筆income
		$mother = (object)array(
			'key' => '',
			'title' => '媽媽',
			'name' => '阿明媽',
			'code' => 'L221234',
			'birthday' => '1950-01-01',
			'property' => $property,
			'income' => $income			
			);

		$members = [];
		$members[] = $boy;
		$members[] = $mother;
		return $members;
	}

}