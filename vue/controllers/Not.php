<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Not extends CI_Controller
{

	public function __construct()
	{
		parent::__construct("user/main");
	}

	public function index()
	{
		$this->load->view('bot');

	}



}
