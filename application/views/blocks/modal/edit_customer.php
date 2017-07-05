<div class="modal fade" id="editCustomerModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body ajax-load">
				
				<div class="body customer-info">
				
						<div class="msg"><div class="alert"></div></div>
						
						<div class="form">
							<div class="form-title">Customer Information</div>
							<div class="form-body row">
								<?foreach([
								'Customer Name' => ['name'=>'name', 'class'=>'form-control required'],
								'Insurance Company' => ['name'=>'insurance_company', 'class'=>'form-control'],
								'Address' => ['name'=>'address', 'class'=>'form-control'],
								'PO #' => ['name'=>'po', 'class'=>'form-control'],
								'Estimator' => ['name'=>'estimator', 'class'=>'form-control'],
								'Claim #' => ['name'=>'claim', 'class'=>'form-control'],
								'Repair Order #' => ['name'=>'repair_order', 'class'=>'form-control'],
								'Phone Number' => ['name'=>'phone', 'class'=>'form-control'],
								] as $label => $attr):?>

								<div class="col-md-6">
									<label><?=$label?> <?if(preg_match('|required|',$attr['class'])):?><sup>*</sup><?endif;?></label>
									<?=set_input($attr)?>
								</div>
								<?endforeach;?>
								<div class="col-md-12">
									<label>Note</label>
									<input type = 'text' name = 'note' class = 'form-control'/>
									<!--<textarea class = 'form-control'></textarea >-->
								</div>
							</div>
						</div>
						
						<div>&nbsp;</div>
						
						<div class="form">
						<div class="form-title">Vehicle Information</div>
						<div class="form-body row">
							<?foreach([
								'VIN #',
								'Mileage',
								'Year',
								'Color',
								'Make',
								'Fuel',
								'Model',
								'Drop Off Date/Time',
								'Adjuster visit Date/Time',
								'Customer pick up the car Date/Time',
							] as $label):?>

							<div class="col-md-6">
								<label><?=$label?></label>
								<?if($label == 'Fuel'):?>
									<div class="clip-radio radio-primary">
                                        <?foreach(['F','3/4','1/2','1/4','E'] as $fuel):?>
                                        <input type="radio" name="fuel" id="fuel-<?=md5($fuel)?>" value="<?=strtolower($fuel)?>"><label for="fuel-<?=md5($fuel)?>"><?=$fuel?></label>
										<?endforeach;?>
                                    </div>

								<?elseif(preg_match('^(Drop|Adjuster|pick)^i',$label)):
								
								$name = 'datetime';
								if(preg_match('^adjuster^i',$label)){
									$name = 'adjuster_datetime';
								}elseif(preg_match('^pick^i',$label)){
									$name = 'pick_up_datetime';
								}
								?>
									<div class="input-group">
                                            <input type="text" class="form-control datetimepicker" name="<?=$name?>">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-primary appt_datetime">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
								<?else:?>
								<input type="text" class="form-control" name="<?=strtolower(preg_replace('|[^a-z]+|i','',$label))?>" />
								<?endif?>
							</div>
							<?endforeach;?>
							<input type="hidden" name="customer_id" value="<?=$user->id?>" />
                            <input type="hidden" name="appt_id" value="<?=@$user->appt_id?>" />
						</div>
					</div>
					     
						<div class="actions">
					    	<a href=".customer-info" class="btn btn-primary save">Save</a>
					    	<a href=".customer-info" class="btn btn-primary btn-o cancel">Cancel</a>
					    </div>
				</div>


			</div>
    	</div>
    </div>
</div>


<script>
	$('#editCustomerModal').on('shown.bs.modal', function() {
	    
	    $('.body', this).each(function(){
	    	var self = $(this);
		    ajaxCall('getCustomer',{id:<?=$user->id?>}, function(res){
				
				if(res.code == 200)
				self.find('input').each(function(){
					
					var attr_name = $(this).attr('name');
					var attr_type = $(this).attr('type');
					var value = res.body[attr_name];
					
					if($.inArray(attr_name,['datetime','adjuster_datetime','pick_up_datetime']) > -1 && value){
						value = $.format.date(value, "MM/dd/yyyy h:mm a")
					}
					
					if(value){
						if(attr_type == 'radio' || attr_type == 'checkbox'){
							$(this).prop('checked', $(this).val() == value);
						}
						else $(this).val(value);
					} 
				});
				self.fadeIn();
			});
	    });

	});
	

	
	$('#editCustomerModal').on('hidden.bs.modal', function(){
		$('.body', this).fadeOut();
	})
	
	
	$('#editCustomerModal .body').find('.save, .cancel').click(function(e){
		e.preventDefault();
		var body = $($(this).attr('href'));
		var modal = $('#editCustomerModal');
		if($(this).hasClass('save')){
			if(body.validateForm()){

				ajaxCall('updateCustomer', modal.find('input').serializeObject(), function(res){
					if(res.code==200){
						modal.animate({scrollTop: 0},400);
						showFormAlert(modal, res, function(){
							document.location.reload();
						}, 1000);
					}
				});
				
			
			}
		}
		else modal.modal('hide');
	});
	
</script>