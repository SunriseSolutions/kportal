		//$(function() {
			jQuery(function($){
				form_quantity = $('.sunrise_form_wrapper').length;
				var form_wrapper=[],currentForm=[],linkform=[];
				
				for(var x = 0; x < form_quantity ; x++){
//					if(x==0){form_selector = '#sunrise_form_wrapper';}
//					else{}
					form_selector = '#sunrise_form_wrapper'+x;
					// the form wrapper (includes all forms)
				 form_wrapper[x]	= $(form_selector),
					// the current form is the one with class active
					currentForm[x]	= form_wrapper[x].children('form.active'),
					// the change form links
					linkform[x]		= form_wrapper[x].find('.linkform'); 
						
				// get width and height of each form and store them for later
				form_wrapper[x].children('form').each(function(i){
					var $theForm	= $(this);
					// solve the inline display none problem when using fadeIn
					// fadeOut
					if(!$theForm.hasClass('active'))
						$theForm.hide();
					$theForm.data({
					// width : $theForm.width(),
					// height : $theForm.height()
					});
				});
				
			
				// set width and height of wrapper (same of current form)
			//	setWrapperWidth();
				
				/*
				 * clicking a link (change form event) in the form makes the
				 * current form hide. The wrapper animates its width and height
				 * to the width and height of the new current form. After the
				 * animation, the new form is shown
				 */
				linkform[x].bind('click',function(e){
					var link	= $(this);
					var target	= link.attr('rel');
					_array_index = link.parents('.sunrise_form_wrapper').attr('id').substring('sunrise_form_wrapper'.length);
					_x = (_array_index=='')?0:_array_index;  
					currentForm[_x].fadeOut(400,function(){
						// remove class active from current form
						currentForm[_x].removeClass('active');
						// new current form
						currentForm[_x]= form_wrapper[_x].children('form.'+target);
						// animate the wrapper
						form_wrapper[_x].stop()
									 .animate({
								// width : $currentForm.data('width') + 'px',
								// height : $currentForm.data('height') + 'px'
									 },500,function(){
										// new form gets class active
										currentForm[_x].addClass('active');
										// show the new form
										currentForm[_x].fadeIn(400);
									 });
					});
					e.preventDefault();	
				});
				
			//	function setWrapperWidth(){
				//	$form_wrapper.css({
					// width : $currentForm.data('width') + 'px',
				// height : $currentForm.data('height') + 'px'
				//	});
			//	}
				
				/*
				 * for the demo we disabled the submit buttons if you submit the
				 * form, you need to check the which form was submited, and give
				 * the class active to the form you want to show
				 */
				form_wrapper[x].find('input[type="submit"]')
							 .click(function(e){
								e.preventDefault();
							 });	
				
				} 
			});