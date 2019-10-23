<?
class Pnt_Controller extends Base_Apply_Controller{
	
	protected $type = 'pnt';
	
	protected $statuses = [];
	protected $aircraft_type = null;
	
	protected $uploaders  = 
	[
		'certificate_of_flang',
		'attestation',
		'attestation_of_medical_fitness',
		'carnet_of_flight',
		'attestation_of_irme',
		'id_photo'   
	];
		
	protected $step_table = [
		    
		'main'=>'application',
		'eu'=>'application_eu_area',
		'foreignlang'=>'application_english_frechn_level',
		'licenses'=>'application_licenses',
		'medical_aptitudes'=>'application_medical_aptitude',
		'practice'=>'application_pnt_practice',
		'qualification_type'=>'application_pnt_qualification',
		'total_flight_hours'=>'application_pnt_total_flight_hours',
		'expirience'=>'application_pnt_flight_expirience',
		'experience_in_instructor'=>'application_pnt_flight_expirience_instructor',
		'successive_employer'=>'application_pnt_successive_employers',
		'complementary_informations'=>'application_pnt_completary',
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
	
	
	public function lang(){
		
	
		$this->app_by_id($_POST['application_id']);
		if(!$this->app){
			die('');
		}
		
		$this->form_validation->set_rules('english_level', lang('english_level'), 
			'trim|required|max_length[255]');

		$this->json['application_id']= $this->app['id'];
			
		if($_POST['fcl'] == '0'){
			$this->json['message']= lang('you_must_have_obtained_a_level_higher_than_or_equal');
			$this->json['application_id']=$_POST['application_id'];
			$this->show_json();
			return ;
		}
		else{
			$this->Crud->update_or_insert(['application_id'=>$this->app['id'],'fcl'=>1],'application_fcl');

			parent::app($_POST['application_id']);
			parent::lang();
		}
	}
		

	/**
	* 
	* 
	* @return view
	*/
	protected function get_lang(){
		
		$levels = $extra =$flc =  null;
		if($this->app){
			
			$extra = $this->Crud->get_all('application_languages_level',['application_id'=>$this->app['id']]);
			$levels =  $this->Crud->get_row(['application_id'=>$this->app['id']],'application_english_frechn_level');
			$flc =  $this->Crud->get_row(['application_id'=>$this->app['id']],'application_fcl');
		}
		return $this->load->view('apply_final/pnt/langs',[
				'url'=> base_url().'apply/new/'.$this->type.'/lang/',
				'lang_level'=>$this->lang_level(),
				'flc'=>$flc,
				'levels'=>$levels,
				'extra'=>$extra,
				'language_list'=>$this->language_list()],true);
	}
	

	protected function get_license(){
		
		$query = null;
		$send = [];
		
		if($this->app){
			$query = $this->Crud->get_row(['application_id'=>$this->app['id']],'application_licenses');
		
			foreach(['theoretical_atpl','mcc'] as $index){
				if($query[$index] == '1')
				$send[$index] =true;	
			}
		}
		
		if($query){
			$convert = ['cpl_start','cpl_end','atpl_start','atpl_end','irma_start','irma_end'];
			foreach($convert as $index){
				
				
				if(!empty($query[$index])&& $query[$index] != '0000-00-00'){
					$send[$index] = date_to_input($query[$index]);

				}
				
			}
		}
		return $this->load->view('apply_final/pnt/licenses',[
				'url'=> base_url().'apply/new/'.$this->type.'/licenses/',
				'query'=>$send
			],true);
	}
	
	public function licenses(){
		$this->app_by_id($_POST['application_id']);
		if(!$this->app){
			die('');
		}
		
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			
			unset($_POST['cpl']);
			unset($_POST['atpl']);
			unset($_POST['irme']);
		
			$dates =  ['cpl_start','cpl_end','atpl_start','atpl_end','irme_start','irme_end'];
			foreach($_POST as $key=>&$value){
				if(in_array($key,$dates) && !empty($value))
				$value = date_to_db($value);

			}		
			$this->Crud->update_or_insert($_POST,'application_licenses');
			$this->json['result'] = true;
			$this->json['message'] = lang('saved');

		}else{
			
			$this->json['message'] = lang('error');
		}
		
		$this->json['application_id'] = $_POST['application_id'];
		$this->show_json();

	}
	
	protected function get_practice(){
		
		$lines = [0];
		if($this->app){
			$rows = $this->Crud->get_all('application_pnt_practice',
				['application_id'=>$this->app['id']]);
			$lines = [];
			foreach($rows as $value){	$lines = [];
				$line = [];
				$line['school_name[]'] = $value['school_name'];
				$line['qualification_obtained[]'] =$value['qualification_obtained'];
				$line['start[]'] = date_to_input($value['start']);
				$line['end[]'] = date_to_input($value['end']);
				

				array_push($lines,$line);

			}
		}
		
		return	$this->load->view('apply_final/pnt/practice',[
				'url'=> base_url().'apply/new/'.$this->type.'/practice/',
				'data'=>$lines
			],true);
	}
	
	public function  practice(){
		$this->app_by_id($_POST['application_id']);
		if(!$this->app){
			die('');
		}
		
		
		$this->form_validation->set_rules('school_name[]', lang('school'), 'trim|required|max_length[250]');
		$this->form_validation->set_rules('qualification_obtained[]', lang('qualification_obtained'), 'trim|required|max_length[250]');
		$this->form_validation->set_rules('start[]', lang('start'), 'trim|required|max_length[20]');
		$this->form_validation->set_rules('end[]', lang('end'), 'trim|required|max_length[20]');


		if($this->form_validation->run() === TRUE ){
			
			$this->Crud->delete(['application_id'=>$this->app['id']],'application_pnt_practice');

			for($i = 0 ; $i < count($_POST['school_name']) ; $i++){
				$row = [
					'application_id'=> $this->app['id'],
					'school_name' => $_POST['school_name'][$i],
					'qualification_obtained' => $_POST['qualification_obtained'][$i],
					'start' => date_to_db($_POST['start'][$i]),
					'end' => date_to_db($_POST['end'][$i])];
			
				$this->Crud->update_or_insert($row,'application_pnt_practice');						
			}
			
			$this->json['message'] = lang('saved');
			$this->json['result']= true;
		}else{
			$this->json['message'] = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		}

		$this->json['application_id'] = $_POST['application_id'];
		$this->show_json();
	}
	
	protected function get_quality(){
		
		
		$lines = [0];
		if($this->app){
			
			$row = $this->Crud->get_all('application_pnt_qualification',['application_id'=>$this->app['id']]);
			if($row){
				$lines = [];
				foreach($row as $value){
					$line = [];
					$line['aircaft_type[]'] = $value['aircaft_type'];
					$line['last_online_check[]']=date_to_input($value['last_online_check']);
					$line['last_simulator_control[]'] =date_to_input($value['last_simulator_control']);
					$line['last_flight[]'] = date_to_input($value['last_flight']);
					array_push($lines,$line);

				}
			}
		}
		
	
		return $this->load->view('apply_final/pnt/qualification_type',[
				'aircraft_type'=>$this->aircraft_type(),
				'url'=> base_url().'apply/new/'.$this->type.'/qualification_type/',
				'data'=>$lines
			],true);
	}
	
	public function qualification_type(){
		$this->app_by_id($_POST['application_id']);
		if(!$this->app){
			die('');
		}
		
		
		$this->form_validation->set_rules('last_online_check[]', lang('function'), 'trim|required|max_length[25]');



		if($this->form_validation->run() === TRUE ){
			
			$this->Crud->delete(['application_id'=>$this->app['id']],'application_pnt_qualification');

			for($i = 0 ; $i < count($_POST['last_online_check']) ; $i++){
				$row = [
					'application_id'=> $this->app['id'],
					'aircaft_type' => $_POST['aircaft_type'][$i],

					'last_online_check' => date_to_db($_POST['last_online_check'][$i]),
					'last_simulator_control' => date_to_db($_POST['last_simulator_control'][$i]),
					'last_flight' => date_to_db($_POST['last_flight'][$i]),
				];
			
				$this->Crud->update_or_insert($row,'application_pnt_qualification');						
			}
			
			$this->json['message'] = lang('saved');
			$this->json['result']= true;
		}else{
			$this->json['message'] = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		}

		$this->json['application_id'] = $_POST['application_id'];
		$this->show_json();
	}

	protected function aircraft_type(){
		
		if($this->aircraft_type  == null ){
			
			$this->aircraft_type = [];
			$levels = $this->Crud->get_all('aircraft_type',NULL,'aircraft','asc');
			
			foreach($levels as $value){
				$this->aircraft_type[$value['id']] = $value['aircraft'];
			}
		}
		return $this->aircraft_type;
	}


	protected function get_exp($name = 'total_flight_hours'){
		$lines = [0];
		if($this->app){
			
			
			$table = $this->step_table[$name];
			$row = $this->Crud->get_all($table,['application_id'=>$this->app['id']]);
			if($row){
				$lines = [];
				foreach($row as $value){
					$line = [];
					$line['aircaft_type[]'] = $value['aircaft_type'];
					$line['company[]'] = $value['company'];
					$line['cdb_hours[]']=$value['cdb_hours'];
					$line['opl_hours[]']= $value['opl_hours'];
					$line['total_hours[]'] = $value['total_hours'];
					$line['last_flight[]'] = date_to_input($value['last_flight']);

					array_push($lines,$line);
				}
			}
		}
		
	
	
		return $this->load->view('apply_final/pnt/exp',[
				'aircraft_type'=>$this->aircraft_type(),
				'name'=>$name,
				'url'=> base_url().'apply/new/'.$this->type.'/exp/'.$name,
				'data'=>$lines
			],true); 
	}
	
	public function exp($name){
		$this->app_by_id($_POST['application_id']);
		if(!$this->app){
			die('');
		}
		
		
		
		$name = $this->step_table[$name];
		$this->form_validation->set_rules('last_flight[]', lang('function'), 'trim|required|max_length[25]');



		if($this->form_validation->run() === TRUE ){
			
			$this->Crud->delete(['application_id'=>$this->app['id']],$name);

			
			
			for($i = 0 ; $i < count($_POST['last_flight']) ; $i++){
				$lang = [
					'application_id'=> $this->app['id'],
					'aircaft_type' => $_POST['aircaft_type'][$i],
					'total_hours' => $_POST['total_hours'][$i],
					'opl_hours' => $_POST['opl_hours'][$i],
					'cdb_hours' => $_POST['cdb_hours'][$i],
					'company' => $_POST['company'][$i],
					'last_flight' => date_to_db($_POST['last_flight'][$i])
				];
				$this->Crud->update_or_insert($lang,$name);	
			}
								
			
			$this->json['message'] = lang('saved');
			$this->json['result']= true;
		}else{
			$this->json['message'] = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		}

		$this->json['application_id'] = $_POST['application_id'];
		$this->show_json();
	}
	
	
	protected function get_experience_in_instructor(){
		$name= 'experience_in_instructor';
		$lines = [0];
		
		if($this->app){
			
			
			$table = $this->step_table[$name];
			$row = $this->Crud->get_all($table,['application_id'=>$this->app['id']]);
			if($row){
				$lines = [];
				foreach($row as $value){
					$line = [];
					$line['aircaft_type[]'] = $value['aircaft_type'];
					$line['company[]'] = $value['company'];
					$line['approval_number[]'] = $value['approval_number'];
					$line['validity_date[]'] = date_to_input($value['validity_date']);
					$line['date_of_issue[]'] = date_to_input($value['date_of_issue']);
					array_push($lines,$line);

				}
			
			}
		}
		
		
	
		return $this->load->view('apply_final/pnt/experience_in_instructor',[
				'aircraft_type'=>$this->aircraft_type(),
				'name'=>$name,
				'url'=> base_url().'apply/new/'.$this->type.'/'.$name,
				'data'=>$lines],true); 
	}
	public function experience_in_instructor(){
		
		
		$this->app_by_id($_POST['application_id']);
		if(!$this->app){
			die('');
		}
		

		$name = $this->step_table['experience_in_instructor'];
		$this->form_validation->set_rules('aircaft_type[]', lang('aircaft_type'), 'trim|required|max_length[250]');

		if($this->form_validation->run() === TRUE ){		
			$this->Crud->delete(['application_id'=>$this->app['id']],$name);
			for($i = 0 ; $i < count($_POST['aircaft_type']) ; $i++){
				$lang = [
					'application_id'=> $this->app['id'],
					'aircaft_type' => $_POST['aircaft_type'][$i],
					'company' => $_POST['company'][$i],
					'approval_number' => $_POST['approval_number'][$i],
					'date_of_issue' => date_to_db($_POST['date_of_issue'][$i]),
					'validity_date' => date_to_db($_POST['validity_date'][$i]),
				];
				$this->Crud->update_or_insert($lang,$name);	
			}		
			$this->json['message'] = lang('saved');
			$this->json['result']= true;
		}else{
			$this->json['message'] = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		}

		$this->json['application_id'] = $_POST['application_id'];
		$this->show_json();
	}
	
	///
		
	protected function get_successive_employer(){
		$name= 'successive_employer';
		$lines = [0];
		
		if($this->app){
			
			
			$table = $this->step_table[$name];
			$row = $this->Crud->get_all($table,['application_id'=>$this->app['id']]);
			if($row){
				$lines = [];
				foreach($row as $value){
					$line = [];
					$line['function[]'] = $value['function'];
					$line['employer[]'] =  $value['employer'];
					$line['start[]'] =  date_to_input($value['start']);
					$line['end[]'] = date_to_input($value['end']);
					$line['name[]'] =  $value['name'];					
					$line['email[]'] =  $value['email'];
					$line['phone[]'] =  $value['phone'];				
					$line['why_left[]'] =  $value['why_left'];
					$line['phone_2[]'] =  $value['phone_2'];
					$line['address[]'] =  $value['address'];
					$line['zip[]'] =  $value['zip'];
					$line['city[]'] =  $value['city'];

					$line['country_id[]']  = 	 $value['country_id'];

					array_push($lines,$line);

				}
			
			}
		}
		
		/*echo "<pre>";
		var_dump($lines);
		die();
		*/
		
	
		return $this->load->view('apply_final/pnt/successive_employer',[
				'countries'=>$this->countries(),
				'name'=>$name,'url'=> base_url().'apply/new/'.$this->type.'/'.$name,
				'data'=>$lines],true); 
	}
	public function successive_employer(){
		
		
		$this->app_by_id($_POST['application_id']);
		if(!$this->app){
			die('');
		}
		

		$name = $this->step_table['successive_employer'];
		$this->form_validation->set_rules('aircaft_type[]', lang('aircaft_type'), 'trim|required|max_length[250]');

		if($this->form_validation->run() === TRUE ){		
			$this->Crud->delete(['application_id'=>$this->app['id']],$name);
			for($i = 0 ; $i < count($_POST['aircaft_type']) ; $i++){
				$lang = [
					'application_id'=> $this->app['id'],
					'aircaft_type' => $_POST['aircaft_type'][$i],
					'company' => $_POST['company'][$i],
					'approval_number' => $_POST['approval_number'][$i],
					'date_of_issue' => date_to_db($_POST['date_of_issue'][$i]),
					'validity_date' => date_to_db($_POST['validity_date'][$i]),
				];
				$this->Crud->update_or_insert($lang,$name);	
			}		
			$this->json['message'] = lang('saved');
			$this->json['result']= true;
		}else{
			$this->json['message'] = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		}

		$this->json['application_id'] = $_POST['application_id'];
		$this->show_json();
	}
	
}