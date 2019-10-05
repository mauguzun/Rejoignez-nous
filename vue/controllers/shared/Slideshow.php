<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// back / usser
class Slideshow extends Shared_Controller
{
	private $data = [];
	private $_redirect ;

	private $_table = 'slideshow';
	private $_ajax ;

	private $_allowed = [1,2];

	public function __construct()
	{
		parent::__construct($this->_allowed);
		$this->_redirect = base_url().Shared_Controller::$map.'/slideshow';
		$this->_ajax = base_url().Shared_Controller::$map.'/ajax';




		$this->load->library("Uploadlist");
		$this->_config['encrypt_name'] = TRUE;
		$this->_config['upload_path'] = $this->uploadlist->site_img();
		$this->_config['allowed_types'] = 'jpg|gif|png';
		$this->_config['max_size'] = 5000;
		/* $this->_config['max_width'] = 650;
		$this->_config['max_height'] = 382;*/

	}

	public function index()
	{
		// $this->load->view('back / index');
		$this->show_header();


		$js = strip_tags($this->load->view('js/ajaxtoogle',[
					'selector'=>$this->_table,'url'=>$this->_ajax.'/toogle' ],TRUE));

		$js .= strip_tags( $this->load->view('js/data_edit_ajax',[
					'selector'=>$this->_table,'url'=>$this->_ajax.'/toogle' ],TRUE));

		$js .= strip_tags( $this->load->view('js/circle',NULL,TRUE));

		$this->load->view('back/parts/datatable',[
				'headers'=>['id','file','status' , 'order' ,'activ_btn'],
				'title' =>lang('slideshow_manage'),
				'url' => $this->_redirect.'/ajax',
				'add_button' => $this->_redirect.'/add',
				'js'=>$js,
				'order'=>'asc'
			]);



		//$this->load->view('js / ajaxupload');

		$this->load->view('back/parts/footer');
	}

	public function add()
	{


		// $this->show_header();
		$this->_set_form_validation($this->_redirect.'/insert');
		$this->_set_data();



		$this->load->view('js/ajaxupload');

		$uploader['upload_id'] = 'imgupload';
		$uploader['upload_url'] = $this->_redirect.'/upload';
		$uploader['delete_url'] = $this->_redirect.'/delete/';
		$uploader['input_selector'] = "#file";

		$this->data['control']['upl'] = $this->load->view('back/parts/uploader',$uploader,TRUE);
		$this->load->view(Admin_Controller::$map .'/parts/add_with_upload',$this->data);

		$this->load->view(Admin_Controller::$map.'/parts/footer');
	}


	public function update($id)
	{
		$this->_set_form_validation($this->_redirect.'/update');
		if($this->form_validation->run() === TRUE)
		{

			$this->Crud->update(['id'=>$id],$_POST,$this->_table);
			echo json_encode(['done'=>true]);
			return;

		}
		echo json_encode(['error'=>$this->form_validation->error_array()]);
	}

	public function ajaxstatus($id,$order)
	{
		if($this->Crud->update(['id'=>$id],['order'=>$order],$this->_table))
		{
			echo json_encode(['done'=>$order]);
			return ;
		}
		echo json_encode(['error'=>'You dont have acces']);

	}

	public function edit($user_id = NULL)
	{

		$row = $this->Crud->get_row(['id'=>$user_id],$this->_table);

		$this->_set_form_validation($this->_redirect.'/update/'.$user_id);
		$this->_set_data($row);



		if($user_id && $user_id > 0)
		{
			$uploader['upload_id'] = 'imgupload';
			$uploader['upload_url'] = $this->_redirect.'/upload';
			$uploader['delete_url'] = $this->_redirect.'/delete/';
			$uploader['input_selector'] = "#file";
			$uploader['default_file'] = base_url().$this->uploadlist->site_img().'/'.$row['file'];


			$this->data['control']['upl'] = $this->load->view('back/parts/uploader',$uploader,TRUE);

			$this->load->view('js/ajaxupload');
			$this->load->view(Admin_Controller::$map .'/parts/add_with_upload',$this->data);

			$this->load->view(Admin_Controller::$map.'/parts/footer');
		}
	}

	/**
	* ajax upload
	*
	* @return
	*/
	public function upload()
	{
		$this->load->library('upload', $this->_config);

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
			echo json_encode([
					'url'=>base_url().$this->uploadlist->site_img().'/'.$upload_data['upload_data']['file_name'],
					'done'=>$upload_data['upload_data']['file_name']
				]);
		}

	}
	/**
	* ajax delete
	* @param string $filename
	*
	* @return
	*/

	public function delete($filename)
	{
		@ unlink($this->_config['upload_path'].'/'.$filename);
	}


	public function insert()
	{

		$this->_set_form_validation($this->_redirect.'/insert');



		if($this->form_validation->run() === TRUE)
		{
			$this->Crud->add($_POST,$this->_table);

			echo json_encode(['done'=>true]);
			return;
		}

		echo json_encode(['error'=>$this->form_validation->error_array()]);

	}

	public function trash($user_id = NULL)
	{
		if($user_id && $user_id > 0)
		{

			$query = $this->Crud->get_row(['id'=>$user_id],$this->_table);

			$this->Crud->delete(['id'=>$user_id],$this->_table);
			@ unlink($this->_config['upload_path'].'/'.$query['file']);

			// $this->session->set_flashdata('message', 'Users deleted line 152');
		}
		redirect($this->_redirect);
	}


	private function _set_form_validation($url  )
	{
		$this->data['title'] = lang('create_offer');

		$this->data['url'] = $url;

		$this->data['buttons'] = [
			'create_and_publish'=>$url,
		];

		$this->data['cancel'] = $this->_redirect;
		$this->form_validation->set_rules('status', lang('status'), 'trim|required|numeric');
		$this->form_validation->set_rules('file', lang('file'), 'trim|required');
	}



	private function _set_data($user = NULL)
	{
		$this->load->library("html/InputArray");



		$file_def = isset($user['file'])?$user['file']:NULL;
		$this->data['control']['file'] = form_input(
			$this->inputarray->getArray('file','hidden',lang("add_user_file"),$file_def,FALSE));


		$status = lang('pub_toogle');
		$this->data['control']["status_l"] = form_label(lang("status"));

		$this->data['control']['status'] = form_dropdown('status',
			[0=>$status[0],1=>$status[1]],1,['class'=>'form-control']);

	}


	public function ajax()
	{

		$query = $this->Crud->get_all( $this->_table,null,'order','asc');

		$this->load->library('html/toogle');

		$toog = $this->toogle->init(0,'status',$this->_table,$this->_table)->set_text(lang('pub_toogle')) ;


		$this->load->library("Uploadlist");
		$data['data'] = [];

		foreach($query as $table_row)
		{
			$row = [];

			array_push(
				$row,

				$table_row['order'],

				'<img width="80px" src="'.base_url().$this->uploadlist->site_img().'/'.$table_row['file'].'" alt="" />',

				$toog->set_flag($table_row['status'])->get($table_row['id']),

				$this->load->view("buttons/slideshow_order",[
						'title'=>$table_row['order'],
						'count'=>count($query),

						'application_id'=>$table_row['id']

					],true),

				$this->load->view("buttons/edit",['url'=>$this->_redirect.'/edit/'.$table_row['id']],true).
				$this->load->view("buttons/trash",['url'=>$this->_redirect.'/trash/'.$table_row['id']],true)


			);
			array_push($data['data'],$row);
		}


		echo json_encode($data);

	}

}
