<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {
	
	
	
	public function __construct(){
		parent::__construct();
	}
	
	
	public function index(){
		echo $this->ajax_model->exec($this->input->post());
	}
	
	

	
	
	
}
