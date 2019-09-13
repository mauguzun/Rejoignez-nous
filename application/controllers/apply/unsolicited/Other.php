<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Other extends Apply_Un_Controller
{

	protected $step = 'other';


	public function __construct()
	{
		parent::__construct('user/offers');

	}

	public function index( )
	{

		$app = $this->get_application();
		if(!$app)
		redirect($this->get_page('main').FILL_FORM);

		$this->form_validation->set_rules('aviability', lang('aviability'), 'trim|required|max_length[20]');
		$this->form_validation->set_rules('salary', lang('salary'), 'trim|numeric|required');


		$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));
		// check form validation


		if( isset($_POST['aviability']) && $this->form_validation->run() === true ){

			unset($_POST['fake_aviability']);
			$_POST['aviability'] = date_to_db($_POST['aviability']);
			// we have app lets continute
			if($row){
				$this->savehistory($app['id'],$row,$_POST,'application_id',$row['application_id'],$this->get_table_name($this->step),
					['application_id','medical_restriction']);

				$this->Crud->update(['application_id'=>$app['id']],$_POST,$this->get_table_name($this->step));
				$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));

			}
			else
			{

				$_POST['application_id'] = $app['id'];
				$this->Crud->add($_POST,$this->get_table_name($this->step));
			}
			redirect($this->apply.'/'.$app['id'].'/true');

		}
		else
		{

			$message = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


			$this->session->set_flashdata('message',$message);

		}

		$this->show_header([lang('unsolicited_application_applys'),lang('unsolicited_application_applys'),lang('unsolicited_application_applys')]);
		$this->open_form();

		$this->show_aviability($row);

		$this->data = null;

		foreach(['salary'] as $value){
			$activity = ($row)?$row[$value] : $this->form_validation->set_value($value);
			$this->data['control']["{$value}_l"] = form_label(lang($value));

			$this->data['control'][$value] = form_input(
				$this->inputarray->getArray($value,'number',lang($value),$activity,TRUE));
		}

		$have_car = isset($row)? $row['car'] : 0;

		$this->data['control']["car_l"] = form_label(lang("car"));
		$this->data['control']['car'] =
		form_dropdown('car', [0=>lang('not_have_car'),1=>lang('have_car')],$have_car,['class'=>'form-control']);

		$this->load->view('front/apply/part/form',$this->data);


		$this->load->view('front/apply/close');
		$this->show_footer();

	}




}


