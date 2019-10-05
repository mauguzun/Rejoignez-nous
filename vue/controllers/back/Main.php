<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// back / main
class Main extends Admin_Controller
{
    private $data = [];
    private $_redirect ;
    private $_table = 'activities';

    public function __construct()
    {
        parent::__construct();
        $this->_redirect = base_url().Admin_Controller::$map.'/main';
    }

    public function index()
    {
    	$this->show_header();
        $this->load->view('back/under');

    }

}
