<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Other extends Apply_Pnc_Controller
{

	protected $step = 'other';


	public function __construct()
	{
		parent::__construct('user/offers');

	}

	public function index($offer_id )
	{
		$offer = $this->errors($offer_id);
		if(!$offer)
		return ;


		$app = $this->application_id($offer_id);
		if(!$app){
			redirect($this->get_page($offer_id,'main').FILL_FORM);
		}

		$this->form_validation->set_rules('employ_center', lang('employ_center'), 'trim');

		if($this->form_validation->run() === TRUE )
		{
			
		
				$employ = [
					'application_id' => $app['id'],
					'employ_center'=>$_POST['employ_center']
				];
			
				$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));
				if($row)
				{
					$this->savehistory($app['id'],$row,$employ,'application_id',$app['id'],$this->get_table_name($this->step),['applicaiton_id']);
				}
				$this->Crud->update_or_insert($employ,$this->get_table_name($this->step));
				
				$car = [
					'application_id' => $app['id'],
					'car'=>$_POST['car']
				];
	
				$row = $this->Crud->get_row(['application_id'=>$app['id']],'applicaiton_misc');
				if($row)
				{
					$this->savehistory($app['id'],$row,$car,'application_id',$app['id'],'applicaiton_misc',['applicaiton_id']);
				}
				$this->Crud->update_or_insert($car,'applicaiton_misc');
				
				
		//	echo $this->apply.'/'.$offer_id;
				redirect($this->apply.'/'.$offer_id);
						
		}


		$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));
		$this->show_header([$offer['title'],$offer['title'],$offer['title']]);
		$this->open_form($offer_id,$offer);
		$this->show($row);
		$this->load->view('front/apply/close');
		$this->show_footer();
	}

	protected function show($row)
	{
		foreach(['employ_center'] as  $column)
		{
			$value = isset($row[$column]) ? $row[$column]  : 0;
			$this->data['control']["{$column}_l"] = form_label(lang('employ_center'));
			$this->data['control'][$column] =
			form_dropdown($column, [0=>lang('no'),1=>lang('yes')],$value,['class'=>'form-control']);
		}
		
		$car = $this->Crud->get_row(['application_id'=>$row['application_id']],'applicaiton_misc');
		$have_car = isset($car)? $car['car'] : 0;

		$this->data['control']["car_l"] = form_label(lang("car"));
		$this->data['control']['car'] =
		form_dropdown('car', [0=>lang('not_have_car'),1=>lang('have_car')],$have_car,['class'=>'form-control']);



		$this->load->view('front/apply/part/form',$this->data);


	}







}


