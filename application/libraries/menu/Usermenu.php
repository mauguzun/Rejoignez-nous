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
			'policy' => 'our_recruitment_policy',
			'offers'=>'offer_list',
			'apply/new/begin' => 'unsolicited_application_applys',
			'#contact'=>'contact'
			 ];
	        
		if($logedIn){
			$menu['auth/logout' ] =   'sign_out';
		}else{
			$menu[ 'auth/login' ] = 'login';

		}
		
	    
		$menu['#'] = [
			'user/appliedoffers' => 'applied_offers',	
			'user/profile' => 'edit_user',
			
		];
	         
			
		if($logedIn){
			$menu['#']['user/resetpassword'] =   'email_forgot_password_link';
		}else{
			$menu['#']['auth/forgot_password'] = 'email_forgot_password_link';

		}
		
		return $menu;
	}




}