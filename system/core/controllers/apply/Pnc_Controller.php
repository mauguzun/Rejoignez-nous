<?



class Pnc_Conntroller extends Base_Apply_Controller{
	
	protected $type = 'pnc';
	
	protected $statuses = [];
	
	protected $uploaders  = 
	[   
		/*'covver_letter',*/
		'cv',
		/*'certificate_of_flang',*/
		'certificate_cfs_or_cca','photo_in_feet',
		'passport',	
		'certificate_of_registration_at_the_employment_center',
		'vaccine_against_yellow_fever',
		'id_photo'];
		
	protected $step_table = [
		    
		'main'=>'application',
		'eu'=>'application_eu_area',
		'education'=>'last_level_education',
		'foreignlang'=>'application_english_frechn_level',
		'aeronautical_experience'=>'aeronautical_experience',
		'medical_aptitudes'=>'application_medical_aptitude',
		'complementary_informations'=>'application_empoy_center',		
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
	
	public function get_education(){
		
		
		$date = $education = null;
		if($this->app){
			$date = $this->Crud->get_row(['application_id'=>$this->app['id']],'application_cfs');
			$education = $this->Crud->get_row(['application_id'=>$this->app['id']],'last_level_education');
		
			if($date){
				$date['safety_training_certificate_date'] =  date_to_input($date['safety_training_certificate_date']);
			}
		}

		return $this->load->view('apply_final/pnc/aur_education',[
				'url'=>base_url().'apply/new/'.$this->type.'/education/',
				'education_level'=>$this->educations(),
				'date'=>$date,
				'education'=>$education],true);
	}
	
	public function education(){
		
		$this->form_validation->set_rules('education_level_id', lang('education'), 'trim|required|numeric');
		$this->form_validation->set_rules('safety_training_certificate_organization', lang('safety_training_certificate_organization'), 'trim|required');	
		$this->form_validation->set_rules('safety_training_certificate_date', lang('safety_training_certificate_date'), 'trim|required');
		
		
		$app = $this->app_by_id($_POST['application_id']);

		$can_update = FALSE;
		if($this->form_validation->run() === TRUE){

			if($this->input->post('education_level_id') != '1'){
				$this->form_validation->set_rules('studies', lang('studies'), 'trim|required|max_length[255]');

				if($this->form_validation->run() === TRUE){
					$can_update = TRUE;
				}
			}
			else{
				$can_update = TRUE;
			}
		}


		if($can_update){

			$sfc = [
				'safety_training_certificate_date'=> date_to_db($_POST['safety_training_certificate_date']) ,
				'safety_training_certificate_organization'=> $_POST['safety_training_certificate_organization'] ,
				'application_id' =>$_POST['application_id']];

			unset($_POST['safety_training_certificate_date']);
			unset($_POST['safety_training_certificate_organization']);


			
			$this->Crud->update_or_insert($_POST,'last_level_education');
			$this->Crud->update_or_insert($sfc,'application_cfs');
			$this->json['result'] = TRUE;
			$this->json['message'] = lang('saved');
		}
		else{
			$this->json['message'] = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		}
		$this->json['app_id']= $_POST['application_id'];
		$this->show_json();
		
		
	}
	
	protected function  get_aur_expirience(){
		
		
		$exp =  $this->app ? 
		$this->Crud->get_all('aeronautical_experience',['application_id'=>$this->app['id']]): [];
		
		
		$exp = count($exp) ==  0 ?  [0]:$exp;
		
		return $this->load->view('apply_final/pnc/aur_expirience',[
				'url'=>base_url().'apply/new/'.$this->type.'/aur_expirience/',
				'exp'=>$exp,
				'functions'=>$this->Crud->get_all('aeronautical_experience_list',NULL,'function_name','asc')

			],true);
	}
	
	public function aur_expirience(){
		
		$this->form_validation->set_rules('function[]', lang('function'), 'trim|required|max_length[2500]');
		$this->app_by_id($_POST['application_id']);

		
		if($this->form_validation->run() === TRUE ){
			$this->Crud->delete(['application_id'=>$this->app['id']],'aeronautical_experience');
			for($i = 0 ; $i < count($_POST['function']) ; $i++){
				$row = [
					'application_id'=> $this->app['id'],
					'function' => $_POST['function'][$i],
					'duration' => strtolower($_POST['function'][$i]) == 'aucune' ? NULL : $_POST['duration'][$i],
					'company'=> strtolower($_POST['function'][$i]) == 'aucune' ? NULL : $_POST['company'][$i],
				];
				$this->Crud->add($row,'aeronautical_experience');
			}
			$this->json['result'] = true;
			$this->json['message'] = lang('saved');
		}
		else{
			$this->json['message'] = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		}
		$this->json['app_id']= $_POST['application_id'];
		$this->show_json();
		
	}
     
	protected function get_complementary_informations(){
		    
		$employ = $car= null;
		if($this->app){
			$employ =$this->Crud->get_row(['application_id'=>$this->app['id']],	'application_empoy_center');
			$car = $this->Crud->get_row(['application_id'=>$this->app['id']],	'applicaiton_misc');
		}
		///
		
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

		
		
		///
		return $this->load->view('apply_final/pnc/complementary_informations',[
				'list'=>$list,
				'id'=>$date,
				'employ_center'=>$employ,
				'car'=>$car,
				'url'=>base_url().'apply/new/'.$this->type.'/complementary_informations/',

			],true);
	}
	
	public function complementary_informations(){
		    
		$this->form_validation->set_rules('employ_center', lang('employ_center'), 'trim');
		
		
		
		///
			
		$app = $this->app_by_id($_POST['application_id']);
		
		
		
		
		
		if($this->form_validation->run() === TRUE ){
			///////////
			
			if(!isset($_POST['aviability'])  |   empty($_POST['aviability'])){
				$_POST['aviability'] = $_POST['fake_aviability'];	
			}
	
			$_POST['aviability'] = date_to_db($_POST['aviability']);
			
			
		
		
			$employ = [
				'application_id' => $this->app['id'],
				'employ_center'=>$_POST['employ_center']];
			$this->Crud->update_or_insert($employ,'application_empoy_center');
				
			$car = [
				'application_id' => $this->app['id'],
				'aviability'=>$_POST['aviability'],
				'car'=>$_POST['car']];
	
			
			$this->Crud->update_or_insert($car,'applicaiton_misc');
			
			$this->json['result'] = true;
			$this->json['message'] = lang('saved');
		}
		else{
			$this->json['message'] = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		}

		$this->json['app_id']= $_POST['application_id'];
		$this->show_json();
	}
	
	
	
	public function printer($app_id=NULL){

		if($this->allow_print($app_id) == false){
			die();
		}
		
		
		require_once("application/libraries/dompdf/vendor/autoload.php");

		$dompdf = new  Dompdf\Dompdf();
		$dompdf->loadHtml($this->get_print_data());

		$dompdf->setPaper('A4','landscape');


		$dompdf->render();
		$dompdf->stream(
		url_title($this->app['first_name'].$this->app['last_name']), array("Attachment"=> false));

		exit(0);
	}
	
	
	
	protected function get_print_data(){
		
		$html = '';
		$html .= $this->load->view('apply_final/printer/header',['query'=>$this->app],true);
		$html .= $this->load->view('apply_final/printer/keyvalue',[
				'title'=>lang('profile'),
				'query'=>$this->get_print_main_data()
			],true);
		
		$html .= $this->load->view('apply_final/printer/keyvalue',[
				'title'=>lang('eu'),
				'query'=>$this->get_print_eu()
			],true);
		
		
		// education
		
		$education= $this->get_print_last_level_education();
		
		$date = $this->Crud->get_row(['application_id'=>$this->app['id']],'application_cfs');
		$date['safety_training_certificate_date'] =  date_to_input($date['safety_training_certificate_date']);
		unset($date['application_id']);
		
		$html .= $this->load->view('apply_final/printer/keyvalue',
			['title'=>lang('education'),'query'=>array_merge($education,$date)],true);
		
		// lang

		$html .= $this->load->view('apply_final/printer/keyvalue',['title'=>lang('language'),
				'query'=>$this->get_print_lang()],true);
		
		// aero 
		$query = $this->Crud->get_all(
			'aeronautical_experience',['application_id'=>$this->app['id']],null,null,'function,duration,company');
	
		$html .=$this->load->view('apply_final/printer/table',['title'=>lang('aeronautical_experience'),
				'query'=>$query],true);
		
		// Miscellaneou
		$misc = $this->get_print_misc();
		unset($misc['salary']);
		unset($misc['medical_restriction']);
		
		
		$html .=$this->load->view('apply_final/printer/keyvalue',['title'=>lang('complementary_informations'),
				'query'=>$misc],true);
		
		
		$html .= $this->load->view('apply_final/printer/footer',['query'=>$this->app],true);
		return $html;
	}

	
}