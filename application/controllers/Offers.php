<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offers extends CI_Controller{
	private $data = [];
	private $_user_id;
	private $_redirect;
	private $_table = 'offers';

	private $limit = 10;

	public function __construct(){
		parent::__construct('user/offers',['offer_list','offer_list','offer_list']);


	}

	public function index(){

		$this->show_header();



		$applications = NULL;
		if($this->ion_auth->logged_in()){
			$applications = [];
			/*   $this->show_user_menu();
			$applications = [];*/
			foreach($this->Crud->get_all('application',[
						'user_id'=>$this->ion_auth->user()->row()->id,'filled'=>1]) as $value){
				array_push($applications, $value['offer_id']);
			}
		}


		$this->load->view('front_asl/offer_list',[

				'category'=>$this->Crud->get_array("id","category","offers_category"),
				'offers'=>$this->make_html(),
				'applications'=>$applications,
				'logined'=>$this->ion_auth->logged_in()
			]);
		$this->show_footer();
	}


	public function type(){
		$this->ajax_json('application_contract','type','id');
	}
	public function location(){
		$this->ajax_json('offers_location','location','id');
	}
	public function category(){
		$this->ajax_json('offers_category','category','id');
	}
	public function activity(){
		$this->ajax_json('activities','activity','id',['published'=>1]);
	}

	public function ajax_result(){
		echo $this->make_html();


	}

	public function make_html(){
		$query = $this->query();



		$data  = "";
		foreach($query['data']  as $row){
			$data .= print_offer($row);
		}
		return $data.$this->make_pagination($query['count']);
	}

	public function make_pagination($arg){

		if(!empty($_SERVER['query_string'])){

		}else{
			$url = base_url().'/offers?page=';
		}
		//


		$string = '<div class="modal-header">';


		$this->load->library("pagination");
		$config["total_rows"] = $arg;
		$config["base_url"] = $url;
		$config["cur_page"] = isset($_GET['page']) ? $_GET['page'] : 0 ;
		$config['use_page_numbers'] = TRUE;
		$config["per_page"] = $this->limit;
      
        
		$config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tagl_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tagl_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item ">';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tagl_close'] = '</a></li>';
        $config['attributes'] = array('class' => 'page-link');
		$this->pagination->initialize($config);


		$data["links"] = $this->pagination->create_links();
		$string .= $data['links'];

		$string .= '</div><br>';

		return $string;
	}

	protected function query(){
		

		$where = [
			'offers.status'=>1,
			//""=>1232
		];

		if(isset($_GET)){
			foreach($_GET as $key=>$value){
				if(!empty($value)){

					if($key == 'page' | $key == 'lang'){

					}
					else
					if($key == 'activity'){
					$where['activities.id'] = $value;
					}else{
						$where['offers.'.$key] = $value;
					}
				}
			}
		}



       
		$start = isset($_GET['page']) && $_GET['page'] > 1 ? $_GET['page'] : 0;
    
		$offers= $this->Crud->get_joins_count(
			$this->_table,
			[
				"offers_location"=>"{$this->_table}.location=offers_location.id",
					'functions'=>"functions.id=$this->_table.function_id",
				'activities'=>"functions.activity_id=activities.id",
				//"offers_activities"=>"{$this->_table}.id=offers_activities.offer_id"
			],
			"{$this->_table}.*,offers_location.location as location,
			GROUP_CONCAT( activities.id  )  as aid",
			["{$this->_table}.pub_date"=>'desc'],"offers.id",$where,$this->limit,$start
		);



		return $offers;
	}


	/**
	*
	* @param string $table
	* @param string $value
	* @param string $id
	* @param array $where
	*
	* @return
	*/
	protected function ajax_json($table,$value,$id,$where = NULL){
		$_GET['q'] = isset($_GET['q']) ? $_GET['q'] : "";
		header('Content-Type: application/json');

		$result = [['text'=>"Clear",'value'=>""]] ;
		foreach($this->Crud->get_like([$value=>$_GET['q']],$table,$where) as $row){

			$result[] = ['text'=>$row[$value],'value'=>$row[$id]];
		}

		echo json_encode(array_values($result));
	}
}


