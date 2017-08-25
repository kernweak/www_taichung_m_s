<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
class User_model extends CI_Model {

    public function __construct()
    {
            parent::__construct();
    }
    //帳密登入
    function Login_PW_select($Login_ID, $Login_PW){
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('user_id', $Login_ID);
		$this->db->where('user_pw', $Login_PW);
		//$this->db->where('Login_PW', $Login_PW);
		$query = $this->db->get();
		return $query;
	}

	function User_PW_Error_Read($Login_ID){
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('user_id', $Login_ID);
		//$this->db->where('Login_PW', $Login_PW);
		$query = $this->db->get();
		return $query;
	}

	//E化入口網登入
	function Login_IDNM_select($Login_ID, $Login_NM){
		$this->db->select('*');
		$this->db->from('user_oss');
		$this->db->where('User_account', $Login_ID);
		$this->db->where('User_name', $Login_NM);
		//$this->db->where('Login_PW', $Login_PW);
		$query = $this->db->get();
		return $query;
	}

	function Check_Dept_OU_ext($OU){
		$this->db->select('*');
		$this->db->from('ad_ou');
		$this->db->where('OU_DeptCode', $OU);
		$query = $this->db->get();
		if($query->num_rows() == 1){
			$row = $query->row(1);
			return $row;
		}
		//array(1,"使用者登入錯誤之紀錄已更新")
		return array("OU_DeptCode" => 0);
	}

	function Find_Organ_by_OU($OU){
		$OU = substr($OU, 4);
		$this->db->select('*');
		$this->db->from('ad_ou');
		$this->db->like('OU_DeptCode', $OU);
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			$row = $query->row(1);
			return $row;
		}
		//array(1,"使用者登入錯誤之紀錄已更新")
		return array("OU_OrganCode" => 0);
	}

	function Insert_Update_ON_DUPLICATE($Table_name, $Insert_Val, $Update_Val){
		//ini_set('xdebug.var_display_max_depth', 5);
		//ini_set('xdebug.var_display_max_children', 3000);
		//ini_set('xdebug.var_display_max_data', 3000);
		$Insert_Col = array_keys($Insert_Val);
		$Update_Col = array_keys($Update_Val);
		$SQL_String ="INSERT INTO `".$Table_name."` (";
		for ($i=0;$i<count($Insert_Col);$i++){
			$SQL_String .= "`".$Insert_Col[$i]."`";
			if($i<(count($Insert_Col)-1)){
				$SQL_String .= ", ";
			}
		}
		$SQL_String .= ") VALUES(";
		for ($i=0;$i<count($Insert_Col);$i++){
			$SQL_String .=  "'".$Insert_Val[$Insert_Col[$i]]."'";
			if($i<(count($Insert_Col)-1)){
				$SQL_String .= ", ";
			}
		}
		$SQL_String .= ") ON DUPLICATE KEY UPDATE ";
		for ($i=0;$i<count($Update_Col);$i++){
		
			$SQL_String .= "`".$Update_Col[$i]."` = '".$Update_Val[$Update_Col[$i]];
			
			if($i<(count($Update_Col)-1)){
				$SQL_String .= "', ";
			}else{
				$SQL_String .= "'";
			}
		}
		
		//var_dump($SQL_String);
		//echo $SQL_String."<br><br>";
		
		if($this->db->query($SQL_String)){
			return $this->db->affected_rows();
		}
		else{
			return (-1);
		}
	
		/*
		INSERT INTO `scan_doc` (`檔號`, `年度號`, `分類號`, `案次號`, `卷次號(文字)`, `卷次號`, `目次號`, `收文字號`, `案由`, `主要來文者`, `來文字號`, `主辦單位`, `主辦人員`)
		VALUES("103/100219/1/0001/1", 103, "100219", 1, "0001", 1, 1, "A61030008422", "主計人員102年考績案、考績升等及考績俸級變更案", "臺中市政府主計處", "字第1030002931號", "會計室", "林秀珍") 
		ON DUPLICATE KEY UPDATE `收文字號` = 'A61030008422' , `案由` = '主計人員102年考績案、考績升等及考績俸級變更案' , `主要來文者` = '臺中市政府主計處' , `來文字號` = '字第1030002931號' , `主辦單位` = '會計室' , `主辦人員` = '林秀珍' 
		*/

	}






	function User_checkPW($Login_ID, $FullName, $Login_PW0){
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('user_id', $Login_ID);
		$this->db->where('user_pw', $Login_PW0);
		$this->db->where('姓名', $FullName);
		//$this->db->where('Login_PW', $Login_PW);
		$query = $this->db->get();
		return $query;
	}

	function User_updatePW($Login_ID, $FullName, $Login_PW0, $Login_PW1){
		$datetime1 = new DateTime("now");
		$data = array(    		
    		'user_pw' => $Login_PW1,
    		'上次修改密碼' => $datetime1->format('Y-m-d H:i:s')
    	);
    	$this->db->where('user_id', $Login_ID);
		$this->db->where('user_pw', $Login_PW0);
		$this->db->where('姓名', $FullName);
    	$this->db->update('user', $data);

    	//更新密碼之後，再做一次查詢
    	$this->db->select('*');
		$this->db->from('user');
		$this->db->where('user_id', $Login_ID);
		$this->db->where('user_pw', $Login_PW1);
		$this->db->where('姓名', $FullName);
		//$this->db->where('Login_PW', $Login_PW);
		$query = $this->db->get();
		return $query;
	}

	function User_PW_Error_Write($Login_ID, $data){
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('user_id', $Login_ID);
		//$this->db->where('Login_PW', $Login_PW);
		$query = $this->db->get();
		if ($query->num_rows() > 1){
			return array(0,"帳號不是唯一，寫入失敗");
		}

    	$this->db->where('user_id', $Login_ID);
    	$this->db->update('user', $data);

		return array(1,"使用者登入錯誤之紀錄已更新");
	}
}