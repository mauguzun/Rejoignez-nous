<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Cfs extends Apply_Pnc_Controller
{

	protected $step = 'cfs';

	public function __construct()
	{
		parent::__construct('user/offers');

	}

	public function index($offer_id)
	{

		$offer_row = $this->errors($offer_id);


		$offer     = $this->errors($offer_id);
		if(!$offer)
		return ;

		$app = $this->application_id($offer_id);
		if(!$app)
		{
			$paqes = $this->get_pagination($offer_id);
			redirect($paqes[1].FILL_FORM);
		}

		$this->form_validation->set_rules('safety_training_certificate_date', lang('safety_training_certificate_date'), 'trim|required|max_length[12]');
		$this->form_validation->set_rules('safety_training_certificate_organization', lang('safety_training_certificate_organization'), 'trim|max_length[250]');

		
		if ($this->form_validation->run() === TRUE) {

            $_POST['safety_training_certificate_date'] = date_to_db($_POST['safety_training_certificate_date'])  ;
            $_POST['application_id'] = $app['id'];
            
            $row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));
            if($row){
				$this->savehistory($app['id'],$row,$_POST,'application_id',$app['id'],$this->get_table_name($this->step));
			}
            $this->Crud->update_or_insert($_POST,$this->get_table_name($this->step));
			redirect($this->apply.'/'.$offer_id);
        }
       
		
		$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));
		$this->show_header([$offer_row['title'],$offer_row['title'],$offer_row['title']]);
		$this->open_form($offer_id,$offer_row);
		$this->show($row);
		$this->load->view('front/apply/close');
		$this->show_footer();

	}

	protected function show($date)
	{
		foreach(['safety_training_certificate_date'] as $oneDate)
		{

			$activity = (isset($date[$oneDate])) ?  date_to_input($date[$oneDate])  : $this->form_validation->set_value($oneDate);

			$this->data['control']["{$oneDate}_l"] = form_label(lang($oneDate));
			$date_picker = $this->inputarray->getArray($oneDate,'search',
				lang($oneDate),$activity,TRUE,['data-calendar'=>true]);
			$this->data['control'][$oneDate] = form_input( $date_picker);
		}


		foreach(['safety_training_certificate_organization'] as $column)
		{

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
	}



}


