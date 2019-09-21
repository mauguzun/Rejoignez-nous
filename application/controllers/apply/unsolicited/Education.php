<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Education extends Apply_Un_Controller{

	protected $step = 'education';


	public function __construct(){
		parent::__construct('user/offers');

	}

	public function index($id = null){
		{

			$app = $this->get_application($id);
			if(!$app)
			redirect(base_url().'apply/unsolicited/main/'.FILL_FORM);



			$can_update = FALSE;
			$this->form_validation->set_rules('education_level_id', lang('education'), 'trim|required|numeric');



			if($this->form_validation->run() === TRUE){

				if($this->input->post('education_level_id') != '1'){
					//$this->form_validation->set_rules('university', lang('university'), 'trim | required | max_length[255]');
					$this->form_validation->set_rules('studies', lang('studies'), 'trim|required|max_length[255]');

					if($this->form_validation->run() === TRUE){
						$can_update = TRUE;
					}
				}
				else{
					$can_update = TRUE;
				}
			}


			if($can_update){
				$_POST['application_id'] = $app['id'];
				$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));
				if($row){
					$this->savehistory($app['id'],$row,$_POST,'application_id',$app['id'],$this->get_table_name($this->step),
						['application_id'],0);
				}

				$this->Crud->update_or_insert($_POST,$this->get_table_name($this->step));
				redirect($this->apply);
			}
			else{
				$message = (validation_errors() ? validation_errors() :
					($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

				$this->session->set_flashdata('message',$message);

			}

			$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));

			$this->show_header([lang('unsolicited_application_applys'),lang('unsolicited_application_applys'),lang('unsolicited_application_applys')]);
			$this->open_form($app);
			$this->show_education($row);
			$this->load->view('front/apply/close');
			$this->show_footer();
		}




	}

}
