<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// back / activity
class Ajax extends Shared_Controller{
	 
 


	private $_allowed = [1,2];
	private $_ajax;

	public function __construct(){
		parent::__construct($this->_allowed);
		$this->_redirect = base_url().Shared_Controller::$map.'/activity';
       
	}
    
	public function toogle(){
    

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
	

	
	public function typehead(){
			
		if(isset($_POST)){
			$arr = $this->Crud->clearArray($_POST,['query','table','column']);
			if($arr){
				$query = $this->Crud->get_like([$arr['column']=>$arr['query']],$arr['table']);
				$this->_result = array_map( function( $a ){ return $a['activity']; }, $query );
				echo json_encode($this->_result);
				return;
			}
		}
		echo json_encode(['error'=>TRUE]);	
	}
	
	public function functions_list($id){
		$app = $this->Crud->get_row(['id'=>$id],'application');
		$function = $this->Crud->get_all('functions',null,'function','asc');
		
		$func = $app ? $app['function_by_admin']: null;
		
		$result = "<select class='form-control change' 
		data-current-id='".$func."' d
		data-application-id='".$id."' >";
		$result .= "<option>".lang('pls_select_some_row')."</option>";
		foreach($function as $value){
			
			$selected =  ($value['id'] == $func) ? 'selected' : '';
			
			
			$result.= "<option   ".$selected."  value='".$value['id']."'>".$value['function']."</option>";
		}  
		$result.= "</select>";
		
		echo $result;
	}
	public function function_by_admin($id,$func_id){
		
		//tpdp 
		$app = $this->Crud->update(['id'=>$id],['function_by_admin'=>$func_id],'application');
		echo json_encode(['app'=>$app]);	
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
		if($query){
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
		if($query && $query[$column]){
			$this->_result['text'] = $query[$column];
			echo json_encode($this->_result);
			return;
		}
		echo json_encode(['error'=>TRUE]);	
	}

   /**
   * 
   * 
   * @param string  $id
   * 
   * @return
   */
   public function delete_app_by_id($id){
   	   $this->Crud->update(['id'=>$id],['deleted'=>1],'application');
   	   echo json_encode(['error'=>TRUE]);	
   }


}
