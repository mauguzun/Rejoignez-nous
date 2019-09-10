<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Position extends Apply_Un_Controller
{

	protected $step = 'position';
	protected $activity = 'application_un_activity';

	public function __construct()
	{
		parent::__construct('user/offers');

	}

	public function index( )
	{
		
		$this->load->language('admin');

		$app = $this->get_application();
		if(!$app)
		redirect($this->get_page('main').FILL_FORM);


		$this->form_validation->set_rules('function', lang('function'), 'trim|required|max_length[200]');
		$this->form_validation->set_rules('contract_id', lang('contract'), 'trim|numeric|required');


		$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));
		// check form validation


		if(  $this->form_validation->run() === true ){
			
			
			// we have app lets continute
			if($row){
				
				// 1 Table
				$save['application_id'] = $app['id'];
				$save['function'] = $_POST['function'];
				$save['contract_id'] = $_POST['contract_id'];
				
				$this->savehistory($app['id'],$save,$row,'application_id',$app['id'],$this->get_table_name($this->step),['application_id']);
				$this->Crud->update_or_insert($save,$this->get_table_name($this->step));
				
				$rows =  $this->Crud->get_all('application_un_activity');
				
				// 2 talbe
				/*$langs = [];
				foreach($_POST['activity'] as $value){
					$lang = [
						'activity' => $value,
						'application_id'=>$app['id']
					];
					array_push($langs,$lang);
				}
				foreach($rows as $value)
				{

					$check_me = $value;
					
					
					unset($check_me['id']);
					if(!in_array($check_me,$langs))
					{
						// oe ? we find you bich
						$this->savehistory($app['id'],$check_me,[],'id',$value['id'],'application_un_activity',['application_id']);

					}
				}
				$this->Crud->delete(['application_id'=>$app['id']],'application_un_activity');
				foreach($langs as $new_value)
				{
					$this->Crud->update_or_insert($new_value,'application_un_activity');
				}
				*/
			}
			else
			{
				

				$save['application_id'] = $app['id'];
				$save['function'] = $_POST['function'];
				$save['contract_id'] = $_POST['contract_id'];
				
				$this->Crud->add($save,$this->get_table_name($this->step));
				$langs = [];
				
				/*foreach($_POST['activity'] as $value){
					$lang = [
						'activity' => $value,
						'application_id'=>$app['id']
					];
					array_push($langs,$lang);
				}
				$this->Crud->add_many($langs,'application_un_activity');*/
				 
				
			}
			redirect($this->apply.'/'.$app['id']);
		}
		else
		{

			$message = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


			$this->session->set_flashdata('message',$message);

		}

		$this->show_header([lang('unsolicited_application_applys'),
		lang('unsolicited_application_applys'),lang('unsolicited_application_applys')]);
		$this->open_form();

		$this->show($row);
		$this->load->view('front/apply/close');
		$this->load->view('front/apply/js/calendar_js');
		$this->show_footer();

	}

	private function show($row)
	{

		/*
		$query = $this->Crud->get_all('activities');
		$activity_list = array_map(
			function ($a)
			{
				return $a['activity'];
			}, $query);
	*/
		$activity_list_id = 'activity_list_id';
	
		$query = $this->Crud->get_all('functions');
		$function_list = array_map(
			function ($a)
			{
				return $a['function'];
			}, $query);

		$function_list_id = 'function_list_id';
		
		
		
		// $this->load->view('datalist',['name'=>$activity_list_id,'list'=>$activity_list]);
		 $this->load->view('datalist',['name'=>$function_list_id,'list'=>$function_list]);

		
		if($row)
		{
			$this->data['data'] = [];
			foreach($this->Crud->get_all('application_un_activity',['application_id'=>$row['application_id']]) as $value){
				$line = [];
				$line['activity[]'] = form_input(
					$this->inputarray->getArray('activity[]','search',lang('activity'),$value['activity'],TRUE
						,['list'=>$activity_list_id]));
				

				array_push($this->data['data'],$line);

			}
		}


		$contract_option = [];
		$contract        = $this->Crud->get_all('application_contract');
		foreach($contract as $value)
		{
			$contract_option[$value['id']] = $value['type'];
		}
		$selected = ($row) ? $row['contract_id']: NULL;
		/*echo "<pre>";
		var_dump($row);
		var_dump($selected);
				echo "</pre>";*/
		
		$this->data['control']["contract_id_l"] = form_label(lang("create_application_contract"));
		$this->data['control']['contract_id'] = form_dropdown('contract_id', $contract_option,$selected,['class'=>'form-control']);

		$this->data['control']["function_l"] = form_label(lang("function"));
		 $this->data['control']['function'] = form_input(
				$this->inputarray->getArray('function','text',lang("function"),($row) ? $row['function']: NULL,
				true,['list'=>$function_list_id]
		));
		
		/*$this->data['activity'] = form_input(
				$this->inputarray->getArray('activity[]','text',lang("set active"),NULL,
				true,['list'=>$activity_list_id]
		));*/


		
		$this->load->view('front/apply/unsolicited/position',$this->data);
	}



}


