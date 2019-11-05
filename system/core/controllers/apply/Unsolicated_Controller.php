<?
class Unsolicated_Controller extends Base_Apply_Controller{
	
	protected $type = 'unsolicated';
	
	protected $statuses = [];
	protected $aircraft_type = null;
	
	protected $uploaders  = 
	[
		'covver_letter','cv' 
		
	];
		
	protected $step_table = [
		    
		'main'=>'application',
		'position'=>'application_un',
		/*'education'=>'last_level_education',*/
		'foreignlang'=>'application_english_frechn_level',	
		'application_unsolicated_formattion'=>'application_unsolicated_formattion',
		'other'=>'applicaiton_misc',
		'professional'=>'application_unsolicated_proffesional'
	
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
	
	

	/**
	* 
	* @param hellyea  $offer_id
	* @return
	*/
	public function main($offer_id=NULL){
		
		$_POST['unsolicated_type'] = 1;
		$_POST['unsolicated'] = 1;
		
		$this->form_validation->set_rules('address', lang('address'), 'trim|required|max_length[255]');
		$this->form_validation->set_rules('phone', lang('phone'), 'trim|required|max_length[20]');		
		$this->form_validation->set_rules('phone_2', lang('phone'), 'trim|max_length[20]');
		$this->form_validation->set_rules('zip', lang('zip'), 'trim|required|max_length[10]');
		$this->form_validation->set_rules('country_id', lang('country_id'), 'trim|required|numeric');
		$this->form_validation->set_rules('city', lang('city'), 'trim|required|max_length[255]');
		$this->form_validation->set_rules('first_name', lang('first_name'), 'trim|required|max_length[255]');
		$this->form_validation->set_rules('last_name', lang('last_name'), 'trim|required|max_length[255]');

		//;	
		
		// check form validation
		if(isset($_POST) &&  $this->form_validation->run() === true){
			
			
			if(isset($_POST['change_acc'])){
				unset($_POST['change_acc']);				
				
				$this->json['message'] = "<p>". lang('user_account_updated')."</p>";
				$this->update_user_account($_POST);
			}
			
			if(isset($_POST['application_id'])){
				$this->app_by_id($_POST['application_id']);
			}
		
			
			if(!$this->app){
				$_POST['user_id'] = $this->user->id;
				
				$newAppId = $this->Crud->add($_POST,'application');
				$this->json['application_id'] = $newAppId;
				$this->app_by_id($newAppId);
			}
			else{
				unset($_POST['application_id']);
				$this->Crud->update(['id'=>$this->app['id']],$_POST,'application');
				$this->json['application_id'] = $this->app['id'];
			}
			
			
			$this->json['result'] = TRUE;
			$this->json['message'] = lang('saved');
			// we setup app 
			
		}
		else{
			$message = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


			$this->json['message'] = $message;
		}
		$this->show_json();
	}
	
	public function other(){
		
		$this->app_by_id($_POST['application_id']);
		
		
		if(!isset($_POST['aviability'])  |   empty($_POST['aviability'])){
			$_POST['aviability'] = $_POST['fake_aviability'];	
		}
		
		
		$this->form_validation->set_rules('salary', lang('salary'), 'trim|required');
		$this->form_validation->set_rules('aviability', lang('aviability'), 'trim|required|max_length[20]');		

		if( $this->app &&   $this->form_validation->run() === true ){
			
			
			unset($_POST['fake_aviability']);
			
			$_POST['aviability'] = date_to_db($_POST['aviability']);
			$this->Crud->update_or_insert($_POST,'applicaiton_misc');
			
			
			
			$this->json['result'] = true;
			$this->json['message']= lang('saved');
			
			
		}
		else{

			$this->json['message'] =(validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			$this->session->set_flashdata('message',$message);

		}
		
		$this->json['app_id']= $_POST['application_id'];
		$this->show_json();		
	
	}
	
	protected function get_other(){
		
		
		$month     = new DateTime('now');
		$month->add(new DateInterval('P1M'));
		$month     = $month->format('d/m/Y');

		$month_two = new DateTime('now');
		$month_two->add(new DateInterval('P2M'));
		$month_two = $month_two->format('d/m/Y');
		
		$month_tree = new DateTime('now');
		$month_tree->add(new DateInterval('P3M'));
		$month_tree = $month_tree->format('d/m/Y');

		////  append current date )
		$list      = [
			date('d/m/Y') => lang('Immédiate'),
			$month=>lang('Préavis 1 mois'),
			$month_two => lang('Préavis 2mois'),			
			$month_tree => lang('Préavis 3mois'),
			0=>lang('calendar'),
		];
		$date      = date("d/m/Y") ;
		
		
		$date = null;
		if($this->app){
			$row = $this->Crud->get_row(['application_id'=>$this->app['id']],
				'applicaiton_misc');
				
			
			if($row && $row['aviability']){
				$date=  date_to_input($row['aviability']);
				$list = [$date=>$date] + $list;
			}			
		}

		$misc =null;
		if($this->app){
			$misc = $this->Crud->get_row(['application_id'=>$this->app['id']],	'applicaiton_misc');
		}
		return $this->load->view('apply_final/unsolicated/other',[
				'list'=>$list,
				'id'=>$date,
				'misc'=>$misc,
				'url'=>base_url().'apply/new/'.$this->type.'/other/'],true);
	}
	
	protected function get_position(){
		
		$data = NULL;
		if($this->app){
			$data =  $this->Crud->get_row(['application_id'=>$this->app['id']],'application_un');
		}
		
		$contract_option = [];
		$contract   = $this->Crud->get_all('application_contract');
		foreach($contract as $value){
			$contract_option[$value['id']] = $value['type'];
		}
		return $this->load->view('apply_final/unsolicated/position',[
				'contracts'=>	 $contract_option,
				'functions'=>$this->Crud->get_all('functions'),
				'data'=>$data,
				'url'=>base_url().'apply/new/unsolicated/position',
			],true);
		
	}
	public function position(){
		
		$this->app_by_id($_POST['application_id']);
		if(!$this->app){
			die('');
		}
		
		$name = $this->step_table['position'];
		
		$this->form_validation->set_rules('function', lang('function'), 'trim|required|max_length[200]');
		$this->form_validation->set_rules('contract_id', lang('contract'), 'trim|numeric|required');

		if($this->form_validation->run() === TRUE ){		
			
			$this->Crud->update_or_insert($_POST,'application_un');
			$this->json['message'] = lang('saved');
			$this->json['result']= true;
		}else{
			$this->json['message'] = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		}

		$this->json['application_id'] = $_POST['application_id'];
		$this->show_json();
	}
	
	public function delete($app_id=NULL){

		if(!$app_id){
			redirect(base_url().'apply//new/begin');
		}
		$this->app_by_id($app_id);
		if(!$this->app){
			redirect(base_url().'apply//new/begin');
		}

		$this->Crud->delete(['id'=>$this->app['id']],'application');
		$files  =  $this->Crud->get_all('application_files',['application_id'=>$this->app['id']]);
		foreach($files as $file){
			@unlink('user_uploads/'.$file['type'].'/'.$file['name']);
		}
		foreach($this->_allTables() as$table){
			if($table != 'application'){
				$this->Crud->delete(['application_id'=>$this->app['id']],$table);
			}
		
		}
	
		$this->_errors[] = anchor(base_url().'user/offers/',lang('deleted'));
		redirect(base_url().'apply/new/'.$this->type.'/index/');
	}
	
	
	public function printer($app_id=NULL){

		
		
		if($this->allow_print($app_id) == false){
			die();
		}
		
		
		$this->load->language('admin');


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
			users.birthday as birthday,  users.email as email ,users.handicaped as handicaped,
			countries.name as country,
			application.id as aid,
			last_level_education.*,
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


		/*echo  "<pre>";
		var_dump($query);
		die();*/

		/*	$hr_expirience = $this->Crud->get_joins('application_hr_expirience',
		[
		'expirience_duration' => "application_hr_expirience.duration  = expirience_duration.id",
		'expirience_managerial' => 'application_hr_expirience.managerial = expirience_managerial.id'
		],'*',['application_hr_expirience.area'=>'ASC'],NULL,["application_hr_expirience.application_id"=>$this->app['id']]
		);

		$query['hr_expirience'] = $hr_expirience;
		*/

		$function = $this->Crud->get_joins(
			'application_un',
			[
				"application_contract"=>'application_un.contract_id =application_contract.id',
				"application_un_activity"=>'application_un.application_id =application_un_activity.application_id'

			],
			'application_un.*,application_contract.type as type ,
			GROUP_CONCAT(DISTINCT application_un_activity.activity  ) as activities,

			',

			NULL,NULL,["application_un.application_id"=>$this->app['id']]

		);

		$query['function'] = $function[0];
		
		$managerial = [];
		foreach(['expirience_managerial'=>'managerial'] as $key=> $column){
			foreach($this->Crud->get_all($key,null,'id','asc') as $value){
				$managerial[$value['id']] = $value[$column];
			}
			
		}
		;

		$query['proff'] = $this->Crud->get_all('application_unsolicated_proffesional',['application_id'=>$this->app['id']]);
		$query['application_unsolicated_formattion'] = $this->Crud->get_all('application_unsolicated_formattion',['application_id'=>$this->app['id']]);
		
		
		$yes = lang('yes_toogle');
		foreach($query['proff'] as &$value){
			unset($value['application_id']);
			$value['country_id'] = $this->countries()[$value['country_id']];
			$value['managerial'] = $managerial[$value['managerial']];
			$value['current'] = $this->_have($value['current']);
			$value['start'] = date_to_input($value['start']);
			$value['end'] =  $value['end'] != '0000-00-00' ? date_to_input($value['end']) : null;
		}
		
		foreach($query['application_unsolicated_formattion'] as &$value){
			unset($value['application_id']);

			$value['start'] = date_to_input($value['start']);
			$value['end'] =  $value['end'] != '0000-00-00' ? date_to_input($value['end']) : null;
		}
		
		
		
		/*$this->load->view('front/apply/printer',['query'=>$query]);
		return;*/

		//$this->load->view('front/apply/printer',['query'=>$query]);
		require_once("application/libraries/dompdf/vendor/autoload.php");

		$dompdf = new  Dompdf\Dompdf();
		$dompdf->loadHtml($this->load->view('front/apply/printer',['query'=>$query],TRUE));

		$dompdf->setPaper('A4');


		$dompdf->render();
		$dompdf->stream(url_title($query['first_name'].$query['last_name']), array("Attachment"=> false));

		exit(0);

	}
	
	
	protected function get_professional(){
		
		$data = [0];
		if($this->app){
			$misc = $this->Crud->get_all('application_unsolicated_proffesional',['application_id'=>$this->app['id']]);
			if($misc){
				$data = $misc;
			}
		}
		
		$managerial = [];
		foreach(['expirience_managerial'=>'managerial'] as $key=> $column){
			foreach($this->Crud->get_all($key,null,'id','asc') as $value){
				$managerial[$value['id']] = $value[$column];
			}
			
		}
		
		return $this->load->view('apply_final/unsolicated/professional',[
				'countries'=>$this->countries(),
				'managerial'=>$managerial,
				'data'=>$data,
				'url'=>base_url().'apply/new/'.$this->type.'/professional/'],true);
				
				
	}
	
	public function professional(){
		
		$this->app_by_id($_POST['application_id']);
		

		$this->form_validation->set_rules('company[]', lang('company'), 'trim|required|max_length[200]');
		$this->form_validation->set_rules('industry[]', lang('industry'), 'trim|required|max_length[200]');
		
		
		
		if(  $this->form_validation->run() === true ){
   

			$this->Crud->delete(['application_id'=>$this->app['id']],'application_unsolicated_proffesional');
			for($i = 0 ; $i < count($_POST['company']) ; $i++){
				$row = [
					'company' => $_POST['company'][$i],
					'industry' => $_POST['industry'][$i],
					'role' => $_POST['role'][$i],
					'position_held' => $_POST['position_held'][$i],
					'country_id' => $_POST['country_id'][$i],
					'current' => isset($_POST['current'][$i]) && $_POST['current'][$i] == '1' ? 1: NULL,			
					'managerial' => $_POST['managerial'][$i],
					'start' => date_to_db($_POST['start'][$i]),	
					'end'=> isset($_POST['current'][$i]) && $_POST['current'][$i] == '1'  ? '':   date_to_db($_POST['end'][$i]),
					'application_id'=> $this->app['id'],
				];
				$this->Crud->update_or_insert($row,'application_unsolicated_proffesional');
			}
			

			$this->json['result'] = true;
			$this->json['message'] = lang('saved');
		}
		else{
		
			$this->json['message'] = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


		}
		$this->json['application_id'] = $this->app['id'];
		$this->show_json();
	}
	
	protected function get_application_unsolicated_formattion(){
		
		$data = [0];
		if($this->app){
			$misc = $this->Crud->get_all('application_unsolicated_formattion',['application_id'=>$this->app['id']]);
			if($misc){
				$data = $misc;
			}
		}
		return $this->load->view('apply_final/unsolicated/application_unsolicated_formattion',[
				
				'data'=>$data,
				'url'=>base_url().'apply/new/'.$this->type.'/application_unsolicated_formattion/'],true);	
	}
	
	public function application_unsolicated_formattion(){
		
		$this->app_by_id($_POST['application_id']);
		

		$this->form_validation->set_rules('school_type[]', lang('school_type'), 'trim|required|max_length[200]');

		
		if(  $this->form_validation->run() === true ){
   

			$this->Crud->delete(['application_id'=>$this->app['id']],'application_unsolicated_formattion');
			for($i = 0 ; $i < count($_POST['school_type']) ; $i++){
				$row = [
					'school_type' => $_POST['school_type'][$i],
					'school_name' => $_POST['school_name'][$i],
					'qualification' => $_POST['qualification'][$i],
					'location' => $_POST['location'][$i],
					'start' => date_to_db($_POST['start'][$i]),	
					'end'=>empty($_POST['end']) ?  NULL : date_to_db($_POST['end'][$i]),
					'application_id'=> $this->app['id'],
				];
				$this->Crud->update_or_insert($row,'application_unsolicated_formattion');
			}
			

			$this->json['result'] = true;
			$this->json['message'] = lang('saved');
		}
		else{
		
			$this->json['message'] = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


		}
		$this->json['application_id'] = $this->app['id'];
		$this->show_json();
	}
}