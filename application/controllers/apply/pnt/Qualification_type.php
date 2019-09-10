<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Qualification_type extends Apply_Pnt_Controller
{

	protected $step = 'qualification_type';


	public function __construct()
	{
		parent::__construct('user/offers');

	}

	public function index($offer_id )
	{
		$offer = $this->errors($offer_id);
		if(!$offer)
		return ;


		$app   = $this->application_id($offer_id);
		$paqes = $this->get_pagination($offer_id);
		if(!$app){
			redirect($this->get_page($offer_id,'main').FILL_FORM);
		}

		$this->form_validation->set_rules('last_online_check[]', lang('function'), 'trim|required|max_length[25]');


		$row = $this->Crud->get_all($this->get_table_name($this->step),['application_id'=>$app['id']]);

		if($this->form_validation->run() === TRUE )
		{

			if($row){

				$langs = [];
				for($i = 0 ; $i < count($_POST['last_online_check']) ; $i++)
				{
					$lang = [
						'application_id'=> $app['id'],
						'aircaft_type' => $_POST['aircaft_type'][$i],

						'last_online_check' => date_to_db($_POST['last_online_check'][$i]),
						'last_simulator_control' => date_to_db($_POST['last_simulator_control'][$i]),
						'last_flight' => date_to_db($_POST['last_flight'][$i]),
					];
					array_push($langs,$lang);
				}
				foreach($row as $value){

					$check_me = $value;
					unset($check_me['id']);
					if(!in_array($check_me,$langs)){

						// oe ? we find you bich
						$this->savehistory($app['id'],$check_me,[],'application_id',$app['id'],$this->get_table_name($this->step),['id']);

					}
				}
				$this->Crud->delete(['application_id'=>$app['id']],$this->get_table_name($this->step));
				foreach($langs as $new_value){
					$this->Crud->update_or_insert($new_value,$this->get_table_name($this->step));
				}
			}
			else
			{

				$langs = [];
				for($i = 0 ; $i < count($_POST['last_online_check']) ; $i++)
				{
					$langs[] = [
						'application_id'=> $app['id'],
						'aircaft_type' => $_POST['aircaft_type'][$i],

						'last_online_check' => date_to_db($_POST['last_online_check'][$i]),
						'last_simulator_control' => date_to_db($_POST['last_simulator_control'][$i]),
						'last_flight' => date_to_db($_POST['last_flight'][$i]),
					];
				}
				$this->Crud->add_many($langs,$this->get_table_name($this->step));



			}
			redirect($this->apply.'/'.$offer_id);
		}



		$row = $this->Crud->get_all($this->get_table_name($this->step),['application_id'=>$app['id']]);


		$this->show_header([$offer['title'],$offer['title'],$offer['title']]);
		$this->open_form($offer_id,$offer);
		$this->show($row);
		$this->load->view('front/apply/close');
		$this->show_footer();
	}

	protected function show($row)
	{


		$levels = $this->Crud->get_all('aircraft_type',NULL,'aircraft','asc');
		$options = [];
		foreach($levels as $coutry)
		{
			$options[$coutry['id']] = $coutry['aircraft'];
		}
		$data_list_id = 'aircraft_type';

		$select       = [];
		foreach(['aircaft_type'] as $column)
		{

			$this->data['control'][$column.'[]'] = form_input(
				$this->inputarray->getArray(
					$column.'[]',null,lang($column),NULL,TRUE,['list'=>$data_list_id]
				));

		}
		$this->data['control']['data-list'] = $this->load->view('datalist',['name'=>$data_list_id,'list'=>$options],TRUE);

		foreach(['last_online_check','last_simulator_control','last_flight'] as $column){
			$date_picker = $this->inputarray->getArray($column.'[]','search',
				lang($column),NULL,TRUE,['data-calendar'=>true]);
			$this->data['control'][$column.'[]'] = form_input( $date_picker);
		}

		if($row){

			$this->data['data'] = [];
			foreach($row as $value){
				$line = [];
				
				$line['aircaft_type[]'] = form_input(
					$this->inputarray->getArray('aircaft_type[]','text',lang('aircaft_type'),$value['aircaft_type'],TRUE
					,['list'=>$data_list_id]));
				$line['last_online_check[]'] = form_input(
					$this->inputarray->getArray('last_online_check[]','text',lang('last_online_check'),date_to_input($value['last_online_check']),TRUE,['data-calendar'=>true]
					));
				
				$line['last_simulator_control[]'] = form_input(
					$this->inputarray->getArray('last_simulator_control[]','text',lang('last_simulator_control'),date_to_input($value['last_simulator_control']),TRUE,['data-calendar'=>true]
					));
				$line['last_flight[]'] = form_input(
					$this->inputarray->getArray('last_flight[]','text',lang('last_flight'),date_to_input($value['last_flight']),TRUE,['data-calendar'=>true]
					));

				array_push($this->data['data'],$line);

			}
		}

		$this->load->view('front/apply/pnt/qualification',$this->data);
		$this->load->view('front/apply/js/calendar_js');



	}







}


