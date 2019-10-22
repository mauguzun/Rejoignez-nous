<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Pnc extends  Pnc_Conntroller{

	

	public function __construct(){
		parent::__construct('user/offers');
		$this->redirect_if_account_not_filled();	
		
	}

	public function index($offer_id = null ){
		
		
		$offer = null;
		if(!$offer_id | !$offer = $this->offer($offer_id) ){
			die('make redirect');
		}
		
		
		
		
		$this->show_header([$offer['title'],$offer['title'],$offer['title']]);
		
		$this->app($offer_id);
		$this->files();
		$this->set_statuses($this->app['id']);
		

		$header = $this->load->view('apply_final/parts/header',[
		'offer'=>$offer,
		'offer_type'=>$this->type
		
		],true);
		$this->load->view('apply_final/pnc/index',
			[
				'header'=>$header,
				'main'=>$this->get_main(),
				'eu'=>$this->get_eu(),
				'education'=>$this->get_education(),
				'foreignlang'=>$this->get_lang(),
				'aeronautical_experience'=>$this->get_aur_expirience(),
				'medical_aptitudes'=>$this->get_medical(),
				'aviability'=>$this->get_aviability(),
				'other'=>$this->get_other(),
				'covver_letter'=>$this->get_uploader('covver_letter'),			
				'cv'=>$this->get_uploader('cv'),
				'certificate_of_flang'=>$this->get_uploader('certificate_of_flang'),
				'medical_aptitude'=>$this->get_uploader('medical_aptitude'),	
				'photo_in_feet'=>$this->get_uploader('photo_in_feet'),
				'passport'=>$this->get_uploader('passport'),	
				'vaccine_against_yellow_fever'=>$this->get_uploader('vaccine_against_yellow_fever'),
				'id_photo'=>$this->get_uploader('id_photo'),
				
			]);
			
		
		
		
		
		$this->load->view('apply_final/pnc/vue',[
			'applicaiton_id'=>$this->app ? $this->app['id'] :  null,
			'uploaders'=>$this->uploaders,
			'status'=>json_encode($this->statuses),
			'filled'=> $this->app['filled'] ,
			
		]);
		$this->show_footer();
	}
	
	
	
	
     
	

}


