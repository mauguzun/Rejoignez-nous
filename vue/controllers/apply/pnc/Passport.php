<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Passport extends Apply_Pnc_Controller
{

	protected $step = 'passport';


	public function __construct()
	{
		parent::__construct('user/offers');

	}

	public function index($offer_id)
	{
		parent::show_upload($offer_id,$this->apply.'/'.$offer_id);
	}









}


