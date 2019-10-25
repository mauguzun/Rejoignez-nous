<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Hr extends  Hr_Controller{

	

	public function __construct(){
		parent::__construct('user/offers');
		$this->redirect_if_account_not_filled();	
		
	}

	public function index($offer_id = null ){
		
		
		$offer = null;
		if(!$offer_id | !$offer = $this->offer($offer_id) ){
			redirect(base_url());
		}
		
		
		
		$this->show_header([$offer['title'],$offer['title'],$offer['title']]);
		
		$this->app($offer_id);
		$this->files();
		$this->set_statuses($this->app['id']);
		  

		$header = $this->load->view('apply_final/parts/header',['offer'=>$offer,
				'offer_type'=>$this->type],true);
		$this->load->view('apply_final/hr/index',
			[
				'header'=>$header,
				'main'=>$this->get_main(),
				
				'education'=>$this->get_education(),
				'foreignlang'=>$this->get_lang(),
				'experience'=>$this->get_experience(),
				'aviability'=>$this->get_aviability(),
				'other'=>$this->get_other(),
				'covver_letter'=>$this->get_uploader('covver_letter'),			
				'cv'=>$this->get_uploader('cv'),
				
				
			]);
			
		
		
		
		
		$this->load->view('apply_final/hr/vue',[
				'applicaiton_id'=>$this->app ? $this->app['id'] :  null,
				'uploaders'=>$this->uploaders,
				'status'=>json_encode($this->statuses),
				'filled'=> $this->app['filled'] ,
			
			]);
		$this->show_footer();
	}
	
	
	
	
     
	

}


