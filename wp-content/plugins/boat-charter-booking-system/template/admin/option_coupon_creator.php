<?php
		$Date=new BCBSDate();
?>
		<ul class="to-form-field-list">
			<li>
				<h5><?php esc_html_e('Count','boat-charter-booking-system'); ?></h5>
				<span class="to-legend">
					<?php esc_html_e('Number of coupons which should be generated.','boat-charter-booking-system'); ?><br/>
					<?php esc_html_e('Allowed are integer numbers from range 1-999.','boat-charter-booking-system'); ?>
				</span>
				<div>
					<input type="text" maxlength="3" name="<?php BCBSHelper::getFormName('coupon_generate_count'); ?>" id="<?php BCBSHelper::getFormName('coupon_generate_count'); ?>" value="<?php echo esc_attr($this->data['option']['coupon_generate_count']); ?>"/>
				</div>
			</li> 
			<li>
				<h5><?php esc_html_e('Usage limit','boat-charter-booking-system'); ?></h5>
				<span class="to-legend"><?php esc_html_e('Current usage count of the code. Allowed are integer values from range 1-9999. Leave blank for unlimited.','boat-charter-booking-system'); ?></span>
				<div>
					<input type="text" maxlength="4" name="<?php BCBSHelper::getFormName('coupon_generate_usage_limit'); ?>" id="<?php BCBSHelper::getFormName('coupon_generate_usage_limit'); ?>" value="<?php echo esc_attr($this->data['option']['coupon_generate_usage_limit']); ?>"/>
				</div>
			</li>							 
			<li>
				<h5><?php esc_html_e('Percentage discount','boat-charter-booking-system'); ?></h5>
				<span class="to-legend">
					<?php esc_html_e('Percentage discount. Allowed are integer numbers from 1-99.','boat-charter-booking-system'); ?></span>
				<div>
					<input type="text" maxlength="2" name="<?php BCBSHelper::getFormName('coupon_generate_discount_percentage'); ?>" id="<?php BCBSHelper::getFormName('coupon_generate_discount_percentage'); ?>" value="<?php echo esc_attr($this->data['option']['coupon_generate_discount_percentage']); ?>"/>
				</div>
			</li>   
			<li>
				<h5><?php esc_html_e('Fixed discount','boat-charter-booking-system'); ?></h5>
				<span class="to-legend"><?php esc_html_e('Fixed discount.','boat-charter-booking-system'); ?></span>
				<div>
					<input type="text" maxlength="12" name="<?php BCBSHelper::getFormName('coupon_generate_discount_fixed'); ?>" id="<?php BCBSHelper::getFormName('coupon_generate_discount_fixed'); ?>" value="<?php echo esc_attr($this->data['option']['coupon_generate_discount_fixed']); ?>"/>
				</div>
			</li>	 
			<li>
				<h5><?php esc_html_e('Active from','boat-charter-booking-system'); ?></h5>
				<span class="to-legend"><?php esc_html_e('Start date. Leave blank for no start date.','boat-charter-booking-system'); ?></span>
				<div>
					<input type="text" class="to-datepicker-custom" name="<?php BCBSHelper::getFormName('coupon_generate_active_date_start'); ?>" id="<?php BCBSHelper::getFormName('coupon_generate_active_date_start'); ?>" value="<?php echo esc_attr($this->data['option']['coupon_generate_active_date_start']); ?>"/>
				</div>
			</li>  
			<li>
				<h5><?php esc_html_e('Active to','boat-charter-booking-system'); ?></h5>
				<span class="to-legend"><?php esc_html_e('Stop date. Leave blank for no start date.','boat-charter-booking-system'); ?></span>
				<div>
					<input type="text" class="to-datepicker-custom" name="<?php BCBSHelper::getFormName('coupon_generate_active_date_stop'); ?>" id="<?php BCBSHelper::getFormName('coupon_generate_active_date_stop'); ?>" value="<?php echo esc_attr($this->data['option']['coupon_generate_active_date_stop']); ?>"/>
				</div>
			</li>
			<li>
				<input type="button" name="<?php BCBSHelper::getFormName('create_coupon_code'); ?>" id="<?php BCBSHelper::getFormName('create_coupon_code'); ?>" class="to-button to-margin-0" value="<?php esc_attr_e('Create coupons','boat-charter-booking-system'); ?>"/>
			</li>
		</ul>
		<script type="text/javascript">
			jQuery(document).ready(function($)
			{	
				var timeFormat='<?php echo BCBSOption::getOption('time_format'); ?>';
				var dateFormat='<?php echo BCBSJQueryUIDatePicker::convertDateFormat(BCBSOption::getOption('date_format')); ?>';
				
				toCreateCustomDateTimePicker(dateFormat,timeFormat);
				
				$('#<?php BCBSHelper::getFormName('create_coupon_code'); ?>').bind('click',function(e) 
				{
					e.preventDefault();
					$('#action').val('<?php echo PLUGIN_BCBS_CONTEXT.'_option_page_create_coupon_code'; ?>');
					$('#to_form').submit();
					$('#action').val('<?php echo PLUGIN_BCBS_CONTEXT.'_option_page_save'; ?>');
				});
			});
		</script>