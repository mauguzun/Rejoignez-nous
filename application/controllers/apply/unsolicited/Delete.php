<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Delete extends Apply_Hr_Controller{

	protected $step = 'delete';

	public function __construct(){
		parent::__construct('user/offers');

	}

	public function index($offer_id = NULL){

		if($offer_id){
			$this->Crud->update(['id'=>$offer_id],['deleted'=>1],'application');
			$this->_errors[] = anchor(base_url().'user/offers/',lang('deleted'));

			
		}
		



		redirect(base_url().'apply/unsolicited/main');
	}





}


