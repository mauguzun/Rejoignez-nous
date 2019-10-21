<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*  can use admin ,and hr
*/
class Applications extends Shared_Controller{
	private $data = [];
	private $_redirect ;

	private $_table = 'application';
	private $_allowed = [1,2,3,4,5,6,7];
	private $_ajax;
	private $_config;
	private $_mode;

	private $_lang_level;
	private $_education_level;
	private $_statuses;
	private $_functions;

	private $_function_filter_id = NULL;

	public function __construct(){
		parent::__construct($this->_allowed);
		$this->_redirect = base_url().Shared_Controller::$map.'/applications';
		$this->_ajax = base_url().'access/Hr_Admin';

		$this->load->library(["Colors","Folderoffer","Uploadconfig","Uploadlist"]);
		$this->_config = $this->uploadconfig->get();



		$this->load->language("ion_auth");
		
		
		foreach($this->Crud->get_all('language_level') as $value){
			$this->_lang_level[$value['id']] = $value['level'];
		}

		foreach($this->Crud->get_all('hr_offer_education_level') as $value){
			$this->_education_level[$value['id']] = $value['level'];
		}

		foreach($this->Crud->get_all('application_status') as $value){
			$this->_statuses[$value['id']] = $value['status'];
		}
		foreach($this->Crud->get_all('functions') as $value){
			$this->_functions[$value['id']] = $value['function'];
		}

	}


	public function index($mode = 0){

		//$this->_set_mode($mode);

		$this->show_header();
		$js = strip_tags( $this->load->view('js/circle',NULL,TRUE));
		
		$this->load->view('back/data_table_filter',[
				'url'=>$this->_redirect.'/ajax',
				'statuses'=>$this->_statuses,
				'category_id'=>$this->get_group_category(),
				'functions'=>$this->_functions
			]);
						
		$this->load->view('back/parts/datatable',[
				'headers'=>[
					'create_offer_pub_date', 
					'index_fname_th','index_lname_th','function',
					
					/*		'#',*/
					'<input  type="checkbox" id="main" />',
					'create_offer_pub_date',
					/*			'category' ,
					'activity',*/
					'education','languages','managment','availability','car','<i class="fas fa-wheelchair"></i>',
					/*'history',*/
					'call','folder','interview','test','decision','status',
					'<i class="fas fa-exclamation-triangle"></i>',	
					'<i class="fa fa-eye" ></i>',	
					'<i class="far fa-file-archive"></i>',
					'<i class="fa fa-print"></i>',
					'<i class="fa fa-envelope"></i>',
					'<i class="fa fa-edit" ></i>'
				],
				'title' =>lang('applications'),
				'url' => $this->_redirect.'/ajax/'.$this->_mode.'?'.$_SERVER['QUERY_STRING'] ,
				'js'=>$js,
				'add_button' => ($this->ion_auth->in_group([5,6,7])) ? NULL : $this->_redirect.'/add/'.$this->_mode,
				'extra'=>[
					
					$this->load->view('back/application',null,true),

				]
			]);

		$this->load->view('js/disable_add_modal')  ;
		$this->load->view('back/parts/footer');



	}
	/**
	* ajax method to send application
	*
	* @return
	*/

	public function email($application_id){

		$app = $this->Crud->get_joins(
			$this->_table,
			["offers"=>"$this->_table.offer_id =  offers.id"],
			"$this->_table.id as aid,$this->_table.*,offers.*",
			NULL,"aid"

		);

		$off = new Apply_Hr_Controller();


	}


	public function add($mode = 1){
		//$this->_set_mode($mode);


		if(!$this->ion_auth->in_group([1,2,3,4])){
			redirect (base_url().'shared/applications');
		}

		// check more


		$this->show_header();
		$this->_set_form_validation($this->_redirect.'/insert/'.$this->_mode);
		$this->_set_data();




		$app_id = time();
		$this->load->view('js/ajaxupload');


		$this->data['control']["asdf"] = form_label('<b>*</b>'.lang("cv"));
		foreach(['cv','covver_letter'] as $value){

			$this->data['control']["X{$value}"] = $this->load->view('front/apply/part/ajaxuploader',
				[
					'upload_id'=>$value,
					'upload_url'=>base_url().'apply/ajaxupload/upload/'.$app_id.'/'.$value,
					'show_me'=>NULL,
				],TRUE
			);
		}

		$this->data['control']['h'] = form_hidden('id',$app_id);



		$this->load->view(Admin_Controller::$map .'/parts/manualay_create_application',$this->data);
		$this->load->view('js/ajax_select',['url'=>$this->_redirect.'/select/'.$mode]);
		
		$this->load->view('js/manual_application'); 
		$this->load->view('back/parts/footer');
	}

	public function select($nevermind = NULL){
		//$this->_set_mode($mode);



		$where = $this->get_filter_array();

		if(is_array($where)){
			unset($where['application.deleted']);
			unset($where['filled']);
		}
		else{

			$where = "offers.category = 1 or offers.category = 4 ";

		}


		$query = $this->Crud->get_like(['title'=>$_POST['q']],'offers',$where);
		$res = [];
		foreach($query as $row){
			
			$active = $row['status'] == 1 ? '✓' : '×';
			$res[] = [  
				'id'=>$row['id'],
				'title'=>$row['title'] .' ' . $row['pub_date'] . ' ' .$active
			];
		}
		echo json_encode($res);


	}


	public function insert($mode = 1){

		if(!$this->ion_auth->in_group([1,2,3,4])){
			redirect (base_url().'shared/applications');
		}

		$this->_set_form_validation($this->_redirect.'/insert/'.$this->_mode);


		if($this->form_validation->run() === TRUE){

			if($_POST['offer_id'] == 0 ){
				$this->data['message'] = lang("pls select offer ");
				$this->session->set_flashdata('message', 'adas');
				redirect($this->_redirect.'/add');
			}
			else{

				// create user
				$user = $this->Crud->add([
						'comment'=>$_POST['comment'],
						'admin_id'=>$this->ion_auth->user()->row()->id,
						'first_name'=>$_POST['first_name'],
						'last_name'=>$_POST['last_name'],
					],'users'
				);


				// appedn to ffer
				$this->Crud->add(
					[
						'manualy'=>1,
						'filled'=>1,
						'id'=>$_POST['id'],
						'user_id'=>$user['id'],
						'offer_id'=>$_POST['offer_id'],
						'unsolicated_function'=>$_POST['unsolicated_function'],
						'first_name'=>$_POST['first_name'],
						'last_name'=>$_POST['last_name'],
						/*'opinion_folder '=>$_POST['opinion_folder'],
						'opinion_interview '=>$_POST['opinion_interview'],
						'opinion_test '=>$_POST['opinion_test'],
						'opinion_decision '=>$_POST['opinion_decision'],*/
					],$this->_table);

				// add Cv

				redirect($this->_redirect);
			}
		}else{
			echo validation_errors();
		}
		redirect($this->_redirect);

	}


	private function _set_form_validation($url){
		$this->data['title'] = lang('manualay_applications');
		$this->data['url'] = $url;
		$this->data['buttons'] = [

			'create'=>$url,
		];
		$this->data['cancel'] = $this->_redirect.'/'.$this->_mode;


		$this->form_validation->set_rules('first_name', lang('first_name'), 'trim|required|max_length[50]');
		$this->form_validation->set_rules('last_name', lang('last_name'), 'trim|required|max_length[50]');
		$this->form_validation->set_rules('offer_id', lang('offer_id'), 'trim|numeric|max_length[11]');



	}

	private function _set_data($user = NULL){


		$this->load->library("html/InputArray");
		foreach(['first_name','last_name'] as $value){
			$this->data['control']["{$value}_l"] = form_label('<b>*</b>'.lang($value));
			$this->data['control'][$value] = form_input(
				$this->inputarray->getArray($value,'text',lang($value),NULL,TRUE));
		}

		$this->data['control']["offer_id_l"] = form_label('<b>*</b>'.lang("pick_offer_id"));
		$this->data['control']['offer_id'] =
		form_dropdown('offer_id', [],$value,['class'=>'form-control selectpicker with-ajax',
				'data-live-search'=>true,
				'required'=>TRUE
			]);


		if($user){
			$this->data['control']['id'] = form_input( $this->inputarray->getArray('id','hidden',null,$user['id'],TRUE));
		}

		$activity = ($user)? $user['function'] : $this->form_validation->set_value('activity');


		$this->data['control']["_l"] = form_label('<b>*</b>'.lang('function'));
		$this->data['control']['unsolicated_function'] =
		form_input( $this->inputarray->getArray('unsolicated_function','text',
				lang('function'),$activity,TRUE,
				[
					'data-typehead'=>true,
					'data-typehead-column'=>'function',
					'data-typehead-url'=>$this->_ajax.'/typehead',
					'data-typehead-table'=>'functions'
				]));

		/* //
		$countries = $this->Crud->get_all('offers_users_contract',NULL,'type','asc');
		$options = [];
		foreach ($countries as $coutry) {
		$options[$coutry['id']] = $coutry['type'];
		}
		$this->data['control']["contract_id_l"] = form_label(lang("contract_id"));
		$this->data['control']['contract_id'] =
		form_dropdown('contract_id', $options,NULL,['class'=>'form-control']);*/


		/*foreach(['handicaped'] as  $column){
		$value = isset($user[$column]) ? $user[$column]  : 0;
		$this->data['control']["{$column}_l"] = form_label('<b>*</b>'.lang($column));
		$this->data['control'][$column] =
		form_dropdown($column, [0=>lang('no'),1=>lang('yes')],$value,['class'=>'form-control']);
		}

		$countries = $this->Crud->get_all('applicaiton_opinion',NULL,'opinion','asc');
		$options = [];
		foreach($countries as $coutry){
		$options[$coutry['id']] = $coutry['opinion'];
		}
		foreach(['opinion_folder','opinion_interview','opinion_test','opinion_decision']as $column){
		$this->data['control']["{$column}_"] = form_label('<b>*</b>'.lang(str_replace("opinion_","",$column)));
		$this->data['control'][$column] =
		form_dropdown($column, $options,NULL,['class'=>'form-control']);

		}*/


		foreach(['comment'] as $column){

			$this->data['control']["{$column}_l"] = form_label(lang($column));

			$selected = ($user) ? $user[$column]: NULL;
			$this->data['control'][$column] = form_textarea(
				$this->inputarray->getArray($column,null,lang($column),$selected
				));
		}


	}


	public function offer_titles(){

		if(isset($_POST)){

			if($_POST){
				$result = [];
				$where  = $this->get_filter_array();

				if(is_array($where)){
					unset($where['deleted']);
					unset($where['filled']);
				}
				else{
					if(isset($_GET['mode']) && $_GET['mode'] != 0){
						$where = "offers.category = ". $_GET['mode']; ;
					}
					else{
						$where = "offers.category = 1 or offers.category = 4 ";
					}
				}



				$query = $this->Crud->get_like(
					['title'=>trim($_POST['query'])],'offers',$where);

				foreach($query as $value){
					array_push($result,$value['title']);
				}
				//$this->_result = array_map( function( $a ) { return $a[$arr['column']]; }, $query );
				echo json_encode($result);
				return;
			}
		}
		echo json_encode(['error'=>TRUE]);
	}


	public function ajax($mode = 0){

		$allowed = $this->get_filter_array();

		$query   = $this->Crud->get_joins(
			$this->_table,
			[
				'offers'=>"$this->_table.offer_id = offers.id",
				'users'=>"$this->_table.user_id = users.id",
				'applicaiton_misc'=>"$this->_table.id = applicaiton_misc.application_id",
				'application_status'=>"$this->_table.application_statuts = application_status.id",
				'application_english_frechn_level'=>"$this->_table.id = application_english_frechn_level.application_id",
				'application_languages_level'=>"$this->_table.id = application_languages_level.application_id",
				'offers_activities'=>"offers.id = offers_activities.offer_id",
				'offers_category'=>"offers.category=offers_category.id",
				'activities'=>"offers_activities.activiti_id = activities.id",
				'last_level_education'=>"$this->_table.id = last_level_education.application_id",
				"application_un_activity"=> "$this->_table.id =  application_un_activity.application_id",
				'application_hr_expirience'=>"last_level_education.education_level_id = application_hr_expirience.id",
				'application_hr_expirience'=>"$this->_table.id = application_hr_expirience.application_id",
				'mechanic_offer_aeronautical_experience'=>"$this->_table.id = mechanic_offer_aeronautical_experience.application_id",
				'offers_activities'=>"offers.id=offers_activities.offer_id",
				'activities'=>"offers_activities.activiti_id=activities.id",
				'function_activity'=>"activities.id=function_activity.activity_id",
				'functions'=>"functions.id=function_activity.function_id",
				'application_files'=>"$this->_table.id  =  application_files.application_id 
				and application_files.deleted  = 0 
				"
			],
			"$this->_table.* ,$this->_table.id as aid,   ,application.user_id as uid ,offers.*,applicaiton_misc.*,
			application_status.status as status,
			GROUP_CONCAT(DISTINCT application_languages_level.language  ) as for_langs,
			GROUP_CONCAT(DISTINCT activities.activity ) as activities,
			GROUP_CONCAT(DISTINCT application_un_activity.activity ) as un_activities,
			GROUP_CONCAT(DISTINCT application_hr_expirience.managerial ) as hr_managerial,
			GROUP_CONCAT(DISTINCT functions.function  SEPARATOR '<br>' ) as functions,		
			GROUP_CONCAT(DISTINCT functions.id  ) as functions_id,		
			GROUP_CONCAT(DISTINCT CONCAT(application_files.type,'/',application_files.file)   ) as files,		
			
			last_level_education.university as university,
			last_level_education.education_level_id as education_level,
			mechanic_offer_aeronautical_experience.managerial_duties as m_managerial,
			offers.category as offer_cat,
			offers.id as oid,offers.title as title,
			offers_category.category  as cat,
			users.handicaped as handicaped,		
			application_english_frechn_level.* ,$this->_table.*,application.*"

			,NULL , ["application.id"],$allowed);
			
			
			
	

		$data['data'] = [];
		foreach($query as $table_row){
			$rest = $this->_row($table_row);
			if($rest){
				array_push($data['data'],$rest);

			}
		}
		/*var_dump($data['data']);
		die();*/
		echo json_encode($data);
	}
	
	private function _row($table_row){
		
		
	
		$data['data'] = [];
		$row  = [];
		
		///
		if($this->_function_filter_id ){
			
			if( $table_row['unsolicated'] == 1  | $table_row['manualy'] == 1){
				return null;
			}
			
			$array = explode(',',$table_row['functions_id']);
			if(!in_array($this->_function_filter_id,$array)){
				return null;
			}
		}

		//

		$educaton = $table_row['education_level'] > 0 ?
		$this->_education_level[$table_row['education_level']] : NULL;
		$title = $table_row['unsolicated'] == 1 ? lang('unsolicited_application_applys') : $table_row['title'];


		if($table_row['unsolicated'] == 1){
			$print          = base_url().'apply/unsolicited/printme/index/'.$table_row['aid'];
			$lang_level_row = $lang_level_row = $this->_show_lang_in_table_column($table_row);
				
			$un = $this->Crud->get_row(['application_id'=>$table_row['aid']],'application_un');
			  
			/*	$title          = lang('unsolicited_application_applys');
			$funciton          = $un['function'];	*/
				
			$title          = $un['function'];
			$table_row['functions']= $un['function'];
			$email          = base_url().Shared_Controller::$map.'/sendemail/unsolicated/'.$table_row['aid'];;
		}
		else  
		if($table_row['manualy'] == 1){
			$lang_level_row = NULL;
		
			$title          = anchor($this->_redirect.'?offer='.$title,  $title ,['target'=>'_blank'] );	
			$funciton = $table_row['functions']." <br> <b>".lang('manual')."</b>";
			$email = base_url().Shared_Controller::$map.'/sendemail/manualy/'.$table_row['aid'];;
			$print = base_url().Shared_Controller::$map.'/printmanualoffer/index/'.$table_row['aid'];
		}
		else{
				
				
			$lang_level_row = $this->_show_lang_in_table_column($table_row);
				
			$print          = base_url().'/apply/'.$this->folderoffer->get_map($table_row['category']).'/printme/index/2/'.$table_row['aid'];
			$email          = base_url().Shared_Controller::$map.'/sendemail/'.$this->folderoffer->get_map($table_row['category']).'/'.$table_row['aid'];
			$title          = anchor($this->_redirect.'?offer='.$title,  $title ,['target'=>'_blank'] );
			$funciton          =  anchor(
				$this->_redirect.'?offer='.$table_row['title'],  $table_row['functions'] ,['target'=>'_blank'] );
			
				
		}
			
		$managerial = 'Not exist on '.$table_row['cat'];
			
		if(isset($table_row['offer_cat'])){
			switch($table_row['offer_cat']){
				case "1":
				$managerial = $this->_have($table_row['hr_managerial']);
				break;
			 		
				case "4":
				$managerial = $this->_have($table_row['m_managerial']);
				break; 	
			}
		}else if($table_row['unsolicated'] == 1){
			$managerial = $this->_have($table_row['hr_managerial']);
		}
		
		//function_by_admin
		
		/// 
		
		$funct =  $table_row['functions']; 
		if( isset($table_row['function_by_admin']) && $table_row['function_by_admin'] != null && array_key_exists($table_row['function_by_admin'],$this->_functions)){
			$funct = 
			'<a data-toggle="tooltip" data-placement="left" title="<b>'.
			lang('initially applied for the position of ').'</b><br>'.
			$table_row['functions']
			 
			.'"  ><i class="fas fa-exclamation-triangle"></i> '.
			$this->_functions[$table_row['function_by_admin']]." </a>";
		}
		
		array_push(
			$row,

			$table_row['add_date'],
			anchor(base_url().Shared_Controller::$map.'/viewuser/index/'.$table_row['aid'],$table_row['first_name']) ,
			anchor(base_url().Shared_Controller::$map.'/viewuser/index/'.$table_row['aid'],$table_row['last_name']) ,
			
			/*$title/*. $table_row['functions']*/ 
			$funct,
			
			/*$table_row['aid'],*/
			'<input class="table-checkbox" 
			data-person = "'.$table_row['first_name'].' '.$table_row['last_name'].'"
			data-email-id="'.$email.'"   type="checkbox" id="'.$table_row['aid'].'" />',
			time_stamp_to_date($table_row['add_date']),

			
			//	$funciton,
			/*	$table_row['cat'],
			$table_row['activities'].$table_row['un_activities'],*/
				
			$table_row['university']." ".  $educaton,
			$lang_level_row,
			$managerial,
			date_to_input($table_row['aviability']),
			$this->_have($table_row['car']) ,
			$this->_have($table_row['handicaped']),
			/*,*/
			$this->load->view("buttons/circle",
				[

					'color_id'=>$table_row['call_id'],
					'url'=>$this->_redirect.'/ajaxcolor/call_id/'.$table_row['aid'],
				],true),
			// opinion
			$this->load->view("buttons/circle",
				[
					'color_id'=>$table_row['opinion_folder'],
					'url'=>$this->_redirect.'/ajaxcolor/opinion_folder/'.$table_row['aid'],

				],true),
			$this->load->view("buttons/circle",
				[
					'color_id'=>$table_row['opinion_interview'],
					'url'=>$this->_redirect.'/ajaxcolor/opinion_interview/'.$table_row['aid'],
				],true),
			$this->load->view("buttons/circle",
				['color'=>$this->colors->get_color($table_row['opinion_test']),

					'color_id'=>$table_row['opinion_test'],
					'url'=>$this->_redirect.'/ajaxcolor/opinion_test/'.$table_row['aid'],

				],true),
			$this->load->view("buttons/circle",
				[
					'color_id'=>$table_row['opinion_decision'],
					'url'=>$this->_redirect.'/ajaxcolor/opinion_decision/'.$table_row['aid'],


				],true),

			$this->load->view("buttons/status",
				[

					'title'=>$table_row['status'],
					'statuses'=>$this->_statuses,
					'application_id'=>$table_row['aid'],


				],true),
			//$table_row['status'],
			
			$this->load->view("buttons/history",
				['url'=>base_url().Shared_Controller::$map.'/history/'.$table_row['uid']],true),
			$this->load->view("buttons/files",
				[
					'files'=>$table_row['files']
				],true),

			$this->load->view("buttons/zip",
				['id'=>$table_row['aid'], 'url'=>base_url().User_Controller::$map.'zipapp/'.$table_row['aid']],true),
			$this->load->view("buttons/print",
				['id'=>$table_row['aid'], 'url'=>$print],true),
			
			$this->load->view("buttons/email",
				[
					'email'=>$email,
					'name'=>$table_row['first_name'].' '.$table_row['last_name']
				
				],true),


			//anchor($email,'<i class="fas fa-envelope"></i>',['class'=>'email']),
			anchor(base_url().Shared_Controller::$map."/apphistory/".$table_row['aid'],'<i class="fas fa-edit" aria-hidden="true"></i>')


		);

		return $row;
	}

	/**
	*
	ajax function , pls check if admin
	* @return
	*/
	public function ajaxcolor($column,$applicaiton_id,$value){

		if($this->get_user_edit()){
			if( $this->Crud->update(['id'=>$applicaiton_id],[$column=>$value],$this->_table)){
				echo json_encode(['done'=>$this->colors->get_color($value)]);
				return ;
			}
		}
		echo json_encode(['error'=>'You dont have acces']);

	}

	
	private function _show_lang_in_table_column($table_row){
		
		$res = "";
		if(array_key_exists($table_row['english_level'],$this->_lang_level)){
			$res =  "<b> en </b>  : " .$this->_lang_level[ $table_row['english_level']];
		}
		if(array_key_exists($table_row['french_level'],$this->_lang_level)){
			$res .=  "<b> fr </b>  : " .$this->_lang_level[ $table_row['french_level']];
		}
		$res .= "<br>".$table_row['for_langs'];
		

		return $res;
				
	}
	public function ajaxstatus($application_id,$status_id){
		if($this->get_user_edit()){
			
			$array['application_statuts']=$status_id;
			if($status_id != '6'){
				$array['function_by_admin'] = NULL;
			}
			if( $this->Crud->update(['id'=>$application_id],$array,$this->_table)){
				// back this shit ?
				$statuses = [];
				foreach($this->Crud->get_all('application_status') as $value){
					$statuses[$value['id']] = $value['status'];
				}
				echo json_encode(['done'=>$statuses[$status_id]]);
				return ;
			}
		}
		echo json_encode(['error'=>'You dont have acces']);
	}

	private function _have($arg){

		$have = lang('yes_toogle');

		if(strpos($arg, ',')){
			$arr = explode(',',$arg);
			return max($arr) > 0  ? $have[1] : $have[0];
		}
		return $arg > 0  ? $have[1] : $have[0];

	}

	private function get_filter_array(){


		$category = $this->get_group_category();


		if($category == NULL)
		$allowed = NULL ;
		else
		if(is_numeric($category))
		$allowed['offers.category'] = $category;



		// any case
		$allowed['application.deleted'] = 0;
		$allowed['filled'] = 1;
		if(isset($_GET)){
			
			// new
			if(isset($_GET['function'])){
				$this->_function_filter_id = $_GET['function'];
			}

			if(isset($_GET['offer']) && !empty($_GET['offer']) && $_GET['offer'] != '0'){

				$allowed['offers.title'] = urldecode($_GET['offer']);
			}

			if(isset($_GET['status']) && $_GET['status'] != 0){
				$allowed['application.application_statuts'] = $_GET['status'];
			}

			if(isset($_GET['mode']) && $_GET['mode'] != 0 && !$this->get_group_category() ){

				switch($_GET['mode']){
					case 7:
					$allowed['application.manualy'] = 1;
					break;
					case 11:
					$allowed['application.manualy'] =0;
					$allowed['application.unsolicated'] =0;
					break;
					case 5:
					$allowed['application.unsolicated'] = 1;
					break;
					default:
					$allowed['offers.category'] = $_GET['mode'];
					break;
				}

			}

			if(is_array($this->get_group_category())){

				if(isset($_GET['mode']) && $_GET['mode'] != 0){
					$prefix = "offers.category = ". $_GET['mode']; ;
				}
				else{
					$prefix = "offers.category = 1 or offers.category = 4 ";
				}

				if(isset($_GET['status']) && $_GET['status'] != 0){
					$status = " application.application_statuts = ".$_GET['status']." and";
				}
				else{
					$status = NULL ;
				}


				if(isset($_GET['offer']) && !empty($_GET['offer']) && $_GET['offer'] != '0'){

					$title = "offers.title = '".urldecode($_GET['offer']) ."'  ";
					$prefix= "";

				}
				else{
					$title = NULL ;
				}

				$allowed = "{$title} {$status} {$prefix}  and filled = 1  and deleted = 0 ";

				return $allowed;
			}
		}

		//var_dump($allowed);

		return $allowed;
	}
	
	public function function_list($id){
		
	}
}
