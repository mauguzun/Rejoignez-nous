<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// back / usser
class Email extends Admin_Controller
{
    private $data = [];
    private $_redirect ;
    private $_table = 'emails';

    private $_config = [];

    public function __construct()
    {
        parent::__construct();
        $this->_redirect = base_url().Admin_Controller::$map.'/email';
        $this->_ajax = base_url().Admin_Controller::$map.'/ajax';




    }

    public function index()
    {
        // $this->load->view('back / index');
        $this->show_header();



        $js = strip_tags( $this->load->view('js/data_edit_ajax',[
                    'selector'=>$this->_table,'url'=>$this->_ajax.'/toogle' ],TRUE));

        $this->load->view('back/parts/datatable',[
                'headers'=>['id','id','subject', 'activ_btn'],
                'title' =>lang('automatic_emails'),
                'url' => $this->_redirect.'/ajax',
                'add_button' => $this->_redirect.'/add',
                'js'=>$js,
                'order'=>'desc'
            ]);



        //$this->load->view('js / ajaxupload');

        $this->load->view('back/parts/footer');
    }

    public function add()
    {

        $this->_set_form_validation($this->_redirect.'/insert');
        $this->_set_data();

           $this->load->view(Admin_Controller::$map .'/parts/add_modal_fixed',$this->data);

    }


    public function update($id)
    {
        $this->_set_form_validation($this->_redirect.'/update');
        if ($this->form_validation->run() === TRUE) {

            $this->Crud->update(['id'=>$id],$_POST,$this->_table);
            echo json_encode(['done'=>true]);
            return;

        }
        echo json_encode(['error'=>$this->form_validation->error_array()]);
    }

    public function edit($user_id = NULL)
    {

        $row = $this->Crud->get_row(['id'=>$user_id],$this->_table);

        $this->_set_form_validation($this->_redirect.'/update/'.$user_id);
        $this->_set_data($row);


        if ($user_id && $user_id > 0) {
               $this->load->view(Admin_Controller::$map .'/parts/add_modal_fixed',$this->data);
        }
    }




    public function insert()
    {

        $this->_set_form_validation($this->_redirect.'/insert');



        if ($this->form_validation->run() === TRUE) {
            $this->Crud->add($_POST,$this->_table);

            echo json_encode(['done'=>true]);
            return;
        }

        echo json_encode(['error'=>$this->form_validation->error_array()]);

    }

    public function trash($user_id = NULL)
    {
        if ($user_id && $user_id > 0) {
            $this->Crud->delete(['id'=>$user_id],$this->_table);
            $this->session->set_flashdata('message', lang('deleted_success'));
        }
        redirect($this->_redirect);
    }


    private function _set_form_validation($url  )
    {
        $this->data['title'] = lang('create_offer');

        $this->data['url'] = $url;

        $this->data['buttons'] = [

            'create'=>$url,
        ];
        $this->data['cancel'] = $this->_redirect;

        $this->data['cancel'] = $this->_redirect;
        $this->form_validation->set_rules('subject', lang('subject'), 'trim|required');
        $this->form_validation->set_rules('content', lang('content'), 'trim|required');
    }



    private function _set_data($user = NULL)
    {
        $this->load->library("html/InputArray");

        $this->data['control']['subject_l'] = form_label(lang("subject"));
        $this->data['control']['subject'] =
        form_input( $this->inputarray->getArray('subject','text',
                lang('create_user_fname_label'),isset($user['subject'])?$user['subject']:NULL,TRUE));

		
		 foreach (['content'] as $column) {

            $this->data['control']["{$column}_l"] = form_label(lang($column));

            $selected = ($user) ? $user[$column]: NULL;
            $this->data['control'][$column] = form_textarea(
                $this->inputarray->getArray($column,null,lang($column),$selected
                ));
        }

    }


    public function ajax()
    {

        $query = $this->Crud->get_all($this->_table,NULL,'id','asc');

        $data['data'] = [];



        foreach ($query as $table_row) {
            $row = [];

            array_push(
                $row,
                (int)$table_row['id'],
                (int)$table_row['id'],
                $table_row['subject'],
                $this->load->view("buttons/edit",['url'=>$this->_redirect.'/edit/'.$table_row['id']],true).
                $this->load->view("buttons/trash",['url'=>$this->_redirect.'/trash/'.$table_row['id']],true)

            );
            array_push($data['data'],$row);
        }


        echo json_encode($data);
    }

}
