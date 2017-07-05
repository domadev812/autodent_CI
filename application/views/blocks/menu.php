<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container-fluid nopad">

    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/"><?=$this->site_name?></a>
    </div>
	<div class="logo col-sm-2"><a href="/"><img src="/assets/images/logo.png" alt="<?=$this->site_name?>" /></a></div>
    <div class="collapse navbar-collapse" id="navbar-collapse">
     
	   
	    <?if(!$this->user_model->in_group(['superadmin'])):?>
	    <ul class="nav navbar-nav navbar-left hidden-sm hidden-xs">         
	      <li>
	      	
	      	<form role="search" class="navbar-form" method="post">
	            <div class="form-group">
	                <input type="text" id="glob_search" autocomplete="off" placeholder="Enter search text here..." class="form-control">
	                <button class="btn search-button">
	                    <i class="fa fa-search"></i>
	                </button>
	            </div>
	        </form>
	      </li> 	
	    </ul>
	    <?endif;?>
	             
	      <ul class="nav navbar-nav navbar-right">        
	        <?if($this->user_model->in_group(['superadmin','dealer','manager'])):?>
	        <li><a href="/users" data-toggle="tooltip" data-placement="bottom" title="User Management"><i class="fa fa-user-plus"></i></a></li> 	
	        <?endif;?>
	        
	        <?if($this->user_model->in_group(['dealer','manager','sales','tech'])):?>
	        <li><a href="/customers" data-toggle="tooltip" data-placement="bottom" title="Customers"><i class="fa fa-users"></i></a></li> 	
			<li class="dropdown" id="alerts" >
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bell"></i><span class="badge"></span></a>
				<ul class="dropdown-menu dropdown-light dropdown-messages dropdown-large animated fadeInUpShort">
					<li><span class="dropdown-header">New notifications</span></li>
					<li>
						<div class="drop-down-wrapper ps-container">
							<div class="list-group no-margin"></div>
						</div>
					</li>
					<!--<li class="view-all"><a href="javascript:void(0)">See All</a></li>-->
				</ul>
			</li>
        	<?endif;?>
        	<?if($this->user_model->in_group(['superadmin','dealer','manager'])):?>
	        <li><a data-toggle="tooltip" class = 'menu financial-information' data-placement="bottom" title="Financial Information"><i class="fa fa-book"></i></a></li> 	
	        <?endif;?>
        
         		 		
        <li><a href="#" class="upper" data-toggle="tooltip" data-placement="bottom"><?=$this->curr_user->username?></a></li> 		
        <li><a href="/auth/logout" data-toggle="tooltip" data-placement="bottom" title="Log Out"><i class="fa fa-power-off"></i></a></li>
        <li>&nbsp;</li>
      </ul>
      
    </div>
    
  </div>
</nav>