<?

class Shared_Controller extends CI_Controller
{


    static public $map = 'shared';
   public $user_id;


    public function __construct($allowed_group)
    {
      
        parent::__construct();


        if (!$this->ion_auth->in_group($allowed_group))
        redirect(base_url('auth'));


	
        $this->load->language(['admin','site','ion_auth']);
        $this->load->library('menu/Backmenu');
       
       $this->user_id = (string)$this->ion_auth->user()->row()->id;




    }

    public function show_header($meta=NULL)
    {
		$segs = $this->uri->segment_array();
	   
		

        if (!$this->ion_auth->is_admin())
        $user_group = $this->ion_auth->get_users_groups( $this->ion_auth->user()->row()->id )->result()[0]->id;
        else
        $user_group = 1;

        $this->load->view("back/parts/header",[
                'charset'=>!$this->main_settings? 'utf-8':$this->main_settings['charset'],
				'meta'=>!$meta ? $this->meta :  $meta,
                'current_lang'=>$this->getCurrentLang(),
                'admin_menu'=>$this->backmenu->get($user_group),
                'lang_list'=>$this->languagemenu->get(),
                'current'=> $segs[1].'/'.$segs[2]
            ]);
    }
    
    /**
	* 
	* 
	* @return true|false 
	*/
    protected function get_user_edit()
    {
		$allowed  = [];
        $user_groups = $this->ion_auth->get_users_groups( $this->ion_auth->user()->row()->id )->result();
        foreach ($user_groups as $value) {
            array_push($allowed,(int)$value->id);
        }
            
        if (in_array(1,$allowed) | in_array(2,$allowed) | in_array(3,$allowed) | in_array(4,$allowed) ) {
            return true ;
        }
        return FALSE;
	}


    protected function get_group_category()
    {
		$allowed  = [];
        $user_groups = $this->ion_auth->get_users_groups( $this->ion_auth->user()->row()->id )->result();
        foreach ($user_groups as $value) {
            array_push($allowed,(int)$value->id);
        }
            
        if (in_array(1,$allowed) | in_array(2,$allowed) | in_array(5,$allowed) ) {
            return NULL ;
        }
      /*  else if (in_array(5,$allowed))
        {
			 return [1,4];
		}*/
        else if(in_array(3,$allowed)| in_array(6,$allowed)  ){
			return 2;
		}
		else if (in_array(4,$allowed)|  in_array(7,$allowed)){
			return 3;
		}
		
	}


}