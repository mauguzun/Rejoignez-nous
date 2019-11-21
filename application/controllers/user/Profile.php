<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends Usermeta_Controller{
	private $data = [];
	
	private $_redirect;
	private $table = 'users';

	public function __construct(){
		parent::__construct('user/profile',['edit_user','edit_user','edit_user']);

		$this->_user_id = $this->ion_auth->user()->row()->id;
		$this->_redirect = base_url().User_Controller::$map.'profile';

		$this->load->library('menu/Profiletabmenu');
		$this->data['pagination'] = [];
		/*        $this->data['pagination'] = $this->profiletabmenu->get_profile_nav('profile');
		*/	}

	public function index(){



		$this->_set_form_validation();
		if($this->form_validation->run() === TRUE){
			
			$_POST['birthday'] = date_to_db($_POST['birthday']);

			$redirect = NULL ;
			if(isset($_POST['redirect'])){
				$redirect = $_POST['redirect'];
				unset($_POST['redirect']);
			}
		
			
			$this->Crud->update(['id'=>$this->user->id],$_POST,$this->table);
			
			$this->session->set_flashdata('message', lang('saved'));
			$this->session->set_flashdata('info', true);
			
			
			if($redirect){
				redirect($redirect);
			}
			
			redirect(base_url().'/offers');
		}
		else{
			$this->data['message'] = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


			$this->session->set_flashdata('message',$this->data['message']);
		}


		$this->show_header([lang('edit_user'),lang('edit_user'),lang('edit_user')]);
		$this->_set_data((array)$this->user);


		$this->data['title'] = lang("edit_profile");



		// copy
	
		$this->load->view('front/user/header_form',$this->data)	;
		$this->load->view('front/apply/part/form',$this->data);
		$this->load->view('front/user/footer_form',$this->data);
		$this->load->view('front/apply/js/calendar_js');


		$this->show_footer();

	}

	public function deleteacc(){
		
		
		die();
		return;
		// 1 user
		$this->Crud->update(['id'=>$this->_user_id],['active'=>0],'users');
		//  candidate we skip

		// all my application set Delete
		$this->Crud->update(['user_id'=>$this->_user_id],['deleted'=>1],'application');
		// all my files marked as deleted

		$this->Crud->update(['user_id'=>$this->_user_id],['deleted'=>1],'application_files');

		redirect(base_url().'auth/logout');
	}


	private function _set_form_validation(){

		$this->data['title'] = lang('edit_user');
		$this->data['url'] = $this->_redirect;



		// user table

		$this->form_validation->set_rules('first_name', lang('first_name'), 'trim|required|max_length[50]');
		$this->form_validation->set_rules('last_name', lang('last_name'), 'trim|required|max_length[50]');
		$this->form_validation->set_rules('birthday', lang('birthday'), 'trim|required|max_length[20]');
		$this->form_validation->set_rules('address', lang('address'), 'trim|required|max_length[255]');
		$this->form_validation->set_rules('phone', lang('phone'), 'trim|required|max_length[20]');		
		$this->form_validation->set_rules('phone_2', lang('phone'), 'trim|max_length[20]');
		$this->form_validation->set_rules('zip', lang('zip'), 'trim|required|max_length[10]');
		$this->form_validation->set_rules('country_id', lang('country_id'), 'trim|required|numeric');
		$this->form_validation->set_rules('city', lang('city'), 'trim|required|max_length[255]');



	}

	private function _set_data($app = NULL ){

		

		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		$this->load->library("html/InputArray");




		// civility
		$civility = isset($app) && $app['civility'] ? $app['civility'] : NULL ;
		$this->data['control']["civility_l"] = form_label(lang("user_civility"));
		$this->data['control']['civility'] =
		form_dropdown('civility', ['mr'=>lang('_mr'),'mrs'=>lang('_mrs')],$civility,['class'=>'form-control']);

		//set user
		foreach(['first_name','last_name'] as $value){
			$this->data['control']["{$value}_l"] = form_label(lang("$value"));
			$this->data['control'][$value] = form_input(
				$this->inputarray->getArray($value,'text',lang($value),$app[$value],TRUE));
		}


		if( isset($_GET['url_back'])){
			$this->data['control']['redirect'] = form_hidden("redirect",$_GET['url_back']);
		}



		$this->data['control']["birthday_l"] = form_label(lang("birthday"));
		$activity = ($app)?  date_format( date_create($app['birthday']),"d/m/Y")  :
		$this->form_validation->set_value('birthday');


		$this->data['control']['birthday'] = form_label(lang("birthday"));

		$this->data['control']['birthday'] = form_input(  $this->inputarray->getArray('birthday','search',
				lang("birthday"),$activity,TRUE,['data-calendar'=>true]));


		// Address
		$countries = $this->Crud->get_all('country_translate',
			['code'=>$this->session->userdata('lang')],'name','asc');
		$options   = [];
		foreach($countries as $coutry){
			$options[$coutry['country_id']] = $coutry['name'];
		}
		$selected = isset($app['country_id'])? $app['country_id']:NULL;;
		//$this->data['control']["country_l"] = form_label(lang("country"));
		$this->data['control']['country_id'] =
		form_dropdown('country_id', $options,$selected,[
				'class'=>'form-control selectpicker',
				'data-live-search'=>"true"]);

		
		// address
		foreach(['city','zip','address','phone','phone_2'] as $value){
			$activity = ($app)?$app[$value] : $this->form_validation->set_value($value);
			//$this->data['control']["{$value}_l"] = form_label(lang($value));
			
			$place = $value == 'zip' ? 'postal' : 'zip';


			$required = ($value == 'phone_2' )?FALSE:TRUE;
			$this->data['control'][$value] = form_input(
				$this->inputarray->getArray($value,'text',$place,$activity,$required));
		}

		//*/
		foreach(['handicaped'] as  $column){
			$value = isset($user[$column]) ? $user[$column]  : 0;
			$this->data['control']["{$column}_l"] = form_label(lang($column));
			$this->data['control'][$column] =
			form_dropdown($column, [0=>lang('no'),1=>lang('yes')],$value,['class'=>'form-control']);
		}




	}
}


