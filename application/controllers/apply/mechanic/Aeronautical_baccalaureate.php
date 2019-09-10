<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Aeronautical_baccalaureate extends Apply_Mechanic_Controller
{

	protected $step = 'aeronautical_baccalaureate';


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

		$this->form_validation->set_rules('school', lang('school'), 'trim|required|max_length[250]');

		$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));

		if($this->form_validation->run() === TRUE ){

			$errors = FALSE;
			$required = [
				'complementary_mention_b1'=>'complementary_mention_b2',
				'licenses_b1'=>'licenses_b2'
			];

			foreach($required as $key=>$value){
				if($_POST[$key] == 0 & $_POST[$value] == 0 ){

					$this->session->set_flashdata('message',lang('required_one_of_them'). ' : '.lang($key).' or '.lang($value));

					$errors = TRUE;
				}
			}
			if($_POST['aeronautical_baccalaureate'] == 0 ){
				$this->session->set_flashdata('message',lang('aeronautical_baccalaureate'));

				$errors = TRUE;
			}
			if(!$errors){
				$_POST['application_id'] = $app['id'];
				// $this->Crud->update_or_insert($_POST,$this->get_table_name($this->step));
				if($row){
					$this->savehistory($app['id'],$row,$_POST,'application_id',$app['id'],$this->get_table_name($this->step),['id']);
				}
				$this->Crud->update_or_insert($_POST,$this->get_table_name($this->step));
				$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));
				redirect($this->apply.'/'.$offer_id);
			}
		}
		$this->show_header([$offer['title'],$offer['title'],$offer['title']]);
		$this->open_form($offer_id,$offer);
		$this->show($row);
		$this->load->view('front/apply/close');
		$this->show_footer();
	}

	protected function show($user)
	{


		foreach(['aeronautical_baccalaureate','complementary_mention_b1','complementary_mention_b2'] as  $column){
			$value = isset($user[$column]) ? $user[$column]  : 0;
			$this->data['control']["{$column}_l"] = form_label(lang($column));
			$this->data['control'][$column] =
			form_dropdown($column, [0=>lang('no'),1=>lang('yes')],$value,['class'=>'form-control']);
		}

		foreach(['school'] as $oneDate){

			$activity = (isset($user[$oneDate])) ?$user[$oneDate] : $this->form_validation->set_value($oneDate);

			$this->data['control']["{$oneDate}_l"] = form_label(lang($oneDate));
			$date_picker = $this->inputarray->getArray($oneDate,'text',
				lang($oneDate),$activity,TRUE);
			$this->data['control'][$oneDate] = form_input( $date_picker);
		}

		foreach(['licenses_b1','licenses_b2'] as  $column){
			$value = isset($user[$column]) ? $user[$column]  : 0;
			$this->data['control']["{$column}_l"] = form_label(lang($column));
			$this->data['control'][$column] =
			form_dropdown($column, [0=>lang('no'),1=>lang('yes')],$value,['class'=>'form-control']);
		}

		$this->load->view('front/apply/part/form',$this->data);
	}







}


