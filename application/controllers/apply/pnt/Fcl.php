<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Fcl extends Apply_Pnt_Controller
{

	protected $step = 'fcl';


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
		if(!$app)
		{
			redirect($this->get_page($offer_id,'main').FILL_FORM);
		}

		$this->form_validation->set_rules('fcl', lang('fcl'), 'trim|numeric');

		if($this->form_validation->run() === TRUE ){
			if($_POST['fcl'] == 0)
			{
				$this->session->set_flashdata('message',
					lang('you_must_have_obtained_a_level_higher_than_or_equal'));
			}
			else
			{

				$_POST['application_id'] = $app['id'];
				$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));
				if($row)
				$this->savehistory($app['id'],$row,$_POST,'application_id',$app['id'],$this->get_table_name($this->step),['applicaiton_id']);

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
		foreach(['fcl'] as  $column){
			$value = isset($row[$column]) ? $row[$column]  : 0;

			$this->data['control'][$column] =
			form_dropdown($column, [0=>lang('no'),1=>lang('yes')],$value,['class'=>'form-control']);
		}

		$this->load->view('front/apply/part/form',$this->data);


	}







}


