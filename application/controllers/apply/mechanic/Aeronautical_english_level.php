<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Aeronautical_english_level extends Apply_Mechanic_Controller
{

	protected $step = 'aeronautical_english_level';


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

		$this->form_validation->set_rules('aeronautical_english_level', lang('function'), 'trim|numeric');
		$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));

		if($this->form_validation->run() === TRUE ){
			$_POST['application_id'] = $app['id'];
			if($row )
			{
				$this->savehistory($app['id'],$row,$_POST,'application_id',$app['id'],$this->get_table_name($this->step));
			}
			$this->Crud->update_or_insert($_POST,$this->get_table_name($this->step));
			$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));
			redirect($this->apply.'/'.$offer_id);
		}
		$this->show_header([$offer['title'],$offer['title'],$offer['title']]);
		$this->open_form($offer_id,$offer);
		$this->show($row);
		$this->load->view('front/apply/close');
		$this->show_footer();
	}

	protected function show($app)
	{


		$options = [];
		foreach($this->Crud->get_all("language_level",null,'id','asc') as $value){
			$options[$value['id']] = $value['level'];
		}

		foreach(['lang_level'] as $column){
			$this->data['control']["x"] = lang('aeronautical_english_level');
			$this->data['control'][$column] = form_dropdown($column, $options,($app) ? $app[$column]: NULL,['class'=>'form-control']);

		}
		$this->load->view('front/apply/part/form',$this->data);

	}







}


