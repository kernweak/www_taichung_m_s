<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ftp extends MY_Controller {

	public function __construct() { 
        parent::__construct(); 
        $this->load->library('ftp');
        date_default_timezone_set("asia/taipei");
     } 

    public function FTP_backup(){				//檔案應用影像列印(檔案列印.功能 )
		//echo "TEST";
    	$DBfilename='MFST_DB_Backup_'.date('Y-m-d').'.zip';
		$ImgFilename='MFST_IMG_Backup_'.date('Y-m-d').'.zip';
		$OutTemp_Path = "C:\MFST_Backup\TEMP";
		$date = DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
		$date->modify('-7 day');
		$DBfileDel='MFST_DB_Backup_'.$date->format('Y-m-d').'.zip';
		$ImgFileDel='MFST_IMG_Backup_'.$date->format('Y-m-d').'.zip';

		echo $DBfilename;
		echo $ImgFilename;
		echo $DBfileDel;
		echo $ImgFileDel;




		$config['hostname'] = '172.18.106.43';
		$config['username'] = 'civil-xitun';
		$config['password'] = 'Civil*1060726';
		$config['debug']	= TRUE;

		$this->ftp->connect($config);

		//$this->ftp->upload('/local/path/to/myfile.html'，'/public_html/myfile.html'，'ascii'，0775);
		
		$this->ftp->upload('/MFST_Backup/ZIP/'.$DBfilename,'/'.$DBfilename);
		$this->ftp->upload('/MFST_Backup/ZIP/'.$ImgFilename,'/'.$ImgFilename);
		$this->ftp->delete_file('/'.$DBfileDel);
		$this->ftp->delete_file('/'.$ImgFileDel);
		//$list = $this->ftp->list_files('/');

		//$this->ftp->mirror('/MFST_Backup/','/ZIP/');

		//print_r($list);

		$this->ftp->close();

		
			
	}
		
	
}