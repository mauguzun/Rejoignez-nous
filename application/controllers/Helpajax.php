<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Helpajax extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
	}
	

	public function form($contact = NULL)
	{
	
		
		$user = $this->ion_auth->user()->row();

		
		$candidate  = isset($user) ? $this->Crud->get_row(['user_id'=>$user->id],'candidates') : NULL ;
		
		$this->load->view('front/helpform',
			[
				'url'=>base_url().'helpajax/send/'.$contact,
				'email'=>$user?(string)$user->email:NULL,
				'candidate' => $candidate
			]
		);

	}
	public function send($contact = NULL)
	{


		$this->load->library('email',[
		  'protocol'=>$this->email_settings['transport']
		]);

		$this->email->from($this->email_settings['email'],$this->email_settings['sender']);


		$this->load->library("json_model");


		if($contact == 'help')
		{
			$file = $this->json_model->load(HELP_EMAIL_JSON);
		}
		else
		{  
        	$file = $this->json_model->load(CONTACT_EMAIL_JSON);
		}

		if($file['to'])
		{
			$this->email->to($file['to']);
		}
		else
		{
			$this->email->to($this->email_settings['email']);
		}
		
		
		if($file['cc'])
		{
			$this->email->cc($file['cc']);
		}
		if($file['bcc'])
		{
			$this->email->bcc($file['bcc']);
		}



		$this->email->reply_to($_POST['email'],$_POST['name']);

		$this->email->subject($_POST['subject']);
		$this->email->message($_POST['comment']);

		if(!$this->email->send())
		{
			echo  json_encode (['resp'=> lang("somthig_go_wrong")]);
		}
		else
		{
			echo  json_encode (['resp'=> lang("you_message_sended")]);
		}


	}


}
