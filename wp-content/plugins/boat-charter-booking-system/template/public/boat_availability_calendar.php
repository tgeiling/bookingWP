
		<div class="bcbs-main bcbs-booking-form-id-<?php echo esc_attr($this->data['boat_availability_calendar_booking_form_id']); ?> bcbs-boat-availability-calendar bcbs-state-load" id="<?php echo esc_attr($this->data['boat_availability_calendar_booking_form_html_id']); ?>"> 
<?php
		if(count($this->data['error']))
		{
?>				
			<div class="bcbs-notice"><?php echo esc_html($this->data['error']['message']); ?></div>
<?php			
		}
		else 
		{
?>
			<div class="bcbs-boat-availability-calendar-header">
				<?php echo $this->data['boat_availability_calendar_header']; ?>
			</div>

			<div class="bcbs-boat-availability-calendar-calendar">
				<?php echo $this->data['boat_availability_calendar_calendar']; ?>
			</div>

			<input type="hidden" name="<?php BCBSHelper::getFormName('boat_availability_calendar_year_number'); ?>" value="<?php echo (int)$this->data['boat_availability_calendar_year_number']; ?>"/>
			<input type="hidden" name="<?php BCBSHelper::getFormName('boat_availability_calendar_month_number'); ?>" value="<?php echo (int)$this->data['boat_availability_calendar_month_number']; ?>"/>

			<input type="hidden" name="<?php BCBSHelper::getFormName('boat_availability_calendar_boat_id'); ?>" value="<?php echo (int)$this->data['boat_availability_calendar_boat_id']; ?>"/>
			<input type="hidden" name="<?php BCBSHelper::getFormName('boat_availability_calendar_booking_form_id'); ?>" value="<?php echo (int)$this->data['boat_availability_calendar_booking_form_id']; ?>"/>

			<div id="bcbs-boat-availability-calendar-preloader"></div>
<?php
		}
?>	
		</div>
<?php
		BCBSHelper::addInlineScript('bcbs-booking-form',
		'
			jQuery(document).ready(function($)
			{
				$(\'#'.esc_attr($this->data['boat_availability_calendar_booking_form_html_id']).'\').BCBSBoatAvailabilityCalendar(
				{			
					\'ajax_url\':\''.esc_url($this->data['ajax_url']).'\',
				}).setup();
			});
		');