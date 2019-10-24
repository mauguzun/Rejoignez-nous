<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Begin extends User_Controller{

	protected $step = 'delete';

	public function __construct(){
		parent::__construct('user/offers');

	}

	public function index(){


		
		$query = $this->Crud->get_all('application',
			['user_id'=>$this->user_id,'unsolicated'=>1,'filled'=>0]);
		
		
		foreach($query as &$value){
			$value['first_name'] = anchor(
				base_url().'apply/new/unsolicated/index/'.$value['id'],
				$value['first_name']
			);
		}
		

		if($query){
				

			$table = $this->load->view('front/parts/page_table',[
					'allert'=>$this->load->view('apply_final/unsolicated/begin',null,true),
					'headers'=>['add_date','first_name'],
					/*				'headers'=>['add_date','title','location','contract','activity'],
					*/		
					'query'=>$query,'title'=>lang('unfinished_applications')]);
						
			
			$this->show_footer();
		}else{
			redirect(base_url().'apply/new/unsolicated/index/');
		}
		
	}





}


