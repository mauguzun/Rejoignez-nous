<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// back / activity
class Online extends Shared_Controller
{
    private $data = [];
    private $_redirect ;

    private $_table = 'offers';
    private $_ajax ;

    private $_allowed = [1,2,3,4,5,6,7];

    public function __construct()
    {
        parent::__construct($this->_allowed);
        $this->_redirect = base_url().Shared_Controller::$map.'/online';
        $this->_ajax = base_url().'access/Pnt_Pnc_Hr_Admin';
    }


    public function index()
    {

        $this->show_header();





        $this->load->view('back/parts/datatable',[
                'headers'=>['id','date','title','type','category','duration','overview'],
                'title' =>lang('offer_online'),
                'url' => $this->_redirect.'/ajax',
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


  


   
    public function ajax()
    {

		
		$category = $this->get_group_category();
		if($category == NULL)
		{
			$allowed = NULL ;
		}
		else if(is_array($category))
		{
			$allowed = "offers.category = 1 or offers.category = 4 and offers.status =1  ";
		}
		else
		{
			$allowed = ['offers.category'=>$category];
		}
		
		if(!is_array($category))
		$allowed['status']  = 1;

        $query = $this->Crud->get_joins(
            $this->_table,
            [
                'application_contract'=>"{$this->_table}.type=application_contract.id",
                'offers_location'=>"{$this->_table}.location=offers_location.id",
                'offers_category'=>"{$this->_table}.category=offers_category.id",
            ],
            'offers.id as id,offers.*,application_contract.type as type,offers_category.category  as cat',NULL,
            'id',
            $allowed


        );

        /* echo "<pre>";
        var_dump($query);
        die();
        */

        $data['data'] = [];


        foreach ($query as $table_row) {
            $row = [];

            array_push(
                $row,
                $table_row['pub_date'],
                date_to_input($table_row['pub_date']) ,
                anchor( base_url().Shared_Controller::$map."/applications?offer=".$table_row['title'], $table_row['title']),
                $table_row['type'],
                $table_row['cat'],
                $table_row['period'],
       
                anchor( base_url().User_Controller::$map."/offer/".$table_row['id'] ,' <i class="fas fa-search"></i>',['target'=>"_blank"])

            );
            array_push($data['data'],$row);
        }


        echo json_encode($data);
    }
}
