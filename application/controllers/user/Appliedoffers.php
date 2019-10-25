<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appliedoffers extends User_Controller{

	private $_table = 'application';

	public function __construct(){
		parent::__construct('user/offers',['unsolicited_application'],true);
		$this->_user_id = $this->ion_auth->user()->row()->id;
		$this->load->library("Folderoffer");
	}

	public function index( ){
		
		$this->show_header(['unsolicited_application']);
		
		
		// todo is active
		$application = $this->Crud->get_joins(
			$this->_table,
			[
				"offers"=>"offers.id = $this->_table.offer_id",
				"application_contract"=>" offers.type=application_contract.id ",
				"offers_location"=>"offers.location = offers_location.id",
				"offers_category"=>"offers.category = offers_category.id",

				'offers_activities'=>"offers.id = offers_activities.offer_id",
				'activities'=>"offers_activities.activiti_id = activities.id",
				"application_un"=>"$this->_table.id = application_un.application_id",
				"application_un_activity"=>'application_un.application_id =application_un_activity.application_id'


			],


			"$this->_table.*, $this->_table.id as aid  ,offers.pub_date as date ,offers.id as id ,$this->_table.user_id as uid ,
			offers.title as title,
			offers_location.location as location ,
			application_contract.type as contract,
			application_un.contract_id as app_un_contract_type,
			application_un.function as app_un_function,
			offers.category  as category,
			GROUP_CONCAT(DISTINCT activities.activity ) as activity,
			GROUP_CONCAT(DISTINCT application_un_activity.activity ) as app_un_contract_activities,
			",
			["offers.pub_date"=>'desc'],["$this->_table.id"],["{$this->_table}.user_id" => $this->_user_id  ,
				"{$this->_table}.deleted"=>0 , "$this->_table.filled"=> 1]
		);


		
		if(!$application){
			redirect(base_url().'user/profile');
		}



		foreach($this->Crud->get_all('application_contract') as $value){
			$all_contract[$value['id']] = $value['type'];
		}

		

		foreach($application as & $value){
			
			$value['add_date'] = time_stamp_to_date($value['add_date']);
			if($value['unsolicated'] == 0){
				$value['title'] =
				anchor(base_url().'/apply/new/'.$this->folderoffer->get_map($value['category']).'/index/'.$value['id'],$value['title']);

			}
			else{
				
				
				
				switch($value['unsolicated_type']){
					case '2':
					$value['title'] = anchor("apply/new/uns_pnt/index/".$value['aid'],
						lang('unsolicited_application_applys'));
					break;
					
					case '3':
					$value['title'] = anchor("apply/new/uns_pnc/index/".$value['aid'],
						lang('unsolicited_application_applys'));
					break;
					
					default:
					$value['title'] = anchor("apply/new/unsolicated/index/".$value['aid'],$value['app_un_function']);
					
					if (array_key_exists($value['app_un_contract_type'],$all_contract))
					$value['contract'] = $all_contract[$value['app_un_contract_type']];	
					
					$value['activity'] = $value['app_un_contract_activities'];
				}
			
				
				
			
			}

		}
		
		
	

		$table = $this->load->view('front/parts/page_table',[
				'headers'=>['add_date','title','location','contract','activity'],
				/*				'headers'=>['add_date','title','location','contract','activity'],
				*/				'query'=>$application,'title'=>lang('applied_offers')]);
		// redirect( base_url().User_Controller::$map.'/offers');

		$this->show_footer();
	}



}


