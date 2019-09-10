<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// back / usser
class Settings_keywords extends Admin_Controller
{

    private $_fields ;

    public function __construct()
    {
        parent::__construct();
        $this->_redirect = base_url().Admin_Controller::$map.'/settings_keywords';
        
        $this->_fields = ['charset'=>'','time_zone'=>''];

    }

    public function index()
    {
        // $this->load->view('back / index');
        $this->show_header();
        $this->_set_form_validation($this->_redirect);



        if ($this->form_validation->run() === TRUE) {
            $this->json_model->save($_POST,KEYWORDS_JSON);
        }else {
            $this->session->set_flashdata('message', $this->form_validation->error_array());
        }

        $file = $this->json_model->load(KEYWORDS_JSON);
        $this->_set_data($file);
           $this->load->view(Admin_Controller::$map .'/parts/add_modal_fixed',$this->data);
        $this->load->view(Admin_Controller::$map.'/parts/footer');
    }











    private function _set_form_validation($url  )
    {
        $this->data['title'] = lang('settings_keywords');

        $this->data['url'] = $url;
        $this->data['buttons'] = [
            'create_and_publish'=>$url,
        ];
        $this->data['cancel'] = $this->_redirect;


        // $this->form_validation->set_rules('charset', lang('charset'), 'trim | required');
        $this->form_validation->set_rules('time_zone', lang('time_zone'), 'trim|required');
        $this->form_validation->set_rules('charset', lang('charset'), 'trim|required');
    }



    private function _set_data($user = NULL)
    {
        $this->load->library("html/InputArray");


        foreach ($this->_fields as $name=>$value) {


            if (isset($user[$name]))
            $value = $user[$name];



            if ($name == 'charset') {
                $this->data['control']["{$name}_l"] = form_label(lang($name));
                $this->data['control'][$name] = form_input(
                    $this->inputarray->getArray($name, $name == 'email' ? 'email' : 'text',lang($name),$value
                        ,FALSE));
            }else {


                $timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
                $options = [];
                foreach($timezones as $timezone){
					$options[$timezone] = $timezone;
				}
                $this->data['control']["time"] =   Date('Y-m-d h:i:s');
                $this->data['control']["{$name}_l"] = form_label(lang($name));
                $this->data['control'][$name] = form_dropdown($name, $options,$value,['class'=>'form-control']);
            }



        }


    }




}
