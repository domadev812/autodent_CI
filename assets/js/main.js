$(document).ready(function(){
	
	//$('.mtooltip').tooltip();
	/*$('.datepicker').on('keydown', function(e){e.preventDefault()}).datepicker().on('changeDate', function(e) {
        $(this).change();
    });*/
    
    $('.datetimepicker').datetimepicker().on('keydown', function(e){e.preventDefault()});
    $('.selectpicker').selectpicker({width: '100%'});
    
	
	$('#glob_search').typeahead({
        item: '<li onclick="document.location.href = '+ BASE_URL +'\'customers/get/\'+$(this).attr(\'data-value\')"><a href="#"></a></li>',
        ajax: { 
	        url: BASE_URL + 'dashboard/search',
	        triggerLength: 1,
	        displayField: 'label_info'
        }
    }).parent().find('.search-button').click(function(){
    	$('#glob_search').typeahead('show');
    	return false;
    });
	
	
	
	
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
				 $.post(BASE_URL + 'ajax',{id:id,function:'delete_user'}, function(res){
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
			_modal.find('form [name=group_id]').val(res.meta.group_id).change();
			
			$('#user-creator_id').on('ready.TopUsers',function(){
				_modal.find('form [name=creator_id]').val(res.meta.creator_id).change();
			});
			
			_modal.modal('show');	
		});
		return false;
	});
	
	
	$('#userModal form [name=group_id]').on('change',function(){		
		var el = $('#user-creator_id');
		el.slideUp().find('select').html('');
		getTopUsers($(this).val(), $('#userModal form [name=id]').val() ,function(list){
			if(list.length){
				$.each(list, function(i,o){
					var opt = $('<option/>').attr('value',o.id).text(o.full_name + ' ('+o.role+')')
					el.find('select').append(opt);
				});
				el.slideDown().find('select').selectpicker('refresh');
				el.trigger('ready.TopUsers');
			}
			
		})
		
		
	});
		
	
	$('.menu.financial-information').click(function(){
		var _modal = $('#viewFinancial');
		_modal.setAddCustomerStep(1).modal('show');
		return false;
	});	
		
	$('.btn.update-status').click(function(){
		var _modal = $('#statusModal');
		var id = $(this).data('id');
		var name = $(this).data('name');
		_modal.find('[name=name]').val(name ? name : '');
		_modal.find('[name=id]').val(id ? id : '');
		_modal.modal('show');
	});
	
	$('.btn.delete-status').click(function(){
		var str = prompt('Type DELETE for confirmation');
		if(str === 'DELETE'){
			ajaxCall('delete_status', {id:$(this).data('id')}, function(res){
				if(res.code == 200) document.location.reload();
			});
		}
	});
	
	$('form.update-status').submit(function(){
		var form = $(this);
		ajaxCall('update_status', form.serializeObject(), function(res){
			showFormAlert(form, res, function(){
						if(res.code == 200) document.location.reload();
			},1000);
		});
		return false;
	});	
	
	
	
	
	
	$('.btn.update-announcement').click(function(){
		var _modal = $('#announcementModal');
		var id = $(this).data('id');
		var content = $(this).data('content');
		_modal.find('[name=content]').val(content ? content : '');
		_modal.find('[name=id]').val(id ? id : '');
		_modal.modal('show');
	});
	
	$('.btn.delete-announcement').click(function(){
		var str = prompt('Type DELETE for confirmation');
		if(str === 'DELETE'){
			ajaxCall('delete_announcement', {id:$(this).data('id')}, function(res){
				if(res.code == 200) document.location.reload();
			});
		}
	});
	
	$('form.update-announcement').submit(function(){
		var form = $(this);
		ajaxCall('update_announcement', form.serializeObject(), function(res){
			showFormAlert(form, res, function(){
						if(res.code == 200) document.location.reload();
			},1000);
		});
		return false;
	});
		
	setScroll_x(); $(window).resize(setScroll_x);

	
	$('.btn.add-customer').click(function(){
		var _modal = $('#createCustomerModal');
		_modal.setAddCustomerStep(1).modal('show');
		return false;
	});
	
	$('#createCustomerModal .next-step').click(function(){        
		var ids=parseInt($(this).attr('href')); 	 
		if(ids == 5) {$(".steps").hide();}
		$('#createCustomerModal').setAddCustomerStep(parseInt($(this).attr('href')));
		return false;
	});		
	$('#createCustomerModal .cancel').click(function(){
		$('#createCustomerModal').modal('hide');
		return false;
	});
	
	
	$('#createCustomerModal .body3').subPages();
	
	
	$('#editCustomerFormModal .body3').editForms();
	
	
	
	


	
	
	
	$('#dashboard [data-dash_name]').on('click',function(){
		var name = $(this).attr('data-dash_name');
		var value = $(this).attr('data-value');
		$('#dashboard .dash_form [name='+name+']').val(value);
		$('#dashboard .dash_form').submit();
		return false;
	});
	
	
	$('.calendar .delete-appt').click(function(){
		var id = $(this).attr('data-id');
		ajaxCall('delete_schedule', {id:id}, function(){
			$('.calendar [data-id='+id+']').fadeOut(300, function(){$(this).remove()})
		})
	});
	
	$('.calendar .edit-appt').click(function(){
		document.location.href= BASE_URL + 'customers/get/' + $(this).attr('data-id');
	});
	
	
	
	
	
	
	
	
	$(document).on('load.c_form', function(e, data){
		
		if(typeof data.target !== 'undefined' && typeof data.customer_id !== 'undefined' && data.customer_id>0)
			
			var body = $('#'+ (typeof data.modal == 'string' ? data.modal : 'createCustomerModal') + ' .body3');
		
			
			ajaxCall('getForm',{target:data.target, customer_id:data.customer_id}, function(res){
				
				var b = JSON.parse(res.body);
				
				var link_selector = '[data-toggle=customer_form][data-target='+data.target+']';
				if(typeof data.modal == 'string') link_selector = '.form-onpage '+ link_selector;
				else link_selector += '.sub-page';
				
				$(link_selector).next().html('<i class="'+(b.passed==1 ? 'fa fa-check' : 'ti-angle-right')+'"></i>');
				
				

				
				
				if(typeof data.cb == 'function') data.cb(b);
					
				$.each(b, function(key, value){
					
					if($.inArray(key, ['parts_replace','r_&_i_information','location']) > -1){
						if(typeof value == 'string') $(':checkbox[name="'+key+'"][value="'+value+'"]', body).prop('checked',true);
						else $.each(value, function(i,v){
							$(':checkbox[name="'+key+'"][value="'+v+'"]', body).prop('checked',true);
						});
						
						if(key == 'location' && value != ''){
							$('.location', body).removeClass('active');
							$('.location.'+value, body).addClass('active');
						}
						
					}
					else if(key == 'pdr-text-items'){
						$('.inserttext', body).html('');
						var appendval = {data:'',add:function(val){this.data += '<li>' + val + '<input type="hidden" name="pdr-text-items" value="'+val+'" /></li>'}};
						if(typeof value == 'string') appendval.add(value); 
						else $.each(value, function(i,v){
							appendval.add(v);
						});
						$('.inserttext', body).append(appendval.data);	
					}
					else if(typeof value == 'object') $('[name="'+key+'"]', body).val(value.value);
					else $('[name="'+key+'"]', body).val(value);
					
					
					
					if($.inArray(key, ['sig-adp','sig-pdr-customer','sig-pdr-adc','sig-ra']) > -1 && value != ''){
						$('.'+key, body).signature('draw', value);
					}
					else if(key == 'annotations' && value != ''){
						var an = JSON.parse(value);
						if(typeof an == 'object'){
							anno.removeAll();
							$.each(an, function(i,obj){anno.addAnnotation(obj)})
						}	
					}
				});
				
				if(data.target == 'invoice'){
					
					var tr = body.find('.table td:has(.fa-times):last').parent();
					$.each(b, function(k,o){
						if(!body.find('.table [name="'+k+'"]').length && k != 'passed')
						var line = '<tr><td><i class="fa fa-times"></i>'+k+'</td><td><input type="text" data-operator="'+o.operator+'"  class="filterInputFloat" name="'+k+'" value="'+o.value+'" /><span>$</span></td></tr>';
						if(tr) tr.after(line); else body.find('.table').prepend(line);
					});
					
					$('.invoice-page', body).trigger('calc.invoice');
				}
				
				
				
			}, typeof data.async === true ? true : false)
	});
	
	$(document).on('save.c_form', function(e, data){
		$(this).trigger('load.c_form', [data]);
	});
	
	
	$('[data-toggle=customer_form].sub-page').on('click',function(){
		$(document).trigger('load.c_form',[{target:$(this).data('target'), customer_id:$('#customer_id').val()}]);
		if($(this).data('target')!='rental_agreement')
			ajaxCall('getCustomer',{id:$('#customer_id').val()}, function(res){
				if(res.code==200){
					$.each(res.body, function(key, value){
						$('#createCustomerModal ._c_'+key).text(value)
					})
				}
			});
		
	});	
	
	
	
	
	
	
	
	
	$('.form-onpage a[data-toggle=customer_form]').each(function(){
		var target = $(this).data('target');
		$(document).trigger('load.c_form',[{target:target, customer_id:$('#page_customer_id').val(), modal:'editCustomerFormModal', async: true, cb: function(data){
			
			if(target == 'rental_agreement'){
			 $('#rental_agreement_'+(data.passed == 1 ? 'accept' : 'decline')+'_p').prop('checked', true);	
			}
		
		}}])
	});
	
	
	
	
	
	$('.form-onpage a[data-toggle=customer_form]').on('click',function(e){
		e.preventDefault();
		
		var body = $('#editCustomerFormModal .body3');
		var target = $(this).data('target');
		
	

		if($(this).attr('href') == '.pdr-page'){
			anno.makeAnnotatable(document.getElementById('hallstatt2'));
		}
		
		
		$('.sub-pages > .page', body).removeClass('active');
		
		if($.inArray($(this).attr('href'),['#','']) < 0){
			$('.sub-pages > ' + $(this).attr('href'), body).addClass('active');
			$('#editCustomerFormModal').modal('show');
		}
		
	
		
		
		if(target != 'rental_agreement'){
			$(document).trigger('load.c_form',[{target:target, customer_id:$('#page_customer_id').val(), modal:'editCustomerFormModal'}]);
			
			ajaxCall('getCustomer',{id:$('#page_customer_id').val()}, function(res){
				if(res.code==200){
					$.each(res.body, function(key,value){
						$('#editCustomerFormModal ._c_'+key).text(value)
					})
				}
			});
		}
			
		
	});
		
	$('.form-onpage [name=rental_agreement]').change(function(){
		ajaxCall('setForm', {target:'rental_agreement', customer_id:$('#page_customer_id').val(), form_data_json: JSON.stringify({rental_agreement: $(this).val() == 'accept' ? 1 : 0}) })
	});


	
	$('.upload_file').on('click', function(){	

		var customer_id = $('#page_customer_id').val();	
		var inputFile = $(this).parent().find('.customerFile');
		var load = $(this).parent().find('.fileLoad');

		
		inputFile.html5_upload({
			url: function() {
				return(BASE_URL + 'customers/upload/' + customer_id);
			},
			fieldName: 'file',
			sendBoundary: window.FormData || $.browser.mozilla,
			onFinishOne: function(event, response, name, number, total) {			
				response = JSON.parse(response);
				if(response.code!=200) alert(response.data);
			},
			onError: function(event, name, error) {
				alert('error while uploading file ' + name);
			},
			onFinish: function(){
				 document.location.reload();
			},
			setProgress: function(val) {
				load.css({opacity:1}).html('<i>' +  Math.ceil(val*100) + '%</i>');
				
			},
			
		});		
		
		inputFile.trigger('click');
	});

	
	
	$('.filterInputFloat').on('keypress', function(){
		return (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46 || event.charCode == 8;
	});	
	$('.filterInputInt').on('keypress', function(){
		return (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 8;
	});
	
	
	
	$('.invoice-page').calcInvoice();		
	
	
	
	$('.add-note textarea').change(function(){
		$('#add_customer_note').data('note', $(this).val());
	});
	$('#add_customer_note').click(function(){
		ajaxCall($(this).attr('id'),$(this).data(), function(res){
			showFormAlert($('.add-note'), res, function(){
				if(res.code == 200) document.location.reload();
			}, 1000);
		})
	});
	
	


	
	$('body').on('click', '.btn.edit-file', function(){
		var _modal = $('#customerFileModal');
		_modal.find('[name=rename]').val($(this).data('rename'));
		_modal.find('[name=id]').val($(this).data('id'));
		
	});
	
	
	$('#customerFileModal .btn.save').on('click', function(){
		var _modal = $('#customerFileModal');
		var id = _modal.find('[name=id]').val();
		var rename = _modal.find('[name=rename]').val();
		ajaxCall('update_file',{id:id,rename:rename},function(res){
			showFormAlert(_modal, res, function(){
				if(res.code == 200) document.location.reload();
			}, 1000);
		});
		return false;
	});
	
	
	
	$('.add-field-trigger').on('click', function(){
		var form = $(this).parent().parent().find('form');
		var name = form.find('[name=name]').val();
		var action = form.find('[name=action]:checked').val();
		var page = $($(this).data('target')).find('.invoice-page');
		
		if(name=='' || page.find('[name="'+name+'"]').length){
			form.find('[name=name]').css({'border-color':'red'});
			return;
		}
		else form.find('[name=name]').css({'border-color':'#c8c7cc'});

		var tr = page.find('.table td:has(.fa-times):last').parent();		
		var line = '<tr><td><i class="fa fa-times"></i>'+name+'</td><td><input type="text" data-operator="'+action+'"  class="filterInputFloat" name="'+name+'" value="0" /><span>$</span></td></tr>';
		
		if(tr.length) tr.after(line); else page.find('.table').prepend(line);

		page.trigger('calc.invoice');	
		$($(this).parent().find('.btn-o').data('target')).modal('hide');
		form.find('[name=name]').val('');
	});
	
	
	$('.invoice-page .table').on('click', '.fa-times', function(){
		$(this).parent().parent().remove();
		$('.modal.in .invoice-page').trigger('calc.invoice');
	});
	
	
	
	$('.btn.print-invoice').on('click', function(){
		$(this).parent().parent().printEl();
		return false;
	});
	
	
	
	$('#alerts').alerts('get').on('click', function(){
		 if(!$(this).hasClass('open')) {
        	$('#alerts').trigger('show');
		}
	});

	
	
	
	
	
	
	
	$('#customerStatusModal [name=status]').change(function(){
		var _modal = $('#customerStatusModal');
		_modal.find('[name=priority]').val('').change().parent().find('.btn').removeClass('btn-success btn-info btn-warning btn-danger').addClass('btn-default');
		_modal.find('[name=datetime],[name=users]').val('').change();
	});
	
	$('#customerStatusModal [name=priority]').change(function(){
		if($(this).val() != ''){
			var color = 'btn-'+$('option:selected',this).data('color');
			$(this).parent().find('.btn').removeClass('btn-success btn-info btn-warning btn-danger').addClass(color);
		}
	});
	
	$('#customerStatusModal form').submit(function(){
		var form = $(this);
		ajaxCall('update_customer_status', form.serializeObject(), function(res){
			showFormAlert(form, res, function(){
				if(res.code == 200) document.location.reload();
			}, 2000);
		})
		return false;
	});



	
	
});