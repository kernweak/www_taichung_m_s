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

}