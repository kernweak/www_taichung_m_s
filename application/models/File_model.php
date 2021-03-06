<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
class File_model extends CI_Model {

    public function __construct()
    {
            parent::__construct();
    }
    /*
    function insert_new_row($Boy_ID_code){
		$this->db->select('*');
		$this->db->from('miliboy_table');
		$this->db->where('身分證字號', $Boy_ID_code);
		//$this->db->where('Login_PW', $Login_PW);
		$query = $this->db->get();
		return $query;
	}
	*/

	public function progress_file($file_key, $oper){
		$this->db->select('役男系統編號, 源版本號,審批階段,扶助級別');
		$this->db->from('files_info_table');
		$this->db->where('案件流水號', $file_key);

		$query 		= $this->db->get();
		$result 	= $query->result();
		$boy_key 	= $result[0]->役男系統編號;
		$file_source= $result[0]->源版本號;


		$update_boy_table_flag = 0;
		if ($oper == "+"){
			if($result[0]->審批階段 == 6){
				$update_boy_table_flag = 1;
				if( $result[0]->扶助級別 == "資格不符"){
					$data = array(
						'審批階段' => ($result[0]->審批階段 + 1),
						'是否扶助' => false
					);

				}else{
					$data = array(
						'審批階段' => ($result[0]->審批階段 + 1),
						'是否扶助' => true
					);
				}
			}else{
				$data = array(
					'審批階段' => ($result[0]->審批階段 + 1)
				);
			}
		}elseif($oper == "-"){
			if($result[0]->審批階段 == 1){
				$data = array(
					'審批階段' => 1
				);
			}
			else{
				$data = array(
					'審批階段' => ($result[0]->審批階段 - 1)
				);
			}
			
		}elseif($oper == "back"){
			if($result[0]->審批階段 <= 4){
				$back = 1;
				$data = array(
					'審批階段' => 1,
					'是否扶助' => NULL
				);
			}
			elseif($result[0]->審批階段 <= 6){
				$back = 4;
				$data = array(
					'審批階段' => 4,
					'是否扶助' => NULL
				);
			}
		}elseif($oper == "delete"){
			if($result[0]->審批階段 <= 1){
				$data = array(
					'案件刪除' => 1
				);
				if($file_source == NULL){
					$data2 = array(
						'役男刪除' => 1
					);
			    	$this->db->where('役男系統編號', $boy_key);
			    	$this->db->update('miliboy_table', $data2);
				}else{
					$data2 = array(
						'最新案件流水號' => $file_source
					);
			    	$this->db->where('役男系統編號', $boy_key);
			    	$this->db->update('miliboy_table', $data2);
				}
			}
		}elseif($oper == "reborn"){
				$data = array(
					'審批階段' => 1,
					'是否扶助' => NULL,
					'扶助級別' => "本案重啟審查中",
				);
		}elseif($oper == "p"){
			$data = array(
			'審批階段' => 8
			);
		}elseif($oper == "r"){
			$data = array(
			'審批階段' => 4
			);
		}elseif($oper == "DClose"){
			$data = array(
				'扶助級別' => "資格不符，逕行結案",
				'審批階段' => 8,
				'是否扶助' => 0
			);
		}

		$this->db->where('案件流水號', $file_key);
    	$this->db->update('files_info_table', $data);

    	//每次案件結案，要把案件流水號寫入miliboy table。這樣，如果是複查案，就能連結到最新的複查案。
    	if($update_boy_table_flag == 1){ 
			$data = array(
				'最新案件流水號' => $file_key
			);
	    	$this->db->where('役男系統編號', $boy_key);
	    	$this->db->update('miliboy_table', $data);
    	}

    	if ($oper == "+"){
			return $result[0]->審批階段 + 1;
		}elseif($oper == "-"){
			return $data['審批階段'];
		}elseif($oper == "p"){
			return 8;
		}elseif($oper == "r"){
			return 4;
		}elseif($oper == "back"){
			return $back;
		}elseif($oper == "DClose"){
			return 9;
		}elseif($oper == "reborn"){
			return 1;
		}elseif($oper == "delete"){
			return 10;
		}
    	//var_dump($this->db->last_query());
	}

	public function progress_batch_next($User_Level){

		$this->db->select('役男系統編號, 源版本號, 審批階段, 扶助級別, 案件流水號');
		$this->db->from('files_info_table');
		$this->db->where('審批階段', 6 /*$User_Level*/);

		// $query 		= $this->db->get();
		// $result 	= $query->result();
		// var_dump($result);
		$query = $this->db->get();
		$results = $query->result_array();
		//var_dump($results);
		$file_key_array  = array();
		//var_dump($this->db->last_query());
		foreach ($results as $result) {
			//var_dump($result);
			//var_dump($value);
			$boy_key 	= $result['役男系統編號'];
			$file_source= $result['源版本號'];
			$file_key_array[]=$result['案件流水號'];


				if($result['審批階段'] == 6){
					$update_boy_table_flag = 1;
					if( $result['扶助級別'] == "資格不符"){
						$data = array(
							'審批階段' => ($result['審批階段'] + 1),
							'是否扶助' => false
						);

					}else{
						$data = array(
							'審批階段' => ($result['審批階段'] + 1),
							'是否扶助' => true
						);
					}
				}else{
					$data = array(
						'審批階段' => ($result['審批階段'] + 1)
					);
				}


			$this->db->where('案件流水號', $result['案件流水號']);
	    	$this->db->update('files_info_table', $data);

	    	//每次案件結案，要把案件流水號寫入miliboy table。這樣，如果是複查案，就能連結到最新的複查案。
	    	if($update_boy_table_flag == 1){ 
				$data = array(
					'最新案件流水號' => $result['案件流水號']
				);
		    	$this->db->where('役男系統編號', $boy_key);
		    	$this->db->update('miliboy_table', $data);
	    	}
		}
		return $file_key_array;

  //   	if ($oper == "+"){
		// 	return $result[0]->審批階段 + 1;
		// }


	}

	public function progress_transfer($file_key, $target_code){
		$data = array(
						'審批階段' => 0,
						'town' => $target_code,
					);
		$this->db->where('案件流水號', $file_key);
    	$this->db->update('files_info_table', $data);
    	return 0;
	}

	public function recive_file_update_editor($file_key,$FullName,$department,$organization){
		$data = array(
						'修改人姓名' => $FullName,
						'修改人單位' => $department,
						'修改人編號' => $organization
					);
		$this->db->where('案件流水號', $file_key);
    	$this->db->update('files_info_table', $data);
	}

	public function progress_log($file_key,$log_comment, $progress_name, $progress_level,$organization,$department,$FullName,$User_Level,$datetime){
		$data = array(
			'案件流水號' => $file_key,
			'動作者意見' => $log_comment,
			'動作名稱' => $progress_name,
			'動作後案件流程層級' => $progress_level,
			'動作者' => $FullName,
			'動作者單位' => $department,
			'動作者機關' => $organization,
			'動作者職級' => $User_Level,
			'日期時間' => $datetime
			);
		$this->db->insert('files_process_log', $data);
		$index = $this->db->insert_id();
		log_message('debug', 'file table insert_id = '. $index);
		return $index;
	}

	public function read_file_progerss_log($user_level, $user_organ,$file_key){
		$this->db->select("files_process_log.日期時間,files_process_log.動作者機關,files_process_log.動作者單位,files_process_log.動作者,files_process_log.動作者職級,files_process_log.動作名稱,files_process_log.動作後案件流程層級,files_process_log.動作者意見");
		$this->db->from('files_process_log');
		$this->db->join('files_info_table', 'files_info_table.案件流水號 = files_process_log.案件流水號');
		$this->db->join('area_town', 'area_town.Town_code = files_info_table.town');
		$this->db->where('files_process_log.案件流水號', $file_key);
		if($user_level <= 1){	
			//區公所使用者登入，應該只能看到自己公所
			$this->db->where('area_town.Town_name', $user_organ);
			

			//LV1 承辦人可以，檢視，編輯，呈核
		}
		elseif($user_level <= 3){	
			//區公所使用者登入，應該只能看到自己公所
			$this->db->where('area_town.Town_name', $user_organ);


			//LV2,3 主管可以檢視，加入意見，退回，呈核，但只能看到自己階段的檔案
			//$this->db->where('files_status_code.審批階段代號', $user_level);

		}
		elseif($user_level <= 6){	
			//市府局處以上可觀看到所有區的檔案
			//可以檢視，加入意見，退回，呈核，但只能看到自己階段的檔案
			//$this->db->where('files_status_code.審批階段代號', $user_level);


		}
		elseif($user_level <= 7){	
			//工程師模式-可完全瀏覽
			//$this->db->where('files_status_code.審批階段代號', $user_level);


		}



		
		//$this->db->where('files_info_table.案件流水號', $file_key);
		


		// ini_set('xdebug.var_display_max_depth', 5);
		// ini_set('xdebug.var_display_max_children', 256);
		// ini_set('xdebug.var_display_max_data', 1024);

		$query = $this->db->get();
		$result = $query->result_array();
		//var_dump($this->db->last_query());
		return $result;
		// var_dump($result);
			// SELECT `files_process_log`.`日期時間`, `files_process_log`.`動作者機關`, `files_process_log`.`動作者單位`, `files_process_log`.`動作者`, `files_process_log`.`動作者職級`, `files_process_log`.`動作名稱`, `files_process_log`.`動作後案件流程層級`, `files_process_log`.`動作者意見`
			// FROM `files_process_log`
			// JOIN `files_info_table` ON files_info_table.案件流水號 = files_process_log.案件流水號
			// JOIN `area_town` ON `area_town`.`Town_code` = `files_info_table`.`town`
			// WHERE `files_process_log`.`案件流水號` = 74
		
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
			'扶助級別'=>$file->level,
			'整體家況敘述-公所'=>$file->file_comm_1,
			'整體家況敘述-局處'=>$file->file_comm_2
			);

    	$this->db->where('案件流水號', $file->key);
    	$this->db->update('files_info_table', $data);		
	}

	public function update_attach($file_key, $attach_category, $attach_name){
		$column = '';
		switch($attach_category){
			case '0':
				$column = 'attach_household'; //戶口名簿
				break;
			case '1':
				$column = 'attach_income'; //所得
				break;
			case '2':
				$column = 'attach_property'; //財產
				break;
			case '3':
				$column = 'attach_statusprove'; //學生證/醫療證明
				break;
			case '4':
				$column = 'attach_others'; // 其他
				break;
		}		
		// get the original attachment name
		$this->db->select($column);
		$this->db->where('案件流水號', $file_key);
		$query = $this->db->get('files_info_table');
		
		$old_file='';
		foreach ($query->result_array() as $row){
			$old_file = $row[$column];
			log_message('debug', 'old file ='.print_r($old_file, true));
		}		

		// update to the new attachment name	
		$data = array($column => $attach_name);
		
		$this->db->where('案件流水號', $file_key);
		$this->db->update('files_info_table', $data);

		return $old_file;
	}

	/*
	*	add a 初審案件
	*/
	public function add_new_file($today, $id, $county, $town, $village, $address, $FullName, $organization, $department, $phone, $email){
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
			'聯絡電話1' => $phone,
			'email' => $email,
			'審批階段' => 1
			);
		$this->db->insert('files_info_table', $data);
		$index = $this->db->insert_id();
		log_message('debug', 'file table insert_id = '. $index);

		return $index;
	}

	/*
	*	add a 複查案件 (從初審案件/資格不符案件 複製過來)
	*/
	public function clone_file_info($file_key, $act2){
		$Qstring = "INSERT `files_info_table` (`作業類別`, `案件編號`, `案件版本號`, `源版本號`, `審批階段`, `建案日期`, `役男系統編號`, `town`, `county`, `village`, `戶籍地址`, `email`, `聯絡電話1`, `聯絡電話2`, `聯絡電話3`, `總列計人口`, `月所需`, `月總所得`, `薪資月所得`, `營利月所得`, `利息月所得`, `股利月所得`, `財產月所得`, `其他月所得`, `總動產`, `存款本金總額`, `投資總額`, `有價證券總額`, `其他動產總額`, `房屋棟數`, `房屋總價`, `房屋列計棟數`, `房屋列計總價`, `土地筆數`, `土地總價`, `土地列計筆數`, `土地列計總價`, `不動產列計總額`, `是否扶助`, `扶助級別`, `扶助用語`, `整體家況敘述-公所`, `整體家況敘述-局處`, `備註`, `修改人編號`, `修改人單位`, `修改人姓名`, `可否編修`) SELECT `作業類別`, `案件編號`, `案件版本號`, `源版本號`, `審批階段`, `建案日期`, `役男系統編號`, `town`, `county`, `village`, `戶籍地址`, `email`, `聯絡電話1`, `聯絡電話2`, `聯絡電話3`, `總列計人口`, `月所需`, `月總所得`, `薪資月所得`, `營利月所得`, `利息月所得`, `股利月所得`, `財產月所得`, `其他月所得`, `總動產`, `存款本金總額`, `投資總額`, `有價證券總額`, `其他動產總額`, `房屋棟數`, `房屋總價`, `房屋列計棟數`, `房屋列計總價`, `土地筆數`, `土地總價`, `土地列計筆數`, `土地列計總價`, `不動產列計總額`, `是否扶助`, `扶助級別`, `扶助用語`, `整體家況敘述-公所`, `整體家況敘述-局處`, `備註`, `修改人編號`, `修改人單位`, `修改人姓名`, `可否編修` FROM `files_info_table` WHERE `案件流水號` = ".$file_key ;
		//var_dump($Qstring);
		$query = $this->db->query($Qstring);
		$new_file_key = $this->db->insert_id();
		date_default_timezone_set('Asia/Taipei');
		$data = array(
			'作業類別' => $act2,
			'源版本號' => $file_key,
			'審批階段' => 1,
			'是否扶助' => null,
			'扶助級別' => "",
			'建案日期' => date("Y-m-d H:i:s")
		);

    	$this->db->where('案件流水號', $new_file_key);
    	$this->db->update('files_info_table', $data);

		$this->db->select('役男系統編號');
		$this->db->from('files_info_table');
		$this->db->where('案件流水號', $file_key);

		$query = $this->db->get();
		$result = $query->result();
		$boy_key = $result[0]->役男系統編號;

		$data = array(
			'最新案件流水號' => $new_file_key
		);

		$this->db->where('役男系統編號', $boy_key);
		$this->db->update('miliboy_table', $data);
    	return $new_file_key;
	}

	public function clone_member_info($member_key, $new_file_key){
		$Qstring = "INSERT `family_members` (`案件流水號`, `稱謂`, `姓名`, `身分證字號`, `出生日期`, `建案時年紀`, `town`, `county`, `village`, `戶籍地址`, `行業`, `職業`, `職業備註`, `所得總額`, `財產總額`, `配偶`, `前配偶`, `area`, `area_key`, `個人描述`, `特殊身分類別_前`, `特殊身分類別`, `特殊身分代號`, `特殊身分備註`, `特殊身分追蹤日期`, `聯絡電話1`, `聯絡電話2`, `聯絡電話3`, `備注`, `家況圖ID`, `家況圖X`, `家況圖Y`, `修改人編號`, `修改人單位`, `修改人姓名`) SELECT `案件流水號`, `稱謂`, `姓名`, `身分證字號`, `出生日期`, `建案時年紀`, `town`, `county`, `village`, `戶籍地址`, `行業`, `職業`, `職業備註`, `所得總額`, `財產總額`, `配偶`, `前配偶`, `area`, `area_key`, `個人描述`, `特殊身分類別_前`, `特殊身分類別`, `特殊身分代號`, `特殊身分備註`, `特殊身分追蹤日期`, `聯絡電話1`, `聯絡電話2`, `聯絡電話3`, `備注`, `家況圖ID`, `家況圖X`, `家況圖Y`, `修改人編號`, `修改人單位`, `修改人姓名` FROM `family_members` WHERE `成員系統編號` = ".$member_key ;
		//var_dump($Qstring);
		$query = $this->db->query($Qstring);
		$new_member_key = $this->db->insert_id();
		date_default_timezone_set('Asia/Taipei');

		$data = array(
			'案件流水號' => $new_file_key
		);

    	$this->db->where('成員系統編號', $new_member_key);
    	$this->db->update('family_members', $data);

    	return $new_member_key;
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

	/*
	*	讀取不同類型的案件列表
	*/

	//本機關相關的所有流程中案件列表
	public function read_file_list_progress($user_level, $user_organ){
		$this->db->select("miliboy_table.入伍日期,area_town.Town_name,miliboy_table.役男姓名,miliboy_table.身分證字號,files_info_table.審批階段,files_info_table.扶助級別,files_info_table.建案日期,files_info_table.修改人姓名,files_info_table.案件流水號,files_info_table.可否編修,`files_status_code`.`案件階段名稱`,files_type.作業類別名稱, Active_newest.最後更動時間");
		$this->db->from('files_info_table');
		$this->db->join('miliboy_table', '`miliboy_table`.`役男系統編號` = `files_info_table`.`役男系統編號`');
		$this->db->join('area_town', 'area_town.Town_code = files_info_table.town');
		$this->db->join('files_status_code', '`files_status_code`.`審批階段代號` = `files_info_table`.`審批階段`','left');
		$this->db->join('files_type', 'files_type.作業類別 = files_info_table.作業類別','left');
		$this->db->join(
			'(SELECT c.案件流水號, p1.日期時間 as 最後更動時間 
				FROM files_info_table c
				JOIN files_process_log p1 ON (c.案件流水號 = p1.案件流水號)
				LEFT OUTER JOIN files_process_log p2 ON (c.案件流水號 = p2.案件流水號 AND 
				    (p1.日期時間 < p2.日期時間 OR p1.日期時間 = p2.日期時間 AND p1.log_index < p2.log_index))
				WHERE p2.log_index IS NULL) as Active_newest
			', 
			'Active_newest.案件流水號 = files_info_table.案件流水號','left');
		
		$this->db->where('是否扶助', null);
		$this->db->where('案件刪除', 0);
		//若扶助有資料，
		if($user_level <= 3){	
			//區公所使用者登入，應該只能看到自己公所
			$this->db->where('area_town.Town_name', $user_organ);
		}
		elseif($user_level <= 6){	



		}
		elseif($user_level <= 7){	
			//工程師模式-可完全瀏覽
			//$this->db->where('files_status_code.審批階段代號', $user_level);


		}



		
		//$this->db->where('files_info_table.案件流水號', $file_key);
		


		// ini_set('xdebug.var_display_max_depth', 5);
		// ini_set('xdebug.var_display_max_children', 256);
		// ini_set('xdebug.var_display_max_data', 1024);
		//$this->db->order_by('建案日期',"DESC");
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
		// var_dump($result);
		// var_dump($this->db->last_query());

		// (SELECT c.案件流水號, p1.日期時間
		// FROM files_info_table c
		// JOIN files_process_log p1 ON (c.案件流水號 = p1.案件流水號)
		// LEFT OUTER JOIN files_process_log p2 ON (c.案件流水號 = p2.案件流水號 AND 
		//     (p1.日期時間 < p2.日期時間 OR p1.日期時間 = p2.日期時間 AND p1.log_index < p2.log_index))
		// WHERE p2.log_index IS NULL) as Active_newest

		// SELECT c.案件流水號, c.役男系統編號, p1.動作者機關, p1.動作者單位, p1.動作者, p1.動作名稱, p1.動作後案件流程層級, p1.日期時間
		// FROM files_info_table c
		// JOIN files_process_log p1 ON (c.案件流水號 = p1.案件流水號)
		// LEFT OUTER JOIN files_process_log p2 ON (c.案件流水號 = p2.案件流水號 AND 
		//     (p1.日期時間 < p2.日期時間 OR p1.日期時間 = p2.日期時間 AND p1.log_index < p2.log_index))
		// WHERE p2.log_index IS NULL;
	}

	//本機關相關的通過且扶助中案件列表
	public function read_file_list_supporting($user_level, $user_organ){
		// $this->db->select("miliboy_table.入伍日期,miliboy_table.役男生日,area_town.Town_name,miliboy_table.役男姓名,miliboy_table.身分證字號,files_info_table.審批階段,files_info_table.扶助級別,files_info_table.建案日期,files_info_table.修改人姓名,files_info_table.案件流水號,files_info_table.可否編修,`files_status_code`.`案件階段名稱`,files_type.作業類別名稱,miliboy_table.最新案件流水號");
		// $this->db->from('files_info_table');
		// $this->db->join('miliboy_table', '`miliboy_table`.`役男系統編號` = `files_info_table`.`役男系統編號`');
		// $this->db->join('area_town', 'area_town.Town_code = files_info_table.town');
		// $this->db->join('files_status_code', '`files_status_code`.`審批階段代號` = `files_info_table`.`審批階段`','left');
		// $this->db->join('files_type', 'files_type.作業類別 = files_info_table.作業類別','left');
		// $this->db->where('是否扶助', true);
		// $this->db->where('miliboy_table.退伍日期', null);

		//若扶助有資料，
		$if_town = "";

		if($user_level <= 3){	
			//區公所使用者登入，應該只能看到自己公所
			//$this->db->where('area_town.Town_name', $user_organ);
			$if_town = "AND `Town_name` = '".$user_organ."'";
		}
		elseif($user_level <= 6){	



		}
		elseif($user_level <= 7){	
			//工程師模式-可完全瀏覽
			//$this->db->where('files_status_code.審批階段代號', $user_level);


		}

			// $Qstring = "SELECT * FROM (SELECT `miliboy_table`.`入伍日期`, `miliboy_table`.`役男生日`, `area_town`.`Town_name`, `miliboy_table`.`役男姓名`, `miliboy_table`.`身分證字號`, `files_info_table`.`審批階段`, `files_info_table`.`扶助級別`, `files_info_table`.`建案日期`, `files_info_table`.`是否扶助`, `miliboy_table`.`退伍日期`, `files_info_table`.`修改人姓名`, `files_info_table`.`案件流水號`, `files_info_table`.`可否編修`, `files_status_code`.`案件階段名稱`, `files_type`.`作業類別名稱`, `miliboy_table`.`最新案件流水號` FROM `files_info_table` JOIN `miliboy_table` ON `miliboy_table`.`役男系統編號` = `files_info_table`.`役男系統編號` JOIN `area_town` ON `area_town`.`Town_code` = `files_info_table`.`town` LEFT JOIN `files_status_code` ON `files_status_code`.`審批階段代號` = `files_info_table`.`審批階段` LEFT JOIN `files_type` ON `files_type`.`作業類別` = `files_info_table`.`作業類別` order by `files_info_table`.`建案日期` asc) as `test` WHERE `test`.`是否扶助` = 1 AND `test`.`退伍日期` IS NULL ".$if_town." group by `身分證字號`";

			//$Qstring = "SELECT ps.案件流水號, ps.建案日期, ps.役男系統編號, `miliboy_table`.`入伍日期`, `miliboy_table`.`役男生日`, `area_town`.`Town_name`, `miliboy_table`.`役男姓名`, `miliboy_table`.`身分證字號`, ps.`審批階段`, ps.`扶助級別`, ps.`建案日期`, ps.`是否扶助`, `miliboy_table`.`退伍日期`, ps.`修改人姓名`, ps.`案件流水號`, ps.`可否編修`, `files_status_code`.`案件階段名稱`, `files_type`.`作業類別名稱`, `miliboy_table`.`最新案件流水號` FROM ( SELECT MAX(建案日期) as 建案日期, 役男系統編號 FROM files_info_table GROUP BY 役男系統編號) ps2 LEFT JOIN files_info_table ps USING (役男系統編號) JOIN `miliboy_table` ON `miliboy_table`.`役男系統編號` = `ps`.`役男系統編號` JOIN `area_town` ON `area_town`.`Town_code` = `ps`.`town` LEFT JOIN `files_status_code` ON `files_status_code`.`審批階段代號` = `ps`.`審批階段` LEFT JOIN `files_type` ON `files_type`.`作業類別` = `ps`.`作業類別` WHERE ps.建案日期 = ps2.建案日期 AND `ps`.`是否扶助` = 1 AND `miliboy_table`.`退伍日期` IS NULL ".$if_town." GROUP BY ps.役男系統編號";
		$localQ = "";
		if($user_level <= 3){	
			//區公所使用者登入，應該只能看到自己公所
			$localQ = "Where `Town_name` = '{$user_organ}'";
		}

		$Qstring = "
		SELECT `役男姓名`,`身分證字號`,`役男生日`,`入伍日期`,`服役軍種`,`服役狀態`,`案件流水號`,`作業類別名稱`, `建案日期`, `Town_name`, `扶助級別`, `修改人姓名`, `複查進行中` 
		FROM	
		(	
		SELECT
		`miliboy_table`.`役男姓名`, `miliboy_table`.`身分證字號`, `miliboy_table`.`役男生日`, `miliboy_table`.`入伍日期`, `miliboy_table`.`服役軍種`, `miliboy_table`.`服役狀態`, `miliboy_table`.`退伍日期`,

		case 
		    when `FTNEW`.`是否扶助` is NOT NULL then `FTNEW`.`案件流水號`
			when `FTNEW`.`是否扶助` is NULL  AND `FTOLD`.`是否扶助` is NOT NULL then `FTOLD`.`案件流水號`
		end as `案件流水號`,
		case 
		    when `FTNEW`.`是否扶助` is NOT NULL then `FTNEW`.`作業類別`
			when `FTNEW`.`是否扶助` is NULL  AND `FTOLD`.`是否扶助` is NOT NULL then `FTOLD`.`作業類別`
		end as `作業類別`,
		case 
		    when `FTNEW`.`是否扶助` is NOT NULL then `FTNEW`.`建案日期`
			when `FTNEW`.`是否扶助` is NULL  AND `FTOLD`.`是否扶助` is NOT NULL then `FTOLD`.`建案日期`
		end as `建案日期`,
		case 
		    when `FTNEW`.`是否扶助` is NOT NULL then `FTNEW`.`扶助級別`
			when `FTNEW`.`是否扶助` is NULL  AND `FTOLD`.`是否扶助` is NOT NULL then `FTOLD`.`扶助級別`
		end as `扶助級別`,
		case 
		    when `FTNEW`.`是否扶助` is NOT NULL then `FTNEW`.`修改人姓名`
			when `FTNEW`.`是否扶助` is NULL  AND `FTOLD`.`是否扶助` is NOT NULL then `FTOLD`.`修改人姓名`
		end as `修改人姓名`,
		case 
		    when `FTNEW`.`是否扶助` is TRUE then 0
			when `FTNEW`.`是否扶助` is NULL  AND `FTOLD`.`是否扶助` is NOT NULL then 1
		end as `複查進行中`,
		case 
		    when `FTNEW`.`是否扶助` is TRUE then `FTNEW`.`town`
			when `FTNEW`.`是否扶助` is NULL  AND `FTOLD`.`是否扶助` is NOT NULL then `FTOLD`.`town`
		end as `town`


		FROM `miliboy_table`
		LEFT JOIN `files_info_table` as FTNEW on `FTNEW`.`案件流水號` = `miliboy_table`.`最新案件流水號`
		LEFT JOIN `files_info_table` as FTOLD on `FTOLD`.`案件流水號` = `FTNEW`.`源版本號`

		WHERE
		(`miliboy_table`.`服役狀態` = '服役中' AND `FTNEW`.`案件刪除` = 0 AND `miliboy_table`.`役男刪除` = 0 AND `miliboy_table`.`退伍日期` IS NULL AND `miliboy_table`.`最新案件流水號` IS NOT NULL)
		AND
			((`FTNEW`.`是否扶助` IS true) OR (`FTNEW`.`是否扶助` IS NOT true AND `FTOLD`.`是否扶助` IS true))
		) as `tableQ1`
		LEFT JOIN `area_town` ON `area_town`.`Town_code` = `tableQ1`.`town`
		LEFT JOIN `files_type` ON `files_type`.`作業類別` = `tableQ1`.`作業類別` ".$localQ;	
		//$this->db->where('files_info_table.案件流水號', $file_key);
		// ini_set('xdebug.var_display_max_depth', 5);
		// ini_set('xdebug.var_display_max_children', 256);
		// ini_set('xdebug.var_display_max_data', 4096);

		//$query = $this->db->get();
		$query = $this->db->query($Qstring);
		$result = $query->result_array();
		// var_dump($this->db->last_query());
		// echo $this->db->last_query();
		return $result;
		// var_dump($result);
		// var_dump($this->db->last_query());
	}
	
	//本使用者待辦中案件列表
	public function read_file_list_pending($user_level, $user_organ){
		// $this->db
		  //       ->select('役男系統編號, Count(*) as 案件數')
		  //       ->from('files_info_table')
		  //       ->group_by('役男系統編號');
		  //       $subquery = $this->db->_compile_select();



		// $this->db->_reset_select(); 

		$this->db->select("miliboy_table.入伍日期,area_town.Town_name,miliboy_table.役男姓名,miliboy_table.役男系統編號,miliboy_table.身分證字號,files_info_table.審批階段,files_info_table.扶助級別,files_info_table.建案日期,files_info_table.修改人姓名,files_info_table.案件流水號,`TOB`.`案件數`, files_info_table.可否編修,`files_status_code`.`案件階段名稱`,files_type.作業類別名稱");
		$this->db->from('files_info_table');
		$this->db->join('miliboy_table', '`miliboy_table`.`役男系統編號` = `files_info_table`.`役男系統編號`');
		$this->db->join('area_town', 'area_town.Town_code = files_info_table.town');
		$this->db->join('files_status_code', '`files_status_code`.`審批階段代號` = `files_info_table`.`審批階段`','left');
		$this->db->join('files_type', 'files_type.作業類別 = files_info_table.作業類別','left');
		$this->db->join("(SELECT 役男系統編號, Count(*) as 案件數 FROM files_info_table GROUP BY 役男系統編號) as TOB", '`TOB`.`役男系統編號` = `files_info_table`.`役男系統編號`','left');
		$this->db->where('是否扶助', null);
		$this->db->where('案件刪除', 0);
		if($user_level <= 1){	
			//區公所使用者登入，應該只能看到自己公所
			$this->db->where('area_town.Town_name', $user_organ);

			//LV1 承辦人可以，檢視，編輯，呈核
			/*
			$this->db->where('files_status_code.審批階段代號', 1);
			$this->db->or_where('files_status_code.審批階段代號', 0);
			$this->db->or_where('files_status_code.審批階段代號', 8);
			*/
			$this->db->where_in('files_status_code.審批階段代號', array(0,1,8));


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
		elseif($user_level <= 7){	
			//工程師模式-可完全瀏覽
			//$this->db->where('files_status_code.審批階段代號', $user_level);


		}




		
		//$this->db->where('files_info_table.案件流水號', $file_key);
		


		ini_set('xdebug.var_display_max_depth', 5);
		ini_set('xdebug.var_display_max_children', 256);
		 ini_set('xdebug.var_display_max_data', 2048);

		$query = $this->db->get();
		$result = $query->result_array();
		//var_dump($this->db->last_query());
		return $result;
		// var_dump($result);
		// var_dump($this->db->last_query());
	}

	//本機關 資格不符的案件列表
	public function read_file_list_fail($user_level, $user_organ){
		$this->db->select("miliboy_table.入伍日期,area_town.Town_name,miliboy_table.役男姓名,miliboy_table.役男生日,miliboy_table.身分證字號,files_info_table.審批階段,files_info_table.扶助級別, miliboy_table.最新案件流水號, files_info_table.建案日期,files_info_table.修改人姓名,files_info_table.案件流水號,files_info_table.可否編修,`files_status_code`.`案件階段名稱`,files_type.作業類別名稱");
		$this->db->from('files_info_table');
		$this->db->join('miliboy_table', '`miliboy_table`.`役男系統編號` = `files_info_table`.`役男系統編號`');
		$this->db->join('area_town', 'area_town.Town_code = files_info_table.town');
		$this->db->join('files_status_code', '`files_status_code`.`審批階段代號` = `files_info_table`.`審批階段`','left');
		$this->db->join('files_type', 'files_type.作業類別 = files_info_table.作業類別','left');
		$this->db->where('是否扶助', 0);
		$this->db->where('案件刪除', 0);
		if($user_level <= 1){	
			//區公所使用者登入，應該只能看到自己公所
			$this->db->where('area_town.Town_name', $user_organ);
			//LV1 承辦人可以，檢視，編輯，呈核
			/*
			*/
			$this->db->where_in('files_status_code.審批階段代號', array(0,1,7,8));
		}
		elseif($user_level <= 3){	
			//區公所使用者登入，應該只能看到自己公所
			$this->db->where('area_town.Town_name', $user_organ);

		}
		elseif($user_level <= 6){	
			//市府局處以上可觀看到所有區的檔案
			//可以檢視，加入意見，退回，呈核，但只能看到自己階段的檔案
		}
		elseif($user_level <= 8){	
			//工程師模式-可完全瀏覽
			//$this->db->where('files_status_code.審批階段代號', $user_level);
		}
		//$this->db->where('files_info_table.案件流水號', $file_key);
		//ini_set('xdebug.var_display_max_depth', 5);
		//ini_set('xdebug.var_display_max_children', 256);
		//ini_set('xdebug.var_display_max_data', 2048);
		$query = $this->db->get();
		$result = $query->result_array();
		
		// var_dump($result);
		//var_dump($this->db->last_query());
		return $result;
	}
	//本機關 被刪除的案件列表
	public function read_file_list_delete($user_level, $user_organ){
		$this->db->select("miliboy_table.入伍日期,area_town.Town_name,miliboy_table.役男姓名,miliboy_table.役男生日,miliboy_table.身分證字號,files_info_table.審批階段,files_info_table.扶助級別, miliboy_table.最新案件流水號, files_info_table.建案日期,files_info_table.修改人姓名,files_info_table.案件流水號,files_info_table.可否編修,`files_status_code`.`案件階段名稱`,files_type.作業類別名稱");
		$this->db->from('files_info_table');
		$this->db->join('miliboy_table', '`miliboy_table`.`役男系統編號` = `files_info_table`.`役男系統編號`');
		$this->db->join('area_town', 'area_town.Town_code = files_info_table.town');
		$this->db->join('files_status_code', '`files_status_code`.`審批階段代號` = `files_info_table`.`審批階段`','left');
		$this->db->join('files_type', 'files_type.作業類別 = files_info_table.作業類別','left');
		$this->db->where('案件刪除', 1);
		if($user_level <= 1){	
			//區公所使用者登入，應該只能看到自己公所
			$this->db->where('area_town.Town_name', $user_organ);
			//LV1 承辦人可以，檢視，編輯，呈核
			/*
			*/
		}
		elseif($user_level <= 3){	
			//區公所使用者登入，應該只能看到自己公所
			$this->db->where('area_town.Town_name', $user_organ);

		}
		elseif($user_level <= 6){	
			//市府局處以上可觀看到所有區的檔案
			//可以檢視，加入意見，退回，呈核，但只能看到自己階段的檔案
		}
		elseif($user_level <= 8){	
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

	/*
	*	讀取立案年度的各參數  ex：低收入標準、利率
	*/
	function get_calc_LowIncome($year){
		$this->db->select('年度, 縣市, 月均所得, 不動產限額');
		$this->db->from('cnf_low_income_f1');
		$this->db->where('年度', $year);
		//$this->db->where('Login_PW', $Login_PW);
		$query = $this->db->get();
		$result = $query->result_array();
		log_message('debug', 'town query result:');
		log_message('debug', print_r($result,true));		
		return $result;
	}

	function get_calc_BankRate($year){
		$this->db->select('年度, 利率');
		$this->db->from('cnf_bank_rate');
		$this->db->where('年度', $year);
		//$this->db->where('Login_PW', $Login_PW);
		$query = $this->db->get();
		$result = $query->result();
		log_message('debug', 'town query result:');
		log_message('debug', print_r($result,true));		
		return $result;
	}

	function get_calc_Movable_Property($year){
		$this->db->select('年度, 起算額, 每人增加額');
		$this->db->from('cnf_low_income_f2');
		$this->db->where('年度', $year);
		//$this->db->where('Login_PW', $Login_PW);
		$query = $this->db->get();
		$result = $query->result();
		log_message('debug', 'town query result:');
		log_message('debug', print_r($result,true));		
		return $result;
	}

	function get_calc_Monthly_Minimum_Wage($thisdate){
		//$thisdate = $thisdate." 00:00:00";
		$this->db->select('月薪資額');
		$this->db->from('cnf_monthly_minimum_wage');
		$this->db->where('啟用日期 <=', $thisdate);
		$this->db->order_by('啟用日期', "desc");
		$this->db->limit(1);
		$query = $this->db->get();
		$result = $query->result();
		log_message('debug', 'town query result:');
		log_message('debug', print_r($result,true));		
		return $result;

	}

}