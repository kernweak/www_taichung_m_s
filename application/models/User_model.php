<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
class User_model extends CI_Model {

    public function __construct()
    {
            parent::__construct();
    }
    function Login_PW_select($Login_ID){
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('user_id', $Login_ID);
		//$this->db->where('Login_PW', $Login_PW);
		$query = $this->db->get();
		return $query;
	}


}