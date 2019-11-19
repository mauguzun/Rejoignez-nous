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
		
		//position
		$data =  $this->Crud->get_row(['application_id'=>$this->app['id']],'application_un');$contract = $this->Crud->get_row(['id'=>$data['contract_id']],'application_contract');
		$query = ['create_application_contract'=>$contract['type'],'function'=>$data['function']];
		
		$html .= $this->load->view('apply_final/printer/keyvalue',[
				'title'=>lang('position'),'query'=>$query],true);	
			
		// prof
	
		$misc = $this->Crud->get_all('application_unsolicated_proffesional',['application_id'=>$this->app['id']]);
		$managerial = $this->Crud->get_array('id','managerial','expirience_managerial');
		foreach($misc as &$value){
			unset($value['application_id']);		
			$value['country_id'] = $this->countries()[$value['country_id']]; 			
			$value['start'] = date_to_input($value['start']);		
			$value['end'] = date_to_input($value['end']);				
			$value['current'] = $this->_have($value['current']);	
			$value['managerial'] = $managerial[$value['managerial']]; 
		}
		$html .= $this->load->view('apply_final/printer/manycolumns',[
				'title'=>lang('professional'),
				'query'=>$misc
			],true);
		
		
		//formation
		$misc = $this->Crud->get_all('application_unsolicated_formattion',['application_id'=>$this->app['id']]);
		foreach($misc as &$value){
			unset($value['application_id']);		
			$value['start'] = date_to_input($value['start']);		
			$value['end'] = date_to_input($value['end']);				

		}
		
		$html .= $this->load->view('apply_final/printer/table',[
				'title'=>lang('application_unsolicated_formattion'),
				'query'=>$misc],true);
			
		
		//lang
		$html .= $this->load->view('apply_final/printer/keyvalue',[
				'title'=>lang('lanuage'),
				'query'=>$this->get_print_lang()],true);	
	
		
				
		// Miscellaneou
		$misc = $this->get_print_misc();
		unset($misc['medical_restriction']);
		unset($misc['employ_center']);
		
		
		$html .= $this->load->view('apply_final/printer/keyvalue',['title'=>lang('complementary_informations'),
				'query'=>$misc],true);
		$html .=  $this->load->view('apply_final/printer/footer',['query'=>$this->app],true);

		return  $html;
													  	
	}
}