<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Delete extends Apply_Un_Controller{

	protected $step = 'delete';

	public function __construct(){
		parent::__construct('user/offers');

	}

	public function index($id = NULL){

		$app = $this->application_id($id);
		
	


		$this->Crud->delete(['id'=>$id],'application');
		foreach($this->get_table_name() as $key=>$table){
			if($table != 'application'){
				$this->Crud->delete(['application_id'=>$id],$table);
			}
		
		}

		redirect(base_url().'apply/unsolicited/begin');
	}





}


