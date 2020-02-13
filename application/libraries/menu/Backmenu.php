<?php

class Backmenu
{

	public function get($group)
	{
		$menu = [];



		foreach($this->_menu() as $key=>$value){

			switch($key){


			
				case 'hiring_policy'  :
				case 'privacystatement' :
				case 'news':
				if(in_array($group ,[1,2,77]))
				$menu[$key] = $value;
				break;

				case 'Fields of activity and functions':

				if(in_array($group ,[1,2]))
				$menu[$key] = $value;
				break;


				case 'dashboard':
				case 'Applications in response':
				if(in_array($group ,[1,2,3,4,5,6,7]))
				$menu[$key] = $value;
				break;


				case 'offers':
				if(in_array($group ,[1,2,3,4,5,6,7]))
				$menu[$key] = $value;
				break;


				//
				case 'offers_online':
				if(in_array($group ,[1,2,3,4]))
				$menu[$key] = $value;
				break;

				case 'applications':
				if(in_array($group ,[1,2,3,4,5,6,7])) // admin + hr
				$menu[$key] = $value;
				break;



			/*	case 'applications_pnc':
				if(in_array($group ,[3]))
				$menu[$key] = $value;
				break;

				case 'applications_pnc_view':
				if(in_array($group ,[6]))
				$menu[$key] = $value;
				break;


				case 'applications_pnt':
				if(in_array($group ,[4]))
				$menu[$key] = $value;
				break;
				
				case 'applications_pnt_view':
				if(in_array($group ,[7]))
				$menu[$key] = $value;
				break;

				case 'applications_hr_view_only':
				if(in_array($group ,[5]))
				$menu[$key] = $value;
				break;
*/
				case 'offers_view_only':
				if(in_array($group ,[1,2,3,4,5,6,7]))
				$menu[$key] = $value;
				break;

				

				case 'slideshow':
				if(in_array($group ,[1,2]))
				$menu[$key] = $value;
				break;


				case 'emails':
				case 'manage_user':
				case 'settings':

				if(in_array($group ,[1]))
				$menu[$key] = $value;
				break;

				case 'sign_out':
				$menu[$key] = $value;
			}

		}
		return $menu;
	}


	private function _menu()
	{
		return
		[


		
			'Fields of activity and functions'=>[
				'fas fa-file-alt'=>

				['activity'=> 'shared/activity' ],
				['function'=> 'shared/functions' ]

			],


			'dashboard'=>[
				'fas fa-file-alt'=>
				["offers_online"=>'shared/online/?p=0&l=50&s=&orderBy=0&orderVal=desc'],

				["Applications in response"=>'shared/Applicationsinresponse'],
				["unsolicited_application"=>'shared/Applicationsinresponse?type=unsolicited'],
				["manualay_applications"=>'shared/Applicationsinresponse?type=manualy'],
				/*["unsolicited_application"=>'shared/applications?mode=5'],
				["Applications created manualy"=>'shared/applications?mode=7'],*/
			],
			'offers'=>['far fa-newspaper'=>'shared/offer?p=0&l=50&s=&orderBy=0&orderVal=desc'],
			"applications"=>['far fa-newspaper'=>'shared/applications?p=0&l=10&s=&orderBy=0&orderVal=desc&mode=0&status=&offer=&function='],
			
			/*
			'Applications in response'=>[
				'fas fa-file-alt'=>
				["Applications in response"=>'shared/Applicationsinresponse'],
				
			],*/
			
			'hiring_policy'=>['fas fa-file-alt'=>'shared/hiringpolicy'],
			'privacystatement'=>['fas fa-file-alt'=>'shared/privacystatement'],
			'news'=>['far fa-newspaper'=>'shared/news'],
			
			'manage_user'=>['fa fa-user'=>'back/user'],
			
			"automatic_email"=>['fas fa-envelope'=>'back/email'],
			
			

			'settings'=>['fas fa-cog'=>

				['settings_email' => 'back/settings_email'],
				['manage_email_template' => 'shared/email'],
				['settings_generic' => 'back/settings_generic'],
				['settings_keywords' => 'back/settings_keywords'],
				['settings_email_help' => 'back/settings_help'],
				['settings_email_contact' => 'back/settings_help/contact'],


			],

			'slideshow'=>['fas fa-pencil-alt'=>'shared/slideshow'],
			'sign_out'=>['fas fa-unlock-alt'=>'auth/logout']];

	}



}
?>