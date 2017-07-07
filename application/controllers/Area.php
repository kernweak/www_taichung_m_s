<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area extends MY_Controller {

	public function get_town_by_county(){	
		$this->load->model('area_model');
		$county = $this->input->post('ADF_county');		
		$towns = $this->area_model->town_by_county($county);
		$data['town_list'] = $towns;
		echo json_encode($data);		
	}

	public function get_village_by_town(){
		$this->load->model('area_model');
		$town_code = $this->input->post('ADF_town');		
		$villages = $this->area_model->village_by_town($town_code);
		$data['village_list'] = $villages;
		echo json_encode($data);				
	}

	public function military_type_list(){
		$this->load->model('area_model');
		//$town_code = $this->input->post('ADF_town');		
		$military_type_list = $this->area_model->military_type_list();
		$data['military_type_list'] = $military_type_list;
		echo json_encode($data);				
	}
}
