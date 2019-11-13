<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// back / activity
class Printmanualoffer extends Shared_Controller{

	private $table = 'application';
	private $_allowed = [1,2];

	public function __construct(){
		parent::__construct($this->_allowed);
	}


	public function index($app_id){

		if( $this->ion_auth->get_users_groups()->row()->id == 8){
			  
			return false;
		}

		$query = $this->Crud->get_row(['id'=>$app_id],'application');
				
		$data = 
		[   lang('first_name')=>$query['first_name'],
			lang('last_name')=>$query['last_name'],
			lang('function')=>$query['unsolicated_function'],
			lang('comment')=>$query['comment']] ;
		
		$html = '';
		$html .= $this->load->view('apply_final/printer/header',['query'=>$query],true);
		$html .= $this->load->view('apply_final/printer/keyvalue',[
				'title'=>lang('profile'),
				'query'=>$data
			],true);

		$html .=  $this->load->view('apply_final/printer/footer',['query'=>$query],true);

		require_once("application/libraries/dompdf/vendor/autoload.php");

		$dompdf = new  Dompdf\Dompdf();
		$dompdf->loadHtml($html);

		$dompdf->setPaper('A4','landscape');


		$dompdf->render();
		$dompdf->stream(
			url_title($query['first_name'].$query['last_name']), array("Attachment"=> false));

		exit(0);
	
		
	}
	


 

	
}
