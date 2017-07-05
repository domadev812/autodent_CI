
<?php 
	$m_num = empty($m_num) ? 1 : $m_num;
	$modalId = [1=>'createCustomerModal',2=>'editCustomerFormModal'];
?>

<div class="modal fade" id="add-field-invoice-modal-<?=$m_num?>" tabindex="-1" style="z-index:1100" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
	    <div class="modal-header">
	        <button type="button" class="close" data-target="#add-field-invoice-modal-<?=$m_num?>" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	     </div>
      	<div class="modal-body">
      	
	      	<form>
	          <div class="form-group">
	            <label for="field-name-<?=$m_num?>" class="control-label">Field Name:</label>
	            <input type="text" name="name" class="form-control required" id="field-name-<?=$m_num?>">
	          </div>
	          <div class="form-group">
	            <div class="clip-radio radio-primary">
	                <input checked="checked" type="radio" id="field-action-plus-<?=$m_num?>" name="action" value="+">
	                <label for="field-action-plus-<?=$m_num?>">Add</label>
	                <input type="radio" id="field-action-minus-<?=$m_num?>" name="action" value="-">
	                <label for="field-action-minus-<?=$m_num?>">Substract</label>
	            </div>
	          </div>
	        </form>
      
      	</div>
      	<div class="modal-footer">
	        <button type="button" class="btn btn-primary btn-o" data-target="#add-field-invoice-modal-<?=$m_num?>" data-dismiss="modal">Cancel</button>
	        <button type="button"  data-target="#<?=$modalId[$m_num]?>" class="btn btn-primary add-field-trigger">Add</button>
	    </div>
      </div>
  </div>
</div>