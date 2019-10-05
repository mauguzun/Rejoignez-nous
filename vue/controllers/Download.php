<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends CI_Controller
{

   
    public function get($filename=NULL)
    {
       if($filename)
       {
       	  $user_id = $this->ion_auth->user()->row()->id;
       	  
       	  $query = $this->Crud->get_row(['user_id'=>$user_id,'file' =>$filename],'users_files');
       	  if ($query){
		  	  $this->load->helper('download');
		  	  $this->load->library('Uploadconfig');
              $config =  $this->uploadconfig->get("/{$query['type']}");
              force_download("{$config['upload_path']}/{$filename}",NULL);
	   	 	  return;
		  }
       	  
       	 
		  	
		 

	   }
	  
    }

   

}
