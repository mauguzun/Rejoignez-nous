<?

class Base_Apply_Controller extends Usermeta_Controller{
	
	protected $user ;
	protected $table = 'application';
	
	
	protected $offer = null;
	protected $type = 'hr';
	
	protected $app = null;	
	// data 
	protected $countries = null;
	protected $educations = null;
	protected $lang_level = null;
	protected $language_list = null;
	
	protected $json =[
		'application_id'=>null,
		'result'=>false,
		'statuses'=>null,
		'filled'=>false,
		'message'=>null];
		
	protected $statuses = [];
	
	protected $files = null;
	


	public function __construct($page = 'user/index',$meta = NULL ){	
		parent::__construct(NULL,$meta = NULL,TRUE);	
		
		$this->user = $this->ion_auth->user()->row();	
		
		/*if(isset($_GET['fill_form'])){
		$this->session->set_flashdata('message',lang('fill_form'));
		}	*/	
		$this->educations();
		
	}

	public function get_main(){

		$app  = (array)$this->user;
		return $this->load->view('apply_final/parts/main',[
				'app'=>$app,
				'url'=> base_url().'apply/new/'.$this->type.'/main/'.$this->offer['id'],
				'countries'=>$this->countries(),
				'civility'=>$this->civility(),
		
			],true);
	}
	
	public function aviability(){
		
		if(!isset($_POST['aviability'])  |   empty($_POST['aviability'])){
			$_POST['aviability'] = $_POST['fake_aviability'];	
		}
		
		$this->form_validation->set_rules('aviability', lang('aviability'), 'trim|required|max_length[20]');		
		$this->app_by_id($_POST['application_id']);
		
		if( isset($_POST['aviability']) && $this->form_validation->run() === true ){

			unset($_POST['fake_aviability']);
			
			$_POST['aviability'] = date_to_db($_POST['aviability']);
			$this->Crud->update_or_insert($_POST,'applicaiton_misc');
			$this->json['result'] = true;
			$this->json['message'] = lang('saved');

		}
		else{
			$this->json['message']= (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		}	
		$this->json['app_id']= $_POST['application_id'];
		$this->show_json();		
	}
	
	
	protected function get_aviability(){
		
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

		


		return $this->load->view('apply_final/parts/aviability',[
				'list'=>$list,
				'id'=>$date,
				'url'=> base_url().'apply/new/'.$this->type.'/aviability/',
			],true);
	}
	
	
	
	protected function get_eu(){
		//			$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));
		
		$eu = $this->app ? 
		$this->Crud->get_row(['application_id'=>$this->app['id']],'application_eu_area'):NULL;
		
		return $this->load->view('apply_final/parts/eu',[
				'url'=> base_url().'apply/new/'.$this->type.'/eu/',
				'eu_nationality'=>$eu ? $eu['eu_nationality'] : 0 ,
				'can_work_eu'=>$eu ? $eu['can_work_eu'] : 0 ,
		
			],true);
	}
	
	
	
	protected function get_medical(){
		
	
		$medical = 	$this->app ?  $this->Crud->get_row(
			['application_id'=>$this->app['id']],'application_medical_aptitude') : null;



		$medical= $medical['date'] ?  date_to_input($medical['date']) : null;
		return $this->load->view('apply_final/parts/medical',[
				'url'=> base_url().'apply/new/'.$this->type.'/medical/',
				'medical' =>$medical
			],true);
	}
	
	public function medical(){
		$this->form_validation->set_rules('date', lang('end_date_last_medical_visit'), 'trim|required|max_length[12]');
		
		$this->app_by_id($_POST['application_id']);
		
		if($this->form_validation->run() === TRUE){

			$_POST['date'] = date_to_db($_POST['date']);
			$this->Crud->update_or_insert($_POST,'application_medical_aptitude');
			$this->json['result'] = true;
			$this->json['message'] = lang('saved');
			
		}else{
			$this->json['message'] = (validation_errors() ? validation_errors() :($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		}
		$this->json['app_id']= $_POST['application_id'];
		$this->show_json();
	}

	/**
	* 
	* @param string $type 
	* 
	* @return string view
	*/
	public function get_uploader($type='cv'){
		return $this->load->view(
			'apply_final/parts/upload',[
				'name'=>$type,
				'files'=>$this->files ? $this->files : null ,
			],true
		);
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
		
		
		$levels = $extra = null;
		if($this->app){
			
			$extra = $this->Crud->get_all('application_languages_level',['application_id'=>$this->app['id']]);
			$levels =  $this->Crud->get_row(['application_id'=>$this->app['id']],'application_english_frechn_level');
		}
		
		
		return $this->load->view('apply_final/parts/langs',[
				'url'=> base_url().'apply/new/'.$this->type.'/lang/',
				'lang_level'=>$this->lang_level(),
				'levels'=>$levels,
				'extra'=>$extra,
				
				'language_list'=>$this->language_list()
		
			],true);
	}
	
	
	public function files(){
		if($this->app){
			$this->files = $this->Crud->get_all('application_files',['application_id'=>$this->app['id']]);
		}
	}
	
	public function eu(){
		
		$this->form_validation->set_rules('eu_nationality', lang('eu_work'), 'trim|numeric');
		$this->form_validation->set_rules('can_work_eu', lang('can_work_eu'), 'trim|numeric');
		
		
		
		if($_POST['can_work_eu'] == 0 && $_POST['eu_nationality'] == 0 ){
			$this->json['message'] = lang('eu_must_have');
		}else{
			$this->Crud->update_or_insert($_POST,'application_eu_area');
			$this->json['result'] = TRUE;
			$this->json['message'] = lang('saved');
		}
		
		$this->app_by_id($_POST['application_id']);
		$this->json['app_id']= $_POST['application_id'];
		$this->show_json();
	}
	
	
	/**
	* @param int $offer_id
	* @return 
	*/
	public function main($offer_id=NULL){
	
		$this->form_validation->set_rules('address', lang('address'), 'trim|required|max_length[255]');
		$this->form_validation->set_rules('phone', lang('phone'), 'trim|required|max_length[20]');		
		$this->form_validation->set_rules('phone_2', lang('phone'), 'trim|max_length[20]');
		$this->form_validation->set_rules('zip', lang('zip'), 'trim|required|max_length[10]');
		$this->form_validation->set_rules('country_id', lang('country_id'), 'trim|required|numeric');
		$this->form_validation->set_rules('city', lang('city'), 'trim|required|max_length[255]');
		$this->form_validation->set_rules('first_name', lang('first_name'), 'trim|required|max_length[255]');
		$this->form_validation->set_rules('last_name', lang('last_name'), 'trim|required|max_length[255]');

		unset($_POST['application_id']);	
		
		// check form validation
		if(isset($_POST) &&  $this->form_validation->run() === true){
			
			
			if(isset($_POST['change_acc'])){
				unset($_POST['change_acc']);				
				
				$this->json['message'] = "<p>". lang('user_account_updated')."</p>";
				$this->update_user_account($_POST);
			}
			
			$this->app($offer_id);
			
			if(!$this->app){
				$_POST['user_id'] = $this->user->id;
				$_POST['offer_id'] = $offer_id;
				
				$newAppId = $this->Crud->add($_POST,'application');
				$this->json['application_id'] = $newAppId;
			}
			else{
				$this->Crud->update(['id'=>$this->app['id']],$_POST,'application');
				$this->json['application_id'] = $this->app['id'];
			}
			
			$this->app($offer_id);
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
	
	protected function show_json(){
		
		if($this->app){
			$this->set_statuses($this->app['id']);
			$this->json['statuses'] = $this->statuses;
			$this->json['filled'] = $this->app['filled'] == 1 ? true:false;
		}
		
		// 1, make steps
		echo json_encode($this->json);
	}
	
	/**
	* @param string $id
	* @return array|null 
	*/
	public function offer($id){
		$this->offer  =  $this->Crud->get_row(['id'=>$id],'offers');		
		return 	$this->offer  ? 	$this->offer  : NULL;
	}
	
	//
	public function app($offer_id){
		$this->app = $this->Crud->get_row(
			['offer_id'=>$offer_id,'user_id'=>$this->user->id],'application');
	}
	
	protected function app_by_id($id){
		$this->app = $this->Crud->get_row(
			['id'=>$id,'user_id'=>$this->user->id],'application');
	}

	protected function redirect_if_account_not_filled(){
		foreach(['civility','first_name','last_name','city','birthday','country_id'] as $value){
			if( empty($this->user->{$value}) ){
				redirect(base_url().'user/profile?q=fill_form&url_back='.current_url());
			}
		}
	}

	/**
	* 
	* @param array $post
	* @return true|false
	*/
	private function _update_user_account($post){
		return $this->Crud->update(['id'=>$this->user->id],$post,'users');
	}
	
	

	/**
	* 
	* @param array $post
	* @return true|false
	*/
	public function update_user_account($post){
		
		return $this->Crud->update(['id'=>$this->user->id],$post,'users');
	}
	
	
	
	/////////////////////////// lists 
	
	protected function civility(){
		return  ['mr'=>lang('_mr'),'mrs'=>lang('_mrs')];
	}
	
	protected function lang_level(){
		if($this->lang_level == null){
			$levels = $this->Crud->get_all('language_level',NULL,'level','asc');
			foreach($levels as $coutry){
				$this->lang_level[$coutry['id']] =$coutry['level'];
			}
		}		
		return $this->lang_level;
	}
	
	protected function language_list(){
		
		if($this->language_list == null){
			$levels = $this->Crud->get_all('language_list');
			foreach($levels as $coutry){
				$this->language_list[$coutry['id']] =$coutry['language'];
			}
		}		
		return $this->language_list;
	}
	

	protected function educations(){
		if($this->educations == null){
			$levels = $this->Crud->get_all('hr_offer_education_level',NULL,'level','asc');
			foreach($levels as $coutry){
				$this->educations[$coutry['id']] =$coutry['level'];
			}
		}		
		return $this->educations;
	}
	protected function countries(){
		if($this->countries == null){
			$countries = $this->Crud->get_all('country_translate',['code'=>$this->session->userdata('lang')],'name','asc');
			$this->countries   = [];
			foreach($countries as $coutry){
				$this->countries [$coutry['country_id']] = $coutry['name'];
			}
		}
		return $this->countries;
	}
	
	
	
	
	public function json_statuses($application_id){
		
		$this->app_by_id($application_id);	
		$this->set_statuses($this->app['id']);
		$this->app_by_id($application_id);	
		echo json_encode(
			[ 
				'statuses'=>$this->statuses,
				'filled'=>$this->app['filled'] == 1 ? true :false]
		);
	}
	
	
	
	
	
	protected function application_done_email(){
		

		
		$email = $this->ion_auth->user()->row()->email;
		$query = $this->Crud->get_row([
				'template_id'=>1,'lang'=>$this->getCurrentLang('lang')		],'email_template_translate');
		
		
		
		$text =  $query['text'];
		$text = str_replace('#NOM',$this->app['first_name'],$text);
		$text = str_replace('#PRENOM',$this->app['last_name'],$text);
		
		
		$this->load->library('email',[
				'protocol'=>$this->email_settings['transport']
			]);

		$this->email->from($this->email_settings['email'],$this->email_settings['sender']);
		$this->load->library("json_model");


		$this->email->reply_to($this->email_settings['email'],$this->email_settings['sender']);
		$this->email->subject($query['subject']);
		$this->email->message($text);
		$this->email->to($email);
		$this->email->cc($this->email_settings['cc']);
		if(!$this->email->send()){
			return false;
		}
		else{
			return true;
		}
		
	}
	
	
	
	public function delete($offer_id){
		
		$this->app($offer_id);

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
		redirect(base_url().'apply/new/'.$this->type.'/index/'.$offer_id);
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
	/**
	* 
	* @return
	*/
	public function other(){
		
		
		$this->app_by_id($_POST['application_id']);
		$this->form_validation->set_rules('salary', lang('salary'), 'trim|required');
		
		if( $this->app &&   $this->form_validation->run() === true ){
			
			$this->Crud->update_or_insert($_POST,'applicaiton_misc');
			$this->json['result'] = true;
			$this->json['message']= lang('saved');
		}
		else{

			$this->json['message'] =(validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			$this->session->set_flashdata('message',$message);

		}
		$this->json['application_id'] = $_POST['application_id'];
		$this->show_json();
	
	}
	
	protected function get_experience(){
		
		$select = [];
		foreach(['expirience_duration'=>'duration','expirience_managerial'=>'managerial'] as $key=> $column){
			foreach($this->Crud->get_all($key,null,'id','asc') as $value){
				$options[$value['id']] = $value[$column];
			}
			$select[$column] = $options;
		}
		
		$exp =  $this->app ? 
		$this->Crud->get_all('application_hr_expirience',['application_id'=>$this->app['id']]): null;
		
		
		if (count($exp)==0){
			$exp = [0];
		}
		
	
		return $this->load->view('apply_final/parts/expirience',[
				'url'=>base_url().'apply/new/'.$this->type.'/expirience/',
				'selects'=>$select,
				'exp'=>$exp,
				
			],true);
	}
	
	
	
	public function expirience(){
		
		$this->app_by_id($_POST['application_id']);
		
		
		$this->form_validation->set_rules('area[]', lang('area'), 'trim|required|max_length[200]');
		if(  isset($_POST['area']) && $this->form_validation->run() === true ){

			// 1 delete ? yea please 
			    

			$this->Crud->delete(['application_id'=>$this->app['id']],'application_hr_expirience');
			for($i = 0 ; $i < count($_POST['area']) ; $i++){
				$row = [
					'area' => $_POST['area'][$i],
					'duration' => $_POST['duration'][$i],
					'managerial' => $_POST['managerial'][$i],
					'application_id'=> $this->app['id'],
				];
				$this->Crud->update_or_insert($row,'application_hr_expirience');
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
	
	protected function get_education(){
		
		$education = null;
		if($this->app){
			$education = $this->Crud->get_row(['application_id'=>$this->app['id']],
				'last_level_education');
		
			
		}

		return $this->load->view('apply_final/parts/education',[
				'url'=>base_url().'apply/new/'.$this->type.'/education/',
				'education_level'=>$this->educations(),
				
				'education'=>$education],true);
	}
	
	
	public function education(){
		
		
		
		$this->form_validation->set_rules('education_level_id', lang('education'), 'trim|required|numeric');
		$app = $this->app_by_id($_POST['application_id']);


		if($this->form_validation->run() === TRUE){

			if($this->input->post('education_level_id') != '1'){
				//$this->form_validation->set_rules('university', lang('university'), 'trim | required | max_length[255]');
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
			
			$this->Crud->update_or_insert($_POST,'last_level_education');


			$this->json['message'] = lang('saved');
			$this->json['result'] = true;
		}
		else{
			$this->json['message'] = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		}

		$this->json['application_id'] = $_POST['application_id'];
		$this->show_json();
	}
	
	/**
	* 
	* @param strinh $application_id
	* @return
	*/
	protected function set_statuses($application_id){}
	/**
	* @return array
	*/
	protected function _allTables(){
		return[
			'aeronautical_english_level',
			'aeronautical_experience',
			'applicaiton_misc',
			'application_cfs',			
			'application_empoy_center',		
			'application_english_frechn_level',		
			'application_eu_area',	
			'application_fcl',	
			'application_fcl',
			'application_files',
			'application_history',
			'application_hr_expirience',
			'application_licenses',
			'application_medical_aptitude',
			'application_pnt_completary',
			'application_pnt_flight_expirience',
			'application_pnt_flight_expirience_instructor',
			'application_pnt_practice',
			'application_pnt_qualification',
			'application_pnt_successive_employers',	
			'application_pnt_total_flight_hours',
			'application_un',
			'application_un_activity',		
							
											
	
			
			
		];
	}
}