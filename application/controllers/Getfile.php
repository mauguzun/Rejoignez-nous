<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Getfile extends Usermeta_Controller
{
	private $data = [];
	private $_user_id;
	private $_redirect;
	private $_table = 'users_files';

	public function __construct()
	{
		parent::__construct('user/offers',FALSE);

	}

	public function index($table,$id,$value,$column)
	{

		
			$img = str_replace(base_url(),"",$_GET['url']);
			$ext = pathinfo($img);
			
			
			$row = $this->Crud->get_row(['user_id'=>$this->ion_auth->user()->row()->id,'file'=>$ext['basename']],$this->_table);
		
			if($row){
			
				$this->load->helper('download');
				force_download("./".$img,NULL);
				return ;
			}
			else
			{
				show_404();
			}

		}
		show_404();
	}



}


