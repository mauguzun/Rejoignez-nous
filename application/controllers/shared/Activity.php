<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// back / activity
class Activity extends Shared_Controller
{
	private $data = [];
	private $_redirect ;

	private $_table = 'activities';
	private $_allowed = [1,2];
	private $_ajax;

	public function __construct()
	{
		parent::__construct($this->_allowed);
		$this->_redirect = base_url().Shared_Controller::$map.'/activity';
		$this->_ajax = base_url().'access/Hr_Admin';


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
				'headers'=>['id','status','activity','function','activ_btn'],
				'title' =>lang('activity_manager'),
				'url' => $this->_redirect.'/ajax',
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

		if(isset($_POST['activity']))
		{
			if($this->form_validation->run() === TRUE)
			{

				$activity_id = $this->Crud->add([
						'activity'=>trim($_POST['activity']),
						'published'=>$_POST['published']
					],$this->_table);

				// anyway if isset id we put other shit
				if($activity_id)
				{
					$bath = [];
					foreach($_POST['activites_types'] as $type_id)
					{
						array_push($bath,['activity_id'=>$activity_id,'type_id'=>$type_id]);
					}
					$this->Crud->add_many($bath,'activites_types');

				}
				$this->session->set_flashdata('message', lang('saved'));
				$this->session->set_flashdata('info', true);


			}


		}

		$this->load->view(Admin_Controller::$map .'/parts/add_modal_fixed',$this->data);

	}


	public function insert()
	{

		$this->_set_form_validation($this->_redirect.'/insert');


		if(isset($_POST['activity']))
		{
			if($this->form_validation->run() === TRUE)
			{

				$activity_id = $this->Crud->add([
						'activity'=>trim($_POST['activity']),
						'published'=>$_POST['published']
					],$this->_table);


				echo json_encode(['done'=>true]);
				return;
			}

			echo json_encode(['error'=>$this->form_validation->error_array()]);
		}
	}


	public function edit($user_id = NULL)
	{

		$this->_set_form_validation($this->_redirect.'/update');
		$user_id = isset($_POST['id']) ? $_POST['id'] :  $user_id ;







		if($user_id && $user_id > 0)
		{

			$query = $this->Crud->get_joins(
				$this->_table,
				[
					"functions"=>"$this->_table.id= functions.activity_id",

				],
				"$this->_table.*,$this->_table.id as aid ,
				GROUP_CONCAT(DISTINCT functions.id ) as fuid  ",null,
				"activities.id",['activities.id'=>$user_id]);

			if($query[0])
			{
				$query = $query[0];
				$query['fuid'] = explode(',',$query['fuid']);
			}
			if($query)
			{
				$this->_set_data($query);
				$this->load->view(Admin_Controller::$map .'/parts/add_modal_fixed',$this->data);

			}
		}

	}

	public function update()
	{




		$this->_set_form_validation($this->_redirect.'/update');
		if($this->form_validation->run() === TRUE)
		{

			$this->Crud->update(
				['id'=>$_POST['id']],
				['id'=>$_POST['id'],'published'=>$_POST['published'],'activity'=>$_POST['activity']],
				$this->_table
			);

			$this->Crud->update(['activity_id'=>$_POST['id']],['activity_id'=>null],'functions');
			foreach($_POST['activity_id'] as $id)
			{

				$this->Crud->update(['id'=>$id],['activity_id'=>$_POST['id']],'functions');
			}


			echo json_encode(['done'=>true]);
			return;

		}
		echo json_encode(['error'=>$this->form_validation->error_array()]);

	}


	public function trash($user_id = NULL)
	{
		if($user_id && $user_id > 0)
		{
			/*
			$functions = $this->Crud->get_all('function_activity',['activity_id'=>$user_id]);
			if($functions)
			{
			$result = "First you must remove this activities from function";
			foreach($functions as $value){
			$result.="<br>".anchor(base_url().Shared_Controller::$map.'/functions?id='.$value['function_id'],"please click here",['target'=>
			'_blank']);
			}
			$this->session->set_flashdata('message', $result);

			}else{*/
			$this->Crud->delete(['id'=>$user_id],'activities');
			$this->Crud->delete(['activity_id'=>$user_id],'function_activity');
			/*}*/
			//todo if user super Admin

			$this->session->set_flashdata('message', lang('deleted'));
			$this->session->set_flashdata('info', true);

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


		$this->form_validation->set_rules('activity', lang('activity'), 'trim|required|max_length[200]');
		$this->form_validation->set_rules('published', lang('status'), 'trim|numeric');

	}



	private function _set_data($user = NULL)
	{
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


		$this->load->library("html/InputArray");

		if($user)
		{
			$this->data['control']['id'] = form_input( $this->inputarray->getArray('id','hidden',null,$user['id'],TRUE));
		}

		$activity = ($user)? $user['activity'] : $this->form_validation->set_value('activity');

		$this->data['control']["_l"] = form_label('<b>*</b>'.lang('activity'));
		$this->data['control']['activity'] =
		form_input( $this->inputarray->getArray('activity','text',
				lang('activity'),$activity,TRUE,
				[
					'data-typehead'=>true,
					'data-typehead-column'=>'activity',
					'data-typehead-url'=>$this->_ajax.'/typehead',
					'data-typehead-table'=>$this->_table
				]));

		$is_active = ($user)?$user['published']:0;

		$this->data['control']['active'] =
		form_dropdown('published', [0=>'unpublished',1=>'published'],$is_active,['class'=>'form-control']);


		// pick only functtion withiut activites

		$options = [];
		foreach(  $this->Crud->get_all('functions',[ 'activity_id'=>NULL  ]) as $row){
			$options[$row['id']] = $row['function'];
		}
		if($user){
			foreach(  $this->Crud->get_all('functions',[ 'activity_id'=>$user['id']  ]) as $row){
				$options[$row['id']] = $row['function'];
			}

		}

		$this->data['control']['function_id[]'] =
		form_multiselect('activity_id[]', $options,$user['fuid'],['class'=>'form-control']);
		
		if(count($options) == 0){
			$this->data['control']['function_id[zx'] =
		anchor(base_url().'shared/function',lang('all_function_asigned_click_here_make_new'));
		}

		/*$this->data['control']["ads_l"] = form_label('<b>*</b>'.lang('function'));
		$this->data['control']['omega'] = $this->load->view('js/fastsearch',[
		'data'=>json_encode(array_values($data)),
		'selected'=>$user['fuid'],
		'name'=>'function_id[]',
		'value'=>$user['fuid'],
		'url'=>$this->_redirect.'/ajaxdata'
		],true);*/





	}

	public function ajax()
	{

		$query = $this->Crud->get_joins(
			$this->_table,
			[
				"functions"=>"$this->_table.id= functions.activity_id",

			],
			"$this->_table.*,$this->_table.id as aid ,GROUP_CONCAT(DISTINCT functions.function SEPARATOR '<br>'  ) as functions ",null,
			"$this->_table.id");

		$data['data'] = [];

		$this->load->library('html/toogle');

		$toog = $this->toogle->init(0,'published','activities',$this->_table)->set_text(lang('pub_toogle'));

		foreach($query as $table_row)
		{
			$row = [];

			array_push(
				$row,

				(int)$table_row['id'],
				$toog->set_flag($table_row['published'])->get($table_row['id']),
				$table_row['activity'],
				$table_row['functions'],
				$this->load->view("buttons/edit",['url'=>$this->_redirect.'/edit/'.$table_row['aid']],true).
				$this->load->view("buttons/trash",['url'=>$this->_redirect.'/trash/'.$table_row['aid']],true)


			);
			array_push($data['data'],$row);
		}


		echo json_encode($data);
	}
}
