<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Covver_letter extends Apply_Un_Controller
{

	protected $step = 'covver_letter';


	public function __construct()
	{
		parent::__construct('user/offers');

	}

	public function index()
	{
		parent::show_upload();
	}









}


