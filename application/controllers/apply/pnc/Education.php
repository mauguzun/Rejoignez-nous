<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Education extends Apply_Pnc_Controller
{

	protected $step = 'education';


	public function __construct()
	{
		parent::__construct('user/offers');

	}

	public function index($offer_id)
	{
		$offer_row = $this->errors($offer_id);
		$offer     = $this->errors($offer_id);
		if(!$offer){
			return ;
		}
		$app = $this->application_id($offer_id);
		if(!$app)
		redirect($this->get_page($offer_id,'main').FILL_FORM);


		$can_update = FALSE;
		$this->form_validation->set_rules('education_level_id', lang('education'), 'trim|required|numeric');

		$app = $this->application_id($offer_id);


		if($this->form_validation->run() === TRUE){

			if($this->input->post('education_level_id') != '1'){
				//$this->form_validation->set_rules('university', lang('university'), 'trim | required | max_length[255]');
				$this->form_validation->set_rules('studies', lang('studies'), 'trim|required|max_length[255]');

				if($this->form_validation->run() === TRUE){
					$can_update = TRUE;
				}
			}
			else
			{
				$can_update = TRUE;
			}
		}


		if($can_update){

			$sfc = [
				'safety_training_certificate_date'=> date_to_db($_POST['safety_training_certificate_date']) ,
				'safety_training_certificate_organization'=> $_POST['safety_training_certificate_organization'] ,

				'application_id' =>$app['id']];

			unset($_POST['safety_training_certificate_date']);
			unset($_POST['safety_training_certificate_organization']);


			$_POST['application_id'] = $app['id'];
			$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));
			if($row)
			{
				$this->savehistory($app['id'],$row,$_POST,'application_id',$app['id'],$this->get_table_name($this->step),
					['application_id'],0);
			}

			$this->Crud->update_or_insert($_POST,$this->get_table_name($this->step));
		/*	redirect($map);*/


			$row = $this->Crud->get_row(['application_id'=>$app['id']],'application_cfs');
			if($row)
			{
				$this->savehistory($app['id'],$row,$sfc,'application_id',$app['id'],'application_cfs');
			}
			$this->Crud->update_or_insert($sfc,'application_cfs');
			redirect($this->apply.'/'.$offer_id);
		}
		else
		{
			$message = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->session->set_flashdata('message',$message);
		}

		$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));
		$this->show_header([$offer_row['title'],$offer_row['title'],$offer_row['title']]);
		$this->open_form($offer_id,$offer_row);
		$this->show_education($row);

		$this->data = null;


		$date = $this->Crud->get_row(['application_id'=>$app['id']],'application_cfs');
		// show cfs
		foreach(['safety_training_certificate_date'] as $oneDate){

			$activity = (isset($date[$oneDate])) ?  date_to_input($date[$oneDate])  : $this->form_validation->set_value($oneDate);

			$this->data['control']["{$oneDate}_l"] = form_label(lang($oneDate));
			$date_picker = $this->inputarray->getArray($oneDate,'search',
				lang($oneDate),$activity,TRUE,['data-calendar'=>true]);
			$this->data['control'][$oneDate] = form_input( $date_picker);
		}


		foreach(['safety_training_certificate_organization'] as $column){

			$this->data['control']["{$column}_l"] = form_label(lang($column));

			$this->data['control'][$column] = form_input(
				$this->inputarray->getArray(
					$column,null,
					lang($column),
					($date) ? $date[$column]: NULL,
					$column == 'motivation' ? TRUE : FALSE
				));
		}

		$this->load->view('front/apply/part/form',$this->data);
		//
		$this->load->view('front/apply/close');
		$this->show_footer();
	}







}


