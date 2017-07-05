<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class User_model extends CI_Model
{
	
	private $model_cache = [];
	private $current_id;


	public function __construct(){
		parent::__construct();
		$this->current_id = $this->ion_auth->get_user_id();
	}
	
	
	/**
	* 
	* @param mixed $user_id if TRUE then current, if INT then by id, if FALSE then all, DEFAULT FALSE
	* @param mixed $creator_id NULL/INT DEFAULT NULL
	* @param mixed $order_by NULL/STRING, DEFAULT NULL
	* @param string $order_by DEFAULT 'ASC'
	* 
	* @return mixed USER(s) ARRAY[OBJ] or OBJ
	*/
	public function getUsers($user_id = false, $creator_id = null, $order_by = null, $order_dir = 'asc'){
		
		if($user_id === true)
			$user_id = $this->current_id;
		elseif(!is_numeric($user_id)) 
			$user_id = false;
		elseif($user_id === 0)
			return false;
		
		
		
		$WHERE = null;
		if(is_numeric($creator_id)){
			$WHERE .= "where C.creator_id = $creator_id";
		}
		elseif(is_array($creator_id)){
			$creator_id = array_filter($creator_id, function($v){return is_numeric($v);});
			$WHERE .= "where C.creator_id in(".implode(',',$creator_id).")";
		}
		
		if($user_id){
			$WHERE .= empty($WHERE) ? "where " : " and ";
			$WHERE .= "U.id = $user_id limit 1";
		}

		
		$ORDER = null;
		if(strlen($order_by) && !$user_id){
			$ORDER = "ORDER BY $order_by $order_dir";
		}
		
		
		$result = $this->db->query("select 
		U.id,
		U.username,
		U.email,
		U.first_name,
		U.last_name,
		concat(U.first_name,' ',U.last_name) as full_name,
		from_unixtime(U.created_on, '%Y-%m-%d') as created_on,
		from_unixtime(U.last_login, '%Y-%m-%d') as last_login,

		UG.group_id,
		G.name as group_name,
		G.description as role,
		C.creator_id
		
		from users U
		left join users_groups UG on UG.user_id = U.id
		left join users_role_groups G on G.id = UG.group_id
		left join users_relations C on C.user_id = U.id
		
		$WHERE $ORDER
		
		")->result();
		
		
		return $user_id ? (isset($result[0]) ? $result[0] : false) : $result;
	}
	
	
	
	
	
	
	
	
	public function getUsersByGroup($group_name, $creator_id = 0){
		
		$uId_sql = "";
		if(is_array($creator_id)){
			$uId_sql .=  "and C.creator_id in(".implode(',', $creator_id).")";
		}elseif($creator_id){
			$uId_sql .=  "and C.creator_id = ".intval($creator_id);
		}
		
		if(is_array($group_name)){
			$group_name = "G.name in(".implode(",",array_map(function($n){return "'$n'";},$group_name)).")";
		}else{
			$group_name = " G.name = '$group_name'";
		}
		
		
		return $this->db->query("select 
		U.id,
		U.username,
		U.email,
		U.first_name,
		U.last_name,
		concat(U.first_name,' ',U.last_name) as full_name,
		from_unixtime(U.created_on) as created_on,
		from_unixtime(U.last_login) as last_login,
		
		UG.group_id,
		G.name as group_name,
		G.description as role,
		C.creator_id
		
		from users U
		left join users_groups UG on UG.user_id = U.id
		left join users_role_groups G on G.id = UG.group_id
		left join users_relations C on C.user_id = U.id
		where $group_name $uId_sql order by full_name")->result();
	}
	
	
	


	public function updateUser($id, $post = array())
	{
	
		$result = (object) array('code'=>0,'msg'=>'');
		
		$this->load->library('form_validation');
		$this->load->helper('language');
		$this->lang->load('auth');
		
		$_POST = $post;
	
		$user = $this->ion_auth->user($id)->row();

		// validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
		$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');


		if (!empty($_POST))
		{

			// update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name'  => $this->input->post('last_name'),
					'username' => preg_replace(array('|[^a-z\.\d]+|i','|\.+|'),array('','.'),strtolower($this->input->post('first_name').'.'.$this->input->post('last_name'))),
				);

				// update the password if it was posted
				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}



				// Only allow updating group if user is admin
				if ($this->in_group(['superadmin','dealer']) && in_array($user->id,$this->getSubUserIDs()) )
				{
					
					
					
					
					
					//Update the group user belongs to
					$group_id = intval($this->input->post('group_id'));
					if($group_id) {
						$this->ion_auth->remove_from_group('', $id);
						$this->ion_auth->add_to_group($group_id, $id);
					}
					
					$this->setUserRelations($this->input->post('creator_id'), $user->id);
					
				}

				$this->ion_auth->update($user->id, $data);
			}
		}


			if(validation_errors()){
				$result->msg = validation_errors();
			}
			elseif($this->ion_auth->errors()){
				$result->msg = $this->ion_auth->errors();
			}else{
				$result->code = 200;
				$result->msg = 'Successfully updated!';
			}
		
		return $result;

	}

	
	
	
	
		
	public function setUserRelations($creator_id, $user_id){
		$creator_id || $creator_id = $this->current_id;
		if($creator_id == $user_id) return;
		#---
		$data = [
			'user_id' => $user_id,
			'creator_id' => $creator_id
		];
		if($this->db->get_where('users_relations', array('user_id'=>$user_id))->num_rows() == 0){
			 $this->db->insert('users_relations',$data);
		}else{
			$this->db->update('users_relations',$data, array('user_id'=>$user_id));
		}
	}
	
	public function getUserRelations($user_id = null){		
		return $this->getCache(function() use($user_id){
			$user_id || $user_id = $this->current_id;
			return $this->db->get_where('users_relations',['user_id'=>$user_id])->row();
		});
	}
	
	
	
	
	
	public function getSubUserIDs($user_id = null, $levels = 3){
		
		return $this->getCache(function() use($user_id, $levels){
		
		
			$user_id || $user_id = $this->current_id;

			$levels = intval($levels);
			if(!$levels) return [];
			
			$join = ""; 
			$where = []; 
			
			
			foreach(range(1, $levels) as $i){
				$join .= " left join users_relations R$i on  R$i.creator_id ".($i==1 ? (is_array($user_id) ? " in(".implode(",",$user_id).")" : " = $user_id") : " = R".($i-1).".user_id");
				$where[] = "R$i.user_id = U.id";
			} 

			
			$subIDs = $this->db->query("select U.id from users U
			$join
			where ".implode(" or ", $where)."
			")->result();
			

			$IDs = array_unique(array_map(function($r){return $r->id;},$subIDs));
			
			
			return $IDs;
		});
	}
	
	
	
	public function getTopUserID($group = null, $user_id = null){

		return $this->getCache(function() use($group, $user_id){
		
			$user_id || $user_id = $this->current_id;
			$allGroups = array_map(function($r){return $r->name;},$this->ion_auth->groups()->result());
			
			if($group && $this->in_group($group, $user_id))
				return $user_id; 
			elseif(!$rel = $this->getUserRelations($user_id))
				return;
			elseif(empty($group) || !in_array($group, $allGroups) || $this->in_group($group, $rel->creator_id)) 
				return $rel->creator_id;
			
			
			while($rel = $this->getUserRelations($rel->creator_id)){
				if($this->in_group($group, $rel->creator_id)){
					return $rel->creator_id;
				} 
			}
			return;
		});
	}
	




	public function getSuperadminID($index = 0){
		$IDs = array_map(function($r){return $r->id;},$this->getUsersByGroup('superadmin'));
		return isset($IDs[$index]) ? $IDs[$index] : false;
	}
	
	
	public function get_group($group_id){
		return $this->getCache(function() use($group_id){
			return @$this->db->get_where('users_role_groups',['id'=>intval($group_id)])->row();
		});
	}

	public function is_superadmin($user_id = null){
		return $this->getCache(function() use($user_id){
			return $this->ion_auth->in_group('superadmin',$user_id);
		});
	}		
	
	public function is_dealer($user_id = null){
		return $this->getCache(function() use($user_id){
			return $this->ion_auth->in_group('dealer',$user_id);
		});
	}	
	
	public function is_manager($user_id = null){
		return $this->getCache(function() use($user_id){
			return $this->ion_auth->in_group('manager',$user_id);
		});
	}	
	
	public function is_sales($user_id = null){
		return $this->getCache(function() use($user_id){
			return $this->ion_auth->in_group('sales',$user_id);
		});
	}	
	
	public function is_tech($user_id = null){
		return $this->getCache(function() use($user_id){
			return $this->ion_auth->in_group('tech',$user_id);
		});
	}	

	public function in_group($groups, $user_id = null){
		return $this->getCache(function() use($groups, $user_id){
			return $this->ion_auth->in_group($groups, $user_id);
		});
	}
	
	private function getCache($cb){
		if(!is_object($cb)) return;
		elseif(!MODEL_CACHE) return $cb();
		#--
		$pF = debug_backtrace();
		if(empty($pF[1])) return;

		$idx = md5($pF[1]['function'].serialize($pF[1]['args']));
		if(!isset($this->model_cache[$idx])) 
			$this->model_cache[$idx] =  $cb();
		#--
		return $this->model_cache[$idx];
	}
}