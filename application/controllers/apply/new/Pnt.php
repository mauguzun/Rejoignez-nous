<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Pnt extends  Pnt_Controller{

	

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
			
			
		$all = [
			'header'=>$header,
			'main'=>$this->get_main(),
			'eu'=>$this->get_eu(),	
			'foreignlang'=>$this->get_lang(),
			'licenses'=>$this->get_license(),
			'medical_aptitudes'=>$this->get_medical(),
			'practice'=>$this->get_practice(),
			'qualification_type'=>$this->get_quality(),
			'total_flight_hours'=>$this->get_exp('total_flight_hours'),
			'expirience'=>$this->get_exp('expirience'),
			'experience_in_instructor'=>$this->get_experience_in_instructor(),
			'successive_employer'=>$this->get_successive_employer(),
			'complementary_informations'=>$this->get_main()];
			
	
		foreach($this->uploaders as $row){
			$all[$row]=$this->get_uploader($row);
		}
		
		$this->load->view('apply_final/pnt/index',
			[
				'views'=>$all
			]);
			
		
		
		
		$this->load->view('apply_final/'.$this->type.'/vue',[
				'applicaiton_id'=>$this->app ? $this->app['id'] :  null,
				'uploaders'=>$this->uploaders,
				'status'=>json_encode($this->statuses),
				'filled'=> $this->app['filled'] ,
				'type'=>$this->type,
			]);
		$this->show_footer();
	}
	
	
	
	
     
	

}


