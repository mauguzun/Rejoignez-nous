<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apply extends Usermeta_Controller
{
	private $data = [];
	private $_user_id;
	private $_redirect;
	private $_table = 'offers';
	private $_filename = 'covver_letter';
	private $_errors = NULL;

	public function __construct()
	{
		parent::__construct('user/offers');
		$this->_user_id = $this->ion_auth->user()->row()->id;

	}

	public function index($offer_id = NULL )
	{

		if(!$offer_id | $offer_id < 1)
		$this->_errors[] = anchor(base_url(),'not_valid_id');

		$offer_row = $this->Crud->get_row(['id'=>$offer_id],'offers');



		if(!$offer_row)
		$this->_errors[] = anchor(base_url(),lang('offer_not_exist'));

		$this->show_header([$offer_row['title'],$offer_row['title'],$offer_row['title']]);


		if( $this->Crud->get_row(['user_id'=>$this->_user_id,'offer_id'=>$offer_id],'offers_users'))
		$this->_errors[] = anchor(base_url().'user/offers/',lang('you_are_applied'));


		$profile = $this->Crud->get_row(['user_id'=>$this->_user_id],'candidates');
		$required= ['address','handicaped','zip','city','country_id','phone','civility','birthday','car','availability','first_name','last_name'];


		if(!$profile){
			$this->_errors[] = anchor(base_url().'user/profile' ,lang('fill_all_fields_in_profile')  , ['target'=>'_blank']);
		}
		else
		{
			$result = $this->Crud->clearArray($profile,$required);
			if(!$result){
				$this->_errors[] = anchor(base_url().'user/profile' ,lang('fill_all_fields_in_profile')  ,
					['target'=>'_blank']);
			}
		}










		if(count($this->Crud->get_all('users_files',['user_id'=>$this->_user_id,'type'=>'cv'])) == 0)
		$this->_errors[] = anchor(base_url().'user/main/upload/main/cv' ,lang('cv')   ,[
				'target'=>'_blank',
				'data-modal-link'=>base_url().'user/main/upload/getpage/main/'.$value
			]);


		$this->_redirect = base_url().'user/apply/'.$offer_id;


		if(!$this->Crud->get_row(['user_id'=>$this->_user_id],'users_english_frechn_level')){
			$this->_errors[] = anchor(base_url().'user/main/language' ,lang('pls_fill_this_form')  ,
			 ['target'=>'_blank']);
		}


		if(!$this->_errors){

			switch($offer_row['category']){
				case 1:
				$this->_hroffer();
				break;

				case 2:
				$this->_pntoffer();
				break;

				case 3:
				$this->_pncoffer();
				break;


				case 4:
				$this->_mechoffer();
				break;
			}


			$error = NULL;
			if(!$this->_errors && $_SERVER['REQUEST_METHOD'] == 'POST'){
				$cv = $this->_doupload($this->_filename);

				if(isset($cv['error'])){
					$error = anchor($this->_redirect ,$cv['error']  ) ;
				}
				else
				{
					$file_id = $this->Crud->add(
						['file'=>$cv['upload_data']['file_name'],'type'=>$this->_filename,'user_id'=>$this->_user_id  ],'users_files');

					$this->Crud->update_or_insert(['cover_letter_file_id'=>$file_id,'offer_id'=>$offer_id,'user_id'=>$this->_user_id],'offers_users');

					redirect($this->_redirect);
				}

			}


		}

		if($this->_errors){
			$this->load->view('front/parts/messages',['messages'=>$this->_errors]);
		}
		else
		{
			$this->load->view('front/upload_letter',
				[
					'title'=> lang('pls_upload_cover_letter'),
					'filename'=>$this->_filename,
					'url'=>$this->_redirect,
					'error'=>$error
				]);

		}
		$this->load->view('js/data-modal');
		$this->load->view('front/parts/footer');



	}

	private function _mechoffer()
	{
		$required_in_table = [
			'mechanic_offer_additional'=>'mechanic/additional',
			'mechanic_offer_aeronautical_experience'=>'mechanic/expirience',
		];




		foreach($required_in_table as $table=>$message){
			if(!$this->Crud->get_row(['user_id'=>$this->_user_id],$table)){
				$this->_errors[] = anchor(base_url().'user/'.$message,lang('pls_fill_this_form'),['target'=>'_blank']);
			}
		}

		$this->load->library('Uploadlist');


		$doc_query = $this->Crud->get_where_in( 'type' , $this->uploadlist->get_mechanic(), 'users_files',
			['user_id'=>$this->_user_id],NULL,'type' );

		$docs = array_map(
			function($row)
			{
				return $row['type'];
			},$doc_query);
		$missing = array_diff( $this->uploadlist->get_mechanic(),$docs);



		foreach($missing as $value){
			$this->_errors[] = anchor(base_url().'user/main/upload/mechanic/'.$value,
				lang("please_upload")."  " .$value
				,[
					'target'=>'_blank',
					'data-modal-link'=>base_url().'user/main/upload/getpage/mechanic/'.$value
				]);
		}
	}

	private function _pncoffer()
	{
		// pnt_offer_flight_expirience_hours_total_hours
		$required_in_table = [
			'pnc_offer_additional'=>'pnc/additional',
			'pnc_offer_experience'=>'pnc/expirience',
		];




		foreach($required_in_table as $table=>$message){
			if(!$this->Crud->get_row(['user_id'=>$this->_user_id],$table)){
				$this->_errors[] = anchor(base_url().'user/'.$message,lang('pls_fill_this_form'),['target'=>'_blank']);
			}
		}

		$this->load->library('Uploadlist');


		$doc_query = $this->Crud->get_where_in( 'type' , $this->uploadlist->get_pnc(), 'users_files',
			['user_id'=>$this->_user_id],NULL,'type' );

		$docs = array_map(
			function($row)
			{
				return $row['type'];
			},$doc_query);
		$missing = array_diff($this->uploadlist->get_pnc(),$docs);




		foreach($missing as $value){
			$this->_errors[] = anchor(base_url().'user/main/upload/pnc/'.$value,
				lang("pls_upload")."  " .lang($value)
				,[
					'target'=>'_blank',
					'data-modal-link'=>base_url().'user/main/upload/getpage/pnc/'.$value
				]);
		}


	}

	private function _hroffer()
	{

		$required_in_table = [
			'last_level_education'=>'hr/education',
			'hr_offer_expirience'=>'hr/expirience' ];

		foreach($required_in_table as $table=>$message){
			if(!$this->Crud->get_row(['user_id'=>$this->_user_id],$table)){
				$this->_errors[] = anchor(base_url().'user/'.$message,lang('pls_fill_this_form'),['target'=>'_blank']);
			}
		}

	}

	private function _pntoffer()
	{

		// pnt_offer_flight_expirience_hours_total_hours
		$required_in_table = [
			'pnt_offer_additional'=>'pnt/additional',
			'users_eu'=>'main/eu/pnt',
			'users_medical'=>'main/medical/pnt',
			'pnt_offer_experience_in_instructor'=>'pnt/experience_in_instructor',
			'pnt_offer_licenses'=>'pnt/licenses',
			'pnt_offer_practice'=>'pnt/practice',
			'pnt_offer_flight_total_hours'=>'pnt/total_hours',
			'pnt_offer_flight_expirience'=>'pnt/flight_expirience',
			'pnt_offer_qualification'=>'pnt/qualification',
			'pnt_offer_successive_employers'=>'pnt/employers'];




		foreach($required_in_table as $table=>$message){
			if(!$this->Crud->get_row(['user_id'=>$this->_user_id],$table)){
				$this->_errors[] = anchor(base_url().'user/'.$message,lang('pls_fill_this_form'),['target'=>'_blank']);
			}
		}

		$this->load->library('Uploadlist');

		$doc_query = $this->Crud->get_where_in( 'type' , $this->uploadlist->get_pnt(), 'users_files',
			['user_id'=>$this->_user_id],NULL,'type' );


		$docs = array_map(
			function($row)
			{
				return $row['type'];
			},$doc_query);
		$missing = array_diff($this->uploadlist->get_pnt(),$docs);

		foreach($missing as $value){
			$this->_errors[] = anchor(base_url().'user/main/upload/pnt/'.$value,
				lang("pls_upload")."  " .lang($value)
				,[
				'target'=>'_blank',
				'data-modal-link'=>base_url().'user/main/upload/getpage/pnt/'.$value
			]);
		}

	}

	private function _doupload($file)
	{
		$this->load->library('Uploadconfig');
		$this->load->library('upload', $this->uploadconfig->get("/".$this->_filename));
		if( ! $this->upload->do_upload($file)){
			return array('error'=> $file."  ".lang("error").$this->upload->display_errors());
		}
		else
		{
			return array('upload_data'=> $this->upload->data());
		}
	}


}


