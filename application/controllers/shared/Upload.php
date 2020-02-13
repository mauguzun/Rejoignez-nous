<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// back / activity
class Upload extends Shared_Controller{
	private $data = [];
	private $_redirect ;

	private $_table = 'activities';
	private $_allowed = [1,2,3,4,5,6,7];
	private $_ajax;

	public function __construct(){
		parent::__construct($this->_allowed);
		$this->_redirect = base_url().Shared_Controller::$map.'/activity';
		$this->_ajax = base_url().'access/Hr_Admin';
       
		    
	}


	public function doupload()
	{
		if($_FILES['file']['name'])
		{
			if(!$_FILES['file']['error'])
			{
				$name        = md5(rand(100, 200));
				$ext         = explode('.', $_FILES['file']['name']);
				$filename    = $name . '.' . $ext[1];
				$destination = 'img/' . $filename; //change this directory
				$location    = $_FILES["file"]["tmp_name"];
				move_uploaded_file($location, $destination);
				echo base_url().'img/' . $filename;//change this URL
			}
			else
			{
				echo  $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
			}
		}
	}
}
