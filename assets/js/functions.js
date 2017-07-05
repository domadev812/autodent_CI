String.prototype.toNum = function(){
    return parseFloat(this) || 0;
}



function ajaxCall(func, data, cb, async){
	data = typeof data == 'object' && data != null ? data : {};
	data.function = func;
	async = async !== false ? true : false;
	
	$.ajax({
		url: BASE_URL + 'ajax',
		type: 'POST',
		data: data,
		dataType: 'json',
		async: async,
		success: function(res){
           if(typeof cb == 'function') cb(res)     
       }
	});
}



$.fn.extend({
    alerts: function (action) {
    	return this.each(function(){
    		
    		var self = $(this);
    		
    		var badge = self.find('.badge');
    		var list = self.find('.dropdown-menu .ps-container .list-group');
    		var view_ids = [];

    		list.html('');
    		badge.hide();
    		
    		self.on('get.alerts', function(){
    			ajaxCall('get_alerts', null, function(res){
    				if(res.code == 200){
						
						var items = JSON.parse(res.body);
						list.html('');
						badge.text(items.length).show();

						$.each(items, function(){
							console.log($(this));
							var a = $('<a/>');
							var obj = $(this)[0];
							view_ids.push(obj.id);
							if(obj.type == 'assigned'){
							a.attr({'class':'media list-group-button'}).html('<span class="media-body block no-margin"><b>'+obj.creator_name+'</b> '+obj.note+'<small class="block text-grey">'+obj.interval+'</small> </span>');
							
							}else{
							a.attr({'class':'media list-group-item','id':obj.customer_id}).html('<span class="media-body block no-margin"><b>'+obj.creator_name+'</b> '+obj.note+'<small class="block text-grey">'+obj.interval+'</small> </span>');
							}
							list.append(a);
						});
						$('.media.list-group-button').click(function(){
							var _modal = $('#technicianCostModal');
							_modal.setAddCustomerStep(1).modal('show');
							return false;
						});
						
						$('.media.list-group-item').click(function(){
							location.href = '/customers/get/' + this.id;
						});
					}
    			});
    			

    		});    		
    		
    		self.on('show.alerts', function(){
    			ajaxCall('update_alerts', {view_ids: view_ids});
    		});
    		
    		
	        /*setInterval(function(){
				self.trigger('get.alerts');
			}, 10000);*/
    		
    		
    		if(typeof action == 'string'){
				self.trigger(action + '.alerts');
			}
    	})
    	
    }
});



$.fn.extend({
    printEl: function () {
    	
    	return this.each(function(){
	    	
	    	var self = $(this);
	    	
	    	self.find('input').each(function(){ $(this).attr('value', $(this).val()) });
	    	self.unbind('print.printEl').on('print.printEl', function(){
	    		var nWin = window.open('', self.data('title'));
				nWin.document.open();
				nWin.document.write('<html><head><link rel="stylesheet" href="'+BASE_URL+'assets/css/print.css"></head><body onload="window.print()" id="'+self.data('id')+'">' + self[0].innerHTML + '</body></html>');
				nWin.document.close();
				setTimeout(function(){ nWin.close(); }, 10);
	    	});

			self.trigger('print.printEl');

    	})
    }
});





jQuery.fn.extend({
    calcInvoice: function () {
        return this.each(function(){
        	
        	var self = $(this);
        	var table = $('.table', this);
        	
        	table.find('input').each(function(){$(this).val($(this).val().toNum())});
        	
        	$(this).on('calc.invoice', function(){
				var net = 0;
				
				table.find('input').each(function(){
					if($(this).attr('name') == 'net') return;
					
					var val = $(this).val().toNum();
					if($(this).data('operator') == '+') net += val;
					else  net -= val;
				});

				net = Math.round(net*100)/100;
				$('.net', table).val(net);
				$('.total b', table).text(net || 0);
        	});
        	
        	table.on('keyup', 'input', function(){
        		self.trigger('calc.invoice');
        	});
        	
        });
    }
});




jQuery.fn.extend({
    validateForm: function () {
        var res = true;
		$(this).find('input.required, select.required').each(function(){
			if($(this).val()) $(this).removeClass('error');
			else{ $(this).addClass('error'); res = false; }
		}).on('focus', function(){$(this).removeClass('error')});
	return res;
    }
});


jQuery.fn.extend({
    showAlert: function (msg, className, duration, cb) {
       className = className || 'info';
       duration = duration || 1000;
       var html = '<div style="display:none" class="alert alert-'+className+'" role="alert">'+ msg +'</div>';
       
       if(msg != '')
	       $(this).html(html).find('.alert').fadeIn('slow', function(){
	       		var alert = $(this);
	       		setTimeout(function(){alert.fadeOut('slow'); if(typeof cb == 'function') cb()},duration);
	       });
	   else cb();
	   
    }
});

jQuery.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};


jQuery.fn.extend({
    setAddCustomerStep: function (step_num) {
       if(step_num>4) return;
       var prevBody = $('.body' + (step_num-1), this);
       if(!prevBody.validateForm()) return;
       self = $(this); 
       
      if(step_num == 2){
	   		var stop2 = false;
	   		ajaxCall('add_customer', $('input,select', prevBody).serializeObject(), function(res){
	   			if(res.code == 200){
					self.find('a.customer_url').attr('href', '/customers/get/' + res.body);
					self.find('input[name=appt_datetime]').parent().parent().parent().find('#customer_id').val(res.body);
				}else{
					stop2 = true;
					showFormAlert(prevBody, res);
					$('[name=customer_name]', prevBody).addClass('error');
				}
	   			
	   		}, false);
	   		if(stop2) return;
	   }
	   
	   
	   	   
	   if(step_num == 4){
	   		
	   		var error = '';
	   		
	   		
	   		if($('input[name=rental_agreement]:checked', prevBody).val() != 'accept'){
				error = 'Please, accept the Rental Agreement to continue...';
			}
			else{
				ajaxCall('setForm', {
					target: 'rental_agreement',
					customer_id: $('#customer_id').val(),
					form_data_json: JSON.stringify({rental_agreement:1})
				});
				
				ajaxCall('getCustomer',{id:$('#customer_id').val()}, function(res){
					if(res.code==200){
						$.each(res.body, function(key, value){
							$('#createCustomerModal ._c_'+key).text(value)
						})
					}
				}, false);	
			}
	   		
	   		
	   		
	   		
	   		if(error != ''){
				showFormAlert(prevBody, {error:error});
	   			return;
			}
	   }
	   
       
       
       $('.body', this).hide();
       var ul = $('ul.steps', this);
       $('li', ul).removeClass('passed active');
       $('li', ul).eq(step_num).addClass('active');
       $('li', ul).each(function(i){
       		if(i>0 && (i<step_num || step_num == 4)){
				$(this).addClass('passed').find('b').html('<i class="fa fa-check"></i>');
			}
       });

       
       if(step_num<=4){
       		$('.body' + step_num, this).fadeIn(300);
       		$('.divider', ul).removeClass('step1 step2 step3 step4').addClass('step'+step_num);
       } 
       
        
	   
	   if(step_num == 3){
	   		if($(this).find('#customer_id').val()!='')
	   		ajaxCall('add_schedule', $('input,select', prevBody).serializeObject(), function(res){
				$('#appt_id').val(res.code == 200 ? res.body : '');
	   		});
	   }	    
       return this; 
    }
});

function parseAnnotations(img_url){
	var an = anno.getAnnotations();
	var result = [];
	$.each(an, function(idx, obj){
		result.push({
			src    : img_url,
			text   : obj.text,
			shapes : [{type : obj.shapes[0].type, geometry : obj.shapes[0].geometry}]
		});
	});
	return JSON.stringify(result);
}





function collectInvoiceData(modalSelector){
	var data = {};
	$(modalSelector + ' .page.invoice-page input').each(function(){
		data[$(this).attr('name')] = {operator:$(this).data('operator'),value:$(this).val()};
	});
	return data;
}


jQuery.fn.extend({
    subPages: function () { 
       var body = $(this);
       
       

       $('.sub-page', body).click(function(){
			$('#createCustomerModal .heading').hide();
			$('.main-page', body).hide();
			$('.sub-pages > .page', body).removeClass('active');
			$('.sub-pages > ' + $(this).attr('href'), body).addClass('active');
			
			if($(this).attr('href') == '.pdr-page'){
				anno.makeAnnotatable(document.getElementById('hallstatt'));
			}
			return false;
		});

		
		$('.location', body).click(function(){
			$('.location', body).removeClass('active').find('input').prop('checked',false);
			$(this).addClass('active').find('input').prop('checked',true);
		});
		
		
		
		function closeBody3Pages(reset_page, cb){
			$('.sub-pages > .page', body).removeClass('active');
			$('#createCustomerModal .heading').show();
			$('.main-page', body).show();
			
			if(typeof reset_page == 'string'){
				var _page = $('.sub-pages > .'+reset_page);

				_page.find('.location').removeClass('active');
				_page.find('input:not(:checkbox)').val('');
				_page.find('input:checkbox').prop('checked',false);
				_page.find('.sig-adp, .sig-pdr-customer, .sig-pdr-adc, .sig-ra').signature('clear');
				_page.find('.sig-adp-block, .sig-pdr-customer-block, .sig-pdr-adc-block').hide();
				_page.find('ul.inserttext').html('');
				
				if(reset_page == 'pdr-page'){
					anno.destroy();
				}
				
			}
			
			if(typeof cb == 'function'){
				cb();
			}
		}
		
		$('.sub-pages .close-pages', body).click(function(){
			closeBody3Pages($(this).attr('href'));
			return false;
		});
		
		$('.sub-pages', body).find('.save-adp, .save-pdr, .save-ra, .save-invoice').click(function(){

			var href = $(this).attr('href');
			var target = $(this).data('target');
			var c_id = $('#customer_id').val();
			
			
			if($(this).hasClass('save-pdr')){
				$('input[name=annotations]', body).val( parseAnnotations($('#hallstatt').attr('src')) );
			}
			
			closeBody3Pages(null, function(){
					
					
					if(href == 'invoice-page'){
						var _data = collectInvoiceData('#createCustomerModal');
					}
					else var _data = $('.page.'+ href + ' input',body).serializeObject();
					
					ajaxCall('setForm', {
						target: target,
						customer_id: c_id,
						form_data_json: JSON.stringify(_data)
					},function(res){
						console.log(res,'setForm');
						$(document).trigger('save.c_form',[{target: target, customer_id: c_id}]);
					});
			});
			return false;	
		});
       
       
		$('.close-sig-adp', body).click(function() {$('.sig-adp-block', body).fadeOut()});
		$('.esign-adp', body).click(function() {$('.sig-adp-block', body).fadeIn()});		
		
		$('.close-sig-pdr-customer', body).click(function() {$('.sig-pdr-customer-block', body).hide()});
		$('.esign-pdr-customer', body).click(function() {$('.sig-pdr-customer-block', body).show();$('.sig-pdr-adc-block', body).hide();});
		
		$('.close-sig-pdr-adc', body).click(function() { $('.sig-pdr-adc-block', body).hide()});
		$('.esign-pdr-adc', body).click(function() {$('.sig-pdr-adc-block', body).show();$('.sig-pdr-customer-block', body).hide()});
		
				
		$('.close-sig-ra', body).click(function() { $('.sig-ra-block', body).hide()});
		$('.esign-ra', body).click(function() {$('.sig-ra-block', body).show()});
		
		
		body.find('.sig-adp, .sig-pdr-customer, .sig-pdr-adc, .sig-ra').signature({ 
		  color: '#31404d',
		  change: function() { 
		    var _btn = $('.'+$(this).attr('data-btn'), body);
		    if($(this).signature('isEmpty'))
		   		_btn.removeClass('active'); 
		    else
		        _btn.addClass('active');
		        
		    //---   
		    $('input[name='+$(this).attr('class').replace(' kbw-signature','')+']').val($(this).signature('toJSON'));
		  }});
		
		
		$('.clear-sig-adp', body).click(function() {$('.sig-adp', body).signature('clear')});
		$('.clear-sig-pdr-customer', body).click(function() {$('.sig-pdr-customer', body).signature('clear')});
		$('.clear-sig-pdr-adc', body).click(function() {$('.sig-pdr-adc', body).signature('clear')});
		$('.clear-sig-ra', body).click(function() {$('.sig-ra', body).signature('clear')});
		
		
		
		$(".addtext",body).click(function(){
			 var vals=$(".addtextval",body).val();
			 if(vals.length > 0) {
			 	var appendval='<li>' + vals + '<input type="hidden" name="pdr-text-items" value="'+vals+'" />' + '</li>';
			 	$(".inserttext",body).append(appendval);
			 	$(".addtextval",body).val("");
		 	}
		});
		
        
    }
});





jQuery.fn.extend({
    editForms: function () {
    	
    	var body = $(this);

		
		$('.location', body).click(function(){
			$('.location', body).removeClass('active').find('input').prop('checked',false);
			$(this).addClass('active').find('input').prop('checked',true);
		});
		
		
		
		function closeBody4Pages(reset_page, cb){
			$('.sub-pages > .page', body).removeClass('active');
			$('#editCustomerFormModal').modal('hide');
			
			
			if(typeof reset_page == 'string'){
				var _page = $('.sub-pages > .'+reset_page, body);

				_page.find('.location').removeClass('active');
				_page.find('input:not(:checkbox)').val('');
				_page.find('input:checkbox').prop('checked',false);
				_page.find('.sig-adp, .sig-pdr-customer, .sig-pdr-adc, .sig-ra').signature('clear');
				_page.find('.sig-adp-block, .sig-pdr-customer-block, .sig-pdr-adc-block').hide();
				_page.find('ul.inserttext').html('');
				
				if(reset_page == 'pdr-page'){
					anno.destroy();
				}
				
			}
			
			if(typeof cb == 'function'){
				cb();
			}
		}
		
		$('.sub-pages .close-pages', body).click(function(){
			closeBody4Pages($(this).attr('href'));
			return false;
		});
		
		$('.sub-pages', body).find('.save-adp, .save-pdr, .save-ra, .save-invoice').click(function(){

			var href = $(this).attr('href');
			var target = $(this).data('target');
			var customer_id = $('#page_customer_id').val();
			
			
			if($(this).hasClass('save-pdr')){
				$('input[name=annotations]', body).val( parseAnnotations($('#hallstatt2').attr('src')) );
			}
			
			closeBody4Pages(null, function(){
					
					//var _data = $('.page.'+ href + ' input', body).serializeObject();
					if(href == 'invoice-page'){
						var _data = collectInvoiceData('#editCustomerFormModal');
					}
					else var _data = $('.page.'+ href + ' input',body).serializeObject();
					
					
					ajaxCall('setForm', {
						target: target,
						customer_id: customer_id,
						form_data_json: JSON.stringify(_data)
					},function(res){
						$(document).trigger('save.c_form',[{target: target, customer_id: customer_id, modal:'editCustomerFormModal'}]);
					});
			});
			return false;	
		});
       
       
		$('.close-sig-adp', body).click(function() {$('.sig-adp-block', body).fadeOut()});
		$('.esign-adp', body).click(function() {$('.sig-adp-block', body).fadeIn()});		
		
		$('.close-sig-pdr-customer', body).click(function() {$('.sig-pdr-customer-block', body).hide()});
		$('.esign-pdr-customer', body).click(function() {$('.sig-pdr-customer-block', body).show();$('.sig-pdr-adc-block', body).hide();});
		
		$('.close-sig-pdr-adc', body).click(function() { $('.sig-pdr-adc-block', body).hide()});
		$('.esign-pdr-adc', body).click(function() {$('.sig-pdr-adc-block', body).show();$('.sig-pdr-customer-block', body).hide()});
		
				
		$('.close-sig-ra', body).click(function() { $('.sig-ra-block', body).fadeOut()});
		$('.esign-ra', body).click(function() {$('.sig-ra-block', body).fadeIn()});
		
		
		body.find('.sig-adp, .sig-pdr-customer, .sig-pdr-adc, .sig-ra').signature({ 
		  color: '#31404d',
		  change: function() { 
		    var _btn = $('.'+$(this).attr('data-btn'), body);
		    if($(this).signature('isEmpty'))
		   		_btn.removeClass('active'); 
		    else
		        _btn.addClass('active');
		        
		    //---   
		    $('input[name='+$(this).attr('class').replace(' kbw-signature','')+']', body).val($(this).signature('toJSON'));
		  }});
		
		
		$('.clear-sig-adp', body).click(function() {$('.sig-adp', body).signature('clear')});
		$('.clear-sig-pdr-customer', body).click(function() {$('.sig-pdr-customer', body).signature('clear')});
		$('.clear-sig-pdr-adc', body).click(function() {$('.sig-pdr-adc', body).signature('clear')});
		$('.clear-sig-ra', body).click(function() {$('.sig-ra', body).signature('clear')});
		
		
		
		$(".addtext",body).click(function(){
			 var vals=$(".addtextval",body).val();
			 if(vals.length > 0) {
			 	var appendval='<li>' + vals + '<input type="hidden" name="pdr-text-items" value="'+vals+'" />' + '</li>';
			 	$(".inserttext",body).append(appendval);
			 	$(".addtextval",body).val("");
		 	}
		});
		
        
    }
});







function showFormAlert(form, res, cb, ms){
	form.find('.msg .alert').removeClass('alert-success, alert-danger');
	form.find('.msg').showAlert(
		res.code == 200 ? res.body : res.error, 
		res.code == 200 ? 'success' : 'danger'
	, ms || 5000, cb);
}




function setCollapseHeight(){
	if( $(window).width() < 768 ) 
		$('.navbar .navbar-collapse').height( $(window).height() - $('.navbar .navbar-header').height() );
}





function update_user(data, cb){
	data = typeof data == 'object' ? data : {};
	data.function = 'update_user';
	$.post(BASE_URL+'ajax', data, function(res){
		cb(JSON.parse(res))
	});
}


function setScroll_x(){
	$('.scroll-x').each(function(){$(this).height($(this).parent().height() - $(this).offset().top)});
}


function getTopUsers(group_id, user_id, cb){
	ajaxCall('get_top_users',{group_id:group_id,user_id:user_id},function(res){
		if(typeof cb == 'function')	{
			var list = [];
			if(res.code == 200){
				$.each(JSON.parse(res.body), function(i,o){
					list.push(o);
				});
			}
			cb(list);
		}	
	});
}
