<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Experience_in_instructor extends Apply_Pnt_Controller
{

	protected $step = 'experience_in_instructor';


	public function __construct()
	{
		parent::__construct('user/offers');

	}

	public function index($offer_id )
	{
		$offer = $this->errors($offer_id);
		if(!$offer)
		return ;


		$app = $this->application_id($offer_id);
		if(!$app)
		{
			redirect($this->get_page($offer_id,'main').FILL_FORM);
		}

		$row = $this->Crud->get_all($this->get_table_name($this->step),['application_id'=>$app['id']]);

		$this->form_validation->set_rules('aircaft_type[]', lang('school'), 'trim|required|max_length[250]');



		//  oe lets go
		if($this->form_validation->run() === TRUE ){

			if($row)
			{

				$langs = [];
				for($i = 0 ; $i < count($_POST['aircaft_type']) ; $i++){
					$lang = [
						'application_id'=> $app['id'],
						'aircaft_type' => $_POST['aircaft_type'][$i],
						'company' => $_POST['company'][$i],
						'approval_number' => $_POST['approval_number'][$i],
						'date_of_issue' => date_to_db($_POST['date_of_issue'][$i]),
						'validity_date' => date_to_db($_POST['validity_date'][$i]),

					];
					array_push($langs,$lang);
				}
				foreach($row as $value)
				{

					$check_me = $value;
					unset($check_me['id']);
					if(!in_array($check_me,$langs))
					{

						// oe ? we find you bich
						$this->savehistory($app['id'],$check_me,[],'application_id',$app['id'],$this->get_table_name($this->step),['id']);

					}
				}
				$this->Crud->delete(['application_id'=>$app['id']],$this->get_table_name($this->step));
				foreach($langs as $new_value)
				{
					$this->Crud->update_or_insert($new_value,$this->get_table_name($this->step));
				}
			}
			else
			{

				$langs = [];
				for($i = 0 ; $i < count($_POST['aircaft_type']) ; $i++){
					$langs[] = [
						'application_id'=> $app['id'],
						'aircaft_type' => $_POST['aircaft_type'][$i],
						'company' => $_POST['company'][$i],
						'approval_number' => $_POST['approval_number'][$i],
						'date_of_issue' => date_to_db($_POST['date_of_issue'][$i]),
						'validity_date' => date_to_db($_POST['validity_date'][$i]),
					];
				}
				$this->Crud->add_many($langs,$this->get_table_name($this->step));
			}
			redirect($this->apply.'/'.$offer_id);
			$row = $this->Crud->get_all($this->get_table_name($this->step),['application_id'=>$app['id']]);
		}



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
		foreach($levels as $coutry){
			$options[$coutry['id']] = $coutry['aircraft'];
		}
		$data_list_id = 'aircraft_type';
		$this->data['control']['data-list'] = $this->load->view('datalist',['name'=>$data_list_id,'list'=>$options],TRUE);




		foreach(['date_of_issue','validity_date'] as $column)
		{
			$date_picker = $this->inputarray->getArray($column.'[]','search',lang($column),NULL,TRUE,['data-calendar'=>true]);
			$this->data['control'][$column.'[]'] = form_input( $date_picker);
		}
		foreach(['company'] as $column)
		{
			$this->data['control'][$column.'[]'] = form_input($this->inputarray->getArray($column.'[]',null,lang($column),NULL,TRUE));
		}
		foreach(['aircaft_type'] as $column){
			$this->data['control'][$column.'[]'] = form_input(
				$this->inputarray->getArray(
					$column.'[]',null,lang($column),NULL,TRUE,['list'=>$data_list_id]
				));
		}
		foreach(['approval_number'] as $column){
			$this->data['control'][$column.'[]'] = form_input($this->inputarray->getArray($column.'[]','number',lang($column),NULL,TRUE,['min'=>1]));
		}


		if($row)
		{
			$this->data['data'] = [];
			foreach($row as $value){
				$line = [];
				$line['aircaft_type[]'] = form_input(
					$this->inputarray->getArray('aircaft_type[]','search',lang('aircaft_type'),$value['aircaft_type'],TRUE
						,['list'=>$data_list_id]));
				$line['company[]'] = form_input(
					$this->inputarray->getArray('company[]','search',lang('company'),$value['company'],TRUE
					));
				$line['approval_number[]'] = form_input(
					$this->inputarray->getArray('approval_number[]','number',lang('approval_number'),$value['approval_number'],TRUE
						,['min'=>1]));

				$line['validity_date[]'] = form_input(
					$this->inputarray->getArray('validity_date[]','text',lang('validity_date'),date_to_input($value['validity_date']),TRUE,['data-calendar'=>true]
					));

				$line['date_of_issue[]'] = form_input(
					$this->inputarray->getArray('date_of_issue[]','text',lang('date_of_issue'),date_to_input($value['date_of_issue']),TRUE,['data-calendar'=>true]
					));

				array_push($this->data['data'],$line);

			}
		}

		$this->load->view('front/apply/pnt/experience_in_instructor',$this->data);
		$this->load->view('front/apply/js/calendar_js');

	}

}


