<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Foreignlang extends Apply_Pnc_Controller
{

	protected $step = 'foreignlang';


	public function __construct()
	{
		parent::__construct('user/offers');

	}

	public function index($offer_id )
	{
		parent::foreign_index($offer_id,$this->apply.'/'.$offer_id);
	
	}




}


