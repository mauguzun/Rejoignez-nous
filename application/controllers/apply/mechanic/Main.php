<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Main extends Apply_Mechanic_Controller
{

	protected $step = 'main';


	public function __construct()
	{
		parent::__construct('user/offers');

	}

	public function index($offer_id)
	{
		
		parent::main_index($offer_id,$this->apply.'/'.$offer_id);
	}










}


