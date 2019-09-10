<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Foreignlang extends Apply_Un_Controller
{

	protected $step = 'foreignlang';


	public function __construct()
	{
		parent::__construct('user/offers');

	}

	public function index( )
	{


		$app = $this->get_application();
		if(!$app)
		redirect($this->get_page('main').FILL_FORM);

		$canRedirect = false;
		if(  isset($_POST['english_level'])  ){

			$main_row = $this->Crud->get_row(['application_id'=>$app['id']],'application_english_frechn_level');

			// we have app lets continute
			if($main_row){
				$new = [
					'french_level'=> $_POST['french_level'] ,
					'english_level'=> $_POST['english_level'],
					'application_id'=>$app['id']
				];
				//$application_id,$before,$new,$select_id,$select_value,$table,$scip = NULL
				$this->savehistory($app['id'],$main_row,$new,'application_id',$main_row['application_id'],
					'application_english_frechn_level',['application_id']);

				$this->Crud->update_or_insert($new, 'application_english_frechn_level');

			}
			else
			{

				$this->Crud->add(
					[
						'french_level'=> $_POST['french_level'],
						'english_level'=> $_POST['english_level'],
						'application_id'=>$app['id']
					],'application_english_frechn_level');
			}
			$row         = $this->Crud->get_row(['application_id'=>$app['id']],$this->get_table_name($this->step));

			$canRedirect = true;
		}
		// end oiof shit :)

		$row = $this->Crud->get_all($this->get_table_name($this->step),['application_id'=>$app['id']]);

		if( isset($_POST['language']) )
		{


			if($row){

				$langs = [];
				for($i = 0 ; $i < count($_POST['language']) ; $i++)
				{
					$lang = [
						'language' => $_POST['language'][$i],
						'level_id' => $_POST['level_id'][$i],
						'application_id'=> $app['id'],
					];
					array_push($langs,$lang);
				}
				foreach($row as $value){
					if(!in_array($value,$langs)){

						// oe ? we find you bich
						$this->savehistory($app['id'],$value,[],'application_id',
							$app['id'],$this->get_table_name($this->step),['application_id']);
						$this->Crud->delete($value,$this->get_table_name($this->step));
					}

				}

				foreach($langs as $new_value){
					$this->Crud->update_or_insert($new_value,$this->get_table_name($this->step));
				}
			}
			else
			{
				$langs = [];
				for($i = 0 ; $i < count($_POST['language']) ; $i++)
				{
					$langs[] = [
						'language' => $_POST['language'][$i],
						'level_id' => $_POST['level_id'][$i],
						'application_id'=> $app['id']
					];
				}

				$this->Crud->add_many($langs,$this->get_table_name($this->step));
			}
			$row = $this->Crud->get_all($this->get_table_name($this->step),['application_id'=>$app['id']]);

		}


		if($canRedirect){
			redirect($this->apply.'/'.$app['id']);
		}




		$this->show_header([lang('unsolicited_application_applys'),lang('unsolicited_application_applys'),lang('unsolicited_application_applys')]);
		$this->open_form();
		$this->show_foreign_lanuage($app['id'],$row);
		$this->load->view('front/apply/close');
		$this->load->view('front/apply/js/calendar_js');
		$this->show_footer();

	}




}


