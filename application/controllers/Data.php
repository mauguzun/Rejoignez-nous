<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller{

    
	public function index(){
      
		$en = $this->lang->load('site_lang','en',TRUE);
		$fr = $this->lang->load('site_lang','en',TRUE);
		
		
		foreach($en as $k=>$v){
			if(array_key_exists($k,$fr)){
				echo $k."<br>";
			}
		}
	     
	}


}
