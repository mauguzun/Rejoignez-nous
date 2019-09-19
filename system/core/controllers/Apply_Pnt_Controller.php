<?

class Apply_Pnt_Controller extends Apply_Controller
{
	protected $user_id;
	static public $map = "apply/pnt";
	protected $apply  ;
	protected $delete;
	protected $printme;

	protected 	$pages = [
		'main',
		'eu',
		'foreignlang',
		//'fcl',
		'licenses',
		'medical_aptitudes',
		'practice',
		'qualification_type',
		'total_flight_hours',
		'expirience',
		'experience_in_instructor',
		'successive_employer',
		'complementary_informations',
		'covver_letter',
		'cv',
	
 
	];
	public function __construct($page = NULL,$meta = NULL )
	{

		parent::__construct();
		$this->apply = base_url().'apply/pnt/apply/index/';
		$this->delete = base_url().'apply/pnt/delete/index/';
		$this->printme = base_url().'apply/pnt/printme/index/';
		$this->load->library("Uploadlist");
	}

	public function get_pagination($offer_id)
	{

		$pages          = $this->pages;

		$list_to_uplaod = $this->uploadlist->get_pnt();
		$pages          = array_merge($pages,$list_to_uplaod);




		return $this->make_form_link($pages,$offer_id,Apply_Pnt_Controller::$map);
	}

	public function get_page($offer_id,$page)
	{
		$pages          = $this->pages;
		$list_to_uplaod = $this->uploadlist->get_pnt();
		$pages          = array_merge($pages,$list_to_uplaod);
		foreach($pages as $key=>&$value)
		{
			if($page == $value)
			return  Apply_Pnt_Controller::$map.'/'.$value.'/index/'.$offer_id;
		}
		return NULL;

	}

	protected function get_table_name($step = NULL)
	{
		$tables      = [
			'main'=>'application',
			'eu'=>'application_eu_area',

			'foreignlang'=>'application_english_frechn_level',
			//'fcl'=>'application_fcl',
			'licenses'=>'application_licenses',
			'medical_aptitudes'=>'application_medical_aptitude',
			'practice'=>'application_pnt_practice',
			'qualification_type'=>'application_pnt_qualification',
			'total_flight_hours'=>'application_pnt_total_flight_hours',
			'expirience'=>'application_pnt_flight_expirience',
			'experience_in_instructor'=>'application_pnt_flight_expirience_instructor',
			'successive_employer'=>'application_pnt_successive_employers',
			'complementary_informations'=>'application_pnt_completary',
						'covver_letter'=>'application_files',

			
			'cv'=>'application_files',
			'employ_center'=>'application_empoy_center',

			
		];


		$tables_plus = [];
		foreach($this->uploadlist->get_pnt() as $value)
		{
			$tables_plus[$value] = 'application_files';
		}
		$tables = array_merge($tables,$tables_plus);

		if($step)
		return $tables[$step];
		else
		return $tables;
	}

	protected function flight_hour_index($offer_id,$map)
	{
		$offer = $this->errors($offer_id);
		if(!$offer)
		return ;


		$app   = $this->application_id($offer_id);
		$paqes = $this->get_pagination($offer_id);
		if(!$app)
		{
			redirect($this->get_page($offer_id,'main').FILL_FORM);
		}

		$this->form_validation->set_rules('last_flight[]', lang('function'), 'trim|required|max_length[25]');


		$row = $this->Crud->get_all($this->get_table_name($this->step),['application_id'=>$app['id']]);

		if($this->form_validation->run() === TRUE ){

			if($row)
			{

				$langs = [];
				for($i = 0 ; $i < count($_POST['last_flight']) ; $i++){
					$lang = [
						'application_id'=> $app['id'],
						'aircaft_type' => $_POST['aircaft_type'][$i],
						'total_hours' => $_POST['total_hours'][$i],
						'opl_hours' => $_POST['opl_hours'][$i],
						'cdb_hours' => $_POST['cdb_hours'][$i],
						'company' => $_POST['company'][$i],
						'last_flight' => date_to_db($_POST['last_flight'][$i])
					];
					array_push($langs,$lang);
				}
				foreach($row as $value)
				{

					$check_me = $value;
					unset($check_me['id']);
					if(!in_array($check_me,$langs))
					{

						// oe ? we find you bich
						$this->savehistory($app['id'],$check_me,[],'application_id',$app['id'],$this->get_table_name($this->step),['id']);

					}
				}
				$this->Crud->delete(['application_id'=>$app['id']],$this->get_table_name($this->step));
				foreach($langs as $new_value)
				{
					$this->Crud->update_or_insert($new_value,$this->get_table_name($this->step));
				}
			}
			else
			{

				$langs = [];
				for($i = 0 ; $i < count($_POST['last_flight']) ; $i++){
					$langs[] = [
						'application_id'=> $app['id'],
						'aircaft_type' => $_POST['aircaft_type'][$i],
						'total_hours' => $_POST['total_hours'][$i],
						'opl_hours' => $_POST['opl_hours'][$i],
						'cdb_hours' => $_POST['cdb_hours'][$i],
						'company' => $_POST['company'][$i],
						'last_flight' => date_to_db($_POST['last_flight'][$i])
					];
				}
				$this->Crud->add_many($langs,$this->get_table_name($this->step));



			}
			redirect($map);
		}



		$row = $this->Crud->get_all($this->get_table_name($this->step),['application_id'=>$app['id']]);


		$this->show_header([$offer['title'],$offer['title'],$offer['title']]);
		$this->open_form($offer_id,$offer);
		$this->flight_hour_show($row);
		$this->load->view('front/apply/close');
		$this->show_footer();
	}

	protected function flight_hour_show($row)
	{


		$levels = $this->Crud->get_all('aircraft_type',NULL,'aircraft','asc');
		$options = [];
		foreach($levels as $coutry){
			$options[$coutry['id']] = $coutry['aircraft'];
		}
		$data_list_id = 'aircraft_type';

		$select       = [];
		foreach(['aircaft_type'] as $column){

			$this->data['control'][$column.'[]'] = form_input(
				$this->inputarray->getArray(
					$column.'[]',null,lang($column),NULL,TRUE,['list'=>$data_list_id]
				));

		}
		$this->data['control']['data-list'] = $this->load->view('datalist',['name'=>$data_list_id,'list'=>$options],TRUE);


		foreach(['cdb_hours','opl_hours','total_hours'] as $column){

			$this->data['control'][$column.'[]'] = form_input(
				$this->inputarray->getArray(
					$column.'[]','number',lang($column),NULL,TRUE,['min'=>1]
				));

		}

		foreach(['last_flight'] as $column)
		{
			$date_picker = $this->inputarray->getArray($column.'[]','search',
				lang($column),NULL,TRUE,['data-calendar'=>true]);
			$this->data['control'][$column.'[]'] = form_input( $date_picker);
		}
		foreach(['company'] as $column){

			$this->data['control'][$column.'[]'] = form_input(
				$this->inputarray->getArray(
					$column.'[]',null,lang($column),NULL,TRUE
				));

		}

		if($row)
		{

			$this->data['data'] = [];
			foreach($row as $value)
			{
				$line = [];

				$line['aircaft_type[]'] = form_input(
					$this->inputarray->getArray('aircaft_type[]','text',lang('aircaft_type'),$value['aircaft_type'],TRUE
						,['list'=>$data_list_id]));
				$line['company[]'] = form_input(
					$this->inputarray->getArray('company[]','text',lang('company'),$value['company'],TRUE
					));
				$line['cdb_hours[]'] = form_input(
					$this->inputarray->getArray('cdb_hours[]','number',lang('cdb_hours'),$value['cdb_hours'],TRUE
						,['min'=>1]));
				$line['opl_hours[]'] = form_input(
					$this->inputarray->getArray('opl_hours[]','number',lang('opl_hours'),$value['opl_hours'],TRUE
						,['min'=>1]));
				$line['total_hours[]'] = form_input(
					$this->inputarray->getArray('total_hours[]','number',lang('total_hours'),$value['total_hours'],TRUE
						,['min'=>1]));


				$line['last_flight[]'] = form_input(
					$this->inputarray->getArray('last_flight[]','text',lang('last_flight'),date_to_input($value['last_flight']),TRUE,['data-calendar'=>true]
					));




				array_push($this->data['data'],$line);

			}
		}


		$this->load->view('front/apply/pnt/flight_hour',$this->data);
		$this->load->view('front/apply/js/calendar_js');



	}




}