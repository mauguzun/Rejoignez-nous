<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once 'vendor/autoload.php';
class User extends CI_Controller{


	private    $faker;
	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->faker = Faker\Factory::create();


		$activites = array_column($this->Crud->get_all('activities'),'id');



		for($i = 0; $i < 1000 ; $i++){

			$user = [
				'username' => $this->faker->userName,
				'email' => $this->faker->email,
				'ip_address'=>'fake',
				'created_on'=>time(),
				'password'=>rand(11231,4),

             
			];
            
			

			$id     = $this->Crud->add($user,'users');
		

			if($id){
				//8
				echo $this->Crud->add( ['user_id'=>$id,'group_id'=>8] ,'users_groups');
				echo $this->Crud->add( ['user_id'=>$id,
						'first_name'=>$this->faker->userName,			
						'last_name'=>$this->faker->userName,
					] ,'candidates');
				
			}



		}

	}

}
