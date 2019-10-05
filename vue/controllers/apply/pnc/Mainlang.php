<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Mainlang extends Apply_Pnc_Controller
{

	protected $step = 'mainlang';


	public function __construct()
	{
		parent::__construct('user/offers');

	}

	public function index($offer_id )
	{
		parent::mainlang_index($offer_id);
	
	}


	




}


