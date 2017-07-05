$(document).ready(function(){
	
	$('[data-toggle="tooltip"]').tooltip();
	
	$('#auth-form').submit(function(){
		var form = $(this);
		if(form.validateForm())
		$.post('/ajax', form.serialize(), function(res){
			res = JSON.parse(res);
			if(res.js) eval(res.js);
			showFormAlert(form, res);
		});
		return false;
	});
	
	

	$('.navbar .navbar-collapse').on('shown.bs.collapse', setCollapseHeight);
	$(window).resize(setCollapseHeight);
	
	
	
	$('#userModal form.save-user').submit(function(){
		var form = $(this);
		if(form.validateForm()){
			$('[type=submit].btn', form).prop('disabled', true);
			update_user(form.serializeObject(), function(res){
				if(res.js) eval(res.js);
				showFormAlert(form, res, function(){
					$('[type=submit].btn', form).prop('disabled', false);
				});
				
			});	
		}
		return false;
	});
	
	
	
	
	$('.btn.delete-user').click(function(){
		var id = parseInt($('#userModal form [name=id]').val());
		var btn = $(this);
		if(id){
			var str = prompt('Type DELETE for confirmation');
			if(str === 'DELETE'){
				 btn.prop('disabled', true);
				 $.post('/ajax',{id:id,function:'delete_user'}, function(res){
					res = JSON.parse(res);
					if(res.js) eval(res.js);
					showFormAlert($('#userModal form'), res, function(){
						btn.prop('disabled', false);
					});
				 }); 
			}
			else alert('Incorect input');
		}
		return false;
	});
	
	
	$('.btn.add-user, a.update-user').click(function(){
		var _modal = $('#userModal');
		_modal.find('form [type=text], form [type=password], form [type=email]').val('').removeClass('error');
		_modal.find('form [type=submit]').prop('disabled', false);
		update_user({id: $(this).attr('data-id')}, function(res){								
			
			if(parseInt(res.meta.id)>0){
				_modal.find('form [name=password],form [name=password_confirm]').removeClass('required').prop('required', false);
				_modal.find('.btn.delete-user').removeClass('hidden');
			}	
			else{
				_modal.find('form [name=password],form [name=password_confirm]').addClass('required').prop('required', true);
				_modal.find('.btn.delete-user').addClass('hidden');
			} 

			_modal.find('.modal-title').text(res.meta.modal_title);
			_modal.find('form [name=id]').val(res.meta.id);
			_modal.find('form [name=first_name]').val(res.meta.first_name);
			_modal.find('form [name=last_name]').val(res.meta.last_name);
			_modal.find('form [name=email]').val(res.meta.email);
			_modal.find('form [name=email]').attr('disabled', parseInt(res.meta.id)>0);
			_modal.find('form [name=group_id]').val(res.meta.group_id);
			_modal.modal('show');	
		});
		return false;
	});
	
	
	
	//$('#createCustomerModal').modal('show')
	//.setAddCustomerStep(2);
	
	/*var e = 1;
	var intId = setInterval(function(){
		$('#createCustomerModal').setAddCustomerStep(e);
		e++;
		//if(e>5) clearInterval(intId);
		if(e>5) e=1;
		
		
	},2000);*/
	
	
	
	
	
	$('.btn.add-customer').click(function(){
		var _modal = $('#createCustomerModal');
		_modal.setAddCustomerStep(1).modal('show');
		return false;
	});
	$('#createCustomerModal .next-step').click(function(){      var ids=parseInt($(this).attr('href')); 	  if(ids == 5) {$(".steps").hide();}
		$('#createCustomerModal').setAddCustomerStep(parseInt($(this).attr('href')));
		return false;
	});		
	$('#createCustomerModal .cancel').click(function(){
		$('#createCustomerModal').modal('hide');
		return false;
	});
	
	$('.outerradiodiv1').click(function(){		    $('#radio1').prop('checked','checked');		    $('.outerradiodiv1').addClass('activeradio1');		    $('.outerradiodiv2').removeClass('activeradio2');	});			$('.outerradiodiv2').click(function(){		   $('#radio2').prop('checked','checked');		  $('.outerradiodiv2').addClass('activeradio2');		  $('.outerradiodiv1').removeClass('activeradio1');	});	
	
	
});

$(document).ready(function(){
	
	$('[data-toggle="tooltip"]').tooltip();
	
	$('#auth-form').submit(function(){
		var form = $(this);
		if(form.validateForm())
		$.post('/ajax', form.serialize(), function(res){
			res = JSON.parse(res);
			if(res.js) eval(res.js);
			showFormAlert(form, res);
		});
		return false;
	});
	
	

	$('.navbar .navbar-collapse').on('shown.bs.collapse', setCollapseHeight);
	$(window).resize(setCollapseHeight);
	
	
	
	$('#userModal form.save-user').submit(function(){
		var form = $(this);
		if(form.validateForm()){
			$('[type=submit].btn', form).prop('disabled', true);
			update_user(form.serializeObject(), function(res){
				if(res.js) eval(res.js);
				showFormAlert(form, res, function(){
					$('[type=submit].btn', form).prop('disabled', false);
				});
				
			});	
		}
		return false;
	});
	
	
	
	
	$('.btn.delete-user').click(function(){
		var id = parseInt($('#userModal form [name=id]').val());
		var btn = $(this);
		if(id){
			var str = prompt('Type DELETE for confirmation');
			if(str === 'DELETE'){
				 btn.prop('disabled', true);
				 $.post('/ajax',{id:id,function:'delete_user'}, function(res){
					res = JSON.parse(res);
					if(res.js) eval(res.js);
					showFormAlert($('#userModal form'), res, function(){
						btn.prop('disabled', false);
					});
				 }); 
			}
			else alert('Incorect input');
		}
		return false;
	});
	
	
	$('.btn.add-user, a.update-user').click(function(){
		var _modal = $('#userModal');
		_modal.find('form [type=text], form [type=password], form [type=email]').val('').removeClass('error');
		_modal.find('form [type=submit]').prop('disabled', false);
		update_user({id: $(this).attr('data-id')}, function(res){								
			
			if(parseInt(res.meta.id)>0){
				_modal.find('form [name=password],form [name=password_confirm]').removeClass('required').prop('required', false);
				_modal.find('.btn.delete-user').removeClass('hidden');
			}	
			else{
				_modal.find('form [name=password],form [name=password_confirm]').addClass('required').prop('required', true);
				_modal.find('.btn.delete-user').addClass('hidden');
			} 

			_modal.find('.modal-title').text(res.meta.modal_title);
			_modal.find('form [name=id]').val(res.meta.id);
			_modal.find('form [name=first_name]').val(res.meta.first_name);
			_modal.find('form [name=last_name]').val(res.meta.last_name);
			_modal.find('form [name=email]').val(res.meta.email);
			_modal.find('form [name=email]').attr('disabled', parseInt(res.meta.id)>0);
			_modal.find('form [name=group_id]').val(res.meta.group_id);
			_modal.modal('show');	
		});
		return false;
	});
	
	
	
	//$('#createCustomerModal').modal('show')
	//.setAddCustomerStep(2);
	
	/*var e = 1;
	var intId = setInterval(function(){
		$('#createCustomerModal').setAddCustomerStep(e);
		e++;
		//if(e>5) clearInterval(intId);
		if(e>5) e=1;
		
		
	},2000);*/
	
	
	
	
	
	$('.btn.add-customer').click(function(){
		var _modal = $('#createCustomerModal');
		_modal.setAddCustomerStep(1).modal('show');
		return false;
	});
	$('#createCustomerModal .next-step').click(function(){      
	var ids=parseInt($(this).attr('href')); alert(ids);	  
	if(ids == 5) {$(".steps").hide();}
	
		$('#createCustomerModal').setAddCustomerStep(parseInt($(this).attr('href')));
	
		return false;
	});		
	$('#createCustomerModal .cancel').click(function(){
		$('#createCustomerModal').modal('hide');
		return false;
	});
	
	$('.outerradiodiv1').click(function(){		
    $('#radio1').prop('checked','checked');		 
	$('.outerradiodiv1').addClass('activeradio1');		   
	$('.outerradiodiv2').removeClass('activeradio2');	});	
	$('.outerradiodiv2').click(function(){		   $('#radio2').prop('checked','checked');	
	$('.outerradiodiv2').addClass('activeradio2');		
	$('.outerradiodiv1').removeClass('activeradio1');	});	
	

});









