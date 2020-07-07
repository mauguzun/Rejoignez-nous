<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*  can use admin ,and hr
*/
class Job_description extends CI_Controller
{

    public function index()
	{

		$this->show_header();
		$this->load->view('front/job_description');
		$this->show_footer();

	}

}