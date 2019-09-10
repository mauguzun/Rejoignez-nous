<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// back / activity
class Resetpassword extends Shared_Controller
{
	private $data = [];
	private $_redirect ;

	private $_allowed = [1,2,3,4,5,6,7];




	public function __construct()
	{
		parent::__construct($this->_allowed);
		$this->_redirect = base_url().Shared_Controller::$map.'/resetpassword';
		$this->_ajax = base_url().'access/Hr_Admin';

	}


	public function index()
	{
		$id = $this->ion_auth->user()->row()->id;

		
		$this->show_header();

		$this->data['title'] = $this->lang->line('edit_user_heading');

		$user = $this->ion_auth->user($id)->row();

		// validate form input



		if(isset($_POST) && !empty($_POST)){
			// do we have a valid request?
			
			// update the password if it was posted
			if($this->input->post('password')){
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}
			
			if($this->form_validation->run() === TRUE){
				$data = [];
				// update the password if it was posted
				if($this->input->post('password')){
					$data['password'] = $this->input->post('password');
				}

				// Only allow updating groups if user is admin
				if($this->ion_auth->is_admin()){
					// Update the groups user belongs to
					$groupData = $this->input->post('groups');

					if(isset($groupData) && !empty($groupData)){

						$this->ion_auth->remove_from_group('', $id);

						foreach($groupData as $grp){
							$this->ion_auth->add_to_group($grp, $id);
						}

					}
				}

				// check to see if we are updating the user
				if($this->ion_auth->update($user->id, $data)){
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					

				}
				else
				{
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				
				}

			}
		

		}
	
		// display the edit user form
		

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		
		
		
		$this->load->library("html/InputArray");

		$this->data['control']['password'] = form_input(
			$this->inputarray->getArray('password','password',lang('password'),"",TRUE));
						
		$this->data['control']['password_confirm'] = form_input(
			$this->inputarray->getArray('password_confirm','password',lang('create_user_password_confirm_label'),"",TRUE));
		


		$this->data['title'] = $this->data['message'];
		$this->data['url'] = $this->_redirect;

		$this->data['buttons'] = [

			'create'=>$this->_redirect,
		];

		$this->load->view(Admin_Controller::$map .'/parts/add_modal_fixed',$this->data);

	//	$this->show_footer();;

	}
	public function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key=> $value);
	}

}
