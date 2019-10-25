<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Unsolicated extends  Unsolicated_Controller{

	

	public function __construct(){
		parent::__construct('user/offers');
		$this->redirect_if_account_not_filled();	
		
	}

	public function index($app_id = null ){
		
	
		$this->show_header([lang('unsolicited_application_applys'),lang('unsolicited_application_applys'),lang('unsolicited_application_applys')]);
		
		
		if ($app_id){
			$this->app_by_id($app_id);
		}
		
		
	
		$offer = null ;
		$this->files();
		$this->set_statuses($this->app['id']);
		
		
		$header = $this->load->view('apply_final/parts/header',[
				'offer'=>$offer,
				'offer_type'=>$this->type
		
			],true);
			
			
		$all = [
			'header'=>$header,
			'main'=>$this->get_main(),
			'position'=>$this->get_position(),
			'professional'=>$this->get_professional(),
			'application_unsolicated_formattion'=>$this->get_application_unsolicated_formattion(),
			'foreignlang'=>$this->get_lang(),

			'other'=>$this->get_other()
		];
				
	
		foreach($this->uploaders as $row){
			$all[$row]=$this->get_uploader($row);
		}
		
		$this->load->view('apply_final/unsolicated/index',
			[
				'views'=>$all
			]);
			
	
		$this->load->view('apply_final/'.$this->type.'/vue',[
				'applicaiton_id'=>$this->app ? $this->app['id'] :  null,
				'uploaders'=>$this->uploaders,
				'status'=>json_encode($this->statuses),
				'filled'=>  $this->app['filled'] ,
				'type'=>$this->type,
			]);
		$this->show_footer();
	}
	
	
	
	public function start(){
		
		$this->show_header([lang('unsolicited_application_applys'),lang('unsolicited_application_applys'),lang('unsolicited_application_applys')]);


		$this->load->view('apply_final/unsolicated/question');
		$this->show_footer();
	}

}


