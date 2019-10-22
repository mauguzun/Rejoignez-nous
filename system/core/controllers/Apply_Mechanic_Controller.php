<?

class Apply_Mechanic_Controller extends Apply_Controller
{
	protected $user_id;
	static public $map = "apply/mechanic";
	protected $apply  ;
	protected $delete;
	protected $printme;

	protected 	$pages = [
		'main',

		'aeronautical_baccalaureate',
		'foreignlang',
		'aeronautical_experience',
		'aviability',
		'other',	
	
		'covver_letter',	'cv',
		'complementary_documents'

	];


	public function __construct($page = NULL,$meta = NULL )
	{


		parent::__construct();
		$this->apply = base_url().'apply/mechanic/apply/index/';
		$this->delete = base_url().'apply/mechanic/delete/index/';
		$this->printme = base_url().'apply/mechanic/printme/index/';
		$this->load->library("Uploadlist");
	}

	public function get_pagination($offer_id)
	{


		$pages = $this->pages;
		return $this->make_form_link($pages,$offer_id,Apply_Mechanic_Controller::$map);
	}

	public function get_page($offer_id,$page)
	{
		$pages = $this->pages;

		foreach($pages as $key=>&$value)
		{
			if($page == $value)
			return  Apply_Mechanic_Controller::$map.'/'.$value.'/index/'.$offer_id;
		}
		return NULL;

	}

	protected function get_table_name($step = NULL)
	{
		$tables      = [
			'main'=>'application',
/*			'education'=>'last_level_education',*/
			'aeronautical_baccalaureate'=>'mechanic_baccalaureate',
				'mainlang'=>'application_english_frechn_level',
			'foreignlang'=>'application_english_frechn_level',
			'aeronautical_experience'=>'mechanic_offer_aeronautical_experience',		
			'aviability'=>'applicaiton_misc',
			
			 
			'other'=>'applicaiton_misc',
			
			'cv'=>'application_files',
			'covver_letter'=>'application_files',
			'complementary_documents'=>'application_files',
		
			
		
		];


		$tables_plus = [];
		foreach($this->uploadlist->get_pnc() as $value)
		{
			$tables_plus[$value] = 'application_files';
		}
		$tables = array_merge($tables,$tables_plus);

		if($step)
		return $tables[$step];
		else
		return $tables;
	}

}