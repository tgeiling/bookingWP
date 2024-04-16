/******************************************************************************/
/******************************************************************************/

;(function($,doc,win)
{
	"use strict";
	
	var BCBSBookingForm=function(object,option)
	{
		/**********************************************************************/
		
        var $self=this;
		var $this=$(object);
		
		var $optionDefault;
		var $option=$.extend($optionDefault,option);
        
        var $googleMap;
        var $googleMapMarker;
		var $googleMapHeightInterval;
        
        var $startLocation;
		
		var $sidebar;

        /**********************************************************************/
        
        this.setup=function()
        {
            var helper=new BCBSHelper();
            helper.getMessageFromConsole();
            
            $self.e('select,input[type="hidden"]').each(function()
            {
                if($(this)[0].hasAttribute('data-value'))
                    $(this).val($(this).attr('data-value'));
            });
            
            $self.init();
        };
            
        /**********************************************************************/
        
        this.init=function()
        {
            var helper=new BCBSHelper();
            
            if(helper.isMobile())
            {
                $self.e('input[name="bcbs_departure_date"]').attr('readonly','readonly');
                $self.e('input[name="bcbs_return_date"]').attr('readonly','readonly');
            }
           
            /***/
            
            $(window).resize(function() 
			{
                try
                {
                    $('select').selectmenu('close');
                }
                catch(e) {}
                
                try
                {
                    $('.bcbs-datepicker').datepicker('hide');
                }
                catch(e) {}
                
                try
                {
                    $('.bcbs-timepicker').timepicker('hide');
                }
                catch(e) {}
                
                try
                {
                    $self.e('.ui-timepicker-wrapper').css({opacity:0});
                }
                catch(e) {}
                
                try
                {
                    var currCenter=$googleMap.getCenter();
                    google.maps.event.trigger($googleMap,'resize');
                    $googleMap.setCenter(currCenter);
                }
                catch(e) {}
			});
            
            $self.setWidthClass();
                     
			$self.setMainNavigation();
			
            /***/
            
            $self.e('.bcbs-main-navigation-default a').on('click',function(e)
            {
                e.preventDefault();
                
                var navigation=parseInt($(this).parent('li').data('step'),10);
                var step=parseInt($self.e('input[name="bcbs_step"]').val(),10);
                
                if(navigation-step===0) return;
                
                $self.goToStep(navigation-step);
            });
            
            $self.e('.bcbs-button-step-next').on('click',function(e)
            {
                e.preventDefault();
                $self.goToStep(1);
            });
            
            $self.e('.bcbs-button-step-prev').on('click',function(e)
            {
                e.preventDefault();
                $self.goToStep(-1);
            });
			
			/***/
			
			$self.e('form[name="bcbs-form"]').on('click','.bcbs-quantity a',function(e)
			{
				e.preventDefault();
				$self.validateQuantity($(this));
				$self.createSummaryPriceElement();		
			});
			
			$self.e('form[name="bcbs-form"]').on('change','.bcbs-quantity input[type="text"]',function(e)
			{
				e.preventDefault();
				
				var parent=$(this).parent('.bcbs-quantity');
				
				var value=parseInt($(this).val(),10);
				
				if(!((value>=parent.attr('data-min')) && (value<=parent.attr('data-max')))) $(this).val(parent.attr('data-default'));
			});
            
            /***/
            
            $self.e('form[name="bcbs-form"]').on('click','.bcbs-form-field',function(e)
            {
                if($(this).find(':input[type="file"]').length) return;
				
				$('.qtip').remove();
                
                e.preventDefault();
                $(this).find(':input').focus(); 
                
                var select=$(this).find('select');
                
                if(select.length)
                    select.selectmenu('open');
            });
           			
			/***/
			
			$self.e('#bcbs-marina-info-frame').on('click','.bcbs-button',function(e)
			{
				e.preventDefault();
				
				var marinaId=parseInt($self.e('#bcbs-marina-info-frame').children('.bcbs-state-open').attr('data-marina-id'),10);
				
				if(marinaId>0)
					$self.e('select[name="bcbs_marina_departure_id"]').val(marinaId).selectmenu('refresh');	
				
				$self.closeMarinaFrame();
			});
			
			$self.e('#bcbs-marina-info-frame').on('click','.bcbs-marina-info-frame-marina-name>span',function(e)
			{
				e.preventDefault();
				$self.closeMarinaFrame();
			});
                    
            /***/
            
            $self.e('.bcbs-main-content-step-2').on('click','.bcbs-booking-extra-list .bcbs-button.bcbs-button-style-3',function(e)
            {
                e.preventDefault();
				
				if($(this).hasClass('bcbs-state-selected-mandatory')) return;
				
                $(this).toggleClass('bcbs-state-selected'); 
                
				$self.setBookingExtraIdField();
                $self.createSummaryPriceElement();
            });
            
            $self.e('.bcbs-main-content-step-2').on('focus','.bcbs-booking-extra-list input[type="text"]',function()
            {
                $(this).select();
            });
            
            $self.e('.bcbs-main-content-step-2').on('blur','.bcbs-booking-extra-list input[type="text"]',function()
            {
				e.preventDefault();
				$self.validateQuantity($(this));
				$self.createSummaryPriceElement();
            });
            
            /***/
            
            $self.e('.bcbs-main-content-step-2').on('click','.bcbs-boat-list .bcbs-button.bcbs-button-style-3',function(e)
            {
                e.preventDefault();
                
                if($(this).hasClass('bcbs-state-selected')) return;
                
                $self.e('.bcbs-boat-list .bcbs-button.bcbs-button-style-3').removeClass('bcbs-state-selected');
                
                $(this).addClass('bcbs-state-selected');
                
                $self.e('input[name="bcbs_boat_id"]').val(parseInt($(this).parents('.bcbs-boat').attr('data-boat-id'),10));
                
                $self.getGlobalNotice().addClass('bcbs-hidden');
                
				$self.setBookingExtra();
				
                $self.createSummaryPriceElement();
                
                if(parseInt($option.scroll_to_booking_extra_after_select_boat_enable,10)===1)
                {
                    var header=$self.e('.bcbs-booking-extra-list');
                    if(header.length===1) $.scrollTo(header,200,{offset:-50});
                }
            });
            
            /***/
            
            $self.e('.bcbs-main-content-step-2').on('click','.bcbs-boat .bcbs-boat-less-more-button',function(e)
            {
                e.preventDefault();
                
                var button=$(this);
                
                var section=$(this).parents('.bcbs-boat:first').find('.bcbs-layout-r2');
                
                var height=parseInt(section.children('div').actual('outerHeight',{includeMargin:true}),10)+60;
                
                if(button.hasClass('bcbs-state-open'))
                {
                    section.animate({height:0},150,function()
                    {
                        button.removeClass('bcbs-state-open');
                        $(window).scroll();
                    });                      
                }
                else
                {
                    section.animate({height:height},150,function()
                    {
                        button.addClass('bcbs-state-open');
						$(window).scroll();
                    });                        
                }
            });            
            
            /***/
            
            $self.e('.bcbs-main-content-step-3').on('change','input[name="bcbs_client_sign_up_enable"]',function(e)
            { 
                var value=parseInt($(this).val(),10)===1 ? 1:0;
                var section=$(this).parents('.bcbs-form-panel:first').find('.bcbs-form-panel-content>.bcbs-disable-section');
                
                if(value===0) section.removeClass('bcbs-hidden');
                else section.addClass('bcbs-hidden');
                
                $(window).scroll();
            });
            
            $self.e('.bcbs-main-content-step-3').on('change','input[name="bcbs_client_billing_detail_enable"]',function(e)
            { 
                var value=parseInt($(this).val(),10)===1 ? 1 : 0;
                var section=$(this).parents('.bcbs-form-panel:first').find('.bcbs-form-panel-content>.bcbs-disable-section');
                
                if(value===0) section.removeClass('bcbs-hidden');
                else section.addClass('bcbs-hidden');
                
                $(window).scroll();
            });
            
            $self.e('.bcbs-main-content-step-3').on('click','.bcbs-sign-up-password-generate',function(e)
            {
                e.preventDefault();
                
                var helper=new BCBSHelper();
                var password=helper.generatePassword(8);
                
                $self.e('input[name="bcbs_client_sign_up_password"],input[name="bcbs_client_sign_up_password_retype"]').val(password);
            });
            
            $self.e('.bcbs-main-content-step-3').on('click','.bcbs-sign-up-password-show',function(e)
            {
                e.preventDefault();
                
                var password=$self.e('input[name="bcbs_client_sign_up_password"]');
                password.attr('type',(password.attr('type')==='password' ? 'text' : 'password'));
            });
            
            $self.e('.bcbs-main-content-step-3').on('click','.bcbs-button-sign-up',function(e)
            {
                e.preventDefault();
                
                $self.e('.bcbs-client-form-sign-up').removeClass('bcbs-hidden');
                $self.e('input[name="bcbs_client_account"]').val(1);
            });
            
            $self.e('.bcbs-main-content-step-3').on('click','.bcbs-button-sign-in',function(e)
            {
                e.preventDefault();
                
                $self.getGlobalNotice().addClass('bcbs-hidden');
                
                $self.preloader(true);
            
                $self.setAction('user_sign_in');
       
                $self.post($self.e('form[name="bcbs-form"]').serialize(),function(response)
                {
                    if(parseInt(response.user_sign_in,10)===1)
                    {
                        $self.e('.bcbs-main-content-step-3 .bcbs-client-form').html('');
                 
                        if(typeof(response.client_form_sign_up)!=='undefined')
                            $self.e('.bcbs-main-content-step-3 .bcbs-client-form').append(response.client_form_sign_up);  
       
                        if(typeof(response.summary)!=='undefined')
                            $self.e('.bcbs-main-content-step-3>.bcbs-layout-25x75 .bcbs-layout-column-left:first').html(response.summary[0]);                        
                        
                        $self.createSelectField();
                    }
                    else
                    {
                        if(typeof(response.error.global[0])!=='undefined')
                            $self.getGlobalNotice().removeClass('bcbs-hidden').html(response.error.global[0].message);
                    }
                    
                    $self.preloader(false);
                });
            });
            
            $self.e('#bcbs-payment').on('click','ul>li>a',function(e)
            {
                e.preventDefault();
				
				var status=$(this).hasClass('bcbs-state-selected') ? 1 : 0;
                var paymentId=parseInt($(this).parents('li:first').attr('data-payment-id'),10);
				
				$self.e('#bcbs-payment>ul>li>a').removeClass('bcbs-state-selected');
			
				if(status===0)
				{
					$(this).addClass('bcbs-state-selected');
					$self.e('input[name="bcbs_payment_id"]').val(paymentId);
				}
				else $self.e('input[name="bcbs_payment_id"]').val('');
				
                $self.getGlobalNotice().addClass('bcbs-hidden');
            });
    
            $self.e('>*').on('click','.bcbs-form-checkbox',function()
            {
                var text=$(this).nextAll('input[type="hidden"]');
                
				var value=1;
				if(!$(this).hasClass('bcbs-state-selected-mandatory'))
					value=parseInt(text.val(),10)===1 ? 0 : 1;
                
                if(value===1) $(this).addClass('bcbs-state-selected');
                else $(this).removeClass('bcbs-state-selected');
                
                text.val(value).trigger('change');
            });
            
            /***/            
                        
            $self.e('.bcbs-main-content-step-4').on('click','.bcbs-coupon-code-section a',function(e)
            {
                e.preventDefault();
                
                $self.setAction('coupon_code_check');
       
                $self.post($self.e('form[name="bcbs-form"]').serialize(),function(response)
                {
                    $self.e('.bcbs-summary-price-element').replaceWith(response.html);
                    
                    var object=$self.e('.bcbs-coupon-code-section');
                    
                    object.qtip(
                    {
                        show:
						{ 
                            target:$(this) 
                        },
                        style:
						{ 
                            classes:(response.error===1 ? 'bcbs-qtip bcbs-qtip-error' : 'bcbs-qtip bcbs-qtip-success')
                        },
                        content:
						{ 
                            text:response.message 
                        },
                        position:
						{ 
                            my:($option.is_rtl ? 'bottom right' : 'bottom left'),
                            at:($option.is_rtl ? 'top right' : 'top left'),
                            container:object.parent()
                        }
                    }).qtip('show');	
                    
                });
            });
            
            /***/
			
            $('.bcbs-datepicker').datepicker(
            {
                autoSize:true,
                dateFormat:$option.date_format_js,				
                beforeShow:function(date,instance)
                {
					var helper=new BCBSHelper();
					var value=helper.getValueFromClass($(instance.dpDiv),'bcbs-booking-form-id-');
					
					if(value!==false) $(instance.dpDiv).removeClass('bcbs-booking-form-id-'+value);
					
					$(instance.dpDiv).addClass('bcbs-main bcbs-booking-form-id-'+$option.booking_form_id);
					
                    var dateField=$(this);
                                        
                    var marinaId=$self.getMarinaId(dateField);
					
					$(this).datepicker('option','minDate',$option.marina_departure_period[marinaId].min); 

					if($(date).attr('name')==='bcbs_departure_date')
					{
						$(this).datepicker('option','maxDate',$option.marina_departure_period[marinaId].max);
					}

					if($(date).attr('name')==='bcbs_return_date')
					{
						try
						{
							var dateDeparture=$self.e('[name="bcbs_departure_date"]').val();
							var dateParse=$.datepicker.parseDate($option.date_format_js,dateDeparture);
							
							if(dateParse!==null)
							{
								$(this).datepicker('option','minDate',dateDeparture); 
							}
						}
						catch(e)
						{
							
						}
					}
                
                    $(this).datepicker('refresh');
                },
                beforeShowDay:function(date)
                {
                    var dateField=$(this);
                    
                    var helper=new BCBSHelper();
                    
                    var marinaId=$self.getMarinaId($(this));
                    
                    for(var i in $option.marina_date_exclude[marinaId])
                    {
                        var r=helper.compareDate([$.datepicker.formatDate('dd-mm-yy',date),$option.marina_date_exclude[marinaId][i].start,$option.marina_date_exclude[marinaId][i].stop]);
                        if(r) return([false,'','']);
                    }
                    
                    /***/
					
					var dayWeek=parseInt(date.getDay(),10);
					if(dayWeek===0) dayWeek=7;
			   
                    var test=true;
               
                    if(dateField.attr('name')==='bcbs_return_date')
                    {
                        if(parseInt($option.marina_after_business_hour_return_enable[marinaId],10)===1)
                        {
                            test=false;
                        }
                    }
                    
                    if(test)
                    {
                        if((!$option.marina_business_hour[marinaId][dayWeek].start) || (!$option.marina_business_hour[marinaId][dayWeek].stop)) 
                            return([false,'','']);
                    }
                    
                    /***/
                    
                    return([true,'','']);
                },
                onSelect:function(date,object)
                {
                    var dateField=$(this);
					
					var timeField=null;
					var timeFieldName=null;
				
					var marinaId=$self.getMarinaId(dateField);
				  
					if(dateField.attr('name').indexOf('departure')>-1) 
					{
						if(parseInt($option.marina_date_departure_return_the_same_enable[marinaId],10)===1)
						{
							$self.e('[name="bcbs_return_date"]').val(dateField.val());
							$self.timeFieldSetup($self.e('[name="bcbs_return_time"]'),$self.e('[name="bcbs_return_date"]'),object);
						}
						
						timeFieldName='bcbs_departure_time';
					}
					else timeFieldName='bcbs_return_time';
						
					timeField=$self.e('[name="'+timeFieldName+'"]');
					
					if(timeField.length!==1) return;

					$self.timeFieldSetup(timeField,dateField,object);
                }
            });
			
			$('.ui-datepicker').addClass('bcbs-main notranslate');
            
            $this.on('focusin','.bcbs-timepicker',function()
			{
                var helper=new BCBSHelper();
                
                var dateField=$(this).parent('div').parent('div').find('.bcbs-datepicker');
                
                if(helper.isEmpty(dateField.val()))
                {
                    $(this).timepicker('remove');
                    dateField.click();
                    return;
                }
                else
                {
                    if(helper.isEmpty($(this).val()))
					{
                        $(this).timepicker('show');
					}
                }
            });
            
            /***/
            
            $self.createSelectField();
              
            /***/
    
            $self.e('.bcbs-form-field').has('select').css({cursor:'pointer'});
            
            /***/
            
            $(document).keypress(function(e) 
            {
                if(parseInt(e.which,10)===13) 
                {
                    switch($(e.target).attr('name'))
                    {
                        case 'bcbs_client_sign_in_login':
                        case 'bcbs_client_sign_in_password':
                        
                            $self.e('.bcbs-main-content-step-3 .bcbs-button-sign-in').trigger('click');
                        
                        break;
                    }
                }
            });
            
            /***/
            
            $self.e('.bcbs-button-widget-submit').on('click',function(e)
            {
                e.preventDefault();
               
                var data={};
                    
                /***/
                
                data.marina_departure_id=$self.e('[name="bcbs_marina_departure_id"]').val();
                data.departure_date=$self.e('[name="bcbs_departure_date"]').val();
                data.departure_time=$self.e('[name="bcbs_departure_time"]').val();
                
                /***/
                
                data.marina_return_id=$self.e('[name="bcbs_marina_return_id"]').val();
                data.return_date=$self.e('[name="bcbs_return_date"]').val();
                data.return_time=$self.e('[name="bcbs_return_time"]').val();                
                
				data.boat_id=$self.e('[name="bcbs_boat_id"]').val(); 
				data.boat_id_only=$self.e('[name="bcbs_boat_id_only"]').val(); 
				
                /***/
				
				data.captain_status=$self.e('[name="bcbs_captain_status"]').val();  
                
                data.widget_submit=1;

                /***/
                
                var url=$option.widget.booking_form_url;
                
				if(url.indexOf('?')===-1) url+='?';
				else url+='&';
                
                url+=decodeURI($.param(data));
                
                window.location=url;
            });
			
            /***/
            
            $self.setDefaultBoat();
            
            /***/
            
            if(parseInt(helper.urlParam('widget_submit'),10)===1)    
            {
                $self.goToStep(1,function()
                {
                    $self.googleMapCreate();
                    $self.googleMapInit();
                    $this.removeClass('bcbs-hidden');
					$self.googleMapStartCustomizeHeight();
                });
            }
            else 
            {
                $self.googleMapCreate();
                $self.googleMapInit();
                $this.removeClass('bcbs-hidden'); 
				$self.googleMapStartCustomizeHeight();
            }
            
            /***/
        };
		
		/**********************************************************************/
		
		this.timeFieldSetup=function(timeField,dateField,object)
		{
			var helper=new BCBSHelper();
			
			var marinaId=$self.getMarinaId(dateField);
			
			timeField.timepicker(
			{ 
				appendTo:$this,
				showOn:[],
				showOnFocus:false,
				timeFormat:$option.time_format,
				step:$option.timepicker_step,
				disableTouchKeyboard:true,
				scrollDefault:'now'
			});

			/***/

			var dateSelected=[object.selectedDay,object.selectedMonth+1,object.selectedYear];

			for(var i in dateSelected)
			{
				if(new String(dateSelected[i]).length===1) dateSelected[i]='0'+dateSelected[i];
			}

			dateSelected=dateSelected[0]+'-'+dateSelected[1]+'-'+dateSelected[2];

			/***/

			var minTime='00:00';
			var maxTime='23:59';

			var dayWeek=parseInt(dateField.datepicker('getDate').getDay(),10);
			if(dayWeek===0) dayWeek=7;

			if(new String(typeof($option.marina_business_hour[marinaId][dayWeek]))!=='undefined')
			{
				minTime=$option.marina_business_hour[marinaId][dayWeek].start;
				maxTime=$option.marina_business_hour[marinaId][dayWeek].stop;
			}

			/***/

			if(dateField.attr('name')==='bcbs_departure_date')
			{
				var t=$option.marina_departure_period[marinaId].min.split(' ');
				if((dateSelected===t[0]) && (dateSelected==$option.current_date))
				{
					if(Date.parse('01/01/1970 '+t[1])>Date.parse('01/01/1970 '+minTime))
						minTime=t[1];
				}

				if(!helper.isEmpty($option.marina_departure_period[marinaId].max))
				{
					var t=$option.marina_departure_period[marinaId].max.split(' ');

					if(dateSelected===t[0])
					{
						if(Date.parse('01/01/1970 '+t[1])<Date.parse('01/01/1970 '+maxTime))
							maxTime=t[1];
					}					
				}

				if(parseInt($option.marina_after_business_hour_departure_enable[marinaId],10)===1)
				{
					var temp=$option.current_date.split('-');
					var date=new Date(temp[2],temp[1]-1,temp[0]);

					if(dayWeek===parseInt(date.getUTCDay(),10)+1)
					{

					}
					else
					{
						minTime='00:00';
					}

					maxTime='23:59';
				}
			}

			/***/

			if(dateField.attr('name')==='bcbs_return_date')
			{
				if(parseInt($option.marina_after_business_hour_return_enable[marinaId],10)===1)
				{
					minTime='00:00';
					maxTime='23:59';
				}
			}

			/***/

			timeField.timepicker('option','minTime',minTime);
			timeField.timepicker('option','maxTime',maxTime);  

			/***/

			if(!helper.isEmpty($option.marina_business_hour[marinaId][dayWeek].break))
			{
				var disableTimeRanges=[];

				var breakHour=$option.marina_business_hour[marinaId][dayWeek].break;

				for(var i in breakHour)
					disableTimeRanges.push([breakHour[i].start,breakHour[i].stop]);

				timeField.timepicker('option','disableTimeRanges',disableTimeRanges);
			}

			/***/

			if(typeof($option.marina_business_hour[marinaId][dayWeek].default_timepicker)!='undefined')
			{
				timeField.timepicker('option','scrollDefault',$option.marina_business_hour[marinaId][dayWeek].default_timepicker);
			}

			timeField.val('').timepicker('show');
			timeField.blur();

			$self.e('.ui-timepicker-wrapper').css({opacity:1,'width':timeField.parent('div').outerWidth()+1});
		};
		
		/**********************************************************************/
		
		this.validateQuantity=function(object)
		{
			var step=1;
				
			var parent=object.parent('.bcbs-quantity');
			var text=parent.children('input[type="text"]');

			if(object.hasClass('bcbs-quantity-minus')) step=-1;

			var value=parseInt(text.val(),10)+step;

			if((value>=parent.attr('data-min')) && (value<=parent.attr('data-max'))) text.val(value);
		};
		
		/**********************************************************************/
		
		this.setPayment=function()
		{
			var paymentId=0;
			var paymentSelected=$self.e('.bcbs-payment>li>a.bcbs-state-selected');
			
			if(paymentSelected.length===1)
				paymentId=paymentSelected.parents('li:first').attr('data-payment-id');
			
			$self.e('input[name="bcbs_payment_id"]').val(paymentId);
		};
        
        /**********************************************************************/

        this.createFileField=function()
        {
			$self.e('input[type="file"]').each(function()
			{
				var field=$(this);
				
				$(this).fileupload(
				{
					url:$option.ajax_url,
					dataType:'json',
					formData:{'action':'bcbs_file_upload'},
					done:function(e,data) 
					{
						$self.setFileUploadField(field,true,data.result);
					}
				});  

				$(this).parent('.bcbs-file-upload').next('.bcbs-file-remove').children('span:last-child').on('click',function(e)
				{
					e.preventDefault();
					$self.setFileUploadField(field,false,[]);
				});
			});
        };
		
		/**********************************************************************/
		
		this.setFileUploadField=function(object,upload,data)
		{
			var name=object.attr('name');
			var field=$self.e('input[name="'+name+'"]');
			
			if(upload)
			{
				field.parent('.bcbs-file-upload').addClass('bcbs-hidden');
				field.parent('.bcbs-file-upload').next('.bcbs-file-remove').removeClass('bcbs-hidden').find('span>span').html(data.name);
			}
			else
			{
				field.parent('.bcbs-file-upload').removeClass('bcbs-hidden');
				field.parent('.bcbs-file-upload').next('.bcbs-file-remove').addClass('bcbs-hidden').find('span>span').html('');

				data={name:'',type:'',tmp_name:''};
			}

			$self.e('input[name="'+name+'_name"]').val(data.name);
			$self.e('input[name="'+name+'_type"]').val(data.type);
			$self.e('input[name="'+name+'_tmp_name"]').val(data.tmp_name);
		};
        
        /**********************************************************************/
        
        this.createSelectField=function()
        {
            $self.e('select').selectmenu(
            {
                appendTo:$this,
                open:function(event,ui)
                {
                    var select=$(this);
                    var selectmenu=$('#'+select.attr('id')+'-menu').parent('div');
                    
                    var field=select.parents('.bcbs-form-field:first');
                    
                    var left=parseInt(selectmenu.css('left'),10)-1;
                    
                    var width=field[0].getBoundingClientRect().width;
                    
                    selectmenu.css({width:width,left:left});
                },
                change:function(event,ui)
                {
                    var name=$(this).attr('name');
                    
                    if(name==='bcbs_navigation_responsive')
                    {
                        var navigation=parseInt($(this).val(),10);
                        
                        var step=parseInt($self.e('input[name="bcbs_step"]').val(),10);    
                
                        if(navigation-step===0) return;

                        $self.goToStep(navigation-step);
                    }
                    else if($.inArray(name,['bcbs_filter_boat_category','bcbs_filter_boat_guest','bcbs_filter_boat_marina_id'])>-1)
                    {
                        $self.setAction('boat_filter');

                        $self.post($self.e('form[name="bcbs-form"]').serialize(),function(response)
                        {       
                            $self.getGlobalNotice().addClass('bcbs-hidden');
                            
                            var boatList=$self.e('.bcbs-boat-list>ul');
                            boatList.html('');
                            
                            if((typeof(response.error)!=='undefined') && (typeof(response.error.global)!=='undefined'))
                            {
                                $self.getGlobalNotice().removeClass('bcbs-hidden').html(response.error.global[0].message);
                            }
                            else
                            {
                                boatList.html(response.html);
                            }
                            
                            $self.e('.bcbs-boat-list').find('.bcbs-button.bcbs-button-style-3').removeClass('bcbs-state-selected');
                            $self.e('input[name="bcbs_boat_id"]').val(0);
							
                            $self.preloadBoatImage();
							$self.createBoatGallery();
							
							$self.setBookingExtra();
                            $self.createSummaryPriceElement();
                        });
                    }
                    else if($.inArray(name,['bcbs_marina_departure_id'])>-1)
                    {
                        $self.e('[name="bcbs_departure_date"]').val('');
                        $self.e('[name="bcbs_departure_time"]').val('');
                        
                        $self.setDefaultBoat();
                    }
                    else if($.inArray(name,['bcbs_marina_return_id'])>-1)
                    {
                        $self.e('[name="bcbs_return_date"]').val('');
                        $self.e('[name="bcbs_return_time"]').val('');   
                    }
                }
            });
                        
            $self.e('.ui-selectmenu-button .ui-icon.ui-icon-triangle-1-s').attr('class','bcbs-meta-icon-24-arrow-vertical');  
        };
		
		/**********************************************************************/
		
		this.createBoatGallery=function()
		{
			$self.e('.bcbs-main-content-step-2').on('click','.bcbs-boat-list .bcbs-boat-image img',function(e)
			{
				e.preventDefault();
				
				var gallery=$(this).parents('.bcbs-boat-image:first').nextAll('.bcbs-boat-gallery');
				
				if(parseInt(gallery.length,10)===1)
				{
					$.fancybox.open(gallery.find('img'));
				}
			});
		};
		
		/**********************************************************************/
		
		this.setBookingExtra=function()
		{
			var boatId=parseInt($self.e('.bcbs-boat-list .bcbs-button.bcbs-button-style-3.bcbs-state-selected').parents('.bcbs-boat').attr('data-boat-id'),10);
				
			$self.e('.bcbs-booking-extra-list>ul>li').each(function() 
			{
				var data=JSON.parse($(this).attr('data-boat'));
				
				if(boatId>0)
				{
					if(parseInt(data[boatId].enable,10)===0)
					{
						$(this).find('.bcbs-button.bcbs-button-style-3').removeClass('bcbs-state-selected');
						$(this).addClass('bcbs-hidden');
					}
					else
					{
						$(this).find('.bcbs-booking-extra-price').html(data[boatId].price_gross_format);
						$(this).removeClass('bcbs-hidden');
					}
				}
				else
				{
					if(parseInt(data[-1].enable,10)===-1)
						$(this).addClass('bcbs-hidden');
					else $(this).removeClass('bcbs-hidden');
					
					if(data[-1].price_gross_format=='-1')
						$(this).find('.bcbs-booking-extra-price').html('');
					else $(this).find('.bcbs-booking-extra-price').html(data[-1].price_gross_format);
				}
			});
		};
        
        /**********************************************************************/

		this.setBookingExtraIdField=function()
		{
			var data=[];
			$self.e('.bcbs-booking-extra-list .bcbs-button.bcbs-button-style-3').each(function()
            {
				if($(this).hasClass('bcbs-state-selected'))
					data.push($(this).parents('li:first').attr('data-booking-extra-id'));
			});
                
            $self.e('input[name="bcbs_booking_extra_id"]').val(data.join(','));
		};
        
        /**********************************************************************/
        
        this.setDefaultBoat=function()
        {
            var marinaDepartureId=parseInt($self.e('[name="bcbs_marina_departure_id"]').val(),10);
            var boatIdDefault=parseInt($option.marina_boat_id_default[marinaDepartureId],10);
            
			if(boatIdDefault>0) $self.e('[name="bcbs_boat_id"]').val(boatIdDefault);
        };
        
        /**********************************************************************/
        
        this.getMarinaId=function(field)
        {
            var marinaId;
			var marinaField;
			
            if($.inArray(field.attr('name'),['bcbs_departure_date','bcbs_departure_time','bcbs_marina_departure_id'])>-1)
            {
				var marinaField=$self.e('[name="bcbs_marina_departure_id"]');
				
				if(marinaField.length===1) marinaId=parseInt(marinaField.val(),10);
				else marinaId=$option.marina_departure_id;
				
				if(parseInt(marinaId,10)===-1) marinaId=$option.marina_departure_id;
            }
            else if($.inArray(field.attr('name'),['bcbs_return_date','bcbs_return_time','bcbs_marina_return_id'])>-1)
            {
 				var marinaField=$self.e('[name="bcbs_marina_return_id"]');
				
				if(marinaField.length===1) marinaId=parseInt(marinaField.val(),10);
				else marinaId=$option.marina_return_id;
				
				if(parseInt(marinaId,10)===-1) marinaId=$option.marina_return_id;
            }
			
            return(Math.abs(marinaId));
        };
        
        /**********************************************************************/
        /**********************************************************************/
        
        this.setMainNavigation=function()
        {
            var step=parseInt($self.e('input[name="bcbs_step"]').val(),10);
     
            var element=$self.e('.bcbs-main-navigation-default').find('li');
            
            element.removeClass('bcbs-state-selected bcbs-state-completed bcbs-state-uncompleted');
            
            var i=0;
            element.each(function()
            {
				i++;
				
                if(i>step) $(this).addClass('bcbs-state-uncompleted');
				else if(i===step) $(this).addClass('bcbs-state-selected');
				else $(this).addClass('bcbs-state-completed');
            });
        };
                
        /**********************************************************************/
        /**********************************************************************/

        this.setAction=function(name)
        {
            $self.e('input[name="action"]').val('bcbs_'+name);
        };

        /**********************************************************************/
        
        this.e=function(selector)
        {
            return($this.find(selector));
        };

        /**********************************************************************/
        
        this.goToStep=function(stepDelta,callback)
        {   
			var Helper=new BCBSHelper();
			
            if(parseInt($option.widget.mode,10)===1)
            {
                callback();
                return;
            }
            
            $self.preloader(true);
            
            $self.setAction('go_to_step');
            
            var step=$self.e('input[name="bcbs_step"]');
            var stepRequest=$self.e('input[name="bcbs_step_request"]');
            stepRequest.val(parseInt(step.val(),10)+stepDelta);
            
            $self.post($self.e('form[name="bcbs-form"]').serialize(),function(response)
            {
                response.step=parseInt(response.step,10);
             
                if(parseInt(response.step,10)===5)
                {
					if(parseInt(response.payment_id,10)===-1)
					{
						if(parseInt(response.thank_you_page_enable,10)!==1)
						{
							window.location.href=response.payment_url;
							return;
						}						
					}
				}
	
                $self.getGlobalNotice().addClass('bcbs-hidden');
                
                $self.e('.bcbs-main-content>div').css('display','none');
                $self.e('.bcbs-main-content>div:eq('+(response.step-1)+')').css('display','block');
                
                $self.e('input[name="bcbs_step"]').val(response.step);
                
                $self.setMainNavigation();
                
                $self.googleMapDuplicate(-1);
                
                if($self.googleMapExist())
                    google.maps.event.trigger($googleMap,'resize');
                
                $('select[name="bcbs_navigation_responsive"]').val(response.step);
                $('select[name="bcbs_navigation_responsive"]').selectmenu('refresh');
				  
                if(parseInt(response.step,10)===1)
                    $self.googleMapStartCustomizeHeight();
                else $self.googleMapStopCustomizeHeight();
				  
                switch(parseInt(response.step,10))
                {
                    case 2:
                        
                        if(typeof(response.boat)!=='undefined')
                            $self.e('.bcbs-boat-list>ul').html(response.boat);
                        
                        if(typeof(response.booking_extra)!=='undefined')
                            $self.e('.bcbs-booking-extra-list').html(response.booking_extra);                        
                        
                        if(typeof(response.summary)!=='undefined')
                            $self.e('.bcbs-main-content-step-2>.bcbs-layout-25x75 .bcbs-layout-column-left:first').html(response.summary[0]);  
                        	
                        if(typeof(response.marina_selected_name)!=='undefined')
                            $self.e('.bcbs-marina-selected-name').html(response.marina_selected_name); 						
					
                        if(typeof(response.marina_selected_address)!=='undefined')
                            $self.e('.bcbs-marina-selected-address>span+span').html(response.marina_selected_address); 	
						
						if((Helper.isEmpty(response.marina_selected_name)) && (Helper.isEmpty(response.marina_selected_address)))
						{
							$self.e('.bcbs-boat-marina-selected-detail').addClass('bcbs-hidden');
							$self.e('.bcbs-boat-filer-marina').removeClass('bcbs-hidden');
						}
						else
						{
							$self.e('.bcbs-boat-marina-selected-detail').removeClass('bcbs-hidden');
							$self.e('.bcbs-boat-filer-marina').addClass('bcbs-hidden');							
						}
						
                        $self.preloadBoatImage();
						$self.createBoatGallery();
						
						$self.setBookingExtraIdField();
						$self.createSummaryPriceElement();
                        
                    case 3:
                        
                        if((typeof(response.client_form_sign_id)!=='undefined') && (typeof(response.client_form_sign_up)!=='undefined'))
                        {
                            $self.e('.bcbs-main-content-step-3 .bcbs-client-form').html('');

                            if(typeof(response.client_form_sign_id)!=='undefined')
                                $self.e('.bcbs-main-content-step-3 .bcbs-client-form').prepend(response.client_form_sign_id);                        

                            if(typeof(response.client_form_sign_up)!=='undefined')
                                $self.e('.bcbs-main-content-step-3 .bcbs-client-form').append(response.client_form_sign_up); 
                        }
                        
                        if(typeof(response.summary)!=='undefined')
                            $self.e('.bcbs-main-content-step-3>.bcbs-layout-25x75 .bcbs-layout-column-left:first').html(response.summary[0]);
                        
                        if(typeof(response.payment)!=='undefined')
                            $self.e('.bcbs-main-content-step-3>.bcbs-layout-25x75 .bcbs-layout-column-right #bcbs-payment').html(response.payment);
						
                        $self.createSelectField();
                        $self.createFileField();
						$self.setPayment();
						
                    break;
                    
                    case 4:
                        
                        if(typeof(response.summary)!=='undefined')
                        {
                            $self.e('.bcbs-main-content-step-4>.bcbs-layout-33x33x33>.bcbs-layout-column-left').html(response.summary[0]);
                        
                            $self.e('.bcbs-main-content-step-4>.bcbs-layout-33x33x33>.bcbs-layout-column-center').html(response.summary[1]);
                        
                            $self.e('.bcbs-main-content-step-4>.bcbs-layout-33x33x33>.bcbs-layout-column-right').html(response.summary[2]);
                        }
                        
                    break;
                }
				                
                $('.qtip').remove();
                
                if($.inArray(response.step,[4])>-1)   
                    $self.googleMapDuplicate(response.step);
                
                if(typeof(response.error)!=='undefined')
                {
                    if(typeof(response.error.local)!=='undefined')
                    {
                        for(var index in response.error.local)
                        {
                            var selector,object;
                            
                            var sName=response.error.local[index].field.split('-');
								
                            if(isNaN(sName[1])) selector='[name="'+sName[0]+'"]:eq(0)';
                            else selector='[name="'+sName[0]+'[]"]:eq('+sName[1]+')';                                    
                                    
                            object=$self.e(selector).prevAll('label');
                                 
                            object.qtip(
                            {
                                show:
								{ 
                                    target:$(this) 
                                },
                                style:
								{ 
                                    classes:(response.error===1 ? 'bcbs-qtip bcbs-qtip-error':'bcbs-qtip bcbs-qtip-success')
                                },
                                content:
								{ 
                                    text:response.error.local[index].message 
                                },
                                position:
								{ 
									my:($option.is_rtl ? 'bottom right' : 'bottom left'),
									at:($option.is_rtl ? 'top right' : 'top left'),
                                    container:object.parent()
                                }
                            }).qtip('show');	
                        }
                    }
                    
                    if(typeof(response.error.global[0])!=='undefined')
                        $self.getGlobalNotice().removeClass('bcbs-hidden').html(response.error.global[0].message);
                }
                
                if(parseInt(response.step,10)===5)
                {
                    $self.e('.bcbs-main-navigation-default').addClass('bcbs-hidden');
                    $self.e('.bcbs-main-navigation-responsive').addClass('bcbs-hidden');
					
					if(typeof(response.error)!=='undefined')
					{
						$self.getGlobalNotice().removeClass('BCBS-hidden').html(response.error.global[0].message);	
					}
					else
					{
						if($.inArray(parseInt(response.payment_id,10),[1,2,3,4])>-1)
						{
							var helper=new BCBSHelper();

							if(!helper.isEmpty(response.payment_info))
								$self.e('.bcbs-booking-complete-payment-'+response.payment_prefix).append('<p>'+response.payment_info+'</p>');
						}

						switch(parseInt(response.payment_id,10))
						{
							case -2:

								$self.e('.bcbs-booking-complete-payment-none').css('display','block');
								$self.e('.bcbs-booking-complete-payment-none>a').attr('href',response.button_back_to_home_url_address).text(response.button_back_to_home_label);

							break;

							case -1:

								if(parseInt(response.thank_you_page_enable,10)!==1)
								{
									window.location.href=response.payment_url;
								}
								else
								{
									$self.e('.bcbs-booking-complete-payment-woocommerce').css('display','block');
									$self.e('.bcbs-booking-complete-payment-woocommerce>a').attr('href',response.payment_url);
								}

							break;

							case 1:

								$self.e('.bcbs-booking-complete-payment-cash').css('display','block');
								$self.e('.bcbs-booking-complete-payment-cash>a').attr('href',response.button_back_to_home_url_address).text(response.button_back_to_home_label);

							break;

							case 2:

								$('body').css('display','none');

								$.getScript('https://js.stripe.com/v3/',function() 
								{								
									var stripe=Stripe(response.stripe_publishable_key);
									var section=$self.e('.bcbs-booking-complete-payment-stripe');

									$self.e('.bcbs-booking-complete').on('click','.bcbs-booking-complete-payment-stripe a',function(e)
									{
										e.preventDefault();

										stripe.redirectToCheckout(
										{
											sessionId:response.stripe_session_id
										}).then(function(result) 
										{

										});
									});

									var counter=parseInt(response.stripe_redirect_duration,10);

									if(counter<=0)
									{
										section.find('a').trigger('click');
									}
									else
									{
										$('body').css('display','block');

										section.find('a>span').html(counter);
										section.css('display','block');

										var interval=setInterval(function()
										{
											counter--;
											section.find('a>span').html(counter);

											if(counter===0)
											{
												clearInterval(interval);
												section.find('a').trigger('click');
											}

										},1000);  
									}
								});

							break;

							case 3:

								$('body').css('display','none');

								var section=$self.e('.bcbs-booking-complete-payment-paypal');

								var marinaDepartureId=$self.getMarinaId($self.e('[name="bcbs_marina_departure_id"]'));

								var counter=$option.marina_payment_paypal_redirect_duration[marinaDepartureId];

								$self.e('.bcbs-booking-complete').on('click','.bcbs-booking-complete-payment-paypal a',function(e)
								{
									e.preventDefault();

									var form=$self.e('form[name="bcbs-form-paypal"][data-marina-id="'+marinaDepartureId+'"]');

									for(var i in response.form)
										form.find('input[name="'+i+'"]').val(response.form[i]);

									form.submit();
								});

								if(counter<=0)
								{
									section.find('a').trigger('click');
								}
								else
								{
									$('body').css('display','block');

									section.find('a>span').html(counter);
									section.css('display','block');

									var interval=setInterval(function()
									{
										counter--;
										section.find('a>span').html(counter);

										if(counter===0)
										{
											clearInterval(interval);
											section.find('a').trigger('click');
										}

									},1000);  
								}

							break;

							case 4:

								$self.e('.bcbs-booking-complete-payment-wire_transfer').css('display','block');
								$self.e('.bcbs-booking-complete-payment-wire_transfer>a').attr('href',response.button_back_to_home_url_address).text(response.button_back_to_home_label);

							break;
						}
					}
                }
                                
				$self.preloader(false);
				
                if(typeof(callback)!=='undefined') callback();

				$self.createStickySidebar();
				$(window).scroll();
				
                var offset=20;
                
                if($('#wpadminbar').length===1)
                    offset+=$('#wpadminbar').height();
                
                $.scrollTo($('.bcbs-main'),{offset:-1*offset});
            });
        };
		
        /**********************************************************************/
        
		this.post=function(data,callback)
		{
			$.post($option.ajax_url,data,function(response)
			{ 
				callback(response); 
			},'json');
		};    
        
        /**********************************************************************/
        
        this.preloader=function(action)
        {
            $('#bcbs-preloader').css('display',(action ? 'block' : 'none'));
        };
        
        /**********************************************************************/
        
        this.preloadBoatImage=function()
        {
			try
			{
				$self.e('.bcbs-boat-list .bcbs-boat-image img').one('load',function()
				{
					$(this).parent('.bcbs-boat-image').animate({'opacity':1},300);
				}).each(function() 
				{
					if(this.complete) $(this).load();
				});
			}
			catch(e) {}
        };
        
        /**********************************************************************/
        /**********************************************************************/
       	   
        this.googleMapExist=function()
        {
            return(typeof($googleMap)==='undefined' ? false : true);
        };
        
        /**********************************************************************/
       
        this.googleMapDuplicate=function(step)
        {
            if(!$self.googleMapExist()) return;
            
            if(step===4)
            {
                var map=$self.e('.bcbs-google-map>#bcbs_google_map');
                if(map.children('div').length)
                {
                    $self.e('.bcbs-google-map-summary').append(map);  
                    $self.googleMapCreateMarker($self.e('[name="bcbs_marina_departure_id"]').val());
                }
            }
            else
            {
                var map=$self.e('.bcbs-google-map-summary>#bcbs_google_map');
                if(map.children('div').length)
                {
                    $self.e('.bcbs-google-map').append(map);
                    $self.googleMapCreateMarker(-1);
                }
            }
            
            google.maps.event.trigger($googleMap,'resize');
			
			$googleMap.setZoom($option.gooogleMapOption.zoomControl.level);
        };
        
        /**********************************************************************/
        
        this.googleMapCreateMarker=function(marinaIdSelected)
        {
            if(!$self.googleMapExist()) return;
            
            for(var i in $googleMapMarker)
                $googleMapMarker[i].setMap(null);
            
            $googleMapMarker=[];
            
            if(Object.keys($option.marina_coordinate).length)
            {
                var bound=new google.maps.LatLngBounds();
                
                for(var i in $option.marina_coordinate)
                {
                    if(marinaIdSelected!==-1)
                    {
                        if(marinaIdSelected!==i) continue;
                    }
                    
                    var coordinate=new google.maps.LatLng($option.marina_coordinate[i].lat,$option.marina_coordinate[i].lng);
                    
                    var marker=new google.maps.Marker(
                    {
                        id:i,
                        map:$googleMap,
                        position:coordinate,
                        icon:
						{
                            path:'M21,0A21,21,0,0,1,42,21c0,16-21,29-21,29S0,37,0,21A21,21,0,0,1,21,0Z',
                            fillColor:'#'+$option.booking_form_color[1],
                            strokeColor:'#'+$option.booking_form_color[1],
                            fillOpacity:1,
                            labelOrigin:new google.maps.Point(21,21),
                            anchor:new google.maps.Point(21,50)
                        },
                        label:
						{
                            text:''+(parseInt($option.boat_count_enable,10)===1 ? $option.marina_info[i].boat_count:' '), 
                            color:'#'+$option.booking_form_color[2],
                            fontSize:'14px',
                            fontWeight:'400',
                            fontFamily:'Lato'
                        }
                    });
                    
                    if(marinaIdSelected===-1)
                    {
                        marker.addListener('click',function() 
                        {
                            $self.openMarinaFrame($(this)[0].id);
                        });
                    }    
                
                    if(marinaIdSelected===-1)
                        bound.extend(coordinate);
                    
                    $googleMapMarker.push(marker);
                }
                
                if((marinaIdSelected===-1) && ($googleMapMarker.length>1))
                    $googleMap.fitBounds(bound);
                else $googleMap.setCenter(coordinate);
            }            
        };
        
        /**********************************************************************/
        
        this.googleMapInit=function()
        {
            if(!$self.googleMapExist()) return;
            
            if(Object.keys($option.marina_coordinate).length)
            {
                $self.googleMapCreateMarker(-1);
            }
            else
            {
                if((navigator.geolocation) && ($.inArray(1,$option.geolocation_enable))) 
                {
                    navigator.geolocation.getCurrentPosition(function(position)
                    {
                        $startLocation=new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
                        $googleMap.setCenter($startLocation);
                    },
                    function()
                    {
                        $self.googleMapUseDefaultLocation();
                    });
                } 
                else
                {
                    $self.googleMapUseDefaultLocation();
                }
            }
        };
        
        /**********************************************************************/
        
        this.googleMapUseDefaultLocation=function()
        {
            if(!$self.googleMapExist()) return;
            
            $startLocation=new google.maps.LatLng($option.client_coordinate.lat,$option.client_coordinate.lng);
            $googleMap.setCenter($startLocation);            
        };
        
        /**********************************************************************/
        
        this.googleMapCreate=function()
        {
            if($self.e('#bcbs_google_map').length!==1) return;
            
            var option= 
            {
                draggable:$option.gooogleMapOption.draggable.enable,
                scrollwheel:$option.gooogleMapOption.scrollwheel.enable,
                mapTypeId:google.maps.MapTypeId[$option.gooogleMapOption.mapControl.id],
                mapTypeControl:$option.gooogleMapOption.mapControl.enable,
                mapTypeControlOptions:
				{
                    style:google.maps.MapTypeControlStyle[$option.gooogleMapOption.mapControl.style],
                    position:google.maps.ControlPosition[$option.gooogleMapOption.mapControl.position],
                },
                zoom:$option.gooogleMapOption.zoomControl.level,
                zoomControl:$option.gooogleMapOption.zoomControl.enable,
                zoomControlOptions:
				{
                    position:google.maps.ControlPosition[$option.gooogleMapOption.zoomControl.position]
                },
                streetViewControl:false,
                styles:$option.gooogleMapOption.style
            };
            
            $googleMap=new google.maps.Map($self.e('#bcbs_google_map')[0],option);
        };
        
        /**********************************************************************/
        
		this.setWidthClass=function()
		{
			var width=$this.parent().width();
			
			var className=null;
			var classPrefix='bcbs-width-';
			
			if(width>=1220) className='1220';
			else if(width>=960) className='960';
			else if(width>=768) className='768';
			else if(width>=480) className='480';
			else if(width>=300) className='300';
            else className='300';
			
			var oldClassName=$self.getValueFromClass($this,classPrefix);
			if(oldClassName!==false) $this.removeClass(classPrefix+oldClassName);
			
			$this.addClass(classPrefix+className);
			
            if(width>=960) $this.removeClass('bcbs-widthlt-960');
            else $this.addClass('bcbs-widthlt-960');
            
			if(width<=300) $this.addClass('bcbs-widthlt-300');
			else $this.removeClass('bcbs-widthlt-300');
			
			if($self.prevWidth!==width)
            {
				$self.prevWidth=width;
                $(window).resize();
                                
                $self.createStickySidebar();
				
				if(parseInt($self.e('input[name="bcbs_step"]').val(),10)===1)
				{
					if(parseInt($option.widget.mode,10)!==1)
					{
						if($.inArray(className,['300','480'])>-1)
							$self.googleMapStopCustomizeHeight();
						else $self.googleMapStartCustomizeHeight();
					}
				}
            };
                        
			setTimeout($self.setWidthClass,500);
		};
       
		/**********************************************************************/
		
		this.getValueFromClass=function(object,pattern)
		{
			try
			{
				var reg=new RegExp(pattern);
				var className=$(object).attr('class').split(' ');

				for(var i in className)
				{
					if(reg.test(className[i]))
						return(className[i].substring(pattern.length));
				}
			}
			catch(e) {}

			return(false);		
		};
        
        /**********************************************************************/
        
        this.createSummaryPriceElement=function()
        {
            $self.setAction('create_summary_price_element');
  
            $self.post($self.e('form[name="bcbs-form"]').serialize(),function(response)
            {    
                $self.e('.bcbs-summary-price-element').replaceWith(response.html);
                $(window).scroll();
            });   
        };
        
        /**********************************************************************/
        
        this.createStickySidebar=function()
        {
            if(parseInt($option.summary_sidebar_sticky_enable,10)!==1) return;
            
            var className=$self.getValueFromClass($this,'bcbs-width-');
            
            if($.inArray(className,['300','480','768'])>-1)
            {
                $self.removeStickySidebar();
                return;
            }       
			
            var step=parseInt($self.e('input[name="bcbs_step"]').val(),10);
			
            $sidebar=$self.e('.bcbs-main-content>.bcbs-main-content-step-'+step+'>.bcbs-layout-25x75 .bcbs-layout-column-left:first').theiaStickySidebar({'additionalMarginTop':20,'additionalMarginBottom':20});
        };
        
        /**********************************************************************/
        
        this.removeStickySidebar=function()
        {
            if(parseInt($option.summary_sidebar_sticky_enable,10)!==1) return;
			try
			{
				$sidebar.destroy();
			}
			catch(e) {}
        };
        
        /**********************************************************************/
        
        this.getGlobalNotice=function()
        {
            var step=parseInt($self.e('input[name="bcbs_step"]').val(),10);
            return($self.e('.bcbs-main-content-step-'+step+' .bcbs-notice'));
        };
    
        /**********************************************************************/
        
        this.openMarinaFrame=function(marinaId)
        {
            var frame=$self.e('#bcbs-marina-info-frame');
            
            $self.closeMarinaFrame();
            
            frame.css({display:'block'});
            frame.children('div[data-marina-id="'+marinaId+'"]').addClass('bcbs-state-open').css({display:'block'});
        };
        
        /**********************************************************************/
        
        this.closeMarinaFrame=function()
        {
            var frame=$self.e('#bcbs-marina-info-frame');
            frame.css({display:'none'});
            frame.children('div').removeClass('bcbs-state-open').css({display:'none'});            
        };
		
		/**********************************************************************/
		
        this.googleMapStartCustomizeHeight=function()
        {
			if(!$self.googleMapExist()) return;
			
            if(parseInt($option.widget.mode,10)===1) return;
            
            if($googleMapHeightInterval>0) return;
            
            $googleMapHeightInterval=window.setInterval(function()
            {
                $self.googleMapCustomizeHeight();
            },500);
        };
        
        /**********************************************************************/
       
        this.googleMapStopCustomizeHeight=function()
        {
			if(!$self.googleMapExist()) return;
			
            if(parseInt($option.widget.mode,10)===1) return;
     
            clearInterval($googleMapHeightInterval);
            $self.e('#bcbs_google_map').height('640px');
            
            $googleMapHeightInterval=0;
        };        
        
        /**********************************************************************/
       
        this.googleMapCustomizeHeight=function()
        {
			if(!$self.googleMapExist()) return;
			
            if(parseInt($option.widget.mode,10)===1) return;
			if(parseInt($self.e('[name="bcbs_step"]').val(),10)>=2) return;
			
            var columnLeft=$self.e('.bcbs-main-content-step-1>div>.bcbs-layout-column-left');
            
            $self.e('#bcbs_google_map').height(parseInt(columnLeft.actual('outerHeight'),10));
            
            google.maps.event.trigger($googleMap,'resize');
        };
		        
        /**********************************************************************/
        /**********************************************************************/
	};
	
	/**************************************************************************/
	
	$.fn.BCBSBookingForm=function(option) 
	{
        console.log('--------------------------------------------------------------------------------------------');
        console.log('Boat and Yacht Charter Booking System for WordPress ver. '+option.plugin_version);
        console.log('https://1.envato.market/boat-charter-booking-system-for-wordpress');
        console.log('--------------------------------------------------------------------------------------------');
        
		var form=new BCBSBookingForm(this,option);
        return(form);
	};
	
	/**************************************************************************/

})(jQuery,document,window);

/******************************************************************************/
/******************************************************************************/