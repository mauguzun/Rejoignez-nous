<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

if( ! function_exists('date_to_db')){
	function date_to_db($date){

		try{
			$date = trim($date);
			@$value= date_format(date_create_from_format('d/m/Y', $date), 'Y-m-d');
			return $value;

		} catch(Exception $e){
			return NULL;
		}

	}
}

if( ! function_exists('date_to_input')){
	function date_to_input($date){
		
		if ($date == '0000-00-00'){
			return NULL;
		}
		try{
			$date = trim($date);
			@$value= date_format(date_create_from_format('Y-m-d', $date), 'd/m/Y');
			return $value;

		} catch(Exception $e){
			return NULL;
		}


	}
}

if( ! function_exists('time_stamp_to_date')){
	function time_stamp_to_date($date){
		/* if (! $date instanceof DateTime) {
		var_dump($date);
		die();
		}*/
		$date = trim($date);
		return date_format(date_create_from_format('Y-m-d H:i:s', $date), 'd/m/Y');
	}
}

if( ! function_exists('img_div_new')){
	function img_div_new($file,$file_id,$name = ''){

		$img = $file;
		if(@!is_array(getimagesize($file))){
			$img = file_cover();
		}

		return  "<div data-img-url='".$file."' class='edit'>".
		'<div class="title">'.$name.'</div>'.
		"<img  src='".$img."' />".
		"<a href='#' @click='deleteImg()' id='".$file_id."' class='trash'><i 
		class='fas fa-trash'
         
		></i></a>
		<a download  href='".base_url().'user/getfile?url='.$file."'><i  class='fas fa-download'></i></a></div>";

	}
}

function get_src($file){
	$img = base_url().'/user_uploads/'.$file['type'].'/'.$file['file'];
	if(@!is_array(getimagesize($img))){
		$img = file_cover();
	}
	return $img;
}

if( ! function_exists('img_from_db')){
	function img_from_db($file){

		$img  =get_src ($file);
        
		return  "<div  id='file_".$file['id']."' class='edit'>".
		'<div class="title">'.$file['file'].'</div>'.
		"<img  src='".$img."' />".
		"<span href='#' @click='deleteImg(".$file['id'].")' class='trash'><i 
		class='fas fa-trash' ></i></span>
		<a download target='_blank' href='".base_url().'user/getfile?url='.$file['id']."'>
		<i  class='fas fa-download'></i></a></div>";


	}
}



if( ! function_exists('file_cover')){
	function file_cover(){
		return base_url().'static/icon/file.png';
	}
}



if( ! function_exists('print_offer')){
	function print_offer($data){
		switch ($data['type']) {
			case 1:
				$offer_type = "HR";
				break;
			case 2:
				$offer_type = "PNC";
				break;
			case 3:
				$offer_type = "PNT";
				break;
			case 4:
				$offer_type = "Mecanicien";
				break;
		}

		return ' <div style="cursor: pointer;" 
		onclick="location.replace(\''. base_url().'offer/'.$data['id'] .'\');" class="custom_offer_bg" >
		<div class="col-md-12 offer_job_card">
		<p class="job_app_head">
		'.$data['title'].'
		</p>

		<p class="sub-string card_dates" style="width:14%;">
		</i>
		'.$data['start_date'].' 

		</p>
		
		
		<p class="sub-string card_dates" style="width:16%;">
		</i>
		'.$data['location'].' 
		</p>

		<p class="offer_card_type" style="width:12%;">'.$offer_type.'</p>

		<a class="offer_view_btn" style="width:13%;">'. lang('View offer').' <img src="'. base_url().'static/update/img/search (2) 1.png"></a>

		</div>
		</div>
		';
	}
}



