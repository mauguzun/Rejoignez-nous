<?



class Hr_Controller extends Base_Apply_Controller{
	
	protected $type = 'hr';
	

	
	protected $uploaders  = 
	[   
		'covver_letter','cv'];
		
	protected $step_table = [
		    
		'main'=>'application',
		'application_unsolicated_formattion'=>'application_unsolicated_formattion',
		//		'education'=>'last_level_education',
		'foreignlang'=>'application_english_frechn_level',
		/*		'expirience'=>'application_hr_expirience',*/
		'aviability'=>'applicaiton_misc',
		'other'=>'applicaiton_misc',		
		'professional'=>'application_unsolicated_proffesional'

			
	];
	

	public function __construct($page = NULL,$meta = NULL ){
		parent::__construct();		
	}
	
	
	public function printer($app_id=NULL){
		
		
		
		if($this->allow_print($app_id) == false){
			die();
		}
		
		
		require_once("application/libraries/dompdf/vendor/autoload.php");


		echo $this->get_print_data();
		return; 
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
			
		$data =  $this->Crud->get_row(['application_id'=>$this->app['id']],'application_un');$contract = $this->Crud->get_row(['id'=>$data['contract_id']],'application_contract');
		$query = ['create_application_contract'=>$contract['type'],'function'=>$data['function']];
		
		$html .= $this->load->view('apply_final/printer/keyvalue',[
				'title'=>lang('position'),'query'=>$query],true);	
	
	
		////
	  
		
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
		
		
		// Miscellaneou
		$misc = $this->get_print_misc();
		unset($misc['medical_restriction']);
		unset($misc['employ_center']);
		
		
		$html .= $this->load->view('apply_final/printer/keyvalue',['title'=>lang('complementary_informations'),
				'query'=>$misc],true);
		$html .=  $this->load->view('apply_final/printer/footer',['query'=>$this->app],true);

		return $html;
	}

	
}