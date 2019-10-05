<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Foreignlang extends Usermeta_Controller
{
	private $data = [];
	private $_user_id;
	private $_redirect;
	private $_table = 'users_english_frechn_level';

	public function __construct()
	{
		parent::__construct('user/profile',['foreignlang','foreignlang','foreignlang']);

		$this->_user_id = $this->ion_auth->user()->row()->id;
		$this->_redirect = base_url().User_Controller::$map.'profile';
		$this->load->library('InputArray');
		$this->load->library('menu/Profiletabmenu');
		$this->data['pagination'] = $this->profiletabmenu->get_profile_nav('foreignlang');
	}

	public function index()
	{

		$this->_set_form_validation();

		$this->_set_data($this->Crud->get_row(['user_id'=>$this->_user_id],'candidates'));

		$this->show_header([lang('edit_user'),lang('edit_user'),lang('edit_user')]);

		$this->data['title'] = lang("edit_profile");

		$this->load->view('front/user/header_form',$this->data)	;
		$this->load->view('front/apply/part/foreign_lang',$this->data);
		$this->load->view('front/user/footer_form',$this->data);

		$this->load->view('front/apply/js/calendar_js');
		$this->show_footer();




	}
	private function _set_form_validation()
	{

		$this->data['title'] = lang("edit_profile");
		$this->data['url'] = $this->_redirect;



		// user table

		$this->form_validation->set_rules('first_name', lang('first_name'), 'trim|required|max_length[50]');
		$this->form_validation->set_rules('last_name', lang('last_name'), 'trim|required|max_length[50]');
		$this->form_validation->set_rules('birthday', lang('birthday'), 'trim|required|max_length[20]');



	}

	private function _set_data( )
	{
		$levels = $this->Crud->get_all('language_level',NULL,'level','asc');
		$options = [];
		foreach($levels as $coutry)
		{
			$options[$coutry['id']] = $coutry['level'];
		}
		$data_list_id = 'lang_list';

		$options      = [];
		foreach($this->Crud->get_all("language_level",null,'id','asc') as $value)
		{
			$options[$value['id']] = $value['level'];
		}


		$main_lang = $this->Crud->get_row(['user_id'=>$this->_user_id ],'users_english_frechn_level');

		foreach(['english_level','french_level'] as $column)
		{
			$this->data['control'][$column] = form_dropdown($column, $options,($main_lang) ? $main_lang[$column]: NULL,['class'=>'form-control']);
		}


		$this->data['control']["level_id_label"] = form_label(lang("level_id"));
		$this->data['control']['level_id[]'] =
		form_dropdown('level_id[]', $options,null,['class'=>'form-control']);


		$this->data['control']['language[]'] = form_input(
			$this->inputarray->getArray('language[]','text',lang("edit_user_language"),NULL,FALSE,['list'=>$data_list_id]));

		$query = $this->Crud->get_all('language_list',null,'language','asc','language');
		$langs = array_map(
			function ($a)
			{
				return $a['language'];
			}, $query);

		$this->data['control']['data-list'] = $this->load->view('datalist',['name'=>$data_list_id,'list'=>$langs],TRUE);

	}


}
