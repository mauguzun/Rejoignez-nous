<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Practice extends Apply_Pnt_Controller
{

	protected $step = 'practice';


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

		$this->form_validation->set_rules('school_name[]', lang('school'), 'trim|required|max_length[250]');
		$this->form_validation->set_rules('qualification_obtained[]', lang('qualification_obtained'), 'trim|required|max_length[250]');
		$this->form_validation->set_rules('start[]', lang('start'), 'trim|required|max_length[20]');
		$this->form_validation->set_rules('end[]', lang('end'), 'trim|required|max_length[20]');


		//  oe lets go
		if($this->form_validation->run() === TRUE ){

			if($row)
			{

				$langs = [];
				for($i = 0 ; $i < count($_POST['school_name']) ; $i++){
					$lang = [
						'application_id'=> $app['id'],
						'school_name' => $_POST['school_name'][$i],
						'qualification_obtained' => $_POST['qualification_obtained'][$i],
						'start' => date_to_db($_POST['start'][$i]),
						'end' => date_to_db($_POST['end'][$i]),

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
				for($i = 0 ; $i < count($_POST['school_name']) ; $i++){
					$langs[] = [
						'application_id'=> $app['id'],
						'school_name' => $_POST['school_name'][$i],
						'qualification_obtained' => $_POST['qualification_obtained'][$i],
						'start' => date_to_db($_POST['start'][$i]),
						'end' => date_to_db($_POST['end'][$i]),

					];
				}
				$this->Crud->add_many($langs,$this->get_table_name($this->step));
			}

			$row = $this->Crud->get_all($this->get_table_name($this->step),['application_id'=>$app['id']]);
			redirect($this->apply.'/'.$offer_id);
		}



		$this->show_header([$offer['title'],$offer['title'],$offer['title']]);
		$this->open_form($offer_id,$offer);
		$this->show($row);
		$this->load->view('front/apply/close');
		$this->show_footer();
	}

	protected function show($row)
	{

		foreach(['start','end'] as $column)
		{
			$date_picker = $this->inputarray->getArray($column.'[]','search',
				lang($column),NULL,TRUE,['data-calendar'=>true]);
			$this->data['control'][$column.'[]'] = form_input( $date_picker);
		}
		foreach(['school_name','qualification_obtained'] as $column)
		{


			$this->data['control'][$column.'[]'] = form_input(
				$this->inputarray->getArray(
					$column.'[]',null,
					lang($column),
					NULL,TRUE
				)

			);
		}
		
			if($row)
		{

			$this->data['data'] = [];
			foreach($row as $value)
			{
				$line = [];
				$line['school_name[]'] = form_input(
					$this->inputarray->getArray('school_name[]','text',lang('school'),$value['school_name'],TRUE
					));	
				$line['qualification_obtained[]'] = form_input(
					$this->inputarray->getArray('qualification_obtained[]','text',lang('qualification_obtained'),$value['qualification_obtained'],TRUE
					));
				$line['start[]'] = form_input(
					$this->inputarray->getArray('start[]','text',lang('start'),date_to_input($value['start']),TRUE,['data-calendar'=>true]
					));
				
				$line['end[]'] = form_input(
					$this->inputarray->getArray('end[]','text',lang('end'),date_to_input($value['end']),TRUE,['data-calendar'=>true]
					));
				
				

				array_push($this->data['data'],$line);

			}
		}
		
		$this->load->view('front/apply/pnt/practice',$this->data);
		$this->load->view('front/apply/js/calendar_js');

	}

}


