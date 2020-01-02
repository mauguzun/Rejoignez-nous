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
       



    }

    

}