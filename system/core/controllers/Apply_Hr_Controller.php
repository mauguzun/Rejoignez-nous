<?

class Apply_Hr_Controller extends Apply_Controller
{
	protected $user_id;
	static public $map = "apply/hr";
	protected $apply  ;
	protected $delete;
	protected $printme;

	protected 	$pages = [
		'main',
		'education',
		'foreignlang',
		'expirience',
		'aviability',
		'other',
		'cv',
		'covver_letter',
	];


	public function __construct($page = NULL,$meta = NULL )
	{

		parent::__construct();
		$this->apply = base_url().'apply/hr/apply/index/';
		$this->delete = base_url().'apply/hr/delete/index/';
		$this->printme = base_url().'apply/hr/printme/index/';

	}

	public function get_pagination($offer_id)
	{

		$pages = $this->pages;
		return $this->make_form_link($pages,$offer_id,Apply_Hr_Controller::$map);
	}

	public function get_page($offer_id,$page)
	{
		$pages = $this->pages;
		foreach($pages as $key=>&$value){
			if($page == $value)
			return  base_url().Apply_Hr_Controller::$map.'/'.$value.'/index/'.$offer_id;
		}
		return NULL;

	}

	protected function get_table_name($step = NULL)
	{
		$tables = [
			'main'=>'application',
			'education'=>'last_level_education',
			'mainlang'=>'application_languages_level',
			'foreignlang'=>'application_languages_level',
			'expirience'=>'application_hr_expirience',
			'aviability'=>'applicaiton_misc',
			'other'=>'applicaiton_misc',
			
			'cv'=>'application_files',
			'covver_letter'=>'application_files',

		];

	
	
		if($step)
		return $tables[$step];
		else
		return $tables;
	}

	protected function get_print_html($offer_id,$app_id = NULL)
	{

		$app   = $this->get_print_application($offer_id,$app_id);

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
				'application_hr_expirience'=>"$this->table.id = application_hr_expirience.application_id",
				'application_english_frechn_level'=>"$this->table.id = application_english_frechn_level.application_id",

			],
			"$this->table.user_id as uid ,
			$this->table.* ,
			applicaiton_misc.*,
			users.email as email,
			countries.name as country,
			$this->table.id as aid,
			last_level_education.*,
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

		return $query;
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