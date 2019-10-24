<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offer extends CI_Controller
{
	private $data = [];

	private $_redirect;
	private $_table = 'offers';

	public function __construct()
	{
		parent::__construct('user/offers',FALSE);
		$this->_redirect = base_url().User_Controller::$map.'offers';
		$this->load->library("Folderoffer");
		$this->load->language('admin');
	}

	public function index($id = NULL )
	{


		// todo is active
		$offers = $this->Crud->get_joins(
			$this->_table,
			[
				"offers_location"=>"{$this->_table}.location=offers_location.id",
				'offers_activities'=>"{$this->_table}.id=offers_activities.offer_id",
				'application_contract'=>"{$this->_table}.type=application_contract.id",

				'activities'=>"offers_activities.activiti_id=activities.id",
				'function_activity'=>"activities.id=function_activity.activity_id",
				'functions'=>"functions.id=function_activity.function_id",
			],
			"offers.*, application_contract.type as contract ,offers_location.location as location ,GROUP_CONCAT(DISTINCT functions.function ) as functions ",
			["{$this->_table}.pub_date"=>'desc'],NULL,["{$this->_table}.id" => $id ]
		);
  		
/*  		var_dump($offers);
  		die();
*/


		if(count($offers) == 1)
		{
			$offer = $offers[0];

			$this->show_header([$offer['title'],$offer['title'],$offer['title']]);

			if($this->ion_auth->logged_in())
			{
				$this->show_user_menu();
			}


			$this->load->view('front_asl/offer',[
					'query'=>$offer,
					'loggined'=>$this->ion_auth->logged_in(),
					'url'=>base_url().'/apply/new/'.$this->folderoffer->get_map($offer['category']).'/index/'.$offer['id']
				]);
			$this->show_footer();
		}
		else
		{
			redirect (base_url());
		}

	}



}


