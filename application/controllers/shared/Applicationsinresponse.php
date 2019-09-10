<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// back / activity
class Applicationsinresponse extends Shared_Controller{
	private $data = [];
	private $_redirect ;

	private $_table = 'appplication';
	private $_ajax ;

	private $_allowed = [1,2,3,4,5,6,7];

	public function __construct(){
		parent::__construct($this->_allowed);
		$this->_redirect = base_url().Shared_Controller::$map.'/applicationsinresponse';
		$this->_ajax = base_url().'access/Pnt_Pnc_Hr_Admin';
	}


	public function index(){



		$this->show_header();
		$js = strip_tags($this->load->view('js/ajaxtoogle',[
					'selector'=>$this->_table,'url'=>$this->_ajax.'/toogle' ],TRUE));
		
		$type = isset($_GET)&& isset($_GET['type']) ? $_GET['type'] : NULL ;
		
		// 
		
		
		
		if($type != 'unsolicited'){
			/*$header = [
			'create_offer_pub_date' ,'create_offer_pub_date','title' ,'status' ,'function','activity'  ,'type' ,
			'period','total','not_consulted','successful_applications',
			'unsuccessful_applications','undecided_applications','interesting_for_another_position'];*/
			$header = [
				'create_offer_pub_date' ,'create_offer_pub_date' ,'status' ,'title'  ,'type' ,
				'period','total','not_consulted','successful_applications',
				'unsuccessful_applications','undecided_applications','interesting_for_another_position'];
		}
		else{
			$header = ['create_offer_pub_date'  ,'function',/*'activity'  ,*/'type' ,
				'total','not_consulted','successful_applications',
				'unsuccessful_applications','undecided_applications','interesting_for_another_position'];
		}
	
					
		
		switch($type){
			case 'unsolicited':
			$top_heder =  lang('unsolicited_application');
			break;
			
			case 'manualy':
			$top_heder =  lang('manualay_applications');
			break;
			
			default:
			$top_heder = lang('applications_in_responce');
			break;
		}
		
		$this->load->view('back/parts/datatable',[
				'headers'=>$header,
				'title' =>$top_heder,
				'url' => $this->_redirect.'/ajax/'.$type ,
				'js'=>$js,
				'add_button' =>NULL,


			]);

		$this->load->view('js/disable_add_modal')  ;
		$this->load->view('back/parts/footer');


	}




	public function ajax($app_type = NULL ){

		$this->load->model("Appresp");
		
		
		$query = $this->Appresp->get_applications($this->get_group_category());
		switch($app_type){
			case 'manualy':
			$query = $this->Appresp->get_manualy($this->get_group_category());
			break;
			
			case 'unsolicited':
			$query = $this->Appresp->get_unsolicited_new($this->get_group_category());
			break;
		}

		/*echo "<pre>";
		echo count($query);
		var_dump($query);
		die();*/


		$this->load->library('html/toogle');
		$toog = $this->toogle->init(0,'status','offers',$this->_table)->set_text(lang('pub_toogle'));
		$data['data'] = [];
		
		
		
		if($app_type == 'unsolicited'){
			
			foreach($query as $table_row){
				$row = [];
			
			
				array_push(
					$row,

					'',
					$table_row['function'],
					//$table_row['function'],
					/*lang('unsolicited_application_applys'),
					lang('unsolicited_application_applys'),
					lang('unsolicited_application_applys'),*/
				//	lang('unsolicited_application_applys'),

					$table_row['contract'],
					anchor(base_url().Shared_Controller::$map."/applications?mode=5",
						$table_row['total_application'],['target'=>'_blank'])   ,
				
					anchor(base_url().Shared_Controller::$map."/applications?mode=5&status=2",
						$table_row['not_consulted'],['target'=>'_blank'])   ,
					
					anchor(base_url().Shared_Controller::$map."/applications?mode=5&status=3",
						$table_row['successful_applications'],['target'=>'_blank'])   ,
					
					anchor(base_url().Shared_Controller::$map."/applications?mode=5&status=4",
						$table_row['unsuccessful_applications'],['target'=>'_blank'])   ,
					
					anchor(base_url().Shared_Controller::$map."/applications?mode=5&status=5",
						$table_row['undecided_applications'],['target'=>'_blank'])   ,
					
					anchor(base_url().Shared_Controller::$map."/applications?mode=5&status=6",
						$table_row['interesting_for_another_position'],['target'=>'_blank'])  
				


				);

				array_push($data['data'],$row);
			}
		}
		else{
			
			foreach($query as $table_row){
				$row = [];
			
			
				array_push(
					$row,

					$table_row['pub_date'],
					date_to_input($table_row['pub_date']),
					//	$table_row['of_title'],  
					$toog->set_flag($table_row['status'])->get($table_row['oid']),
					$table_row['of_title'],  
					//$table_row['functions'],
					//	$table_row['activities'],
					isset($table_row['contract_title']) ? $table_row['contract_title'] :  ''  ,
					$table_row['period'],
					anchor(base_url().Shared_Controller::$map."/applications?offer=".urldecode($table_row['of_title']),
						$table_row['total_application'],['target'=>'_blank'])   ,
					
					anchor(base_url().Shared_Controller::$map."/applications?offer={$table_row['of_title']}&status=2",
						$table_row['not_consulted'],['target'=>'_blank'])   ,
					
					anchor(base_url().Shared_Controller::$map."/applications?offer={$table_row['of_title']}&status=3",
						$table_row['successful_applications'],['target'=>'_blank'])   ,
					
					anchor(base_url().Shared_Controller::$map."/applications?offer={$table_row['of_title']}&status=4",
						$table_row['unsuccessful_applications'],['target'=>'_blank'])   ,
					
					anchor(base_url().Shared_Controller::$map."/applications?offer={$table_row['of_title']}&status=5",
						$table_row['undecided_applications'],['target'=>'_blank'])   ,
					
					anchor(base_url().Shared_Controller::$map."/applications?offer={$table_row['of_title']}&status=6",
						$table_row['interesting_for_another_position'],['target'=>'_blank'])  
				


				);
				
				/*	anchor(base_url().Shared_Controller::$map."/applications?offer={$table_row['of_title']}&mode=7",
				$table_row['manualay_created_applications'],['target'=>'_blank'])   */


				array_push($data['data'],$row);
			}
		}
			
		

		echo json_encode($data);   ;
	}
	private function _have($arg){

		$have = lang('yes_toogle');

		if(strpos($arg, ',')){
			$arr = explode(',',$arg);
			return max($arr) > 0  ? $have[1] : $have[0];
		}
		return $arg > 0  ? $have[1] : $have[0];

	}

}
