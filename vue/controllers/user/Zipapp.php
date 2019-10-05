<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zipapp extends Usermeta_Controller
{
	private $data = [];
	private $_user_id;
	private $_redirect;
	private $_table = 'application_files';

	public function __construct()
	{
		parent::__construct('user/offers',FALSE);

	}

	public function index($app_id  = NULL )
	{
		
		
		
		
		if(!$app_id)
		show_404();
		//$this->ion_auth->user()->row()->id
		
		$user_id = $this->ion_auth->user()->row()->id;
		$app = $this->Crud->get_row(['id'=>$app_id],'application');
		$user_group = $this->ion_auth->get_users_groups( $this->ion_auth->user()->row()->id )->result()[0]->id;
		
		
	
		if ( !$app | $user_group == '8'  && $app['user_id'] != $user_id )
			show_404();
		else  if ( $user_group == '8'  && $app['deleted'] == 1 )		
			show_404();
		
		
		$this->load->library(['Uploadlist','Uploadconfig']);
		
		
		$candidate = $this->Crud->get_row(['user_id'=>$app['user_id']],'candidates');
		$query        = $this->Crud->get_row(['id'=>$app['offer_id']],'offers');
        $directory    = $this->uploadconfig->get();
        $base         = $directory['upload_path'];
		$files        = ['cv','covver_letter'];
        switch ($query['category']) {
            case 2:
            foreach ( $this->uploadlist->get_pnt() as $value) {
                array_push($files,$value);
            }
            break;

            case 3:
            foreach ( $this->uploadlist->get_pnc() as $value) {
                array_push($files,$value);
            }
            break;

            case 4:
            foreach ( $this->uploadlist->get_mechanic() as $value) {
                array_push($files,$value);
            }
            break;


        }
		
		
		$this->load->helper('file');

        $this->load->library('zip');
        $move_me = $this->Crud->get_where_in('type',$files,$this->_table,['application_id'=>$app_id,'deleted'=>0]);

	
		
        foreach ($move_me as $value) {
        	
           $ext = pathinfo($base.'/'.$value['type'].'/'.$value['file'], PATHINFO_EXTENSION); 
           $this->zip->read_file($base.'/'.$value['type'].'/'.$value['file'],$value['type'].'_'.$app_id.'_'.date("Y").".".$ext);         
        }
       $this->zip->download(url_title($candidate['first_name']."_".$candidate['last_name']));
		
	}



}


