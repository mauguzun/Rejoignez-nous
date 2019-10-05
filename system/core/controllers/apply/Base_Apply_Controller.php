<?

class Base_Apply_Controller extends Usermeta_Controller{
	
	protected $user ;
	protected $table = 'application';
	
	
	protected $offer = null;
	protected $type = 'hr';
	// data 
	private $countries = null;
	
	
	protected $json =['app_id'=>null,'result'=>null,'message'=>null];


	public function __construct($page = 'user/index',$meta = NULL ){	
		parent::__construct(NULL,$meta = NULL,TRUE);	
		
		$this->user = $this->ion_auth->user()->row();	
		
		/*if(isset($_GET['fill_form'])){
		$this->session->set_flashdata('message',lang('fill_form'));
		}	*/	
		
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
	
	
	/**
	* @param int $offer_id
	* @return 
	*/
	public function main($offer_id){
	
		$this->form_validation->set_rules('address', lang('address'), 'trim|required|max_length[255]');
		$this->form_validation->set_rules('phone', lang('phone'), 'trim|required|max_length[20]');		
		$this->form_validation->set_rules('phone_2', lang('phone'), 'trim|max_length[20]');
		$this->form_validation->set_rules('zip', lang('zip'), 'trim|required|max_length[10]');
		$this->form_validation->set_rules('country_id', lang('country_id'), 'trim|required|numeric');
		$this->form_validation->set_rules('city', lang('city'), 'trim|required|max_length[255]');
		$this->form_validation->set_rules('first_name', lang('first_name'), 'trim|required|max_length[255]');
		$this->form_validation->set_rules('last_name', lang('last_name'), 'trim|required|max_length[255]');

		
		
		// check form validation
		if(isset($_POST) &&  $this->form_validation->run() === true){
			
			
			if(isset($_POST['change_acc'])){
				unset($_POST['change_acc']);	
				$this->json['message'] = "<p>". lang('user_account_updated')."</p>";
				$this->update_user_account($_POST);
			}
			
			$app = $this->Crud->get_row(['offer_id'=>$offer_id,'user_id'=>$this->user->id],'application');
			if(!$app){
				$_POST['user_id'] = $this->user->id;
				$_POST['offer_id'] = $offer_id;
				
				$app = $this->Crud->add($_POST,'application');
				$this->json['app_id'] = $app;
			}
			else{
				$this->Crud->update(['id'=>$app['id']],$_POST,'application');
				$this->json['app_id'] = $app['id'];
			}
			$this->json['result'] = TRUE;
			$this->json['message'] .= lang('saved');
		}
		else{
			$message = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->json['message'] .= $message;
		}
		$this->show_json();
	}
	
	protected function show_json(){
	
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

	protected function redirect_if_account_not_filled(){
		foreach(['civility','first_name','last_name','birthday','country_id'] as $value){
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
	
	
	protected function civility(){
		return  ['mr'=>lang('_mr'),'mrs'=>lang('_mrs')];
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
}