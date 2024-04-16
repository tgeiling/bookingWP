<?php 
		echo BCBSHelper::displayNonce($this->data);; 
		$Date=new BCBSDate();
?>	
		<div class="to">
			<div class="ui-tabs">
				<ul>
					<li><a href="#meta-box-coupon-1"><?php esc_html_e('General','boat-charter-booking-system'); ?></a></li>
				</ul>
				<div id="meta-box-coupon-1">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Coupon code','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Unique, coupon code.','boat-charter-booking-system'); ?></span>
							<div>
								<input type="text" maxlength="32" name="<?php BCBSHelper::getFormName('code'); ?>" id="<?php BCBSHelper::getFormName('code'); ?>" value="<?php echo esc_attr($this->data['meta']['code']); ?>"/>
							</div>
						</li>  
						<li>
							<h5><?php esc_html_e('Usage count','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Current usage count of the coupon.','boat-charter-booking-system'); ?></span>
							<div class="to-field-disabled">
								<?php echo esc_html($this->data['meta']['usage_count']); ?>
							</div>
						</li>  
						<li>
							<h5><?php esc_html_e('Usage limit','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Usage limit of the coupon. Allowed are integer values from range 1-9999. Leave blank for unlimited.','boat-charter-booking-system'); ?></span>
							<div>
								<input type="text" maxlength="4" name="<?php BCBSHelper::getFormName('usage_limit'); ?>" id="<?php BCBSHelper::getFormName('usage_limit'); ?>" value="<?php echo esc_attr($this->data['meta']['usage_limit']); ?>"/>
							</div>
						</li>  
						<li>
							<h5><?php esc_html_e('Boats','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Select boats for which coupon will be applied.','boat-charter-booking-system'); ?></span>
							<div class="to-checkbox-button">
								<input type="checkbox" value="-1" id="<?php BCBSHelper::getFormName('boat_id_0'); ?>" name="<?php BCBSHelper::getFormName('boat_id[]'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['boat_id'],-1); ?>/>
								<label for="<?php BCBSHelper::getFormName('boat_id_0'); ?>"><?php esc_html_e('- All boats -','boat-charter-booking-system') ?></label>
<?php
		foreach($this->data['dictionary']['boat'] as $index=>$value)
		{
?>
								<input type="checkbox" value="<?php echo esc_attr($index); ?>" id="<?php BCBSHelper::getFormName('boat_id_'.$index); ?>" name="<?php BCBSHelper::getFormName('boat_id[]'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['boat_id'],$index); ?>/>
								<label for="<?php BCBSHelper::getFormName('boat_id_'.$index); ?>"><?php echo esc_html($value['post']->post_title); ?></label>
<?php		
		}
?>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Boat categories','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Select boat categories for which coupon will be applied.','boat-charter-booking-system'); ?></span>
							<div class="to-checkbox-button">
								<input type="checkbox" value="-1" id="<?php BCBSHelper::getFormName('boat_category_id_0'); ?>" name="<?php BCBSHelper::getFormName('boat_category_id[]'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['boat_category_id'],-1); ?>/>
								<label for="<?php BCBSHelper::getFormName('boat_category_id_0'); ?>"><?php esc_html_e('- All boat categories -','boat-charter-booking-system') ?></label>
<?php
		foreach($this->data['dictionary']['boat_category'] as $index=>$value)
		{
?>
								<input type="checkbox" value="<?php echo esc_attr($index); ?>" id="<?php BCBSHelper::getFormName('boat_category_id_'.$index); ?>" name="<?php BCBSHelper::getFormName('boat_category_id[]'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['boat_category_id'],$index); ?>/>
								<label for="<?php BCBSHelper::getFormName('boat_category_id_'.$index); ?>"><?php echo esc_html($value['name']); ?></label>
<?php		
		}
?>
							</div>							
						</li>
						<li>
							<h5><?php esc_html_e('Active from','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Start date. Leave blank if there is no start date.','boat-charter-booking-system'); ?></span>
							<div>
								<input type="text" class="to-datepicker-custom" name="<?php BCBSHelper::getFormName('active_date_start'); ?>" id="<?php BCBSHelper::getFormName('active_date_start'); ?>" value="<?php echo esc_attr($Date->formatDateToDisplay($this->data['meta']['active_date_start'])); ?>"/>
							</div>
						</li>  
						<li>
							<h5><?php esc_html_e('Active to','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Stop date. Leave blank if there is no stop date.','boat-charter-booking-system'); ?></span>
							<div>
								<input type="text" class="to-datepicker-custom" name="<?php BCBSHelper::getFormName('active_date_stop'); ?>" id="<?php BCBSHelper::getFormName('active_date_stop'); ?>" value="<?php echo esc_attr($Date->formatDateToDisplay($this->data['meta']['active_date_stop'])); ?>"/>
							</div>
						</li>  						
						<li>
							<h5><?php esc_html_e('Percentage discount','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Percentage discount. Allowed are float numbers from 0.00-99.00.','boat-charter-booking-system'); ?></span>
							<div>
								<input type="text" maxlength="5" name="<?php BCBSHelper::getFormName('discount_percentage'); ?>" id="<?php BCBSHelper::getFormName('discount_percentage'); ?>" value="<?php echo esc_attr($this->data['meta']['discount_percentage']); ?>"/>
							</div>
						</li>	 
						<li>
							<h5><?php esc_html_e('Fixed discount','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Fixed discount. This discount is used only if percentage discount is set to 0.','boat-charter-booking-system'); ?></span>
							<div>
								<input type="text" maxlength="12" name="<?php BCBSHelper::getFormName('discount_fixed'); ?>" id="<?php BCBSHelper::getFormName('discount_fixed'); ?>" value="<?php echo esc_attr($this->data['meta']['discount_fixed']); ?>"/>
							</div>
						</li>  
					   <li>
							<h5><?php esc_html_e('Discount based on rental days number','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php echo esc_html__('Enter discount (percentage or fixed) for selected range of rental days. This option works for "Daily" billing type only.','boat-charter-booking-system'); ?><br/>
								<?php echo esc_html__('Fixed discount is used only if percentage discount is set to 0. If days ranges will not be found, default discount from coupon will be applied.','boat-charter-booking-system'); ?><br/>
							</span>
							<div>
								<table class="to-table" id="to-table-discount-rental-day-count">
									<tr>
										<th style="width:20%">
											<div>
												<?php esc_html_e('From','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('From.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:20%">
											<div>
												<?php esc_html_e('To','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('To.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:20%">
											<div>
												<?php esc_html_e('Percentage discount','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Percentage discount.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:20%">
											<div>
												<?php esc_html_e('Fixed discount','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Fixed discount.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:20%">
											<div>
												<?php esc_html_e('Remove','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Remove this entry.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>											
									</tr>
									<tr class="to-hidden">
										<td>
											<div>
												<input type="text" maxlength="5" name="<?php BCBSHelper::getFormName('discount_rental_day_count[start][]'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" maxlength="5" name="<?php BCBSHelper::getFormName('discount_rental_day_count[stop][]'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" maxlength="5" name="<?php BCBSHelper::getFormName('discount_rental_day_count[discount_percentage][]'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" maxlength="12" name="<?php BCBSHelper::getFormName('discount_rental_day_count[discount_fixed][]'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','boat-charter-booking-system'); ?></a>
											</div>
										</td>
									</tr>   
<?php
		if(isset($this->data['meta']['discount_rental_day_count']))
		{
			if(is_array($this->data['meta']['discount_rental_day_count']))
			{
				foreach($this->data['meta']['discount_rental_day_count'] as $index=>$value)
				{
?>
									<tr>
										<td>
											<div>
												<input type="text" maxlength="5" name="<?php BCBSHelper::getFormName('discount_rental_day_count[start][]'); ?>" value="<?php echo esc_attr($value['start']); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" maxlength="5" name="<?php BCBSHelper::getFormName('discount_rental_day_count[stop][]'); ?>" value="<?php echo esc_attr($value['stop']); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" maxlength="5" name="<?php BCBSHelper::getFormName('discount_rental_day_count[discount_percentage][]'); ?>" value="<?php echo esc_attr($value['discount_percentage']); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" maxlength="12" name="<?php BCBSHelper::getFormName('discount_rental_day_count[discount_fixed][]'); ?>" value="<?php echo esc_attr($value['discount_fixed']); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','boat-charter-booking-system'); ?></a>
											</div>
										</td>										
									</tr>	 
<?php				  
				}
			}
		}
?>
								</table>
								<div> 
									<a href="#" class="to-table-button-add"><?php esc_html_e('Add','boat-charter-booking-system'); ?></a>
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function($)
			{	
				$('.to').themeOptionElement({init:true});
				
				var timeFormat='<?php echo BCBSOption::getOption('time_format'); ?>';
				var dateFormat='<?php echo BCBSJQueryUIDatePicker::convertDateFormat(BCBSOption::getOption('date_format')); ?>';
				
				toCreateCustomDateTimePicker(dateFormat,timeFormat);
				
				$('#to-table-discount-rental-day-count').table();
				
				$('input[name="<?php BCBSHelper::getFormName('boat_id'); ?>[]"],input[name="<?php BCBSHelper::getFormName('boat_category_id'); ?>[]"]').on('change',function()
				{
					var checkbox=$(this).parents('li:first').find('input');
					
					var value=parseInt($(this).val());
					if(value===-1)
					{
						checkbox.prop('checked',false);
						checkbox.first().prop('checked',true);
					}
					else checkbox.first().prop('checked',false);
					
					var checked=[];
					checkbox.each(function()
					{
						if($(this).is(':checked'))
							checked.push(parseInt($(this).val(),10));
					});
					
					if(checked.length===0)
					{
						checkbox.prop('checked',false);
						checkbox.first().prop('checked',true);
					}
					
					checkbox.button('refresh');
				});
				
			});
		</script>