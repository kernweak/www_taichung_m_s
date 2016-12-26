<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chart extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	//public function index()
	//{
	//	$this->load->view('welcome_message');
	//}
	public function pie_test()
	{
			$this->load->view('chart/pie_test');
	}
	public function pie(){
		$this->load->model('statistics_model');
		$statistics_type 	= $this->input->post('statistics_type');
		$Date_1 			= $this->input->post('Date_1')." 00:00:00" ;
		$Date_2 			= $this->input->post('Date_2')." 23:59:59";
		
		// <option value="各區案件申請數量">各區案件申請數量</option>
  //       <option value="各區核定案件數量">各區核定案件數量</option>
  //       <option value="各區核定案件扶助級別人數">各區核定案件扶助級別人數</option>
  //       <option value="全市核定案件扶助級別人數">全市核定案件扶助級別人數</option>
		$data = [];
		if($statistics_type == "各區案件申請數量"){			
			$data = $this->statistics_model->Statistics_1($Date_1,$Date_2);			
		}elseif($statistics_type == "各區核定案件數量"){			
			$data = $this->statistics_model->Statistics_2($Date_1,$Date_2);
		}elseif($statistics_type == "各區核定案件扶助級別人數"){			
			$data = $this->statistics_model->Statistics_3($Date_1,$Date_2);			
		}elseif($statistics_type == "全市核定案件扶助級別人數"){			
			$data = $this->statistics_model->Statistics_4($Date_1,$Date_2);
		}
		$this->log_activity("統計分析", "$Date_1 -> $Date_2","type=$statistics_type");
		echo json_encode($data);
	}
}
