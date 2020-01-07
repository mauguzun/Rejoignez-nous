<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends  CI_Controller
{


	public function __construct()
	{
		parent::__construct('user/offers',FALSE);

	}

	public function index($id = NULL )
	{


		for($i = 0  ; $i < 200 ;$i++){
			$id = time() + $i;
			// appedn to ffer
			$this->Crud->add(
				[
					'manualy'=>1,
					'filled'=>1,

					'offer_id'=>179,
					'unsolicated_function'=>'Assistant(e) des Ressources Humaines',
					'first_name'=>'denis '. $i ,
					'last_name'=>'shabalin'. $i,
					'id'=>$id,

				],'application');
			$this->Crud->add(
				['application_id'=>$id, 'user_id'=>39,
					'file'=>'26172624_10213275261068810_7995438670988634459_o8.jpg',
					'type'=>'cv'],'application_files');
		}

	}



}


