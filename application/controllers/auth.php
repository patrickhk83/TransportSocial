<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->load->helper('language');
	}

	//redirect if needed, otherwise display the user list
	function index()
	{

		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		elseif (!$this->ion_auth->is_admin()) //remove this elseif if you want to enable this for non-admins
		{
			//redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else
		{
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			//list the users
			$this->data['users'] = $this->ion_auth->users()->result();
			foreach ($this->data['users'] as $k => $user)
			{
				$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}

			$this->template->write_view('content', 'auth/index', $this->data);
			$this->template->render();
		}
	}

	//log the user in
	function login()
	{
		$this->template->write('title','Login');

		//validate form input
		$this->form_validation->set_rules('identity', 'Identity', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == true)
		{
			//check to see if the user is logging in
			//check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('/');
			}
			else
			{
				//if the login was un-successful
				//redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/login'); //use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{
			//the user is not logging in so display the login page
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['identity'] = array('name' => 'identity',
				'id' => 'identity',
				'class' => 'form-control',
				'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$this->data['password'] = array('name' => 'password',
				'id' => 'password',
				'class' => 'form-control',
				'type' => 'password',
			);
			$this->load->model('Useropt_Model' , 'useropt');
			$this->data['countries'] = $this->useropt->get_countries();
			$this->data['controller_name'] = strtolower(get_class());
			$this->template->add_css('assets/css/signup.css');
			$this->template->add_css('assets/css/datepicker.css');
			$this->template->add_css('assets/css/jquery.fileupload.css');
			$this->template->add_css('assets/css/jquery.fileupload-ui.css');
			$this->template->add_js('assets/js/bootstrap-datepicker.js');
			$this->template->add_js('assets/js/jquery.form.js');
			$this->template->add_js('assets/js/jquery.validate.min.js');
			$this->template->add_js('assets/js/manageuser.js');
			$this->template->add_js('assets/js/modal.js');
			$this->template->write_view('content', 'auth/login', $this->data);
			$this->template->render();
		}
	}

	//log the user out
	function logout()
	{
		$this->data['title'] = "Logout";

		//log the user out
		$logout = $this->ion_auth->logout();

		//redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('auth/login', 'refresh');
	}

	//change password
	function change_password()
	{
		$this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
		$this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}

		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() == false)
		{
			//display the form
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$this->data['old_password'] = array(
				'name' => 'old',
				'id'   => 'old',
				'type' => 'password',
			);
			$this->data['new_password'] = array(
				'name' => 'new',
				'id'   => 'new',
				'type' => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
			);
			$this->data['new_password_confirm'] = array(
				'name' => 'new_confirm',
				'id'   => 'new_confirm',
				'type' => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
			);
			$this->data['user_id'] = array(
				'name'  => 'user_id',
				'id'    => 'user_id',
				'type'  => 'hidden',
				'value' => $user->id,
			);

			//render
			$this->template->write_view('content', 'auth/change_password', $this->data);
			$this->template->render();
		}
		else
		{
			$identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change)
			{
				//if the password was successfully changed
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->logout();
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/change_password', 'refresh');
			}
		}
	}

	//forgot password
	function forgot_password()
	{
		$this->form_validation->set_rules('email', $this->lang->line('forgot_password_validation_email_label'), 'required');
		if ($this->form_validation->run() == false)
		{
			//setup the input
			$this->data['email'] = array('name' => 'email',
				'id' => 'email',
			);

			if ( $this->config->item('identity', 'ion_auth') == 'username' ){
				$this->data['identity_label'] = $this->lang->line('forgot_password_username_identity_label');
			}
			else
			{
				$this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
			}

			//set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->template->write_view('content', 'auth/forgot_password', $this->data);
			$this->template->render();
		}
		else
		{
			// get identity for that email
            $identity = $this->ion_auth->where('email', strtolower($this->input->post('email')))->users()->row();
            if(empty($identity)) {
                $this->ion_auth->set_message('forgot_password_email_not_found');
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("auth/forgot_password", 'refresh');
            }

			//run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			if ($forgotten)
			{
				//if there were no errors
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("auth/forgot_password", 'refresh');
			}
		}
	}

	//reset password - final step for forgotten password
	public function reset_password($code = NULL)
	{
		if (!$code)
		{
			show_404();
		}

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user)
		{
			//if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

			if ($this->form_validation->run() == false)
			{
				//display the form

				//set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$this->data['new_password'] = array(
					'name' => 'new',
					'id'   => 'new',
					'type' => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['new_password_confirm'] = array(
					'name' => 'new_confirm',
					'id'   => 'new_confirm',
					'type' => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['user_id'] = array(
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->id,
				);
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;

				//render
				$this->template->write_view('content', 'auth/reset_password', $this->data);
				$this->template->render();

			}
			else
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id'))
				{

					//something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($code);

					show_error($this->lang->line('error_csrf'));

				}
				else
				{
					// finally change the password
					$identity = $user->{$this->config->item('identity', 'ion_auth')};

					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

					if ($change)
					{
						//if the password was successfully changed
						$this->session->set_flashdata('message', $this->ion_auth->messages());
						$this->logout();
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect('auth/reset_password/' . $code, 'refresh');
					}
				}
			}
		}
		else
		{
			//if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}


	//activate the user
	function activate($id, $code=false)
	{
		if ($code !== false)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation)
		{
			//redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth", 'refresh');
		}
		else
		{
			//redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}

	//deactivate the user
	function deactivate($id = NULL)
	{
		$id = $this->config->item('use_mongodb', 'ion_auth') ? (string) $id : (int) $id;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
		$this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

		if ($this->form_validation->run() == FALSE)
		{
			// insert csrf check
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['user'] = $this->ion_auth->user($id)->row();

			$this->template->write_view('content', 'auth/deactivate_user', $this->data);
			$this->template->render();
		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_error($this->lang->line('error_csrf'));
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
				}
			}

			//redirect them back to the auth page
			redirect('auth', 'refresh');
		}
	}

	//create a new user
	function create_user()
	{
		$this->data['title'] = "Create User";

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		//validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required|xss_clean');
		$this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required|xss_clean');
		$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
		$this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'required|xss_clean');
		$this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'required|xss_clean');
		$this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

		if ($this->form_validation->run() == true)
		{
			$username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
			$email    = strtolower($this->input->post('email'));
			$password = $this->input->post('password');

			$additional_data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name'  => $this->input->post('last_name'),
				'company'    => $this->input->post('company'),
				'phone'      => $this->input->post('phone'),
			);
		}
		if ($this->form_validation->run() == true && $this->ion_auth->register($username, $password, $email, $additional_data))
		{
			//check to see if we are creating the user
			//redirect them back to the admin page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth", 'refresh');
		}
		else
		{
			//display the create user form
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['first_name'] = array(
				'name'  => 'first_name',
				'id'    => 'first_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('first_name'),
			);
			$this->data['last_name'] = array(
				'name'  => 'last_name',
				'id'    => 'last_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('last_name'),
			);
			$this->data['email'] = array(
				'name'  => 'email',
				'id'    => 'email',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('email'),
			);
			$this->data['company'] = array(
				'name'  => 'company',
				'id'    => 'company',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('company'),
			);
			$this->data['phone'] = array(
				'name'  => 'phone',
				'id'    => 'phone',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('phone'),
			);
			$this->data['password'] = array(
				'name'  => 'password',
				'id'    => 'password',
				'type'  => 'password',
				'value' => $this->form_validation->set_value('password'),
			);
			$this->data['password_confirm'] = array(
				'name'  => 'password_confirm',
				'id'    => 'password_confirm',
				'type'  => 'password',
				'value' => $this->form_validation->set_value('password_confirm'),
			);

			$this->template->write_view('content', 'auth/create_user', $this->data);
			$this->template->render();
		}
	}

	//edit a user
	function edit_user($id)
	{
		$this->data['title'] = "Edit User";

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		$user = $this->ion_auth->user($id)->row();
		$groups=$this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();

		//validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required|xss_clean');
		$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required|xss_clean');
		$this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required|xss_clean');
		$this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required|xss_clean');
		$this->form_validation->set_rules('groups', $this->lang->line('edit_user_validation_groups_label'), 'xss_clean');

		if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			{
				show_error($this->lang->line('error_csrf'));
			}

			$data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name'  => $this->input->post('last_name'),
				'company'    => $this->input->post('company'),
				'phone'      => $this->input->post('phone'),
			);

			//Update the groups user belongs to
			$groupData = $this->input->post('groups');

			if (isset($groupData) && !empty($groupData)) {

				$this->ion_auth->remove_from_group('', $id);

				foreach ($groupData as $grp) {
					$this->ion_auth->add_to_group($grp, $id);
				}

			}

			//update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');

				$data['password'] = $this->input->post('password');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$this->ion_auth->update($user->id, $data);

				//check to see if we are creating the user
				//redirect them back to the admin page
				$this->session->set_flashdata('message', "User Saved");
				redirect("auth", 'refresh');
			}
		}

		//display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();

		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		//pass the user to the view
		$this->data['user'] = $user;
		$this->data['groups'] = $groups;
		$this->data['currentGroups'] = $currentGroups;

		$this->data['first_name'] = array(
			'name'  => 'first_name',
			'id'    => 'first_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('first_name', $user->first_name),
		);
		$this->data['last_name'] = array(
			'name'  => 'last_name',
			'id'    => 'last_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('last_name', $user->last_name),
		);
		$this->data['company'] = array(
			'name'  => 'company',
			'id'    => 'company',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('company', $user->company),
		);
		$this->data['phone'] = array(
			'name'  => 'phone',
			'id'    => 'phone',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('phone', $user->phone),
		);
		$this->data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'type' => 'password'
		);
		$this->data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'type' => 'password'
		);

		$this->template->write_view('content', 'auth/edit_user', $this->data);
		$this->template->render();
	}

	// create a new group
	function create_group()
	{
		$this->data['title'] = $this->lang->line('create_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		//validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash|xss_clean');
		$this->form_validation->set_rules('description', $this->lang->line('create_group_validation_desc_label'), 'xss_clean');

		if ($this->form_validation->run() == TRUE)
		{
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
			if($new_group_id)
			{
				// check to see if we are creating the group
				// redirect them back to the admin page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth", 'refresh');
			}
		}
		else
		{
			//display the create group form
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['group_name'] = array(
				'name'  => 'group_name',
				'id'    => 'group_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('group_name'),
			);
			$this->data['description'] = array(
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('description'),
			);

			$this->template->write_view('content', 'auth/create_group', $this->data);
			$this->template->render();
		}
	}

	//edit a group
	function edit_group($id)
	{
		// bail if no group id given
		if(!$id || empty($id))
		{
			redirect('auth', 'refresh');
		}

		$this->data['title'] = $this->lang->line('edit_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		$group = $this->ion_auth->group($id)->row();

		//validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash|xss_clean');
		$this->form_validation->set_rules('group_description', $this->lang->line('edit_group_validation_desc_label'), 'xss_clean');

		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{
				$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

				if($group_update)
				{
					$this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
				redirect("auth", 'refresh');
			}
		}

		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		//pass the user to the view
		$this->data['group'] = $group;

		$this->data['group_name'] = array(
			'name'  => 'group_name',
			'id'    => 'group_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_name', $group->name),
		);
		$this->data['group_description'] = array(
			'name'  => 'group_description',
			'id'    => 'group_description',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_description', $group->description),
		);

		$this->template->write_view('content', 'auth/edit_group', $this->data);
		$this->template->render();
	}


	function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
			$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}


/**
 * Registration New User
*/
	function signup_user()
	{
/*
		$person_id = $this->input->post('person_id');
		if($person_id != 0 || $person_id != '')
		{
			if (!$this->ion_auth->logged_in())
			{
				redirect('auth', 'refresh');
			}
		}
*/
/*
		if ($this->ion_auth->logged_in())
		{
			//redirect('auth', 'refresh');
			echo json_encode(array('success'=>false ,
					'message'=>lang('create_user_error_adding_updating').' '.
					$$this->input->post('fname').' '.$this->input->post('lname')));
			return;
		}
*/
		$this->load->helper(array('form' , 'url'));
		$this->load->library('form_validation');
		//$this->lang->load('auth_lang' , 'english');
		$this->form_validation->set_rules('fname', $this->lang->line('create_user_validation_fname_label'), 'required|xss_clean');
		$this->form_validation->set_rules('lname', $this->lang->line('create_user_validation_lname_label'), 'required|xss_clean');
		$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
		$this->form_validation->set_rules('country', $this->lang->line('create_user_validation_phone_label'), 'required|xss_clean');

//		$this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
//		$this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

		if ($this->form_validation->run() == TRUE)
		{
			$username = strtolower($this->input->post('fname')).' '.strtolower($this->input->post('lname'));

			$email    = strtolower($this->input->post('email'));

			$password = $this->input->post('passwords');
			$default_photo = $this->input->post('radio1');
			//$default_photo = 1;
			$additional_data = array(
				'first_name' => $this->input->post('fname'),
				'last_name'  => $this->input->post('lname'),
				'company'    => $this->input->post('occupation'),
				'phone'      => $this->input->post('phone'),
				'country' => $this->input->post('country'),
				'birthday' => $this->input->post('birthday'),
				'about_me' => $this->input->post('about_me'),
				'hobbies' => $this->input->post('hobbies'),
				'musics' => $this->input->post('musics'),
				'movies' => $this->input->post('movies'),
				'books' => $this->input->post('books')
			);
		}

		if ($this->form_validation->run() == TRUE && $id = $this->ion_auth->register($username, $password, $email, $additional_data))
		{
			//check to see if we are creating the user
			//redirect them back to the admin page
			//$this->session->set_flashdata('message', $this->ion_auth->messages());
			//echo json_encode(array('success'=>true , 'message'=>$this->ion_auth->message()));
			$config['upload_path'] = "./assets/images/photos";
			$config['allowed_types'] = "gif|jpg|png";
			$config['max_width'] = '1920';
			$config['max_height'] = '1080';
			$config['remove_spaces'] = TRUE;
			$config['encrypt_name'] = TRUE;
			$config['file_name'] = "aa";
			$this->load->library('upload' , $config);

			$field_name = "files1";
			$this->upload->do_upload($field_name);
			$upload_data1 = $this->upload->data();

			$config['upload_path'] = "./assets/images/photos";
			$config['allowed_types'] = "gif|jpg|png";
			$config['max_width'] = '1920';
			$config['max_height'] = '1080';
			$config['remove_spaces'] = TRUE;
			$config['encrypt_name'] = TRUE;
			$config['file_name'] = "aa";
			$this->upload->initialize($config);

			$field_name = "files2";
			$this->upload->do_upload($field_name);
			$upload_data2 = $this->upload->data();



			$config['upload_path'] = "./assets/images/photos";
			$config['allowed_types'] = "gif|jpg|png";
			$config['max_width'] = '1920';
			$config['max_height'] = '1080';
			$config['remove_spaces'] = TRUE;
			$config['encrypt_name'] = TRUE;
			$config['file_name'] = "aa";
			$this->upload->initialize($config);

			$field_name = "files3";
			$this->upload->do_upload($field_name);
			$upload_data3 = $this->upload->data();



			$config['upload_path'] = "./assets/images/photos";
			$config['allowed_types'] = "gif|jpg|png";
			$config['max_width'] = '1920';
			$config['max_height'] = '1080';
			$config['remove_spaces'] = TRUE;
			$config['encrypt_name'] = TRUE;
			$config['file_name'] = "aa";
			$this->upload->initialize($config);

			$field_name = "files4";
			$this->upload->do_upload($field_name);
			$upload_data4 = $this->upload->data();



			$config['upload_path'] = "./assets/images/photos";
			$config['allowed_types'] = "gif|jpg|png";
			$config['max_width'] = '1920';
			$config['max_height'] = '1080';
			$config['remove_spaces'] = TRUE;
			$config['encrypt_name'] = TRUE;
			$config['file_name'] = "aa";
			$this->upload->initialize($config);

			$field_name = "files5";
			$this->upload->do_upload($field_name);
			$upload_data5 = $this->upload->data();

			if($upload_data1['raw_name'] == "aa") $photo1 = $upload_data1['raw_name'];
			else $photo1 = $upload_data1['raw_name'].$upload_data1['file_ext'];

			if($upload_data2['raw_name'] == "aa") $photo2 = $upload_data2['raw_name'];
			else $photo2 = $upload_data2['raw_name'].$upload_data2['file_ext'];

			if($upload_data3['raw_name'] == "aa") $photo3 = $upload_data3['raw_name'];
			else $photo3 = $upload_data3['raw_name'].$upload_data3['file_ext'];

			if($upload_data4['raw_name'] == "aa") $photo4 = $upload_data4['raw_name'];
			else $photo4 = $upload_data4['raw_name'].$upload_data4['file_ext'];

			if($upload_data5['raw_name'] == "aa") $photo5 = $upload_data5['raw_name'];
			else $photo5 = $upload_data5['raw_name'].$upload_data5['file_ext'];

			//$this->photos_db($id , $photo1 , $photo2 , $photo3 , $photo4 , $photo5 , $default_photo);
			$save_data = array(
					'user_id' => $id,
					'photo1' => $photo1,
					'photo2' => $photo2,
					'photo3' => $photo3,
					'photo4' => $photo4,
					'photo5' => $photo5,
					'default_character' => $default_photo
			);

			//		$this->load->model('Useropt' , 'useropt');
			$this->load->model('Useropt_Model' , 'useropt');

			if($this->useropt->photos_db($save_data))
				echo json_encode(array('success'=>true , 'message'=> $this->lang->line('create_user_successful_adding')));

		}
		else
		{
			//display the create user form
			//set the flash data error message if there is one
			//$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			//echo json_encode(array('success'=>true ,
			//		'message'=>(validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')))));
			//echo json_encode(array('success' => false , 'message' => (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : "Unknown error."))));
			echo json_encode(array('success'=>false , 'message'=>(validation_errors() ? validation_errors() : $this->lang->line('create_user_error_adding_updating'))));
		}

	}



/**
 * Register in the users_photos of db
 */
	function photos_db($user_id , $data1 , $data2 , $data3 , $data4 , $data5 , $default)
	{
		if($default < 1) $default = 1;
		$save_data = array(
			'user_id' => $user_id,
			'photo1' => $data1,
			'photo2' => $data2,
			'photo3' => $data3,
			'photo4' => $data4,
			'photo5' => $data5,
			'default_character' => $default
		);

		$this->load->model('Useropt_Model' , 'useropt');
		//$this->load->model('Airport_Model' , 'airport');
		return $this->useropt->photos_db($save_data);

	}


	public function profile($user_id)
	{
		if(isset($this->user->id) && $this->user->id == $user_id)
		{
			$this->load->model('Useropt_Model' , 'useropt');

			$data['countries'] = $this->useropt->get_countries();
			$data['controller_name'] = strtolower(get_class());
			$user_data = $this->useropt->get_user_info($user_id);
			$data['user_data'] = $user_data;
			$data['country'] = $this->useropt->get_user_country_name($user_data->country);
			$photo = $this->useropt->get_photo_name($user_id);

			if($photo->photo1 == "aa") $data['photo1'] = base_url('assets/images/default-profile-pic.png');
			else $data['photo1'] = base_url("assets/images/photos/")."/".$photo->photo1;

			if($photo->photo2 == "aa") $data['photo2'] = base_url('assets/images/default-profile-pic.png');
			else $data['photo2'] = base_url("assets/images/photos/")."/".$photo->photo2;

			if($photo->photo3 == "aa") $data['photo3'] = base_url('assets/images/default-profile-pic.png');
			else $data['photo3'] = base_url("assets/images/photos/")."/".$photo->photo3;

			if($photo->photo4 == "aa") $data['photo4'] = base_url('assets/images/default-profile-pic.png');
			else $data['photo4'] = base_url("assets/images/photos/")."/".$photo->photo4;

			if($photo->photo5 == "aa") $data['photo5'] = base_url('assets/images/default-profile-pic.png');
			else $data['photo5'] = base_url("assets/images/photos/")."/".$photo->photo5;

			switch($photo->default_character)
			{
				case 1:
					$data['default_character'] = $data['photo1'];
					break;
				case 2:
					$data['default_character'] = $data['photo2'];
					break;
				case 3:
					$data['default_character'] = $data['photo3'];
					break;
				case 4:
					$data['default_character'] = $data['photo4'];
					break;
				case 5:
					$data['default_character'] = $data['photo5'];
					break;
			}
			$this->template->add_css('assets/css/signup.css');
			$this->template->add_css('assets/css/datepicker.css');
			$this->template->add_css('assets/css/jquery.fileupload.css');
			$this->template->add_css('assets/css/jquery.fileupload-ui.css');
			$this->template->add_css('assets/js/fancybox/jquery.fancybox-1.3.4.css');

			$this->template->add_js('assets/js/fancybox/jquery.fancybox-1.3.4.js');
			$this->template->add_js('assets/js/bootstrap-datepicker.js');
			$this->template->add_js('assets/js/jquery.form.js');
			$this->template->add_js('assets/js/jquery.validate.min.js');
			$this->template->add_js('assets/js/manageuser.js');
			$this->template->add_js('assets/js/modal.js');
			$this->template->write_view('content', 'auth/profile', $data);
			$this->template->render();
		}
		else redirect("/");
	}


	public function get_user_dialog_info()
	{
		$person_id = $this->input->post('person_id');
		$this->load->model('Useropt_Model' , 'useropt');
		$results = $this->useropt->get_user_info($person_id);
		$result_photos = $this->useropt->get_user_photos($person_id);
		if($result_photos->photo1 == "aa") $photo1 = base_url("assets/images/default-profile-pic.png");
		else $photo1 = base_url("assets/images/photos/$result_photos->photo1");

		if($result_photos->photo2 == "aa") $photo2 = base_url("assets/images/default-profile-pic.png");
		else $photo2 = base_url("assets/images/photos/$result_photos->photo2");

		if($result_photos->photo3 == "aa") $photo3 = base_url("assets/images/default-profile-pic.png");
		else $photo3 = base_url("assets/images/photos/$result_photos->photo3");

		if($result_photos->photo4 == "aa") $photo4 = base_url("assets/images/default-profile-pic.png");
		else $photo4 = base_url("assets/images/photos/$result_photos->photo4");

		if($result_photos->photo5 == "aa") $photo5 = base_url("assets/images/default-profile-pic.png");
		else $photo5 = base_url("assets/images/photos/$result_photos->photo5");

		$data = array();

		$data[] = $results->first_name;
		$data[] = $results->last_name;
		$data[] = $results->email;
		$data[] = $results->country;
		$data[] = $results->birthday;
		$data[] = $results->company;
		$data[] = $results->about_me;
		$data[] = $results->hobbies;
		$data[] = $results->musics;
		$data[] = $results->movies;
		$data[] = $results->books;
		$data[] = $photo1;
		$data[] = $photo2;
		$data[] = $photo3;
		$data[] = $photo4;
		$data[] = $photo5;

		echo json_encode($data);

	}


}
