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
	protected function get_print_data($app_id=NULL){


		$html = '';
		$html .= $this->load->view('apply_final/printer/header',['query'=>$this->app],true);
		$html .= $this->load->view('apply_final/printer/keyvalue',[
				'title'=>lang('profile'),
				'query'=>$this->get_print_main_data()
			],true);
		
		// bach
		$row = $this->Crud->get_row(['application_id'=>$this->app['id']],'mechanic_baccalaureate');
		unset($row['application_id']);
		$send = [];
		foreach($row as $key => &$value){
			$send [lang($key)] = $this->_have($value);
		}
		$html .= $this->load->view('apply_final/printer/keyvalue',[
				'title'=>lang('aeronautical_baccalaureate'),
				'query'=>$send	],true);
		//lang
		$lang = $this->get_print_lang();
		$aero_lang =  $this->Crud->get_row(['application_id'=>$this->app['id']],'aeronautical_english_level');
		$lang[lang('aeronautical_english_level')] = $this->lang_level()[$aero_lang['lang_level']];
		
		
		$html .= $this->load->view('apply_final/printer/keyvalue',[
				'title'=>lang('language'),
				'query'=>$lang	],true);
				
		
		// mec exp
		$html .= $this->load->view('apply_final/printer/keyvalue',[
				'title'=>lang('aeronautical_experience'),
				'query'=>$this->_get_mex_expr()	],true);
	
				
		// Miscellaneou
		$misc = $this->get_print_misc();
		unset($misc['medical_restriction']);
		unset($misc['employ_center']);
		
		
		$html .= $this->load->view('apply_final/printer/keyvalue',['title'=>lang('complementary_informations'),
				'query'=>$misc],true);
		$html .=  $this->load->view('apply_final/printer/footer',['query'=>$this->app],true);

		return $html;

	}
	private function _get_mex_expr(){
		
		$managerial = $this->Crud->get_array('id','managerial','expirience_managerial');

	
		$mec_expirience = $this->Crud->get_row(['application_id'=>$this->app['id']],'mechanic_offer_aeronautical_experience');
		
	
		if($mec_expirience){
			$mechanic_period = $this->Crud->get_array('id','duration','mechanic_offer_managerial');

			$mec_expirience['b737_classic'] = $mechanic_period[$mec_expirience['b737_classic']];
			$mec_expirience['b737_ng'] = $mechanic_period[$mec_expirience['b737_ng']];
			$mec_expirience['part_66_license'] = $this->_have($mec_expirience['part_66_license']) ;
			
			if($mec_expirience['managerial_duties']){
				$mec_expirience['managerial_duties'] = $managerial[$mec_expirience['managerial_duties']] ;

			}else{
				$mec_expirience['managerial_duties'] = lang('no');
			}
			
		}
		unset($mec_expirience['application_id']);
		return $mec_expirience;
	}
	
}