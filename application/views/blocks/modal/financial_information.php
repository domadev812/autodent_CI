<div class="modal fade" id="viewFinancial" tabindex="-1" role="dialog">
   <div class="modal-dialog modal-lg">
	<div class="modal-content">
	      <div class="msg">
	      	<div class="title" align = 'center'>
	      		<b>Financial Information</b>
	      	</div>
	      </div>
              <div class="form">
		  <div class="form-body row">
		  	<div class = 'left-user-list col-md-3'>
		  		<div class = 'col-md-11'  id = "first">&nbsp;</div>
		  		<?foreach($this->customers_model->getCustomerUserList(null) as $u):?>
        				<div class = 'col-md-12'  id = "<?=$u->id?>">
        					<span style = 'color: white;'><?=$u->full_name?></span>
        				</div>
        			<?endforeach;?>
		  	</div>
		  	<div class = 'col-md-9'>
		  		
		  	</div>
		  </div>
	      </div>
	 </div>
    </div>
</div>