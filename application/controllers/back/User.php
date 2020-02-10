<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// back / usser
class User extends Admin_Controller
{
    private $data = [];
    private $_redirect ;
    private $_table = 'activities';

    public function __construct()
    {
        parent::__construct();
        $this->_redirect = base_url().Admin_Controller::$map.'/user';
        $this->_ajax = base_url().Admin_Controller::$map.'/ajax';
    }

    public function index()
    {
        // $this->load->view('back / index');
        $this->show_header();
       


        $js     = strip_tags( $this->load->view('js/data_edit_ajax',[
                    'selector'=>$this->_table,'url'=>$this->_ajax.'/toogle' ],TRUE));


$js .= strip_tags($this->load->view('js/modal',NULL,TRUE) );
        $this->load->view('back/parts/datatable',[
                'headers'=>['id','name_lastname','email','group','activ_btn'],
                'title' =>lang('user_manage'),
                'url' => $this->_redirect.'/ajax',
                'add_button' => $this->_redirect.'/add',
                'js'=>$js,
                'order'=>'asc'
            ]);





        $this->load->view('back/parts/footer');
    }

    public function add()
    {
        // $this->show_header();
        $this->_set_form_validation($this->_redirect.'/insert');
        $this->_set_form_validation_password();
        $this->_set_data();


           $this->load->view(Admin_Controller::$map .'/parts/add_modal_fixed',$this->data);

    }
    public function insert()
    {

        $this->_set_form_validation($this->_redirect.'/insert');
        $this->_set_form_validation_password();
        if ($this->form_validation->run() === TRUE) {

            $identity        = $email           = strtolower($this->input->post('email'));
            $password        = $this->input->post('password');



            $id              = $this->ion_auth->register($identity, $password, $email);

            $additional_data = array(
                'user_id'   =>$id,
                'first_name'=> $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'));

            $cand = $this->Crud->add($additional_data,'candidates');

            if ($id ) {
                // registred set active and change group ppls
                $this->Crud->update(['id'=>$id],['active'=>1],'users');
                $this->Crud->update(['user_id'=>$id],['group_id'=>$_POST['users_groups']],'users_groups');

                echo json_encode(['done'=>true]);
                return;

            }
        }
        echo json_encode(['error'=>$this->form_validation->error_array()]);

    }


    public function edit($user_id = NULL)
    {
        // $this->show_header();
        $this->_set_form_validation($this->_redirect.'/update');



        if ( isset($_POST['email'])) {

            if ($this->input->post('password'))
            $this->_set_form_validation_password();


            if ($this->form_validation->run() === TRUE) {

                $this->ion_auth->update($_POST['id'],$_POST);
                $this->Crud->update(['user_id'=>$_POST['id']],['group_id'=>$_POST['users_groups']], 'users_groups');
                $this->session->set_flashdata('message',  lang('udpated'));

            }else {
                $this->data['message'] = (validation_errors() ? validation_errors() :
                    ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            }
        }



        if ($user_id && $user_id > 0) {
            $user = $this->Crud->get_joins(
                'users',[
                    'users_groups'=>'users.id=users_groups.user_id',
                    'groups'=>'users_groups.group_id=groups.id',
                    'candidates'=>'candidates.user_id = users.id',
                ],' users.id as uid, users.email as email,groups.id as group_id , groups.description as description ,candidates.* ',

                ['users.first_name','ASC'] ,NULL ,['users.id'=>$user_id]);

            if ($user) {
                $this->_set_data($user[0]);
                   $this->load->view(Admin_Controller::$map .'/parts/add_modal_fixed',$this->data);
            }
        }
    }
    public function update()
    {
        $this->_set_form_validation($this->_redirect.'/update');



        //  check email
        if ($_POST['email'] != $this->ion_auth->user($_POST['id'])->row()->email) {
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'),
                'trim|required|valid_email|is_unique[users.email]');
        }else {
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'),
                'trim|required|valid_email');
        }




        if ( trim( $this->input->post('password'))!= "" )
        $this->_set_form_validation_password();


        if ($this->form_validation->run() === TRUE) {

            $this->ion_auth->update($_POST['id'],$_POST);
            $this->Crud->update(['user_id'=>$_POST['id']],['group_id'=>$_POST['users_groups']], 'users_groups');
            
             $additional_data = [  'first_name'=> $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),'user_id'=>$_POST['id']];
               
              

            $cand = $this->Crud->update_or_insert($additional_data,'candidates');
            
            echo json_encode(['done'=>true]);
            return;
        }
        echo json_encode(['error'=>$this->form_validation->error_array()]);
    }

    public function trash($user_id = NULL)
    {
        if ($user_id && $user_id > 0) {

            //todo if user super Admin
            $this->Crud->delete(['id'=>$user_id],'users');
            $this->Crud->delete(['user_id'=>$user_id],'users_groups');
            $this->Crud->delete(['user_id'=>$user_id],'candidates');

            // $this->session->set_flashdata('message', 'Users deleted line 152');
        }
        redirect($this->_redirect);
    }


    private function _set_form_validation($url  )
    {
        $this->data['title'] = $this->lang->line('create_user_heading');

        $this->data['url'] = $url;
        $this->data['buttons'] = [

            'create_and_publish'=>$url,

        ];

        $this->data['cancel'] = $this->_redirect;

        $tables          = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;


        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'trim|required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'trim|required');


        $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email|is_unique[' . $tables['users'] . '.email]');


    }

    private function _set_form_validation_password()
    {
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

    }

    private function _set_data($user = NULL)
    {
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


        $this->load->library("html/InputArray");

        if ($user['uid']) {
            $this->data['control']['uid'] = form_input( $this->inputarray->getArray('id','hidden',null,$user['uid'],TRUE));
        }

        $first_name = ($user)? $user['first_name'] : $this->form_validation->set_value('first_name');

        $this->data['control']['first_name'] =
        form_input( $this->inputarray->getArray('first_name','text',
                lang('create_user_fname_label'),$first_name,TRUE));

        $last_name = ($user)? $user['last_name'] : $this->form_validation->set_value('last_name');

        $this->data['control']['last_name'] =
        form_input( $this->inputarray->getArray('last_name','text',
                lang('create_user_lname_label'),$last_name,TRUE));

        $email = ($user)? $user['email'] : $this->form_validation->set_value('email');
        $this->data['control']['email'] =
        form_input( $this->inputarray->getArray('email','email',
                lang('create_user_email_label'),$email,TRUE));


        foreach ($this->Crud->get_all('groups',null,'id','asc') as $value) {
            $options[$value['id']] = $value['description'];
        }

        $selected = ($user)?$user['group_id']:null;

        $this->data['control']['users_groups'] =
        form_dropdown('users_groups', $options,$selected,['class'=>'form-control']);


        $this->data['control']['password'] =
        form_input( $this->inputarray->getArray('password','password',
                lang('create_user_password_label'),$this->form_validation->set_value('password')));


        $this->data['control']['password_confirm'] =
        form_input( $this->inputarray->getArray('password_confirm','password',
                lang('create_user_password_confirm_label'),$this->form_validation->set_value('password_confirm')));



    }


    public function ajax()
    {

        $query = $this->Crud->get_joins(
            'users',[
                'users_groups'=>'users.id=users_groups.user_id',
                'candidates'=>'candidates.user_id = users.id',
                'groups'=>'users_groups.group_id=groups.id',],
            ' users.id as uid, users.email as email, groups.description as description ,candidates.* ',
            ['candidates.first_name','ASC']);

     
        $data['data'] = [];
        foreach ($query as $table_row) {
            $row = [];

            array_push(
                $row,

                $table_row['first_name'],
                $table_row['first_name'].' '.$table_row['last_name'],
                $table_row['email'],
                $table_row['description'],
                $this->load->view("buttons/edit",['url'=>$this->_redirect.'/edit/'.$table_row['uid']],true).
                $this->load->view("buttons/trash",['url'=>$this->_redirect.'/trash/'.$table_row['uid']],true)


            );
            array_push($data['data'],$row);
        }
		
		


        echo json_encode($data);

    }

}
