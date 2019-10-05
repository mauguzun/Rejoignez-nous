<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Aviability extends Apply_Hr_Controller
{

	protected $step = 'aviability';


	public function __construct()
	{
		parent::__construct('user/offers');

	}

	public function index($offer_id )
	{

		parent::main_aviability($offer_id,$this->apply.'/'.$offer_id);
	}





}


