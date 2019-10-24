<?



class Mechanic_Controller extends Base_Apply_Controller{
	
	protected $type = 'mechanic';
	
	protected $statuses = [];
	
	protected $uploaders  = 
	[   
		'covver_letter','cv','complementary_documents'];
		
	protected $step_table = [
		    
		
		
		'main'=>'application',
		'aeronautical_baccalaureate'=>'mechanic_baccalaureate',
		'mainlang'=>'application_english_frechn_level',
		'foreignlang'=>'application_english_frechn_level',
		'aeronautical_experience'=>'mechanic_offer_aeronautical_experience',		
		'aviability'=>'applicaiton_misc',	 
		'other'=>'applicaiton_misc',
			
	];
	

	public function __construct($page = NULL,$meta = NULL ){

		parent::__construct();
		
	}
	
	
	protected function set_statuses($app_id){
	 	
	 	 
		
		
		$setNotFilled = false;
		
		foreach($this->step_table as $stp=>$table){
			
			// let do if app 
			if($stp == 'main'){
				$this->statuses[$stp] = 'filled';
				continue;
			}
			if(!$this->Crud->get_row(['application_id'=>$this->app['id']],$table)){
				$setNotFilled = true;
				$this->statuses[$stp] = 'notfilled';
			}else{
				
				
				$this->statuses[$stp] = 'filled';
			}
			
		}
		
		foreach($this->uploaders as $type){
			
			if(count($this->Crud->get_all('application_files',
						['application_id'=>$this->app['id'] ,'type'=>$type])) == 0){
				$this->statuses[$type] = 'notfilled';
				if($type != 'covver_letter'){
					$setNotFilled = true;
				}
			}else{
				$this->statuses[$type] = 'filled';
			}
			
		}
		
	
		
		if($setNotFilled){
			$this->Crud->update(['id'=>$app_id],['filled'=>0],'application');
			$this->app_by_id($app_id);
		}
		else{
			$this->app_by_id($app_id);
			if($this->app['filled'] == 0 ){
				// only one time !!! 
				$this->Crud->update(['id'=>$this->app['id']],['filled'=>1],'application');
				$this->application_done_email();
			}
		}
	}
	
	
	protected function get_aeronautical_baccalaureate(){
		
		
		$row = NULL;
		if($this->app){
			$row = $this->Crud->get_row(['application_id'=>$this->app['id']],'mechanic_baccalaureate');
			
		}
		return $this->load->view('apply_final/mechanic/bach',[
				'row'=>$row,
				'url'=>base_url().'apply/new/'.$this->type.'/aeronautical_baccalaureate/',
			],TRUE);
	}
	
	public function aeronautical_baccalaureate(){
		
		$this->app_by_id($_POST['application_id']);
		$this->form_validation->set_rules('school', lang('school'), 'trim|required|max_length[250]');


		$this->json['result'] = true;
		if($this->form_validation->run() === TRUE ){

			
			$required = [
				'complementary_mention_b1'=>'complementary_mention_b2',
				'licenses_b1'=>'licenses_b2'
			];

			foreach($required as $key=>$value){
				if($_POST[$key] == 0 & $_POST[$value] == 0 ){
					$this->json['message'] = 
					lang('required_one_of_them'). ' : '.lang($key).' or '.lang($value);
					$this->json['result'] = false;
				}
			}
			if($this->json['result'] && $_POST['aeronautical_baccalaureate'] == 0 ){
				$this->json['message'] =lang('aeronautical_baccalaureate');
				$this->json['result'] = false;
			}
			if(	$this->json['result']){
			
				$this->Crud->update_or_insert($_POST,'mechanic_baccalaureate');
				$this->json['message'] =lang('saved');
			}
		}else{
			$this->json['message'] = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->json['result'] = FALSE;
		}
		$this->json['application_id'] = $_POST['application_id'];
		$this->show_json();

	}
	
	protected function get_experience(){
		
		
		$selects = [];
		
		$options = [];
		foreach($this->Crud->get_all("mechanic_offer_managerial",null,'id','asc') as $value){
			$options[$value['id']] = $value['duration'];
		}
		$selects['mechanic_offer_managerial'] = $options;
		
		$options = [];
		foreach($this->Crud->get_all("expirience_managerial",null,'id','asc') as $value){
			$options[$value['id']] = $value['managerial'];
		}
		$selects['expirience_managerial'] = $options;
	
	
		$row = $this->app? $this->Crud->get_row(['application_id'=>$this->app['id']],'mechanic_offer_aeronautical_experience'):null;

	
		return $this->load->view('apply_final/mechanic/expirience',[
				'url'=>base_url().'apply/new/'.$this->type.'/expirience/',
				'row'=>$row,
				'selects'=>$selects],true);
	}
	
	
	public function lang(){
		
		$this->form_validation->set_rules('english_level', lang('language'), 'trim|required|max_length[255]');
		
		
		$this->app_by_id($_POST['application_id']);

		if(isset($_POST['english_level'])  ){
			$this->Crud->update_or_insert([
					'application_id'=>$this->app['id'],
					'english_level'=>$_POST['english_level'],			
					'french_level'=>$_POST['french_level']],'application_english_frechn_level');
					
			$this->json['result'] = TRUE;
			$this->Crud->delete(['application_id'=>$this->app['id']],'application_languages_level');
			
			
			$this->Crud->update_or_insert([
					'application_id'=>$this->app['id'],
					'lang_level'=>$_POST['lang_level']],'aeronautical_english_level');
		
			if(isset($_POST['language'])){
				for($i = 0 ; $i < count($_POST['language']) ; $i++){
					
					$lang = ['language' => $_POST['language'][$i],'level_id' => $_POST['level_id'][$i],'application_id'=> $this->app['id']];		
					$this->Crud->update_or_insert($lang,'application_languages_level');		
				}
			}
			$this->json['message'] = lang('saved');
			
		}else{
			$this->json['result'] = FALSE;
		}
		
		$this->json['app_id']= $_POST['application_id'];
		$this->show_json();
		
	}
	/**
	* 
	* 
	* @return view
	*/
	protected function get_lang(){
		
		
		$levels = $extra =$aero_lang =  null;
		if($this->app){
			
			$extra = $this->Crud->get_all('application_languages_level',['application_id'=>$this->app['id']]);
			$levels =  $this->Crud->get_row(['application_id'=>$this->app['id']],'application_english_frechn_level');
			$aero_lang =  $this->Crud->get_row(['application_id'=>$this->app['id']],'aeronautical_english_level');
	
			
		}
		
		return $this->load->view('apply_final/mechanic/langs',[
				'url'=> base_url().'apply/new/'.$this->type.'/lang/',
				'lang_level'=>$this->lang_level(),
				'aero_lang'=>$aero_lang,
				'levels'=>$levels,
				'extra'=>$extra,
				'language_list'=>$this->language_list()
		
			],true);
	}
	
	
	
	public function expirience(){
		
		$this->app_by_id($_POST['application_id']);
		
		$this->form_validation->set_rules('b737_ng', lang('b737_ng'), 'trim|required|max_length[250]');
		if($this->form_validation->run() === TRUE ){

			if($_POST['part_66_license'] == 0 ){
				$this->json['message']= lang('part_66_license');
			}else{
				$this->Crud->update_or_insert($_POST,'mechanic_offer_aeronautical_experience');
				$this->json['result']= true;
				$this->json['message']= lang('saved');
			}
		}else{
			$this->json['message'] = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->json['result'] = FALSE;
		}
		$this->json['application_id'] = $this->app['id'];
		$this->show_json();
	}
	
	public function printer($app_id){

		$this->app_by_id($app_id);
		if(!$this->app | $this->app['filled'] == 0 )
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
				'application_english_frechn_level'=>"application.id = application_english_frechn_level.application_id",
				'application_eu_area'=>"application.id = application_eu_area.application_id",
				'application_medical_aptitude'=>"application.id = application_medical_aptitude.application_id",
				'aeronautical_english_level'=>"application.id = aeronautical_english_level.application_id",
				'mechanic_baccalaureate'=>"application.id = mechanic_baccalaureate.application_id"
			],
			"application.user_id as uid ,
			application.* ,
			applicaiton_misc.*,
			mechanic_baccalaureate.*,
			users.birthday as birthday,  users.email as email ,users.handicaped as handicaped,

			application.id as aid,
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
			["application.id" => $this->app['id']]);


		$query      = $query[0];
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
			["application_languages_level.application_id"=> $this->app['id']]
		);
		$query['more_lang'] = [];
		foreach($more_lang as $row){
			$query['more_lang'][$row['language']] = $row['level'];
		}

		$query['handicaped'] = $this->_have($query['handicaped']);
		$managerial = $this->Crud->get_array('id','managerial','expirience_managerial');
		$query['mec_expirience'] = $this->_get_mex_expr($this->app['id'],$managerial);
		
		//$this->load->view('front/apply/printer',['query'=>$query]);
		require_once("application/libraries/dompdf/vendor/autoload.php");

		$dompdf = new  Dompdf\Dompdf();
		$dompdf->loadHtml($this->load->view('front/apply/printer',['query'=>$query],TRUE));

		$dompdf->setPaper('A4');

		
		$dompdf->render();
		$dompdf->stream(url_title($query['first_name'].$query['last_name']), array("Attachment"=> false));

		exit(0);

	}
	private function _get_mex_expr($application_id,$managerial){
		
		
	
		$mec_expirience = $this->Crud->get_row(['application_id'=>$application_id],'mechanic_offer_aeronautical_experience');
		
	
		if($mec_expirience){
			$mechanic_period = $this->Crud->get_array('id','duration','mechanic_offer_managerial');

			$mec_expirience['b737_classic'] = $mechanic_period[$mec_expirience['b737_classic']];
			$mec_expirience['b737_ng'] = $mechanic_period[$mec_expirience['b737_ng']];
			$mec_expirience['part_66_license'] = $this->_have($mec_expirience['part_66_license']) ;
			
			if ($mec_expirience['managerial_duties']){
				$mec_expirience['managerial_duties'] = $managerial[$mec_expirience['managerial_duties']] ;

			}else{
				$mec_expirience['managerial_duties'] = lang('no');
			}
			
		}
		return $mec_expirience;
	}
	
}