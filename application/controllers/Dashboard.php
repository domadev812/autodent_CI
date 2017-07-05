<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function __construct(){
		parent::__construct();
		
		if($this->user_model->in_group(['superadmin'])){
			redirect('users');
		}
		
		$this->meta_title = 'Dashboard';
		$this->load->library('Auto_calendar');
		
		$this->opt = new stdClass;
		$this->opt->dash_interval = $this->input->cookie('dash_interval') ? $this->input->cookie('dash_interval', true) : 'month';
		$this->opt->dash_date = $this->input->cookie('dash_date') ? $this->input->cookie('dash_date', true) : date('Y-m-d');
		$this->opt->dash_prev = null;
		$this->opt->dash_next = null;
	}


	public function index()
	{
		$data = $this->_check_opt();
		self::view('dashboard',$data);
	}
	
	public function search(){
		$q = $this->input->get('query');
		if(strlen($q)){
			echo json_encode($this->customers_model->search($q));
		}
	}
	
	
	private function _get_prev(){	
		return date('Y-m-d', strtotime($this->opt->dash_date.' - 1 '.$this->opt->dash_interval));
	}	
	
	private function _get_next(){
		return date('Y-m-d', strtotime($this->opt->dash_date.' + 1 '.$this->opt->dash_interval));
	}
	
	private function _check_opt(){
		
		$data = [];
		foreach($this->opt as $key => $value){
			if($this->input->post($key)){
				$this->input->set_cookie([
				    'name'   => $key,
				    'value'  => $this->input->post($key, true),
				    'expire'  => 0,
			    ]);
			    $this->opt->{$key} = $this->input->post($key, true);
			}					
		}

		$this->opt->dash_prev = $this->_get_prev();
		$this->opt->dash_next = $this->_get_next();
		
		foreach($this->opt as $key => $value){$data[$key] = $this->opt->{$key};}
		$data['calendar'] = new Auto_calendar($data['dash_date']);
		return $data;
	}
	
}
