<?php

class Uploadconfig
{

	public function get($folder = "")
	{

		$config = [];
/*		$config['encrypt_name'] = TRUE;*/
		$config['upload_path'] = './user_uploads'.$folder;
		$config['allowed_types'] = 'pdf|doc|docx|ppt|pptx|jpg|gif|bmp|png';
		$config['max_size'] = 4000;
		$config['url_path'] = '/user_uploads'.$folder;


		return $config;
	}




}
?>