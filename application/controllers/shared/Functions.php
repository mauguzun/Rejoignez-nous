<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// back / activity
class Functions extends Shared_Controller
{
	private $data = [];
	private $_redirect ;

	private $_table = 'functions';
	private $_allowed = [1,2];
	private $_ajax;

	public function __construct()
	{
		parent::__construct($this->_allowed);
		$this->_redirect = base_url().Shared_Controller::$map.'/functions';
		$this->_ajax = base_url().'access/Hr_Admin';
	}


	public function index()
	{
		// $this->load->view('back / index');
		$this->show_header();


		$js = strip_tags( $this->load->view('js/data_edit_ajax',[
					'selector'=>$this->_table,'url'=>$this->_ajax.'/toogle' ],TRUE));

		$id = isset($_GET['id']) ? $_GET['id'] : NULL ;

		$this->load->view('back/parts/datatable',[
				'headers'=>['id','function','activity','activ_btn'],
				'title' =>lang('function'),
				'url' => $this->_redirect.'/ajax/'.$id,
				'add_button' => $this->_redirect.'/add',
				'js'=>$js
			]);

		$this->load->view('js/autocomplete',[
				'url'=>$this->_ajax.'/typehead',
				'table'=>$this->_table,
				'name'=>'activity'
			]);

		$this->load->view('back/parts/footer');



	}

	public function add()
	{
		// $this->load->view('back / parts / jquery');
		$this->_set_form_validation($this->_redirect.'/insert');
		$this->_set_data();

		if(isset($_POST['activity'])){
			if($this->form_validation->run() === TRUE){

				$activity_id = $this->Crud->add([
						'activity'=>trim($_POST['activity']),
						'published'=>$_POST['published']
					],$this->_table);

				// anyway if isset id we put other shit
				if($activity_id){
					$bath = [];
					foreach($_POST['activites_types'] as $type_id){
						array_push($bath,['activity_id'=>$activity_id,'type_id'=>$type_id]);
					}
					$this->Crud->add_many($bath,'activites_types');

				}


			}


		}

		$this->load->view(Admin_Controller::$map .'/parts/add_modal_fixed',$this->data);

	}


	public function insert()
	{

		$this->_set_form_validation($this->_redirect.'/insert');

		if($this->form_validation->run() === TRUE)
		{

			$function_id = $this->Crud->add(['function'=>trim($_POST['function'])],$this->_table);

			// anyway if isset id we put other shit


			if($function_id)
			{
				$bath = [];
				foreach(explode(",", $_POST['activity_id'][0]) as $activity_id)
				{
					array_push($bath,['activity_id'=>$activity_id,'function_id'=>$function_id]);
				}
				//	$this->Crud->delete(['activity_id'=>$_POST['id']],'function_activity');
				$this->Crud->add_many($bath,'function_activity');
				// redirect($this->_redirect);

			}
			echo json_encode(['done'=>true]);
			return;
		}

		echo json_encode(['error'=>$this->form_validation->error_array()]);

	}


	public function edit($user_id = NULL)
	{

		$this->_set_form_validation($this->_redirect.'/update');
		$user_id = isset($_POST['id']) ? $_POST['id'] :  $user_id ;

		if($user_id && $user_id > 0){
			$user = $this->Crud->get_row(['id'=>$user_id], $this->_table);
			if($user){
				$this->_set_data($user);
				$this->load->view(Admin_Controller::$map .'/parts/add_modal_fixed',$this->data);

			}
		}

	}

	public function update()
	{
		$this->_set_form_validation($this->_redirect.'/update');
		if($this->form_validation->run() === TRUE){

			$this->Crud->update(
				['id'=>$_POST['id']],
				['function'=>$_POST['function']],
				$this->_table);


			$bath = [];
			foreach(explode(",", $_POST['activity_id'][0]) as $activity_id)
			{
				array_push($bath,['activity_id'=>$activity_id,'function_id'=>$_POST['id']]);
			}
			$this->Crud->delete(['function_id'=>$_POST['id']],'function_activity');
			$this->Crud->add_many($bath,'function_activity');
			echo json_encode(['done'=>true]);
			return;

		}
		echo json_encode(['error'=>$this->form_validation->error_array()]);

	}


	public function trash($user_id = NULL)
	{
		if($user_id && $user_id > 0){

			//todo if user super Admin
			$this->Crud->delete(['id'=>$user_id],$this->_table);
			//$this->Crud->delete(['activity_id'=>$user_id],'function_activity');

			$this->session->set_flashdata('message', lang('deleted'));
		}
		redirect($this->_redirect);
	}


	private function _set_form_validation($url)
	{
		$this->data['title'] = lang('create_activity_url');

		$this->data['url'] = $url;
		$this->data['buttons'] = [

			'create'=>$url,
		];
		$this->data['cancel'] = $this->_redirect;


		$this->form_validation->set_rules('function', lang('function'), 'trim|required|max_length[200]');
		$this->form_validation->set_rules('activity_id[]', lang('activity'), 'required');

	}



	private function _set_data($user = NULL)
	{
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


		$this->load->library("html/InputArray");

		if($user){
			$this->data['control']['id'] = form_input( $this->inputarray->getArray('id','hidden',null,$user['id'],TRUE));
		}

		$activity = ($user)? $user['function'] : $this->form_validation->set_value('activity');


		$this->data['control']['function'] =
		form_input( $this->inputarray->getArray('function','text',
				lang('function'),$activity,TRUE,
				[
					'data-typehead'=>true,
					'data-typehead-column'=>'function',
					'data-typehead-url'=>$this->_ajax.'/typehead',
					'data-typehead-table'=>$this->_table
				]));



		$options = [];
		foreach($this->Crud->get_all('activities',['published'=>1]) as $value){
			$options[$value['id']] = $value['activity'];
		}




		$selected = [];
		$data     = [];
		if($user){
			foreach(  $this->Crud->get_all('function_activity',['function_id'=>$user['id']],NULL,NULL) as $value ){
				array_push($selected,$value['activity_id']);

				$activity = $this->Crud->get_row(['id'=>$value['activity_id']],'activities');
				$data[] = ['text'=>$activity['activity'],'value'=>$activity['id']];
			}

		}



		// old before 2019.02.12

		/*$this->data['control']['activites_types[]'] =
		form_multiselect('activity_id[]', $options,$selected,['class'=>'form-control']);*/

		$this->data['control']['omega'] = $this->load->view('js/fastsearch',[
				'data'=>json_encode(array_values($data)),
				'selected'=>$selected,
				'name'=>'activity_id[]',
				'value'=>$selected,
				'url'=>$this->_redirect.'/ajaxdata'
			],true);

		$this->data['control']['z'] = '<div style="margin-bottom:400px"></div>';
	}

	public function ajaxdata()
	{
		$_GET['q'] = isset($_GET['q']) ? $_GET['q'] : "";
		header('Content-Type: application/json');

		$result = [];
		foreach($this->Crud->get_like(['activity'=>$_GET['q']],'activities') as $value){

			$result[] = ['text'=>$value['activity'],'value'=>$value['id']];
		}

		echo json_encode(array_values($result));

		/*echo '[
		{"text": "Afghanistan", "value": "Afghanistan"},
		{"text": "Albania", "value": "Albania"},
		{"text": "Algeria", "value": "Algeria"},
		{"text": "Angola", "value": "Angola"}
		]';*/
	}

	public function ajax($id = NULL )
	{

		$allow = ($id != NULL ) ? ['functions.id'=>$id] :  NULL ;


		$query = $this->Crud->get_joins(
			$this->_table,
			[
				"function_activity"=>"function_activity.function_id = $this->_table.id",
				"activities"=>"function_activity.activity_id= activities.id",

			]  , "$this->_table.*,GROUP_CONCAT(DISTINCT activities.activity ) as activities",
			NULL,"$this->_table.id",$allow);

		$data['data'] = [];


		foreach($query as $table_row){
			$row = [];

			array_push(
				$row,

				(int)$table_row['id'],
				$table_row['function'],
				$table_row['activities'],


				$this->load->view("buttons/edit",['url'=>$this->_redirect.'/edit/'.$table_row['id']],true).
				$this->load->view("buttons/trash",['url'=>$this->_redirect.'/trash/'.$table_row['id']],true)


			);
			array_push($data['data'],$row);
		}


		echo json_encode($data);
	}
}
