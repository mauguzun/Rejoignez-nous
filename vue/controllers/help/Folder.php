<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Folder extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->library('Uploadconfig');

        $directory = $this->uploadconfig->get();

        echo $directory['upload_path'];

        if (!is_dir($directory['upload_path'])) {
            echo  mkdir($directory['upload_path'], 0777, TRUE);
        }


      

        $this->load->library("Uploadlist");
        echo @mkdir ($this->uploadlist->site_img(), 0777, TRUE);
        echo @mkdir ($this->uploadlist->get_pricacy(), 0777, TRUE);

        foreach ($this->uploadlist->get_main() as $value) {
            if (!is_dir($directory['upload_path'].'/'.$value)) {
                echo @mkdir($directory['upload_path'].'/'.$value, 0777, TRUE);
            }
        }

        foreach ($this->uploadlist->get_pnc() as $value) {
            if (!is_dir($directory['upload_path'].'/'.$value)) {
                echo  mkdir($directory['upload_path'].'/'.$value, 0777, TRUE);
            }
        }
         foreach ($this->uploadlist->get_unsolocated() as $value) {
            if (!is_dir($directory['upload_path'].'/'.$value)) {
                echo  mkdir($directory['upload_path'].'/'.$value, 0777, TRUE);
            }
        }
        foreach ($this->uploadlist->get_pnt() as $value) {
            if (!is_dir($directory['upload_path'].'/'.$value)) {
                echo  mkdir($directory['upload_path'].'/'.$value, 0777, TRUE);
            }
        }
        foreach ($this->uploadlist->get_mechanic() as $value) {
            if (!is_dir($directory['upload_path'].'/'.$value)) {
                echo  mkdir($directory['upload_path'].'/'.$value, 0777, TRUE);
            }
        }

    }



}
