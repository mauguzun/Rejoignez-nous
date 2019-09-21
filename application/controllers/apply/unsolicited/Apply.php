<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Apply extends Apply_Un_Controller{

	protected $step = 'apply';

	public function __construct(){
		parent::__construct('user/offers');

	}

	public function index($app_id,$myStep = null){
		{

			$app = $this->get_application($app_id);
			if(!$app){
				redirect(base_url().'apply/unsolicited/main/'.FILL_FORM);
			}



			$tables = $this->get_table_name();

			unset($tables['cv']);
			unset($tables['covver_letter']);
			unset($tables['main']);

			foreach($tables as $tab=>$table){
				if(!$this->Crud->get_row(['application_id'=>$app['id']],$table)){
					$url = $this->get_page($tab,$app_id);
					if($url){
						redirect($url.FILL_FORM);
					}

				}
			}
			
			if($myStep != null){
				
				
				foreach(['covver_letter'] as $type){
					if(count($this->Crud->get_all('application_files',
								['application_id'=>$app['id'] ,'deleted'=>0  ,'type'=>$type])) == 0){



						$url =
						 base_url().Apply_Un_Controller::$map.'/'.$type.'/index/'. $app['id'];
						
					
					
						if($url){
							redirect($url.FILL_FORM);
						}

					}
				}
			}
			foreach(['cv'] as $type){
				if(count($this->Crud->get_all('application_files',
							['application_id'=>$app['id'] ,'deleted'=>0  ,'type'=>$type])) == 0){



					$url = $this->get_page($type,$app_id);
					if($url){
						redirect($url.FILL_FORM);
					}

				}
			}

			$this->Crud->update(['id'=>$app['id']],['filled'=>1],'application');
			$this->application_done_email($app['id']);
			redirect($this->get_page('main',$app_id));


		}



	}

}


