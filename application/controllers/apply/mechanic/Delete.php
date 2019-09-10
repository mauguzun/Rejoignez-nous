<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Delete extends Apply_Mechanic_Controller
{

	protected $step = 'delete';

	public function __construct()
	{
		parent::__construct('user/offers');

	}

	public function index($offer_id)
	{

		$app = $this->application_id($offer_id);


		$this->Crud->update(['id'=>$app['id']],['deleted'=>1],'application');
		$this->_errors[] = anchor(base_url().'user/offers/',lang('deleted'));


		redirect($this->get_page($offer_id,'main'));
	}





}


