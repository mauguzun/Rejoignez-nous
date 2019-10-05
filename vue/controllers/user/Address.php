<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Address extends Usermeta_Controller
{
	private $data = [];
	private $_user_id;
	private $_redirect;
	private $_table = 'candidate';

	public function __construct()
	{
		parent::__construct('user/profile',['edit_user','edit_user','edit_user']);

		$this->_user_id = $this->ion_auth->user()->row()->id;
		$this->_redirect = base_url().User_Controller::$map.'profile';

		$this->load->library('menu/Profiletabmenu');
        $this->data['pagination'] = $this->profiletabmenu->get_profile_nav('profile');
	}

	public function index()
	{

		$this->_set_form_validation();
		if($this->form_validation->run() === TRUE)
		{
			$_POST['user_id'] = $this->_user_id;
			$_POST['birthday'] = date_to_db($_POST['birthday']);

			$redirect = NULL ;
			if(isset($_POST['redirect']))
			{
				$redirect = $_POST['redirect'];
				unset($_POST['redirect']);
			}

			$this->Crud->update_or_insert($_POST,'candidates');


			redirect(base_url().'/offers');
			/*if($redirect != null )
			{

			//			redirect($redirect);
			}*/
		}
		else
		{
			$this->data['message'] = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


			$this->session->set_flashdata('message',$this->data['message']);
		}


		$this->show_header([lang('edit_user'),lang('edit_user'),lang('edit_user')]);
		$this->_set_data($this->Crud->get_row(['user_id'=>$this->_user_id],'candidates'));


		$this->data['title'] = lang("edit_profile");



		// copy
	
		$this->load->view('front/user/header_form',$this->data)	;
		$this->load->view('front/apply/part/form',$this->data);
		$this->load->view('front/user/footer_form',$this->data);
		$this->load->view('front/apply/js/calendar_js');


		$this->show_footer();

	}

	public function deleteacc()
	{
		// 1 user
		$this->Crud->update(['id'=>$this->_user_id],['active'=>0],'users');
		//  candidate we skip

		// all my application set Delete
		$this->Crud->update(['user_id'=>$this->_user_id],['deleted'=>1],'application');
		// all my files marked as deleted

		$this->Crud->update(['user_id'=>$this->_user_id],['deleted'=>1],'application_files');

		redirect(base_url().'auth/logout');
	}


	private function _set_form_validation()
	{

		$this->data['title'] = lang('edit_user');
		$this->data['url'] = $this->_redirect;



		// user table

		$this->form_validation->set_rules('first_name', lang('first_name'), 'trim|required|max_length[50]');
		$this->form_validation->set_rules('last_name', lang('last_name'), 'trim|required|max_length[50]');
		$this->form_validation->set_rules('birthday', lang('birthday'), 'trim|required|max_length[20]');



	}

	private function _set_data($candidates = NULL )
	{



		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		$this->load->library("html/InputArray");




		// civility
		$civility = isset($candidates) && $candidates['civility'] ? $candidates['civility'] : NULL ;
		$this->data['control']["civility_l"] = form_label(lang("user_civility"));
		$this->data['control']['civility'] =
		form_dropdown('civility', ['mr'=>lang('_mr'),'mrs'=>lang('_mrs')],$civility,['class'=>'form-control']);

		//set user
		foreach(['first_name','last_name'] as $value)
		{
			$this->data['control']["{$value}_l"] = form_label(lang("$value"));
			$this->data['control'][$value] = form_input(
				$this->inputarray->getArray($value,'text',lang($value),$candidates[$value],TRUE));
		}


		if( isset($_GET['url_back']))
		{
			$this->data['control']['redirect'] = form_hidden("redirect",$_GET['url_back']);
		}



		$this->data['control']["birthday_l"] = form_label(lang("birthday"));
		$activity = ($candidates)?  date_format( date_create($candidates['birthday']),"d/m/Y")  :
		$this->form_validation->set_value('birthday');


		$this->data['control']['birthday'] = form_label(lang("birthday"));

		$this->data['control']['birthday'] = form_input(  $this->inputarray->getArray('birthday','search',
				lang("birthday"),$activity,TRUE,['data-calendar'=>true]));




		//*/
		foreach(['handicaped'] as  $column)
		{
			$value = isset($user[$column]) ? $user[$column]  : 0;
			$this->data['control']["{$column}_l"] = form_label(lang($column));
			$this->data['control'][$column] =
			form_dropdown($column, [0=>lang('no'),1=>lang('yes')],$value,['class'=>'form-control']);
		}




	}
}


