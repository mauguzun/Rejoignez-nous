<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// back / activity
class Sendemail extends Shared_Controller
{

	private $table = 'application';
	private $_allowed = [1,2,3,4];

	public function __construct()
	{
		parent::__construct($this->_allowed);
		$this->load->library("Uploadlist");
	}

	// doe
	public function hr($application_id)
	{

		$app   = $this->Crud->get_row(['id'=>$application_id],$this->table);

		$query = $this->Crud->get_joins(
			$this->table,
			[
				"users"=>"users.id = $this->table.user_id",
			
				"applicaiton_misc"=>"$this->table.id = applicaiton_misc.application_id",
				'countries'=>"$this->table.country_id = countries.id",
				'application_languages_level'=>"$this->table.id = application_languages_level.application_id",
				'last_level_education'=>"$this->table.id = last_level_education.application_id",
				'hr_offer_education_level'=>"last_level_education.education_level_id = hr_offer_education_level.id",
				'application_hr_expirience'=>"$this->table.id = application_hr_expirience.application_id",
				'application_english_frechn_level'=>"$this->table.id = application_english_frechn_level.application_id",

			],
			"$this->table.user_id as uid ,
			$this->table.* ,
			applicaiton_misc.*,
			users.email as email,
			countries.name as country,
			$this->table.id as aid,
			last_level_education.*,users.handicaped as handicaped,users.birthday as birthday,
			application_english_frechn_level.*,
			hr_offer_education_level.level as education_level,
			application_languages_level.* ",
			NULL,
			null,
			["{$this->table}.id" => $app['id']]);



		$query      = $query[0];

		//$query['date'] = time_stamp_to_date($query['date']);


		$lang_level = $this->Crud->get_array('id','level','language_level');
		$query['english_level'] = $lang_level[$query['english_level']];
		$query['french_level'] = $lang_level[$query['french_level']];



		$more_lang = $this->Crud->get_joins('application_languages_level',
			['language_level' => "application_languages_level.level_id  = language_level.id" ],
			'*',['application_languages_level.language'=>'ASC'],NULL,
			["application_languages_level.application_id"=>$app['id']]
		);
		$query['more_lang'] = [];
		foreach($more_lang as $row)
		{
			$query['more_lang'][$row['language']] = $row['level'];
		}
		$query['handicaped'] = $this->_have($query['handicaped']);


		$hr_expirience = $this->Crud->get_joins('application_hr_expirience',
			[
				'expirience_duration' => "application_hr_expirience.duration  = expirience_duration.id",
				'expirience_managerial' => 'application_hr_expirience.managerial = expirience_managerial.id'
			],'*',['application_hr_expirience.area'=>'ASC'],NULL,["application_hr_expirience.application_id"=>$app['id']]
		);

		$query['hr_expirience'] = $hr_expirience;


		if($query){
			//$this->load->view('front / apply / printer',['query'=>$query]);
			$html = $this->load->view('front/apply/printer',['query'=>$query],TRUE);
			$this->sendEmail($_POST['email'],"applicaion ". $app['id'] ,$html);
		}
		else
		{
			show_404();
		}


	}

	public function pnt($application_id)
	{

		$app   = $this->Crud->get_row(['id'=>$application_id],$this->table);

		$query = $this->Crud->get_joins(
			$this->table,
			[
				"users"=>"users.id = $this->table.user_id",

				"applicaiton_misc"=>"$this->table.id = applicaiton_misc.application_id",
				'countries'=>"$this->table.country_id = countries.id",
				'application_languages_level'=>"$this->table.id = application_languages_level.application_id",
				'last_level_education'=>"$this->table.id = last_level_education.application_id",
				'hr_offer_education_level'=>"last_level_education.education_level_id = hr_offer_education_level.id",
				'application_english_frechn_level'=>"$this->table.id = application_english_frechn_level.application_id",
				'application_eu_area'=>"$this->table.id = application_eu_area.application_id",
				'application_medical_aptitude'=>"$this->table.id = application_medical_aptitude.application_id"
			],
			"$this->table.user_id as uid ,
			$this->table.* ,
			$this->table.id as aid,
			applicaiton_misc.*,
			users.email as email,
			countries.name as country,
			last_level_education.*,users.handicaped as handicaped,users.birthday as birthday,
			application_medical_aptitude.date as medical_date,
			application_eu_area.*,
			application_english_frechn_level.*,
			hr_offer_education_level.level as education_level,
			application_languages_level.* ",
			NULL,
			null,
			["{$this->table}.id" => $app['id']]);



		$query      = $query[0];

		//$query['date'] = time_stamp_to_date($query['date']);


		$lang_level = $this->Crud->get_array('id','level','language_level');
		$query['english_level'] = $lang_level[$query['english_level']];
		$query['french_level'] = $lang_level[$query['french_level']];



		$query['eu_nationality'] = $this->_have($query['eu_nationality']);
		$query['can_work_eu'] = $this->_have($query['can_work_eu']);






		$more_lang = $this->Crud->get_joins('application_languages_level',
			['language_level' => "application_languages_level.level_id  = language_level.id" ],
			'*',['application_languages_level.language'=>'ASC'],NULL,
			["application_languages_level.application_id"=>$app['id']]
		);
		$query['more_lang'] = [];
		foreach($more_lang as $row)
		{
			$query['more_lang'][$row['language']] = $row['level'];
		}



		$query['handicaped'] = $this->_have($query['handicaped']);





		$pnc_query = $this->Crud->get_all('application_pnt_flight_expirience',["application_id"=>$app['id']] );
		$query['pnt_exp'] = $pnc_query;

		// pnt exp

		$pnc_query = $this->Crud->get_all('application_pnt_flight_expirience_instructor',["application_id"=>$app['id']] );
		$query['pnt_exp_inst'] = $pnc_query;

		$pnc_query = $this->Crud->get_all('application_pnt_practice',["application_id"=>$app['id']] );
		$query['pnt_practice'] = $pnc_query;


		$pnc_query = $this->Crud->get_all('application_pnt_qualification',["application_id"=>$app['id']] );
		$query['pnt_qualification'] = $pnc_query;


		$pnc_query = $this->Crud->get_all('application_pnt_total_flight_hours',["application_id"=>$app['id']] );
		$query['pnt_total_flight_hours'] = $pnc_query;

		$pnc_query = $this->Crud->get_row(["application_id"=>$app['id']],'application_fcl' );
		$query['application_fcl'] = $this->_have($pnc_query['fcl']);

		$pnc_query = $this->Crud->get_row(["application_id"=>$app['id']],'application_pnt_completary' );
		$query['pnt_completary'] = $pnc_query;


		$pnc_query = $this->Crud->get_all('application_pnt_successive_employers',["application_id"=>$app['id']]);
		$query['pnt_s'] = $pnc_query;

		if($query){
			//$this->load->view('front / apply / printer',['query'=>$query]);
			$html = $this->load->view('front/apply/printer',['query'=>$query],TRUE);
			$this->sendEmail($_POST['email'],"applicaion ". $app['id'] ,$html);
		}
		else
		{
			show_404();
		}
	}
	public function pnc($application_id)
	{

		$app   = $this->Crud->get_row(['id'=>$application_id],$this->table);

		$query = $this->Crud->get_joins(
			$this->table,
			[
				"users"=>"users.id = $this->table.user_id",
				
				"applicaiton_misc"=>"$this->table.id = applicaiton_misc.application_id",
				'countries'=>"$this->table.country_id = countries.id",
				'application_languages_level'=>"$this->table.id = application_languages_level.application_id",
				'last_level_education'=>"$this->table.id = last_level_education.application_id",
				'hr_offer_education_level'=>"last_level_education.education_level_id = hr_offer_education_level.id",
				'application_english_frechn_level'=>"$this->table.id = application_english_frechn_level.application_id",
				'application_eu_area'=>"$this->table.id = application_eu_area.application_id",
				'application_medical_aptitude'=>"$this->table.id = application_medical_aptitude.application_id"
			],
			"$this->table.user_id as uid ,
			$this->table.* ,
			applicaiton_misc.*,
			$this->table.id as aid,
			users.email as email,users.handicaped as handicaped,users.birthday as birthday,
			countries.name as country,
			last_level_education.*,
			application_medical_aptitude.date as medical_date,
			application_eu_area.*,
			application_english_frechn_level.*,
			hr_offer_education_level.level as education_level,
			application_languages_level.* ",
			NULL,
			null,
			["{$this->table}.id" => $app['id']]);



		$query      = $query[0];

		//$query['date'] = time_stamp_to_date($query['date']);


		$lang_level = $this->Crud->get_array('id','level','language_level');
		$query['english_level'] = $lang_level[$query['english_level']];
		$query['french_level'] = $lang_level[$query['french_level']];



		$query['eu_nationality'] = $this->_have($query['eu_nationality']);
		$query['can_work_eu'] = $this->_have($query['can_work_eu']);






		$more_lang = $this->Crud->get_joins('application_languages_level',
			['language_level' => "application_languages_level.level_id  = language_level.id" ],
			'*',['application_languages_level.language'=>'ASC'],NULL,
			["application_languages_level.application_id"=>$app['id']]
		);
		$query['more_lang'] = [];
		foreach($more_lang as $row)
		{
			$query['more_lang'][$row['language']] = $row['level'];
		}



		$query['handicaped'] = $this->_have($query['handicaped']);





		$pnc_query = $this->Crud->get_all('aeronautical_experience',["application_id"=>$app['id']] );
		$query['pnc_exp'] = $pnc_query;

		$query['application_cfs'] = $this->Crud->get_row(['application_id'=>$app['id']],'application_cfs');
		$emp = $this->Crud->get_row(['application_id'=>$app['id']],'application_empoy_center');

		$query['employ_center'] = $this->_have($emp['employ_center']);



		if($query){
			//$this->load->view('front / apply / printer',['query'=>$query]);
			$html = $this->load->view('front/apply/printer',['query'=>$query],TRUE);
			$this->sendEmail($_POST['email'],"applicaion ". $app['id'] ,$html);
		}
		else
		{
			show_404();
		}

	}
	public function mechanic($appliciton_id)
	{

		$app   = $this->Crud->get_row(['id'=>$appliciton_id],$this->table);

		$query = $this->Crud->get_joins(
			$this->table,
			[
				"users"=>"users.id = $this->table.user_id",
			
				"applicaiton_misc"=>"$this->table.id = applicaiton_misc.application_id",
				'countries'=>"$this->table.country_id = countries.id",
				'application_languages_level'=>"$this->table.id = application_languages_level.application_id",
				'last_level_education'=>"$this->table.id = last_level_education.application_id",
				'hr_offer_education_level'=>"last_level_education.education_level_id = hr_offer_education_level.id",
				'application_english_frechn_level'=>"$this->table.id = application_english_frechn_level.application_id",
				'application_eu_area'=>"$this->table.id = application_eu_area.application_id",
				'application_medical_aptitude'=>"$this->table.id = application_medical_aptitude.application_id",
				'aeronautical_english_level'=>"$this->table.id = aeronautical_english_level.application_id",
				'mechanic_baccalaureate'=>"$this->table.id = mechanic_baccalaureate.application_id"
			],
			"$this->table.user_id as uid ,
			$this->table.* ,
			applicaiton_misc.*,
			mechanic_baccalaureate.*,
			users.email as email,users.handicaped as handicaped,users.birthday as birthday,
			$this->table.id as aid,
			countries.name as country,
			aeronautical_english_level.lang_level as aeronautical_english_level,
			last_level_education.*,
			application_medical_aptitude.date as medical_date,
			application_eu_area.*,
			application_english_frechn_level.*,
			hr_offer_education_level.level as education_level,
			application_languages_level.* ",
			NULL,
			null,
			["{$this->table}.id" => $app['id']]);



		$query      = $query[0];

		//$query['date'] = time_stamp_to_date($query['date']);


		$lang_level = $this->Crud->get_array('id','level','language_level');
		$query['english_level'] = $lang_level[$query['english_level']];
		$query['french_level'] = $lang_level[$query['french_level']];
		$query['aeronautical_english_level'] = $lang_level[$query['aeronautical_english_level']];




		foreach(['licenses_b1','licenses_b2','complementary_mention_b1','complementary_mention_b2','aeronautical_baccalaureate'] as $value){
			$query[$value] = $this->_have($query[$value]);
		}



		$more_lang = $this->Crud->get_joins('application_languages_level',
			['language_level' => "application_languages_level.level_id  = language_level.id" ],
			'*',['application_languages_level.language'=>'ASC'],NULL,
			["application_languages_level.application_id"=>$app['id']]
		);
		$query['more_lang'] = [];
		foreach($more_lang as $row)
		{
			$query['more_lang'][$row['language']] = $row['level'];
		}



		$query['handicaped'] = $this->_have($query['handicaped']);





		$managerial = $this->Crud->get_array('id','managerial','expirience_managerial');
		$query['mec_expirience'] = $this->_get_mex_expr($app['id'],$managerial);

		if($query){
			//$this->load->view('front / apply / printer',['query'=>$query]);
			$html = $this->load->view('front/apply/printer',['query'=>$query],TRUE);
			$this->sendEmail($_POST['email'],"applicaion ". $app['id'] ,$html);
		}
		else
		{
			show_404();
		}
	}
	public function unsolicated($application_id)
	{
		$app = $this->Crud->get_row(['id'=>$application_id],$this->table);



		if(!$app)
		redirect($this->get_page('main').FILL_FORM);


		$query = $this->Crud->get_joins(
			$this->table,
			[
				"users"=>"users.id = $this->table.user_id",
				
				"applicaiton_misc"=>"$this->table.id = applicaiton_misc.application_id",
				'countries'=>"$this->table.country_id = countries.id",
				'application_languages_level'=>"$this->table.id = application_languages_level.application_id",
				'last_level_education'=>"$this->table.id = last_level_education.application_id",
				'hr_offer_education_level'=>"last_level_education.education_level_id = hr_offer_education_level.id",
				'application_hr_expirience'=>"$this->table.id = application_hr_expirience.application_id",
				'application_english_frechn_level'=>"$this->table.id = application_english_frechn_level.application_id",

			],
			"$this->table.user_id as uid ,
			$this->table.* ,
			applicaiton_misc.*,
			users.email as email,users.handicaped as handicaped,users.birthday as birthday,
			countries.name as country,
			$this->table.id as aid,
			last_level_education.*,
			application_english_frechn_level.*,
			hr_offer_education_level.level as education_level,
			application_languages_level.* ",
			NULL,
			null,
			["{$this->table}.id" => $app['id']]);



		$query      = $query[0];


		$lang_level = $this->Crud->get_array('id','level','language_level');
		$query['english_level'] = $lang_level[$query['english_level']];
		$query['french_level'] = $lang_level[$query['french_level']];


		$more_lang = $this->Crud->get_joins('application_languages_level',
			['language_level' => "application_languages_level.level_id  = language_level.id" ],
			'*',['application_languages_level.language'=>'ASC'],NULL,
			["application_languages_level.application_id"=>$app['id']]
		);
		$query['more_lang'] = [];
		foreach($more_lang as $row)
		{
			$query['more_lang'][$row['language']] = $row['level'];
		}



		$query['handicaped'] = $this->_have($query['handicaped']);





		$hr_expirience = $this->Crud->get_joins('application_hr_expirience',
			[
				'expirience_duration' => "application_hr_expirience.duration  = expirience_duration.id",
				'expirience_managerial' => 'application_hr_expirience.managerial = expirience_managerial.id'
			],'*',['application_hr_expirience.area'=>'ASC'],NULL,["application_hr_expirience.application_id"=>$app['id']]
		);

		$query['hr_expirience'] = $hr_expirience;


		$function = $this->Crud->get_joins(
			'application_un',
			[
				"application_contract"=>'application_un.contract_id =application_contract.id',
				"application_un_activity"=>'application_un.application_id =application_un_activity.application_id'

			],
			'application_un.*,application_contract.type as type ,
			GROUP_CONCAT(DISTINCT application_un_activity.activity  ) as activities,

			',

			NULL,NULL,["application_un.application_id"=>$app['id']]

		);

		$query['function'] = $function[0];

		if($query){
			//$this->load->view('front / apply / printer',['query'=>$query]);
			$html = $this->load->view('front/apply/printer',['query'=>$query],TRUE);
			$this->sendEmail($_POST['email'],"applicaion ". $app['id'] ,$html);
		}
		else
		{
			show_404();
		}


	}
	public function manualy($application_id)
	{
		$query = $this->Crud->get_joins(
			$this->table,
			[


				"applicaiton_misc"=>"$this->table.id = applicaiton_misc.application_id",
				'countries'=>"$this->table.country_id = countries.id",
				'application_languages_level'=>"$this->table.id = application_languages_level.application_id",
				'last_level_education'=>"$this->table.id = last_level_education.application_id",
				'hr_offer_education_level'=>"last_level_education.education_level_id = hr_offer_education_level.id",
				'application_hr_expirience'=>"$this->table.id = application_hr_expirience.application_id",
				'application_english_frechn_level'=>"$this->table.id = application_english_frechn_level.application_id",

			],
			"
			$this->table.* ,
			applicaiton_misc.*,
			users.handicaped as handicaped,users.birthday as birthday,
			countries.name as country,
			$this->table.id as aid,
			last_level_education.*,
			application_english_frechn_level.*,
			hr_offer_education_level.level as education_level,
			application_languages_level.* ",
			NULL,
			null,
			["{$this->table}.id" => $application_id]);



		$query = $query[0];
		$query['handicaped'] = $this->_have($query['handicaped']);
		$query['application_id'] = $application_id;
		if($query){
			$html = $this->load->view('front/apply/printer_manualy',['query'=>$query],TRUE);
			$this->sendEmail($_POST['email'],"applicaion ". $application_id ,$html);
		}
		else
		{
			show_404();
		}




	}
	private function sendEmail($to,$subject,$html)
	{
		$this->load->library('email',[
				'protocol'=>$this->email_settings['transport']
			]);


		$this->email->from($this->email_settings['sender'],$this->email_settings['email']);
		$this->email->to($to);
		$this->email->subject($subject);
		/*echo $html;*/

		require_once("application/libraries/dompdf/vendor/autoload.php");

		$dompdf = new  Dompdf\Dompdf();
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4');

		$dompdf->render();
		$pdf    = $dompdf->output();
		file_put_contents('output.pdf', $pdf);
		$this->email->attach($pdf, 'application/pdf', 'output.pdf', false);


		$this->email->message($html);
		/*return $this->email->send();*/
		return $this->email->send();
		//echo $this->email->print_debugger();

		/*echo $this->email->print_debugger();*/
	}

	private function _have($arg)
	{
		$have = lang('yes_toogle');
		if(strpos($arg, ','))
		{
			$arr = explode(',',$arg);
			return max($arr) > 0  ? $have[1] : $have[0];
		}
		return $arg > 0  ? $have[1] : $have[0];
	}

	private function _get_mex_expr($application_id,$managerial)
	{
		$mec_expirience = $this->Crud->get_row(['application_id'=>$application_id],'mechanic_offer_aeronautical_experience');
		if($mec_expirience){
			$mechanic_period = $this->Crud->get_array('id','duration','mechanic_offer_managerial');

			$mec_expirience['b737_classic'] = $mechanic_period[$mec_expirience['b737_classic']];
			$mec_expirience['b737_ng'] = $mechanic_period[$mec_expirience['b737_ng']];
			$mec_expirience['part_66_license'] = $this->_have($mec_expirience['part_66_license']) ;
			$mec_expirience['managerial_duties'] = $managerial[$mec_expirience['managerial_duties']] ;

		}
		return $mec_expirience;
	}

}
