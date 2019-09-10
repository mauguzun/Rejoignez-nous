<?php

class Usermenu{

	public function get($logedIn = false){
		/*
		$menu =
		[

		'offers'=>'offer_list',

		];

		if($logedIn)
		{

		$menu [ 'user/profile'] = 'edit_user';
		$menu ['user/appliedoffers'] = 'applied_offers';
		$menu ['apply/unsolicited/main'] = 'unsolicited_application_applys';
		$menu ['user/resetpassword'] = 'email_forgot_password_link';
		$menu ['auth/logout'] = 'sign_out';

		}
		else
		{
		$menu ['auth/login'] = 'login';
		$menu ['auth/forgot_password'] = 'forgot_password_heading';



		}*/
		
		$menu = [
			'offers'=>'offer_list',
			'#contact'=>'contact',
			'apply/unsolicited/main' => 'unsolicited_application_applys',
			'policy' => 'our_recruitment_policy' ];
	        
		if($logedIn){
			$menu['auth/logout' ] =   'sign_out';
		}else{
			$menu[ 'auth/login' ] = 'login';

		}
		
	    
		$menu['#'] = [
			'user/appliedoffers' => 'applied_offers',	
			'user/profile' => 'edit_user',
			'user/resetpassword' => 'email_forgot_password_link',
		];
	         
			
		
		
		return $menu;
	}




}