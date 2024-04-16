/******************************************************************************/
/******************************************************************************/

;(function($,doc,win) 
{
	"use strict";
	
	var BCBSBoatAvailabilityCalendar=function(object,option)
	{
		/**********************************************************************/
		
        var $self=this;
		var $this=$(object);
        
		var $optionDefault;
		var $option=$.extend($optionDefault,option);
        
		/**********************************************************************/
		
        this.setup=function()
        {
			$self.setupEvent();
			
			$self.watch();
			
			$this.removeClass('bcbs-state-load');
        };
		
		/**********************************************************************/
		
		this.setupEvent=function()
		{
			$this.find('.bcbs-boat-availability-calendar-header>a:first').on('click',function(e)
			{
				e.preventDefault();
				$self.increaseMonthNumber(-1);
				$self.sendRequest();
			});
		
			$this.find('.bcbs-boat-availability-calendar-header>a:first+a').on('click',function(e)	
			{
				e.preventDefault();
				$self.increaseMonthNumber(1);
				$self.sendRequest();
			});	
		};
		
		/**********************************************************************/

		this.watch=function()
		{
			var helper=new BCBSHelper();

			var width=$this.parent().width();

			var className=null;
			var classPrefix='bcbs-boat-availability-calendar-width-';

			if(width>=1220) className='1220';
			else if(width>=960) className='960';
			else if(width>=768) className='768';
			else if(width>=480) className='480';
			else className='300';

			var oldClassName=helper.getValueFromClass($this,classPrefix);
			if(oldClassName!==false) $this.removeClass(classPrefix+oldClassName);

			$this.addClass(classPrefix+className);
			
			/***/
			
			$self.equalCell();
			
			/***/

			setTimeout($self.watch,500);
		};
		
		/**********************************************************************/
		
		this.equalCell=function()
		{
			var width=$this.find('.bcbs-boat-availability-calendar-calendar td:first').actual('width');
			$this.find('.bcbs-boat-availability-calendar-calendar td').height(width);			
		};
		
        /**********************************************************************/
	
		this.sendRequest=function()
		{
			var data={};

			data.action='bcbs_boat_availability_calendar_ajax';

			data.bcbs_boat_availability_calendar_year_number=jQuery('input[name="bcbs_boat_availability_calendar_year_number"]').val();
			data.bcbs_boat_availability_calendar_month_number=jQuery('input[name="bcbs_boat_availability_calendar_month_number"]').val();

			data.bcbs_boat_availability_calendar_boat_id=jQuery('input[name="bcbs_boat_availability_calendar_boat_id"]').val();

			$self.preloader(true);

			jQuery.post($option.ajax_url,data,function(response) 
			{		
				$self.preloader(false);
				
				$('.bcbs-boat-availability-calendar-header>h2').html(response.boat_availability_calendar_header);
				$('.bcbs-boat-availability-calendar-calendar').html(response.boat_availability_calendar_calendar);
				
				$self.equalCell();
			},'json');
		};
	
		/**********************************************************************/
	
		this.increaseMonthNumber=function(step)
		{
			var month=parseInt(jQuery('input[name="bcbs_boat_availability_calendar_month_number"]').val(),10);

			month+=step;

			$('input[name="bcbs_boat_availability_calendar_month_number"]').val(month);
		};
	
		/**********************************************************************/
	
		this.preloader=function(action)
		{
			//$('#bcbs-boat-availability-calendar-preloader').css('display',(action ? 'block' : 'none'));
		};

		/**********************************************************************/
	};
		
	/**************************************************************************/
	
	$.fn.BCBSBoatAvailabilityCalendar=function(option) 
	{
        var boatAvailabilityCalendar=new BCBSBoatAvailabilityCalendar(this,option);
        return(boatAvailabilityCalendar);            
	};
	
	/**************************************************************************/

})(jQuery,document,window);

/******************************************************************************/
/******************************************************************************/