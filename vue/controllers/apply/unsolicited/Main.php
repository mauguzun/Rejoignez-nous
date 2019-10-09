<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*
*/
class Main extends Apply_Un_Controller{

	protected $step = 'main';

	public function __construct(){
		parent::__construct();
	}

	public function index($id = null){

		// 1 check if ok ?

		if(isset($_GET['fill_form'])){
			$this->session->set_flashdata('message',lang('fill_form'));
		}
	
		$app = $this->get_application($id);
		
		$id_for_redirect = $app ? $app['id'] : NULL;	
		$this->redirect_if_account_not_filled('/apply/unsolicited/main/index/'.$id_for_redirect);
		
		$this->set_validate();

		// check form validation
		if(isset($_POST['first_name']) && $this->form_validation->run() === true){
		
			$_POST['user_id'] = $this->user_id;
			$_POST['unsolicated'] = 1;
			
			
			if(isset($_POST['change_acc'])){
				unset($_POST['change_acc']);	
				$this->update_user_account($_POST);
			}
			
			
			// id not exist we create applicaiton
			if(!$app){
				$app['id'] = $this->Crud->add($_POST,$this->get_table_name($this->step));
				$this->set_print_link($app['id']);
			} 
			else{
				$this->Crud->update(['id'=>$app['id']],$_POST,$this->get_table_name($this->step));
			}
	
			redirect($this->apply);
			
		}
		else{
			$this->session->set_flashdata('message',validation_errors());
		}

		$this->show_header([lang('unsolicited_application_applys'),lang('unsolicited_application_applys'),lang('unsolicited_application_applys')]);
		$this->open_form($app);
		
		$this->show_main($app);
		$this->load->view('front/apply/close');
		$this->show_footer();

	}

	private function set_validate(){
				

		$this->form_validation->set_rules('address', lang('address'), 'trim|required|max_length[255]');
		$this->form_validation->set_rules('phone', lang('phone'), 'trim|required|regex_match[/^[- +()]*[0-9][- +()0-9]*$/ ]|max_length[20]');
		$this->form_validation->set_rules('phone_2', lang('phone'), 'trim|regex_match[/^[- +()]*[0-9][- +()0-9]*$/]|max_length[20]');
		$this->form_validation->set_rules('zip', lang('zip'), 'trim|required|max_length[10]');
		$this->form_validation->set_rules('country_id', lang('country_id'), 'trim|required|numeric');
		$this->form_validation->set_rules('city', lang('city'), 'trim|required|max_length[255]');
		$this->form_validation->set_rules('first_name', lang('first_name'), 'trim|required');
		$this->form_validation->set_rules('last_name', lang('last_name'), 'trim|required');
	}



}

