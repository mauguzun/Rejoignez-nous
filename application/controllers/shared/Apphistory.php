<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// back / activity
class Apphistory extends Shared_Controller
{
	private $data = [];

	private $_table = 'application_history';
	private $_allowed = [1,2,3,4,5,6,7];

	public function __construct()
	{
		parent::__construct($this->_allowed);
		$this->_redirect = base_url().Shared_Controller::$map.'/apphistory/';
		$this->_ajax = base_url().'access/Hr_Admin';
		$this->load->language('site');
	}


	public function index($app_id)
	{
		
		
		$app = $this->Crud->get_row(['id'=>$app_id],'application');
		if (!$app){
			redirect(base_ur());
		}
		$this->show_header();
		

		$this->load->view('back/parts/datatable',[
				'headers'=>['action','date','status','old_value'],
				'title' =>lang('activity_manager'),
				'url' => $this->_redirect.'/ajax/'.$app_id,
				'add_button' => $this->_redirect.'/add',
				'js'=>NULL,
			]);

		
		$this->load->view('back/parts/footer');



	}










	public function ajax($app_id)
	{



		$query = $this->Crud->get_all($this->_table,['application_id'=>$app_id],'date','desc');




		$data['data'] = [];
		foreach($query as $row){

			if($row['table'] == 'application_files'){
				$data['data'][$row['row']]['action'] = 0;
				$data['data'][$row['row']]['date'] = $row['date'];
				
				
				$file = $this->Crud->get_row(['id'=>$row['select_value']],'application_files');
				$data['data'][$row['row']]['value'] = anchor(
					base_url().'user/getfile?url='.$file['file'],'file marked as deleted',['target'=>'_blank','download'=>''])  ;
				   
				
				//$data['data'][$row['row']]['table'] = $row['table'];
			}
			else
			{
				if(isset($data['data'][$row['row']])){
					if($row['action'] == 0 )
					{
						$data['data'][$row['row']]['action'] = 0;
					}
					$data['data'][$row['row']]['value'] .= $this->_n($row['column'],$row['old_value']).
					$this->_v($row['column'],$row['old_value'],$row['table']) ;
					//$data['data'][$row['row']]['table'] = $row['table'];
				}
				else
				{
					$data['data'][$row['row']] = [];
					$data['data'][$row['row']]['action'] = $row['action'];
					$data['data'][$row['row']]['date'] = $row['date'];
					//$data['data'][$row['row']]['table'] = $row['table'];
					$data['data'][$row['row']]['value'] = 
					$this->_n($row['column'],$row['old_value']).
					$this->_v($row['column'],$row['old_value'],$row['table']) ;
				}
			}
		}
		
		$show=  [];
		$show['data'] = [];
		foreach($data['data'] as $value){
			
			$action = ($value['action'] == 0 )? '<i class="fa fa-trash"></i>' : '<i class="far fa-edit"></i>';
			array_push($show['data'],[$value['date'],$value['date'],$action,$value['value']]);
		}
		
		
		echo json_encode($show);
	}

	private function _n($arg,$value)
	{
		if(!empty($value))
		return "<br>    <strong>".lang($arg)."</strong>  ";
	}


	private function _v($column,$value,$table)
	{
	 //	echo $column.'-'.$value.'-'.$table."<br>";

		switch($column){
			case 'car':
			case 'eu_nationality':
			case 'can_work_eu':
			case 'employ_center':
			case 'part_66_license':
			case 'licenses_b1':
			case 'licenese_b2':
			case 'aeronautical_baccalaureate':
			case 'complementary_mention_b1':
			case 'complementary_mention_b2':
			case 'theoretical_atpl':
			case 'mcc':
			return $this->_have($value);
			break;

			case 'english_level' :
			case 'french_level' :
			case 'level_id' :
			case 'lang_level' :

			return $this->_lang_level($value);
			break;

			case 'education_level_id':
			return $this->_education($value);
			break;
			
			case 'b737_classic':
			case 'b737_ng':
			return $this->_boing($value);
			break;
			
			case 'managerial':
			case 'managerial_duties':
			return $this->_managerial($value);
			
			
		
			case 'contract_id':
			return $this->_contract($value);
		
            case 'duration':
            if($table == 'aeronautical_experience')
           		 return $value;
            else
           		 return $this->_duration($value);

			case 'country_id' :
			return $this->_country($value);

			default:
			return $value;
		}
	}
	
	private function  _boing($arg)
	{
		if(!isset( $this->data['type'])){
			$this->data['boing'] = [];
			foreach($this->Crud->get_all('mechanic_offer_managerial') as $value){
				$this->data['boing'][$value['id']] = $value['duration'];
			}
		}
		return $this->data['boing'][$arg];
	}
	
	private function  _contract($arg)
	{
		if(!isset( $this->data['type'])){
			$this->data['type'] = [];
			foreach($this->Crud->get_all('application_contract') as $value){
				$this->data['type'][$value['id']] = $value['type'];
			}
		}
		return $this->data['type'][$arg];
	}
	
	private function  _duration($arg)
	{
		if(!isset( $this->data['duration'])){
			$this->data['duration'] = [];
			foreach($this->Crud->get_all('expirience_duration') as $value){
				$this->data['duration'][$value['id']] = $value['duration'];
			}
		}
		return $this->data['duration'][$arg];
	}
	
	private function  _managerial($arg)
	{
		if(!isset( $this->data['managerial'])){
			$this->data['managerial'] = [];
			foreach($this->Crud->get_all('expirience_managerial') as $value){
				
				$this->data['managerial'][$value['id']] = $value['managerial'];
			}
		}
		
		return $this->data['managerial'][$arg];
	}
	
	private function _country($arg)
	{
		if(!isset($this->data['country'])){
			$this->data['country'] = [];
			foreach($this->Crud->get_all('country_translate',['code'=>$_SESSION["lang"]]) as $value){
				$this->data['country'][$value['country_id']] = $value['name'];
			}
		}

		return $this->data['country'][$arg];
	}

	private function _education($arg)
	{
		if(!isset( $this->data['education'])){
			$this->data['education'] = [];
			foreach($this->Crud->get_all('hr_offer_education_level') as $value){
				$this->data['education'][$value['id']] = $value['level'];
			}
		}
		return $this->data['education'][$arg];
	}

	private function _lang_level($arg)
	{
		if(!isset( $this->data['language_level'])){
			$this->data['language_level'] = [];
			foreach($this->Crud->get_all('language_level') as $value){
				$this->data['language_level'][$value['id']] = $value['level'];
			}
		}
		return $this->data['language_level'][$arg];
	}


	private function _have($arg)
	{

		$have = lang('yes_toogle');

		if(strpos($arg, ',')){
			$arr = explode(',',$arg);
			return max($arr) > 0  ? $have[1] : $have[0];
		}
		return $arg > 0  ? $have[1] : $have[0];

	}
}
