<?

class Apply_Pnc_Controller extends Apply_Controller
{
	protected $user_id;
	static public $map = "apply/pnc";
	protected $apply  ;
	protected $delete;
	protected $printme;

	protected 	$pages = [
		'main',
		'eu',
		'education',
		'cfs',
		'foreignlang',
		'aeronautical_experience',
		'medical_aptitudes',
		'aviability',
		'other',
		'cv',
		'covver_letter',

	];


	public function __construct($page = NULL,$meta = NULL )
	{

		parent::__construct();
		$this->apply = base_url().'apply/pnc/apply/index/';
		$this->delete = base_url().'apply/pnc/delete/index/';
		$this->printme = base_url().'apply/pnc/printme/index/';
		$this->load->library("Uploadlist");
	}

	public function get_pagination($offer_id)
	{

		$pages          = $this->pages;

		$list_to_uplaod = $this->uploadlist->get_pnc();
		$pages          = array_merge($pages,$list_to_uplaod);




		return $this->make_form_link($pages,$offer_id,Apply_Pnc_Controller::$map);
	}

	public function get_page($offer_id,$page)
	{
		$pages          = $this->pages;
		$list_to_uplaod = $this->uploadlist->get_pnc();
		$pages          = array_merge($pages,$list_to_uplaod);
		foreach($pages as $key=>&$value){
			if($page == $value)
			return  base_url().Apply_Pnc_Controller::$map.'/'.$value.'/index/'.$offer_id;
		}
		return NULL;

	}

	protected function get_table_name($step = NULL)
	{
		$tables      = [
			'main'=>'application',
			'eu'=>'application_eu_area',
			'education'=>'last_level_education',
			'cfs'=>'application_cfs',
			'foreignlang'=>'application_languages_level',
			'aeronautical_experience'=>'aeronautical_experience',
			'medical_aptitudes'=>'application_medical_aptitude',
			'aviability'=>'applicaiton_misc',
			
			'other'=>'application_empoy_center',
			'cv'=>'application_files',
			'covver_letter'=>'application_files',

			'employ_center'=>'application_empoy_center'



		];


		$tables_plus = [];
		foreach($this->uploadlist->get_pnc() as $value){
			$tables_plus[$value] = 'application_files';
		}
		$tables = array_merge($tables,$tables_plus);

		if($step)
		return $tables[$step];
		else
		return $tables;
	}

}