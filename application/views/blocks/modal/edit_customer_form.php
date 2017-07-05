<div class="modal fade" id="editCustomerFormModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body ajax-load">
				<div class="body body3 row" style="display:block">
				
						<div class="sub-pages col-xs-12">
							
							<div class="page adp-page">
							  	<h2>Authorization and Direction to Pay</h2>
								<div class="row">
									<div class="col-sm-4 location noselect TX">
										<div class="wr">
											<img src="/assets/images/circle-icon-img-right.png" >
											<div class="info">4535 Spring Cypress Rd. Spring, TX 77388</div>
										</div>
										<input type="checkbox" name="location" value="TX">
									</div>
									<div class="col-sm-4 location noselect NM">
										<div class="wr">
											<img src="/assets/images/circle-icon-img.png" >
											<div class="info">1712 W. Hadley Ave. Ste A Las Cruces, NM 88005</div>
										</div>
										<input type="checkbox" name="location"  value="NM">
									</div>
									<div class="col-sm-4 nopad">
										<div class="form">
											<div class="form-title">Customer/Vehicle Information</div>
											<div class="form-body">
												<p>Customer/Vehicle Information</p>
												<p><span class="_c_name"></span></p>
												<p><span class="_c_year"></span> <span class="_c_make"> </span> <span class="_c_model"></span> <span class="_c_color"></span></p>
												<p class="_c_vin"></p>
												<p class="_c_claim"></p>
												<p>Date of Loss</p>
											</div>
										</div>
										<div>
											<p style="font-size:11px;">I authorize Auto Dent Company LLC to repair my vehicle.  I authorize <strong>Insurance Company Name</strong> to pay Auto Dent Company LLC directly for repairs performed to my vehicle.</p>
										</div>
					                    <div class="sig-block sig-adp-block text-center">
											<div data-btn="esign-adp" style="width:270px;height:75px;" class="sig-adp"></div>
											<input type="hidden" name="sig-adp" />
											<p style="clear: both; margin-top: 5%;">
												<button class="sig-btn clear-sig-adp">CLEAR</button> 
												<button class="sig-btn close-sig-adp">CLOSE</button>
											</p>
										</div>
										<a class="esign-btn margin-top-20 esign-adp">Customer e-Sign</a>
									</div>
								</div>
								<div class="pull-right margin-top-20">
									<a href="adp-page"  class="btn btn-primary save-adp" data-target="authorization_and_direction_to_pay">Save</a>
									<a href="adp-page" class="btn btn-primary btn-o close-pages">Cancel</a>
								</div>
							</div>
	
							
							<div class="pdr-page page">	
				                <h2>Prior Damage Report</h2>
								
								<div class="row">
			
									<div class="col-md-7">
										<p class="top-title">
											<span class="_c_name"></span><br/> <span class="_c_year"></span> <span class="_c_make"></span> <span class="_c_model"></span>
										</p>
										<div>
											<img id="hallstatt2" src="/assets/images/640px-Hallstatt.jpg" class="annotatable" style="width: 100% !important;">
										</div>
									</div>
									<div class="col-md-5">
										<div class="form">
											<div class="form-title">
												<p>Dings, Dents, Scratches &Scuffs</p>
											</div>
											<br>
											<div class="form-body">
												 <ul class="inserttext"></ul>
												 <div class="addtext-group">
												 	<input type="text" value="" class="addtextval">
												 	<div class="addtext"></div>
												 </div>
											</div>
										</div>
										<div>
											<p style="font-size:11px;">To ensure customers can continue to receive excellent auto hail repair, this report is necessary. Door dings and other repairs will not be fixed during repairs unless specified on the “notes” section of the repair authorization. I agree and understand that everything listed on the above diagram is true and correct to the best of my knowledge, and I understand that the damage listed WILL NOT be  fixed upon or by the return of my vehicle. Auto Dent Company is not responsible for previous damage unrelated to hail.
											</p>
											
										</div>
										<div class="sig-block sig-pdr-customer-block text-center">
												<div data-btn="esign-pdr-customer" style="width:270px;height:75px;" class="sig-pdr-customer"></div>
												<input type="hidden" name="sig-pdr-customer" />
												<p style="clear: both; margin-top: 5%;">
													<button class="sig-btn clear-sig-pdr-customer">CLEAR</button> 
													<button class="sig-btn close-sig-pdr-customer">CLOSE</button>
												</p>
										</div>
											
										<div class="sig-block sig-pdr-adc-block text-center">
												<div data-btn="esign-pdr-adc" style="width:270px;height:75px;" class="sig-pdr-adc"></div>
												<input type="hidden" name="sig-pdr-adc" />
												<p style="clear: both; margin-top: 5%;">
													<button class="sig-btn clear-sig-pdr-adc">CLEAR</button> 
													<button class="sig-btn close-sig-pdr-adc">CLOSE</button>
												</p>
													
										</div>
										
										
										<div class="esign-two">
											<a class="esign-btn margin-top-20 esign-pdr-customer">Customer e-Sign</a>
											<a class="esign-btn margin-top-20 esign-pdr-adc">ADC Rep e-Sign</a>
										</div>
									</div>	
									
								</div>
								<input type="hidden" name="annotations" />
								
								<div class="pull-right margin-top-20">
									<a href="pdr-page" class="btn btn-primary save-pdr" data-target="prior_damage_report">Save</a>
									<a href="pdr-page" class="btn btn-primary btn-o close-pages">Cancel</a>
								</div>
							</div>
						
						
							<div class="ra-page page">	
				                
				                <?php
				                	
				                	$checkboxes = [
				                		'Parts Replace' => [
				                			'LF Belt',
				                			'LR Belt',
				                			'RF Belt',
				                			'RR Belt',
				                			'L Drip',
				                			'R Drip',
				                			'Front Applique: L/R',
				                			'Rear Applique: L/R',
				                			'Windshield',
				                			'Quarter Glass Mldg: L/R',
				                			'L Tail Light',
				                			'R Tail Light',
				                			'Third Brake Light',
				                			'Cowl',
				                			'Front Scalp L/R',
				                			'Rear Scalp L/R',
				                		],
				                		'R & I Information' => [
				                			'Hood Assy',
				                			'R&I Information',
				                			'Hood Insulator',
				                			'Decklid Assy',
				                			'Decklid Trim',
				                			'Head Light: L/R',
				                			'Marker Light: L/R',
				                			'Grille',
				                			'Headliner',
				                			'Sunroof Frame',
				                			'Luggage Rack',
				                			'Front Door Panel',
				                			'Rear Door Panel: L/R',
				                			'Bumper Cover: F/R',
				                			'Antenna',
				                			'Qtr. Trim Panel: L/R',
				                			'Fender Liner: L/R',
				                			'Tail Light: L/R',
				                			'Spoiler',
				                			'Qtr. Glass: L/R',
				                			'Liftgate Glass',
				                			'Liftgate Trim',
				                			'Liftgate Assy',
				                			'Highmount Lamp',
				                			'Tailgate Assy',
				                			'Cabside Panel: L/R',
				                			'Other',
				                		]
				                	];
				                ?>
				                
				                
				                
				                <h2>Repair Authorization</h2>
				                <div class="row">
				                	<?foreach($checkboxes as $form_title => $arr):?>
				                	<div class="col-sm-6">
				                		<div class="form">
											<div class="form-title"><?=$form_title?></div>
											<div class="form-body">
												<ul class="checkboxes">
													<?foreach($arr as $i => $cbx):?>
													<li>
														<div class="checkbox clip-check check-primary">
									                        <input type="checkbox" name="<?=strtolower(str_replace(' ','_',$form_title))?>" id="<?=md5($cbx)?>_2" value="<?=$cbx?>" />
									                        <label class="noselect" for="<?=md5($cbx)?>_2"> <?=$cbx?> </label>
									                    </div>
													</li>
													<?endforeach;?>
												</ul>
											</div>
										</div>
				                	</div>
									<?endforeach;?>
									<div class="col-sm-12">
										<ul class="list-group">
											<li>1.01 PERMISSION TO REPAIR & RELEASE. I authorize the repair of my vehicle and grant permission to
											this company’s employees to operate the vehicle for the purpose of testing and/or inspection.
											I agree that AutoDent is not responsible for the loss of damage to this vehicle and/or articles left in 
											the vehicle due to …. Beyond its control. __________ Initial
											</li>
											<li>1.02 ADDITIONAL REPAIRS & PRIOR DAMAGE. I acknowledge that if closer analysis reveal additional repairs are necessary</li>
											<li>1.03 PAYMENT. I agree to pay for all repair charges, not previously paid to AutoDent by my insurance company, and  </li>
											<li>1.04 FAILURE TO PAY. In the event that I fail to pay pursuent to paragraph 1.02, I acknowledge an expressed mechanic’s lien on the vehicle in</li> 
										</ul>
									</div>
									
									<div class="col-sm-4 margin-top-10">
										<div class="sig-block sig-ra-block text-center">
											<div data-btn="esign-ra" style="width:270px;height:75px;" class="sig-ra"></div>
											<input type="hidden" name="sig-ra" />
											<p style="clear:both; margin-top:5%;">
												<button class="sig-btn clear-sig-ra">CLEAR</button> 
												<button class="sig-btn close-sig-ra">CLOSE</button>
											</p>
										</div>
										<a class="esign-btn margin-top-15 esign-ra">Customer e-Sign</a>
									</div>
									<div class="col-sm-8 margin-top-20">
										<div class="pull-right">
											<a href="ra-page" class="btn btn-primary save-ra" data-target="repair_authorization">Save</a>
											<a href="ra-page" class="btn btn-primary btn-o close-pages">Cancel</a>
										</div>
									</div>
				                </div>
				                
				            </div>


							<div class="page invoice-page" data-id="invoice" data-title="Invoice">
							  	<h2>Invoice</h2>
								<div class="row">
									<div class="col-md-12">
										<div class="top-title">
											<span class="_c_name"></span><br/>
											<span class="_c_year"></span> <span class="_c_make"></span> <span class="_c_model"></span>
										</div>
									</div>
									<div class="col-md-12">
										<table class="table">
											<tr>
												<td>Complete Hail Damage Repair</td>
												<td><input type="text" data-operator="+" class="filterInputFloat" name="Complete Hail Damage Repair" value="0" /><span>$</span></td>
											</tr>											
											<tr>
												<td>Customer Deductible</td>
												<td><input type="text" data-operator="-"  class="filterInputFloat" name="Customer Deductible" value="0" /><span>$</span></td>
											</tr>
											<tr class="hide noprint"><td><i class="fa fa-times"></i></td></tr>											
											<tr class="noprint">	
												<td align="right" colspan="2">
													<a href="#" data-toggle="modal"  data-target="#add-field-invoice-modal-2" class="btn btn-xs btn-success add-field"> <i class="fa fa-plus"></i> Add Field</a>
												</td>
											</tr>											
											<tr>	
												<td>Net Cost</td>
												<td><input type="text" class="net" disabled name="net" /><span>$</span></td>
											</tr>
											<tr>	
												<td colspan="2" class="t-footer">
													<div class="total">Total Due: $ <b>0</b></div>
												</td>
											</tr>
										</table>
									</div>
								</div>
								<div class="pull-right margin-top-20 noprint">
									<a href="#" class="btn btn-primary btn-o print-invoice"><i class="fa fa-print"></i></a>
									<a href="invoice-page" class="btn btn-primary save-invoice" data-target="invoice">Save</a>
									<a href="invoice-page" class="btn btn-primary btn-o close-pages">Cancel</a>
								</div>
							</div>
						
						</div>
							
					



				</div>
			</div>
    	</div>
    </div>
</div>



<?$this->load->view('blocks/modal/add_field_invoice.php',['m_num'=>2])?>

