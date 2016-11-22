<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
class File_model extends CI_Model {

    public function __construct()
    {
            parent::__construct();
    }
    function insert_new_row($Boy_ID_code){
		$this->db->select('*');
		$this->db->from('miliboy_table');
		$this->db->where('身分證字號', $Boy_ID_code);
		//$this->db->where('Login_PW', $Login_PW);
		$query = $this->db->get();
		return $query;
	}

	public function progress_file($file_key, $oper){
		$this->db->select('審批階段');
		$this->db->from('files_info_table');
		$this->db->where('案件流水號', $file_key);
		$query = $this->db->get();
		$result = $query->result();
		//var_dump($result);

		if ($oper == "+"){
			$data = array(
			'審批階段' => ($result[0]->審批階段 + 1)
			);
		}elseif($oper == "1"){
			$data = array(
			'審批階段' => 1
			);
		}
		$this->db->where('案件流水號', $file_key);
    	$this->db->update('files_info_table', $data);
    	//var_dump($this->db->last_query());
	}
	public function update($file){
		$data = array(
			'存款本金總額' => $file->deposits,
			'投資總額' => $file->investment,
			'有價證券總額' => $file->securities,
			'其他動產總額'=> $file->others_pro,
			'總動產'=> $file->total_pro,
			'房屋棟數'=> $file->houses,
			'房屋總價'=>$file->houses_total,
			'房屋列計棟數'=>$file->houses_num,
			'房屋列計總價'=>$file->houses_listtotal,
			'土地筆數'=>$file->land,
			'土地總價'=>$file->land_total,
			'土地列計筆數'=>$file->land_num,
			'土地列計總價'=>$file->land_listtotal,
			'不動產列計總額'=>$file->total_imm,
			'薪資月所得'=>$file->salary,
			'營利月所得'=>$file->profit,
			'財產月所得'=>$file->property_inc,
			'利息月所得'=>$file->bank_inc,
			'股利月所得'=>$file->stock_inc,
			'其他月所得'=>$file->others_inc,
			'月總所得'=>$file->total_inc,
			'總列計人口'=>$file->members,
			'月所需'=>$file->need,			
			'扶助級別'=>$file->level
			);

    	$this->db->where('案件流水號', $file->key);
    	$this->db->update('files_info_table', $data);		
	}
	/*
	*	add a 初審案件
	*/
	public function add_new_file($today, $id, $county, $town, $village, $address, $FullName, $organization, $department){
		//$organization 機關先不寫
		$data = array(
			'作業類別' => 1,
			'建案日期' => $today,
			'役男系統編號' => $id,
			'county'=> (int)$county,
			'town'=> (int)$town,
			'village' => (int)$village,
			'戶籍地址' => $address,
			'修改人姓名' => $FullName,
			'修改人單位' => $department,
			'修改人編號' => $organization,
			'審批階段' => 1
			);
		$this->db->insert('files_info_table', $data);
		$index = $this->db->insert_id();
		log_message('debug', 'file table insert_id = '. $index);

		return $index;

	}

	public function read_file($file_key){
		//var_dump($file_key);
		$this->db->select('*');
		$this->db->from('files_info_table');
		$this->db->join('miliboy_table', 'miliboy_table.役男系統編號 = files_info_table.役男系統編號');
		$this->db->join('area_county', 'area_county.County_code = files_info_table.county');
		$this->db->join('area_town', 'area_town.Town_code = files_info_table.town');
		$this->db->join('area_village', 'area_village.Village_id = files_info_table.village');
		$this->db->join('files_type', 'files_type.作業類別 = files_info_table.作業類別','left');
		$this->db->where('files_info_table.案件流水號', $file_key);
		$query = $this->db->get();
		$result = $query->result();

		//var_dump($result);
		//var_dump($this->db->last_query());
		
		//var_dump($result);
		return $result;
	}

	public function read_file_list_pending($user_level, $user_organ){
		$this->db->select("miliboy_table.入伍日期,area_town.Town_name,miliboy_table.役男姓名,miliboy_table.身分證字號,files_info_table.審批階段,files_info_table.扶助級別,files_info_table.建案日期,files_info_table.修改人姓名,files_info_table.案件流水號,files_info_table.可否編修,`files_status_code`.`案件階段名稱`,files_type.作業類別名稱");
		$this->db->from('files_info_table');
		$this->db->join('miliboy_table', '`miliboy_table`.`役男系統編號` = `files_info_table`.`役男系統編號`');
		$this->db->join('area_town', 'area_town.Town_code = files_info_table.town');
		$this->db->join('files_status_code', '`files_status_code`.`審批階段代號` = `files_info_table`.`審批階段`','left');
		$this->db->join('files_type', 'files_type.作業類別 = files_info_table.作業類別','left');
		if($user_level <= 1){	
			//區公所使用者登入，應該只能看到自己公所
			$this->db->where('area_town.Town_name', $user_organ);

			//LV1 承辦人可以，檢視，編輯，呈核
			$this->db->where('files_status_code.審批階段代號', $user_level);
			$this->db->or_where('files_status_code.審批階段代號', 0);


		}
		elseif($user_level <= 3){	
			//區公所使用者登入，應該只能看到自己公所
			$this->db->where('area_town.Town_name', $user_organ);


			//LV2,3 主管可以檢視，加入意見，退回，呈核，但只能看到自己階段的檔案
			$this->db->where('files_status_code.審批階段代號', $user_level);

		}
		elseif($user_level <= 6){	
			//市府局處以上可觀看到所有區的檔案
			//可以檢視，加入意見，退回，呈核，但只能看到自己階段的檔案
			$this->db->where('files_status_code.審批階段代號', $user_level);


		}
		elseif($user_level == 7){	
			//工程師模式-可完全瀏覽
			//$this->db->where('files_status_code.審批階段代號', $user_level);


		}



		
		//$this->db->where('files_info_table.案件流水號', $file_key);
		


		// ini_set('xdebug.var_display_max_depth', 5);
		// ini_set('xdebug.var_display_max_children', 256);
		// ini_set('xdebug.var_display_max_data', 1024);

		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
		// var_dump($result);
		// var_dump($this->db->last_query());
	}
}