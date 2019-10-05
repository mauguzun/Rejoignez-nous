<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap extends  CI_Controller
{


    public function __construct()
    {
        parent::__construct('user/offers',FALSE);
     
    }

    public function index( )
    {

		
		
		
		
		$this->show_header(['sitemap']);
			$this->load->view('front/sitemap',[
				'general'=>$this->topmenu->get(false),
				'offers'=>$this->Crud->get_all('offers',['status'=>1],'pub_date','desc'),
				'news'=>$this->Crud->get_all('news',NULL,'date','desc'),
				
			]);
		$this->show_footer();
        
      
      
      
    }
	
	
   
}


