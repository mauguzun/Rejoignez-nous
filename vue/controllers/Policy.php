<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Policy extends  CI_Controller
{


    public function __construct()
    {
        parent::__construct('user/offers',FALSE);
     
    }

    public function index( )
    {

		
		
		$this->load->library('Uploadlist');	
		
		$this->show_header(['our_recruitment_policy']);
			$this->load->view('front/hiring_policy',[
				'query'=>$this->Crud->get_row(['id'=>1],'hiring_policy'),
				'img'=>base_url().$this->uploadlist->site_img().'/',
			]);
		$this->show_footer();
        
      
      
      
    }
	
	
   
}


