<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Apply extends Apply_Hr_Controller{

	protected $step = 'apply';

	public function __construct(){
		parent::__construct('user/offers');

	}

	public function index($offer_id,$myStep =null){


	
		$app = $this->application_id($offer_id);
		
		
		
		$offer = $this->errors($offer_id);
		if(!$offer){
			return ;
		}

		

		$tables = $this->get_table_name();
		
	

		unset($tables['cv']);
		unset($tables['covver_letter']);
		unset($tables['main']);
		

		foreach($tables as $tab=>$table){
		
		
			if($tab == 'foreignlang'){
				$url = $this->get_page($offer_id,'other');
				redirect($url.FILL_FORM);
			}
		
			if(!$this->Crud->get_row(['application_id'=>$app['id']],$table)){
				$url = $this->get_page($offer_id,$tab);
				if($url){
					redirect($url.FILL_FORM);
				}

			}
			else if($table == 'applicaiton_misc'){
				$query = $this->Crud->get_row( ['application_id'=>$app['id']],$table);
				if($query['salary'] == null){
					$url = $this->get_page($offer_id,'other');
					redirect($url.FILL_FORM);
				}
				
			}
		}
		if($myStep != null){
			foreach(['covver_letter'] as $type){
				if(count($this->Crud->get_all('application_files',
							['application_id'=>$app['id'] ,'deleted'=>0  ,'type'=>$type])) == 0){



					$url = $this->get_page($offer_id,$type);
					if($url){
						redirect($url.FILL_FORM);
					}

				}
			}
		}
		foreach(['cv'] as $type){
			if(count($this->Crud->get_all('application_files',
						['application_id'=>$app['id'] ,'deleted'=>0  ,'type'=>$type])) == 0){
				$url = $this->get_page($offer_id,$type);
				if($url){
					redirect($url.FILL_FORM);
				}

			}
		}

		if( $this->Crud->get_row(['id'=>$app['id'],'filled'=>1],'application')){
			$this->_errors[] = anchor(base_url().'user/offers/',lang('you_are_applied'));
			//todo send email 
			$this->application_done_email();
		}else{
			$this->Crud->update(['id'=>$app['id']],['filled'=>1],'application');
			$this->_errors[] = anchor(base_url().'user/offers/',lang('you_are_applied'));
			$this->application_done_email();
		}
		redirect($this->get_page($offer_id,'main'));
		/*
		
		/*$this->show_header();
		$this->load->view('front/parts/messages',['messages'=>$this->_errors]);
		$this->show_footer();*/

	}





}


