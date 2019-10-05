<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// back / activity
class Viewoffers extends Shared_Controller
{
    private $data = [];
    private $_redirect ;

    private $_table = 'offers';
    private $_ajax ;
  
    private $_allowed = [1,2,3,4,5,6,7];

    public function __construct()
    {
        parent::__construct($this->_allowed);
        $this->_redirect = base_url().Shared_Controller::$map.'/viewoffers';
        $this->_ajax = base_url().'access/All_Admins';
        
        if($this->ion_auth->in_group([1,2])){
			redirect(base_url().'shared/offer');
		}
    }


    public function index()
    {

        $this->show_header();


       

        $js = strip_tags($this->load->view('js/modal',NULL,TRUE) );
    
      

        $this->load->view('back/parts/datatable',[
                'headers'=>['id','date','title','type','duration','overview','status'],
                'title' =>lang('offer_manager'),
                'url' => $this->_redirect.'/ajax',
                'add_button' => $this->_redirect.'/add',
                'order_by'=>1,
                'js'=>$js
            ]);



        $this->load->view('back/parts/footer');


    }

   

    public function ajax()
    {

        $allowed     = [1,2,3,4,5,6,7];
     

        $query = $this->Crud->get_joins_where_in(
            $this->_table,
            [
                'application_contract'=>"{$this->_table}.type=application_contract.id",
                'offers_location'=>"{$this->_table}.location=offers_location.id",
                'offers_category'=>"{$this->_table}.category=offers_category.id",
                'offers_groups'=>"{$this->_table}.id=offers_groups.offer_id",
            ],
            'offers.*,application_contract.type as type',NULL,"{$this->_table}.id","offers_groups.group_id",$allowed


        );

        /* echo "<pre>";
        var_dump($query);
        die();
        */

        $data['data'] = [];

        $this->load->library('html/toogle');

        $toog = $this->toogle->init(0,'status','offers',$this->_table)->set_text(lang('pub_toogle'));

        foreach ($query as $table_row) {
            $row = [];

            array_push(
                $row,

                (int)$table_row['id'],
                date_to_input($table_row['pub_date']),
                anchor( base_url().Shared_Controller::$map."/application/".$table_row['id'], $table_row['title']),
                $table_row['type'],
                $table_row['period'] ,
                $this->load->view("buttons/magnify",
                    ['url'=>$this->_ajax.'/modal/offers/overview/'.$table_row['id'].'/id'],true),

                $toog->set_flag($table_row['status'])->get($table_row['id']),
                $this->load->view("buttons/copy",['url'=>$this->_ajax.'/copy/'.$table_row['id']],true)

            );
            array_push($data['data'],$row);
        }


        echo json_encode($data);
    }
}
