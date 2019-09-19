<?

class Usermeta_Controller extends CI_Controller{
	private $_page;



	static public $redirect = "user/profile";
	static public $map      = "user/";
	
	protected $user ; 


	public function __construct($page = 'user/index'){
   
		$this->_page = $page;
		parent::__construct();
        
		
        
		if(!$this->ion_auth->logged_in() | $this->ion_auth->user()->row() == null ){

			redirect(base_url().'auth/create_user?create_first');
			
		}
    	   
		$this->user =  $this->ion_auth->user()->row();
		$this->load->library("Uploadlist");

	}

	public function show_header($meta = NULL){
		
		parent::show_header($meta);

		/*  $this->load->library("menu/Topmenu");
		$this->load->library("menu/Usermenu");

		if ($meta) {
		$meta['title'] = $meta[0];
		$meta['description'] = $meta[1];
		$meta['keywords'] = $meta[2];

		}

		$this->load->view("front_asl/header",[
		'top_menu'=>$this->topmenu->get($this->ion_auth->logged_in()),
		'charset'=>!$this->main_settings? 'utf-8':$this->main_settings['charset'],
		'meta'=>!$meta ? $this->meta :  $meta,
		'user'=>$this->ion_auth->user()->row(),
		'page'=>$this->_get_page(),
		'current_lang'=>$this->getCurrentLang(),
		'usermenu'=>$this->usermenu->get($this->ion_auth->user()->row()),
		'lang_list'=>$this->languagemenu->get(),
		'logo'=>  base_url().$this->uploadlist->site_img().'/'.$this->meta['logo'],
		]);
		$this->show_user_menu();*/

	}
  


}