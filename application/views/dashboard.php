<div class="breadcrumb-wrapper">
	<h4 class="no-margin mainTitle">Welcome to Auto Dent Company Portal</h4>
	<span>overview &amp; stats </span>
	<ul class="pull-right breadcrumb">
		<li><a href="/dashboard"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a></li>
		<li>Dashboard</li>
	</ul>
</div>
<div id="dashboard" class="container-fluid container-fullw padding-bottom-10">

	<div class="row">
		<div class="col-md-12 col-lg-9">			
			<div class="panel panel-white no-radius no-border">
				<div class="panel-body">		        	
		        	<div class="row">
		                           
                        <div class="col-md-12">
                            <div class="margin-bottom-30">
                                <?if(!$this->user_model->is_tech()):?>
                                <button class="btn btn-primary btn-o btn-wide add-customer">
                                    <i class="ti-plus"></i> Customer
                                </button>
                                <?endif?>
                            </div>
                        </div>
		             </div>
			         <div class="row">       
			                       																																															
                        <div class="col-md-12">
                            <h2 class="text-center margin-bottom-20 margin-top-20"><?=$calendar->getTitle($dash_interval)?></h2>
                        </div>
                        <div class="col-xs-8">
                            <div class="btn-group">
                                <button class="btn btn-primary" data-dash_name="dash_date" data-value="<?=$dash_prev?>">
                                    <i class="ti-angle-left"></i>
                                </button>
                                <button class="btn btn-primary" data-dash_name="dash_date" data-value="<?=$dash_next?>">
                                    <i class="ti-angle-right"></i>
                                </button>
                            </div>
                            <button data-dash_name="dash_date" data-value="<?=date('Y-m-d')?>" class="btn btn-primary btn-o">
                                Today
                            </button>
                        </div>
                        <div class="col-xs-4 text-right">
                            <div class="visible-md visible-lg hidden-sm hidden-xs">
                                <div class="btn-group">
                                    <?foreach(['year','month','week','day'] as $e):?>
                                    <label data-dash_name="dash_interval" data-value="<?=$e?>" class="btn btn-primary <?if($e == $dash_interval):?>active<?endif;?>"> <?=ucfirst($e)?> </label>
                                    <?endforeach;?>
                                </div>
                            </div>
                            <div class="visible-xs visible-sm hidden-md hidden-lg">
                                <div class="btn-group dropdown">
                                    <button type="button" class="btn btn-primary dropdown-toggle" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-cog"></i>&nbsp;<span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right dropdown-light" role="menu">
                                        <?foreach(['year','month','week','day'] as $e):?>
                                        <li><a href="#" data-dash_name="dash_interval" data-value="<?=$e?>" <?if($e == $dash_interval):?>class="active"<?endif;?>><?=ucfirst($e)?></a></li>
                                        <?endforeach;?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <form method="post" class="dash_form">
                        	<input type="hidden" name="dash_date" />
                        	<input type="hidden" name="dash_interval" value="<?=$dash_interval?>" />
                        </form>

					</div>
					
					<div class="row">
						<div class="col-md-12">
							<?$this->load->view('blocks/calendar/'.$dash_interval)?>
						</div>
					</div>
												
				</div>
			</div>
		</div>
		<div class="col-md-12 col-lg-3">
			<?if(!$this->user_model->is_dealer()):
			$announcements = $this->customers_model->getAnnouncements($this->user_model->getTopUserID('dealer'))
			?>
			<div class="panel panel-white announcements">
				<div class="panel-heading" data-toggle="collapse" data-target="#announcements_body">Announcements</div>
				<div class="panel-body collapse" id="announcements_body">
				<ul class="list">
				 	<?foreach($announcements as $a):?>
				 	<li> <small class="text-info"><?=get_time_interval(strtotime($a->added))?></small><br/> <?=url_to_link($a->content)?></li>
				 	<?endforeach;?>
				 </ul>	
				</div>
			</div>
			
			<?$myTasks = $this->customers_model->getMyTasks();?>
			<div class="panel panel-white my_tasks">
				<div class="panel-heading" data-toggle="collapse" data-target="#my_tasks_body">My Tasks</div>
				<div class="panel-body collapse" id="my_tasks_body">
				<ul class="list">
					<?foreach($myTasks as $task):?>
				 	<li class="<?=$task->color?>">
				 		<a href="/customers/get/<?=$task->id?>">
				 			<div class="sub"><?=date('m/d/y H:i A',strtotime($task->datetime))?></div>
				 			<div class="title"><?=$task->desc?></div>
				 			<div class="sub"><?=$task->name?></div>
				 		</a>
				 	</li>
				 	<?endforeach;?>
				 </ul>		
				</div>
			</div>
			<?endif;?>
			
			<?$queue = $this->customers_model->getQueue();?>
			<div class="panel panel-white queue">
				<div class="panel-heading" data-toggle="collapse" data-target="#queue_body">Queue</div>
				<div class="panel-body collapse <?=empty($queue)?'':'in'?>" id="queue_body">
				 <ul class="list">
				 	<?foreach($queue as $q):?>
				 	<li class="<?=$q->color?>">
				 		<a href="/customers/get/<?=$q->id?>">
				 			<div class="sub"><?=date('m/d/y H:i A',strtotime($q->datetime))?></div>
				 			<div class="title"><?=$q->desc?></div>
				 			<div class="sub"><?=$q->name?></div>
				 		</a>
				 	</li>
				 	<?endforeach;?>
				 </ul>	
				</div>
			</div>
			
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		var H = $('#dashboard .col-md-12.col-lg-9').height();
		var pos = $('#queue_body').parent().position();
		$('#queue_body').css({'max-height':H - pos.top - 71});
	});
</script>


<?$this->load->view('blocks/modal/create_customer')?>
<?$this->load->view('blocks/modal/edit_technician_cost')?>
<?$this->load->view('blocks/modal/financial_information')?>