<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// back / activity
class Languages extends Shared_Controller
{
	private $data = [];
	private $_redirect ;

	private $_table = 'language_list';
	private $_allowed = [1];
	private $_ajax;

	public function __construct()
	{
		parent::__construct($this->_allowed);
		$this->_redirect = base_url().Shared_Controller::$map.'/Languages';
		$this->_ajax = base_url().'access/Hr_Admin_Comm';
	}


	public function index()
	{
		// $this->load->view('back / index');
		$this->show_header();


		$js = strip_tags($this->load->view('js/ajaxtoogle',[
					'selector'=>$this->_table,'url'=>$this->_ajax.'/toogle' ],TRUE));

		$js .= strip_tags( $this->load->view('js/data_edit_ajax',[
					'selector'=>$this->_table,'url'=>$this->_ajax.'/toogle' ],TRUE));


		$this->load->view('back/parts/datatable',[
				'headers'=>['id','id','langugage','activ_btn'],
				'title' =>lang('langugage'),
				'url' => $this->_redirect.'/ajax',
				'add_button' => $this->_redirect.'/add',
				'js'=>$js
			]);


		$this->load->view('back/parts/footer');



	}

	public function add()
	{
		// $this->load->view('back / parts / jquery');
		$this->_set_form_validation($this->_redirect.'/insert');
		$this->_set_data();



		$this->load->view(Admin_Controller::$map .'/parts/add_modal_fixed',$this->data);

	}


	public function insert()
	{

		$this->_set_form_validation($this->_redirect.'/insert');
		if($this->form_validation->run() === TRUE)
		{
			$this->Crud->add($_POST,$this->_table);
			echo json_encode(['done'=>true]);
			return;
		}

		echo json_encode(['error'=>$this->form_validation->error_array()]);

	}


	public function edit($user_id = NULL)
	{

		$this->_set_form_validation($this->_redirect.'/update/'.$user_id);
		$user_id = isset($_POST['id']) ? $_POST['id'] :  $user_id ;

		if($user_id && $user_id > 0)
		{
			$user = $this->Crud->get_row(['id'=>$user_id], $this->_table);
			if($user)
			{
				$this->_set_data($user);
				$this->load->view(Admin_Controller::$map .'/parts/add_modal_fixed',$this->data);

			}
		}

	}

	public function update($id)
	{
		$this->_set_form_validation($this->_redirect.'/update');
		if($this->form_validation->run() === TRUE)
		{

			$this->Crud->update(
				['id'=>$id],
				$_POST,
				$this->_table
			);

			/* $this->Crud->delete(['activity_id'=>$_POST['id']],'activites_types');

			$bath = [];
			foreach ($_POST['activites_types'] as $type_id) {
			array_push($bath,['activity_id'=>$_POST['id'],'type_id'=>$type_id]);
			}

			$this->Crud->add_many($bath,'activites_types');*/
			echo json_encode(['done'=>true]);
			return;

		}
		echo json_encode(['error'=>$this->form_validation->error_array()]);

	}


	public function trash($user_id = NULL)
	{
		if($user_id && $user_id > 0)
		{

			//todo if user super Admin
			$this->Crud->delete(['id'=>$user_id],$this->_table);



		}
		redirect($this->_redirect);
	}


	private function _set_form_validation($url)
	{
		$this->data['title'] = lang('language');

		$this->data['url'] = $url;
		$this->data['buttons'] = [

			'create'=>$url,
		];
		$this->data['cancel'] = $this->_redirect;


		$this->form_validation->set_rules('language', lang('language'), 'trim|required|max_length[200]');


	}



	private function _set_data($user = NULL)
	{
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


		$this->load->library("html/InputArray");






		foreach(['language'] as $value)
		{
			$activity = ($user)? $user[$value] : $this->form_validation->set_value($value);
			$this->data['control'][$value."_"] = form_label( lang($value));
			$this->data['control'][$value] =
			form_input( $this->inputarray->getArray($value,'text',
					lang($value),$activity,TRUE));
		}
	}

	public function ajax()
	{

		$query = $this->Crud->get_all($this->_table,NULL,'id','asc');

		$data['data'] = [];

		$this->load->library('html/toogle');

		$toog = $this->toogle->init(0,'published','news',$this->_table)->set_text(lang('pub_toogle'));

		foreach($query as $table_row)
		{
			$row = [];

			array_push(
				$row,

				(int)$table_row['id'],
				(int)$table_row['id'],
				$table_row['language'],

				$this->load->view("buttons/edit",['url'=>$this->_redirect.'/edit/'.$table_row['id']],true).
				$this->load->view("buttons/trash",['url'=>$this->_redirect.'/trash/'.$table_row['id']],true)


			);
			array_push($data['data'],$row);
		}


		echo json_encode($data);
	}
}