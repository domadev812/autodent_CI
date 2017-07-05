<!DOCTYPE html>
<html>
<head>			
<title><?=get_title()?></title>	<?if(strlen($this->meta_desc)):?>
<meta name="description" content="<?=$this->meta_desc?>" /><?endif;?>	
<?if(strlen($this->meta_key)):?><meta name="keywords" content="<?=$this->meta_key?>"><?endif;?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">		
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css">	
	<link rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap.min.css">	
	<link rel="stylesheet" href="<?=base_url()?>assets/css/font-awesome.min.css">	
	<link rel="stylesheet" href="<?=base_url()?>assets/fonts/themify-icons/themify-icons.css">	
	<link rel="stylesheet" href="<?=base_url()?>assets/css/animate.min.css">
	<link rel="stylesheet" href="<?=base_url()?>assets/css/annotorious-dark.css" />
	<link rel="stylesheet" href="<?=base_url()?>assets/plugins/bs-datetimepicker/bootstrap-datetimepicker.min.css" />
	<link rel="stylesheet" href="<?=base_url()?>assets/plugins/bs-select/bootstrap-select.min.css" />
	<link rel="stylesheet" href="<?=base_url()?>assets/css/main.css?v=<?=get_css_version('main')?>">
	<link rel="stylesheet" href="<?=base_url()?>assets/css/calendar.css" />
	<link rel="stylesheet" href="<?=base_url()?>assets/css/modal.css" />
	
	<script>var BASE_URL = '<?=base_url()?>';</script>
	<script src="<?=base_url()?>assets/js/jquery-2.2.1.min.js"></script>	
	<script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script src="<?=base_url()?>assets/plugins/bs-datetimepicker/moment.js"></script>
	<script src="<?=base_url()?>assets/plugins/bs-datetimepicker/bootstrap-datetimepicker.min.js"></script>
	<script src="<?=base_url()?>assets/plugins/bs-select/bootstrap-select.min.js"></script>
	<script src="<?=base_url()?>assets/js/jquery.ui.touch-punch.min.js"></script>
	<script src="<?=base_url()?>assets/js/jquery.signature.min.js"></script>
	<script src="<?=base_url()?>assets/js/annotorious.js"></script> 
	<script src="<?=base_url()?>assets/js/jquery-dateFormat.min.js"></script> 
	<script src="<?=base_url()?>assets/js/jquery.html5_uploader.js"></script> 
	<script src="<?=base_url()?>assets/js/bootstrap-typeahead.js"></script> 
	<script src="<?=base_url()?>assets/js/functions.js"></script>	
	<script src="<?=base_url()?>assets/js/main.js"></script>
	<?if($this->ion_auth->logged_in()):?><script>console.debug('uid: <?=$this->curr_user->id?>')</script><?endif?>
</head>
<body>
<main> 