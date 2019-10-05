<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offer extends Usermeta_Controller
{
    private $data = [];
   
    private $_redirect;
    private $_table = 'offers';

    public function __construct()
    {
        parent::__construct('user/offers',FALSE);
        $this->_user_id = $this->ion_auth->user()->row()->id;
        $this->_redirect = base_url().User_Controller::$map.'offers';
        $this->load->library("Folderoffer");
    }

    public function index($id = NULL )
    {
		
		redirect(base_url().'/offer/'.$id);
		
	/*	// todo is active 
       $offers = $this->Crud->get_joins(
        	$this->_table,
        	[
        		"offers_location"=>"{$this->_table}.location=offers_location.id",
        		'offers_activities'=>"{$this->_table}.id=offers_activities.offer_id",
				'activities'=>"offers_activities.activiti_id=activities.id",
				'function_activity'=>"activities.id=function_activity.activity_id",
				'functions'=>"functions.id=function_activity.function_id",
        	],
        	"offers.* ,offers_location.location as location ,GROUP_CONCAT(DISTINCT functions.function ) as functions ",
        	["{$this->_table}.pub_date"=>'desc'],NULL,["{$this->_table}.id" => $id ]
        );
      
        
        if (count($offers) == 1){
        	$offer = $offers[0];
        	
        	$this->show_header([$offer['title'],$offer['title'],$offer['title']]);
			$this->load->view('front/offer',[
				'query'=>$offer,
				'url'=>base_url().'/apply/'.$this->folderoffer->get_map($offer['category']).'/main/index/'.$offer['id']
			]);
			$this->show_footer();
		}
		else{
			redirect (base_url());
		}*/
      
    }
	
	
   
}


