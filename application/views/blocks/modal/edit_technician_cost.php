
<!-- Modal -->
<div class="modal fade" id="technicianCostModal" tabindex="-1" role="dialog" aria-labelledby="technicianCostModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="customerStatusModalLabel">Cost</h4>
      </div>
     
      <form>
      <div class="modal-body">
       		<div class="msg"></div>
       		
       		<label>Task</label>
       		<div class="form-group">
	            <input type="text" disabled = 'disabled' class="form-control required" required name="task">
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
        	         	<label>Assigned Users</label>
        	<div class="form-group">
	                <select name="users" data-max-options="3" multiple class="selectpicker" data-style="btn-default" title="Select Users">
	        			<?foreach($this->customers_model->getCustomerUserList($user->id) as $u):?>
	        				<option <?=$u->active?'selected':''?> value="<?=$u->id?>"><?=$u->full_name?> (<?=$u->role?>)</option>
	        			<?endforeach;?>
	        	</select>
	        </div>
        	<label>Cost</label>
       		<div class="form-group">
	            <input type="text" class="form-control required" required name="cost">
	        </div>
        	 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>


