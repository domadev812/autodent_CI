
<? $onlyLeads = intval($this->input->get('leads'))?>

<div class="container-fluid full-height nopad">
	
	<div class="col-md-12 col-lg-2 users-left-col">
		
		<?if(!$this->user_model->is_tech()):?>
		<button class="btn btn-primary btn-block btn-lg add-customer">
        	Compose
        </button>
        <div class="divider"></div>
        <div class="btn-group btn-group-justified">
        	<a href="<?=base_url()?>customers" class="btn <?=$onlyLeads?'':'active'?> btn-primary">Customers</a>
			<a href="<?=base_url()?>customers?leads=1" class="btn <?=$onlyLeads?'active':''?> btn-primary">Leads</a>
        </div>
        <br/>
        <?else:?>
        <div class="margin-top-30"></div>
        <?endif;?>
        
        
        <div class="scroll-x">
			<ul class="users-left-list">
				<?foreach($this->customers_model->getAll() as $li): $active = !empty($user->id) && $user->id == $li->id ? 'class="active"':'';
				if($onlyLeads == $li->is_lead):?>
				<li <?=$active?>><a class="capit" href="/customers/get/<?=$li->id?><?=$onlyLeads?'?leads=1':''?>"><?=$li->name?></a></li>
				<?endif;endforeach;?>
			</ul>
		</div>
	</div>
	<div class="col-md-12 col-lg-10 users-right-col">
		
		
		<?if(!empty($user->id)):?>
		
		
		
		<?//echo '<pre>';print_r($user);exit;?>
		
		
<div class="row" id="customer-view">
    <div class="col-md-4">
        <div class="user-left">
            <div class="center">
                <button class="btn btn-primary btn-o pull-right" data-toggle="modal" data-target="#editCustomerModal">EDIT</button>
                <h4 class="capit"><?=$user->name?></h4>
                <hr>
                <div class="row">
                   <div class="col-sm-6 text-left">
                   		<span class="text-primary">VIN# <?=empty($user->vin)?'----':$user->vin?></span>
	                   	<br/>
	                   	<span class="text-primary"><?=(empty($user->year)?'----':$user->year).' '.(empty($user->make)?'----':$user->make).' '.(empty($user->model)?'----':$user->model)?></span>
	                   	<br/>
	                   	<span class="text-primary"><?=empty($user->color)?'----':$user->color?></span>
                   </div>
				   <div class="col-sm-6 text-right">Fuel Level <?=empty($user->fuel)?'----':$user->fuel?></div>
                </div>
                <hr>
            </div>
            <table class="table table-condensed">
                <thead>
                    <tr><th colspan="3">Contact Information</th></tr>
                </thead>
                <tbody>
                    <tr><td><span class="text-primary">Address</span></td><td><?=$user->address?></td></tr>
                    <tr><td><span class="text-primary">Phone Number</span></td><td><?=$user->phone?></td></tr>
                    <tr><td><span class="text-primary">Insurance Company</span></td><td><?=$user->insurance_company?></td></tr>
                    <tr><td><span class="text-primary">Estimator</span></td><td><?=$user->estimator?></td></tr>
                </tbody>
            </table>
            <table class="table table-condensed">
                <thead>
                    <tr><th colspan="3">General information</th></tr>
                </thead>
                <tbody>
                    <tr><td><span class="text-primary">Repair Order#</span></td><td><?=$user->repair_order?></td></tr>
                    <tr><td><span class="text-primary">PO#</span></td><td><?=$user->po?></td></tr>
                    <tr><td><span class="text-primary">Claim#</span></td><td><?=$user->claim?></td></tr>
                   	<tr><td colspan="2"><br/>&nbsp;</td></tr>
                    <tr><td><span class="text-primary">Status</span></td><td>
                    	<?$status = @$this->customers_model->getStatus($user->status)->name;?>
                    	<a href="#" data-toggle="modal" data-target="#customerStatusModal" class="btn btn-sm btn-default full-w"><?=empty($status)?'----':$status?></a>
                     </td></tr>                    
                     <tr><td><span class="text-primary">Status Date/Time</span></td><td>
                    	<a href="#" data-toggle="modal" data-target="#customerStatusModal" class="btn btn-sm btn-default full-w"><?=empty($user->status_datetime) ? '----' : date('m/d/Y h:i A',strtotime($user->status_datetime))?></a>
                     </td></tr>
                     <tr><td><span class="text-primary">Priority</span></td><td> 
                    	<?$active = $this->customers_model->getPriorityList($user->priority, true);?>
                    	<a href="#" data-toggle="modal" data-target="#customerStatusModal" class="btn btn-sm btn-<?=empty($active->color)?'default':$active->color?> full-w"><?=empty($active->name)?'----':$active->name?></a>
                    </td></tr>
                    <tr><td colspan="2"><br/>&nbsp;</td></tr>
                    <tr><td><span class="text-primary">Drop Off Date/Time</span></td><td><?=empty($user->datetime)?'----':date('m/d/Y h:i A',strtotime($user->datetime))?></td></tr>
                    <tr><td><span class="text-primary">Adjuster visit Date/Time</span></td><td><?=empty($user->adjuster_datetime)?'----':date('m/d/Y h:i A',strtotime($user->adjuster_datetime))?></td></tr>
                    <tr><td><span class="text-primary">Customer pick up the car Date/Time</span></td><td><?=empty($user->pick_up_datetime)?'----':date('m/d/Y h:i A',strtotime($user->pick_up_datetime))?></td></tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-8">
        
        <div class="panel panel-white" id="recent_activities">
            <div class="panel-heading border-light">
                <h4 class="panel-title text-primary">Recent Activities</h4>
             </div>
            
                <div class="panel-body">
                    
                    <div class="add-note">
                    	<div class="msg"><div class="alert hidden"></div></div>
                    	<textarea class="form-control" placeholder="Write a note or update..."></textarea>
                    	<button id="add_customer_note" data-customer_id="<?=$user->id?>" data-note="" class="btn btn-primary">Send</button>
                    </div>
           
                   
                   <ul class="timeline-xs">
                   	<?foreach($user->activity as $act):?>
                   		<li class="timeline-item">
                            <div class="margin-left-15">
                                <div class="text-muted text-small"><?=$act->interval?></div>
                                <p><a class="text-info"><?=$act->creator_name?></a> <?=$act->note?></p>
                            </div>
                        </li>
                   	<?endforeach;?>
                   </ul>
                </div>
        </div>
        
        
        <div class="panel panel-white">
            <div class="panel-heading border-light">
                <h4 class="panel-title text-primary">Files</h4>
             </div>
             <div class="panel-body">
                   <table class="table" id="projects">
                        <thead>
                            <tr>
                                <th>Form Title</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="form-onpage"><a href=".ra-page"  data-target="repair_authorization" data-toggle="customer_form">Repair Authorization</a> <span><i class="ti-angle-right"></i></span></td>
                            </tr>
                            <tr>
                                <td class="form-onpage"><a href="#"  data-target="rental_agreement" data-toggle="customer_form">Rental Agreement</a> <span style="display:none">&nbsp;</span> <span>
                                	<div class="clip-radio radio-primary r_a">
                                        <input type="radio" id="rental_agreement_accept_p" name="rental_agreement" value="accept">
                                        <label for="rental_agreement_accept_p">Accept</label>
                                        <input type="radio" id="rental_agreement_decline_p" name="rental_agreement" value="decline">
                                        <label for="rental_agreement_decline_p">Decline</label>
                                    </div>
                                </span></td>
                            </tr>
                            <tr>
                                <td class="form-onpage"><a href=".adp-page"  data-target="authorization_and_direction_to_pay" data-toggle="customer_form">Authorization and Direction to Pay</a> <span><i class="ti-angle-right"></i></span></td>
                            </tr>
                            <tr>
                                <td class="form-onpage"><a href=".pdr-page"  data-target="prior_damage_report" data-toggle="customer_form">Prior Damage Report</a> <span><i class="ti-angle-right"></i></span></td>
                            </tr>                            
                            <tr>
                                <td class="form-onpage"><a href=".invoice-page"  data-target="invoice" data-toggle="customer_form">Invoice</a> <span><i class="ti-angle-right"></i></span></td>
                            </tr>
                            <?foreach($user->files as $file): $fName = empty($file->rename) ? $file->orig_name: $file->rename?>
                            <tr>
                                <td class="c_files">
                                	<a class="text-info" download="<?=$fName?>" href="/uploads/customer/<?=$file->customer_id.'/'.$file->filename?>"><?=$fName?></a>
                                	
                                	<div class="btn-group pull-right">
                                		<a class="edit-file btn btn-info btn-xs"  data-toggle="modal" data-target="#customerFileModal" data-rename="<?=$file->rename?>" data-id="<?=$file->id?>" href="#"><i class="ti-pencil"></i></a>
                                		<a class="btn btn-danger btn-xs" href="/customers/delete_file/<?=$file->id?>/<?=$user->id?>"><i class="ti-close"></i></a>
                                	</div>
                                </td>
                            </tr>
                            <?endforeach;?>
                            
                        </tbody>
                    </table>
                    <div class="upload_block">
                    	<div class="btn btn-primary btn-o upload_file">UPLOAD FILE</div>
                    	<div class="fileLoad ajax-load"></div>
                    	<input type="file" class="customerFile hidden" />
                    </div>
       		</div>
       		
       		<input type="hidden" id="page_customer_id" value="<?=$user->id?>" />      		
       </div>
       
       
        
      
        
    </div>
</div>
		
		
		<?$this->load->view('blocks/modal/edit_customer_form')?>
		
		<?$this->load->view('blocks/modal/edit_customer',['user'=>$user])?>
		
		<?$this->load->view('blocks/modal/edit_customer_file')?>
		
		<?$this->load->view('blocks/modal/customer_status', ['user' => $user])?>
		
		
		<?else:?>
		
		<div id="empty-user">
			<h1>No customer has been selected</h1>			
		</div>

		<?endif;?>

	</div>

</div>

 

<?$this->load->view('blocks/modal/create_customer')?>
<?$this->load->view('blocks/modal/edit_technician_cost')?>
<?$this->load->view('blocks/modal/financial_information')?>
