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
			redirect(base_url());
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
			'education'=>$this->get_education(),
			'foreignlang'=>$this->get_lang(),
			'aeronautical_experience'=>$this->get_aur_expirience(),
			'medical_aptitudes'=>$this->get_medical(),
			'complementary_informations'=>$this->get_complementary_informations()] ;
				
	
		foreach($this->uploaders as $row){
			$all[$row]=$this->get_uploader($row);
		}
		
		$this->load->view('apply_final/pnc/index',
			[
				'views'=>$all
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


