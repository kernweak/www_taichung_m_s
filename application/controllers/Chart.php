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
		if($statistics_type == "各區案件申請數量"){
			// $data_array =
			// [
			// 	['Task', 'Hours per Day'],
   //        		['西屯區',     11],
   //        		['南屯區',      2],
   //        		['北屯區',  2],
   //        		['豐原區', 2],
   //        		['霧峰區',    7]
   //        	];
			$array1 = $this->statistics_model->Statistics_1($Date_1,$Date_2);
			$data_array2 = [['區域','件數', "{ role: 'annotation' }"]];
			foreach ($array1 as $value) {
			    $new_data = array($value['Town_name'],(int)$value['amount'],(string)$value['amount']);
			    $data_array2[] = $new_data;
			}
		}elseif($statistics_type == "各區核定案件數量"){
			$array1 = $this->statistics_model->Statistics_2($Date_1,$Date_2);
			$data_array2 = [['區域','甲級','乙級',"丙級"]];
			foreach ($array1 as $value) {
			    $new_data = array($value['區別'],(int)$value['甲級'],(int)$value['乙級'],(int)$value['丙級']);
			    $data_array2[] = $new_data;
			}
		}elseif($statistics_type == "各區核定案件扶助級別人數"){
			$array1 = $this->statistics_model->Statistics_3($Date_1,$Date_2);
			$data_array2 = [['區域','甲級','乙級',"丙級"]];
			foreach ($array1 as $value) {
			    $new_data = array($value['區別'],(int)$value['甲級'],(int)$value['乙級'],(int)$value['丙級']);
			    $data_array2[] = $new_data;
			}
		}elseif($statistics_type == "全市核定案件扶助級別人數"){
			$array1 = $this->statistics_model->Statistics_4($Date_1,$Date_2);
			$data_array2 = [['扶助級別','人數']];
			foreach ($array1 as $value) {
			    $new_data = array($value['GroupName'],(int)$value['PostCount']);
			    $data_array2[] = $new_data;
			}
		}

		

		echo json_encode($data_array2);
	}
}
