<?



class Hr_Controller extends Base_Apply_Controller{
	
	protected $type = 'hr';
	

	
	protected $uploaders  = 
	[   
		'covver_letter','cv'];
		
	protected $step_table = [
		    
		'main'=>'application',
	
		'education'=>'last_level_education',
		'foreignlang'=>'application_english_frechn_level',
		'expirience'=>'application_hr_expirience',
		'aviability'=>'applicaiton_misc',
		'other'=>'applicaiton_misc',		
		

			
	];
	

	public function __construct($page = NULL,$meta = NULL ){
		parent::__construct();		
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
	
	
	public function get_print_data($app_id=NULL){

		$html = '';
		$html .= $this->load->view('apply_final/printer/header',['query'=>$this->app],true);
		$html .= $this->load->view('apply_final/printer/keyvalue',[
				'title'=>lang('profile'),
				'query'=>$this->get_print_main_data()
			],true);
			
		$html .= $this->load->view('apply_final/printer/keyvalue',[
				'title'=>lang('education'),
				'query'=>$this->get_print_last_level_education()
			],true);	
			
		$html .= $this->load->view('apply_final/printer/keyvalue',[
				'title'=>lang('language'),
				'query'=>$this->get_print_lang()
			],true);
			
		// exp
		$query = $this->Crud->get_all(
			'application_hr_expirience',
			['application_id'=>$this->app['id']],null,null,'area,duration,managerial');
		
		$select = [];
		foreach(['expirience_duration'=>'duration','expirience_managerial'=>'managerial'] as $key=> $column){
			foreach($this->Crud->get_all($key,null,'id','asc') as $value){
				$options[$value['id']] = $value[$column];
			}
			$select[$column] = $options;
		}
		
		foreach($query as  &$value){
			$value['managerial'] = $select['managerial'][$value['managerial'] ];
			$value['duration'] = $select['duration'][$value['duration'] ];;
		}
		
		
		
		$html .= $this->load->view('apply_final/printer/table',['title'=>lang('experience'),
				'query'=>$query],true);
				
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