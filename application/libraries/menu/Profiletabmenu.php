<?php

class Profiletabmenu
{

	protected 	$pages = [
		'profile'=>'profile',
		'address'=>'address',
		
		'foreignlang'=>'foreignlang',
		'education'=>'education',
		'expirience'=>'expirience',
		'misc'=>'mics'

	];

    public function get_profile_nav($active,$url = null )
    {

      
	   $num = 0;
       foreach($this->pages as $key=>&$value){

			$class = ($key == $active )? 'page-item active':'page-item';
			$value = '<li class="'.$class.'">'.anchor(base_url().'/user/'.$key,
				++$num ,['class'=>'page-link' ,'data-toggle'=>'tooltip', 'title'=>lang($value) ])."</li>";
		}
		return $this->pages;
       
    }



}
?>