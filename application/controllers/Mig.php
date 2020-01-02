<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mig extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		 // load migration library
        $this->load->library('migration');
        
        var_dump($this->migration->current());

        if ( ! $this->migration->current())
        {
            echo 'Error' . $this->migration->error_string();
        } else {
            echo 'Migrations ran successfully!';
        }   

	}



}
