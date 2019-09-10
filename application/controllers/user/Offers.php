<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offers extends User_Controller
{
	private $data = [];
	private $_user_id;
	private $_redirect;
	private $_table = 'offers';

	public function __construct()
	{
		parent::__construct('user/offers',['offer_list','offer_list','offer_list']);
		$this->_user_id = $this->ion_auth->user()->row()->id;
		$this->_redirect = base_url().User_Controller::$map.'offers';
	}

	public function index()
	{


		$offers = $this->Crud->get_joins(
			$this->_table,
			["offers_location"=>"{$this->_table}.location=offers_location.id"],
			"{$this->_table}.*,offers_location.location as location",
			["{$this->_table}.pub_date"=>'desc'],NULL,["{$this->_table}.status" => 1]
		);

		$this->load->view('front/offer_list',[
				'query'=>$offers
			]);
		$this->show_footer();
	}



}


