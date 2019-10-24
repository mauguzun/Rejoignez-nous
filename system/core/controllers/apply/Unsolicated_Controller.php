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
		'education'=>'last_level_education',
		'foreignlang'=>'application_english_frechn_level',
		'expirience'=>'application_hr_expirience',		
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
			
			if (isset($_POST['application_id'])){
				$this->app_by_id($_POST['application_id']);
			}
		
			
			if(!$this->app){
				$_POST['user_id'] = $this->user->id;
				
				$newAppId = $this->Crud->add($_POST,'application');
				$this->json['application_id'] = $newAppId;
				$this->app_by_id($newAppId);
			}
			else{
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
	
	
	
	protected function get_other(){
		
		$misc =null;
		if($this->app){
			$misc = $this->Crud->get_row(['application_id'=>$this->app['id']],	'applicaiton_misc');
		}
		return $this->load->view('apply_final/parts/other',[

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
	
	
	public function printer($app_id=NULL)
	{

		
		
		iF(!$app_id){
			die();}
			
		$this->app_by_id($app_id);
		
		if(!$this->app | $this->app['filled'] == 0){
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
		foreach($more_lang as $row)
		{
			$query['more_lang'][$row['language']] = $row['level'];
		}




		$query['handicaped'] = $this->_have($query['handicaped']);





		$hr_expirience = $this->Crud->get_joins('application_hr_expirience',
			[
				'expirience_duration' => "application_hr_expirience.duration  = expirience_duration.id",
				'expirience_managerial' => 'application_hr_expirience.managerial = expirience_managerial.id'
			],'*',['application_hr_expirience.area'=>'ASC'],NULL,["application_hr_expirience.application_id"=>$this->app['id']]
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

			NULL,NULL,["application_un.application_id"=>$this->app['id']]

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
	
}