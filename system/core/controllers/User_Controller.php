<?

class User_Controller extends CI_Controller
{
    private $_page;
    protected $user_id;


    static public $redirect = "user/profile";
    static public $map      = "user/";



    public function __construct($page = 'user/index',$meta = NULL ,$disablhead = FALSE)
    {
        $this->_page = $page;
        parent::__construct();
        
        if (!$this->ion_auth->logged_in() | $this->ion_auth->user()->row() == null ){

			 redirect(base_url().'auth/create_user?create_first');
		}
       

		$this->load->library("Uploadlist");

        $this->user_id = (string)$this->ion_auth->user()->row()->id;
	
		if(!$disablhead)
        $this->show_header($meta);
    }

    public function show_header($meta = NULL)
    {

	
		parent::show_header($meta);
       /* $this->load->library("menu/Topmenu");
        $this->load->library("menu/Usermenu");

        if ($meta) {
            $meta['title'] = lang($meta[0]);
            $meta['description'] = isset($meta[1])?  lang($meta[1]) :  lang($meta[0]);
            $meta['keywords'] = isset($meta[2]) ?  lang($meta[2]) :  lang($meta[0]);
        }



        $this->load->view("front_asl/header",[
                'top_menu'=>$this->topmenu->get($this->ion_auth->logged_in()),
                'charset'=>!$this->main_settings? 'utf-8':$this->main_settings['charset'],
                'meta'=>!$meta ? $this->meta :  $meta,
                'user'=>$this->ion_auth->user()->row(),
				'current_lang'=>$this->getCurrentLang(),
				'page'=>$this->_get_page(),
				'usermenu'=>$this->usermenu->get($this->ion_auth->user()->row()),
				'logo'=>  base_url().$this->uploadlist->site_img().'/'.$this->meta['logo'],
                'lang_list'=>$this->languagemenu->get(),
            ]);

	;*/



    }

    

}