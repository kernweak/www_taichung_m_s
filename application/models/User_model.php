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