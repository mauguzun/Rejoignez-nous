<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Install_title extends CI_Migration{

	public function __construct(){
		parent::__construct();
		$this->load->dbforge();

	
	}
	
	public function up(){
		$this->dbforge->modify_column('offers',[
				'title'=>[

					'type' => 'varchar',
					'constraint'=>'250'
				]
			]);
			
	}
              
	public function down(){
		
		
	}
}