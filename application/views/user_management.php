

<div class="container-fluid  padding-bottom-10 full-height nopad" id="user_management">
	
	<div class="col-md-12 users-left-col">	

		<div class="row">
			<div class="col-md-8 col-md-offset-2 ">
				
				
				<?if($this->user_model->is_superadmin()):?>
				<div class="panel panel-white my_tasks margin-top-15">
			    <div class="panel-heading" data-toggle="collapse" data-target="#tasks_body"><i class="fa fa-cogs"></i>&nbsp; Edit Statuses</div>
			    <div class="panel-body collapse" id="tasks_body">
			    	<button class="btn btn-success update-status btn-block">
		        		<i class="ti-plus"></i> Add New
		        	</button>
					<div class="table-wrap">
						<table class="table margin-top-15">
							<?foreach($this->customers_model->getStatus() as $status):?>
							<tr>
								<td>
									<a title="Edit" class="btn btn-default update-status" data-name="<?=$status->name?>" data-id="<?=$status->id?>" href="#"><i class="fa fa-pencil"></i></a>
									&nbsp; <span class="title"><?=$status->name?></span>
									<a title="Delete" class="btn btn-danger pull-right delete-status" data-id="<?=$status->id?>" href="#"><i class="fa fa-remove"></i></a>
								</td>
							</tr>
							<?endforeach;?>
						</table>
					</div>	
			    </div>
			   </div>
				<?endif;?>
				
				
				
				<?if($this->user_model->is_dealer()):?>
				<div class="panel panel-white announcements margin-top-15">
			    <div class="panel-heading" data-toggle="collapse" data-target="#tasks_body"><i class="fa fa-cogs"></i>&nbsp; Edit Announcements</div>
			    <div class="panel-body collapse" id="tasks_body">
			    	<button class="btn btn-success update-announcement btn-block">
		        		<i class="ti-plus"></i> Add New
		        	</button>
					<div class="table-wrap">
						<table class="table margin-top-15">
							<?foreach($this->customers_model->getAnnouncements() as $announcement):?>
							<tr>
								<td>
									<a title="Edit" class="btn btn-default update-announcement" data-content="<?=$announcement->content?>" data-id="<?=$announcement->id?>" href="#"><i class="fa fa-pencil"></i></a>
									&nbsp; <span class="desc"><?=get_time_interval(strtotime($announcement->added))?></span> &nbsp; <span class="title"><?=character_limiter($announcement->content,60)?></span>
									<a title="Delete" class="btn btn-danger pull-right delete-announcement" data-id="<?=$announcement->id?>" href="#"><i class="fa fa-remove"></i></a>
								</td>
							</tr>
							<?endforeach;?>
						</table>	
			    	</div>
			    </div>
			   </div>
			  <?endif;?>
				
				
				
				<div class="panel panel-white margin-top-15 custom">
					<div class="panel-heading" data-toggle="collapse" data-target="#edit_users_body"><i class="fa fa-cogs"></i>&nbsp; Edit Users</div>
					<div class="panel-body collapse in" id="edit_users_body">
						<button class="btn btn-success btn-block add-user">
		        			<i class="ti-plus"></i> Add New
		        		</button>
						<div class="table-wrap">
							<table class="table margin-top-15">
								<?foreach($users as $user):?>
								<tr>
									<td>
										<a title="Edit" class="btn btn-default update-user" data-id="<?=$user->id?>" href="#"><i class="fa fa-pencil"></i></a>
										&nbsp; <span class="title"><?=$user->full_name?></span> <span class="desc"><?=$user->role?></span>
										
										<a title="Login" class="btn btn-info pull-right" href="<?=base_url()?>auth/login_as_user/<?=$user->id?>"><i class="fa fa-sign-in"></i></a>	
									</td>
								</tr>
								<?endforeach;?>
							</table>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<?if($this->user_model->is_superadmin()) $this->load->view('blocks/modal/status_modal');?>
<?if($this->user_model->is_dealer()) $this->load->view('blocks/modal/announcement_modal');?>


<?$this->load->view('blocks/modal/user_modal', array(
	'min_password_length' => $this->config->item('min_password_length', 'ion_auth'
)))?>