

<!-- Modal -->
<div class="modal fade" id="announcementModal" tabindex="-1" role="dialog" aria-labelledby="announcementModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-md">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="announcementModalLabel">Announcement</h4>
      </div>
     
      <form class="update-announcement">
      <div class="modal-body">
       		<div class="msg"></div>
       		<div class="form-group">
	            <textarea style="min-height:150px" class="form-control required" required placeholder="Content..." name="content"></textarea>
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