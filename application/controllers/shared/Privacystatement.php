<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*  can use admin ,and hr
*/
class Privacystatement extends Shared_Controller
{
	private $data = [];
	private $_redirect ;

	private $_table = 'privacy_statement';
	private $_allowed = [1,2,77];
	private $_ajax;

	public function __construct()
	{
		parent::__construct($this->_allowed);
		$this->_redirect = base_url().Shared_Controller::$map.'/privacystatement';
			$this->_ajax = base_url().'access/Hr_Admin_Comm';

		$this->load->library("Uploadlist");
		//$this->_config['encrypt_name'] = TRUE;
		$this->_config['upload_path'] = $this->uploadlist->get_pricacy();
		$this->_config['allowed_types'] = 'pdf';
		$this->_config['max_size'] = 5000;

	}


	public function index()
	{
		$this->show_header();




		$js = strip_tags( $this->load->view('js/data_edit_ajax',[
					'selector'=>$this->_table,'url'=>$this->_ajax.'/add' ],TRUE));

		$this->load->view('back/parts/datatable',[
				'headers'=>['id',  'file','set active' ,'delete'],
				'title' =>lang('privacystatement'),
				'url' => $this->_redirect.'/ajax',
				'add_button' => $this->_redirect.'/add',
				'js'=>$js,
				'order'=>'desc'
			]);



		//$this->load->view('js / ajaxupload');

		$this->load->view('back/parts/footer');

	}

	public function add()
	{

		$this->_set_form_validation($this->_redirect.'/insert');
		$this->load->view('js/ajaxupload');

		$uploader['upload_id'] = 'imgupload';
		$uploader['upload_url'] = $this->_redirect.'/upload';
		$uploader['delete_url'] = $this->_redirect.'/delete/';
		$uploader['input_selector'] = "#file";

		$this->data['control']['upl'] = $this->load->view('back/parts/uploader',$uploader,TRUE);
		$this->load->view(Admin_Controller::$map .'/parts/add_with_upload',$this->data);

	}


	private function _set_form_validation($url  )
	{
		$this->data['title'] = lang('uplad_file_hiring');

		$this->data['url'] = $url;

		$this->data['buttons'] = [

		];

	}
	/**
	* used by ajax from view
	* @param string type  $cv
	*
	* @return json messag
	*/
	public function upload()
	{



		$new_name = url_title($_FILES["file"]['name']);
		$this->_config['file_name'] = $new_name;

		$this->load->library("upload",$this->_config);

		if( ! $this->upload->do_upload('file'))
		{
			$this->session->set_flashdata('message', $this->upload->display_errors());
			$this->data['message'] = $this->upload->display_errors();

			echo json_encode(['error'=>$this->upload->display_errors().lang('allowed_filetype').$this->_config['allowed_types']]);
			return ;

		}
		else
		{
			$upload_data = [ 'upload_data'=> $this->upload->data()];

			$this->Crud->add(['file'=>$upload_data['upload_data']['file_name'] ,'status'=>0],$this->_table);
			echo json_encode([
					'url'=>base_url().$this->uploadlist->get_pricacy().'/'.$upload_data['upload_data']['file_name'],
					'done'=>$upload_data['upload_data']['file_name']
				]);
		}
	}

	public function trash($id)
	{
		if($id && $id > 0)
		{
			$row = $this->Crud->get_row(['id'=>$id],$this->_table);
			$this->Crud->delete(['id'=>$id],$this->_table);
			@unlink($this->uploadlist->get_pricacy().'/'.$row['file'])  ;
		}
		redirect($this->_redirect);
	}

	public function set($id)
	{

		$row   = $this->Crud->get_row(['id'=>$id],$this->_table);
		$value = $row['status'] == 0  ? 1 : 0;
		
		if ($value == 1)
		$this->Crud->update(NULl,['status'=>0],$this->_table);
		
		$this->Crud->update(['id'=>$id],['status'=>$value],$this->_table);

		redirect($this->_redirect);
	}

	public function ajax()
	{

		$query = $this->Crud->get_all( $this->_table);




		$this->load->helper("directory");
		$data['data'] = [];

		$phrase = lang('file_toogle');

		foreach( $query as $file)
		{

			$row = [];
			$top = ($file['status'] == 1) ? 1: 0;

			array_push(
				$row,
				$file['id'],
				anchor( base_url().'/'.$this->uploadlist->get_pricacy().'/'.$file['file']  , $file['file']  ,['target'=>'_blank'] ),
				anchor( $this->_redirect.'/set/'.$file['id']  , $phrase[!$top]  ),
				$this->load->view("buttons/trash",['url'=>$this->_redirect.'/trash/'.$file['id']],true)

			);
			array_push($data['data'],$row);
		}


		echo json_encode($data);

	}


}
