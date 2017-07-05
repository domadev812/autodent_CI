

<!-- Modal -->
<div class="modal fade" id="customerStatusModal" tabindex="-1" role="dialog" aria-labelledby="customerStatusModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="customerStatusModalLabel">STATUS</h4>
      </div>
     
      <form>
      <div class="modal-body">
       		<div class="msg"></div>
       		
       		<label>Status</label>
       		<div class="form-group">
	            <select name="status" class="selectpicker required" required title="Select Status">
            		<?foreach($this->customers_model->getStatusList($user->status) as $option):?>
            			<option value="<?=$option->id?>" <?=$option->active?'selected':null?>><?=$option->name?></option>
            		<?endforeach;?>
            	</select>  
	        </div>
	        
	        <?$active = $this->customers_model->getPriorityList($user->priority, true);?>
        	<label>Priority</label>
        	<div class="form-group">
	        	<select name="priority" class="selectpicker required" required data-style="btn-<?=empty($active->color)?'default':$active->color?>" title="Select Priority">
	        		<?foreach($this->customers_model->getPriorityList($user->priority) as $option):?>
	        			<option data-color="<?=$option->color?>" value="<?=$option->id?>" <?=$option->active?'selected':null?>><?=$option->name?></option>
	        		<?endforeach;?>
	        	</select>
        	</div>
        	
        	<label>Date/Time</label>
        	<div class="input-group">
                <input type="text" class="form-control datetimepicker required" required name="datetime" value="<?=empty($user->status_datetime)?'':date('m/d/Y h:i A',strtotime($user->status_datetime))?>">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary appt_datetime">
                        <i class="fa fa-calendar"></i>
                    </button>
                </span>
            </div>
        	 
        	 <hr/>       	
        	<label>Assigned Users</label>
        	<div class="form-group">
                <select name="users" data-max-options="3" multiple class="selectpicker" data-style="btn-default" title="Select Users">
	        			<?foreach($this->customers_model->getCustomerUserList($user->id) as $u):?>
	        				<option <?=$u->active?'selected':''?> value="<?=$u->id?>"><?=$u->full_name?> (<?=$u->role?>)</option>
	        			<?endforeach;?>
	        	</select>
            </div>
        	
        	 
			<input type="hidden" name="id" value="<?=$user->id?>" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>



