<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// back / activity
class User extends Shared_Controller{
	private $data = [];
	private $_redirect ;

	private $_table = 'users';
	private $_allowed = [1,2,3,4,5,6,7];
	private $_ajax;

	public $user_id;

	public function __construct(){
		parent::__construct($this->_allowed);
		$this->_redirect = base_url().Shared_Controller::$map.'/user';
		$this->_ajax = base_url().'access/Hr_Admin';

		$this->user_id = (string)$this->ion_auth->user()->row()->id;;
	}


	public function index(){

		$this->show_header();
		$this->_set_form_validation();
		$this->_set_data($this->Crud->get_row(['user_id'=>$this->user_id],'candidates'));
		$this->load->view(Admin_Controller::$map .'/parts/add_modal_fixed',$this->data);
		$this->data['title'] = lang("edit_profile");
		//$this->show_footer();
		

	}

	public function insert(){

		$this->_set_form_validation($this->_redirect.'/insert/');


		if($_POST['email'] != $this->ion_auth->user()->row()->email){


			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email|is_unique[users.email]');

		}

		if($this->form_validation->run() === TRUE){

			$this->Crud->update_or_insert(
				[
					'user_id'=>$this->user_id,
					'first_name'=>$_POST['first_name'],
					'last_name'=>$_POST['last_name'],
					'birthday'=>date_to_db($_POST['birthday']),
				]
				,'candidates');
				
			if($_POST['email'] != $this->ion_auth->user()->row()->email && 
				$this->form_validation->run() === TRUE){
				$this->Crud->update(
					['id'=>$this->user_id],
					['email'=>$_POST['email']],$this->_table
				);
			}

		}
	
		redirect($this->_redirect);

	}

	public function user_history($id){
		echo $id;
	}
	private function _set_form_validation(){

		$this->data['title'] = lang('edit_user');
		$this->data['url'] = $this->_redirect.'/insert';

		$this->data['buttons'] = [

			'create'=>$this->_redirect,
		];

		// user table

		$this->form_validation->set_rules('first_name', lang('first_name'), 'trim|required|max_length[50]');
		$this->form_validation->set_rules('last_name', lang('last_name'), 'trim|required|max_length[50]');
		$this->form_validation->set_rules('birthday', lang('birthday'), 'trim|required|max_length[20]');



	}


	private function _set_data($candidates){

		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		$this->load->library("html/InputArray");



		foreach(['email'] as $value){
			$this->data['control']["email_l"] = form_label('email');
			$this->data['control']['email'] = form_input(
				$this->inputarray->getArray($value,'email',lang('email'),$this->ion_auth->user()->row()->email,TRUE));
		}

		// civility
		$civility = isset($candidates) && $candidates['civility'] ? $candidates['civility'] : NULL ;
		$this->data['control']["civility_l"] = form_label(lang("user_civility"));
		$this->data['control']['civility'] =
		form_dropdown('civility', ['mr'=>lang('_mr'),'mrs'=>lang('_mrs')],$civility,['class'=>'form-control']);

		//set user
		foreach(['first_name','last_name'] as $value){
			$this->data['control']["{$value}_l"] = form_label(lang("$value"));
			$this->data['control'][$value] = form_input(
				$this->inputarray->getArray($value,'text',lang($value),$candidates[$value],TRUE));
		}



		if( isset($_GET['url_back'])){
			$this->data['control']['redirect'] = form_hidden("redirect",$_GET['url_back']);
		}



		$this->data['control']["birthday_l"] = form_label(lang("birthday"));
		$activity = ($candidates)?  date_format( date_create($candidates['birthday']),"d/m/Y")  :
		$this->form_validation->set_value('birthday');


		$this->data['control']['birthday'] = form_label(lang("birthday"));

		$this->data['control']['birthday'] = form_input(  $this->inputarray->getArray('birthday','search',
				lang("birthday"),$activity,TRUE,['data-calendar'=>true]));







	}
}
