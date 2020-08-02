<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Uns_pnt extends  Pnt_Controller{

	

	public function __construct(){
		parent::__construct('user/offers');
		$this->redirect_if_account_not_filled();	
		$this->type = "uns_pnt";
	}

	public function index($app_id = null ){
		
		
	
		
		if($app_id){
			$this->app_by_id($app_id);
		}
		$this->show_header([lang('unsolicited_application_applys'),lang('unsolicited_application_applys'),lang('unsolicited_application_applys')]);
		
		
			
		$this->files();
		$this->set_statuses($this->app['id']);
		
		$offer = null ;
		$header = $this->load->view('apply_final/parts/header',[
				'offer'=>$offer,
				'offer_type'=>$this->type
		
			],true);
			
			
		$all = [
			'header'=>$header,
			'main'=>$this->get_main(),
			'eu'=>$this->get_eu(),	
			'foreignlang'=>$this->get_lang(),
			'licenses'=>$this->get_license(),
			'medical_aptitudes'=>$this->get_medical(),
			'qualification_type'=>$this->get_quality(),
			'total_flight_hours'=>$this->get_exp('total_flight_hours'),
			'expirience'=>$this->get_exp('expirience'),
			'experience_in_instructor'=>$this->get_experience_in_instructor(),
			'successive_employer'=>$this->get_successive_employer(),
			'complementary_informations'=>$this->get_complementary_informations()];
			
	
		foreach($this->uploaders as $row){
			$all[$row]=$this->get_uploader($row);
		}
		
		$this->load->view('apply_final/pnt/index',
			[
				'views'=>$all
			]);
			
		
		
		
		$this->load->view('apply_final/pnt/vue',[
				'applicaiton_id'=>$this->app ? $this->app['id'] :  null,
				'uploaders'=>$this->uploaders,
				'status'=>json_encode($this->statuses),
				'filled'=> $this->app['filled'] ,
				'type'=>$this->type,
			]);
		$this->show_footer();
	}
	
	
	public function main($offer_id=NULL){
		
		$_POST['unsolicated_type'] = 2;
		$_POST['unsolicated'] = 1;
		
		$this->form_validation->set_rules('address', lang('address'), 'trim|required|max_length[255]');
		$this->form_validation->set_rules('phone', lang('phone'), 'trim|required|max_length[20]');		
		$this->form_validation->set_rules('phone_2', lang('phone'), 'trim|max_length[20]');
		$this->form_validation->set_rules('zip', lang('zip'), 'trim|required|max_length[10]');
		$this->form_validation->set_rules('country_id', lang('country_id'), 'trim|required|numeric');
		$this->form_validation->set_rules('city', lang('city'), 'trim|required|max_length[255]');
		$this->form_validation->set_rules('first_name', lang('first_name'), 'trim|required|max_length[255]');
		$this->form_validation->set_rules('last_name', lang('last_name'), 'trim|required|max_length[255]');

		//;	
		
		// check form validation
		if(isset($_POST) &&  $this->form_validation->run() === true){
			
			if(isset($_POST['change_acc'])){
				unset($_POST['change_acc']);				
				
				$this->json['message'] = "<p>". lang('user_account_updated')."</p>";
				$userData = $_POST;
				unset($userData['application_id']);
				unset($userData['unsolicated_type']);
				unset($userData['unsolicated']);
				$this->update_user_account($userData);
			}
			
			
			if(isset($_POST['application_id'])){
				$this->app_by_id($_POST['application_id']);
			}
		
			
			if(!$this->app){
				$_POST['user_id'] = $this->user->id;
				
				$newAppId = $this->Crud->add($_POST,'application');
				$this->json['application_id'] = $newAppId;
				$this->app_by_id($newAppId);
			}
			else{
				unset($_POST['application_id']);
				$this->Crud->update(['id'=>$this->app['id']],$_POST,'application');
				$this->json['application_id'] = $this->app['id'];
			}
			
			
			$this->json['result'] = TRUE;
			$this->json['message'] = lang('saved');
			// we setup app 
			
		}
		else{
			$message = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


			$this->json['message'] = $message;
		}
		$this->show_json();
	}
     
	

}


