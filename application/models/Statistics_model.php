<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
class Statistics_model extends CI_Model {

    public function __construct()
    {
            parent::__construct();
    }
    //各區案件申請數量
    function Statistics_1($Date_1,$Date_2){
    	$this->db->select('area_town.Town_name, lat, lng, COUNT(*) AS amount');
    	$this->db->from('files_info_table');
    	$this->db->join('area_town', 'area_town.Town_code = files_info_table.town','left');
    	$this->db->where("`files_info_table`.`建案日期` BETWEEN '{$Date_1}' and '{$Date_2}'");
    	$this->db->group_by('town');
    	$this->db->order_by('amount');
    	$query = $this->db->get();
		
    $result = $query->result();
    log_message('debug', 'Statistics_1 result = '.print_r($result, true));
		return $result;
    }


    //各區核定案件數量
    function Statistics_2($Date_1,$Date_2){
  		//ini_set('xdebug.var_display_max_depth', 5);
		// ini_set('xdebug.var_display_max_children', 256);
		// ini_set('xdebug.var_display_max_data', 1024);
    	$Qstring = "SELECT `area_town`.`Town_name` AS `區別`, lat, lng, COUNT((case when `扶助級別` like '%甲級%' then `files_info_table`.`扶助級別` end)) as `甲級`, COUNT(case when `扶助級別` like '%乙級%' then `files_info_table`.`扶助級別` end) as `乙級`, COUNT(case when `扶助級別` like '%丙級%' then `files_info_table`.`扶助級別` end) as `丙級` from `miliboy_table` left join`files_info_table` on `files_info_table`.`案件流水號` = `miliboy_table`.`最新案件流水號` left join `area_town` on `area_town`.`Town_code` =`files_info_table`.`town` where (`files_info_table`.`建案日期` between '{$Date_1}' and '{$Date_2}') AND ( `files_info_table`.`是否扶助` = 1) AND ( `files_info_table`.`扶助級別` like '%甲級%' OR `files_info_table`.`扶助級別` like '%乙級%' OR `files_info_table`.`扶助級別` like '%丙級%' ) GROUP BY `區別`";
    	//var_dump($Qstring);
    	$query = $this->db->query($Qstring);
		$result = $query->result();
		log_message('debug', 'Statistics_2 result = '.print_r($result, true));
		return $result;
    }


    //各區核定案件扶助級別人數
    function Statistics_3($Date_1,$Date_2){
    	$Qstring = 
  "SELECT 
  	`area_town`.`Town_name` AS `區別`, lat, lng, 
  	COUNT(case when `扶助級別` like '%甲級%'      then `files_info_table`.`扶助級別` end) as `甲級`,
    COUNT(case when `扶助級別` like '%乙級%'      then `files_info_table`.`扶助級別` end) as `乙級`,
    COUNT(case when `扶助級別` like '%丙級%'      then `files_info_table`.`扶助級別` end) as `丙級`
   from
      `miliboy_table`
   left join `files_info_table` on `files_info_table`.`案件流水號`  = `miliboy_table`.`最新案件流水號`
   left join `area_town` on `area_town`.`Town_code` =`files_info_table`.`town`
   left join `family_members` on `family_members`.`案件流水號` = `files_info_table`.`案件流水號`
   where
   	  (`files_info_table`.`建案日期` between '{$Date_1}' and '{$Date_2}') AND 
      (`family_members`.`特殊身分類別` != 1) AND
      ( `files_info_table`.`是否扶助` = 1) AND (
          `files_info_table`.`扶助級別` like '%甲級%'
      OR  `files_info_table`.`扶助級別` like '%乙級%'
      OR  `files_info_table`.`扶助級別` like '%丙級%'
          )
	GROUP BY `區別`";
    	$query = $this->db->query($Qstring);
		$result = $query->result();
    log_message('debug', 'Statistics_3 result = '.print_r($result, true));
		return $result;
    }


    //各區核定案件扶助級別人數
    function Statistics_4($Date_1,$Date_2){
    	$Qstring = "SELECT case when `files_info_table`.`扶助級別` like '%甲級%' then '甲級' when `files_info_table`.`扶助級別` like '%乙級%' then '乙級' when `files_info_table`.`扶助級別` like '%丙級%' then '丙級' end as GroupName, count(*) as PostCount from `miliboy_table` left join`files_info_table` on `files_info_table`.`案件流水號` = `miliboy_table`.`最新案件流水號` left join `area_town` on `area_town`.`Town_code` =`files_info_table`.`town` left join`family_members` on `family_members`.`案件流水號` = `files_info_table`.`案件流水號` where (`files_info_table`.`建案日期` between '{$Date_1}' and '{$Date_2}') AND (`family_members`.`特殊身分類別` != 1) AND (`是否扶助` = 1) AND ( `files_info_table`.`扶助級別` like '%甲級%' OR `files_info_table`.`扶助級別` like '%乙級%' OR `files_info_table`.`扶助級別` like '%丙級%' ) GROUP BY GroupName";
    	$query = $this->db->query($Qstring);
		$result = $query->result();
    log_message('debug', 'Statistics_4 result = '.print_r($result, true));
		return $result;
    }

    
}