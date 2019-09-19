<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('date_to_db')) {
    function date_to_db($date)
    {

        try {
            $date = trim($date);
            @$value= date_format(date_create_from_format('d/m/Y', $date), 'Y-m-d');
            return $value;

        } catch (Exception $e) {
            return NULL;
        }

    }
}

if ( ! function_exists('date_to_input')) {
    function date_to_input($date)
    {

        try {
            $date = trim($date);
            @$value= date_format(date_create_from_format('Y-m-d', $date), 'd/m/Y');
            return $value;

        } catch (Exception $e) {
            return NULL;
        }


    }
}

if ( ! function_exists('time_stamp_to_date')) {
    function time_stamp_to_date($date)
    {
        /* if (! $date instanceof DateTime) {
        var_dump($date);
        die();
        }*/
        $date = trim($date);
        return date_format(date_create_from_format('Y-m-d H:i:s', $date), 'd/m/Y');
    }
}

if ( ! function_exists('img_div_new')) {
    function img_div_new($file,$file_id,$name = '')
    {

        $img = $file;
        if (@!is_array(getimagesize($file))) {
            $img = file_cover();
        }

        return  "<div data-img-url='".$file."' class='edit'>".
        '<div class="title">'.$name.'</div>'.
        "<img src='".$img."' />".
        "<a href='#'  id='".$file_id."' class='trash'><i 
         class='fas fa-trash'
         
         ></i></a>
        <a download  href='".base_url().'user/getfile?url='.$file."'><i  class='fas fa-download'></i></a></div>";

    }
}


if ( ! function_exists('file_cover')) {
    function file_cover()
    {
        return 'https://www.shareicon.net/data/128x128/2015/08/03/79466_file_512x512.png';
    }
}



if ( ! function_exists('print_offer')) {
    function print_offer($data)
    {
        return ' <div style="cursor: pointer;" 
        onclick="location.replace(\''. base_url().'offer/'.$data['id'] .'\');" class="custom_offer_bg" >
        <h5 class="job_app_head">
        '.$data['title'].'
        </h5>
        <div class="row" >
        <div class="col-md-3">
        <p class="sub-string" style="margin-top:10px;">
        <i class="fas fa-pencil-alt">
        </i>
        '.$data['start_date'].'

        </p>
        </div>
        <div class="col-md-9">
        <p class="sub-string" style="margin-top:10px;">
        <i class="fas fa-search-location">
        </i>
        '.$data['location'].'
        </p>
        </div>

        </div>
        </div>
        ';
    }
}



