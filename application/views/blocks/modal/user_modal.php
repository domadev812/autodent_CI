

<!-- Modal -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="userModalLabel">TITLE</h4>
      </div>
     
      <form class="save-user">
      <div class="modal-body">
        
       
       
			<div class="msg"></div>
	          
	        <p>
            	Personal details:
        	</p>        
	        <div class="form-group">
	            <input type="text" class="form-control required" required name="first_name" placeholder="First Name">
	        </div>                
	        <div class="form-group">
	            <input type="text" class="form-control required" required name="last_name" placeholder="Last Name">
	        </div>
	        <p>
	            Account details:
	        </p>
	        

	        <div class="form-group" id="user-creator_id">
	            <select name="creator_id" title="Select Top User" class="selectpicker"></select>
	        </div>
	             
	        
	        <div class="form-group">
	            <select name="group_id" title="Select Group" class="selectpicker required" required>
	            	<?foreach($this->db->get('users_role_groups')->result() as $gorup): 
	            	if(!in_array($gorup->name,['superadmin',$this->curr_user->group_name]) && (!$this->user_model->is_manager() || !in_array($gorup->name,['dealer'])) ):
	            	?>
	            		<option value="<?=$gorup->id?>"><?=$gorup->description?></option>
	            	<?endif;endforeach;?>
	            </select>
	        </div>	
	        
	                
	        <div class="form-group">
	            <input type="email" class="form-control required" name="email" required placeholder="Email">
	        </div>
	        <div class="form-group">
	            <input type="password" class="form-control" id="password" name="password"  pattern="^.{<?=$min_password_length?>}.*$" placeholder="Password">
	        </div>
	        <div class="form-group">
	            <input type="password" class="form-control" name="password_confirm"  pattern="^.{<?=$min_password_length?>}.*$" placeholder="Confirm Password">
	        </div>
	        <p class="text-center">
	    		The password should be at least <?=$min_password_length?> characters long
			</p>
			
			<input type="hidden" name="id" />
    
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left hidden delete-user"><i class="ti-trash"></i> Delete</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>