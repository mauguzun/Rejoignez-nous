<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*  can use admin ,and hr
*/
class Hiringpolicy extends Shared_Controller
{
	private $data = [];
	private $_redirect ;

	private $_table = 'hiring_policy';
	private $_allowed = [1,2,77];
	private $_ajax;

	public function __construct()
	{
		parent::__construct($this->_allowed);
		$this->_redirect = base_url().Shared_Controller::$map.'/hiringpolicy';
		$this->_ajax = base_url().'access/Hr_Admin_Comm';

		$this->load->library("Uploadlist");
		$this->_config['encrypt_name'] = TRUE;
		$this->_config['upload_path'] = $this->uploadlist->site_img();
		$this->_config['allowed_types'] = 'jpg|gif|png';
		$this->_config['max_size'] = 5000;
		$this->_config['max_width'] = 450;
		$this->_config['max_height'] = 270;
	}


	public function index()
	{

		$this->show_header();
		$this->_set_form_validation($this->_redirect.'/insert/');


		$row = $this->Crud->get_row(['id'=>1],$this->_table);

		$this->load->view('js/ajaxupload');
		/* foreach (['picture'] as $value) {
		$uploader['upload_id'] = $value;
		$uploader['upload_url'] = $this->_redirect.'/upload/'.$value;
		$uploader['delete_url'] = $this->_redirect.'/delete/'.$value;
		$uploader['input_selector'] = "#$value";
		$uploader['default_file'] = (isset($row[$value]))?
		base_url().$this->uploadlist->site_img().'/'.$row[$value]:NULL;

		$this->data['control']["X.$value"] = form_label(lang($value));
		$this->data['control']["X".$value] = $this->load->view('back/parts/uploader',$uploader,TRUE);
		}*/

		$this->_set_data($row);


		// uploader


		$this->data['required'] = [  'general_picture' ,'pnt_picture','mecahic_picture'];




		foreach($this->data['required'] as $value)
		{
			$uploader['upload_id'] = $value;
			$uploader['upload_url'] = $this->_redirect.'/upload/'.$value;
			$uploader['delete_url'] = $this->_redirect.'/delete/'.$value;
			$uploader['input_selector'] = "#$value";
			$uploader['default_file'] = (isset($row[$value]))?
			base_url().$this->uploadlist->site_img().'/'.$row[$value]:NULL;

			$this->data['control']["X.$value"] = form_label(lang($value));
			$this->data['control']["X".$value] = $this->load->view('back/parts/uploader',$uploader,TRUE);
		}


		//  array_push($this->data['required'],'integration','course','recruiting','diversity');
		array_push($this->data['required'],'integration','recruiting','diversity');


		$this->load->view(Admin_Controller::$map .'/parts/add_with_upload',$this->data);
		$this->load->view('back/parts/footer');

	}



	/**
	* used by ajax from view
	* @param string type  $cv
	*
	* @return json messag
	*/
	public function upload($cv = 'picture')
	{


		if($cv == 'picture')
		{
			$this->_config['max_width'] = 276;
			$this->_config['max_height'] = 368;
		}

		$this->_config['upload_path'] = $this->_config['upload_path'];




		$this->load->library('upload',$this->_config);
		if( ! $this->upload->do_upload('file'))
		{
			$this->session->set_flashdata('message', $this->upload->display_errors());
			echo json_encode(['error'=>$this->upload->display_errors().lang('allowed_filetype'). '  :  ' .$this->_config['allowed_types']]);
			return ;
		}
		else
		{
			$upload_data = [ 'upload_data'=> $this->upload->data()];
			echo json_encode([
					'url'=>base_url().$this->_config['upload_path'] .'/'.$upload_data['upload_data']['file_name'],
					'done'=>$upload_data['upload_data']['file_name'],
					'file'=>'file'
				]);
		}

	}

	public function insert()
	{




		$this->_set_form_validation($this->_redirect.'/insert/');

		if($this->form_validation->run() === TRUE)
		{
			$this->Crud->update_or_insert($_POST,$this->_table);
		}
		redirect($this->_redirect);
		/*echo json_encode(['error'=>$this->form_validation->error_array()]);*/

	}
	private function _set_form_validation($url)
	{
		$this->data['title'] = lang('hiring_policy');
		$this->data['url'] = $url;
		$this->data['buttons'] = [

			'create_and_publish'=>$url,
		];
		$this->data['cancel'] = $this->_redirect;



		$this->form_validation->set_rules('integration', lang('integration'), 'required');
		//        $this->form_validation->set_rules('course', lang('course'), 'required');
		$this->form_validation->set_rules('recruiting', lang('recruiting'), 'required');
		$this->form_validation->set_rules('diversity', lang('diversity'), 'required');



	}

	private function _set_data($user = NULL)
	{

		$this->load->library("html/InputArray");



		foreach(['diversity','recruiting','integration',] as $column)
		{

			$this->data['control']["{$column}_l"] = form_label(lang("$column"));

			$selected = ($user) ? $user[$column]: NULL;
			$this->data['control'][$column] = form_textarea(
				$this->inputarray->getArray($column,null,lang($column),$selected,null
				));
		}

		$this->data['control']['id'] = form_input(
			$this->inputarray->getArray('id','hidden',1,1));

		foreach(['general_picture','picture','pnt_picture','pnc_picture','mecahic_picture']as $column)
		{
			$selected = (isset($user[$column])) ? $user[$column]: NULL;
			$this->data['control'][$column] = form_input(
				$this->inputarray->getArray($column,'hidden',null,$selected,null,null));
			//
		}

	}


}
