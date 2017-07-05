<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
*
*
*/
class MY_Controller extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();		

		$this->site_name = 'AutoDent';
		
		//-------------HTML META---------------//
		$this->meta_title = '';
		$this->meta_desc = '';
		$this->meta_key = '';

		if( !$this->ion_auth->logged_in() && $this->uri->segment(1) != 'auth' )
		{
			redirect('/auth/login');
		}
		
		$this->curr_user = $this->user_model->getUsers(true);
		//$this->output->enable_profiler(TRUE);
		
	}
	
	
	
	
	/*
	*
	*
	* VIEW TEMPLATE
	*
	*/
	public function view($view, $data=array(), $returnHtml = false)
	{
		$data += array('view'=>$view);
		
		$html = $this->load->view('includes/template', $data, true);
		$html = preg_replace('|<!--(.*)-->|Uis','',$html);
		$html = preg_replace('|/\*(.*)\*/|Uis','/*--Hidden--*/',$html);
		$html = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $html);
		$html = preg_replace('|\t|',' ',$html);
		
		if($returnHtml) return $html;
		else $this->output->set_output($html);	
	}	
	
	

}