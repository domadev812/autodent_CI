<?php
	$calendarItems = $calendar->getYear();
	
	$appts = [];
	$weekItems = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Notes/To-Do'];
	$firstDate = date('Y-m-d',strtotime("last Sunday"));
	
	if(!empty($calendarItems)){
		reset($calendarItems);
		$appt_from = key($calendarItems);
		end($calendarItems);
		$appt_to = key($calendarItems);
		$appts = $this->customers_model->getSchedule($appt_from.'-01', $appt_to.'-31');
	}
?>

<div class="calendar week">
		
	<?$i = 1;foreach($calendarItems as $month => $opt):?>
		<?if($i % 4 == 1) echo '<div class = "wr">';
			$notify_count = 0;
		?>
			<div id="col-<?=$month?>" class="col cell <?=$opt->classes?>">
				<b><?=$opt->month?></b>
				<?foreach($appts as $date => $appt):
					$key = substr($date,0,7);
					if($key == $month):
					foreach($appt as $one){
						$notify_count ++;
					}?>
				<?endif;endforeach;?>
				<?if($notify_count != 0):?>
					<div class="notify"><?echo $notify_count;?></div>
				<?endif?>		
			</div>			
		<?if($i % 4 == 0) echo '</div>';?>
	<?$i ++ ;endforeach;?>
	
	<ul class="appts">
		<?
		foreach($appts as $date => $appt):
		
		$key = substr($date,0,7);
		foreach($appt as $one):
		?>
		<li data-col="col-<?=$key?>" data-id="<?=$one->id?>">
			<a href="#" onclick="return false;">
			<div class="point <?=$one->date_color?>"></div>
			<div class="name capit"><?=$one->name?></div>
			<div class="time">(<?=$one->date_name?>, <?=date('h:i A',strtotime($one->task_datetime))?>)</div>
			</a>
			
			<div class="btns">
				<button class="btn btn-danger btn-sm margin-right-10 delete-appt" data-id="<?=$one->id?>"><i class="ti-close"></i></button>
				<button class="btn btn-primary btn-sm pull-right edit-appt" data-id="<?=$one->customer_id?>"><i class="ti-pencil"></i></button>
			</div>
			
		</li>
		<?endforeach;endforeach;?>
	</ul>
</div>
<script>
	$('.calendar .wr').eq($('.calendar .wr').length-1).addClass('last');
	
	$('.calendar .col.cell').click(function(){
		if($(this).hasClass('disabled')) return false;
		//--
		$(".appts").slideUp(0);
		$('.calendar .col.cell').removeClass('active');
		$(this).addClass('active');
		//--
		var id = $(this).attr('id');
		$(".appts").detach().insertAfter($(this).parent());
		$('.appts > li').hide(0,function(){
			$('.appts > li').each(function(){
				if($(this).attr('data-col') == id) $(this).show();
			});
		});
		$(".appts").slideDown(300);
		return false;
	});
	
	$('.calendar .col.cell .chevron').click(function(){
		$(".appts").slideUp(0);
		$(this).parent(this).removeClass('active');
		return false;
	});
</script>

