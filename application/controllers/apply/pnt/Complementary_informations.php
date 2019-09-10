<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Complementary_informations extends Apply_Pnt_Controller
{

	protected $step = 'complementary_informations';


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

		$this->form_validation->set_rules('motivation_asl', lang('motivation_asl'), 'trim|required|max_length[2500]');


		if($this->form_validation->run() === TRUE){

			$incedent_array = [
				'motivation_asl' => $_POST['motivation_asl'],
				'involved_in_incidents' => $_POST['involved_in_incidents'],
				'application_id' => $app['id'],
			];

			
			$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));
			if($row){
				$this->savehistory($app['id'],$row,$incedent_array,'application_id',$app['id'],$this->get_table_name($this->step));
			}
			$this->Crud->update_or_insert($incedent_array,$this->get_table_name($this->step));
			
			
			// car and Aviability
			
			$misc_array =
			[
				'application_id' => $app['id'],
				'car'=>$_POST['car'],
				'aviability'=>date_to_db($_POST['aviability']),
			];
			 
			$row = $this->Crud->get_row(['application_id'=>$app['id']],'applicaiton_misc');
			if($row){
				$this->savehistory($app['id'],$row,$misc_array,'application_id',$app['id'],'applicaiton_misc');
			}
			$this->Crud->update_or_insert($misc_array,'applicaiton_misc');
			
			
			
			redirect($this->apply.'/'.$offer_id);
		}else{
				$message = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


			$this->session->set_flashdata('message',$message);
		}


		$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));
		$this->show_header([$offer_row['title'],$offer_row['title'],$offer_row['title']]);
		$this->open_form($offer_id,$offer_row);

		$app_other_table = $this->Crud->get_row(['application_id'=>$row['application_id']],'applicaiton_misc');
		$this->show($row,$app_other_table);
		$this->data = null ;
		
		
		parent::show_aviability($app_other_table);


		$this->load->view('front/apply/close');
		$this->show_footer();
	}


	protected function show($app,$app_other_table)
	{


		$this->data['control']["a"] = form_label(lang('motivation_asl'));

		$this->data['control']['motivation_asl'] = form_textarea(
			$this->inputarray->getArray(
				'motivation_asl','textarea',lang('motivation_asl'),$app['motivation_asl'],TRUE));

		$this->data['control']["aa"] = form_label(lang('Involved in incidents'));

		$this->data['control']['involved_in_incidents'] = form_textarea(
			$this->inputarray->getArray(
				'involved_in_incidents','textarea',lang('Involved in incidents'),$app['involved_in_incidents'],FALSE));

		
	   

		$have_car = isset($app_other_table['car'])? $app_other_table['car'] : 0;

		$this->data['control']["car_l"] = form_label(lang("car"));
		$this->data['control']['car'] =
		form_dropdown('car', [0=>lang('not_have_car'),1=>lang('have_car')],$have_car,['class'=>'form-control']);



		$this->load->view('front/apply/part/form',$this->data);
	}







}


