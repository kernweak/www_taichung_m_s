<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Useroos_Model extends CI_Model {
	
	function __construct(){  
        parent::__construct();  
    }

	function SQL_basic($start,$length,$search,$order_column,$order_dir){
		$col_keys = array("機關", "單位", "User_account", "User_name", "User_OU_Title", "系統等級", "帳號啟用", "User_login_time");
		

		$this->db->select("User_id, User_account, User_name, 機關, 單位, 系統等級, 帳號啟用, User_OU_code, User_OU_Title, User_login_time");
		$this->db->from("`user_oss`");
		if ($search != ''){	
			$searchs = explode(" ", $search);
			$searchs_len = count($searchs);
			for ($i=0;$i<$searchs_len;$i++){
				$this->db->where("
					User_account like '%".$searchs[$i]."%' OR 
					User_name like '%".$searchs[$i]."%' OR 
					機關 like '%".$searchs[$i]."%' OR 
					單位 like '%".$searchs[$i]."%' OR 
					系統等級 like '%".$searchs[$i]."%' OR 
					帳號啟用 like '%".$searchs[$i]."%' OR 
					User_OU_code like '%".$searchs[$i]."%' OR 
					User_OU_Title like '%".$searchs[$i]."%' OR 
					User_login_time like binary '%".$searchs[$i]."%'
					");
			}
		}

		$this->db->order_by($col_keys[$order_column]." ".$order_dir);
		$this->db->limit(intval($length), intval($start));
		$query = $this->db->get();
		$result = $query->result_array();
		$old_query_string = $this->db->last_query();

		$new_query_string = substr( $old_query_string , 0, strpos($old_query_string, 'ORDER BY') );
		$new_query_string = substr( $new_query_string , strpos($old_query_string, 'WHERE')-1 );
		$JJ = $this->db->query("SELECT COUNT(*) AS numrows FROM (`user_oss`)".$new_query_string);
		$NUMS = $JJ->row()->numrows;
		return array($NUMS,$result);
	}

	function User_Switch($User_id, $type){
		$type = filter_var($type, FILTER_VALIDATE_BOOLEAN);
		$Data = array('帳號啟用' => $type);
		$this->db->where('User_id', $User_id);
		$this->db->update('user_oss', $Data);
	}

	function User_level($User_id, $User_level){
		//$type = filter_var($type, FILTER_VALIDATE_BOOLEAN);
		$Data = array('系統等級' => (int)$User_level);
		$this->db->where('User_id', $User_id);
		$this->db->update('user_oss', $Data);
	}


}