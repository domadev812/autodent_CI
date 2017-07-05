<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Ajax_model extends CI_Model
{
	private $code;
	private $body;
	private $meta;
	private $error;
	private $js;
	
	public function __construct(){
		parent::__construct();
		$this->_reset();
	}

	public function exec($post){
		$this->_reset();
		foreach($post as $k => &$v) 
			if(is_array($v)){
				foreach($v as &$e) $e = trim($e);
			} 
			elseif(!strlen(trim($v))) unset($post[$k]);
			else $v = trim($v);
		#---
		$method = @trim($post['function']);
		unset($post['function']);
		if(!method_exists($this, $method)){
			$this->code = 404;
			$this->error = "function not found '$method'";
		}
		else $this->{$method}($post);
		return $this->_getJSON();
	}
	
	
	

	
	
	
	//~~~~~~~~~~~~~FUNCTIONS START~~~~~~~~~~~~~//
	
	private function login($args){
		
		$this->load->library('form_validation');
		$this->load->helper('language');
		$this->lang->load('auth');
		
		//validate form input
		$this->form_validation->set_rules('identity', 'Identity', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == true)
		{
			$remember = (bool) @$args['remember'];

			if ($this->ion_auth->login($args['identity'], $args['password'], $remember))
			{
				$this->code = 200;
				$this->js = 'window.location.reload();';
			}
			else
			{
				$this->error = $this->ion_auth->errors();
			}
		}
		else
		{
			$this->error = validation_errors();
		}
	}

	private function forgot_password($args){
		
		$this->load->library('form_validation');
		$this->load->helper('language');
		$this->lang->load('auth');
		
		// setting validation rules by checking wheather identity is username or email
		if($this->config->item('identity', 'ion_auth') != 'email' )
		{
		   $this->form_validation->set_rules('identity', 'Username', 'required');
		}
		else
		{
		   $this->form_validation->set_rules('identity', 'Email', 'required|valid_email');
		}
		
		
		if ($this->form_validation->run() == false)
		{
			$this->error = validation_errors();
		}
		else
		{
			$identity_column = $this->config->item('identity','ion_auth');
			$identity = $this->ion_auth->where($identity_column, $args['identity'])->users()->row();

			if(empty($identity)) {

        		if($this->config->item('identity', 'ion_auth') != 'email')
            	{
            		$this->ion_auth->set_error('forgot_password_identity_not_found');
            	}
            	else
            	{
            	   $this->ion_auth->set_error('forgot_password_email_not_found');
            	}

                $this->error = $this->ion_auth->errors(); 
                return;
            }

			// run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			if ($forgotten)
			{
				// if there were no errors
				$this->code = 200;
				$this->body = $this->ion_auth->messages();
				$this->js = '$("input[type=email]").val("");';
			}
			else
			{
				$this->error = $this->ion_auth->errors();
			}
		}
		
	}

	private function reset_password($args){

		$this->load->library('form_validation');
		$this->load->helper('language');
		$this->lang->load('auth');
		
		$user = $this->ion_auth->forgotten_password_check($args['code']);
		if ($user)
		{
			$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

			if ($this->form_validation->run() == false)
			{
				$this->error = strip_tags(validation_errors());
			}
			else
			{
				// do we have a valid request?
				if ($user->id != $args['user_id'])
				{

					// something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($args['code']);

					$this->error = $this->lang->line('error_csrf');

				}
				else
				{
					// finally change the password
					$identity = $user->{$this->config->item('identity', 'ion_auth')};

					$change = $this->ion_auth->reset_password($identity, $args['new']);

					if ($change)
					{
						// if the password was successfully changed
						$this->code = 200;
						$this->body = $this->ion_auth->messages();
						$this->js = '$("input[type=password]").val("");setTimeout(function(){window.location.href = "/auth/login"},5000);';
					}
					else
					{
						$this->error = $this->ion_auth->errors();
					}
				}
			}
			
			
		}
		else{
			$this->error = strip_tags($this->ion_auth->errors());
		}
	}

	private function registration($args){
		
		
		//$this->_check_access(['superadmin', 'dealer','manager']);
		
		$creator_id = @intval($args['creator_id']);
		$group = @$this->user_model->get_group($args['group_id']);
		
		
		if($this->ion_auth->logged_in() && !$group){
			$this->error = '<p>The Group field is required.</p>';
			return;
		}
		#---
		
		
		
		$this->load->library('form_validation');
		$this->load->helper('language');
		$this->lang->load('auth');
		
		$tables = $this->config->item('tables','ion_auth');
        $identity_column = $this->config->item('identity','ion_auth');

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        if($identity_column!=='email')
        {
            $this->form_validation->set_rules('identity',$this->lang->line('create_user_validation_identity_label'),'required|is_unique['.$tables['users'].'.'.$identity_column.']');
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
        }
        else
        {
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }
        
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
        $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() == true)
        {
            $email    = strtolower($this->input->post('email'));
            $identity = ($identity_column==='email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'company'    => $this->input->post('company'),
                'phone'      => $this->input->post('phone'),
            );
            if($identity_column == 'email') $additional_data['username'] = preg_replace(array('|[^a-z\.\d]+|i','|\.+|'),array('','.'),strtolower($this->input->post('first_name').'.'.$this->input->post('last_name')));
        }
        
        if ($this->form_validation->run() == true && ($user_id = $this->ion_auth->register($identity, $password, $email, $additional_data)))
        {
            

            // check to see if we are creating the user
            $this->code = 200;
            $this->body = $this->ion_auth->messages();
            $this->js = '$("input").val("");setTimeout(function(){window.location.href = "/auth/login"},5000);';
            
            
            if($this->ion_auth->logged_in()){
	            $this->user_model->setUserRelations($creator_id ? $creator_id : $this->ion_auth->get_user_id(), $user_id);
	            //Update the group user belongs to
				if($group->id) {
					$this->ion_auth->remove_from_group('', $user_id);
					$this->ion_auth->add_to_group($group->id, $user_id);
				}				
			}
			elseif($sID = $this->user_model->getSuperadminID()){
				 $this->user_model->setUserRelations($sID, $user_id);
			}
            
            
        }
        else
        {
            // set the error message if there is one
            $this->error = validation_errors() ? validation_errors() : $this->ion_auth->errors();
        }
		
		
	}
	
	private function update_user($args){
	
		$id = @intval($args['id']); unset($args['id']);
		$user = $this->user_model->getUsers($id);
		
		$this->code = 200;
		
		$this->meta = new stdClass;
		$this->meta->modal_title = 'Add New';
		
		$this->meta->id = @$user->id;
		$this->meta->group_id = @$user->group_id;
		$this->meta->first_name = @$user->first_name;
		$this->meta->last_name = @$user->last_name;
		$this->meta->email = @$user->email;
		$this->meta->creator_id = @$user->creator_id;
				

		if($user){
			$this->meta->modal_title = 'Update';
			
			if(!empty($args)){
				$res = $this->user_model->updateUser($id, $args);
				$this->code = $res->code;
				#--
				if($this->code == 200){
					$this->body = $res->msg;
					$this->js = 'setTimeout(function(){window.location.reload();},2000);';
				}
				else{
					$this->error = $res->msg; 
				} 
				
				
			}

		}else{
			$this->code = 0;
			#--
			$this->config->config['ion_auth']['email_activation'] = false;
			$this->registration($args);
			$this->js = 'setTimeout(function(){window.location.reload();},2000);';
		}
	}
	
	private function delete_user($args){
		$id = @intval($args['id']);
		$current_id = $this->ion_auth->get_user_id();
		if($id && $id != $current_id && $this->ion_auth->is_admin())
			if($this->ion_auth->delete_user($id)){
				$this->code = 200;
				$this->body = $this->ion_auth->messages();
				$this->js = 'setTimeout(function(){window.location.reload();},2000);';
				return;
			}
			
		$this->error = $id == $current_id ? 'You can\'t delete yourself!' : $this->ion_auth->errors();
	}
	
	
	
	
	
	
	
	private function add_customer($args){
		
		if($id = $this->customers_model->add($args)){
			$this->code = 200;
			$this->body = $id;
		}else{
			$this->error = "Customer with same name already exists";
		}
	}
	
	
	private function add_schedule($args){
		
		if($id = $this->customers_model->addSchedule($args)){
			$this->code = 200;
			$this->body = $id;
		}
	}	
	
	private function delete_schedule($args){
		$id = @intval($args['id']);
		$this->db->delete('appointments', ['id'=>$id]);
		$this->code = 200;
		
	}
	
	
	
	
	private function getForm($args){
		
		if($form = $this->customers_model->getForm($args)){
			$this->code = 200;
			$this->body = $form;
		}
	}	
	
	
	private function setForm($args){
		
		if($form = $this->customers_model->setForm($args)){
			$this->code = 200;
		}
	}
	
	
	private function getCustomer($args){
		if($id = @intval($args['id'])){
			
			if($customer = $this->customers_model->getById($id)){
				$this->code = 200;
				$this->body = $customer;
			}
		}
	}	
	
	
	private function updateCustomer($args){	
		
		if($this->customers_model->update($args)){
			$this->code = 200;
			$this->body = 'Customer has been successfully updated!';
		}
	}
	
	
	
	private function add_customer_note($args){	
		
		$cid = @intval($args['customer_id']);
		$note = @trim(preg_replace('^\s+^',' ',strip_tags($args['note'])));
		if(!strlen($note)){
			$this->error = 'Note field is required!';
		}
		elseif($this->customers_model->setActivity($cid, 'note', $note)){
			$this->code = 200;
			$this->body = 'Note successfully added!';
		}
	}
	
	
	private function set_customer_data($args){
		
		$id = @intval($args['customer_id']);
		$name = @trim($args['name']);
		$value = @trim($args['value']);
		if($id && !empty($name) && !empty($value) && $this->customers_model->update_data($id, $name, $value)){
			$this->code = 200;
		}
	}
	
	
	
	private function update_file($args){
		
		$id = @intval($args['id']);
		$rename = @trim($args['rename']);
		if($id && $this->customers_model->updateFile($id, $rename)){
			$this->code = 200;
			$this->body = 'Successfully updated!';
		}else{
			$this->error = 'error...';
		}
	}
	
	
	
	
	
	private function get_alerts($args){
		
		$alerts = $this->customers_model->getRelatedActivity(null, true);
		
		if($this->user_model->is_tech()){
			$alerts = array_values(array_filter($alerts, function($el){return in_array($el->type,[
					'status_changed',
					'assigned',
				]);
			}));
		}
		


		if(!empty($alerts)){
			$this->code = 200;
			$this->body = json_encode($alerts);
		}
	}	
	
	private function update_alerts($args){
		$IDs = @array_filter($args['view_ids']);
		
		if(is_array($IDs)){
			$this->code = 200;
			
			foreach($IDs as $id){
				$data = ['user_id'=>$this->ion_auth->get_user_id(),'activity_id'=>$id];
				if(!$this->db->get_where('customers_activity_view',$data)->num_rows())
					$this->db->insert('customers_activity_view',$data);
			} 
				
		}
	}
	
	
	private function get_top_users($args){
		
		if(!$this->user_model->in_group(['superadmin','dealer','manager'])) return;
		$user_id = @intval($args['user_id']);
		$group = @$this->user_model->get_group(intval($args['group_id']));
		if(empty($group->name) || $group->name == 'dealer' || $this->user_model->is_manager()) return;
		
		
		$is_dealer = $this->user_model->is_dealer();
		
		$groups =  'dealer';
		if($is_dealer && $group->name == 'manager'){
			return;
		}
		elseif($is_dealer){
			$groups = 'manager';
		}		

		
		$users = $this->user_model->getUsersByGroup($groups);
		foreach($users as $k=>&$u) if($user_id == $u->id) unset($users[$k]);
		
		$this->code = 200;
		$this->body =  json_encode($users);
	}
	
	
	private function update_status($args){
		
		$this->_check_access('superadmin');
		
		
		$id = @intval($args['id']);
		$name = @trim($args['name']);
		
		
		if(empty($name)){
			$this->error = 'The Status field is required.';
			return;
		}
		
		if($this->customers_model->updateStatus($id, $name)){
			$this->code = 200;
			$this->body = 'Successfully '.($id ? 'updated' : 'added').'!';
		}
	}
	
	
	private function delete_status($args){
		$this->_check_access('superadmin');
		$id = @intval($args['id']);
		if($id && $this->db->delete('statuses',['id'=>$id])){
			$this->code = 200;
		}
		
	}
	
	
	
	private function update_customer_status($args){
		$this->_check_access(['dealer','manager','sales','tech']);
		
		$id = @intval($args['id']);
		$status = @intval($args['status']);
		$datetime = @trim($args['datetime']);
		$priority = @intval($args['priority']);
		$users = @$args['users'];

		
		if(!$id){
			return;
		}elseif(!$status){
			$this->error = 'The Status field is required.';
			return;
		}elseif(!$datetime){
			$this->error = 'The Date/Time field is required.';
			return;
		}
		elseif(!$priority){
			$this->error = 'The Priority field is required.';
			return;
		}
		
		if($this->customers_model->updateCustomerStatus($id, $status, $datetime, $priority, $users)){
			$this->code = 200;
			$this->body = 'Successfully updated!';
		}
	}
	
	
	
	
	
	private function update_announcement($args){
		
		$this->_check_access('dealer');
		
		$id = @intval($args['id']);
		$content = @trim($args['content']);	
		
		if(empty($content)){
			$this->error = 'The Content field is required.';
			return;
		}
		
		if($this->customers_model->updateAnnouncement($id, $content)){
			$this->code = 200;
			$this->body = 'Successfully '.($id ? 'updated' : 'added').'!';
		}
	}
	
	
	//~~~~~~~~~~~~~~FUNCTIONS END~~~~~~~~~~~~~~//
	
	
	
	private function _check_access($groups){
		if(!$this->user_model->in_group($groups)) 
		exit('Access Denied');
	}
	
	
	private function _reset(){
		$this->code = 0;
		$this->body = '';
		$this->meta = '';
		$this->error = '';
		$this->js = '';
	}
	
	private function _getJSON(){
		return json_encode(array(
			'code' => $this->code,
			'body' => $this->body,
			'meta' => $this->meta,
			'error' => $this->error,
			'js' => $this->js,
		));
	}
	
}