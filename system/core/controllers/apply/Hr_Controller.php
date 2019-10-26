<?



class Hr_Controller extends Base_Apply_Controller{
	
	protected $type = 'hr';
	

	
	protected $uploaders  = 
	[   
		'covver_letter','cv'];
		
	protected $step_table = [
		    
		'main'=>'application',
	
		'education'=>'last_level_education',
		'foreignlang'=>'application_english_frechn_level',
		'expirience'=>'application_hr_expirience',
		'aviability'=>'applicaiton_misc',
		'other'=>'applicaiton_misc',		
		

			
	];
	

	public function __construct($page = NULL,$meta = NULL ){
		parent::__construct();		
	}
	
	
	
	public function printer($app_id){

		
	
		
		$this->app_by_id($app_id);
		
		

		if(!$this->app | $this->app['filled'] == '0' )
		redirect(base_url());
		

		$query = $this->Crud->get_joins(
			'application',
			[
				"users"=>"users.id = application.user_id",
				

				"applicaiton_misc"=>"application.id = applicaiton_misc.application_id",
				'countries'=>"application.country_id = countries.id",
				'application_languages_level'=>"application.id = application_languages_level.application_id",
				'last_level_education'=>"application.id = last_level_education.application_id",
				'hr_offer_education_level'=>"last_level_education.education_level_id = hr_offer_education_level.id",
				'application_hr_expirience'=>"application.id = application_hr_expirience.application_id",
				'application_english_frechn_level'=>"application.id = application_english_frechn_level.application_id",

			],
			"application.user_id as uid ,
			application.* ,
			applicaiton_misc.*,
			users.email as email,
			countries.name as country,
			application.id as aid,
			users.birthday as birthday,  users.email as email ,users.handicaped as handicaped,

			last_level_education.*,
			application_english_frechn_level.*,
			hr_offer_education_level.level as education_level,
			application_languages_level.* ",
			NULL,
			null,
			["application.id" => $this->app['id']]);



		$query      = $query[0];

		//$query['date'] = time_stamp_to_date($query['date']);


		$lang_level = $this->Crud->get_array('id','level','language_level');
		$query['english_level'] = $lang_level[$query['english_level']];
		$query['french_level'] = $lang_level[$query['french_level']];



		$more_lang = $this->Crud->get_joins('application_languages_level',
			['language_level' => "application_languages_level.level_id  = language_level.id" ],
			'*',['application_languages_level.language'=>'ASC'],NULL,
			["application_languages_level.application_id"=>$this->app['id']]
		);
		$query['more_lang'] = [];
		foreach($more_lang as $row){
			$query['more_lang'][$row['language']] = $row['level'];
		}



		$query['handicaped'] = $this->_have($query['handicaped']);





		$hr_expirience = $this->Crud->get_joins('application_hr_expirience',
			[
				'expirience_duration' => "application_hr_expirience.duration  = expirience_duration.id",
				'expirience_managerial' => 'application_hr_expirience.managerial = expirience_managerial.id'
			],'*',['application_hr_expirience.area'=>'ASC'],NULL,
			["application_hr_expirience.application_id"=>$this->app['id']]
		);

		$query['hr_expirience'] = $hr_expirience;
		
	
		if($query){
			//$this->load->view('front / apply / printer',['query'=>$query]);
			require_once("application/libraries/dompdf/vendor/autoload.php");

			$dompdf = new  Dompdf\Dompdf();
			$dompdf->loadHtml($this->load->view('front/apply/printer',['query'=>$query],TRUE));

			$dompdf->setPaper('A4');


			$dompdf->render();
			$dompdf->stream(url_title($query['first_name'].$query['last_name']), array("Attachment"=> false));

			exit(0);

		}else{
			show_404();
		}

	

	}

	
}