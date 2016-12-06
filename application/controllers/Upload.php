<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends MY_Controller {

	public function index(){
		$data = array('msg'=>'');
		$this->load->view('upload_form', $data);
	}

	public function do_upload(){
                $config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'gif|jpg|png|pdf';
                //$config['max_size']             = 100;
                //$config['max_width']            = 1024;
                //$config['max_height']           = 768;

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

                        //var_dump($data);
                        $this->load->view('upload_form', $data);
                }		
	}


        public function upload_file(){
        //upload file
        $config['upload_path'] = 'uploads/';
        $config['allowed_types'] = '*';
        // $config['max_filename'] = '255';
        // $config['encrypt_name'] = TRUE;
        $config['max_size'] = '4064'; //4 MB

        log_message('debug', ' FILES = '.print_r($_FILES, true));
        $category = $this->input->post('category');
        log_message('debug', ' category = '.$category);

        if (isset($_FILES['file']['name'])) {
            if (0 < $_FILES['file']['error']) {
                echo 'Error during file upload' . $_FILES['file']['error'];
            } else {
                if (file_exists('uploads/' . $_FILES['file']['name'])) {
                    echo '檔案已經存在 : ' . $_FILES['file']['name'];
                } else {
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('file')) {
                        echo $this->upload->display_errors();
                    } else {
                        echo '上傳成功: ' . $_FILES['file']['name'];
                    }
                }
            }
        } else {
            echo '請選擇一個檔案';
        }                
        }
}

// array (size=2)
//   'msg' => string '上傳成功' (length=12)
//   'upload_data' => 
//     array (size=14)
//       'file_name' => string '00011.jpg' (length=9)
//       'file_type' => string 'image/jpeg' (length=10)
//       'file_path' => string 'D:/wamp/www_taichung_m_s_88/uploads/' (length=36)
//       'full_path' => string 'D:/wamp/www_taichung_m_s_88/uploads/00011.jpg' (length=45)
//       'raw_name' => string '00011' (length=5)
//       'orig_name' => string '0001.jpg' (length=8)
//       'client_name' => string '0001.jpg' (length=8)
//       'file_ext' => string '.jpg' (length=4)
//       'file_size' => float 463.37
//       'is_image' => boolean true
//       'image_width' => int 1474
//       'image_height' => int 2023
//       'image_type' => string 'jpeg' (length=4)
//       'image_size_str' => string 'width="1474" height="2023"' (length=26)


// array (size=2)
//   'msg' => string '上傳成功' (length=12)
//   'upload_data' => 
//     array (size=14)
//       'file_name' => string 'img018.pdf' (length=10)
//       'file_type' => string 'application/pdf' (length=15)
//       'file_path' => string 'D:/wamp/www_taichung_m_s_88/uploads/' (length=36)
//       'full_path' => string 'D:/wamp/www_taichung_m_s_88/uploads/img018.pdf' (length=46)
//       'raw_name' => string 'img018' (length=6)
//       'orig_name' => string 'img018.pdf' (length=10)
//       'client_name' => string 'img018.pdf' (length=10)
//       'file_ext' => string '.pdf' (length=4)
//       'file_size' => float 129.45
//       'is_image' => boolean false
//       'image_width' => null
//       'image_height' => null
//       'image_type' => string '' (length=0)
//       'image_size_str' => string '' (length=0)