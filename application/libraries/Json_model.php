<?php

class Json_model
{

    private $_folder = "json_config/";


	/**
	* 
	* @param array $array
	* @param string  $filename
	* 
	* @return
	*/
    public function save($array,$filename)
    {
        file_put_contents($this->_folder.$filename,  json_encode($array));
    }
    /**
	* 
	* @param string $filename
	* 
	* @return
	*/
    public function load($filename)
    {
		$file = @file_get_contents($this->_folder.$filename);
		
		return (!$file) ?  NULL :  json_decode($file, true);
		
		
    }


}
