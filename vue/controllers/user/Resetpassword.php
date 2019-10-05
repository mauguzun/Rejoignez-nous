<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resetpassword extends User_Controller
{
    

    public function __construct()
    {
        parent::__construct('user/offers');
        $this->_user_id = $this->ion_auth->user()->row()->id;

    }

    public function index($id = null )
    {
		if (!$this->ion_auth->logged_in())
        redirect(base_url('auth'));


		$id = null;
        $user          = $this->ion_auth->user($id)->row();
        $groups        = $this->ion_auth->groups()->result_array();
        $currentGroups = $this->ion_auth->get_users_groups($id)->result();


       
        if (isset($_POST) && !empty($_POST)) {
          
            if (!$this->ion_auth->hash_password_db($user->id,  $this->input->post('old_password'))) {

                $this->session->set_flashdata('message', lang('password_change_wrong_old'));

            }
            else {

                // update the password if it was posted
                if ($this->input->post('password')) {
                    $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                    $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
                }

                if ($this->form_validation->run() === TRUE) {
                    $data = array(
                        'first_name'=> $this->input->post('first_name'),
                        'last_name' => $this->input->post('last_name'),
                        'company'   => $this->input->post('company'),
                        'phone'     => $this->input->post('phone'),
                    );

                    // update the password if it was posted
                    if ($this->input->post('password')) {
                        $data['password'] = $this->input->post('password');
                    }

                    // Only allow updating groups if user is admin
                    if ($this->ion_auth->is_admin()) {
                        // Update the groups user belongs to
                        $groupData = $this->input->post('groups');

                        if (isset($groupData) && !empty($groupData)) {

                            $this->ion_auth->remove_from_group('', $id);

                            foreach ($groupData as $grp) {
                                $this->ion_auth->add_to_group($grp, $id);
                            }

                        }
                    }

                    // check to see if we are updating the user
                    if ($this->ion_auth->update($user->id, $data)) {
                        // redirect them back to the admin page if admin, or to the base url if non admin
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                       // $this->redirectUser();

                    }
                    else {
                        // redirect them back to the admin page if admin, or to the base url if non admin
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        //$this->redirectUser();

                    }

                }


            }


        }

        // display the edit user form
        $this->data['csrf'] = 's';

        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        // pass the user to the view
        $this->data['user'] = $user;
        $this->data['groups'] = $groups;
        $this->data['currentGroups'] = $currentGroups;


        $this->data['old_password'] = array(
            'name'   => 'old_password',
            'id'     => 'password',
            'class'  =>'form-control',
            'require'=>'require',
            'type'   => 'password'
        );
        $this->data['password'] = array(
            'name'   => 'password',
            'class'  =>'form-control',
            'require'=>'require',
            'id'     => 'password',
            'type'   => 'password'
        );
        $this->data['password_confirm'] = array(
            'class'  =>'form-control',
            'require'=>'require',
            'name'   => 'password_confirm',
            'id'     => 'password_confirm',
            'type'   => 'password'
        );
        /**
        * ovverided by denis
        */



       
        $this->load->view('front_asl' . DIRECTORY_SEPARATOR . 'pass', $this->data);
      $this->show_footer();;
        // $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'edit_user', $this->data);
    }
	

}


