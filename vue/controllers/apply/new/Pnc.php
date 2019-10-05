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
			die();
		}
		
		
		
		//page 
		$this->show_header([$offer['title'],$offer['title'],$offer['title']]);
		
		// form 
		$header = $this->load->view('apply_final/parts/header',['offer'=>$offer],true);
		$this->load->view('apply_final/pnc/pnc',
		[
			'header'=>$header,
			'main'=>$this->get_main(),
			
		
		]);
		
		$this->load->view('apply_final/pnc/vue');
		$this->show_footer();
	}
     
	

}


