



<div class="modal fade" id="createCustomerModal" tabindex="-1" role="dialog">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      	<div class="modal-body">

        	<h2>Create a Customer</h2>

       		<ul class="steps">

       			<li class="divider"></li>

       			<li> <b>1</b> <span>Customer Information</span> </li>

				<li> <b>2</b> <span>Vehicle Information</span> </li>

				<li> <b>3</b> <span>Forms & Approvals</span> </li>

				<li> <b>4</b> <span>Authorize</span> </li>

       		</ul>

       

			<div class="body body1 row">

				<div class="col-md-8 col-md-offset-4 nopad">

					<div class="form">

						<div class="form-title">Customer Information</div>

						<div class="form-body row">

							<?foreach([

								

								'Customer Name',

								'Insurance Company',

								'Address',

								'PO #',

								'Estimator',

								'Claim #',

								'Repair Order #',

								'Phone Number',

							

							] as $label):?>

							<div class="col-md-6">

								<label><?=$label?> <sup>*</sup></label>

								<input type="text" class="form-control" />

							</div>

							<?endforeach;?>

						</div>

					</div>

					<div class="actions">

						<a href="2" class="btn btn-primary next-step">OK</a>

						<a href="#" class="btn btn-primary btn-o cancel">Cancel</a>

					</div>

				</div>

			</div>

			<div class="body body2 row">

				<div class="col-md-8 col-md-offset-4 nopad">

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



							

							] as $label):?>

							<div class="col-md-6">

								<label><?=$label?> <sup>*</sup></label>

								<?if($label == 'Fuel'):?>

									<div class="clip-radio radio-primary">

                                        <?foreach(['F','3/4','1/2','1/4','E'] as $fuel):?>

                                        <input type="radio" name="fuel" id="fuel-<?=md5($fuel)?>" value="<?=$fuel?>"><label for="fuel-<?=md5($fuel)?>"><?=$fuel?></label>

										<?endforeach;?>

                                    </div>

								<?elseif($label == 'Drop Off Date/Time'):?>

								

									<div class="input-group">

                                            <input type="text" class="form-control" name="masked">

                                            <span class="input-group-btn">

                                                <button type="button" class="btn btn-primary">

                                                    <i class="fa fa-calendar"></i>

                                                </button>

                                            </span>

                                        </div>

								

								

								<?else:?>

								<input type="text" class="form-control" />

								<?endif?>

							</div>

							<?endforeach;?>

						</div>

					</div>

					<div class="actions">

						<a href="3" class="btn btn-primary next-step">Start Forms</a>

						<a href="#" class="btn btn-primary btn-o">Save</a>

						<a href="#" class="btn btn-primary btn-o cancel">Cancel</a>

					</div>

				</div>

			</div>

			<div class="body body3 row">

				<div class="col-md-8 col-md-offset-4 nopad">

					<div class="form">

						<div class="form-title">Forms & Approvals</div>

						<div class="form-body">

							<div class="info">

								Enter security question in case you lose access to your account.<br/>

								Be sure to pick questions that you will remember the answer to.

							</div>

							<ul class="f_a_list">

								<li>Repair Authorization <i class="fa fa-check"></i></li>

								<li>

									Rental Agreement 

								

									<div class="clip-radio radio-primary r_a">

                                        <input type="radio" id="accept" name="action" value="accept">

                                        <label for="accept">

                                            Accept

                                        </label>

                                        <input type="radio" id="decline" name="action" value="decline" checked="checked">

                                        <label for="male">

                                            Decline

                                        </label>

                                        <a href="#">Rental Coverage</a>

                                    </div>

								</li>

								<li class="auth"><a href="5" class="next-step">Authorization and Direction to Pay </a><i class="ti-angle-right"></i></li>

								<li>Prior Damage Report <i class="ti-angle-right"></i></li>

								<li>Invoice <i class="ti-angle-right"></i></li>

							</ul>

						</div>

					</div>

					<div class="actions">

						<a href="4" class="btn btn-primary next-step">Save</a>

						<a href="#" class="btn btn-primary btn-o cancel">Cancel</a>

					</div>

				</div>

			</div>
            
			<div class="body body5 row">

				<div class="col-md-3 col-md-offset-1 nopad cl-bdr">
						<img src="<?php echo base_url();?>/assets/images/circle-icon-img.png" >
						<p class="ptext">4535 Spring Cypress Rd.
			   			Spring, TX 77388</p>
				</div>

				<div class="col-md-3 col-md-offset-1 nopad cl-bdr">
					<p class="ptext">1712 W. Hadley Ave. Ste A
					Las Cruces, NM 88005</p>
				</div>

				<div class="col-md-3 col-md-offset-1 nopad">

					<div class="form">

						<div class="form-title">Customer/Vehicle Information</div>

						<div class="form-body">

							<p>Customer/Vehicle Information</p></legend>
							<p>Customer Name/Vehicle Owner Name</p>
							<p>Year Make Model Color</p>
							<p>VIN#</p>
							<p>Claim#</p>
							<p>Date of Loss</p>
							
						</div>

					</div>
					<div>
							<p style="margin-top:5%; font-size:12px;">I authorize Auto Dent Company LLC to repair my vehicle.  I authorize <strong>Insurance Company Name</strong> to pay Auto Dent Company LLC directly for repairs performed to my vehicle.</p>
					</div>

					<div>
						<input type="button" value="Customer e-Sign" class="esignbtn">
					</div>

					<div class="actions">

						<a href="4" class="btn btn-primary next-step">Save</a>

						<a href="#" class="btn btn-primary btn-o cancel">Cancel</a>

					</div>

				</div>

			</div>
			<div class="body body4">

				<div class="t">

					<div class="cell text-center">

						<i class="ti-check"></i>

						<h1>Congratulations!</h1>

						<div class="info">

							Customer Name's Make Model has been added to the schedule!<br/>

							Check the Queue for updates.

						</div>

						<div class="row actions">

							<div class="col-sm-6">

								<a href="#" class="btn btn-primary btn-o btn-block cancel">Queue</a>

							</div>

							<div class="col-sm-6">

								<a href="#" class="btn btn-primary btn-o btn-block cancel">Customer</a>

							</div>

						</div>

					</div>					

				</div>	

			</div>

      

      

    	</div>

    </div>

  </div>

</div>