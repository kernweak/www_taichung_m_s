<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attachment extends MY_Controller {

    public function upload(){
        log_message('debug', ' FILES = '.print_r($_FILES, true));        
        
        $config['upload_path'] = 'uploads/';
        $config['allowed_types'] = 'pdf';
        // $config['max_filename'] = '255';
        // $config['encrypt_name'] = TRUE;
        $config['max_size'] = '16384'; //8MB

        /*  rename the uploaded attachment to [fileid_category_timestamp]
        *   category的數字代表
        *   0:戶口名簿, 1:所得, 2:財產, 3:學生證/醫療證明, 4:其他
        */
        $file_id = $this->input->post('file_id');
        $category = $this->input->post('category');    
        $new_name = $file_id.'_'.$category.'_'.time();
        log_message('debug', 'new file name = '.$new_name);

        $config['file_name']= $new_name;        
        if (isset($_FILES['attachment']['name'])) {
            if (0 < $_FILES['attachment']['error']) {
                echo '檔案上傳發生錯誤: ' . $_FILES['attachment']['error'];
            } else {
                if (file_exists('uploads/' . $_FILES['attachment']['name'])) {
                    echo '檔案已經存在: ' . $_FILES['attachment']['name'];
                } else {
                    $this->load->library('upload', $config);
                    // $this->upload->initialize($config);
                    if (!$this->upload->do_upload('attachment')) {
                        echo $this->upload->display_errors();
                    } else {
                        $upload_name = $this->upload->data()['file_name'];
                        echo '上傳成功: ' . $_FILES['attachment']['name']. '<br>新檔名: '.$upload_name;                        
                        //1. update database record 2. delete previous file
                        $this->update($file_id, $category , $upload_name);
                    }
                }
            }
        } else {
            echo '請選擇一個檔案';
        }                
    }

    /*
    1. update database to store the new attachment file name. 
    2. delete old attachment file
    */
    function update($file_key, $category, $attchment_name){
        $this->load->model('file_model');
        $old_attach = $this->file_model->update_attach($file_key, $category, $attchment_name);
        $this->log_activity("uploaded an attachment", "file_key=$file_key", "attachment=$attchment_name");
        
        if (!empty($old_attach)){
            //delete old file
            log_message('debug', 'deleting old attachment: '. $old_attach);
            if (file_exists('uploads/' . $old_attach)) {
                unlink('uploads/' . $old_attach); //delete
                log_message('debug', 'deleted: '. $old_attach);
            }
        }
    }
}
