<?$this->load->view('includes/html')?>
<?if(empty($this->emptyPage)):?>
<?$this->load->view('includes/header')?>
<div class="wrap"><?$this->load->view($view)?></div>	
<?$this->load->view('includes/footer')?>
<?else:?>
<?$this->load->view($view)?>
<?endif;?>

