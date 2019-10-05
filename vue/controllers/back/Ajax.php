<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// back / activity
class Ajax extends Admin_Controller
{
	private $_result;
   
    public function __construct()
    {
        parent::__construct();
       	
       	if (!$this->ion_auth->is_admin()){
			show_error('please login',401,'please login');
		}
		$this->_result = [];
		
    }
    
    public function toogle()
    {
    

		if(isset($_POST)){
			
			$this->load->library('html/toogle');
			
			$toogle = $this->toogle->init(0,$_POST['column'],$_POST['table'])->set_text(lang('pub_toogle'))->set_flag($_POST['value']);
			$toogle->set_toogle();

			$this->Crud->update(['id'=>$_POST['id']],[$_POST['column']=>$toogle->get_value()],$_POST['table']);
			
			$this->_result['text'] = $toogle->get_text();
			$this->_result['value'] = $toogle->get_value();
			$this->_result['class'] = $toogle->get_class();
			echo json_encode($this->_result);
			return;
		}
		echo json_encode(['error'=>TRUE]);

	}
	

	
	public function typehead()
	{
			
		if(isset($_POST)){
			$arr = $this->Crud->clearArray($_POST,['query','table','column']);
			if ($arr){
				$query = $this->Crud->get_like([$arr['column']=>$arr['query']],$arr['table']);
				$this->_result = array_map( function( $a ) { return $a['activity']; }, $query );
				echo json_encode($this->_result);
				return;
			}
		}
		echo json_encode(['error'=>TRUE]);	
	}
	
	
	

	
	public function user_modal($table,$column,$id,$selector="id"){	
			$user_id = $this->ion_auth->user()->row()->id;
			$this->_show_modal(['user_id'=>$user_id,$selector=>$id],$table,$column);
	}
	
	public function  modal($table,$column,$id,$selector="id"){
			
			$this->_show_modal([$selector=>$id],$table,$column);
		
	}
	
	public function copy($id = NULL){
		 $user_id = $this->ion_auth->user()->row()->id;
		 $query   = $this->Crud->get_joins(
                'offers',
                [
                    'application_contract'=>"offers.type=application_contract.id",
                    'offers_location'=>"offers.location=offers_location.id",
                    'offers_category'=>"offers.category=offers_category.id",
                    'offers_mission'=>"offers.mission=offers_mission.offer_id and  offers_mission.user_id = {$user_id}",
                    'offers_profile'=>"offers.profile=offers_profile.offer_id and  offers_profile.user_id = {$user_id}",
                    'offers_overview'=>"offers.overview=offers_overview.offer_id and  offers_overview.user_id = {$user_id}",
                ],
                'offers.*,offers_overview.overview as overview,
                offers_location.location as location,offers_category.category as category,
                ,application_contract.type as type,
                offers_profile.profile as profile,offers_mission.mission as mission
                ',null,null,["offers.id"=>$id]


            );
            if ($query){
            	$this->_result['text'] = '';
				foreach($query[0] as $key => $value){
					$this->_result['text'] .= strip_tags($key.':'.$value) ."\r\n";
				}
				echo json_encode($this->_result);
				return; 
			}
            
           echo json_encode(['error'=>TRUE]);	
	}
	
	
	private function _show_modal($where,$table,$column){
			$query = $this->Crud->get_row($where,$table);
			if ($query && $query[$column]){
				$this->_result['text'] = $query[$column];
				echo json_encode($this->_result);
				return;
			}
			echo json_encode(['error'=>TRUE]);	
	}

   


}
