<?php
/**
* CodeIgniter
*
* An open source application development framework for PHP
*
* This content is released under the MIT License (MIT)
*
* Copyright (c) 2014 - 2018, British Columbia Institute of Technology
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* The above copyright notice and this permission notice shall be included in
* all copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
* THE SOFTWARE.
*
* @package    CodeIgniter
* @author    EllisLab Dev Team
* @copyright    Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
* @copyright    Copyright (c) 2014 - 2018, British Columbia Institute of Technology (http://bcit.ca/)
* @license    http://opensource.org/licenses/MIT    MIT License
* @link    https://codeigniter.com
* @since    Version 1.0.0
* @filesource
*/
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Application Controller Class
*
* This class object is the super class that every library in
* CodeIgniter will be assigned to.
*
* @package        CodeIgniter
* @subpackage    Libraries
* @category    Libraries
* @author        EllisLab Dev Team
* @link        https://codeigniter.com/user_guide/general/controllers.html
*/


require_once "controllers/Shared_Controller.php";
require_once "controllers/User_Controller.php";
require_once "controllers/Admin_Controller.php";
require_once "controllers/Usermeta_Controller.php";

require_once "controllers/Apply_Controller.php";
require_once "controllers/Apply_Hr_Controller.php";
require_once "controllers/Apply_Pnc_Controller.php";
require_once "controllers/Apply_Pnt_Controller.php";
require_once "controllers/Apply_Mechanic_Controller.php";
require_once "controllers/Apply_Un_Controller.php";

require_once "controllers/Ajax_Controller.php";

// new 
require_once "controllers/apply/Base_Apply_Controller.php";
require_once "controllers/apply/Pnc_Controller.php";
class CI_Controller{



	protected $main_settings = NULL;
	protected $meta = NULL;
	public $email_settings = NULL;

	/**
	* Reference to the CI singleton
	*
	* @var    object
	*/
	private static $instance;

	/**
	* Class constructor
	*
	* @return    void
	*/
	public function __construct(){
		self::$instance =& $this;

		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach(is_loaded() as $var => $class){
			$this->$var =& load_class($class);
		}



		$this->load =& load_class('Loader', 'core');
		$this->load->initialize();
		log_message('info', 'Controller Class Initialized');


		$this->load->library(['menu/Languagemenu','menu/Usermenu','Uploadlist']);
		if(isset($_GET['lang'])){
			$this->setLang($_GET['lang']);
		}
		else
		if( array_key_exists($this->session->userdata('lang'), $this->languagemenu->get()) ){
			$this->config->set_item('language',$this->session->userdata('lang'));
		}
		else{
			$this->setLang();
		}



		//echo lang('our_offers');


		$this->main_settings = $this->json_model->load(KEYWORDS_JSON);
		$this->meta = $this->json_model->load(GENERIC_JSON);
		$this->email_settings = $this->json_model->load(EMAIL_JSON);


		if($this->main_settings){
			date_default_timezone_set($this->main_settings['time_zone']);
		}

		$this->email_config();

		$this->load->language(['site','auth','ion_auth']);
	}


	protected function email_config(){
		$this->load->library('email');
		$config = [];
		/*$config['protocol'] = $this->email_settings['transport'];
		$config['smtp_host'] = $this->email_settings['host'];
		$config['smtp_user'] = $this->email_settings['user'];
		$config['smtp_pass'] = $this->email_settings['password'];
		$config['smtp_port'] = $this->email_settings['port'];*/
		$this->email_settings['cc'] ='mauguzun+rej@gmail.com,info@lifa.lv';
		$this->config->set_item('site_title', $this->email_settings['sender']);
		$this->config->set_item('admin_email',$this->email_settings['email']);
		$this->email->from($this->email_settings['sender'],$this->email_settings['email']);
		$this->email->initialize($config);
	}

	public function setLang($arg = 'en'){
		
	
		if(array_key_exists($arg, $this->languagemenu->get())){
			
			
			$this->session->set_userdata('lang' , $arg);
			
			// this is old shit , need remove it later
			$this->session->set_userdata('lang_code' , $arg);
			$this->config->set_item('language',$arg);
		
		}
		$this->getCurrentLang();

	}

	public function getCurrentLang(){

		return  $this->session->userdata('lang');
	}
  
	// --------------------------------------------------------------------

	/**
	* Get the CI singleton
	*
	* @static
	* @return    object
	*/
	public static function & get_instance(){
		return self::$instance;
	}

	public function show_header($meta = NULL){

		$this->load->library("menu/Topmenu");
		$this->load->library("menu/Usermenu");
  		 
  		 
		if($meta){
			$meta['title'] = lang($meta[0]);
			$meta['description'] = isset($meta[1])?  lang($meta[1]) :  lang($meta[0]);
			$meta['keywords'] = isset($meta[2]) ?  lang($meta[2]) :  lang($meta[0]);
		}
		
		
		$this->load->view('front_asl/header',
			[
				'meta'=>!$meta ? $this->meta :  $meta,
				'logo'=>  base_url().$this->uploadlist->site_img().'/'.$this->meta['logo'],
				'charset'=>!$this->main_settings? 'utf-8':$this->main_settings['charset'],
				'top_menu'=>$this->topmenu->get($this->ion_auth->logged_in()),
				'user'=>$this->ion_auth->user()->row(),
				'usermenu'=>$this->usermenu->get($this->ion_auth->user()->row()),
				'current_lang'=>$this->getCurrentLang(),
				'page'=>$this->_get_page(),				
				'asl_top_menu'=>$this->load->view('front_asl/asl/'.$this->getCurrentLang().'/topmenu',null,true),
				'lang_list'=>$this->languagemenu->get(),
			]);
	}

	public function show_header_not_translate($meta = NULL){

		$this->load->library("menu/Topmenu");

		if($meta){
			$meta['title'] = ($meta[0]);
			$meta['description'] = isset($meta[1])?  ($meta[1]) :  ($meta[0]);
			$meta['keywords'] = isset($meta[2]) ?  ($meta[2]) :  ($meta[0]);
		}
		$this->load->view('welcome/header',
			[
				'meta'=>!$meta ? $this->meta :  $meta,
				'charset'=>!$this->main_settings? 'utf-8':$this->main_settings['charset'],
				'top_menu'=>$this->topmenu->get($this->ion_auth->logged_in()),
				'user'=>$this->ion_auth->user()->row(),
				'current_lang'=>$this->getCurrentLang(),
				'page'=>$this->_get_page(),
				'logo'=>  base_url().$this->uploadlist->site_img().'/'.$this->meta['logo'],
				'lang_list'=>$this->languagemenu->get(),
			]);
	}
	protected function show_user_menu(){



		/*$this->load->view('front/parts/usermenu',[
		'page'=>$this->_get_page(),
		'user_menu'=>$this->usermenu->get(),

		]);*/
	}

	/**
	* privacy statement
	*
	* @return
	*/
	public function get_privacy(){
		$privacy = $this->Crud->get_row(['status'=>1],'privacy_statement');
		$this->load->library('Uploadlist');
		return  base_url().$this->uploadlist->get_pricacy().'/'.$privacy['file'];
	}


	protected function _get_page(){


		switch($this->uri->segment(2)){

			case "profile":
			
			return "user/profile";
			
			
			case 'login';
			return 'auth/login';


			case "appliedoffers":
			return "user/appliedoffers";

			case "unsolicited":
			return "apply/unsolicited/main";

			case "resetpassword":
			return "user/resetpassword";
		}
		switch($this->uri->segment(1)){





			//case "apply":
			//return "user/appliedoffers";
			
			
			case "policy":
	
			return "policy";
			
			case "offers":
			case "offer":
			case "apply":
			case "":
			return "offers";

			
			

			
			
		}
		
	}

	public function show_footer(){


		$this->load->view('front_asl/footer',
			[
				'asl_footer'=>$this->load->view('front_asl/asl/'.$this->getCurrentLang().'/footer',[],true),
				'privacy'=>$this->get_privacy(),

			]

		);
	}
}
