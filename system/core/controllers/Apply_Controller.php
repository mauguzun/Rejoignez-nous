<?

class Apply_Controller extends Usermeta_Controller
{
	protected $user_id;

	protected $_errors = NULL;


	public function __construct($page = 'user/index',$meta = NULL )
	{
		$this->_page = $page;
		parent::__construct(NULL,$meta = NULL,TRUE);


		$this->user_id = (string)$this->ion_auth->user()->row()->id;
		$this->load->library("InputArray");
		
		

	}
	public function open_form($offer_id,$offer)
	{
		//  move me lat
		$app = $this->application_id($offer_id);


		$this->load->view('front/apply/open',[
				'pagination'=>$this->get_pagination($offer_id),
				'title'=>$offer['title'],
				'step'=>$this->step,
				'apply'=>$this->apply.$offer_id,
				'delete'=>$this->delete.$offer_id,
				'printme'=>$this->printme.$offer_id,
				'app'=>$app,

			])
		;
	}

	protected function get_print_application($offer,$app_id = NULL)
	{
		if(!$app_id){
			return  $this->application_id($offer);
		}
		else
		{
			return  $this->Crud->get_row(['id'=>$app_id],'application');
		}

	}

	public function make_form_link($pages,$offer_id,$folder)
	{
		foreach($pages as $key=>&$value){

			$class = ($value == $this->step)? 'is-active':'';
			$value = '<span class="'.$class.'"    data-toggle="tooltip" title="'.lang($value).'"   ><a href="'.base_url().$folder.'/'.$value.'/index/'.$offer_id.'">&nbsp;</a></span>';
		}
		return $pages;
		//
	}

	/**
	*
	* @param undefined $application_id
	* @param array $before
	* @param array $new
	* @param undefined $select_id
	* @param undefined $select_value
	* @param undefined $table
	* @param array $scip
	*
	* @return
	*/
	public function savehistory($application_id,$before,$new,$select_id,$select_value,$table,$scip = NULL)
	{

		$bath = [];
		$row  = round(microtime(true) * 1000);

		if(!is_array($before))
		{
			return;
		}

		foreach($before as $key=>$value)
		{

			if($key == 'application_id')
			continue;

			if(is_array($scip) && in_array($key,$scip))
			continue;

			if(!array_key_exists($key,$new))
			{
				array_push($bath,[
						'application_id'=>$application_id,
						'table'=>$table,
						'column'=>$key,
						'old_value'=>$before[$key],
						'select_id'=>$select_id,
						'select_value'=>$select_value,
						'action'=>0,
						'row'=>$row
					]);
			}

			else
			if($before[$key] != $new[$key] )
			{
				array_push($bath,[
						'application_id'=>$application_id,
						'table'=>$table,
						'column'=>$key,
						'old_value'=>$before[$key],
						'select_id'=>$select_id,
						'select_value'=>$select_value,
						'action'=>1,
						'row'=>$row
					]);
			}
		}
		$this->Crud->update(['id'=>$application_id],['filled'=>0],'application');
		$this->Crud->add_many($bath,'application_history');

		// if not exist deleted
	}
	public function application_id($offer_id)
	{
		$app_id = $this->Crud->get_row(['offer_id'=>$offer_id,'user_id'=>$this->user_id,'deleted'=>0],'application');
		if($app_id){
			return $app_id;

		}
		else
		{
			return NULL;
		}
	}


	public function show_aviability($app)
	{


		$month     = new DateTime('now');
		$month->add(new DateInterval('P1M'));
		$month     = $month->format('d/m/Y');

		$month_two = new DateTime('now');
		$month_two->add(new DateInterval('P2M'));
		$month_two = $month_two->format('d/m/Y');

		////  append current date )
		$list      = [
			date('d/m/Y') => lang('Immédiate'),
			$month=>lang('Préavis 1 mois'),
			$month_two => lang('Préavis 2mois'),
			0=>lang('calendar'),
		];
		$date      = date("d/m/Y") ;

		if(isset($app['aviability']))
		{


			$date = date_to_input($app['aviability']);
			$list = [$date=>$date] + $list;
		}


		$this->data['control']["availability_l"] = form_label(lang("availability"));
		$this->data['control']["aviability"] = $this->load->view(
			'drop_calendar',[
				'name'=>'aviability' ,
				'default'=>$date,
				'options'=>$list],TRUE);
		/*
		foreach(['salary'] as $value){
		$activity = ($app)?$app[$value] : $this->form_validation->set_value($value);
		$this->data['control']["{$value}_l"] = form_label(lang($value));

		$this->data['control'][$value] = form_input(
		$this->inputarray->getArray($value,'number',lang($value),$activity,TRUE));
		}

		$have_car = isset($app)? $app['car'] : 0;

		$this->data['control']["car_l"] = form_label(lang("car"));
		$this->data['control']['car'] =
		form_dropdown('car', [0=>lang('not_have_car'),1=>lang('have_car')],$have_car,['class'=>'form-control']);


		foreach(['medical_restriction'] as $column)
		{

		$this->data['control']["{$column}_l"] = form_label(lang("medical_restriction"));

		$this->data['control'][$column] = form_textarea(
		$this->inputarray->getArray(
		$column,null,
		lang($column),
		($app) ? $app[$column]: NULL,FALSE
		));
		}*/

		$this->load->view('front/apply/part/form',$this->data);
	}

	public function show_other($app)
	{
		foreach(['salary'] as $value)
		{
			$activity = ($app)?$app[$value] : $this->form_validation->set_value($value);
			$this->data['control']["{$value}_l"] = form_label(lang($value));

			$this->data['control'][$value] = form_input(
				$this->inputarray->getArray($value,'number',lang($value),$activity,TRUE));
		}

		$have_car = isset($app)? $app['car'] : 0;

		$this->data['control']["car_l"] = form_label(lang("car"));
		$this->data['control']['car'] =
		form_dropdown('car', [0=>lang('not_have_car'),1=>lang('have_car')],$have_car,['class'=>'form-control']);


		/*foreach(['medical_restriction'] as $column)
		{

		$this->data['control']["{$column}_l"] = form_label(lang("medical_restriction"));

		$this->data['control'][$column] = form_textarea(
		$this->inputarray->getArray(
		$column,null,
		lang($column),
		($app) ? $app[$column]: NULL,FALSE
		));
		}*/

		$this->load->view('front/apply/part/form',$this->data);
	}
	protected function show_education($user = NULL )
	{


		if($user == null){
			$query = $this->Crud->get_all('application' ,
				['user_id'=>$this->ion_auth->user()->row()->id ,'filled'=>1,'deleted'=>0 ,'manualy'=>0 ],"add_date",'desc');


			if($query && array_key_exists(0,$query) ){
				$app = $query[0];
				$user = $this->Crud->get_row(['application_id'=>$app['id']],'last_level_education');
			}
		}
		// levels
		$levels = $this->Crud->get_all('hr_offer_education_level',NULL,'level','asc');
		$options = [];
		foreach($levels as $coutry)
		{
			$options[$coutry['id']] = $coutry['level'];
		}
		$selected = isset($user['education_level_id'])? $user['education_level_id']:1;



		$this->data['control']["education_level"] = form_label(lang("education_level"));
		$this->data['control']['education_level_id'] =
		form_dropdown('education_level_id', $options,$selected,['class'=>'form-control','data-hidden'=>true]);

		// set select required value
		$this->data['hidden_select_value'] = 1;
		$this->data['hidden_select_selected'] = $selected;
		//set unviersity
		$this->data['hidden'] = "";
		foreach(['studies','university'] as $value)
		{

			$required = ($value == 'studies')? TRUE:FALSE;

			$this->data['hidden'] .= $this->load->view('front/parts/one_form'
				,['value'=>form_label(lang("create_offer_{$value}"))] ,TRUE).
			$this->load->view('front/parts/one_form' ,[
					'value'=>form_input(
						$this->inputarray->getArray($value,'text',lang("edit_user_{$value}"),

							isset($user[$value]) ? $user[$value] : NULL
							,$required))] ,TRUE);
		}
		$this->load->view('front/apply/part/form',$this->data);


	}


	public function show_upload($offer_id,$map)
	{

		$this->load->library("Uploadconfig");
		$offer = $this->errors($offer_id);
		if(!$offer)
		{
			return ;
		}

		$app = $this->application_id($offer_id);
		if(!$app){
			redirect($this->get_page($offer_id,'main').FILL_FORM);
		}


		$this->show_header([$offer['title'],$offer['title'],$offer['title']]);
		$this->open_form($offer_id,$offer);

		$this->load->view('js/ajaxupload');
		$query   = $this->Crud->get_all( 'application_files' ,['deleted'=>0, 'application_id'=>$app['id'],'type'=>$this->step]);
		$show_me = [] ;
		foreach($query as $value)
		{

				$show_me[$value['id']] = 
			[
				'img'=>base_url().$this->uploadconfig->get("/".$value['type'])['upload_path'].'/'.$value['file'],
				'name'=>$value['file']
			];
		}
		$this->load->view('front/apply/part/ajaxuploader',
			[
				'upload_id'=>$this->step,
				'upload_url'=>base_url().'apply/ajaxupload/upload/'.$app['id'].'/'.$this->step,
				'show_me'=>$show_me,
				'apply'=>$map,
			]
		);
		$this->load->view('front/apply/close_upload');
		$this->show_footer();

	}

	/**
	*
	* @param undefined $app
	*
	* @return
	*/

	public function show_upload_header($offer_id)
	{
		$offer = $this->errors($offer_id);
		if(!$offer)
		{
			return ;
		}

		$app = $this->application_id($offer_id);
		if(!$app){
			redirect($this->get_page($offer_id,'main').FILL_FORM);
		}

		$this->show_header([$offer['title'],$offer['title'],$offer['title']]);
		$this->open_form($offer_id,$offer);
	}

	public function show_upload_footer()
	{
		$this->load->view('front/apply/close_upload');
		$this->show_footer();
	}

	public function show_upload_with_type($type,$offer_id,$map,$last = FALSE)
	{
		$this->load->library("Uploadconfig");
		$offer = $this->errors($offer_id);
		if(!$offer)
		{
			return ;
		}

		$app = $this->application_id($offer_id);
		if(!$app){
			redirect($this->get_page($offer_id,'main').FILL_FORM);
		}




		$this->load->view('js/ajaxupload');
		$query   = $this->Crud->get_all( 'application_files' ,['deleted'=>0, 'application_id'=>$app['id'],'type'=>$type]);
		$show_me = [] ;
		foreach($query as $value)
		{

			$show_me[$value['id']] = base_url().$this->uploadconfig->get("/".$value['type'])['upload_path'].'/'.$value['file'];
		}
		$this->load->view('front/apply/part/ajaxuploader',
			[
				'upload_id'=>$type,
				'upload_url'=>base_url().'apply/ajaxupload/upload/'.$app['id'].'/'.$type,
				'show_me'=>$show_me,
				'apply'=>!$last?NULL:$map,
			]
		);


	}

	public function show_main($app)
	{

		if($app == null){
			$query = $this->Crud->get_all('application' ,
				['user_id'=>$this->ion_auth->user()->row()->id ,'filled'=>1,'deleted'=>0 ,'manualy'=>0 ],"add_date",'desc');


			if($query && array_key_exists(0,$query) )
			$app = $query[0];
		}



		$countries = $this->Crud->get_all('country_translate',
			['code'=>$this->session->userdata('lang')],'name','asc');
		$options   = [];
		foreach($countries as $coutry)
		{
			$options[$coutry['country_id']] = $coutry['name'];
		}
		$selected = isset($app['country_id'])? $app['country_id']:NULL;;
		//$this->data['control']["country_l"] = form_label(lang("country"));
		$this->data['control']['country_id'] =
		form_dropdown('country_id', $options,$selected,[
				'class'=>'form-control selectpicker',
				'data-live-search'=>"true"]);


		// address
		foreach(['city','zip','address','phone','phone_2'] as $value)
		{
			$activity = ($app)?$app[$value] : $this->form_validation->set_value($value);
			//$this->data['control']["{$value}_l"] = form_label(lang($value));

			$required = ($value == 'phone_2' )?FALSE:TRUE;
			$this->data['control'][$value] = form_input(
				$this->inputarray->getArray($value,'text',lang($value),$activity,$required));
		}

		$this->load->view('front/apply/part/form',$this->data);
	}

	public function show_mainlang($app)
	{
		$options = [];
		foreach($this->Crud->get_all("language_level",null,'id','asc') as $value){
			$options[$value['id']] = $value['level'];
		}

		foreach(['english_level','french_level'] as $column){
			$this->data['control']["{$column}_l"] = form_label(lang($column));
			$this->data['control'][$column] = form_dropdown($column, $options,($app) ? $app[$column]: NULL,['class'=>'form-control']);

		}
		$this->load->view('front/apply/part/form',$this->data);

	}

	public function show_foreign_lanuage($app_id,$row)
	{
		if($row == null){
			$query = $this->Crud->get_all('application' ,
				['user_id'=>$this->ion_auth->user()->row()->id ,'filled'=>1,'deleted'=>0 ,'manualy'=>0 ],"add_date",'desc');


			if($query && array_key_exists(0,$query) ){
				
				$app = $query[0];
				$row = $this->Crud->get_all('application_languages_level' , ['application_id'=>$app['id']]);
			}
		}
		
		
		//

		$levels = $this->Crud->get_all('language_level',NULL,'level','asc');
		$options = [];
		foreach($levels as $coutry){
			$options[$coutry['id']] = $coutry['level'];
		}
		$data_list_id = 'lang_list';


		//
		if($row){

			$this->data['data'] = [];
			foreach($row as $value){
				$line = [];
				$line['language[]'] = $this->data['control']['language[]'] = form_input(
					$this->inputarray->getArray('language[]','text',lang("edit_user_language"),$value['language'],FALSE,['list'=>$data_list_id]));
				$line['level_id[]'] = form_dropdown('level_id[]', $options,$value['level_id'],['class'=>'form-control']);
				/*$line['id[]'] = form_hidden('id[]',$value['id']);*/
				array_push($this->data['data'],$line);

			}
		}


		$options = [];
		foreach($this->Crud->get_all("language_level",null,'id','asc') as $value){
			$options[$value['id']] = $value['level'];
		}
		$app = $this->Crud->get_row(['application_id'=>$app_id],'application_english_frechn_level');
		if ($app == null && isset($row) && array_key_exists(0,$row))
		{
			
				$app = $this->Crud->get_row(['application_id'=>$row[0]['application_id']],'application_english_frechn_level');
		}
		foreach(['english_level','french_level'] as $column){
			$this->data['control'][$column] = form_dropdown($column, $options,($app) ? $app[$column]: NULL,['class'=>'form-control']);
		}



		$this->data['control']["level_id_label"] = form_label(lang("level_id"));
		$this->data['control']['level_id[]'] =
		form_dropdown('level_id[]', $options,null,['class'=>'form-control']);


		$this->data['control']['language[]'] = form_input(
			$this->inputarray->getArray('language[]','text',lang("edit_user_language"),NULL,FALSE,['list'=>$data_list_id]));

		$query = $this->Crud->get_all('language_list',null,'language','asc','language');
		$langs = array_map(
			function ($a)
			{
				return $a['language'];
			}, $query);

		$this->data['control']['data-list'] = $this->load->view('datalist',['name'=>$data_list_id,'list'=>$langs],TRUE);
		$this->load->view('front/apply/part/foreign_lang',$this->data);
	}


	// * index methods

	protected function other_index($offer_id,$map)
	{
		$offer = $this->errors($offer_id);
		if(!$offer)
		{
			return ;
		}

		$app = $this->application_id($offer_id);
		if(!$app)
		redirect($this->get_page($offer_id,'main').FILL_FORM);


		//$this->form_validation->set_rules('aviability', lang('aviability'), 'trim | required | max_length[20]');
		$this->form_validation->set_rules('salary', lang('salary'), 'trim|numeric|required');


		$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));
		// check form validation


		if( isset($_POST['salary']) && $this->form_validation->run() === true ){


			// we have app lets continute
			if($row){
				$this->savehistory($app['id'],$row,$_POST,'application_id',$row['application_id'],$this->get_table_name($this->step),
					['application_id','aviability','medical_restriction']);

				$this->Crud->update(['application_id'=>$app['id']],$_POST,$this->get_table_name($this->step));
				$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));

			}
			else
			{

				$_POST['application_id'] = $app['id'];
				$this->Crud->add($_POST,$this->get_table_name($this->step));
			}
			redirect($map);

		}
		else
		{

			$message = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


			$this->session->set_flashdata('message',$message);

		}

		$this->show_header([$offer['title'],$offer['title'],$offer['title']]);
		$this->open_form($offer_id,$offer);

		$this->show_other($row);
		$this->load->view('front/apply/close');
		$this->show_footer();
	}

	protected function education_index($offer_id = NULL ,$map )
	{



		$offer_row = $this->errors($offer_id);
		$offer     = $this->errors($offer_id);
		if(!$offer)
		{
			return ;
		}
		$app = $this->application_id($offer_id);
		if(!$app)
		redirect($this->get_page($offer_id,'main').FILL_FORM);


		$can_update = FALSE;
		$this->form_validation->set_rules('education_level_id', lang('education'), 'trim|required|numeric');

		$app = $this->application_id($offer_id);


		if($this->form_validation->run() === TRUE)
		{

			if($this->input->post('education_level_id') != '1')
			{
				//$this->form_validation->set_rules('university', lang('university'), 'trim | required | max_length[255]');
				$this->form_validation->set_rules('studies', lang('studies'), 'trim|required|max_length[255]');

				if($this->form_validation->run() === TRUE)
				{
					$can_update = TRUE;
				}
			}
			else
			{
				$can_update = TRUE;
			}
		}


		if($can_update)
		{
			$_POST['application_id'] = $app['id'];
			$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));
			if($row){
				$this->savehistory($app['id'],$row,$_POST,'application_id',$app['id'],$this->get_table_name($this->step),
					['application_id'],0);
			}

			$this->Crud->update_or_insert($_POST,$this->get_table_name($this->step));


			redirect($map);
		}
		else
		{
			$message = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->session->set_flashdata('message',$message);
		}

		$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));
		$this->show_header([$offer_row['title'],$offer_row['title'],$offer_row['title']]);
		$this->open_form($offer_id,$offer_row);
		$this->show_education($row);
		$this->load->view('front/apply/close');
		$this->show_footer();
	}

	protected function main_index($offer_id,$map)
	{

		$offer_row = $this->errors($offer_id);
		if(!$offer_row)
		{
			return ;
		}
		// 1 check if ok ?

		if(isset($_GET['fill_form'])){
			$this->session->set_flashdata('message',lang('fill_form'));
		}
		// chek if profile not filed

		$cand = $this->Crud->get_row(['user_id'=>$this->user_id],'candidates');
		foreach(['civility','first_name','last_name','birthday'] as $value)
		{
			if( empty($cand[$value]) )
			{
				redirect(base_url().'user/profile?q=fill_form&url_back='.$this->get_page($offer_id,'main'));
			}
		}



		$this->form_validation->set_rules('address', lang('address'), 'trim|required|max_length[255]');
		$this->form_validation->set_rules('phone', lang('phone'), 'trim|required|max_length[20]');		
	//	$this->form_validation->set_rules('phone', lang('phone'), 'trim|required|numeric|max_length[20]');
		$this->form_validation->set_rules('phone_2', lang('phone'), 'trim|max_length[20]');
		$this->form_validation->set_rules('zip', lang('zip'), 'trim|required|max_length[10]');
		$this->form_validation->set_rules('country_id', lang('country_id'), 'trim|required|numeric');
		$this->form_validation->set_rules('city', lang('city'), 'trim|required|max_length[255]');


		$app = $this->application_id($offer_id);

		// check form validation
		if(isset($_POST['zip']) && $this->form_validation->run() === true){

			if(!$app){
				$_POST['user_id'] = $this->user_id;
				$_POST['offer_id'] = $offer_id;
				$app = $this->Crud->add($_POST,$this->get_table_name($this->step));
			}
			else
			{
				// update
				$_POST['user_id'] = $this->user_id;
				$_POST['offer_id'] = $offer_id;

				$this->savehistory($app['id'],$app,$_POST,'id',$app['id'],$this->get_table_name($this->step),
					['id','filled','unsolicated','manualy','call_id','application_statuts','opinion_decision','opinion_test','opinion_interview','opinion_folder','usser_id','deleted', 'add_date','update_date']);


				$this->Crud->update(['id'=>$app['id']],$_POST,$this->get_table_name($this->step));

			}
			$app = $this->application_id($offer_id);

			redirect($map);

		}
		else
		{
			$message = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->session->set_flashdata('message',$message);
		}



		$this->show_header([$offer_row['title'],$offer_row['title'],$offer_row['title']]);
		$this->open_form($offer_id,$offer_row,$app);

		$this->show_main($app);
		$this->load->view('front/apply/close');
		$this->show_footer();
	}


	protected function main_aviability($offer_id,$map)
	{

		$offer = $this->errors($offer_id);
		if(!$offer)
		{
			return ;
		}

		$app = $this->application_id($offer_id);
		if(!$app)
		redirect($this->get_page($offer_id,'main').FILL_FORM);


		$this->form_validation->set_rules('aviability', lang('aviability'), 'trim|required|max_length[20]');
		//$this->form_validation->set_rules('salary', lang('salary'), 'trim | numeric | required');


		$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));
		// check form validation


		if( isset($_POST['aviability']) && $this->form_validation->run() === true ){

			unset($_POST['fake_aviability']);
			$_POST['aviability'] = date_to_db($_POST['aviability']);
			// we have app lets continute
			if($row){
				$this->savehistory($app['id'],$row,$_POST,'application_id',$row['application_id'],$this->get_table_name($this->step),
					['application_id','medical_restriction','salary','car']);

				$this->Crud->update(['application_id'=>$app['id']],$_POST,$this->get_table_name($this->step));
				$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));

			}
			else
			{

				$_POST['application_id'] = $app['id'];
				$this->Crud->add($_POST,$this->get_table_name($this->step));
			}
			redirect($map);

		}
		else
		{

			$message = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


			$this->session->set_flashdata('message',$message);

		}

		$this->show_header([$offer['title'],$offer['title'],$offer['title']]);
		$this->open_form($offer_id,$offer);

		$this->show_aviability($row);
		$this->load->view('front/apply/close');
		$this->show_footer();
	}

	protected function mainlang_index($offer_id )
	{

		$offer = $this->errors($offer_id);
		if(!$offer)
		{
			return ;
		}

		$app = $this->application_id($offer_id);
		if(!$app)
		redirect($this->get_page($offer_id,'main').FILL_FORM);


		$this->form_validation->set_rules('english_level', lang('english_level'), 'trim|max_length[2]');
		$this->form_validation->set_rules('french_level', lang('french_level'), 'trim|max_length[2]');


		$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));
		// check form validation


		if(  isset($_POST['english_level']) && $this->form_validation->run() === true ){


			// we have app lets continute
			if($row){

				$this->savehistory($app['id'],$row,$_POST,'application_id',$row['application_id'],$this->get_table_name($this->step),
					['application_id']);

				$this->Crud->update(['application_id'=>$app['id']],$_POST,$this->get_table_name($this->step));

			}
			else
			{

				$_POST['application_id'] = $app['id'];
				$this->Crud->add($_POST,$this->get_table_name($this->step));
			}
			$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));

		}
		else
		{

			$message = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));



			$this->session->set_flashdata('message',$message);

		}

		$this->show_header([$offer['title'],$offer['title'],$offer['title']]);
		$this->open_form($offer_id,$offer);

		$this->show_mainlang($row);
		$this->load->view('front/apply/close');
		$this->show_footer();

	}

	public function foreign_index($offer_id ,$map )
	{



		$offer = $this->errors($offer_id);
		if(!$offer){
			return ;
		}



		$app = $this->application_id($offer_id);
		if(!$app)
		{
			redirect($this->get_page($offer_id,'main').FILL_FORM);
		}
		$this->form_validation->set_rules('english_level', lang('language'), 'trim|required|max_length[255]');
		$can_redirect = FALSE;


		if(  isset($_POST['english_level'])  ){

			$main_row = $this->Crud->get_row(['application_id'=>$app['id']],'application_english_frechn_level');

			// we have app lets continute
			if($main_row){
				$new = [
					'french_level'=> $_POST['french_level'] ,
					'english_level'=> $_POST['english_level'],
					'application_id'=>$app['id']
				];
				//$application_id,$before,$new,$select_id,$select_value,$table,$scip = NULL
				$this->savehistory($app['id'],$main_row,$new,'application_id',$main_row['application_id'],
					'application_english_frechn_level',['application_id']);

				$this->Crud->update_or_insert($new, 'application_english_frechn_level');

			}
			else
			{

				$this->Crud->add(
					[
						'french_level'=> $_POST['french_level'],
						'english_level'=> $_POST['english_level'],
						'application_id'=>$app['id']
					],'application_english_frechn_level');
			}
			$row          = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));
			$can_redirect = TRUE;
		}
		// end oiof shit :)

		$row = $this->Crud->get_all($this->get_table_name($this->step),['application_id'=>$app['id']]);

		if( isset($_POST['language']) && $this->form_validation->run() === TRUE)
		{
			if($row)
			{

				$langs = [];
				for($i = 0 ; $i < count($_POST['language']) ; $i++){
					$lang = [
						'language' => $_POST['language'][$i],
						'level_id' => $_POST['level_id'][$i],
						'application_id'=> $app['id'],
					];
					array_push($langs,$lang);
				}
				foreach($row as $value)
				{
					if(!in_array($value,$langs))
					{

						// oe ? we find you bich
						$this->savehistory($app['id'],$value,[],'application_id',
							$app['id'],$this->get_table_name($this->step),['application_id']);
						$this->Crud->delete($value,$this->get_table_name($this->step));
					}
				}

				foreach($langs as $new_value)
				{
					if(!empty($new_value['language'])){
						$this->Crud->update_or_insert($new_value,$this->get_table_name($this->step));
					}


				}
			}
			else
			{
				$langs = [];
				for($i = 0 ; $i < count($_POST['language']) ; $i++){
					if(!empty($_POST['language'][$i])){
						$langs[] = [
							'language' => $_POST['language'][$i],
							'level_id' => $_POST['level_id'][$i],
							'application_id'=> $app['id']
						];
					}


				}

				$this->Crud->add_many($langs,$this->get_table_name($this->step));
			}
			$row          = $this->Crud->get_all($this->get_table_name($this->step),['application_id'=>$app['id']]);

			$can_redirect = TRUE;
		}

		if($can_redirect)
		{
			redirect($map);
		}

		$this->show_header([$offer['title'],$offer['title'],$offer['title']]);
		$this->open_form($offer_id,$offer);
		$this->show_foreign_lanuage($app['id'],$row);
		$this->load->view('front/apply/close');
		$this->load->view('front/apply/js/calendar_js');
		$this->show_footer();
	}



	// end index
	public function errors($offer_id)
	{
		if(!$offer_id | $offer_id < 1)
		$this->_errors[] = anchor(base_url(),'not_valid_id');

		$offer_row = $this->Crud->get_row(['id'=>$offer_id],'offers');

		if(!$offer_row)
		$this->_errors[] = anchor(base_url(),lang('offer_not_exist'));



		if($this->_errors){
			$this->show_header();
			$this->load->view('front/parts/messages',['messages'=>$this->_errors]);
			$this->show_footer();
			return NULL;
		}
		return $offer_row;
	}
	
	/**
	* 
	* @param string $email
	* 
	* @return true|false
	*/
	protected function application_done_email($email = null ){
		$candidate = $this->Crud->get_row(['user_id'=>$this->user_id],'candidates');
		$email = $this->ion_auth->user()->row()->email;
		$query = $this->Crud->get_row([
		'template_id'=>1,'lang'=>$this->getCurrentLang('lang')		],'email_template_translate');
		
		
		
		$text =  $query['text'];
		$text = str_replace('#NOM',$candidate['first_name'],$text);
		$text = str_replace('#PRENOM',$candidate['last_name'],$text);
		
		
		$this->load->library('email',[
		  'protocol'=>$this->email_settings['transport']
		]);

		$this->email->from($this->email_settings['email'],$this->email_settings['sender']);
		$this->load->library("json_model");


		$this->email->reply_to($this->email_settings['email'],$this->email_settings['sender']);
		$this->email->subject($query['subject']);
		$this->email->message($text);
		$this->email->to($email);
		if(!$this->email->send())
		{
			return false;
		}
		else
		{
			return true;
		}
		
	}




}