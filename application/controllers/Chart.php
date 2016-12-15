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
		$statistics_type = $this->input->post('statistics_type');
		$data_array2 = [['區域','件數', "{ role: 'annotation' }"]];



		if($statistics_type == "各區案件申請數量"){
			$data_array =
			[
				['Task', 'Hours per Day'],
          		['西屯區',     11],
          		['南屯區',      2],
          		['北屯區',  2],
          		['豐原區', 2],
          		['霧峰區',    7]
          	];
			$array1 = $this->statistics_model->Statistics_1("","");
			//$data_array =  (array) $array1;
     
        	//var_dump($statistics_type);

			foreach ($array1 as $value) {
			    //$value = $value * 2;
			    $new_data = array($value['Town_name'],(int)$value['amount'],(string)$value['amount']);
			    $data_array2[] = $new_data;
			}


        	 // var_dump($array1);
        	 // var_dump($data_array);
        	 // var_dump($data_array2);
		}
		

		echo json_encode($data_array2);
	}
}
