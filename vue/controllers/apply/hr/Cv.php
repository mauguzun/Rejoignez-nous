<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Cv extends Apply_Hr_Controller
{

	protected $step = 'cv';


	public function __construct()
	{
		parent::__construct('user/offers');

	}

	public function index($offer_id)
	{
		parent::show_upload($offer_id,$this->apply.'/'.$offer_id);
	}









}


