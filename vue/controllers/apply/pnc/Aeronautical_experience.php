<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Aeronautical_experience extends Apply_Pnc_Controller
{

	protected $step = 'aeronautical_experience';


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
		if(!$app)
		{
			redirect($this->get_page($offer_id,'main').FILL_FORM);
		}

		$this->form_validation->set_rules('function[]', lang('function'), 'trim|required|max_length[2500]');


		$row = $this->Crud->get_all($this->get_table_name($this->step),['application_id'=>$app['id']]);

		if($this->form_validation->run() === TRUE ){

			if($row)
			{

				$langs = [];
				for($i = 0 ; $i < count($_POST['function']) ; $i++){
					$lang = [
						'application_id'=> $app['id'],
						'function' => $_POST['function'][$i],
						'duration' => strtolower($_POST['function'][$i]) != 'aucune' ? NULL : $_POST['duration'][$i],
						'company'=> strtolower($_POST['function'][$i]) != 'aucune' ? NULL : $_POST['company'][$i],
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
				for($i = 0 ; $i < count($_POST['function']) ; $i++){
					$langs[] = [
						'application_id'=> $app['id'],
						'function' => $_POST['function'][$i],
						'duration' => strtolower($_POST['function'][$i]) != 'aucune' ? NULL : $_POST['duration'][$i],
						'company'=> strtolower($_POST['function'][$i]) != 'aucune' ? NULL : $_POST['company'][$i],
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


		$levels = $this->Crud->get_all('aeronautical_experience_list',NULL,'function_name','asc');
		$options = [];
		foreach($levels as $coutry){
			$options[$coutry['id']] = $coutry['function_name'];
		}
		$data_list_id = 'function';

		$select       = [];
		foreach(['function','duration','company'] as $column){


			$this->data['control'][$column.'[]'] = form_input(
				$this->inputarray->getArray(
					$column.'[]','text',
					lang($column),
					 NULL,
					$column == 'duration' ? FALSE : TRUE,
					[
						'list'=>$data_list_id == $column ? $data_list_id : NULL,
						'style'=> $column == 'function' ?  FALSE :'display:none' ,
						'data-change'=>$column == 'function' ? 'true' : 'false',
					]
				)

			);

		}
		$this->data['control']['data-list'] = $this->load->view('datalist',['name'=>$data_list_id,'list'=>$options],TRUE);



		if($row)
		{

			$this->data['data'] = [];
			foreach($row as $value)
			{
				$line = [];
				$line['function[]'] = form_input(
					$this->inputarray->getArray('function[]','text',lang('function'),$value['function'],TRUE,
					['list'=>$data_list_id ,'data-change'=>'true'  ]));
				$line['duration[]'] = form_input(
					$this->inputarray->getArray('duration[]','text',lang('duration'),$value['duration'],FALSE,
					['style'=>strtolower($value['function']) == 'aucune' ?  FALSE :'display:none' ]));
				$line['company[]'] = form_input(
					$this->inputarray->getArray('company[]','text',lang('company'),$value['company'],FALSE,
					['style'=>strtolower($value['function']) == 'aucune' ?  FALSE :'display:none']));

				array_push($this->data['data'],$line);

			}
		}
		
		$this->load->view('front/apply/pnc/expirience',$this->data);
		$this->load->view('front/apply/js/calendar_js');
	}







}


