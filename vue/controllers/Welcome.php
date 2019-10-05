<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library("menu/Topmenu");
		$this->load->library("menu/Usermenu");
		$this->load->library("Uploadlist");
	}
	
	public function index()
	{


		$this->load->view("welcome/header",[
				'top_menu'=>$this->topmenu->get($this->ion_auth->logged_in()),
				'charset'=>!$this->main_settings? 'utf-8':$this->main_settings['charset'],
				'meta'=> $this->meta ,
				'user'=>$this->ion_auth->user()->row(), 
				'current_lang'=>$this->getCurrentLang(),
				'logo'=> base_url().$this->uploadlist->site_img().'/'.$this->meta['logo'],	
				'lang_list'=>$this->languagemenu->get(),
			]);
			
		$slides = $sliders= $this->Crud->get_all('slideshow',['status'=>1]);
		foreach($slides as &$value){
			$value['file']  = base_url().$this->uploadlist->site_img().'/'.$value['file'];
		}
		
		
		$this->load->view("welcome/welcome",
		[
			'slides'=>$slides,
			'offers'=>$this->Crud->get_joins('offers',
				['application_contract'=>'offers.type = application_contract.id '],
				'offers.*,application_contract.type as type',['offers.pub_date'=>'desc'],
				['offers.id'],['offers.status'=>1],4),
			'news'=>null,
/*			'news'=>$this->Crud->get_all('news',['published'=>1],'date','desc','*',3),*/
			
		]);
		
		
		
		$this->load->view('welcome/footer',['privacy'=>$this->get_privacy(),]);
	}



}
