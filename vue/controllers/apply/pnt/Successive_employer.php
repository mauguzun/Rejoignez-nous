<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Successive_employer extends Apply_Pnt_Controller
{

	protected $step = 'successive_employer';


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

		$this->form_validation->set_rules('start[]', lang('school'), 'trim|required|max_length[250]');

	

		//  oe lets go
		if($this->form_validation->run() === TRUE ){

			if($row)
			{

				$langs = [];
				for($i = 0 ; $i < count($_POST['start']) ; $i++){
					$lang = [
						'application_id'=> $app['id'],
				'start' => date_to_db($_POST['start'][$i]),
				'end' => date_to_db($_POST['end'][$i]),
				'employer' => isset($_POST['employer'][$i])? $_POST['employer'][$i] : NULL ,
				'function' => isset($_POST['function'][$i])? $_POST['function'][$i] : NULL ,
				'name' => isset($_POST['name'][$i])? $_POST['name'][$i] : NULL ,
				'address' => isset($_POST['address'][$i])? $_POST['address'][$i] : NULL ,
				'zip' => isset($_POST['zip'][$i])? $_POST['zip'][$i] : NULL ,
				'city' => isset($_POST['city'][$i])? $_POST['city'][$i] : NULL ,
				'country_id' => isset($_POST['country_id'][$i])? $_POST['country_id'][$i] : NULL ,
				'phone' =>isset($_POST['phone'][$i])? $_POST['phone'][$i] : NULL ,
				'phone_2' => isset($_POST['phone_2'][$i])? $_POST['phone_2'][$i] : NULL ,
				'email' => isset($_POST['email'][$i])? $_POST['email'][$i] : NULL ,
				'why_left' => isset($_POST['why_left'][$i])? $_POST['why_left'][$i] : NULL ,

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
				for($i = 0 ; $i < count($_POST['start']) ; $i++){
					$langs[] = [
						'application_id'=> $app['id'],
				'start' => date_to_db($_POST['start'][$i]),
				'end' => date_to_db($_POST['end'][$i]),
				'employer' => isset($_POST['employer'][$i])? $_POST['employer'][$i] : NULL ,
				'function' => isset($_POST['function'][$i])? $_POST['function'][$i] : NULL ,
				'name' => isset($_POST['name'][$i])? $_POST['name'][$i] : NULL ,
				'address' => isset($_POST['address'][$i])? $_POST['address'][$i] : NULL ,
				'zip' => isset($_POST['zip'][$i])? $_POST['zip'][$i] : NULL ,
				'city' => isset($_POST['city'][$i])? $_POST['city'][$i] : NULL ,
				'country_id' => isset($_POST['country_id'][$i])? $_POST['country_id'][$i] : NULL ,
				'phone' =>isset($_POST['phone'][$i])? $_POST['phone'][$i] : NULL ,
				'phone_2' => isset($_POST['phone_2'][$i])? $_POST['phone_2'][$i] : NULL ,
				'email' => isset($_POST['email'][$i])? $_POST['email'][$i] : NULL ,
				'why_left' => isset($_POST['why_left'][$i])? $_POST['why_left'][$i] : NULL ,
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





		foreach(['start','end'] as $column)
		{
			$date_picker = $this->inputarray->getArray($column.'[]','search',lang($column),NULL,TRUE,['data-calendar'=>true]);
			$this->data['control'][$column.'[]'] = form_input( $date_picker);
		}
		foreach(['employer','function'] as $column)
		{
			$this->data['control'][$column.'[]'] = form_input($this->inputarray->getArray($column.'[]',null,lang($column),NULL,
					$column == 'function'?TRUE:FALSE));
		}
		$countries = $this->Crud->get_all('country_translate',
			['code'=>$this->session->userdata('lang')],'name','asc');
		$options   = [];
		foreach($countries as $coutry)
		{
			$options[$coutry['country_id']] = $coutry['name'];
		}

		//$this->data['control']["country_l"] = form_label(lang("country"));
		$this->data['control']['country_id[]'] =
		form_dropdown('country_id[]', $options,NULL,[
				'class'=>'form-control selectpicker',
				'data-live-search'=>"true"]);


		if($row)
		{
			$this->data['data'] = [];
			foreach($row as $value){
				$line = [];
				$line['function[]'] = form_input(
					$this->inputarray->getArray('function[]','text',lang('function'),$value['function'],TRUE
						));
				$line['employer[]'] = form_input(
					$this->inputarray->getArray('employer[]','text',lang('employer'),$value['employer'],FALSE
					));


				$line['start[]'] = form_input(
					$this->inputarray->getArray('start[]','text',lang('start'),date_to_input($value['start']),TRUE,['data-calendar'=>true]
					));

				$line['end[]'] = form_input(
					$this->inputarray->getArray('end[]','text',lang('end'),date_to_input($value['end']),TRUE,['data-calendar'=>true]
					));

				$line['name[]'] = form_input(
					$this->inputarray->getArray('name[]','text',lang('name'),$value['name'],FALSE,
					['data-required'=>TRUE]
					));
					
				$line['email[]'] = form_input(
					$this->inputarray->getArray('email[]','email',lang('email'),$value['email'],FALSE,
					['data-required'=>TRUE]
					));
				
				$line['phone[]'] = form_input(
					$this->inputarray->getArray('phone[]','tel',lang('phone'),$value['phone'],FALSE,
					['data-required'=>TRUE]
					));
					
				
				$line['why_left[]'] = form_textarea(
					$this->inputarray->getArray('why_left[]',NULL,lang('why_left'),$value['why_left'],FALSE,
					['data-required'=>TRUE]
					));
				
				
				$line['phone_2[]'] = form_input(
					$this->inputarray->getArray('phone_2[]','tel',lang('phone'),$value['phone_2'],FALSE
					
					));
					
				$line['address[]'] = form_input(
					$this->inputarray->getArray('address[]','text',lang('address'),$value['address'],FALSE
					
					));
					
			    $line['zip[]'] = form_input(
					$this->inputarray->getArray('zip[]','text',lang('zip'),$value['zip'],FALSE
					
					));
					
					
				 $line['city[]'] = form_input(
					$this->inputarray->getArray('city[]','text',lang('city'),$value['city'],FALSE
					
					));
					
				$line['country_id[]']  = 	form_dropdown('country_id[]', $options,$value['country_id'],[
				'class'=>'form-control selectpicker',
				'data-live-search'=>"true"]);

				array_push($this->data['data'],$line);

			}
		}

		$this->load->view('front/apply/pnt/successive_employer',$this->data);


	}

}


