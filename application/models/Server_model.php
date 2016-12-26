<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
class Server_model extends CI_Model {

    public function __construct(){
    	parent::__construct();
    }

	public function get_Server_Config($parameter){
        $this->db->select('`值`');
        $this->db->from('server_config');
		$this->db->where('參數', $parameter);
		$result = $this->db->get()->row();	
		return $result->值;
	}
}