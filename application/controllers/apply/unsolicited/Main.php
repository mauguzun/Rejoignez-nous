<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*
*/
class Main extends Apply_Un_Controller
{

	protected $step = 'main';

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{

		// 1 check if ok ?

		if(isset($_GET['fill_form']))
		{
			$this->session->set_flashdata('message',lang('fill_form'));
		}
		

		$cand = $this->Crud->get_row(['user_id'=>$this->user_id],'candidates');
		if(!$cand){
				redirect(base_url().'user/profile?q=fill_form&url_back='.$paqes[0]);
		}
		foreach(['civility','first_name','last_name','birthday'] as $value){
			if( empty($cand[$value]) ){
				$paqes = $this->get_pagination(NULL);
				redirect(base_url().'user/profile?q=fill_form&url_back='.$paqes[0]);
			}
		}



		$this->form_validation->set_rules('address', lang('address'), 'trim|required|max_length[255]');
		$this->form_validation->set_rules('phone', lang('phone'), 'trim|required|regex_match[/^[- +()]*[0-9][- +()0-9]*$/ ]|max_length[20]');
		$this->form_validation->set_rules('phone_2', lang('phone'), 'trim|regex_match[/^[- +()]*[0-9][- +()0-9]*$/]|max_length[20]');
		$this->form_validation->set_rules('zip', lang('zip'), 'trim|required|max_length[10]');
		$this->form_validation->set_rules('country_id', lang('country_id'), 'trim|required|numeric');
		$this->form_validation->set_rules('city', lang('city'), 'trim|required|max_length[255]');

		$app = $this->get_application();
		

		// check form validation
		if(isset($_POST['zip']) && $this->form_validation->run() === true)
		{

			if(!$app)
			{
				$_POST['user_id'] = $this->user_id;
				$_POST['unsolicated'] = 1;
				$app = $this->Crud->add($_POST,$this->get_table_name($this->step));
			}
			else
			{
				// update
				$_POST['user_id'] = $this->user_id;
				$_POST['unsolicated'] = 1;

				$this->savehistory($app['id'],$app,$_POST,'id',$app['id'],$this->get_table_name($this->step),
					['id','filled','unsolicated','manualy','call_id','application_statuts','opinion_decision','opinion_test','opinion_interview','opinion_folder','usser_id','deleted', 'add_date','update_date']);



				$this->Crud->update(['id'=>$app['id']],$_POST,$this->get_table_name($this->step));

			}

			$app = $this->get_application();
			redirect($this->apply.'/'.$app['id']);
		}
		else
		{
			$message = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->session->set_flashdata('message',$message);
		}



		$this->show_header([lang('unsolicited_application_applys'),lang('unsolicited_application_applys'),lang('unsolicited_application_applys')]);
		$this->open_form();
		
		
		if($app['deleted'] == 1)
		{
			$this->show_main(NULL);
		}
		else
		{
			
			$this->show_main($app);
		}


		$this->load->view('front/apply/close');
		$this->show_footer();

	}





}


