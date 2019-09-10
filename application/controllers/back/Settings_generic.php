<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// back / usser
class Settings_generic extends Admin_Controller
{

    private $_fields ;

    public function __construct()
    {
        parent::__construct();
        $this->_redirect = base_url().Admin_Controller::$map.'/settings_generic';
        $this->load->library("Json_model");

        $this->_fields = ['title'=>'','description'=>'','keywords'=>'','logo'=>''];
        $this->_ajax = base_url().Admin_Controller::$map.'/ajax';


        $this->load->library("Uploadlist");

        $this->_config['upload_path'] = $this->uploadlist->site_img();
        $this->_config['allowed_types'] = 'jpg|gif|png';
        $this->_config['max_size'] = 5000;


    }

    public function index()
    {
        // $this->load->view('back / index');
        $this->show_header();
        $this->_set_form_validation($this->_redirect);



        if ($this->form_validation->run() === TRUE) {
        	foreach($_POST as &$value)
        		$value = strip_tags($value);
        		
            $this->json_model->save($_POST,GENERIC_JSON);
            redirect($this->_redirect);
            
        }else {
            $this->session->set_flashdata('message', $this->form_validation->error_array());
        }

        $user = $this->json_model->load(GENERIC_JSON);

        $this->_set_data($user);
        $this->load->view('js/ajaxupload');


        $this->data['required'] = ['logo'];
        foreach ($this->data['required'] as $value) {
            $uploader['upload_id'] = $value;
            $uploader['upload_url'] = $this->_redirect.'/upload';
            $uploader['input_selector'] = "#logo";
            $uploader['default_file'] = (isset($user[$value]))?
            base_url().$this->uploadlist->site_img().'/'.$user[$value]:NULL;

            $this->data['control']["X.$value"] = form_label(lang($value));
            $this->data['control']["X".$value] = $this->load->view('back/parts/uploader',$uploader,TRUE);
        }


        $this->load->view(Admin_Controller::$map .'/parts/add_with_upload',$this->data);
        $this->load->view(Admin_Controller::$map.'/parts/footer');
    }

    public function upload()
    {



        $this->load->library('upload', $this->_config);

        if ( ! $this->upload->do_upload('file')) {
            $this->session->set_flashdata('message', $this->upload->display_errors());
            $this->data['message'] = $this->upload->display_errors();

            echo json_encode(['error'=>$this->upload->display_errors().lang('allowed_filetype').$this->_config['allowed_types']]);
            return ;

        }
        else {
            $upload_data = [ 'upload_data'=> $this->upload->data()];
            echo json_encode([
                    'url'=>base_url().$this->uploadlist->site_img().'/'.$upload_data['upload_data']['file_name'],
                    'done'=>$upload_data['upload_data']['file_name']
                ]);
        }

    }









    private function _set_form_validation($url  )
    {
        $this->data['title'] = lang('settings_generic');

        $this->data['url'] = $url;
        $this->data['buttons'] = [
            'create_and_publish'=>$url,
        ];
        $this->data['cancel'] = $this->_redirect;


        $this->form_validation->set_rules('title', lang('title'), 'trim|required');
        $this->form_validation->set_rules('logo', lang('logo'), 'trim|required');
    }



    private function _set_data($user = NULL)
    {
        $this->load->library("html/InputArray");


        foreach ($this->_fields as $name=>$value) {


            if (isset($user[$name]))
            $value = $user[$name];




            if ($name == 'logo') {
                $this->data['control'][$name] = form_input(
                    $this->inputarray->getArray($name, 'hidden',lang($name),$value
                        ,FALSE));
            }
            else
            if ($name == 'description' | $name == 'keywords') {

                $this->data['control']["{$name}_l"] = form_label(lang($name));



                $this->data['control'][$name] = form_textarea(
                    $this->inputarray->getArray($name, $name == 'email' ? 'email' : 'text',lang($name),$value
                        ,FALSE));
            }
            else {

                $this->data['control']["{$name}_l"] = form_label(lang($name));


                $this->data['control'][$name] = form_input(
                    $this->inputarray->getArray($name, $name == 'email' ? 'email' : 'text',lang($name),$value
                        ,TRUE));
            }


        }


    }




}
