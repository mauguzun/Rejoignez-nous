<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// back / usser
class Settings_help extends Admin_Controller
{

	private $_fields ;
	private $_redirect;

	public function __construct()
	{
		parent::__construct();
		$this->load->library("Json_model");

		$this->_fields = ['to'=>'','cc'=>'','bcc'=>''];

	}

	public function index($contact = 'help')
	{
		// $this->load->view('back / index');
		$this->show_header();
		$this->_set_form_validation($this->_redirect);

		$this->_redirect = base_url().Admin_Controller::$map.'/settings_help/'.$contact;

		if($contact == 'contact')
		{
			$file = CONTACT_EMAIL_JSON;
		}
		else
		{
			$file = HELP_EMAIL_JSON;
		}

		if($this->form_validation->run() === TRUE)
		{
			$this->json_model->save($_POST,$file);
		}
		else
		{
			$this->session->set_flashdata('message', $this->form_validation->error_array());
		}

		$file = $this->json_model->load($file);
		$this->_set_data($file);
		   $this->load->view(Admin_Controller::$map .'/parts/add_modal_fixed',$this->data);
		$this->load->view(Admin_Controller::$map.'/parts/footer');
	}











	private function _set_form_validation($url  )
	{
		$this->data['title'] = lang('email_configuration');

		$this->data['url'] = $url;
		$this->data['buttons'] = [
			'create_and_publish'=>$url,
		];
		$this->data['cancel'] = $this->_redirect;


		$this->form_validation->set_rules('to', lang('to'), 'trim|required|valid_email');

	}



	private function _set_data($user = NULL)
	{
		$this->load->library("html/InputArray");


		foreach($this->_fields as $name=>$value)
		{


			if(isset($user[$name]))
			$value = $user[$name];





			$this->data['control']["{$name}_l"] = form_label(lang($name));
			$this->data['control'][$name] = form_input(
				$this->inputarray->getArray($name, $name == 'email' ? 'email' : 'text',lang($name),$value
					,FALSE));

		}


	}




}
