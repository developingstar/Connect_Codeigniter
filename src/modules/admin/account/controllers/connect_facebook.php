<?php
/*
 * Connect_facebook Controller
 */
class Connect_facebook extends MY_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();

		// Load the necessary stuff...
		$this->load->config('account/account');
		$this->load->helper(array( 'account/ssl'));
		$this->load->library(array('account/authentication', 'account/authorization', 'account/facebook_lib'));
		$this->load->model(array('account/account_model', 'account/account_facebook_model'));
	}

	function index()
	{
		// Enable SSL?
		maintain_ssl($this->config->item("ssl_enabled"));

		// Check if user is signed in on facebook
		if ($this->facebook_lib->user)
		{
			// Check if user has connect facebook to a3m
			if ($user = $this->account_facebook_model->get_by_facebook_id($this->facebook_lib->user['id']))
			{
				// Check if user is not signed in on a3m
				if ( ! $this->authentication->is_signed_in())
				{
					// Run sign in routine
					$this->authentication->sign_in($user->user_id);
				}

				$user->user_id === $this->session->userdata('user_id') ? $this->session->set_flashdata('linked_error', sprintf(lang('linked_linked_with_this_account'), lang('connect_facebook'))) : $this->session->set_flashdata('linked_error', sprintf(lang('linked_linked_with_another_account'), lang('connect_facebook')));
				redirect('account/account_linked');
			}
			// The user has not connect facebook to a3m
			else
			{
				// Check if user is signed in on a3m
				if ( ! $this->authentication->is_signed_in())
				{
					// Store user's facebook data in session
					$this->session->set_userdata('connect_create', array(array('provider' => 'facebook', 'provider_id' => $this->facebook_lib->user['id']), array('fullname' => $this->facebook_lib->user['name'], 'firstname' => $this->facebook_lib->user['first_name'], 'lastname' => $this->facebook_lib->user['last_name'], 'gender' => $this->facebook_lib->user['gender'], //'dateofbirth' => $this->facebook_lib->user['birthday'],	// not a required field, not all users have it set
						'picture' => 'http://graph.facebook.com/'.$this->facebook_lib->user['id'].'/picture/?type=large' // $this->facebook_lib->user['link']
						// $this->facebook_lib->user['bio']
						// $this->facebook_lib->user['timezone']
						// $this->facebook_lib->user['locale']
						// $this->facebook_lib->user['verified']
						// $this->facebook_lib->user['updated_time']
					)));

					// Create a3m account
					redirect('account/connect_create');
				}
				else
				{
					// Connect facebook to a3m
					$this->account_facebook_model->insert($this->session->userdata('user_id'), $this->facebook_lib->user['id']);
					$this->session->set_flashdata('linked_info', sprintf(lang('linked_linked_with_your_account'), lang('connect_facebook')));
					redirect('account/account_linked');
				}
			}
		}

		// Load facebook redirect view
		$this->load->view("account/redirect_fb");
	}

}

/* End of file connect_facebook.php */
/* Location: ./application/account/controllers/connect_facebook.php */
