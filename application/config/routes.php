<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes with
| underscores in the controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
//$route['default_controller'] = 'welcome';

/*$route['default_controller'] = 'welcome';
$route['404_override'] = 'welcome';*/


$route['default_controller'] = 'offers';
$route['404_override'] = 'offers';


$route['back/settings_help/(:any)'] = 'back/settings_help/index/$1';



$route['user/edit_user'] = 'auth/edit_user';
$route['user/logout'] = 'auth/logout';
/*$route['user/apply/(:num)'] = 'user/apply/index/$1';
*/$route['user/offer/(:num)'] = 'user/offer/index/$1';

$route['offer/(:num)'] = 'offer/index/$1';
$route['news/(:num)'] = 'news/index/$1';

$route['user/zipapp/(:num)'] = 'user/zipapp/index/$1';

/*$route['user/main/eu/(:any)'] = 'user/main/eu/index/$1';
$route['user/main/medical/(:any)'] = 'user/main/medical/index/$1';
$route['user/main/language/(:any)'] = 'user/main/language/index/$1';
$route['user/main/foreighnlanguage/(:any)'] = 'user/main/foreighnlanguage/index/$1';
$route['user/main/expirience/(:any)'] = 'user/main/expirience/index/$1';


$route['user/main/upload/(:any)/(:any)'] = 'user/main/upload/index/$1/$2';
$route['user/main/uploadajax/(:any)/(:any)'] = 'user/main/uploadajax/index/$1/$2';*/

// Shared 

$route['shared/application/(:num)'] = 'shared/application/index/$1';
$route['shared/applications/(:num)'] = 'shared/applications/index/$1';

$route['shared/applicationstatus/(:num)/(:num)'] = 'shared/applicationstatus/index/$1/$2';

$route['shared/history/(:num)'] = 'shared/history/index/$1';
$route['shared/zipofferuser/(:num)/(:num)'] = 'shared/zipofferuser/index/$1/$2';
$route['shared/printofferuser/(:num)/(:num)'] = 'shared/printofferuser/index/$1/$2';

$route['shared/apphistory/(:num)'] = 'shared/apphistory/index/$1';


$route['back'] = 'back/main';
$route['translate_uri_dashes'] = FALSE;
