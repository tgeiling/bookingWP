<?php
		echo BCBSHelper::displayNonce($this->data);; 

		$Date=new BCBSDate();
		$Validation=new BCBSValidation();
		
		if(($Validation->isEmpty($this->data['meta']['coordinate_latitude'])) || ($Validation->isEmpty($this->data['meta']['coordinate_longitude'])))
		{
?>	
		<div class="notice notice-error">
			<p>
				<?php esc_html_e('Please provide coordinates of marina in "Address" tab. Otherwise marina will not be available in booking form.','boat-charter-booking-system') ?>
			</p>
		</div>
<?php
		}
?>		
		<div class="to">
			<div class="ui-tabs">
				<ul>
					<li><a href="#meta-box-marina-1"><?php esc_html_e('General','boat-charter-booking-system'); ?></a></li>
					<li><a href="#meta-box-marina-2"><?php esc_html_e('Address','boat-charter-booking-system'); ?></a></li>
					<li><a href="#meta-box-marina-3"><?php esc_html_e('Availability','boat-charter-booking-system'); ?></a></li>
					<li><a href="#meta-box-marina-4"><?php esc_html_e('Payments','boat-charter-booking-system'); ?></a></li>
					<li><a href="#meta-box-marina-5"><?php esc_html_e('Notifications','boat-charter-booking-system'); ?></a></li>
					<li><a href="#meta-box-marina-6"><?php esc_html_e('Google Calendar','boat-charter-booking-system'); ?></a></li>
				</ul>
				<div id="meta-box-marina-1">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Berths number','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Enter number of berths.','boat-charter-booking-system'); ?><br/>
								<?php esc_html_e('Allowed are integer values from 1 to 9999. Leave empty if not defined.','boat-charter-booking-system'); ?>
							</span>
							<div>
								<input type="text" maxlength="4" name="<?php BCBSHelper::getFormName('berth_number'); ?>" value="<?php echo esc_attr($this->data['meta']['berth_number']); ?>"/>
							</div>   
						</li>  
						<li>
							<h5><?php esc_html_e('Boat max length','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Enter maximum length (in meters) of boat.','boat-charter-booking-system'); ?><br/>
								<?php esc_html_e('Allowed are integer values from 1 to 999. Leave empty if not defined.','boat-charter-booking-system'); ?>
							</span>
							<div>
								<input type="text" maxlength="3" name="<?php BCBSHelper::getFormName('boat_max_length'); ?>" value="<?php echo esc_attr($this->data['meta']['boat_max_length']); ?>"/>
							</div>   
						</li>  						
						<li>
							<h5><?php esc_html_e('Boat max draught','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Enter maximum draught (in meters) of boat.','boat-charter-booking-system'); ?><br/>
								<?php esc_html_e('Allowed are integer values from 1 to 999. Leave empty if not defined.','boat-charter-booking-system'); ?>
							</span>
							<div>
								<input type="text" maxlength="3" name="<?php BCBSHelper::getFormName('boat_max_draught'); ?>" value="<?php echo esc_attr($this->data['meta']['boat_max_draught']); ?>"/>
							</div>   
						</li> 						
						<li>
							<h5><?php esc_html_e('Departure period','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Set range (in days/hours/minutes) during which customer can departure boat.','boat-charter-booking-system'); ?><br/>
								<?php esc_html_e('Eg. range 1-14 days means that customer can departure boat from tomorrow during next two weeks.','boat-charter-booking-system'); ?><br/>
								<?php esc_html_e('Empty values means that departure period is not limited.','boat-charter-booking-system'); ?>
							</span>
							<div>
								<span class="to-legend-field"><?php esc_html_e('From (number of days/hours/minutes - counting from now - since when customer can departure of boat):','boat-charter-booking-system'); ?></span>
								<input type="text" maxlength="4" name="<?php BCBSHelper::getFormName('departure_period_from'); ?>" value="<?php echo esc_attr($this->data['meta']['departure_period_from']); ?>"/>
							</div>   
							<div>
								<span class="to-legend-field"><?php esc_html_e('To (number of days/hours/minutes - counting from now plus number of days/hours/minutes from previous field - until when customer can departure of boat):','boat-charter-booking-system'); ?></span>
								<input type="text" maxlength="4" name="<?php BCBSHelper::getFormName('departure_period_to'); ?>" value="<?php echo esc_attr($this->data['meta']['departure_period_to']); ?>"/>
							</div>  
							<div>
								<span class="to-legend-field"><?php esc_html_e('Time unit:','boat-charter-booking-system'); ?></span>
								<div class="to-radio-button">
									<input type="radio" value="1" id="<?php BCBSHelper::getFormName('departure_period_type_1'); ?>" name="<?php BCBSHelper::getFormName('departure_period_type'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['departure_period_type'],1); ?>/>
									<label for="<?php BCBSHelper::getFormName('departure_period_type_1'); ?>"><?php esc_html_e('Days','boat-charter-booking-system'); ?></label>
									<input type="radio" value="2" id="<?php BCBSHelper::getFormName('departure_period_type_2'); ?>" name="<?php BCBSHelper::getFormName('departure_period_type'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['departure_period_type'],2); ?>/>
									<label for="<?php BCBSHelper::getFormName('departure_period_type_2'); ?>"><?php esc_html_e('Hours','boat-charter-booking-system'); ?></label>
									<input type="radio" value="3" id="<?php BCBSHelper::getFormName('departure_period_type_3'); ?>" name="<?php BCBSHelper::getFormName('departure_period_type'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['departure_period_type'],3); ?>/>
									<label for="<?php BCBSHelper::getFormName('departure_period_type_3'); ?>"><?php esc_html_e('Minutes','boat-charter-booking-system'); ?></label>
								</div>  
							</div>
						</li> 
						<li>
							<h5><?php esc_html_e('Range of days to charter a boat','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Maximum and minimum days count of charter a boat.','boat-charter-booking-system'); ?><br/>
								<?php esc_html_e('This option works for "Daily" billing type only. Empty or zero values are ignored.','boat-charter-booking-system'); ?>
							</span>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Minimum:','boat-charter-booking-system'); ?></span>
								<input type="text" maxlength="4" name="<?php BCBSHelper::getFormName('boat_charter_day_count_min'); ?>" value="<?php echo esc_attr($this->data['meta']['boat_charter_day_count_min']); ?>"/>
							</div>   
							<div>
								<span class="to-legend-field"><?php esc_html_e('Maximum:','boat-charter-booking-system'); ?></span>
								<input type="text" maxlength="4" name="<?php BCBSHelper::getFormName('boat_charter_day_count_max'); ?>" value="<?php echo esc_attr($this->data['meta']['boat_charter_day_count_max']); ?>"/>
							</div>  
						</li>  
						<li>
							<h5><?php esc_html_e('Range of days to charter a boat depends on dates','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Specify minimum and maximum days count of charter boat for defined dates.','boat-charter-booking-system'); ?><br/>
								<?php esc_html_e('This option has higher priority than these defined in section "Range of days to charter a boat".','boat-charter-booking-system'); ?><br/>
								<?php esc_html_e('This option works for "Daily" billing type only. Empty or zero values are ignored.','boat-charter-booking-system'); ?>
							</span> 
							<div class="to-clear-fix">
								<table class="to-table" id="to-table-boat-charter-date">
									<tr>
										<th style="width:20%">
											<div>
												<?php esc_html_e('From','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Start date in DD-MM-YYYY format.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:20%">
											<div>
												<?php esc_html_e('To','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('End date in DD-MM-YYYY format.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:20%">
											<div>
												<?php esc_html_e('Minimum','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Minimum days count of charter a boat.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>										
										<th style="width:20%">
											<div>
												<?php esc_html_e('Maximum','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Maximum days count of charter a boat.','boat-charter-booking-system'); ?>
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
												<input type="text" maxlength="10" class="to-datepicker" name="<?php BCBSHelper::getFormName('boat_charter_date[start][]'); ?>" title="<?php esc_attr_e('Enter start date in DD-MM-YYYY format.','boat-charter-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" maxlength="10" class="to-datepicker" name="<?php BCBSHelper::getFormName('boat_charter_date[stop][]'); ?>" title="<?php esc_attr_e('Enter stop date in DD-MM-YYYY format.','boat-charter-booking-system'); ?>"/>
											</div>									
										</td>	
										<td>
											<div>
												<input type="text" maxlength="4" name="<?php BCBSHelper::getFormName('boat_charter_date[day_count_min][]'); ?>" title="<?php esc_attr_e('Enter minimum days count..','boat-charter-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" maxlength="4" name="<?php BCBSHelper::getFormName('boat_charter_date[day_count_max][]'); ?>" title="<?php esc_attr_e('Enter maximum days count.','boat-charter-booking-system'); ?>"/>
											</div>									
										</td>	
										<td>
											<div>
												<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','boat-charter-booking-system'); ?></a>
											</div>
										</td>										
									</tr>	
									</tr>
<?php
		if(count($this->data['meta']['boat_charter_date']))
		{
			foreach($this->data['meta']['boat_charter_date'] as $index=>$value)
			{
?>
									<tr>
										<td>
											<div>
												<input type="text" maxlength="10" class="to-datepicker" value="<?php echo esc_attr($value['start']); ?>" name="<?php BCBSHelper::getFormName('boat_charter_date[start][]'); ?>" title="<?php esc_attr_e('Enter start date in DD-MM-YYYY format.','boat-charter-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" maxlength="10" class="to-datepicker" value="<?php echo esc_attr($value['stop']); ?>" name="<?php BCBSHelper::getFormName('boat_charter_date[stop][]'); ?>" title="<?php esc_attr_e('Enter stop date in DD-MM-YYYY format.','boat-charter-booking-system'); ?>"/>
											</div>									
										</td>	
										<td>
											<div>
												<input type="text" maxlength="4" value="<?php echo esc_attr($value['day_count_min']); ?>" name="<?php BCBSHelper::getFormName('boat_charter_date[day_count_min][]'); ?>" title="<?php esc_attr_e('Enter minimum days count..','boat-charter-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" maxlength="4" value="<?php echo esc_attr($value['day_count_max']); ?>" name="<?php BCBSHelper::getFormName('boat_charter_date[day_count_max][]'); ?>" title="<?php esc_attr_e('Enter maximum days count.','boat-charter-booking-system'); ?>"/>
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
?>
								</table>
								<div> 
									<a href="#" class="to-table-button-add"><?php esc_html_e('Add','boat-charter-booking-system'); ?></a>
								</div>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Bookings interval','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Set interval (in minutes) between bookings.','boat-charter-booking-system'); ?></span>
							<div>
								<input type="text" maxlength="4" name="<?php BCBSHelper::getFormName('booking_interval'); ?>" value="<?php echo esc_attr($this->data['meta']['booking_interval']); ?>"/>
							</div>   
						</li>  
						<li>
							<h5><?php esc_html_e('Countries availability','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Select available countries to select by customer in the booking form.','boat-charter-booking-system'); ?><br/>
							</span>
							<div class="to-clear-fix">
								<select name="<?php BCBSHelper::getFormName('country_available'); ?>[]" id="<?php BCBSHelper::getFormName('country_available'); ?>" class="to-dropkick-disable" multiple="multiple">
<?php
		echo '<option value="-1" '.(BCBSHelper::selectedIf($this->data['meta']['country_available'],-1,false)).'>'.esc_html__('- All countries -','boat-charter-booking-system').'</option>';
		foreach($this->data['dictionary']['country'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['meta']['country_available'],$index,false)).'>'.esc_html($value[0]).'</option>';
?>
								</select>												  
							</div>
						</li>	
						<li>
							<h5><?php esc_html_e('Default country','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Select default country.','boat-charter-booking-system'); ?><br/>
								<?php esc_html_e('This country will be default selected in step #3 of booking form in section "Billing details".','boat-charter-booking-system'); ?>
							</span>
							<div class="to-clear-fix">
								<select name="<?php BCBSHelper::getFormName('country_default'); ?>" id="<?php BCBSHelper::getFormName('country_default'); ?>">
<?php
		echo '<option value="-1" '.(BCBSHelper::selectedIf($this->data['meta']['country_default'],-1,false)).'>'.esc_html__('- Based on customer geolocation -','boat-charter-booking-system').'</option>';
		foreach($this->data['dictionary']['country'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['meta']['country_default'],$index,false)).'>'.esc_html($value[0]).'</option>';
?>
								</select>												  
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Default boat','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php echo esc_html__('Choose a boat which will be selected by default in booking form for this location.','boat-charter-booking-system'); ?><br/>
							</span>
							<div>
								<select name="<?php BCBSHelper::getFormName('boat_id_default'); ?>" id="<?php BCBSHelper::getFormName('boat_id_default'); ?>">
									<option value="-1"><?php esc_html_e('- None - ','boat-charter-booking-system'); ?></option>';
<?php
		foreach($this->data['dictionary']['boat'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['meta']['boat_id_default'],$index,false)).'>'.esc_html($value['post']->post_title).'</option>';
?>
								</select>								
							</div>  
						</li>	  
						<li>
							<h5><?php esc_html_e('Boat availability checking','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Select in which way (if at all) plugin has to check if the boat is available to book.','boat-charter-booking-system'); ?><br/>
								<?php esc_html_e('"Boat" means, that plugin will check whether boat was not marked as unavailable by administrator.','boat-charter-booking-system'); ?><br/>
								<?php esc_html_e('"Bookings" means, that plugin will check whether boat was not booked in the same period already.','boat-charter-booking-system'); ?>
							</span>
							<div>
								<div class="to-checkbox-button">
									<input type="checkbox" value="2" id="<?php BCBSHelper::getFormName('boat_availability_check_type_2'); ?>" name="<?php BCBSHelper::getFormName('boat_availability_check_type[]'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['boat_availability_check_type'],2); ?>/>
									<label for="<?php BCBSHelper::getFormName('boat_availability_check_type_2'); ?>"><?php esc_html_e('Boat','boat-charter-booking-system'); ?></label>
									<input type="checkbox" value="3" id="<?php BCBSHelper::getFormName('boat_availability_check_type_3'); ?>" name="<?php BCBSHelper::getFormName('boat_availability_check_type[]'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['boat_availability_check_type'],3); ?>/>
									<label for="<?php BCBSHelper::getFormName('boat_availability_check_type_3'); ?>"><?php esc_html_e('Bookings','boat-charter-booking-system'); ?></label>
									<input type="checkbox" value="1" id="<?php BCBSHelper::getFormName('boat_availability_check_type_1'); ?>" name="<?php BCBSHelper::getFormName('boat_availability_check_type[]'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['boat_availability_check_type'],1); ?>/>
									<label for="<?php BCBSHelper::getFormName('boat_availability_check_type_1'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
								</div>
							</div>
						</li>	
						<li>
							<h5><?php esc_html_e('Displaying unavailable boats','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Display boat in the step #2 of booking form even if it is not available.','boat-charter-booking-system'); ?><br/>
								<?php esc_html_e('Such boat will not be available to book.','boat-charter-booking-system'); ?>
							</span>
							<div>
								<div class="to-radio-button">
									<input type="radio" value="1" id="<?php BCBSHelper::getFormName('boat_unavailable_display_enable_1'); ?>" name="<?php BCBSHelper::getFormName('boat_unavailable_display_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['boat_unavailable_display_enable'],1); ?>/>
									<label for="<?php BCBSHelper::getFormName('boat_unavailable_display_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
									<input type="radio" value="0" id="<?php BCBSHelper::getFormName('boat_unavailable_display_enable_2'); ?>" name="<?php BCBSHelper::getFormName('boat_unavailable_display_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['boat_unavailable_display_enable'],0); ?>/>
									<label for="<?php BCBSHelper::getFormName('boat_unavailable_display_enable_2'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
								</div>
							</div>
						</li>							
						<li>
							<h5><?php esc_html_e('Boats unavailable','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Set all boats as unavailable, if at least one boat is booked in selected period.','boat-charter-booking-system'); ?><br/>
								<?php esc_html_e('This options works only if "Boat availability checking" is set to "Boat".','boat-charter-booking-system'); ?>
							</span>
							<div>
								<div class="to-radio-button">
									<input type="radio" value="1" id="<?php BCBSHelper::getFormName('boat_all_unavailable_enable_1'); ?>" name="<?php BCBSHelper::getFormName('boat_all_unavailable_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['boat_all_unavailable_enable'],1); ?>/>
									<label for="<?php BCBSHelper::getFormName('boat_all_unavailable_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
									<input type="radio" value="0" id="<?php BCBSHelper::getFormName('boat_all_unavailable_enable_2'); ?>" name="<?php BCBSHelper::getFormName('boat_all_unavailable_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['boat_all_unavailable_enable'],0); ?>/>
									<label for="<?php BCBSHelper::getFormName('boat_all_unavailable_enable_2'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
								</div>
							</div>
						</li>							
						<li>
							<h5><?php esc_html_e('Departure boat after business hours','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Allow to departure boat after business hours of the marina.','boat-charter-booking-system'); ?></span>
							<div class="to-radio-button">
								<input type="radio" value="1" id="<?php BCBSHelper::getFormName('after_business_hour_departure_enable_1'); ?>" name="<?php BCBSHelper::getFormName('after_business_hour_departure_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['after_business_hour_departure_enable'],1); ?>/>
								<label for="<?php BCBSHelper::getFormName('after_business_hour_departure_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
								<input type="radio" value="0" id="<?php BCBSHelper::getFormName('after_business_hour_departure_enable_0'); ?>" name="<?php BCBSHelper::getFormName('after_business_hour_departure_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['after_business_hour_departure_enable'],0); ?>/>
								<label for="<?php BCBSHelper::getFormName('after_business_hour_departure_enable_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
							</div>
						</li> 
						<li>
							<h5><?php esc_html_e('Return boat after business hours','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Allow to return boat after business hours of the marina.','boat-charter-booking-system'); ?></span>
							<div class="to-radio-button">
								<input type="radio" value="1" id="<?php BCBSHelper::getFormName('after_business_hour_return_enable_1'); ?>" name="<?php BCBSHelper::getFormName('after_business_hour_return_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['after_business_hour_return_enable'],1); ?>/>
								<label for="<?php BCBSHelper::getFormName('after_business_hour_return_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
								<input type="radio" value="0" id="<?php BCBSHelper::getFormName('after_business_hour_return_enable_0'); ?>" name="<?php BCBSHelper::getFormName('after_business_hour_return_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['after_business_hour_return_enable'],0); ?>/>
								<label for="<?php BCBSHelper::getFormName('after_business_hour_return_enable_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
							</div>
						</li> 
						<li>
							<h5><?php esc_html_e('Use the same date for return as for departure','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Enable or disable option to force customer to provide the same date for return as for departure.','boat-charter-booking-system'); ?><br/>
							</span>
							<div>
								<div class="to-radio-button">
									<input type="radio" value="1" id="<?php BCBSHelper::getFormName('date_departure_return_the_same_enable_1'); ?>" name="<?php BCBSHelper::getFormName('date_departure_return_the_same_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['date_departure_return_the_same_enable'],1); ?>/>
									<label for="<?php BCBSHelper::getFormName('date_departure_return_the_same_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
									<input type="radio" value="0" id="<?php BCBSHelper::getFormName('date_departure_return_the_same_enable_2'); ?>" name="<?php BCBSHelper::getFormName('date_departure_return_the_same_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['date_departure_return_the_same_enable'],0); ?>/>
									<label for="<?php BCBSHelper::getFormName('date_departure_return_the_same_enable_2'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
								</div>
							</div>
						</li>	
					</ul>
				</div>
				<div id="meta-box-marina-2">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Location','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Start typing to find location.','boat-charter-booking-system'); ?></span>
							<div>
								<input type="text" name="<?php BCBSHelper::getFormName('location_search'); ?>" id="<?php BCBSHelper::getFormName('location_search'); ?>" value=""/>
							</div>
						</li>   						
						<li>
							<h5><?php esc_html_e('Address','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Specify address of the location.','boat-charter-booking-system'); ?></span>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Street:','boat-charter-booking-system'); ?></span>
								<input type="text" name="<?php BCBSHelper::getFormName('address_street'); ?>" id="<?php BCBSHelper::getFormName('address_street'); ?>" value="<?php echo esc_attr($this->data['meta']['address_street']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Street number:','boat-charter-booking-system'); ?></span>
								<input type="text" name="<?php BCBSHelper::getFormName('address_street_number'); ?>" id="<?php BCBSHelper::getFormName('address_street_number'); ?>" value="<?php echo esc_attr($this->data['meta']['address_street_number']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Postcode:','boat-charter-booking-system'); ?></span>
								<input type="text" name="<?php BCBSHelper::getFormName('address_postcode'); ?>" id="<?php BCBSHelper::getFormName('address_postcode'); ?>" value="<?php echo esc_attr($this->data['meta']['address_postcode']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('City:','boat-charter-booking-system'); ?></span>
								<input type="text" name="<?php BCBSHelper::getFormName('address_city'); ?>" id="<?php BCBSHelper::getFormName('address_city'); ?>" value="<?php echo esc_attr($this->data['meta']['address_city']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('State:','boat-charter-booking-system'); ?></span>
								<input type="text" name="<?php BCBSHelper::getFormName('address_state'); ?>" id="<?php BCBSHelper::getFormName('address_state'); ?>" value="<?php echo esc_attr($this->data['meta']['address_state']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Country:','boat-charter-booking-system'); ?></span>
								<select name="<?php BCBSHelper::getFormName('address_country'); ?>" id="<?php BCBSHelper::getFormName('address_country'); ?>">
<?php
		foreach($this->data['dictionary']['country'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['meta']['address_country'],$index,false)).'>'.esc_html($value[0]).'</option>';
?>
								</select>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Contact details','boat-charter-booking-system'); ?></h5> 
							<span class="to-legend"><?php esc_html_e('Specify contact details of the location.','boat-charter-booking-system'); ?></span>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Phone number:','boat-charter-booking-system'); ?></span>
								<input type="text" name="<?php BCBSHelper::getFormName('contact_detail_phone_number'); ?>" id="<?php BCBSHelper::getFormName('contact_detail_phone_number'); ?>" value="<?php echo esc_attr($this->data['meta']['contact_detail_phone_number']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Fax number:','boat-charter-booking-system'); ?></span>
								<input type="text" name="<?php BCBSHelper::getFormName('contact_detail_fax_number'); ?>" id="<?php BCBSHelper::getFormName('contact_detail_fax_number'); ?>" value="<?php echo esc_attr($this->data['meta']['contact_detail_fax_number']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('E-mail address:','boat-charter-booking-system'); ?></span>
								<input type="text" name="<?php BCBSHelper::getFormName('contact_detail_email_address'); ?>" id="<?php BCBSHelper::getFormName('contact_detail_email_address'); ?>" value="<?php echo esc_attr($this->data['meta']['contact_detail_email_address']); ?>"/>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Coordinates','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Specify coordinates details (latitude, longitude) of the location.','boat-charter-booking-system'); ?></span>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Latitude:','boat-charter-booking-system'); ?></span>
								<input type="text" name="<?php BCBSHelper::getFormName('coordinate_latitude'); ?>" id="<?php BCBSHelper::getFormName('coordinate_latitude'); ?>" value="<?php echo esc_attr($this->data['meta']['coordinate_latitude']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Longitude:','boat-charter-booking-system'); ?></span>
								<input type="text" name="<?php BCBSHelper::getFormName('coordinate_longitude'); ?>" id="<?php BCBSHelper::getFormName('coordinate_longitude'); ?>" value="<?php echo esc_attr($this->data['meta']['coordinate_longitude']); ?>"/>
							</div>
						</li>						
					</ul>
				</div>
				<div id="meta-box-marina-3">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Business hours','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Specify working days/hours (in HH:MM time format).','boat-charter-booking-system'); ?><br/>
								<?php esc_html_e('Leave all fields empty if booking is not available for selected day.','boat-charter-booking-system'); ?>
							</span> 
							<div class="to-clear-fix">
								<table class="to-table">
									<tr>
										<th style="width:16%">
											<div>
												<?php esc_html_e('Weekday','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Day of the week','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:18%">
											<div>
												<?php esc_html_e('Start time','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Start time in HH:MM time format','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:18%">
											<div>
												<?php esc_html_e('End time','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('End time in HH:MM time format','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:18%">
											<div>
												<?php esc_html_e('Default time','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Default time in HH:MM time format','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:30%">
											<div>
												<?php esc_html_e('Breaks','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('List of breaks in format HH:MM-HH:MM separated by semicolon. E.g: 09:00-11:00;13:15-14:15.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
									</tr>
<?php
		for($i=1;$i<8;$i++)
		{
			$breakTime=null;

			if(is_array($this->data['meta']['business_hour'][$i]['break']))
			{
				foreach($this->data['meta']['business_hour'][$i]['break'] as $value)
				{
					if(!is_null($breakTime)) $breakTime.=';';
					$breakTime.=$value['start'].'-'.$value['stop'];
				}
			}
?>
									<tr>
										<td>
											<div><?php echo esc_html($Date->getDayName($i)); ?></div>
										</td>
										<td>
											<div>
												<input type="text" class="to-timepicker" name="<?php BCBSHelper::getFormName('business_hour['.$i.'][0]'); ?>" id="<?php BCBSHelper::getFormName('business_hour['.$i.'][0]'); ?>" value="<?php echo esc_attr($this->data['meta']['business_hour'][$i]['start']); ?>" title="<?php esc_attr_e('Enter start time in format HH:MM.','boat-charter-booking-system'); ?>"/>
											</div>
										</td>
										<td>
											<div>								
												<input type="text" class="to-timepicker" name="<?php BCBSHelper::getFormName('business_hour['.$i.'][1]'); ?>" id="<?php BCBSHelper::getFormName('business_hour['.$i.'][1]'); ?>" value="<?php echo esc_attr($this->data['meta']['business_hour'][$i]['stop']); ?>" title="<?php esc_attr_e('Enter end time in format HH:MM.','boat-charter-booking-system'); ?>"/>
											</div>
										</td>
										<td>
											<div>								
												<input type="text" class="to-timepicker" name="<?php BCBSHelper::getFormName('business_hour['.$i.'][2]'); ?>" id="<?php BCBSHelper::getFormName('business_hour['.$i.'][2]'); ?>" value="<?php echo esc_attr($this->data['meta']['business_hour'][$i]['default']); ?>" title="<?php esc_attr_e('Enter default time in format HH:MM.','boat-charter-booking-system'); ?>"/>
											</div>
										</td>
										<td>
											<div>								
												<input type="text" name="<?php BCBSHelper::getFormName('business_hour['.$i.'][3]'); ?>" id="<?php BCBSHelper::getFormName('business_hour['.$i.'][3]'); ?>" value="<?php echo esc_attr($breakTime); ?>" title="<?php esc_attr_e('Enter period of break in format HH:MM-HH:MM.','boat-charter-booking-system'); ?>"/>
											</div>
										</td>
									</tr>
<?php
		}
?>
								</table>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Exclude dates','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Specify dates not available for booking. Past (or invalid date ranges) will be removed during saving.','boat-charter-booking-system'); ?></span>
							<div>	
								<table class="to-table" id="to-table-exclude-date">
									<tr>
										<th style="width:40%">
											<div>
												<?php esc_html_e('Start date','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Start date in DD-MM-YYYY format','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:40%">
											<div>
												<?php esc_html_e('End date','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('End date in DD-MM-YYYY format','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:20%">
											<div>
												<?php esc_html_e('Remove','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Remove this entry','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
									</tr>
									<tr class="to-hidden">
										<td>
											<div>
												<input type="text" maxlength="10" class="to-datepicker" name="<?php BCBSHelper::getFormName('date_exclude_start[]'); ?>" title="<?php esc_attr_e('Enter start date in format DD-MM-YYYY.','boat-charter-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" maxlength="10" class="to-datepicker" name="<?php BCBSHelper::getFormName('date_exclude_stop[]'); ?>" title="<?php esc_attr_e('Enter start date in format DD-MM-YYYY.','boat-charter-booking-system'); ?>"/>
											</div>									
										</td>	
										<td>
											<div>
												<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','boat-charter-booking-system'); ?></a>
											</div>
										</td>
									</tr>
<?php
		if(count($this->data['meta']['date_exclude']))
		{
			foreach($this->data['meta']['date_exclude'] as $dateExcludeIndex=>$dateExcludeValue)
			{
?>
									<tr>
										<td>
											<div>
												<input type="text" maxlength="10" class="to-datepicker" value="<?php echo esc_attr($dateExcludeValue['start']); ?>" name="<?php BCBSHelper::getFormName('date_exclude_start[]'); ?>" title="<?php esc_attr_e('Enter start date in format DD-MM-YYYY.','boat-charter-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" maxlength="10" class="to-datepicker" value="<?php echo esc_attr($dateExcludeValue['stop']); ?>" name="<?php BCBSHelper::getFormName('date_exclude_stop[]'); ?>" title="<?php esc_attr_e('Enter start date in format DD-MM-YYYY.','boat-charter-booking-system'); ?>"/>
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
?>
								</table>
								<div> 
									<a href="#" class="to-table-button-add"><?php esc_html_e('Add','boat-charter-booking-system'); ?></a>
								</div>
							</div>
						</li>
					</ul>
				</div>
				<div id="meta-box-marina-4">
					<div class="ui-tabs">
						<ul>
							<li><a href="#meta-box-marina-4-1"><?php esc_html_e('General','boat-charter-booking-system'); ?></a></li>
							<li><a href="#meta-box-marina-4-2"><?php esc_html_e('Deposit','boat-charter-booking-system'); ?></a></li>
							<li><a href="#meta-box-marina-4-3"><?php esc_html_e('Payments','boat-charter-booking-system'); ?></a></li>
						</ul>
						<div id="meta-box-marina-4-1">
							<ul class="to-form-field-list">
								<li>
									<h5><?php esc_html_e('Payments','boat-charter-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Select one or more payment methods available in this booking form.','boat-charter-booking-system'); ?><br/>
										<?php esc_html_e('For some of them you have to enter additional settings.','boat-charter-booking-system'); ?>
									</span>
									<div class="to-checkbox-button">
<?php
		foreach($this->data['dictionary']['payment'] as $index=>$value)
		{
?>
										<input type="checkbox" value="<?php echo esc_attr($index); ?>" id="<?php BCBSHelper::getFormName('payment_id_'.$index); ?>" name="<?php BCBSHelper::getFormName('payment_id[]'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['payment_id'],$index); ?>/>
										<label for="<?php BCBSHelper::getFormName('payment_id_'.$index); ?>"><?php echo esc_html($value[0]); ?></label>							
<?php		
		}
?>
									</div>	
								</li>
								<li>
									<h5><?php esc_html_e('Default payment','boat-charter-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Select default payment method.','boat-charter-booking-system'); ?>
									</span>
									<div class="to-radio-button">
										<input type="radio" value="-1" id="<?php BCBSHelper::getFormName('payment_default_id_0'); ?>" name="<?php BCBSHelper::getFormName('payment_default_id'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['payment_default_id'],$index); ?>/>
										<label for="<?php BCBSHelper::getFormName('payment_default_id_0'); ?>"><?php echo esc_html_e('- None - ','boat-charter-booking-system'); ?></label>	
<?php
		foreach($this->data['dictionary']['payment'] as $index=>$value)
		{
?>
										<input type="checkbox" value="<?php echo esc_attr($index); ?>" id="<?php BCBSHelper::getFormName('payment_default_id_'.$index); ?>" name="<?php BCBSHelper::getFormName('payment_default_id'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['payment_default_id'],$index); ?>/>
										<label for="<?php BCBSHelper::getFormName('payment_default_id_'.$index); ?>"><?php echo esc_html($value[0]); ?></label>							
<?php		
		}
?>
									</div>	
								</li>
								<li>
									<h5><?php esc_html_e('Payment selection','boat-charter-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Set payment method as mandatory to select by the customer.','boat-charter-booking-system'); ?></span>
									<div class="to-radio-button">
										<input type="radio" value="1" id="<?php BCBSHelper::getFormName('payment_mandatory_enable_1'); ?>" name="<?php BCBSHelper::getFormName('payment_mandatory_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['payment_mandatory_enable'],1); ?>/>
										<label for="<?php BCBSHelper::getFormName('payment_mandatory_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
										<input type="radio" value="0" id="<?php BCBSHelper::getFormName('payment_mandatory_enable_0'); ?>" name="<?php BCBSHelper::getFormName('payment_mandatory_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['payment_mandatory_enable'],0); ?>/>
										<label for="<?php BCBSHelper::getFormName('payment_mandatory_enable_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
									</div>
								</li>
								<li>
									<h5><?php esc_html_e('Payment processing','boat-charter-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Enable or disable possibility of paying by booking form.','boat-charter-booking-system'); ?><br/>
										<?php esc_html_e('Disabling this option means that customer can choose payment method, but he won\'t be able to pay.','boat-charter-booking-system'); ?>
									</span>
									<div class="to-radio-button">
										<input type="radio" value="1" id="<?php BCBSHelper::getFormName('payment_processing_enable_1'); ?>" name="<?php BCBSHelper::getFormName('payment_processing_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['payment_processing_enable'],1); ?>/>
										<label for="<?php BCBSHelper::getFormName('payment_processing_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
										<input type="radio" value="0" id="<?php BCBSHelper::getFormName('payment_processing_enable_0'); ?>" name="<?php BCBSHelper::getFormName('payment_processing_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['payment_processing_enable'],0); ?>/>
										<label for="<?php BCBSHelper::getFormName('payment_processing_enable_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
									</div>
								</li> 
								<li>
									<h5><?php esc_html_e('WooCommerce payments on step #3','boat-charter-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Enable or disable possibility to choose wooCommerce payment method in step #3.','boat-charter-booking-system'); ?><br/>
										<?php esc_html_e('This option is available if wooCommerce support is enabled.','boat-charter-booking-system'); ?>
									</span>
									<div class="to-radio-button">
										<input type="radio" value="1" id="<?php BCBSHelper::getFormName('payment_woocommerce_step_3_enable_1'); ?>" name="<?php BCBSHelper::getFormName('payment_woocommerce_step_3_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['payment_woocommerce_step_3_enable'],1); ?>/>
										<label for="<?php BCBSHelper::getFormName('payment_woocommerce_step_3_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
										<input type="radio" value="0" id="<?php BCBSHelper::getFormName('payment_woocommerce_step_3_enable_0'); ?>" name="<?php BCBSHelper::getFormName('payment_woocommerce_step_3_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['payment_woocommerce_step_3_enable'],0); ?>/>
										<label for="<?php BCBSHelper::getFormName('payment_woocommerce_step_3_enable_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
									</div>
								</li>
							</ul>
						</div>
						<div id="meta-box-marina-4-2">
							<ul class="to-form-field-list">
								<li>
									<h5><?php esc_html_e('Type','boat-charter-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Select type of deposit or disable it completely.','boat-charter-booking-system'); ?></span>
									<div class="to-radio-button">
										<input type="radio" value="0" id="<?php BCBSHelper::getFormName('payment_deposit_type_0'); ?>" name="<?php BCBSHelper::getFormName('payment_deposit_type'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['payment_deposit_type'],0); ?>/>
										<label for="<?php BCBSHelper::getFormName('payment_deposit_type_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
										<input type="radio" value="1" id="<?php BCBSHelper::getFormName('payment_deposit_type_1'); ?>" name="<?php BCBSHelper::getFormName('payment_deposit_type'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['payment_deposit_type'],1); ?>/>
										<label for="<?php BCBSHelper::getFormName('payment_deposit_type_1'); ?>"><?php esc_html_e('Fixed','boat-charter-booking-system'); ?></label>
										<input type="radio" value="2" id="<?php BCBSHelper::getFormName('payment_deposit_type_2'); ?>" name="<?php BCBSHelper::getFormName('payment_deposit_type'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['payment_deposit_type'],2); ?>/>
										<label for="<?php BCBSHelper::getFormName('payment_deposit_type_2'); ?>"><?php esc_html_e('Percentage','boat-charter-booking-system'); ?></label>
									</div>									
								</li>
								<li>
									<h5><?php esc_html_e('Fixed value','boat-charter-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Fixed value.','boat-charter-booking-system'); ?></span>
									<div class="to-clear-fix">
										<input maxlength="12" type="text" name="<?php BCBSHelper::getFormName('payment_deposit_type_fixed_value'); ?>" id="<?php BCBSHelper::getFormName('payment_deposit_type_fixed_value'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_deposit_type_fixed_value']); ?>"/>
									</div>	
								</li>
								<li>
									<h5><?php esc_html_e('Percentage value','boat-charter-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Percentage value.','boat-charter-booking-system'); ?></span>
									<div class="to-clear-fix">
										<input maxlength="6" type="text" name="<?php BCBSHelper::getFormName('payment_deposit_type_percentage_value'); ?>" id="<?php BCBSHelper::getFormName('payment_deposit_type_percentage_value'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_deposit_type_percentage_value']); ?>"/>
									</div>
								</li>
								<li>
									<h5><?php esc_html_e('Applied before defined number of days','boat-charter-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Deposit will be applied only if the booking will be sent before defined number of days before departure date.','boat-charter-booking-system'); ?></span>
									<div class="to-clear-fix">
										<input maxlength="4" type="text" name="<?php BCBSHelper::getFormName('payment_deposit_day_number_before_departure_date'); ?>" id="<?php BCBSHelper::getFormName('payment_deposit_day_number_before_departure_date'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_deposit_day_number_before_departure_date']); ?>"/>
									</div>	
								</li>
							</ul>
						</div>
						<div id="meta-box-marina-4-3">
							<div class="ui-tabs">
								<ul>
									<li><a href="#meta-box-location-4-2-1"><?php esc_html_e('Stripe','boat-charter-booking-system'); ?></a></li>
									<li><a href="#meta-box-location-4-2-2"><?php esc_html_e('PayPal','boat-charter-booking-system'); ?></a></li>
									<li><a href="#meta-box-location-4-2-3"><?php esc_html_e('Cash','boat-charter-booking-system'); ?></a></li>
									<li><a href="#meta-box-location-4-2-4"><?php esc_html_e('Wire transfer','boat-charter-booking-system'); ?></a></li>
								</ul>
								<div id="meta-box-location-4-2-1">
									<ul class="to-form-field-list">
										<li>
											<h5><?php esc_html_e('Secret API key','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php echo sprintf(__('You can find more info about keys <a href="%s" target="_blank">here</a>.','boat-charter-booking-system'),'https://stripe.com/docs/keys'); ?></span>
											<div class="to-clear-fix">
												<input type="text" name="<?php BCBSHelper::getFormName('payment_stripe_api_key_secret'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_stripe_api_key_secret']); ?>"/>
											</div>											
										</li>
										<li>
											<h5><?php esc_html_e('Publishable API key','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php echo sprintf(__('You can find more info about keys <a href="%s" target="_blank">here</a>.','boat-charter-booking-system'),'https://stripe.com/docs/keys'); ?></span>									
											<div class="to-clear-fix">
												<input type="text" name="<?php BCBSHelper::getFormName('payment_stripe_api_key_publishable'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_stripe_api_key_publishable']); ?>"/>
											</div>											
										</li>
										<li>
											<h5><?php esc_html_e('Payment methods','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('You can set up each of them in your "Stripe" dashboard under "Settings / Payment methods".','boat-charter-booking-system'); ?></span>											
											<div class="to-clear-fix">
												<div class="to-checkbox-button">
<?php
		foreach($this->data['dictionary']['payment_stripe_method'] as $index=>$value)
		{
?>
													<input type="checkbox" value="<?php echo esc_attr($index); ?>" id="<?php BCBSHelper::getFormName('payment_stripe_method_'.$index); ?>" name="<?php BCBSHelper::getFormName('payment_stripe_method[]'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['payment_stripe_method'],$index); ?>/>
													<label for="<?php BCBSHelper::getFormName('payment_stripe_method_'.$index); ?>"><?php echo esc_html($value[0]); ?></label>							
<?php		
		}
?>
												</div>	
											</div>											
										</li>
										<li>
											<h5><?php esc_html_e('Product ID','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Product ID.','boat-charter-booking-system'); ?></span>											
											<div class="to-clear-fix">
												<input type="text" name="<?php BCBSHelper::getFormName('payment_stripe_product_id'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_stripe_product_id']); ?>"/>
											</div>											
										</li>
										<li>
											<h5><?php esc_html_e('Redirection delay','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Duration of redirection delay (in seconds) to the Stripe gateway.','boat-charter-booking-system'); ?></span>											
											<div class="to-clear-fix">
												<input type="text" maxlength="2" name="<?php BCBSHelper::getFormName('payment_stripe_redirect_duration'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_stripe_redirect_duration']); ?>"/>
											</div>												
										</li>
										<li>
											<h5><?php esc_html_e('"Success" URL address','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('"Success" URL address.','boat-charter-booking-system'); ?></span>											
											<div class="to-clear-fix">
												<input type="text" name="<?php BCBSHelper::getFormName('payment_stripe_success_url_address'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_stripe_success_url_address']); ?>"/>
											</div>											
										</li>									
										<li>
											<h5><?php esc_html_e('"Cancel" URL address:','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('"Cancel" URL address.','boat-charter-booking-system'); ?></span>											
											<div class="to-clear-fix">
												<input type="text" name="<?php BCBSHelper::getFormName('payment_stripe_cancel_url_address'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_stripe_cancel_url_address']); ?>"/>
											</div>												
										</li>
										<li>
											<h5><?php esc_html_e('Logo','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Logo:','boat-charter-booking-system'); ?></span>											
											<div class="to-clear-fix">
												<input type="text" name="<?php BCBSHelper::getFormName('payment_stripe_logo_src'); ?>" id="<?php BCBSHelper::getFormName('payment_stripe_logo_src'); ?>" class="to-float-left" value="<?php echo esc_attr($this->data['meta']['payment_stripe_logo_src']); ?>"/>
												<input type="button" name="<?php BCBSHelper::getFormName('payment_stripe_logo_src_browse'); ?>" id="<?php BCBSHelper::getFormName('payment_stripe_logo_src_browse'); ?>" class="to-button-browse to-button" value="<?php esc_attr_e('Browse','boat-charter-booking-system'); ?>"/>
											</div>											
										</li>
										<li>
											<h5><?php esc_html_e('Information for customer','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Additional information for the customer:','boat-charter-booking-system'); ?></span>											
											<div class="to-clear-fix">
												<textarea rows="1" cols="1" name="<?php BCBSHelper::getFormName('payment_stripe_info'); ?>"><?php echo esc_html($this->data['meta']['payment_stripe_info']); ?></textarea>
											</div>												
										</li>
									</ul>
								</div>
								<div id="meta-box-location-4-2-2">
									<ul class="to-form-field-list">
										<li>
											<h5><?php esc_html_e('E-mail address','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('E-mail address.','boat-charter-booking-system'); ?></span>	
											<div class="to-clear-fix">
												<input type="text" name="<?php BCBSHelper::getFormName('payment_paypal_email_address'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_paypal_email_address']); ?>"/>
											</div>											
										</li>									
										<li>
											<h5><?php esc_html_e('Sandbox mode','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Sandbox mode.','boat-charter-booking-system'); ?></span>	
											<div class="to-radio-button">
												<input type="radio" value="1" id="<?php BCBSHelper::getFormName('payment_paypal_sandbox_mode_enable_1'); ?>" name="<?php BCBSHelper::getFormName('payment_paypal_sandbox_mode_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['payment_paypal_sandbox_mode_enable'],1); ?>/>
												<label for="<?php BCBSHelper::getFormName('payment_paypal_sandbox_mode_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
												<input type="radio" value="0" id="<?php BCBSHelper::getFormName('payment_paypal_sandbox_mode_enable_0'); ?>" name="<?php BCBSHelper::getFormName('payment_paypal_sandbox_mode_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['payment_paypal_sandbox_mode_enable'],0); ?>/>
												<label for="<?php BCBSHelper::getFormName('payment_paypal_sandbox_mode_enable_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
											</div>
										</li>	
										<li>
											<h5><?php esc_html_e('Redirection delay','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Duration of redirection delay (in seconds) to the PayPal gateway.','boat-charter-booking-system'); ?></span>												
											<div class="to-clear-fix">
												<input type="text" maxlength="2" name="<?php BCBSHelper::getFormName('payment_paypal_redirect_duration'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_paypal_redirect_duration']); ?>"/>
											</div>				
										</li>	
										<li>
											<h5><?php esc_html_e('"Success" URL address','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('"Success" URL address.','boat-charter-booking-system'); ?></span>												
											<div class="to-clear-fix">
												<input type="text" name="<?php BCBSHelper::getFormName('payment_paypal_success_url_address'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_paypal_success_url_address']); ?>"/>
											</div>
										</li>									
										<li>
											<h5><?php esc_html_e('"Cancel" URL address','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('"Cancel" URL address.','boat-charter-booking-system'); ?></span>												
											<div class="to-clear-fix">
												<input type="text" name="<?php BCBSHelper::getFormName('payment_paypal_cancel_url_address'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_paypal_cancel_url_address']); ?>"/>
											</div>		
										</li>	
										<li>
											<h5><?php esc_html_e('Logo','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Logo.','boat-charter-booking-system'); ?></span>												
											<div class="to-clear-fix">
												<input type="text" name="<?php BCBSHelper::getFormName('payment_paypal_logo_src'); ?>" id="<?php BCBSHelper::getFormName('payment_paypal_logo_src'); ?>" class="to-float-left" value="<?php echo esc_attr($this->data['meta']['payment_paypal_logo_src']); ?>"/>
												<input type="button" name="<?php BCBSHelper::getFormName('payment_paypal_logo_src_browse'); ?>" id="<?php BCBSHelper::getFormName('payment_paypal_logo_src_browse'); ?>" class="to-button-browse to-button" value="<?php esc_attr_e('Browse','boat-charter-booking-system'); ?>"/>
											</div>
										</li>	
										<li>
											<h5><?php esc_html_e('Information for customer','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Additional information for customer.','boat-charter-booking-system'); ?></span>												
											<div class="to-clear-fix">
												<textarea rows="1" cols="1" name="<?php BCBSHelper::getFormName('payment_paypal_info'); ?>"><?php echo esc_html($this->data['meta']['payment_paypal_info']); ?></textarea>
											</div>											
										</li>	
									</ul>
								</div>
								<div id="meta-box-location-4-2-3">
									<ul class="to-form-field-list">
										<li>
											<h5><?php esc_html_e('Logo','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Logo.','boat-charter-booking-system'); ?></span>
											<div class="to-clear-fix">
												<input type="text" name="<?php BCBSHelper::getFormName('payment_cash_logo_src'); ?>" id="<?php BCBSHelper::getFormName('payment_cash_logo_src'); ?>" class="to-float-left" value="<?php echo esc_attr($this->data['meta']['payment_cash_logo_src']); ?>"/>
												<input type="button" name="<?php BCBSHelper::getFormName('payment_cash_logo_src_browse'); ?>" id="<?php BCBSHelper::getFormName('payment_cash_logo_src_browse'); ?>" class="to-button-browse to-button" value="<?php esc_attr_e('Browse','boat-charter-booking-system'); ?>"/>
											</div>											
										</li>									
										<li>
											<h5><?php esc_html_e('Information for customer','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Additional information for customer.','boat-charter-booking-system'); ?></span>
											<div class="to-clear-fix">
												<textarea rows="1" cols="1" name="<?php BCBSHelper::getFormName('payment_cash_info'); ?>"><?php echo esc_html($this->data['meta']['payment_cash_info']); ?></textarea>
											</div>											
										</li>										
									</ul>
								</div>
								<div id="meta-box-location-4-2-4">
									<ul class="to-form-field-list">
										<li>
											<h5><?php esc_html_e('Logo','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Logo.','boat-charter-booking-system'); ?></span>
											<div class="to-clear-fix">
												<input type="text" name="<?php BCBSHelper::getFormName('payment_wire_transfer_logo_src'); ?>" id="<?php BCBSHelper::getFormName('payment_wire_transfer_logo_src'); ?>" class="to-float-left" value="<?php echo esc_attr($this->data['meta']['payment_wire_transfer_logo_src']); ?>"/>
												<input type="button" name="<?php BCBSHelper::getFormName('payment_wire_transfer_logo_src_browse'); ?>" id="<?php BCBSHelper::getFormName('payment_wire_transfer_logo_src_browse'); ?>" class="to-button-browse to-button" value="<?php esc_attr_e('Browse','boat-charter-booking-system'); ?>"/>
											</div>										
										</li>
										<li>
											<h5><?php esc_html_e('Information for customer','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Additional information for customer.','boat-charter-booking-system'); ?></span>
											<div class="to-clear-fix">
												<textarea rows="1" cols="1" name="<?php BCBSHelper::getFormName('payment_wire_transfer_info'); ?>"><?php echo esc_html($this->data['meta']['payment_wire_transfer_info']); ?></textarea>
											</div>											
										</li>
									</ul>
								</div>	
							</div>						
						</div>						
					</div>		
				</div>
				<div id="meta-box-marina-5">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('E-mail messages','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Select the sender\'s email account from which the messages will be sent (to clients and to defined recipients) with info about new bookings.','boat-charter-booking-system'); ?>
							</span>
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('Sender e-mail account:','boat-charter-booking-system'); ?></span>
								<select name="<?php BCBSHelper::getFormName('booking_new_sender_email_account_id'); ?>" id="<?php BCBSHelper::getFormName('booking_new_sender_email_account_id'); ?>">
<?php
		echo '<option value="-1" '.(BCBSHelper::selectedIf($this->data['meta']['booking_new_sender_email_account_id'],-1,false)).'>'.esc_html__(' - Not set -','boat-charter-booking-system').'</option>';
		foreach($this->data['dictionary']['email_account'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['meta']['booking_new_sender_email_account_id'],$index,false)).'>'.esc_html($value['post']->post_title).'</option>';
?>
								</select>
							</div>
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('List of recipients e-mail addresses separated by semicolon:','boat-charter-booking-system'); ?></span>
								<input type="text" name="<?php BCBSHelper::getFormName('booking_new_recipient_email_address'); ?>" value="<?php echo esc_attr($this->data['meta']['booking_new_recipient_email_address']); ?>"/>
							</div>
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('Enable/disable sending e-mail message with notification about new booking to the customers:','boat-charter-booking-system'); ?></span>
								<div class="to-radio-button">
									<input type="radio" value="1" id="<?php BCBSHelper::getFormName('booking_new_customer_email_notification_1'); ?>" name="<?php BCBSHelper::getFormName('booking_new_customer_email_notification'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['booking_new_customer_email_notification'],1); ?>/>
									<label for="<?php BCBSHelper::getFormName('booking_new_customer_email_notification_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
									<input type="radio" value="0" id="<?php BCBSHelper::getFormName('booking_new_customer_email_notification_0'); ?>" name="<?php BCBSHelper::getFormName('booking_new_customer_email_notification'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['booking_new_customer_email_notification'],0); ?>/>
									<label for="<?php BCBSHelper::getFormName('booking_new_customer_email_notification_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
								</div>
							</div>
							<div class="to-clear-fix">
								<span class="to-legend-field">
									<?php esc_html_e('Enable/disable sending e-mail message with notification about new booking to the customers after payment.','boat-charter-booking-system'); ?></br>
									<?php esc_html_e('Please note that this option works for built-in payment methods only: PayPal and Stripe.','boat-charter-booking-system'); ?>
								</span>
								<div class="to-radio-button">
									<input type="radio" value="1" id="<?php BCBSHelper::getFormName('booking_new_customer_email_notification_after_payment_1'); ?>" name="<?php BCBSHelper::getFormName('booking_new_customer_email_notification_after_payment'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['booking_new_customer_email_notification_after_payment'],1); ?>/>
									<label for="<?php BCBSHelper::getFormName('booking_new_customer_email_notification_after_payment_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
									<input type="radio" value="0" id="<?php BCBSHelper::getFormName('booking_new_customer_email_notification_after_payment_0'); ?>" name="<?php BCBSHelper::getFormName('booking_new_customer_email_notification_after_payment'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['booking_new_customer_email_notification_after_payment'],0); ?>/>
									<label for="<?php BCBSHelper::getFormName('booking_new_customer_email_notification_after_payment_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
								</div>
							</div>
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('Enable/disable sending wooCommerce e-mail message with notification about new booking:','boat-charter-booking-system'); ?></span>
								<div class="to-radio-button">
									<input type="radio" value="1" id="<?php BCBSHelper::getFormName('booking_new_woocommerce_email_notification_1'); ?>" name="<?php BCBSHelper::getFormName('booking_new_woocommerce_email_notification'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['booking_new_woocommerce_email_notification'],1); ?>/>
									<label for="<?php BCBSHelper::getFormName('booking_new_woocommerce_email_notification_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
									<input type="radio" value="0" id="<?php BCBSHelper::getFormName('booking_new_woocommerce_email_notification_0'); ?>" name="<?php BCBSHelper::getFormName('booking_new_woocommerce_email_notification'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['booking_new_woocommerce_email_notification'],0); ?>/>
									<label for="<?php BCBSHelper::getFormName('booking_new_woocommerce_email_notification_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
								</div>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Vonage SMS notifications','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php echo sprintf(esc_html__('Enter details to be notified via SMS about new booking through %s.','boat-charter-booking-system'),'<a href="https://www.vonage.com" target="_blank">Vonage</a>'); ?>
							</span> 
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('Status:','boat-charter-booking-system'); ?></span>
								<div class="to-radio-button">
									<input type="radio" value="1" id="<?php BCBSHelper::getFormName('nexmo_sms_enable_1'); ?>" name="<?php BCBSHelper::getFormName('nexmo_sms_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['nexmo_sms_enable'],1); ?>/>
									<label for="<?php BCBSHelper::getFormName('nexmo_sms_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
									<input type="radio" value="0" id="<?php BCBSHelper::getFormName('nexmo_sms_enable_0'); ?>" name="<?php BCBSHelper::getFormName('nexmo_sms_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['nexmo_sms_enable'],0); ?>/>
									<label for="<?php BCBSHelper::getFormName('nexmo_sms_enable_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
								</div>								
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('API key:','boat-charter-booking-system'); ?></span>
								<input type="text" name="<?php BCBSHelper::getFormName('nexmo_sms_api_key'); ?>" value="<?php echo esc_attr($this->data['meta']['nexmo_sms_api_key']); ?>"/>
							</div>								
							<div>
								<span class="to-legend-field"><?php esc_html_e('Secret API key:','boat-charter-booking-system'); ?></span>
								<input type="text" name="<?php BCBSHelper::getFormName('nexmo_sms_api_key_secret'); ?>" value="<?php echo esc_attr($this->data['meta']['nexmo_sms_api_key_secret']); ?>"/>
							</div>									
							<div>
								<span class="to-legend-field"><?php esc_html_e('Sender name:','boat-charter-booking-system'); ?></span>
								<input type="text" name="<?php BCBSHelper::getFormName('nexmo_sms_sender_name'); ?>" value="<?php echo esc_attr($this->data['meta']['nexmo_sms_sender_name']); ?>"/>
							</div>							   
							<div>
								<span class="to-legend-field"><?php esc_html_e('Recipient phone number:','boat-charter-booking-system'); ?></span>
								<input type="text" name="<?php BCBSHelper::getFormName('nexmo_sms_recipient_phone_number'); ?>" value="<?php echo esc_attr($this->data['meta']['nexmo_sms_recipient_phone_number']); ?>"/>
							</div>								
							<div>
								<span class="to-legend-field"><?php esc_html_e('Message:','boat-charter-booking-system'); ?></span>
								<input type="text" name="<?php BCBSHelper::getFormName('nexmo_sms_message'); ?>" value="<?php echo esc_attr($this->data['meta']['nexmo_sms_message']); ?>"/>
							</div>							  
						</li>
						<li>
							<h5><?php esc_html_e('Twilio SMS notifications','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php echo sprintf(esc_html__('Enter details to be notified via SMS about new booking through %s.','boat-charter-booking-system'),'<a href="https://www.twilio.com" target="_blank">Twilio</a>'); ?>
							</span> 
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('Status:','boat-charter-booking-system'); ?></span>
								<div class="to-radio-button">
									<input type="radio" value="1" id="<?php BCBSHelper::getFormName('twilio_sms_enable_1'); ?>" name="<?php BCBSHelper::getFormName('twilio_sms_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['twilio_sms_enable'],1); ?>/>
									<label for="<?php BCBSHelper::getFormName('twilio_sms_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
									<input type="radio" value="0" id="<?php BCBSHelper::getFormName('twilio_sms_enable_0'); ?>" name="<?php BCBSHelper::getFormName('twilio_sms_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['twilio_sms_enable'],0); ?>/>
									<label for="<?php BCBSHelper::getFormName('twilio_sms_enable_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
								</div>								
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('API SID:','boat-charter-booking-system'); ?></span>
								<input type="text" name="<?php BCBSHelper::getFormName('twilio_sms_api_sid'); ?>" value="<?php echo esc_attr($this->data['meta']['twilio_sms_api_sid']); ?>"/>
							</div>								
							<div>
								<span class="to-legend-field"><?php esc_html_e('API token:','boat-charter-booking-system'); ?></span>
								<input type="text" name="<?php BCBSHelper::getFormName('twilio_sms_api_token'); ?>" value="<?php echo esc_attr($this->data['meta']['twilio_sms_api_token']); ?>"/>
							</div>									
							<div>
								<span class="to-legend-field"><?php esc_html_e('Sender phone number:','boat-charter-booking-system'); ?></span>
								<input type="text" name="<?php BCBSHelper::getFormName('twilio_sms_sender_phone_number'); ?>" value="<?php echo esc_attr($this->data['meta']['twilio_sms_sender_phone_number']); ?>"/>
							</div>							   
							<div>
								<span class="to-legend-field"><?php esc_html_e('Recipient phone number:','boat-charter-booking-system'); ?></span>
								<input type="text" name="<?php BCBSHelper::getFormName('twilio_sms_recipient_phone_number'); ?>" value="<?php echo esc_attr($this->data['meta']['twilio_sms_recipient_phone_number']); ?>"/>
							</div>								
							<div>
								<span class="to-legend-field"><?php esc_html_e('Message:','boat-charter-booking-system'); ?></span>
								<input type="text" name="<?php BCBSHelper::getFormName('twilio_sms_message'); ?>" value="<?php echo esc_attr($this->data['meta']['twilio_sms_message']); ?>"/>
							</div>							  
						</li>
						<li>
							<h5><?php esc_html_e('Telegram notifications','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php echo sprintf(esc_html__('Enter details to be notified about new booking through %s.','boat-charter-booking-system'),'<a href="https://telegram.org/" target="_blank">Telegram Messenger</a>'); ?>
							</span> 
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('Status:','boat-charter-booking-system'); ?></span>
								<div class="to-radio-button">
									<input type="radio" value="1" id="<?php BCBSHelper::getFormName('telegram_enable_1'); ?>" name="<?php BCBSHelper::getFormName('telegram_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['telegram_enable'],1); ?>/>
									<label for="<?php BCBSHelper::getFormName('telegram_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
									<input type="radio" value="0" id="<?php BCBSHelper::getFormName('telegram_enable_0'); ?>" name="<?php BCBSHelper::getFormName('telegram_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['telegram_enable'],0); ?>/>
									<label for="<?php BCBSHelper::getFormName('telegram_enable_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
								</div>								
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Token:','boat-charter-booking-system'); ?></span>
								<input type="text" name="<?php BCBSHelper::getFormName('telegram_token'); ?>" value="<?php echo esc_attr($this->data['meta']['telegram_token']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Group ID:','boat-charter-booking-system'); ?></span>
								<input type="text" name="<?php BCBSHelper::getFormName('telegram_group_id'); ?>" value="<?php echo esc_attr($this->data['meta']['telegram_group_id']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Message:','boat-charter-booking-system'); ?></span>
								<input type="text" name="<?php BCBSHelper::getFormName('telegram_message'); ?>" value="<?php echo esc_attr($this->data['meta']['telegram_message']); ?>"/>
							</div>
						</li>
					</ul>
				</div>	
				<div id="meta-box-marina-6">
					<ul class="to-form-field-list">
					   <li>
							<h5><?php esc_html_e('Google Calendar','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php echo esc_html__('Enable or disable integration with Google Calendar.','boat-charter-booking-system'); ?></span> 
							<div class="to-radio-button">
								<input type="radio" value="1" id="<?php BCBSHelper::getFormName('google_calendar_enable_1'); ?>" name="<?php BCBSHelper::getFormName('google_calendar_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['google_calendar_enable'],1); ?>/>
								<label for="<?php BCBSHelper::getFormName('google_calendar_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
								<input type="radio" value="0" id="<?php BCBSHelper::getFormName('google_calendar_enable_0'); ?>" name="<?php BCBSHelper::getFormName('google_calendar_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['google_calendar_enable'],0); ?>/>
								<label for="<?php BCBSHelper::getFormName('google_calendar_enable_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
							</div>							
						</li>	   
						<li>
							<h5><?php esc_html_e('ID','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php echo esc_html__('Google Calendar ID.','boat-charter-booking-system'); ?></span> 
							<div class="to-clear-fix">
								<input type="text" name="<?php BCBSHelper::getFormName('google_calendar_id'); ?>" value="<?php echo esc_attr($this->data['meta']['google_calendar_id']); ?>"/>								 
							</div>						 
						</li>
						<li>
							<h5><?php esc_html_e('Settings','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php echo esc_html__('Copy/paste the contents of downloaded *.json file.','boat-charter-booking-system'); ?></span> 
							<div class="to-clear-fix">
								<textarea rows="1" cols="1" name="<?php BCBSHelper::getFormName('google_calendar_settings'); ?>" id="<?php BCBSHelper::getFormName('google_calendar_settings'); ?>"><?php echo esc_html($this->data['meta']['google_calendar_settings']); ?></textarea>
							</div>						 
						</li>
					</ul>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function($)
			{	
				/***/
				
				var helper=new BCBSHelper();
				helper.getMessageFromConsole();
				
				/***/
				
				var element=$('.to').themeOptionElement({init:true});
				
				$('#to-table-exclude-date').table();
				$('#to-table-boat-charter-date').table();
				
				/***/
				
				$('input[name="<?php BCBSHelper::getFormName('boat_availability_check_type'); ?>[]"]').on('change',function()
				{
					var value=parseInt($(this).val());
					var checkbox=$(this).parents('li:first').find('input');
					
					if($.inArray(value,[2,3])>-1)
						checkbox.last().prop('checked',false);	 
					
					var checked=[];
					checkbox.each(function()
					{
						if($(this).is(':checked'))
							checked.push(parseInt($(this).val(),10));
					});
					
					if($.inArray(1,checked)>-1 || checked.length===0)
					{
						checkbox.prop('checked',false);
						checkbox.last().prop('checked',true);						
					}
					
					checkbox.button('refresh');
				});
				
				/***/
				
				element.bindBrowseMedia('.to-button-browse');
				
				/***/
				
				var helper=new BCBSHelper();
				helper.googleMapAutocompleteCreate($('#bcbs_location_search'),function(place)
				{
					if(confirm('<?php esc_html_e('Do you want to fill all address details based on this location?') ?>'))
					{
						var key=
						[
							['address_street','route'],
							['address_street_number','street_number'],
							['address_postcode','postal_code'],
							['address_city','locality'],
							['address_state','administrative_area_level_1'],
							['address_country','country']
						];

						for(var i in key)
						{
							for(var j in place.address_components)
							{
								var field=$('[name="bcbs_'+key[i][0]+'"]');
								
								field.val('');
								
								if(key[i][1].length)
								{
									if($.inArray(key[i][1],place.address_components[j].types)>-1)
									{
										if(key[i][1]=='country')
										{
											field.val(place.address_components[j].short_name);	
											field.dropkick('refresh');
										}
										else field.val(place.address_components[j].long_name);	
										
										break;
									}
								}							
							}
						}
						
						$('[name="bcbs_coordinate_latitude"]').val(place.geometry.location.lat);
						$('[name="bcbs_coordinate_longitude"]').val(place.geometry.location.lng);
					}
				});
				
				/***/
				
			});
		</script>
						