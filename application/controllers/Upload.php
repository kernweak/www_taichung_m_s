<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends MY_Controller {

	public function index(){
		$data = array('msg'=>'');
		$this->load->view('upload_form', $data);
	}

	public function do_upload(){

                $config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 100;
                $config['max_width']            = 1024;
                $config['max_height']           = 768;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile'))
                {
                        $error = array('msg' => $this->upload->display_errors());

                        $this->load->view('upload_form', $error);
                }
                else
                {
                        $data = array(
                        	'msg' => '上傳成功',
                        	'upload_data' => $this->upload->data()
                        	);

                        $this->load->view('upload_form', $data);
                }		
	}
}
