<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*  can use admin ,and hr
*/
class Job_gallery extends CI_Controller
{

    public function index()
	{

		$this->show_header();
		$this->load->view('front/job_gallery');
		$this->show_footer();

	}

}