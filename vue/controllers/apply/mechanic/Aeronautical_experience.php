<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Aeronautical_experience extends Apply_Mechanic_Controller
{

	protected $step = 'aeronautical_experience';


	public function __construct()
	{
		parent::__construct('user/offers');

	}

	public function index($offer_id )
	{
		$offer = $this->errors($offer_id);
		if(!$offer)
		return ;



		$app   = $this->application_id($offer_id);
		$paqes = $this->get_pagination($offer_id);
		if(!$app)
		{
			redirect($this->get_page($offer_id,'main').FILL_FORM);
		}

		$this->form_validation->set_rules('b737_ng', lang('b737_ng'), 'trim|required|max_length[250]');


		$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));

		if($this->form_validation->run() === TRUE ){



			if($_POST['part_66_license'] == 0 ){

				$this->session->set_flashdata('message',lang('part_66_license'));
			}
			else
			{
				$_POST['application_id'] = $app['id'];
				if($row)
				{
					$this->savehistory($app['id'],$row,$_POST,'application_id',$app['id'],$this->get_table_name($this->step),['id']);
				}
				$this->Crud->update_or_insert($_POST,$this->get_table_name($this->step));
				redirect($this->apply.'/'.$offer_id);
			}
			$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));
			
		}



		$this->show_header([$offer['title'],$offer['title'],$offer['title']]);
		$this->open_form($offer_id,$offer);
		$this->show($row);
		$this->load->view('front/apply/close');
		$this->show_footer();
	}

	protected function show($app)
	{


		$options = [];
		foreach($this->Crud->get_all("mechanic_offer_managerial",null,'id','asc') as $value){
			$options[$value['id']] = $value['duration'];
		}

		foreach(['b737_classic','b737_ng'] as $column){
			$this->data['control']["{$column}_l"] = form_label(lang($column));
			$this->data['control'][$column] = form_dropdown($column, $options, isset($app[$column]) ? $app[$column]: NULL,['class'=>'form-control']);

		}

		foreach(['part_66_license'] as  $column){
			$value = isset($app[$column]) ? $app[$column]  : 0;
			$this->data['control']["{$column}_l"] = form_label(lang($column));
			$this->data['control'][$column] =
			form_dropdown($column, [0=>lang('no'),1=>lang('yes')],$value,['class'=>'form-control']);
		}





		$options = [];
		foreach($this->Crud->get_all("expirience_managerial",null,'id','asc') as $value){
			$options[$value['id']] = $value['managerial'];
		}

		foreach(['managerial_duties'] as $column){
			$this->data['control']["{$column}_l"] = form_label(lang($column));
			$this->data['control'][$column] = form_dropdown($column, $options, isset($app[$column]) ? $app[$column]: NULL,['class'=>'form-control']);

		}
		$this->load->view('front/apply/part/form',$this->data);




	}







}


