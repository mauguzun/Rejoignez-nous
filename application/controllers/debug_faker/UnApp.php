<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once 'vendor/autoload.php';
class UnApp extends CI_Controller{


	private    $faker;
	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->faker = Faker\Factory::create();
		echo "<pre>";
		$fake =  $this->Crud->get_all('users',['ip_address'=>'fake']);
		
					$function = $this->Crud->get_array('id','function','functions');

		foreach($fake as $user){
			
		
			$user_id = $user['id'];
			
			$application = [
				'user_id' => $user_id,
				'address' => $this->faker->streetAddress,
				'zip'=> $this->faker->postcode  ,
				'city'=> $this->faker->city  ,
				'filled'=>1,
				'country_id'=> rand(2,240) ,
				'phone'=>  $this->faker->phoneNumber               ,
				'unsolicated'=>  1,
			
			];
			$app_id = $this->Crud->add($application,'application');
			
			var_dump($application);
			
			$positon = [
				'application_id'=>$app_id,
				'contract_id'=>rand(1,5),
				'function'=>$function[rand(37,44)]];
				
			var_dump($positon);
			
			$this->Crud->add($positon,'application_un');
			
			
			
			$education = [
				'university'=>$this->faker->city  ,
				'education_level_id'=>rand(1,8),
				'application_id'=>$app_id,
				'studies'=>$this->faker->city 
			];
			
			$this->Crud->add($education , 'last_level_education');
			
			var_dump($education);
			
			
			$lang = [
				'french_level'=> rand(1,5),
				'english_level'=>rand(1,5),
				'application_id'=>$app_id];
			
			$this->Crud->add($lang,'application_english_frechn_level');
			
			
			var_dump($lang);
			
			
			
			$exp = [
				'area' => $this->faker->streetAddress,
				'duration' => rand(1,5),
				'managerial' => rand(1,5),
				'application_id'=> $app_id,
			]; 
					
			var_dump($exp);
			$this->Crud->add($exp,'application_hr_expirience');
			
			$misc = [
				'application_id'=>$app_id,
				'car'=>1,
				'aviability'=>'2019-02-06',
				'salary'=>rand(10000,20000),
				'medical_restriction'=>1
			];
			
			
				$this->Crud->add($misc,'applicaiton_misc');
			var_dump($misc);
		
			
			$cover  =  'c9b55cf738906013646ba5d6339b5279.pdf';
			$cv =  '57a4cdcf8ef6885cc82e49ab490bd152.pdf'; 
			
			$this->Crud->add([
					'application_id'=>$app_id,
					'user_id'=>$user_id,
					'file'=>$cover,
					'type'=>'covver_letter'	
			
				],'application_files');
				
				$this->Crud->add([
					'application_id'=>$app_id,
					'user_id'=>$user_id,
					'file'=>$cv,
					'type'=>'cv'	
			
				],'application_files');
			
		
			
		}
	
		//$this->Crud->add();
		
		//<a download="" href="http://localhost/asldomain/user/getfile?url=http://localhost/asldomain/./user_uploads/covver_letter/c9b55cf738906013646ba5d6339b5279.pdf"><i class="fas fa-download"></i></a>
		
		//'position'=>'application_un',
	
		
		 
		
	}

}
