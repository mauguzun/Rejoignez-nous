<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends  CI_Controller
{


    public function __construct()
    {
        parent::__construct('user/offers',FALSE);
     
    }

    public function index($id = NULL )
    {

		
        $this->load->view('js/fastsearch',['name'=>'sd','data'=>['id'=>'denis']]);
      
      
      
    }
	
	
   
}


