<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// back / activity
class History extends Shared_Controller
{
    private $data = [];
    private $_redirect ;

    private $_table = 'application';
    private $_ajax ;

    private $_allowed = [1,2,3,4,5,6,7];

    public function __construct()
    {
        parent::__construct($this->_allowed);
        $this->_redirect = base_url().Shared_Controller::$map.'/history';
        $this->_ajax = base_url().'access/Pnt_Pnc_Hr_Admin';
        	$this->load->library(["Colors","Folderoffer","Uploadconfig","Uploadlist"]);
    }


    public function index($user_id =NULL )
    {


		if (!$user_id)
		redirect( base_url());

        $this->show_header();



        $this->load->view('back/parts/datatable',[
                'headers'=>['id','date','title','type','duration','overview'],
                'title' =>lang('user_history'),
                'url' => $this->_redirect.'/ajax/'.$user_id,
                'order_by'=>1,
                'js'=>null,
            ]);

		

        $this->load->view('back/parts/footer');


    }

    public function show($id = NULL )
    {
    	
        if ($id ) {
            
            $user_groups = $this->ion_auth->get_users_groups( $this->ion_auth->user()->row()->id )->result();
            foreach ($user_groups as $value) {
                $current_user_group = (int)$value->id;
            }
        }
        
        $can_show = FALSE;
        if (!$this->ion_auth->is_admin()){
			
			 $for_this_groups =  $this->Crud->get_all('offers_groups',['offer_id'=>$id],null,'groups');
       		 $allowed_groups = array_map(function($a){return $a['group_id'] ;},$for_this_groups);
       		 $can_show = in_array($current_user_group,$allowed_groups);
		}else{
			$can_show = TRUE;
		}
		
		$this->show_header();
		$this->load->view('back/parts/show',['data'=>($can_show)? 
			$this->Crud->get_row(['id'=>$id],$this->_table)['overview']
		    :  lang('cant_view')]);
        
        $this->load->view('back/parts/footer');
        
       
        
        
    }


  


   
    public function ajax($user_id)
    {



        $query = $this->Crud->get_joins(
            $this->_table,
            [
                'offers'=>"$this->_table.offer_id=offers.id",
                'application_contract'=>"offers.type=application_contract.id",
                'offers_location'=>"offers.location=offers_location.id",
                'offers_category'=>"offers.category=offers_category.id"
            ],
            "$this->_table.*,$this->_table.id as aid, offers.id as oid,offers.*,application_contract.type as type",NULL,
            "$this->_table.id",
            ["$this->_table.user_id"=> $user_id]


        );
       

        /* echo "<pre>";
        var_dump($query);
        die();
        */

        $data['data'] = [];


        foreach ($query as $table_row) {
            $row = [];
            
            if($table_row['unsolicated'] == 1){
				$print          = base_url().'apply/unsolicited/printme/index/1'.$table_row['aid'];
				$title          = lang('unsolicited_application_applys');
			}
			else
			if($table_row['manualy'] == 1){
				$title = $table_row['title']." <br> <b>".lang('manual')."</b>";
				$print = base_url().Shared_Controller::$map.'/printmanualoffer/index/'.$table_row['aid'];
			}
			else
			{
				
				$print   = base_url().'/apply/'.$this->folderoffer->get_map($table_row['category']).'/printme/index/2/'.$table_row['aid'];
				$title = anchor(base_url().Shared_Controller::$map.'/applications?offer='. $table_row['title'],   $table_row['title'] ,['target'=>'_blank'] );
			}

            array_push(
                $row,
                $table_row['pub_date'],
                date_to_input($table_row['pub_date']) ,
                $title,
                $table_row['type'],
                $table_row['period']. " month ",
                
                $this->load->view('buttons/dynamic',
                    [
                        'class'=>'fas fa-search',
                        'url'=>$this->_redirect.'/show/'.$table_row['id']]

                    ,TRUE)
            );
            array_push($data['data'],$row);
        }


        echo json_encode($data);
    }
}
