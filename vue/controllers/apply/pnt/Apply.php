<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Apply extends Apply_Pnt_Controller{

	protected $step = 'apply';

	public function __construct(){
		parent::__construct('user/offers');

	}

	public function index($offer_id,$myStep = null){
		{

			$app    = $this->application_id($offer_id);







			$tables = $this->get_table_name();

			foreach($tables as $key=>$value){
				if($value == 'application_files' | $value == 'application' /*| $value == 'application_languages_level'*/  ){
					unset($tables[$key]);
				}
			}

			foreach($tables as $tab=>$table){
				if(!$this->Crud->get_row(['application_id'=>$app['id']],$table)){
					$url = $this->get_page($offer_id,$tab);
					if($url){
						redirect($url.FILL_FORM);
					}

				}
				else
				if($table == 'applicaiton_misc'){
					$query = $this->Crud->get_row( ['application_id'=>$app['id']],$table);
					if($query['salary'] == null){
						$url = $this->get_page($offer_id,'other');
						redirect($url.FILL_FORM);
					}

				}
			}
			if($myStep != null){
				foreach(['covver_letter'] as $type){
					if(count($this->Crud->get_all('application_files',
								['application_id'=>$app['id'] ,'deleted'=>0  ,'type'=>$type])) == 0){



						$url = $this->get_page($offer_id,$type);
						if($url){
							redirect($url.FILL_FORM);
						}

					}
				}
			}
			foreach(['cv',
					'attestation_of_medical_fitness',
					'certificate_of_flang',
					'carnet_of_flight',
					'attestation',
					'attestation_of_irme',
					'id_photo'] as $type){
				if(count($this->Crud->get_all('application_files',
							['application_id'=>$app['id'] ,'deleted'=>0  ,'type'=>$type])) == 0){
					$url = $this->get_page($offer_id,$type);
					if($url){
						redirect($url.FILL_FORM);
					}

				}
			}

			$this->Crud->update(['id'=>$app['id']],['filled'=>1],'application');
			$this->application_done_email($app['id']);
			redirect($this->get_page($offer_id,'main'));

			/*if( $this->Crud->get_row(['id'=>$app['id'],'filled'=>1],'application')){
			$this->_errors[] = anchor(base_url().'user/offers/',lang('you_are_applied'));

			}else{
			$this->Crud->update(['id'=>$app['id']],['filled'=>1],'application');
			$this->_errors[] = anchor(base_url().'user/offers/',lang('you_are_applied'));

			}

			$this->show_header();
			$this->load->view('front/parts/messages',['messages'=>$this->_errors]);
			$this->show_footer();*/

		}




	}
}

