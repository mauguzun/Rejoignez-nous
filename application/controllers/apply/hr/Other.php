<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Other extends Apply_Hr_Controller
{

	protected $step = 'other';


	public function __construct()
	{
		parent::__construct('user/offers');

	}

	public function index($offer_id )
	{

			parent::other_index($offer_id,$this->apply.'/'.$offer_id.'/'.true);
	}





}


