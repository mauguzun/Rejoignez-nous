<?

class Toogle
{
    private $_flag ;
    private $_text ;
    private $_class = ['toogle bg-danger-400 my-toogle','toogle bg-success-400 my-toogle'];
    
    
    public function __construc(){
		
		
		$this->_text = lang('pub_toogle');
		
	}
    
    private $_element = '<div 
	  id="%id%" 
	  data-column="%column%"
	  data-value="%value%" 
	  data-table="%table%"
	  data-selector="%selector%"
	  class="%class%">%text%
	  </div>';
	
	
    
    public function init($active = FALSE , $column,$table,$selector = NULL ){
		$this->_flag =  ($active | $active == 1) ? TRUE : FALSE;
		
		$this->_element = str_replace("%column%",$column,$this->_element);
		$this->_element = str_replace("%table%",$table,$this->_element);
		
		if ($selector)
		$this->_element = str_replace("%selector%",$selector,$this->_element);
		
		return $this;
	}
	
	
	
	public function set_text($text){
		$this->_text = $text;
		return $this;
	}
	
	public function set_class(){
		$this->_class[(int)$this->_flag];
		return $this;
	}
	
	
	public function set_flag($active){
		$this->_flag =  ($active | $active == 1) ? TRUE : FALSE;
		return $this;
	}

	public function get($id = NULL  ){
		
		$return = $this->_element;	
		$return = str_replace('%text%',$this->get_text(),$return);		
		$return = str_replace('%class%',$this->get_class(),$return);
		$return = str_replace('%value%',$this->get_value(),$return);
		$return = str_replace('%id%',$id,$return);
		return $return;
	}
	
	
	public function set_toogle(){
		$this->_flag = !$this->_flag ;
	}

	public function get_text(){
		return $this->_text[(int)$this->_flag];
	}
	public function get_class(){
		return $this->_class[(int)$this->_flag];
	}

	public function get_value(){
		return (int)$this->_flag;
	}
    


}