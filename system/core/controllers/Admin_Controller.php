<?

class Admin_Controller extends Shared_Controller
{

	
    static public $map = 'back';
    static public $redirect =  'back/main';
    
    
  
	public function __construct($page = 'admin/index')
	{
		$this->_page = $page;
	    parent::__construct(1);
	}
	
	

	
	
}