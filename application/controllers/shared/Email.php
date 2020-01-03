<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// back / activity
class Email extends Shared_Controller
{


	private $data = [];
	private $_redirect ;

	private $_table = 'email_template';
	private $_allowed = [1];
	private $_ajax;

	public function __construct()
	{
		parent::__construct($this->_allowed);
		$this->_redirect = base_url().Shared_Controller::$map.'/email';

	}


	public function index()
	{
		// $this->load->view('back / index');
		$this->show_header();


		$js = strip_tags( $this->load->view('js/data_edit_ajax',[
					'selector'=>$this->_table,'url'=>$this->_ajax.'/toogle' ],TRUE));




		$this->load->view('back/parts/datatable',[
				'headers'=>['id','id','title','activ_btn'],
				'title' =>lang('manage_email_template'),
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
			$id = $this->Crud->add(['title'=>$_POST['title'],'placeholder'=>$_POST['placeholder']]
			,$this->_table);
			$this->Crud->add(['subject'=>$_POST['subject'],'body'=>$_POST['body'],
			'lang'=>$this->getCurrentLang(),'template_id'=>$id],'email_template_translate');
			
			echo json_encode(['done'=>true]);
			return;
		}

		echo json_encode(['error'=>$this->form_validation->error_array()]);

	}


	public function edit($id = NULL)
	{



		$this->_set_form_validation($this->_redirect.'/update/'.$id);
		$id = isset($_POST['id']) ? $_POST['id'] :  $id ;

		if($id && $id > 0)
		{
			$row = $this->Crud->get_row(['id'=>$id],$this->_table);
			$row['trans'] = $this->Crud->get_row(
			['template_id'=>$id,'lang'=>$this->getCurrentLang()],'email_template_translate');


			if($row)
			{
				$this->_set_data($row);
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
				['title'=>$_POST['title'],'placeholder'=>$_POST['placeholder']],
				$this->_table
			);
			
			$this->Crud->update_or_insert(
				['subject'=>$_POST['subject'],'body'=>$_POST['body'],'lang'=>$this->getCurrentLang(),
				'template_id'=>$id],
				'email_template_translate'
			);
			
			


		
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

			$this->Crud->delete(['id'=>$user_id],'activities');
			$this->Crud->delete(['activity_id'=>$user_id],'function_activity');

		}
		redirect($this->_redirect);
	}


	private function _set_form_validation($url)
	{
		$this->data['title'] = lang('manage_email_template');

		$this->data['url'] = $url;
		$this->data['buttons'] = [

			'create'=>$url,
		];
		$this->data['cancel'] = $this->_redirect;


		$this->form_validation->set_rules('title', lang('title'), 'trim|required|max_length[200]');
		$this->form_validation->set_rules('subject', lang('subject'), 'trim|required|max_length[200]');
		$this->form_validation->set_rules('body', lang('body'), 'trim|required|max_length[9000]');


	}



	private function _set_data($user = NULL)
	{
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


		$this->load->library("html/InputArray");


		foreach(['title','placeholder'] as $value)
		{
			$activity = ($user)? $user[$value] : $this->form_validation->set_value($value);
			$this->data['control'][$value."_"] = form_label( lang($value));
			$this->data['control'][$value] =
			form_input( $this->inputarray->getArray($value,'text',
					lang($value),$activity,TRUE));
		}


		foreach(['subject'] as $value)
		{
			$activity = ($user)? $user['trans'][$value] : $this->form_validation->set_value($value);
			$this->data['control'][$value."_"] = form_label( lang($value));
			$this->data['control'][$value] =
			form_input( $this->inputarray->getArray($value,'text',
					lang($value),$activity,TRUE));
		}




		foreach(['body'] as $value)
		{
			$activity = ($user)? $user['trans'][$value] : $this->form_validation->set_value($value);

			$this->data['control'][$value."_"] = form_label( lang($value));
			$this->data['control'][$value] =
			form_textarea( $this->inputarray->getArray($value,'text',
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


				$table_row['title'],
				$this->load->view("buttons/edit",
					['url'=>$this->_redirect.'/edit/'.$table_row['id']],true)



			);
			array_push($data['data'],$row);
		}


		echo json_encode($data);
	}
}
