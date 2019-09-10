<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Vaccine_against_yellow_fever extends Apply_Pnt_Controller
{

	protected $step = 'vaccine_against_yellow_fever';


	public function __construct()
	{
		parent::__construct('user/offers');

	}

	public function index($offer_id)
	{
		parent::show_upload($offer_id);
	}









}


