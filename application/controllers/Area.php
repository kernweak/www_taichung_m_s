<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area extends MY_Controller {
	public function __construct() { 
        parent::__construct(); 
		$this->load->model('area_model');
    }
	public function get_town_by_county(){	
		$county = $this->input->post('ADF_county');		
		$towns = $this->area_model->town_by_county($county);
		$data['town_list'] = $towns;
		echo json_encode($data);		
	}

	public function get_village_by_town(){
		$town_code = $this->input->post('ADF_town');		
		$villages = $this->area_model->village_by_town($town_code);
		$data['village_list'] = $villages;
		echo json_encode($data);				
	}

	public function military_type_list(){
		$military_type_list = $this->area_model->military_type_list();
		$data['military_type_list'] = $military_type_list;
		echo json_encode($data);				
	}

	public function get_area_group_list(){

		$get_area_group_list = $this->area_model->get_area_group_list();
		$AG_list = array();
		foreach ($get_area_group_list as $AG){
			//var_dump();
			switch ($AG['town_group']) {
				case 1:
					$AG_list[0][$AG['Town_code']]['name']= $AG['name'];
					break;
				case 2:
					$AG_list[1][$AG['Town_code']]['name']= $AG['name'];
					break;
				case 3:
					$AG_list[2][$AG['Town_code']]['name']= $AG['name'];
					break;
				default:
					# code...
					break;
			}
			$AG_list[3][$AG['Town_code']]= $AG['name'];
		}
		//var_dump($AG_list1);
		echo json_encode($AG_list);
	}
}
