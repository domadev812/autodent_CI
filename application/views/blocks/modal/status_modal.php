

<!-- Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-md">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="statusModalLabel">STATUS</h4>
      </div>
     
      <form class="update-status">
      <div class="modal-body">
       		<div class="msg"></div>
       		<div class="form-group">
	            <input type="text" class="form-control required" required name="name" placeholder="Status...">
	        </div>
			<input type="hidden" name="id" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>