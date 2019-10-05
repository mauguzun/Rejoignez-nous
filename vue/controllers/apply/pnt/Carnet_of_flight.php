<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Carnet_of_flight extends Apply_Pnt_Controller
{

	protected $step = 'carnet_of_flight';


	public function __construct()
	{
		parent::__construct('user/offers');

	}

	public function index($offer_id)
	{
		parent::show_upload($offer_id,$this->apply.'/'.$offer_id);
	}









}


