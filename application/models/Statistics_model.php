<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
class Statistics_model extends CI_Model {

    public function __construct()
    {
            parent::__construct();
    }
    function Statistics_1($Date_1,$Date_2){
    	$this->db->select('area_town.Town_name,  COUNT(*) AS amount');
    	$this->db->from('files_info_table');
    	$this->db->join('area_town', 'area_town.Town_code = files_info_table.town','left');
    	$this->db->group_by('town');
    	$this->db->order_by('amount');
    	$query = $this->db->get();
		$result = $query->result_array();
		return $result;


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
		// $this->db->select("miliboy_table.入伍日期,miliboy_table.役男生日,area_town.Town_name,miliboy_table.役男姓名,miliboy_table.身分證字號,files_info_table.審批階段,files_info_table.扶助級別,files_info_table.建案日期,files_info_table.修改人姓名,files_info_table.案件流水號,files_info_table.可否編修,`files_status_code`.`案件階段名稱`,files_type.作業類別名稱,miliboy_table.最新案件流水號");
		// $this->db->from('files_info_table');
		// $this->db->join('miliboy_table', '`miliboy_table`.`役男系統編號` = `files_info_table`.`役男系統編號`');
		// $this->db->join('area_town', 'area_town.Town_code = files_info_table.town');
		// $this->db->join('files_status_code', '`files_status_code`.`審批階段代號` = `files_info_table`.`審批階段`','left');
		// $this->db->join('files_type', 'files_type.作業類別 = files_info_table.作業類別','left');
		// $this->db->where('是否扶助', true);
		// $this->db->where('miliboy_table.退伍日期', null);
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