<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Ajaxupload extends Apply_Controller{

	protected $table = 'application_files';

	public function __construct(){
		parent::__construct();
		$this->load->library('Uploadconfig');
		$this->user_id = (int)$this->ion_auth->user()->row()->id;
	}


	public function upload($application_id,$file){
		$this->load->library('upload', $this->uploadconfig->get("/".$file));
		if( ! $this->upload->do_upload('file')){
			echo json_encode(['error'=> lang($file)."   ".lang("error").'<br>'.$this->upload->display_errors()]);
		}
		else{
			$data = $this->upload->data();

			$id   = $this->Crud->add(
				[
					'file'=>$data['file_name'],
					'type'=>$file,
					'application_id'=>$application_id,
					'user_id'=>$this->user_id  ]

				,$this->table);

			$data = $this->upload->data();
			$data['result'] = img_div_new(
				base_url().'/'.$this->uploadconfig->get("/".$file)['upload_path'].'/'.$data['file_name'],$id,$data['file_name']);



			echo  json_encode (['upload_data'=> $data]);
		}
	}
	public function upload_vue($application_id,$file){
		
		$this->load->library('upload', $this->uploadconfig->get("/".$file));
		if( ! $this->upload->do_upload('file')){
			echo json_encode(['error'=> lang($file)."   ".lang("error").'<br>'.$this->upload->display_errors()]);
		}
		else{
			$data = $this->upload->data();

			$id   = $this->Crud->add(
				[
					'file'=>$data['file_name'],
					'type'=>$file,
					'application_id'=>$application_id,
					'user_id'=>$this->user_id  ]

				,$this->table);


			$data = $this->upload->data();
			
			$data['result'] = get_src($this->Crud->get_row(['id'=>$id],$this->table));
			$data['id']=$id;
			$data['name']=$data['file_name'];


			echo  json_encode (['upload_data'=> $data]);
		}
	}

	public function delete($id){
		
		$row = $this->Crud->get_row(['id'=>$id],$this->table);
		if($this->Crud->update(['id'=>$id],['deleted'=>1],$this->table)){
			
			$new_row = $row;
			$new_row['deleted'] = 1;
			  
			$this->savehistory($new_row['application_id'],$new_row,$row,'id',$id,$this->table,$scip = NULL);
			echo json_encode(['done'=> 'done']);
		}
		
		else 
		echo json_encode(['error'=> 'error_on_action']);
	
	}


	public function delete_file($id){
		$this->Crud->delete(['id'=>$id],'application_files');
		echo json_encode(['done'=> 'done']);
		
	}
}





