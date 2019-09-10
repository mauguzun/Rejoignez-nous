<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clear extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
       echo   $this->Crud->delete(['id >' => 0 ],'login_attempts');

    }



}
