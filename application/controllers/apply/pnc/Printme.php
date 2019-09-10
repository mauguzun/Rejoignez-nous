<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Printme extends Apply_Pnc_Controller
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
		redirect(base_url().Apply_Pnc_Controller::$map.'/apply/index/'.$offer_id);

		$query = $this->Crud->get_joins(
			$this->table,
			[
				"users"=>"users.id = $this->table.user_id",
				"candidates"=>"users.id = candidates.user_id",

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
			users.email as email,
			countries.name as country,
			last_level_education.*,
			application_medical_aptitude.date as medical_date,
			application_eu_area.*,
			application_english_frechn_level.*,
			hr_offer_education_level.level as education_level,
			application_languages_level.* ,candidates.*",
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
		foreach($more_lang as $row){
			$query['more_lang'][$row['language']] = $row['level'];
		}



		$query['handicaped'] = $this->_have($query['handicaped']);





		$pnc_query = $this->Crud->get_all('aeronautical_experience',["application_id"=>$app['id']] );
		$query['pnc_exp'] = $pnc_query;

		$query['application_cfs'] = $this->Crud->get_row(['application_id'=>$app['id']],'application_cfs');
		$emp = $this->Crud->get_row(['application_id'=>$app['id']],'application_empoy_center');

		$query['employ_center'] = $this->_have($emp['employ_center']);



		//$this->load->view('front / apply / printer',['query'=>$query]);
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

		if(strpos($arg, ','))
		{
			$arr = explode(',',$arg);
			return max($arr) > 0  ? $have[1] : $have[0];
		}
		return $arg > 0  ? $have[1] : $have[0];

	}



}


