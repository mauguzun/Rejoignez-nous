<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Getfile extends Usermeta_Controller
{
	private $data = [];
	private $_user_id;
	private $_redirect;
	private $_table = 'application_files';

	public function __construct()
	{
		parent::__construct('user/offers',FALSE);
		$this->load->library("Uploadconfig");

	}

	public function index()
	{

		if(isset($_GET['url'])){
			$img = str_replace(base_url(),"",$_GET['url']);
			$ext = pathinfo($img);
			
			
			
			
			
			if ($this->ion_auth->in_group(8))
			{
				$row = $this->Crud->get_row(['user_id'=>$this->ion_auth->user()->row()->id,'id'=>$_GET['url']],$this->_table);
			}
			else
			{
				$row = $this->Crud->get_row(['id'=>$_GET['url']],$this->_table);
			}
			
		
			if($row){
			
				$this->load->helper('download');
			//	echo $this->uploadconfig->get('/'.$row['type'])['upload_path'].'/'.$row['file'];
				force_download($this->uploadconfig->get('/'.$row['type'])['upload_path'].'/'.$row['file'],NULL);
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


