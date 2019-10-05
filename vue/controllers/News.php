<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends  CI_Controller
{


    public function __construct()
    {
        parent::__construct('user/offers',FALSE);
     
    }

    public function index($id = NULL )
    {

		
		if(!$id)
			redirect(base_url());
		
		$new = $this->Crud->get_row(['id'=>$id],'news');
		if(!$new)
			redirect(base_url());
			
		
		$this->show_header([$new['title'],$new['description'],$new['title']]);
			$this->load->view('front/news',[
				'query'=>$new,
			]);
		$this->show_footer();
        
      
      
      
    }
	
	
   
}


