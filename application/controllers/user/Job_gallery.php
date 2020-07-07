<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_gallery extends User_Controller
{
	public function index()
	{
		$this->load->view('front/job_gallery');
		$this->show_footer();
	}
}


