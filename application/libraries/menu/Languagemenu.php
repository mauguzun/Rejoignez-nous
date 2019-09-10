<?php

class Languagemenu{

	public function get( ){
		return
		[ 
			'en'=>'English',
			'fr'=>'Francais',
		];

	}
    
	public function get_code($code){
		
		
		
		if(!array_key_exists($code,$this->get())){
			return 'en';
		}else{
			return $this->get()[$code];
		}
		
	}


}
?>