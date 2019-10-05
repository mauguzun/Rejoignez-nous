<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Mainlang extends Apply_Un_Controller
{

	protected $step = 'mainlang';


	public function __construct()
	{
		parent::__construct('user/offers');

	}

public function index($id = null){
	{


			$app = $this->get_application($id);
			if(!$app)
			redirect(base_url().'apply/unsolicited/main/'.FILL_FORM);


		$this->form_validation->set_rules('english_level', lang('english_level'), 'trim|max_length[2]');
		$this->form_validation->set_rules('french_level', lang('french_level'), 'trim|max_length[2]');


		$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));
		// check form validation


		if(  isset($_POST['english_level']) && $this->form_validation->run() === true )
		{


			// we have app lets continute
			if($row)
			{

				$this->savehistory($app['id'],$row,$_POST,'application_id',$row['application_id'],$this->get_table_name($this->step),
					['application_id']);

				$this->Crud->update(['application_id'=>$app['id']],$_POST,$this->get_table_name($this->step));
				$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));

			}
			else
			{

				$_POST['application_id'] = $app['id'];
				$this->Crud->add($_POST,$this->get_table_name($this->step));
			}
			$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));

		}
		else
		{

			$message = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));



			$this->session->set_flashdata('message',$message);

		}
		
		$this->show_header([lang('unsolicited_application_applys'),lang('unsolicited_application_applys'),lang('unsolicited_application_applys')]);
		$this->open_form($app);

		$this->show_mainlang($row);
		$this->load->view('front/apply/close');
		$this->show_footer();

	}





}


