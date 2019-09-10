<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apply_un extends User_Controller
{
	private $data = [];
	private $_user_id;
	private $_redirect;
	private $_table = 'unsolicited';

	private $_errors = NULL;

	public function __construct()
	{
		parent::__construct('user/offers',['unsolicited_application'],true);
		$this->_user_id = $this->ion_auth->user()->row()->id;

	}

	public function index( )
	{

		$this->show_header(['unsolicited_application']);

		$required_in_table = [
			'unsolicited'=>'unsolicited/additional',
			'users_english_frechn_level'=>'main/language/unsolicated',
			'last_level_education'=>'unsolicited/education_un',
			'hr_offer_expirience'=>'main/expirience/unsolicated' ];


		foreach($required_in_table as $table=>$message)
		{
			if(!$this->Crud->get_row(['user_id'=>$this->_user_id],$table))
			{
				$this->_errors[] = anchor(base_url().'user/'.$message,lang('pls_fill_this_form'),['target'=>'_blank']);
			}
		}


		$profile = $this->Crud->get_row(['user_id'=>$this->_user_id],'candidates');
		$required= ['address','handicaped','zip','city','country_id','phone','civility','birthday','car','availability','first_name','last_name'];


		if(!$profile)
		{
			$this->_errors[] = anchor(base_url().'user/profile' ,lang('fill_all_fields_in_profile')  , ['target'=>'_blank']);
		}
		else
		{
			$result = $this->Crud->clearArray($profile,$required);
			if(!$result)
			{
				$this->_errors[] = anchor(base_url().'user/profile' ,lang('fill_all_fields_in_profile')  , ['target'=>'_blank']);
			}
		}


		$this->load->library('Uploadlist');


		$doc_query = $this->Crud->get_where_in( 'type' , $this->uploadlist->get_unsolocated(), 'users_files',
			['user_id'=>$this->_user_id],NULL,'type' );

		$docs = array_map(
			function($row)
			{
				return $row['type'];
			},$doc_query);
		$missing = array_diff( $this->uploadlist->get_unsolocated(),$docs);



		foreach($missing as $value)
		{
			$this->_errors[] = anchor(base_url().'user/main/upload/unsolicited/'.$value,
				lang($value)
				,[
					'target'=>'_blank',
					'data-modal-link'=>base_url().'user/main/upload/getpage/unsolicited/'.$value
				]);
		}


		if($this->_errors)
		{
			//$this->load->view('front / parts / messages',['messages'=>$this->_errors]);
		}
		else
		{
			$row = $this->Crud->get_row(['user_id'=>$this->_user_id],$this->_table);

			if($row['applied'] == 0 )
			{
				$this->_errors[] = form_label(lang('you_are_not_applied'));
			}
			else
			{
				$this->_errors[] = form_label(lang('you_are_applied'));

			}

			$this->_errors[] = anchor(base_url().'user/apply_un/set/1',lang('apply'));
			$this->_errors[] = anchor(base_url().'user/apply_un/set/0',lang('disable_if_im_total_jerk_and_delete_some_files'));
		}
		$this->load->view('front/parts/messages',['messages'=>$this->_errors]);
		$this->load->view('js/data-modal');
		$this->load->view('front/parts/footer');


	}
	public function set($mode = 0)
	{

		$mode = ($mode == 1 )? 1 : 0 ;
		$row  = $this->Crud->update(['user_id'=>$this->_user_id],['applied'=>$mode],$this->_table);
		redirect(base_url().'user/apply_un');


	}

}


