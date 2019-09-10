<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Expirience extends Apply_Un_Controller
{

	protected $step = 'expirience';


	public function __construct()
	{
		parent::__construct('user/offers');

	}

	public function index( )
	{


		$app = $this->get_application();
		if(!$app)
		redirect($this->get_page('main').FILL_FORM);

		$this->form_validation->set_rules('area[]', lang('area'), 'trim|required|max_length[200]');


		$row = $this->Crud->get_all($this->get_table_name($this->step),['application_id'=>$app['id']]);
		// check form validation


		if(  isset($_POST['area']) && $this->form_validation->run() === true ){


			// we have app lets continute
			if($row){


				$langs = [];
				for($i = 0 ; $i < count($_POST['area']) ; $i++){
					$lang = [
						'area' => $_POST['area'][$i],
						'duration' => $_POST['duration'][$i],
						'managerial' => $_POST['managerial'][$i],
						'application_id'=> $app['id'],
					];
					array_push($langs,$lang);
				}
				foreach($row as $value)
				{
					if(!in_array($value,$langs))
					{

						// oe ? we find you bich
						$this->savehistory($app['id'],$value,[],'application_id',$app['id'],$this->get_table_name($this->step),NULL);
						$this->Crud->delete($value,$this->get_table_name($this->step));
					}
				}

				foreach($langs as $new_value)
				{
					$this->Crud->update_or_insert($new_value,$this->get_table_name($this->step));
				}

			}
			else
			{

				$langs = [];
				for($i = 0 ; $i < count($_POST['area']) ; $i++)
				{
					$langs[] = [
						'area' => $_POST['area'][$i],
						'duration' => $_POST['duration'][$i],
						'managerial'=> $_POST['managerial'][$i],
						'application_id'=> $app['id']
					];
				}

				$this->Crud->add_many($langs,$this->get_table_name($this->step));
			}
			redirect($this->apply.'/'.$app['id']);
			$row = $this->Crud->get_all($this->get_table_name($this->step),['application_id'=>$app['id']]);


		}
		else
		{

			$message = (validation_errors() ? validation_errors() :
				($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));



			$this->session->set_flashdata('message',$message);

		}

		$this->show_header([lang('unsolicited_application_applys'),lang('unsolicited_application_applys'),lang('unsolicited_application_applys')]);
		$this->open_form();
		$this->show($row);
		$this->load->view('front/apply/close');
		$this->show_footer();
	}

	protected function show($row)
	{


		$this->data['control']['area[]'] = form_input(
			$this->inputarray->getArray('area[]','text',lang("area"),NULL,TRUE));


		$select = [];
		foreach(
			[
				'expirience_duration'=>'duration',
				'expirience_managerial'=>'managerial'] as $key=> $column)
		{

			$arr = [];
			$arr['class'] = 'form-control' ;
			if($column == 'managerial')
			{
				$arr['data-toggle'] = 'tooltip' ;
				$arr['data-original-title'] = lang('managerial_tooltip');
			}



			foreach($this->Crud->get_all($key,null,'id','asc') as $value)
			{
				$options[$value['id']] = $value[$column];
			}
			$select[$column] = $options;
			$this->data['control'][$column.'[]'] = form_dropdown($column.'[]', $options,0,$arr);

		}



		if($row)
		{
			$arr = [];
			$arr['class'] = 'form-control' ;
			$arr['data-toggle'] = 'tooltip' ;
			$arr['data-original-title'] = lang('managerial_tooltip');
			$this->data['data'] = [];
			foreach($row as $value)
			{
				$line = [];
				$line['area[]'] = form_input(
					$this->inputarray->getArray('area[]','text',lang("area"),$value['area'],TRUE));
				$line['duration[]'] = form_dropdown('duration[]', $select['duration'],$value['duration'],['class'=>'form-control']);





				$line['managerial[]'] = form_dropdown('managerial[]',
					$select['managerial'],$value['managerial'],$arr);

				array_push($this->data['data'],$line);

			}
		}
		$this->load->view('front/apply/hr/expirience',$this->data);
		$this->load->view('front/apply/js/calendar_js');



	}







}


