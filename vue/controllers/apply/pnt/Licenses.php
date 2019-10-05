<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Licenses extends Apply_Pnt_Controller
{

	protected $step = 'licenses';


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

		$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));

		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			
			$dates =  ['cpl_start','cpl_end','atpl_start','atpl_end','irme_start','irme_end'];
			foreach($_POST as $key=>&$value)
			{
				if(in_array($key,$dates) && !empty($value))
					$value = date_to_db($value);

			}
			
			$_POST['application_id'] = $app['id'];
			if($row)
			{
				$this->savehistory($app['id'],$row,$_POST,'application_id',$app['id'],$this->get_table_name($this->step));
			}
			$this->Crud->update_or_insert($_POST,$this->get_table_name($this->step));
			redirect($this->apply.'/'.$offer_id);
			$row = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));
		}



		$this->show_header([$offer['title'],$offer['title'],$offer['title']]);
		$this->open_form($offer_id,$offer);
		$this->show($row);
		$this->load->view('front/apply/close');
		$this->show_footer();
	}

	protected function show($row)
	{
		if($row)
		{
			$convert = ['cpl_start','cpl_end','atpl_start','atpl_end','irma_start','irma_end'];
			foreach($convert as $index)
			{
				if(!empty($row[$index]))
				$row[$index] = date_to_input($row[$index]);
			}
		}

		$this->data['query'] = $row;

		$this->load->view('front/apply/pnt/license_view',$this->data);

	}







}


