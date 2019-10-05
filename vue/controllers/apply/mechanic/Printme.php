<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Printme extends Apply_Mechanic_Controller
{

	protected $step = 'printme';
	protected $table = 'application';

	public function __construct()
	{
		parent::__construct('user/offers');

	}

	public function index($offer_id,$app_id = NULL)
	{

	
		$app = $this->get_print_application($offer_id,$app_id);

		if(!$app | $app['filled'] == 0 )
		redirect(base_url().Apply_Mechanic_Controller::$map.'/apply/index/'.$offer_id);
		

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
						users.birthday as birthday,  users.email as email ,users.handicaped as handicaped,

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
		
		//$this->load->view('front/apply/printer',['query'=>$query]);
		require_once("application/libraries/dompdf/vendor/autoload.php");

		$dompdf = new  Dompdf\Dompdf();
		$dompdf->loadHtml($this->load->view('front/apply/printer',['query'=>$query],TRUE));

		$dompdf->setPaper('A4');

		
		$dompdf->render();
		$dompdf->stream(url_title($query['first_name'].$query['last_name']), array("Attachment"=> false));

		exit(0);

	}

	private function _have($arg)
	{

		$have = lang('yes_toogle');


		if(strpos($arg, ',')){
			$arr = explode(',',$arg);
			return max($arr) > 0  ? $have[1] : $have[0];
		}else
		
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


