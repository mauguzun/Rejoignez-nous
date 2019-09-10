<?php

class Colors
{

    private $colors = 
    [
    	'1'=>'grey',
    	'2'=>'green',
    	'3'=>'orange',
    	'4'=>'red'
    ];
    
    
    public function get_colors(){
		return $this->colors;
	}
	public function get_color($arg){
		 
		 if (array_key_exists($arg,$this->colors))
		 	return $this->colors[$arg];
		 	
		 return $this->colors['1'];
	}
	
}
