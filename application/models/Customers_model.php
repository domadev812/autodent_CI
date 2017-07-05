<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Customers_model extends CI_Model
{
	
	
	private $model_cache = [];
	
	public function __construct(){
		parent::__construct();
		$this->appt_dates = [
			'datetime'=> (object) ['color' => 'green', 'name' => 'Drop off'],
			'adjuster_datetime'=> (object) ['color' => 'yellow', 'name' => 'Adjuster visit'],
			'pick_up_datetime' => (object) ['color' => 'blue', 'name' => 'Customer pick up the car'],
		];
		
		$this->check24HoursDates();
	}
	
	
	private function check24HoursDates(){
		$topUseId = $this->user_model->getTopUserID('dealer');
		foreach($this->getAllowedIDs($topUseId, date('Y-m-d')) as $id){
			$c = $this->getById($id);
			foreach($this->appt_dates as $key => $data){			
				$type = $key.'_24hours';
				if(!empty($c->{$key}) &&  strtotime($c->{$key}.'- 24 hours') < time() && !$this->db->get_where('customers_activity', ['customer_id' => $id, 'type' => $type])->num_rows()){
					$this->setActivity($c->id, $type, '24 hours before Date/Time of appointment', $topUseId);
				}
			}

		}	
	}
	
	
	
	
	
	
	
	
	/**
	* 
	* @param mixed $creator_id if NULL then current, default NULL
	* @param string $date_from Y-m-d, default NULL
	* @param string $date_to Y-m-d, default NULL
	* 
	* @return array Customer IDs
	*/
	public function getAllowedIDs($creator_id = null, $date_from = null, $date_to = null){
		
		
		return $this->getCache(function() use($creator_id, $date_from, $date_to){
		
			$creator_id || $creator_id = $this->ion_auth->get_user_id();
			
			$UID = null;
		
			if(!is_numeric($creator_id) && !is_array($creator_id)) return [];
			elseif(is_numeric($creator_id)){
				$UID = $creator_id;
				$topId = $this->user_model->getTopUserID('dealer', $creator_id);
				$topId || $topId = $UID;				
				$creator_id = array_unique(array_filter(array_merge([$topId], $this->user_model->getSubUserIDs($topId))));
			}	
			
			$filterByStatus = null;
			$filterByLeads = null;
			if($this->user_model->is_tech()){
				$filterByStatus = " and lower(ST.name) = 'approved and ready'";
				
				$filterByLeads = [];
				foreach($this->appt_dates as $key => $data) $filterByLeads[] = "A.$key is not null";
				$filterByLeads = "and (".implode(" or ", $filterByLeads).")";
			}
			elseif($this->user_model->is_sales()){
				$filterByLeads = [];
				foreach($this->appt_dates as $key => $data) $filterByLeads[] = "A.$key is not null";
				$filterByLeads = "and if(C.creator_id = ".$this->ion_auth->get_user_id()." or (".implode(" or ", $filterByLeads)."),1,0) = 1";
			}
			
			
			$filterByDate = null;
			if(strlen($date_from) || strlen($date_to) ){
				
				$filterByDate = [];	
				foreach($this->appt_dates as $key => $data){
					$dates = [];
					if(strlen($date_from)){
						$date_from = $this->_date($date_from);
						$dates[] = "A.$key >= '$date_from'";
					}
					if(strlen($date_to)){
						$date_to = $this->_date($date_to);
						$dates[] = "A.$key <= '$date_to'";
					} 
					$filterByDate[] = "(".implode(" and ",$dates).")";
				}
					
				#--
				$filterByDate = "and (".implode(" or ", $filterByDate).")";
			}
			
			
			$assignedCustomers = null;
			
			if($UID){
				$assignedCustomers = array_map(function($r){return $r->customer_id;}, $this->db->get_where('customers_users', ['user_id'=>$UID])->result());
				$assignedCustomers = empty($assignedCustomers) ? null : " or C.id in(".implode(",", $assignedCustomers).")";
			}
			
			
			
			$IDs = array_map(function($r){return $r->id;}, $this->db->query("select C.id from customers C
			left join statuses ST on ST.id = C.status
			left join appointments A on A.customer_id = C.id
			where ((C.creator_id in(".implode(",",$creator_id).") $filterByStatus $filterByLeads) $assignedCustomers)  $filterByDate")->result());
			return array_unique($IDs);
		
		});
	}
	
	
	public function getAll($creator_id = null){
		$customers = array();
		foreach($this->getAllowedIDs($creator_id) as $id){
			$customers[] = $this->getById($id);
		} 
		return $customers;
	}
	
	
	
	
	
	public function getQueue($creator_id = null){
		
		$queue = array();
		$tmp_queue = array();
		foreach($this->getAllowedIDs($creator_id, date('Y-m-d')) as $id){
			$c = $this->getById($id);
			if($c->is_lead) continue;
			
			$name = @trim($c->name.' '.$c->year.' '.$c->make.' '.$c->model);
			#--
			foreach([
				'status_datetime',
				'datetime',
				'adjuster_datetime',
				'pick_up_datetime',
			] as $key){
				
				if(!empty($c->{$key})){
					
					 $desc = $key == 'status_datetime' ? $this->getStatus($c->status)->name : $this->appt_dates[$key]->name;
					 $color = $key == 'status_datetime' ? $this->getPriorityList($c->priority, true)->color : $this->appt_dates[$key]->color;
					 switch($color){
					 	case 'green': $color = 'success';
					 		break;					 	
					 	case 'yellow': $color = 'warning';
					 		break;					 	
					 	case 'blue': $color = 'info';
					 		break;
					 }
				
					 
					 $tmp_queue[$c->{$key}][] = (object) [
						 'id'=>$c->id,
						 'datetime' => $c->{$key}, 
						 'name' => $name, 
						 'desc' => $desc, 
						 'color' => 'bg-'.$color,
					 ];
				}
				
			}
		} 
		
		ksort($tmp_queue);
		foreach($tmp_queue as $datetime)
			foreach($datetime as $item)
				$queue[] = $item;
		return $queue;	
	}
	
	
	
	
	public function getMyTasks($user_id = null){
		$user_id || $user_id = $this->ion_auth->get_user_id();
		$tmp_tasks = [];
		$tasks = [];
		foreach($this->db->get_where('customers_users', ['user_id'=>$user_id])->result() as $row){
			$c = $this->getById($row->customer_id);
			$name = @trim($c->name.' '.$c->year.' '.$c->make.' '.$c->model);
			$desc = $this->getStatus($c->status)->name;
			$color = $this->getPriorityList($c->priority, true)->color;
			
			$tmp_tasks[$c->status][] = (object) [
				 'id'=>$c->id,
				 'datetime' => $c->status, 
				 'name' => $name, 
				 'desc' => $desc, 
				 'color' => 'bg-'.$color,
			 ];
		}
		
		ksort($tmp_tasks);
		foreach($tmp_tasks as $datetime)
			foreach($datetime as $item)
				$tasks[] = $item;
				
		return $tasks;
	}
	
	
	
		
	
	
	
	public function getById($id){

		return $this->getCache(function() use($id){
		
			if(!$row = $this->db->get_where('customers', ['id'=>$id])->row()){
				return;
			}
			$customer = (object)[
				'id' => $row->id,
				'name' => $row->name,
				'phone' => preg_replace(['|[^\d]+|', '|([\d]{3})([\d]{3})([\d]{4})|'],['', '($1)-$2-$3'],$row->phone),
				'address' => $row->address,
				'insurance_company' => $row->insurance_company,
				'repair_order' => $row->repair_order,
				'estimator' => $row->estimator,
				'po' => $row->po,
				'claim' => $row->claim,
				'status' => $row->status,
				'status_datetime' => $row->status_datetime,
				'priority' => $row->priority,
				'creator_id' => $row->creator_id,
				'note' => $row->note,
				'is_lead' => 0,
			];

			if($appt = $this->db->select('id as appt_id, datetime,adjuster_datetime,pick_up_datetime,vin,mileage,year,color,make,fuel,model')->get_where('appointments', ['customer_id'=>$row->id])->row()){
				foreach($appt as $key => $val){ 
					$customer->{$key} = $val;
				}
				
				$customer->forms = [];
				if($forms = $this->db->select('form_name, form_data_json')->get_where('appointments_forms', ['customer_id' => $row->id])->result()){
					foreach($forms as $f) $customer->forms[] = $f;
				}
			}
			if(empty($customer->datetime) && empty($customer->adjuster_datetime) && empty($customer->pick_up_datetime)){
				$customer->is_lead = 1;
			}
			#------------------------
			return $customer;
		});
	}
	
	
	public function update($post){
		$customer_id = @intval($post['customer_id']);
		$appt_id = @intval($post['appt_id']);
	
		
		$updated = false;
		
		if($customer_id){
			$data = [];
			foreach([
				'name',
				'address',
				'insurance_company',
				'po',
				'estimator',
				'claim',
				'repair_order',
				'phone',
				'note',
			] as $key){
				$value = @trim($post[$key]);
				if( ($key == 'name' && !empty($value)) || $key != 'name'){
					$data[$key] = $value;
				}
				 
			}

			if(!empty($data)){
				
				
				foreach($this->getById($customer_id) as $ck => $cv) if(isset($data[$ck]) && $data[$ck] != $cv){
					$this->setActivity($customer_id, 'updated'); $updated = true;
					break;
				}

				$this->db->update('customers', $data, ['id'=>$customer_id]);
			}
		}
		
		
		if(!$appt_id){
			if(!$appt = $this->db->get_where('appointments',['customer_id' => $customer_id])->row()){
				$this->db->insert('appointments', ['customer_id' => $customer_id]);
				$appt_id = $this->db->insert_id();
				
			}	
			else 
				$appt_id = $appt->id;
		}
		
		if($appt_id){
			
			$appt = !empty($appt) ? : $this->db->get_where('appointments',['id' => $appt_id])->row();
			
			$data = [];
			foreach([
				'vin',
				'mileage',
				'year',
				'color',
				'make',
				'fuel',
				'model',
				'datetime',
				'adjuster_datetime',
				'pick_up_datetime',
			] as $key){
				$value = @trim($post[$key]);
				if(!empty($value)){
					$data[$key] = $value;
				}
				 
			}

			if(!empty($data)){
				
				if(!empty($data['datetime']))          $data['datetime'] = @$this->_date($post['datetime'], null, 'Y-m-d H:i:s');
				if(!empty($data['adjuster_datetime'])) $data['adjuster_datetime'] = @$this->_date($post['adjuster_datetime'], null, 'Y-m-d H:i:s');
				if(!empty($data['pick_up_datetime']))  $data['pick_up_datetime'] = @$this->_date($post['pick_up_datetime'], null, 'Y-m-d H:i:s');
			
				
				if(!$updated){
					foreach(['vin','year','color','make','color','make','fuel','model'] as $ik) if(isset($data[$ik]) && $data[$ik] != $appt->{$ik}){
						$this->setActivity($customer_id,'updated');
						break;
					}
				}
				
				$date_changed = false;
				foreach($this->appt_dates as $dk => $d) if(isset($data[$dk]) && $data[$dk] != $appt->{$dk}){	
					$this->db->delete('customers_activity',['customer_id'=>$customer_id,'type'=>$dk.'_24hours']);
					
					if(!$date_changed){
						$date_changed = true;
						$this->setActivity($customer_id,'date_changed');
					}
				}

				$this->db->update('appointments', $data, ['id'=>$appt_id]);
			}
		}
		
		
		return true;
	}
	
	
	public function update_data($id, $name, $value){
		if(empty($name) || $name == 'id') return;
		$this->setActivity($id, $name.'_changed');
		return $this->db->update('customers', [$name=>$value], ['id'=>$id]);
	}
	
	
	
	
	public function search($q, $creator_id = null){
		
		$q = trim(preg_replace('^\s+^',' ',strtolower($q)));
		$IDs = $this->getAllowedIDs($creator_id);
		if(empty($q) || empty($IDs)){
			return [];
		}
	
		$fields = [
			'C.name',
			'C.address',
			'C.insurance_company',
			'C.po',
			'C.estimator',
			'C.claim',
			'C.repair_order',
			'C.phone',
			'A.year',
			'A.make',
			'A.model',
		];
		
		$fields = array_map(function($v) use($q){
			return "$v LIKE '%$q%'";
		}, $fields);
		
		$WHERE  = "WHERE (".implode(' OR ', $fields).")";
		$WHERE .= " AND C.id IN(".implode(",",$IDs).")";

		
		$sql = "SELECT C.*, A.year, A.make, A.model  
		FROM customers C
		LEFT JOIN appointments A ON A.customer_id = C.id
		$WHERE ORDER BY C.name
		";
		
		$users = $this->db->query($sql)->result();
		foreach($users as &$u){
			$u->label_info = trim("$u->name $u->year $u->make $u->model");
		}
		
		return $users;
	}
	
	
	
	public function getSchedule($date_from, $date_to = null, $creator_id = null){
		

		$appts = [];
		$IDs = $this->getAllowedIDs($creator_id, $date_from, $date_to);
		if(empty($IDs)) return $appts;
		foreach($this->appt_dates as $key => $data){
			foreach($this->db->query("select S.id, C.name, S.$key as task_datetime, '$data->color' as date_color, '$data->name' as date_name, S.customer_id from appointments S
			left join customers C on C.id = S.customer_id
			left join statuses ST on ST.id = C.status
			where (S.$key between '$date_from' and date_add('$date_to', interval 1 day))  and C.id in(".implode(",",$IDs).") order by S.datetime")->result() as $item){
				$appts[date('Y-m-d', strtotime($item->task_datetime))][] = $item;
			}
		}
		
		
		return $appts;
	}	
	
	public function addSchedule($post){

		
		if(empty($post['customer_id'])) return 0;
		$data = [];
		$data['datetime'] = @$this->_date($post['appt_datetime'], null, 'Y-m-d H:i:s');
		$data['adjuster_datetime'] = @$this->_date($post['adjuster_datetime'], null, 'Y-m-d H:i:s');
		$data['pick_up_datetime'] = @$this->_date($post['pick_up_datetime'], null, 'Y-m-d H:i:s');
		$data['customer_id'] = @intval($post['customer_id']);
		$fields = [
			'vin',
			'mileage',
			'year',
			'color',
			'make',
			'fuel',
			'model',
		];
		foreach($post as $k => $p)
			if(in_array($k, $fields)) $data[$k] = trim(strtolower(preg_replace('^\s+^',' ',$p)));

		
		$this->db->insert('appointments', $data);
		return $this->db->insert_id();
	}
	
	
	
	public function add($post, $creator_id = null){
		
		if($this->user_model->is_tech()) return;
		
		
		$creator_id || $creator_id = $this->ion_auth->get_user_id();
		$name = @trim(strtolower(preg_replace('^\s+^',' ',$post['customer_name'])));
		
		if(empty($name)) return;
		if(!$row = $this->db->get_where('customers', ['name'=>$name])->row()){
			$fields = [
				'insurance_company',
				'address',
				'po',
				'estimator',
				'claim',
				'repair_order',
				'phone',
				'note',
			];
			
			foreach($post as $k => &$p)
				if(!in_array($k, $fields)) unset($post[$k]);
				else $p = trim(strtolower(preg_replace('^\s+^',' ',$p))); 
			
			
			$post['name'] = $name;
			$post['creator_id'] = $creator_id;
						
			$this->db->insert('customers', $post);
			$cid = $this->db->insert_id();
			$this->setActivity($cid, 'created');
			return $cid;
		}
		
		return;
	}
	
	
	
	public function getForm($post = []){
		$target = @trim($post['target']);
		$customer_id = @intval($post['customer_id']);
		if($target && $customer_id){
			$json = @json_decode($this->db->get_where('appointments_forms', ['form_name' => $target, 'customer_id'=>$customer_id])->row()->form_data_json);
			if(!empty($json)){
				
				$json->passed = 0;
				
				//print_r($json);exit;
				
				switch($target){
					case 'repair_authorization':
					$sig_ra = @json_decode($json->{'sig-ra'});
					if(!empty($sig_ra->lines)) $json->passed = 1;
						break;					
						
					case 'authorization_and_direction_to_pay':
					$sig_adp = @json_decode($json->{'sig-adp'});
					if(!empty($sig_adp->lines)) $json->passed = 1;
						break;					
						
					case 'prior_damage_report':
					$sig_pdr_customer = @json_decode($json->{'sig-pdr-customer'});
					$sig_pdr_adc = @json_decode($json->{'sig-pdr-adc'});
					$annotations = @json_decode($json->annotations);
					if(!empty($sig_pdr_customer->lines) && !empty($sig_pdr_adc->lines) && !empty($annotations[0]->text)) $json->passed = 1;
						break;					
						
					case 'rental_agreement':
					$rental_agreement = @json_decode($json->{'rental_agreement'});
					if($rental_agreement) $json->passed = 1;
						break;					
						
					case 'invoice':
					$damage = @json_decode($json->{'damage'});
					if($damage) $json->passed = 1;
						break;
				}
				
				
				return json_encode($json);
			}
		}
		return json_encode([]);
	}
	
	public function setForm($post = []){
		$targests = [
			'repair_authorization',
			'rental_agreement',
			'authorization_and_direction_to_pay',
			'prior_damage_report',
			'invoice',
		];
		
		$data = [];
		$data['form_name'] = @trim($post['target']);
		$data['customer_id'] = @intval($post['customer_id']);
		$data['form_data_json'] = @trim($post['form_data_json']);
		
		if(in_array($data['form_name'], $targests) && $data['customer_id'] && !empty($data['form_data_json'])){
			
			$this->setActivity($data['customer_id'], 'updated');
			
			if($this->db->get_where('appointments_forms', ['form_name' => $data['form_name'], 'customer_id'=> $data['customer_id']])->num_rows()){
				return $this->db->update('appointments_forms', $data, ['form_name' => $data['form_name'], 'customer_id' => $data['customer_id']]);
			}
			else{
				return $this->db->insert('appointments_forms', $data);
			}
		}
		return;
	}
	
	
	public function getFiles($id){
		return $this->db->get_where('appointments_files', ['customer_id'=>$id])->result();
	}
	
	public function updateFile($id, $rename = null){
		return $this->db->update('appointments_files', ['rename'=>$rename], ['id'=>$id]);
	}
	
	
	
	

	
	
	public function setActivity($customer_id, $type, $note = null, $user_id = null){
		
		$user_id || $user_id = $this->ion_auth->get_user_id();
		
		$types = [
			'note',
			'created',
			'updated',
			'date_changed',
			'status_changed',
			'priority_changed',
			'assigned',
			'edit_cost',
			
			/*'appt_scheduled',
			'forms_completed',
			'adjuster_scheduled',
			'tech_started_work',
			'tech_completed_work',
			'account_billed',
			'account_paid',*/
		];
		foreach($this->appt_dates as $k=>$v) $types[] = $k.'_24hours';
		
		
		if(!in_array($type, $types)) return [];
		
		return $this->db->insert('customers_activity', [
			'customer_id' => $customer_id,
			'type' => $type,
			'note' => trim($note),
			'user_id' => $user_id
		]);
	}
	
	
	public function getActivity($customer_id, $new = false, $user_id = 0){
		$activity = $this->db->query("select A.*, C.name as customer_name, concat(U.first_name ,' ',U.last_name) as creator_name from customers_activity A
		left join users U on U.id = A.user_id
		left join customers C on C.id = A.customer_id
		where A.customer_id = $customer_id ".($new ? "and (select count(*) from customers_activity_view AV where AV.user_id = $user_id and AV.activity_id = A.id) = 0":"")." order by A.added desc
		")->result();
		
		foreach($activity as &$a){

			$a->interval = get_time_interval(strtotime($a->added));
			
			switch($a->type){
				case 'note':
					$a->note = 'on <b class="capit">'.$a->customer_name.'</b>: '.$a->note;
					break;				
				
				case 'created':
					$a->note = 'created <b class="capit">'.$a->customer_name.'</b>';
					break;				
				
				case 'updated':
					$a->note = 'updated <b class="capit">'.$a->customer_name.'</b>';
					break;				
				
				case 'status_changed':
					$a->note = 'changed <b class="capit">'.$a->customer_name.'</b> Status';
					break;					
					
				case 'date_changed':
					$a->note = 'changed <b class="capit">'.$a->customer_name.'</b> Date/Time';
					break;				
				
				case 'priority_changed':
					$a->note = 'changed <b class="capit">'.$a->customer_name.'</b> Priority';
					break;				
					
				case 'assigned':
					$u = $this->user_model->getUsers(intval($a->note));
					$a->note = 'on <b class="capit">'.$a->customer_name.'</b> Created a task for '.($u ? $u->full_name : '----');
					break;
				
				default:
					$a->note = 'on <b class="capit">'.$a->customer_name.'</b>: '.$a->note;
					break;
			}
			
		}
		
		return $activity;
	}
	
	
	

	
	
	public function getRelatedActivity($user_id = null, $new = false){
		$user_id || $user_id = $this->ion_auth->get_user_id();
		$IDs = $this->getAllowedIDs($user_id);

		$hours24Types = [];
		foreach($this->appt_dates as $key => $data) $hours24Types[] = $key.'_24hours';
		
		$activity = [];
		foreach($IDs as $cid){
			foreach($this->getActivity($cid, $new, $user_id) as $act){
				if( $act->user_id != $user_id || in_array($act->type, $hours24Types) ) 
					$activity[] = $act;
			}
				
		}

		return $activity;
	}
	
	
	

	








	
	/**
	* 
	* @param mixed $id if INT then obj, if NULL then all, default NULL
	* 
	* @return mixed obj/array
	*/
	public function getStatus($id = null){
		$id = intval($id);
		$status = $this->db->query("select * from statuses ".($id ? "where id = $id" : ""))->result();
		return $id ? $status[0] : $status;
	}
	
	
	public function updateStatus($id, $name){
		return $id ? $this->db->update('statuses',['name'=>$name],['id'=>$id]) : $this->db->insert('statuses',['name'=>$name]);
	}
	
	
	public function updateCustomerStatus($id, $status, $datetime, $priority, $users = []){
		
		if(!$c = $this->getById($id)) return;
		
		if($c->status != $status){
			$this->setActivity($id, 'status_changed');
		}	
		
		$this->updateCustomerUserList($id, $users);
		
		$datetime = $this->_date($datetime, null, 'Y-m-d H:i:s');
		
		if($c->status_datetime != $datetime){
			$this->setActivity($id, 'date_changed');
		}
		
		return $this->db->update('customers',['status'=>$status, 'status_datetime'=>$datetime, 'priority'=>$priority],['id'=>$id]);
	}

	public function getStatusList($status_id = 0, $getActive = false){
		$result = $this->getStatus();
		foreach($result as &$r){
			$r->active = intval($r->id == $status_id);
		}	
		
		if($getActive){
			foreach($result as $a) if($a->active) return $a;
			return;
		}
		
		return $result;
	}

	public function getPriorityList($priority_id = 0, $getActive = false){	
		$result = [
			(object)['id'=>1, 'name' => 'Low',  'color' => 'info'],
			(object)['id'=>2, 'name' => 'Mid',  'color' => 'warning'],
			(object)['id'=>3, 'name' => 'High', 'color' => 'danger'],
		];
		
		foreach($result as &$r){
			$r->active = intval($r->id==$priority_id);
		}
		
		if($getActive){
			foreach($result as $a) if($a->active) return $a;
			return;
		}

		return $result;
	}

	public function getAnnouncements($user_id = null){
		$user_id || $user_id =  $this->ion_auth->get_user_id();
		return $this->db->order_by('id','desc')->get_where('announcements',['user_id'=>$user_id])->result();
	}	
	
	public function updateAnnouncement($id, $content, $user_id = null){
		$user_id || $user_id = $this->ion_auth->get_user_id();
		return $id ? $this->db->update('announcements',['content'=>$content],['id'=>$id,'user_id'=>$user_id]) : $this->db->insert('announcements',['content'=>$content, 'user_id'=>$user_id, 'added' => date('Y-m-d H:i:s')]);
	}
	
	public function updateCustomerUserList($customer_id, $IDs){
		$IDs = is_array($IDs) ? array_unique(array_filter($IDs)) : (intval($IDs) ? [intval($IDs)] : []);
		
		//echo '<pre>';print_r($IDs);//exit;
		
		$prev_IDs = array_map(function($r){return $r->user_id;},$this->db->get_where('customers_users',['customer_id' => $customer_id])->result());
		
		//echo '<pre>';print_r($prev_IDs);exit;
		
		foreach($IDs as $ID){
			if(!in_array($ID,$prev_IDs)) $this->setActivity($customer_id,'assigned',$ID);
		}
		
		
		$this->db->delete('customers_users',['customer_id' => $customer_id]);
		$data = array_map(function($uid) use ($customer_id){
			return (object) ['user_id' => $uid, 'customer_id' => $customer_id];
		},$IDs);
		
		
		
		return empty($data) ? null : $this->db->insert_batch('customers_users', $data);

	}
	
	public function getCustomerUserList($customer_id, $user_id = null){
		$user_id || $user_id = $this->ion_auth->get_user_id();
		$users = [];
		$managerID = $this->user_model->getTopUserID('dealer',$user_id);
		$activeIDs = array_map(function($r){return $r->user_id;}, $this->db->get_where('customers_users', ['customer_id'=>$customer_id])->result());

		foreach($this->user_model->getSubUserIDs($managerID) as $uid){
			$tmp = $this->user_model->getUsers($uid);
			if($tmp && $tmp->id != $user_id){
				$user = (object) [
					'id' => $tmp->id,
					'full_name' => $tmp->full_name,
					'group_name' => $tmp->group_name,
					'role' => $tmp->role,
				];
				$user->active = intval(in_array($user->id, $activeIDs));
				$users[] = $user;
			}
			
		}

		return $users;
	}




	

	
	private function _date($date, $str = '', $format = 'Y-m-d'){
		return date($format, strtotime($date.' '.trim($str)));
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