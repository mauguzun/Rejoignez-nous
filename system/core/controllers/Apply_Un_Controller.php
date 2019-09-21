<?

class Apply_Un_Controller extends Apply_Controller{

	static public $map = "apply/unsolicited";
	protected $apply  ;
	protected $delete;
	protected $printme;

	protected 	$pages = [
		
		'main',
		'position',
		'education',
		'foreignlang',
		'expirience',
		'other',
	];
	public function __construct($page = NULL,$meta = NULL ){

		parent::__construct();
		$this->load->library("Uploadlist");
	}
	

	public function get_pagination($app_id){

		$pages          = $this->pages;

		$list_to_uplaod = $this->uploadlist->get_unsolocated();
		$pages          = array_merge($pages,$list_to_uplaod);

		return $this->make_form_link($pages,$app_id,Apply_Un_Controller::$map);
	}

	public function get_page($page,$id){
		
		$pages          = $this->pages;
		$list_to_uplaod = $this->uploadlist->get_unsolocated();
		$pages          = array_merge($pages,$list_to_uplaod);
		foreach($pages as $key=>&$value){
			if($page == $value)
			return Apply_Un_Controller::$map.'/'.$value.'/index/'.$id;
		}
		return NULL;

	}

	protected function get_table_name($step = NULL){
		$tables      = [
			'main'=>'application',
			'position'=>'application_un',
			'education'=>'last_level_education',
			'foreignlang'=>'application_languages_level',
			'expirience'=>'application_hr_expirience',		
			'other'=>'applicaiton_misc',
			'mainlang'=>'application_languages_level',
			
			'covver_letter'=>'application_files',
			'cv'=>'application_files',
			
		];

	

		$tables_plus = [];
		foreach($this->uploadlist->get_pnt() as $value){
			$tables_plus[$value] = 'application_files';
		}
		$tables = array_merge($tables,$tables_plus);

		if($step)
		return $tables[$step];
		else
		return $tables;
	}

	protected function  set_print_link($id){
		 
		$this->apply = base_url().'apply/unsolicited/apply/index/'.$id;
		$this->delete = base_url().'apply/unsolicited/delete/index/'.$id;
		$this->printme = base_url().'apply/unsolicited/printme/index/'.$id;
	}
	
	/**
	* 
	* @param string $id
	* @return array| null
	*/
	public function get_application($id){
		$app =   $this->Crud->get_row(['id'=>$id],'application');
		if ($app){
			$this->set_print_link($app['id']);
		}
		return $app;
	}
	public function open_form($app, $title = NULL ){
		
		
		

		$this->load->view('front/apply/open',[
				'pagination'=>$this->get_pagination($app['id']),
				'title'=>lang('unsolicited_application_applys'),
				'step'=>$this->step,
				'apply'=>$this->apply.'/'.$app['id'],
				'delete'=>$this->delete.'/'.$app['id'],
				'printme'=>$this->printme.'/'.$app['id'],
				'app'=>$app,
			])
		;
	}
	
	public function show_upload($offer_id = NULL,$map=NULL){
		$this->load->library("Uploadconfig");
	

		$app = $this->get_application($offer_id);
		if(!$app)
		redirect(base_url().'apply/unsolicited/main/'.FILL_FORM);
		


		$this->show_header([lang('unsolicited_application'),lang('unsolicited_application'),lang('unsolicited_application')]);
		$this->open_form(NULL,NULL);

		$this->load->view('js/ajaxupload');
		$query   = $this->Crud->get_all( 'application_files' ,['deleted'=>0, 'application_id'=>$app['id'],'type'=>$this->step]);
		$show_me = [] ;
		foreach($query as $value){

			$show_me[$value['id']] = 
			[
				'img'=>base_url().$this->uploadconfig->get("/".$value['type'])['upload_path'].'/'.$value['file'],
				'name'=>$value['file']
			];
			
			
		}
		$this->load->view('front/apply/part/ajaxuploader',
			[
				'upload_id'=>$this->step,
				'upload_url'=>base_url().'apply/ajaxupload/upload/'.$app['id'].'/'.$this->step,
				'show_me'=>$show_me,
				'map'=>$map,
				'apply'=>$this->apply,
			]
		);
		$this->load->view('front/apply/close_upload');
		$this->show_footer();

	}
}