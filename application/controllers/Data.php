<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller
{

    
    public function index()
    {
      
	  $d= 	file_get_contents('application/language/en/site_lang.php');
		
		foreach($d as  $k=>$v){
			echo $k;
		}
    }


}
