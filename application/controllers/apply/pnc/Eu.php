<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Eu extends Apply_Pnc_Controller
{

	protected $step = 'eu';


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
		$paqes = $this->get_pagination($offer_id);
		if(!$app){
			redirect($this->get_page($offer_id,'main').FILL_FORM);
		}

		$this->form_validation->set_rules('eu_nationality', lang('eu_work'), 'trim|numeric');
		$this->form_validation->set_rules('can_work_eu', lang('can_work_eu'), 'trim|numeric');

		if($this->form_validation->run() === TRUE )
		{
			// if 0 && 0
			if($_POST['can_work_eu'] == 0 && $_POST['eu_nationality'] == 0 )
			{
				$this->session->set_flashdata('message',
					lang('eu_must_have'));
			}
			else
			{
				$_POST['application_id'] = $app['id'];

				$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));
				if($row)
				{
					$this->savehistory($app['id'],$row,$_POST,'application_id',$app['id'],$this->get_table_name($this->step),['applicaiton_id']);
				}
				$this->Crud->update_or_insert($_POST,$this->get_table_name($this->step));
				redirect($this->apply.'/'.$offer_id);
			}
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



		foreach(['eu_nationality','can_work_eu'] as  $column)
		{
			$value = isset($row[$column]) ? $row[$column]  : 0;
			$this->data['control']["{$column}_l"] = form_label(lang($column));
			$this->data['control'][$column] =
			form_dropdown($column, [0=>lang('no'),1=>lang('yes')],$value,['class'=>'form-control']);
		}

		$this->load->view('front/apply/part/form',$this->data);


	}







}


