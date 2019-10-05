<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Medical_aptitudes extends Apply_Pnt_Controller
{

	protected $step = 'medical_aptitudes';


	public function __construct()
	{
		parent::__construct('user/offers');

	}

	public function index($offer_id)
	{
		$offer_row = $this->errors($offer_id);


		$offer     = $this->errors($offer_id);
		if(!$offer)
		return ;

		$app = $this->application_id($offer_id);
		if(!$app)
		{
			$paqes = $this->get_pagination($offer_id);
			redirect($paqes[1].FILL_FORM);
		}

		 $this->form_validation->set_rules('date', lang('end_date_last_medical_visit'), 'trim|required|max_length[12]');

		
		if ($this->form_validation->run() === TRUE) {

            $_POST['application_id'] = $app['id'];
            $_POST['date'] = date_to_db($_POST['date']);
            $row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));
            if($row){
				$this->savehistory($app['id'],$row,$_POST,'application_id',$app['id'],$this->get_table_name($this->step));
			}
            $this->Crud->update_or_insert($_POST,$this->get_table_name($this->step));
			redirect($this->apply.'/'.$offer_id);
        }
       
		
		$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));
		$this->show_header([$offer_row['title'],$offer_row['title'],$offer_row['title']]);
		$this->open_form($offer_id,$offer_row);
		$this->show($row);
		$this->load->view('front/apply/close');
		$this->show_footer();
	}


	protected function show($app)
	{
		


			$this->data['control'][0]= "<strong>".lang('do_you_have_class')."</strong>";
			$this->data['control']["a"] = form_label(lang('end_date_last_medical_visit'));

			$date_picker = $this->inputarray->getArray('date','search',
            lang("end_date_last_medical_visit"),isset($app['date']) ?  date_to_input($app['date']) :  NULL ,TRUE,['data-calendar'=>true]);
            $this->data['control']['date'] = form_input( $date_picker);
	

		$this->load->view('front/apply/part/form',$this->data);
	}







}


