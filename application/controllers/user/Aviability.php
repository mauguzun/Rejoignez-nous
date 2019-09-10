<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aviability extends User_Controller
{
    private $data = [];
    private $_user_id;
    private $_redirect;
    private $_table = 'candidates';

    public function __construct()
    {
        parent::__construct('user/aviability');
        $this->_user_id = $this->ion_auth->user()->row()->id;
        $this->_redirect = base_url().User_Controller::$map.'aviability';
    }

    public function index()
    {

        $this->_set_form_validation();


        if ($this->form_validation->run() === TRUE) {


            $this->Crud->update(['user_id'=>$this->_user_id],
                [
                    'availability'=>date("Y-m-d", strtotime($_POST['availability']))
                ],$this->_table);
            $this->session->set_flashdata('message', lang('date_udpated'));
        }

        $this->data['message'] = (validation_errors() ? validation_errors() :
            ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        $this->_set_data(
            $this->Crud->get_row(["user_id"=>$this->_user_id],$this->_table) );



        $this->load->view('front/parts/add',$this->data);
      $this->show_footer();;

    }


    private function _set_form_validation()
    {
        $this->data['title'] = lang('edit_user');
        $this->data['url'] = $this->_redirect;
        $this->data['cancel'] = $this->_redirect;

        // user table
        $this->form_validation->set_rules('availability', lang('availability'), 'trim|required');


    }

    private function _set_data($user = NULL )
    {



        // aviability

        $month     = new DateTime('now');
        $month->add(new DateInterval('P1M'));
        $month     = $month->format('d/m/Y');

        $month_two = new DateTime('now');
        $month_two->add(new DateInterval('P2M'));
        $month_two = $month_two->format('d/m/Y');



        ////  append current date )
        $list      = [
            date('d/m/Y') => lang('Immédiate'),
            $month=>lang('Préavis 1 mois'),
            $month_two => lang('Préavis 2mois'),
            0=>lang('calendar'),
        ];

        $date      = NULL ;
        if (isset($user['availability'])) {
            $date = date("d/m/Y", strtotime($user['availability']));
            $list = [$date=>$date] + $list;
        }



        $this->data['control']["availability_l"] = form_label(lang("edit_user_availability"));
        $this->data['control']["availability"] = $this->load->view(
            'drop_calendar',[
                'name'=>'availability' ,
                'default'=>$date,
                'options'=>$list],TRUE);


    }
}


