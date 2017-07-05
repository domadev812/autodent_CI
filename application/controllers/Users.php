<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {


	public function __construct(){
		parent::__construct();	
		
		if(!$this->user_model->in_group(['superadmin','dealer','manager'])){
			redirect('dashboard');
		}
	}
	



	public function index()
	{
		

		
		$this->load->helper('text');
		
		$this->meta_title = 'User Management';		
		$data = array();
		
		$creator_ids = $this->curr_user->id;
		if($this->user_model->is_dealer()){
			$creator_ids = array_merge(
				[$this->curr_user->id],
				array_map(function($r){return $r->id;},$this->user_model->getUsersByGroup(['manager'],  $this->ion_auth->get_user_id()))
			);
		}
		

		
		$data['users'] = $this->user_model->getUsers(false, $creator_ids, 'UG.group_id');
		
		self::view('user_management', $data);
	}
	
}
