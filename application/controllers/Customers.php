<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends MY_Controller {

	
	public function __construct(){
		parent::__construct();
		
		if($this->user_model->in_group(['superadmin'])){
			redirect('users');
		}
	}
	
	
	
	public function index()
	{
		$this->meta_title = 'Customers';
		self::view('customers');
	}
	
	
	public function get($id){
		$this->_checkAccess($id);
		if(!$user = $this->customers_model->getById($id)) show_404();
		
		$user->files = $this->customers_model->getFiles($id);
		$user->activity = $this->customers_model->getActivity($id);
		$data['user'] = $user;

		self::view('customers',$data);
	}
	
	
	public function upload($customer_id){
 		
		$this->_checkAccess($customer_id);
		
		$code=404; $data=null;
		#--
		$dir = $_SERVER['DOCUMENT_ROOT']."/uploads/customer/$customer_id";
		if(!is_dir($dir)){
			mkdir($dir);
		}
		
		$config['upload_path'] = $dir;
		$config['allowed_types'] = '*';
		$config['encrypt_name']	= true;
		$this->load->library('upload', $config);
		#--
		if(!$this->upload->do_upload('file'))
			$data = strip_tags($this->upload->display_errors());		
		else{
			$code=200;
			$data = (object) $this->upload->data();
			#--
			$this->db->insert('appointments_files', ['customer_id'=>$customer_id, 'filename'=>$data->file_name, 'orig_name' => $data->orig_name]);
		}
		#--
		$out = array('code'=>$code, 'data'=>$data);
		echo json_encode($out);
	    
	}
	
	
	public function delete_file($id, $customer_id){
		
		$this->_checkAccess($customer_id);
		
		$where = ['id'=>$id,'customer_id'=>$customer_id];
		if($row = $this->db->get_where('appointments_files', $where)->row()){
			@unlink($_SERVER['DOCUMENT_ROOT'].'/uploads/customer/'.$customer_id.'/'.$row->filename);
			$this->db->delete('appointments_files', $where);
			redirect('customers/get/'.$customer_id);
		}
	}
	
	
	
	
	private function _checkAccess($customer_id){
		$IDs = $this->customers_model->getAllowedIDs();
		if(!in_array($customer_id, $IDs)){
			print_r($IDs);
			exit('Access Denied');
		}	
	}
	
	
}
