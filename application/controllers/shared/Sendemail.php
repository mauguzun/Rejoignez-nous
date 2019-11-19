<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// back / activity
class Sendemail extends Shared_Controller{

	private $table = 'application';
	private $_allowed = [1,2,3,4];

	public function __construct(){
		parent::__construct($this->_allowed);
		$this->load->library("Uploadlist");
	}

	// doe
	public function hr($application_id){

		redirect(base_url().'apply/new/hr/send_email/?email='.$_POST['email'].'&app_id='.$application_id);


	}

	public function pnt($application_id){
		redirect(base_url().'apply/new/pnt/send_email/?email='.$_POST['email'].'&app_id='.$application_id);
	}
	public function pnc($application_id){
		redirect(base_url().'apply/new/pnc/send_email/?email='.$_POST['email'].'&app_id='.$application_id);
	}
	public function mechanic($application_id){
		redirect(base_url().'apply/new/mechanic/send_email/?email='.$_POST['email'].'&app_id='.$application_id);

	}
	public function unsolicated($application_id){
		redirect(base_url().'apply/new/hr/send_email/?email='.$_POST['email'].'&app_id='.$application_id);

	}
	public function manualy($application_id){
		$query = $this->Crud->get_row(['id'=>$application_id],'application');
				
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

		$this->send_pdf_to_user($_POST['email'],"applicaion ". $application_id ,$html);
		
		echo true;
	

	}
	private function send_pdf_to_user($to,$subject,$html){
		$this->load->library('email',[
				'protocol'=>$this->email_settings['transport']
			]);


		$this->email->from($this->email_settings['sender'],$this->email_settings['email']);
		$this->email->to($to);
		$this->email->subject($subject);
		/*echo $html;*/

		require_once("application/libraries/dompdf/vendor/autoload.php");

		$dompdf = new  Dompdf\Dompdf();
		$dompdf->loadHtml($html);
				$dompdf->setPaper('A4'.'landscape');

		$dompdf->render();
		$pdf    = $dompdf->output();
		file_put_contents('output.pdf', $pdf);
		$this->email->attach($pdf, 'application/pdf', 'output.pdf', false);


		$this->email->message($html);
	
		return $this->email->send();

	}

	
}
