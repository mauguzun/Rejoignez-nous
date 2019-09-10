<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Total_flight_hours extends Apply_Pnt_Controller
{

	protected $step = 'total_flight_hours';


	public function __construct()
	{
		parent::__construct('user/offers');

	}

	public function index($offer_id )
	{
		parent::flight_hour_index($offer_id,$this->apply.'/'.$offer_id);
	}

	






}


