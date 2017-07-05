<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {
	
	
	
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		redirect('/auth/login');
	}

	
	public function login(){
		if($this->ion_auth->logged_in()){
			redirect('/');
		}
		
		$data = array();
		$data['message'] = $this->session->flashdata('message');
		if(strlen($data['message'])) $data['message'] = '<div class="alert alert-info text-center">'.strip_tags($data['message']).'</div>';
		
		$this->meta_title = 'Login';
		$this->emptyPage = 1; 
		self::view('login', $data);
	}
	
	
	public function logout()
	{
		$this->ion_auth->logout();
		redirect('/');
	}


	public function forgot_password()
	{
		if($this->ion_auth->logged_in()){
			redirect('/');
		}
		
		$data = array();
		$data['message'] = $this->session->flashdata('message');
		if(strlen($data['message'])) $data['message'] = '<div class="alert alert-info text-center">'.strip_tags($data['message']).'</div>';
		
		$this->meta_title = 'Forget Password?';
		$this->emptyPage = 1; 
		self::view('forgot_password', $data);
	}	
	
	// reset password - final step for forgotten password
	public function reset_password($code = NULL)
	{
		if($this->ion_auth->logged_in()){
			redirect('/');
		}
		
		if(!$code) show_404();


		$data = array('error'=>'');
		if(!$user = $this->ion_auth->forgotten_password_check($code)){
			$data['error'] = strip_tags($this->ion_auth->errors());
		}
		else{
			$this->load->helper('form_helper');
			$data['user_id'] = $user->id;
			$data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$data['csrf'] = $this->_get_csrf_nonce();
			$data['code'] = $code;
		}
		

		
		$this->meta_title = 'Change Password';
		$this->emptyPage = 1; 
		self::view('reset_password', $data);
	}
	
	
	
	
	public function registration()
	{
		if($this->ion_auth->logged_in()){
			redirect('/');
		}
		
		$data = array();
		$data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
		
		$this->meta_title = 'Sign Up';
		$this->emptyPage = 1; 
		self::view('registration', $data);
	}
	
	
	
	// activate the user
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
			// redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth", 'refresh');
		}
		else
		{
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}
	
	
		
	public function login_as_user($id){
		
		if( 
			!$this->user_model->in_group(['superadmin','dealer','manager']) 
			|| (!$user = $this->ion_auth->user($id)->row()) 
			|| !in_array($id,$this->user_model->getSubUserIDs())
		){
			show_404();
		}
		else{
			$this->ion_auth->set_session($user);
			redirect('dashboard');
		}
		
	}
	
	
	
	private function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	
	
	
	

	
	
}