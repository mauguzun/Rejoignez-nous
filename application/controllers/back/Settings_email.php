<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// back / usser
class Settings_email extends Admin_Controller
{

    private $_fields ;

    public function __construct()
    {
        parent::__construct();
        $this->_redirect = base_url().Admin_Controller::$map.'/settings_email';
        $this->load->library("Json_model");

        $this->_fields = ['email'=>'','sender'=>'','transport'=>'smtp','host'=>'','user'=>'','password'=>'','port'=>''];

    }

    public function index()
    {
        // $this->load->view('back / index');
        $this->show_header();
        $this->_set_form_validation($this->_redirect);



        if ($this->form_validation->run() === TRUE) {
            $this->json_model->save($_POST,EMAIL_JSON);
        }else {
            $this->session->set_flashdata('message', $this->form_validation->error_array());
        }

        $file = $this->json_model->load(EMAIL_JSON);
        $this->_set_data($file);
           $this->load->view(Admin_Controller::$map .'/parts/add_modal_fixed',$this->data);
        $this->load->view(Admin_Controller::$map.'/parts/footer');
    }











    private function _set_form_validation($url  )
    {
        $this->data['title'] = lang('email_configuration');

        $this->data['url'] = $url;
        $this->data['buttons'] = [
            'create_and_publish'=>$url,
        ];
        $this->data['cancel'] = $this->_redirect;


        $this->form_validation->set_rules('email', lang('email'), 'trim|required|valid_email');
        $this->form_validation->set_rules('password', lang('password'), 'trim|required');
    }



    private function _set_data($user = NULL)
    {
        $this->load->library("html/InputArray");


        foreach ($this->_fields as $name=>$value) {


            if (isset($user[$name]))
            $value = $user[$name];





            $this->data['control']["{$name}_l"] = form_label(lang($name));
            $this->data['control'][$name] = form_input(
                $this->inputarray->getArray($name, $name == 'email' ? 'email' : 'text',lang($name),$value
                    ,FALSE));  

        }


    }




}
