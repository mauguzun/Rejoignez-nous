<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Printme extends Apply_Un_Controller
{

	protected $step = 'printme';
	protected $table = 'application';

	public function __construct()
	{
		parent::__construct('user/offers');
		$this->load->language('admin');

	}

	public function index($app_id=NULL)
	{

		$app = $this->Crud->get_row(['id'=>$app_id],'application');
		$this->load->language('admin');

		
		
		if(!$app | $app['filled'] == 0)
		redirect(redirect(base_url().'apply/unsolicited/Apply/index'));


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
			users.birthday as birthday,  users.email as email ,users.handicaped as handicaped,
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
		}
		return $arg > 0  ? $have[1] : $have[0];
	}



}


