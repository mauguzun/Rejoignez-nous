<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user/apply/Hr/Main
*/
class Foreignlang extends Apply_Mechanic_Controller{

	protected $step = 'foreignlang';


	public function __construct(){
		parent::__construct('user/offers');

	}

	public function index($offer_id ){
		$offer = $this->errors($offer_id);
		if(!$offer){
			return ;
		}



		$app = $this->application_id($offer_id);
		if(!$app){
			redirect($this->get_page($offer_id,'main').FILL_FORM);
		}
		/*$this->form_validation->set_rules('language[]', lang('language'), 'trim|required|max_length[255]');
		*/

		$can_redirect = FALSE;
		$this->form_validation->set_rules('aeronautical_english_level', lang('function'), 'trim|numeric');
		
		if(isset($_POST['english_level'])  ){
			$this->Crud->update_or_insert([
					'application_id'=>(int)$app['id'],
					'english_level'=>$_POST['english_level'],			
					'french_level'=>$_POST['french_level']],'application_english_frechn_level');
					
			$this->Crud->update_or_insert([
					'application_id'=>(int)$app['id'],
					'lang_level'=>$_POST['lang_level']],'aeronautical_english_level');
					
			$can_redirect = TRUE;
		}

		$row = $this->Crud->get_all('application_languages_level',['application_id'=>$app['id']]);

		if( isset($_POST['language']) && $this->form_validation->run() === TRUE){
			
			if($row){

				$langs = [];
				for($i = 0 ; $i < count($_POST['language']) ; $i++){
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
							$app['id'],'application_languages_level',['application_id']);
						$this->Crud->delete($value,'application_languages_level');
					}
				}

				foreach($langs as $new_value){
					if(!empty($new_value['language'])){
						$this->Crud->update_or_insert($new_value,'application_languages_level');
					}


				}
			}
			else{
				$langs = [];
				for($i = 0 ; $i < count($_POST['language']) ; $i++){
					if(!empty($_POST['language'][$i])){
						$langs[] = [
							'language' => $_POST['language'][$i],
							'level_id' => $_POST['level_id'][$i],
							'application_id'=> $app['id']
						];
					}


				}

				$this->Crud->add_many($langs,'application_languages_level');
			}
			$row  = $this->Crud->get_all('application_languages_level',['application_id'=>$app['id']]);

			
		}
		if($can_redirect)
		redirect( $this->apply.'/'.$offer_id);

		$this->show_header([$offer['title'],$offer['title'],$offer['title']]);
		$this->open_form($offer_id,$offer);
		$this->show_foreign_lanuage($app['id'],$row);

		$this->data = null;

		$aero_lang = $this->Crud->get_row(['application_id'=>$app['id']],'aeronautical_english_level');
		$options   = [];
		foreach($this->Crud->get_all("language_level",null,'id','asc') as $value){
			$options[$value['id']] = $value['level'];
		}

		foreach(['lang_level'] as $column){
			$this->data['control']["x"] = lang('aeronautical_english_level');
			$this->data['control'][$column] = form_dropdown($column, $options,($aero_lang) ? $aero_lang[$column]: NULL,['class'=>'form-control']);

		}
		$this->load->view('front/apply/part/form',$this->data);


		$this->load->view('front/apply/close');
		$this->load->view('front/apply/js/calendar_js');
		$this->show_footer();

	}




}

