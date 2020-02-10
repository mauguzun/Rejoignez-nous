<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// back / activity
class Offer extends Shared_Controller
{
	private $data = [];
	private $_redirect ;

	private $_table = 'offers';
	private $_ajax ;

	private $_allowed = [1,2,3,4,5,6,7];

	public function __construct()
	{
		parent::__construct($this->_allowed);
		$this->_redirect = base_url().Shared_Controller::$map.'/offer';
		$this->_ajax = base_url().'access/Pnt_Pnc_Hr_Admin';

		$this->load->library('html/toogle');


	}


	public function index()
	{



		$this->show_header();


		$js = strip_tags($this->load->view('js/ajaxtoogle',[
					'selector'=>$this->_table,'url'=>$this->_ajax.'/toogle' ],TRUE));

		$js .= strip_tags($this->load->view('js/modal',NULL,TRUE) );
		$js .= strip_tags($this->load->view('js/clipboard',NULL,TRUE) );
		$js .= strip_tags( $this->load->view('js/data_edit_ajax',[
					'selector'=>$this->_table ],TRUE));

		$this->load->view('back/parts/datatable',[
				'headers'=>['id','create_offer_pub_date','title',/*'function','category',*/'type','period',
					'overview','status','copy','activ_btn'],
				'title' =>lang('offer_manager'),
				'url' => $this->_redirect.'/ajax',
				'add_button' => ($this->get_user_edit()) ?  $this->_redirect.'/add' : NULL,
				'order_by'=>1,
				'js'=>$js
			]);



		$this->load->view('back/parts/footer');


	}

	public function add($status = 1)
	{



		$this->_set_form_validation($this->_redirect.'/insert');
		$this->_set_data();
		$this->load->view(Admin_Controller::$map .'/parts/add_modal_fixed',$this->data);


	}
	public function insert($status = 1 )
	{
		//check if CDI !!!


		$this->_set_form_validation($this->_redirect.'/insert');


		$this->_extraCheck();

		if($this->form_validation->run() === TRUE)
		{

			$offer_id = $this->Crud->add([
					'title'=>$_POST['title'],
					'category'=>$_POST['category'],
					'type'=>$_POST['type'],
					'period'=>$_POST['period'],
					/*					'start_date'=>  date_to_db($_POST['start_date']) ,*/
					'start_date'=>  $_POST['start_date'] ,
					'pub_date'=> date_to_db($_POST['pub_date']),
					'location'=>$_POST['location'],
					/*					'date'=>date_to_db($_POST['date']),*/
					'profile'=>$_POST['profile'],
					'mission'=>$_POST['mission'],
					'status'=>$status,
					'admin_id'=>$this->ion_auth->user()->row()->id,

				],$this->_table);


			$bath     = [];
			foreach(explode(",", $_POST['offers_activities'][0]) as $activity_id)
			{
				array_push($bath,['activiti_id'=>$activity_id,'offer_id'=>$offer_id]);
			}

			$this->Crud->add_many($bath,'offers_activities');



			echo json_encode(['done'=>true]);
			return;

		}

		echo json_encode(['error'=>$this->form_validation->error_array()]);

	}

	public function edit($id = NULL)
	{


		if(!$this->get_user_edit())
		{
			echo "You dont have acces";
			return;
		}


		// $this->show_header();
		$this->_set_form_validation($this->_redirect.'/update');

		if($id && $id > 0)
		{

			$user_id = $this->ion_auth->user()->row()->id;
			$query   = $this->Crud->get_joins(
				$this->_table,
				[
					'application_contract'=>"{$this->_table}.type=application_contract.id",
					'offers_location'=>"{$this->_table}.location=offers_location.id",
					'offers_category'=>"{$this->_table}.category=offers_category.id",
					'offers_activities'=>"{$this->_table}.id=offers_activities.offer_id",
					'activities'=>"offers_activities.activiti_id=activities.id",
				],
				'offers.*,GROUP_CONCAT(DISTINCT activities.activity ) as activities',null,null,["{$this->_table}.id"=>$id]
			);

			if($query && is_array($query))
			{
				$this->_set_data($query[0]);
				$this->load->view(Admin_Controller::$map .'/parts/add_modal_fixed',$this->data);

			}
		}



	}

	public function update($status = 1)
	{


		$this->_set_form_validation($this->_redirect.'/update');
		//$this->_extraCheck();
		if($this->form_validation->run() === TRUE)
		{

			$this->Crud->update(
				['id'=>$_POST['id']],
				[
					'title'=>$_POST['title'],
					'category'=>$_POST['category'],
					'type'=>$_POST['type'],
					'period'=>$_POST['period'],
					/*					'start_date'=>  date_to_db($_POST['start_date']),
					*/					'start_date'=>  $_POST['start_date'],
					'pub_date'=>date_to_db($_POST['pub_date']),
					'profile'=>$_POST['profile'],
					'mission'=>$_POST['mission'],
					'status'=>$status,
					'location'=>$_POST['location'],
					/*					'date'=>date_to_db($_POST['date'])
					*/
				] ,$this->_table
			);


			/*	if($_POST['group_id'])
			$bath = [];
			foreach($_POST['group_id'] as $type_id)
			{
			array_push($bath,['offer_id'=>$_POST['id'],'group_id'=>$type_id]);
			}
			$this->Crud->delete(['offer_id'=>$_POST['id']],'offers_groups');
			$this->Crud->add_many($bath,'offers_groups');*/

			$bath = [];
			foreach(explode(",", $_POST['offers_activities'][0]) as $activity_id)
			{
				array_push($bath,['activiti_id'=>$activity_id,'offer_id'=>$_POST['id']]);
			}
			$this->Crud->delete(['offer_id'=>$_POST['id']],'offers_activities');
			$this->Crud->add_many($bath,'offers_activities');


			echo json_encode(['done'=>true]);
			return;

		}
		echo json_encode(['error'=>$this->form_validation->error_array()]);

	}

	public function trash($id = NULL)
	{

		if(!$this->get_user_edit())
		{
			echo "You dont have acces";
			return;
		}

		if($id && $id > 0)
		{
			$this->Crud->delete(['id'=>$id],$this->_table);
			$this->Crud->delete(['offer_id'=>$id],'offers_activities');
			$this->Crud->delete(['offer_id'=>$id],'application');
			$this->Crud->delete(['offer_id'=>$id],'application');
			$this->Crud->delete(['id'=>$this->user_id],'activities');
			$this->Crud->delete(['activity_id'=>$this->user_id],'function_activity');
		}
		redirect($this->_redirect);
	}


	private function _set_form_validation($url)
	{
		$this->data['title'] = lang('create_offer');

		$this->data['url'] = $url;

		$this->data['buttons'] = [

			'create_and_publish'=>$url,
			'create_and_not_publish'=>$url.'/0'
		];

		$this->data['cancel'] = $this->_redirect;


		$this->form_validation->set_rules('title', lang('title'), 'trim|required|max_length[250]');
		$this->form_validation->set_rules('type', lang('type'), 'trim|required|numeric');
		$this->form_validation->set_rules('period', lang('create_offer_period'), 'trim|max_length[250]');
		$this->form_validation->set_rules('start_date', lang('start_date'), 'trim|required|max_length[250]');
		$this->form_validation->set_rules('pub_date', lang('start_date'), 'trim|required|max_length[11]');
		/*		$this->form_validation->set_rules('date', lang('date'), 'trim|max_length[11]');
		*/		$this->form_validation->set_rules('location', lang('location'), 'trim|required|numeric');
		$this->form_validation->set_rules('mission', lang('mission'), 'trim|required');
		$this->form_validation->set_rules('profile', lang('profile'), 'trim|required');
		//  $this->form_validation->set_rules('group_id[]', lang('group_id'), 'trim | required | numeric');
		$this->form_validation->set_rules('offers_activities[]', lang('offers_activities'), 'trim|required');


	}



	private function _set_data($user = NULL)
	{


		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


		$this->load->library("html/InputArray");

		if($user)
		{
			$this->data['control']['id'] = form_input( $this->inputarray->getArray('id','hidden',null,$user['id']),TRUE);
		}

		// begin



		$activity = ($user)? $user['title'] : $this->form_validation->set_value('title');
		$this->data['control']["ads_l"] = form_label('<b>*</b>'.lang('title'));
		$this->data['control']['title'] =
		form_input( $this->inputarray->getArray('title','text',lang('create_offer_title'),$activity,TRUE));



		////

		$activity = $user && $user['start_date'] ?  $user['start_date'] : 'Immediate';
		
		$selected  = $activity == 'Immediate' ? 'Immediate' : '';
		$this->data['control']["1"] = form_label( '<b>*</b>'.lang("create_offer_start_date"));
		$this->data['control'][''] =
		form_dropdown('fake_start_date', ['Immediate'=>'Immediate',''=>lang('calendar')],$selected,['class'=>'form-control']);


		

		$this->data['control']['start_date'] =
		form_input( $this->inputarray->getArray('start_date','text',lang('calendar'),$activity,TRUE,['data-calendar'=>true]));
		////////////////////////////////////////////////////////////
		//$dates = ['start_date','pub_date'];
		$dates = ['pub_date'];
		foreach($dates as $oneDate)
		{

			$activity = ($user ) ? $user[$oneDate]  :
			$activity = $this->form_validation->set_value($oneDate);
			if($user )
			{
				if($oneDate == 'pub_date')
				$activity = date_to_input($user[$oneDate]);
				else
				$activity = $user[$oneDate];
			}

			$this->data['control']["{$oneDate}_l"] = form_label( '<b>*</b>'.lang("create_offer_{$oneDate}"));
			$date_picker = $this->inputarray->getArray($oneDate,'search',
				lang("create_offer_{$oneDate}"),$activity,TRUE,['data-calendar'=>true]);
			$this->data['control'][$oneDate] = form_input( $date_picker);
		}


		/* $selected = null;
		foreach ($this->Crud->get_all('groups',null,'id','asc') as $value) {
		$options[$value['id']] = $value['description'];
		}

		if ($user) {
		$all_selected = $this->Crud->get_all('offers_groups',['offer_id'=>$user['id']]);
		$selected     = array_map(
		function($a)
		{
		return $a['group_id'];
		}, $all_selected);
		}
		$this->data['control']['group_id[]'] =
		form_multiselect('group_id[]', $options,$selected,['class'=>'form-control']);*/


		$this->data['control']['period_l'] = form_label(lang('period'));
		$activity = ($user)? $user['period'] : $this->form_validation->set_value('period');
		$this->data['control']['period'] = form_input( $this->inputarray->getArray('period','text',
				lang('create_offer_period'),$activity,FALSE));



		// '
		$is_active = ($user)?$user['status']:0;

		/*  $this->data['control']['status'] =
		form_dropdown('un', [0=>lang('unpublished'),1=>lang('published')],$is_active,['class'=>'form-control']);
		*/

		if(!$this->get_group_category())
		{


			$options = [];
			foreach($this->Crud->get_all("offers_category",null,'id','asc') as $value)
			{
				$options[$value['id']] = $value['category'];
			}
			$selected = ($user) ? $user['category']: NULL;


			$this->data['control']["category_l"] = form_label('<b>*</b>'.lang("create_offer_category"));
			$this->data['control']['category'] = form_dropdown('category', $options,$selected,['class'=>'form-control']);

		}
		else
		{
			$this->data['control']['category'] = form_hidden('category',$this->get_group_category());

		}



		foreach(['location'] as $column)
		{
			/*$options = [];
			foreach($this->Crud->get_all("offers_{$column}",null,'id','asc') as $value){
			$options[$value['id']] = $value[$column];
			}*/

			//	var_dump($user);

			$data = null ;
			if($user)
			{

				$location = $this->Crud->get_row(['id'=>$user['location']],'offers_location');
				$data[] = ['text'=>$location['location'],'value'=>$location['id']];
			}


			$this->data['control']["{$column}_l"] = form_label('<b>*</b>'.lang("create_offer_{$column}"));

			$this->data['control'][$column] = $this->load->view('js/ajax_select_url',
				[
					'selected'=>isset($user) ? [$user['location']] : null ,
					'name'=>$column,
					'data'=> is_array($data) ?   json_encode(array_values($data)) : null ,
					'url'=>$this->_redirect.'/ajax_location',
					'multiple'=>false
				],TRUE);


			//			$this->data['control'][$column] = form_dropdown($column, $options,$selected,['class'=>'form - control']);*/

		}

		$options = [];
		foreach($this->Crud->get_all("application_contract",null,'id','asc') as $value)
		{
			$options[$value['id']] = $value['type'];
		}
		$selected = ($user) ? $user["type"]: NULL;
		$this->data['control']["type_l"] = form_label('<b>*</b>'.lang("type"));

		$this->data['control']["type"] = form_dropdown("type", $options,$selected,['class'=>'form-control']);


		// Activity ///////////////////////////////////


		$selected = [];
		$data     = [];
		if($user)
		{
			foreach(   $this->Crud->get_all('offers_activities',['offer_id'=>$user['id']],NULL,NULL) as $value )
			{

				array_push($selected,$value['activiti_id']);

				$activity = $this->Crud->get_row(['id'=>$value['activiti_id']],'activities');
				$data[] = ['text'=>$activity['activity'],'value'=>$activity['id']];
			}

		}

		$this->data['control']["offers_activities[]_l"] = form_label('<b>*</b>'.lang("offers_activities"));
		$this->data['control']['offers_activities[]'] = $this->load->view('js/fastsearch',[
				'data'=>json_encode(array_values($data)),
				'selected'=>$selected,
				'name'=>'offers_activities[]',
				'url'=>base_url().'shared/functions/ajaxdata'
			],true);

		///////////////////////////////////

		//text areaas

		foreach(['mission','profile'] as $column)
		{

			$this->data['control']["{$column}_l"] = form_label('<b>*</b>'.lang("create_offer_{$column}"));

			$selected = ($user) ? $user[$column]: NULL;
			$this->data['control'][$column] = form_textarea(
				$this->inputarray->getArray($column,null,lang("create_offer_{$column}"),$selected
				));
		}

	}

	public function ajax_location()
	{


		$_GET['q'] = isset($_GET['q']) ? $_GET['q'] : "";
		header('Content-Type: application/json');

		$result = [];
		foreach($this->Crud->get_like(['location'=>$_GET['q']],'offers_location') as $value)
		{

			$result[] = ['text'=>$value['location'],'value'=>$value['id']];
		}

		echo json_encode(array_values($result));
	}

	public function ajax()
	{


		$category = $this->get_group_category();
		if($category == NULL)
		{
			$allowed = NULL ;
		}
		else
		if(is_array($category))
		{
			$allowed = "offers.category = 1 or offers.category = 4 and offers.status =1  ";
		}
		else
		{
			$allowed = ['offers.category'=>$category];
		}

		/*		if(!is_array($category))
		$allowed['status'] = 1;*/



		$query = $this->Crud->get_joins(
			$this->_table,
			[
				'application_contract'=>"{$this->_table}.type=application_contract.id",
				'offers_location'=>"{$this->_table}.location=offers_location.id",
				'offers_category'=>"{$this->_table}.category=offers_category.id",
				'offers_activities'=>"{$this->_table}.id=offers_activities.offer_id",
				'activities'=>"offers_activities.activiti_id=activities.id",
				'function_activity'=>"activities.id=function_activity.activity_id",
				'functions'=>"functions.id=function_activity.function_id"
			],
			"offers.*,GROUP_CONCAT(DISTINCT functions.function ) as functions ,GROUP_CONCAT(DISTINCT activities.activity ) as activities  ,application_contract.type as type,$this->_table.id as aid , offers_category.category  as cat",
			NULL,"{$this->_table}.id",$allowed


		);

		$data['data'] = [];


		foreach($query as $table_row)
		{

			array_push($data['data'],$this->_row($table_row));
		}


		echo json_encode($data);
	}

	public function copy_row($id)
	{
		$query = $this->Crud->get_joins(
			$this->_table,
			[
				'application_contract'=>"{$this->_table}.type=application_contract.id",
				'offers_location'=>"{$this->_table}.location=offers_location.id",
				'offers_category'=>"{$this->_table}.category=offers_category.id",
				'offers_activities'=>"{$this->_table}.id=offers_activities.offer_id",
				'activities'=>"offers_activities.activiti_id=activities.id",
				'function_activity'=>"activities.id=function_activity.activity_id",
				'functions'=>"functions.id=function_activity.function_id"
			],
			"offers.*,GROUP_CONCAT(DISTINCT functions.function ) as functions ,GROUP_CONCAT(DISTINCT activities.activity ) as activities  ,application_contract.type as type,$this->_table.id as aid , offers_category.category  as cat",
			NULL,"{$this->_table}.id",["$this->_table.id" => $id ]
		);

		$data = [];


		foreach($query as $value)
		{
			array_push($data,$this->_row($value));
		}
		echo json_encode($data);

	}

	private function _row($table_row)
	{
		$toog = $this->toogle->init(0,'status','offers',$this->_table)->set_text(lang('pub_toogle'));
		$row  = [];

		array_push(
			$row,

			(int)$table_row['id'],
			$table_row['pub_date'],
			$table_row['title'],
			//anchor( base_url().Shared_Controller::$map." / applications?offer = ".$table_row['title'], $table_row['title']),
			/*	$table_row['functions'],

			$table_row['cat'],*/
			$table_row['type'],
			$table_row['period'] ,

			anchor( base_url().User_Controller::$map."/offer/".$table_row['aid'] ,' <i class="fas fa-search"></i>',['target'=>"_blank"]  ),
			$toog->set_flag($table_row['status'])->get($table_row['id']),
			$this->load->view("buttons/copy",['url'=>$this->_ajax.'/copy/'.$table_row['id']],true),

			$this->load->view("buttons/edit",['url'=>$this->_redirect.'/edit/'.$table_row['id']],true).
			$this->load->view("buttons/trash",['url'=>$this->_redirect.'/trash/'.$table_row['id']],true)


		);
		return $row;
	}

	private function _extraCheck()
	{


		/*if($_POST['type'] != '2')
		{
			$this->form_validation->set_rules('period', lang('create_offer_period'),
				'trim|required|max_length[255]');
		}*/
	}
}
