<?php
	
	$today =$calendar->getCurrentDate();
	$appts = [];
	if(!empty($today)){
		$appt_from = $today;
		$appt_to = $today;
		$appts = $this->customers_model->getSchedule($appt_from, $appt_to);
	}
?>



<div class="calendar day">	
	<div class="wr">
	<div id="col-<?=$today?>" class="col cell">
		<?if(!empty($appts[$today])): foreach($appts[$today] as $appt):?>
			<a href="#" onclick="return false;">
			<div class="appointment">
				<div class="point <?=$appt->date_color?>"></div>
				<?=$appt->name?>(<?=$appt->date_name?>, <?=date('h:i A',strtotime($appt->task_datetime))?>)
				<button class="btn btn-primary btn-sm pull-right edit-appt" data-id="<?=$appt->customer_id?>">
					<i class="ti-pencil"></i>
				</button>
				&nbsp;
				<button class="btn btn-danger btn-sm margin-right-10 delete-appt" data-id="<?=$appt->id?>">
					<i class="ti-close"></i>
				</button>
			</div>
			</a>				
		<?endforeach;?>
		<?endif;?>
		</ul>
	</div>
	</div>
</div>

