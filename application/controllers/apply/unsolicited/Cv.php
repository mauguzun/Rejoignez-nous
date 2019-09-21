<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Cv extends Apply_Un_Controller{

	protected $step = 'cv';


	public function __construct(){
		parent::__construct('user/offers');

	}

	public function index($id = null){

		parent::show_upload($id);
	}









}


