<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
class Activitylog_model extends CI_Model {

    public function __construct(){
            parent::__construct();
    }

    /**
    	add a log entry
 	*/
    public function add($log){
		$this->db->insert('activity_log', $log); 
	}
	
	public function UserSessionUpdate($UserOnline){
		$this->db->where('User_account', $UserOnline['User_account']);
		$this->db->where('User_name', $UserOnline['User_name']);
		$Update['User_update'] = $UserOnline['User_update'];
		$this->db->update('user_oss', $Update);
		
	}

}