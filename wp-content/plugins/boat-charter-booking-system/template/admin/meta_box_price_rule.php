<?php 
		echo BCBSHelper::displayNonce($this->data);;
		
		$Date=new BCBSDate();
?>	
		<div class="to">
			<div class="ui-tabs">
				<ul>
					<li><a href="#meta-box-price-rule-1"><?php esc_html_e('General','boat-charter-booking-system'); ?></a></li>
					<li><a href="#meta-box-price-rule-2"><?php esc_html_e('Conditions','boat-charter-booking-system'); ?></a></li>
					<li><a href="#meta-box-price-rule-3"><?php esc_html_e('Prices','boat-charter-booking-system'); ?></a></li>
					<li><a href="#meta-box-price-rule-4"><?php esc_html_e('Options','boat-charter-booking-system'); ?></a></li>
				</ul>
				<div id="meta-box-price-rule-1">
					<ul class="to-form-field-list">
						<?php echo BCBSHelper::createPostIdField(__('Price rule ID','boat-charter-booking-system')); ?>
					</ul>
				</div>
				<div id="meta-box-price-rule-2">
					<div class="ui-tabs">
						<ul>
							<li><a href="#meta-box-price-rule-2-1"><?php esc_html_e('General','boat-charter-booking-system'); ?></a></li>
							<li><a href="#meta-box-price-rule-2-2"><?php esc_html_e('Marinas','boat-charter-booking-system'); ?></a></li>
							<li><a href="#meta-box-price-rule-2-3"><?php esc_html_e('Boats','boat-charter-booking-system'); ?></a></li>
							<li><a href="#meta-box-price-rule-2-4"><?php esc_html_e('Dates','boat-charter-booking-system'); ?></a></li>
							<li><a href="#meta-box-price-rule-2-5"><?php esc_html_e('Days range','boat-charter-booking-system'); ?></a></li>
							<li><a href="#meta-box-price-rule-2-6"><?php esc_html_e('Hours range','boat-charter-booking-system'); ?></a></li>
						</ul>	
						<div id="meta-box-price-rule-2-1">
							<ul class="to-form-field-list">
								<li>
									<h5><?php esc_html_e('Booking forms','boat-charter-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Select forms.','boat-charter-booking-system'); ?></span>
									<div class="to-checkbox-button">
										<input type="checkbox" value="-1" id="<?php BCBSHelper::getFormName('booking_form_id_0'); ?>" name="<?php BCBSHelper::getFormName('booking_form_id[]'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['booking_form_id'],-1); ?>/>
										<label for="<?php BCBSHelper::getFormName('booking_form_id_0'); ?>"><?php esc_html_e('- All forms -','boat-charter-booking-system') ?></label>
<?php
		foreach($this->data['dictionary']['booking_form'] as $index=>$value)
		{
?>
										<input type="checkbox" value="<?php echo esc_attr($index); ?>" id="<?php BCBSHelper::getFormName('booking_form_id_'.$index); ?>" name="<?php BCBSHelper::getFormName('booking_form_id[]'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['booking_form_id'],$index); ?>/>
										<label for="<?php BCBSHelper::getFormName('booking_form_id_'.$index); ?>"><?php echo esc_html($value['post']->post_title); ?></label>
<?php		
		}
?>
									</div>
								</li>								
							</ul>
						</div>
						<div id="meta-box-price-rule-2-2">
							<ul class="to-form-field-list">
								<li>
									<h5><?php esc_html_e('Departure marina','boat-charter-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Select departure marina.','boat-charter-booking-system'); ?></span>
									<div class="to-checkbox-button">
										<input type="checkbox" value="-1" id="<?php BCBSHelper::getFormName('marina_departure_id_0'); ?>" name="<?php BCBSHelper::getFormName('marina_departure_id[]'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['marina_departure_id'],-1); ?>/>
										<label for="<?php BCBSHelper::getFormName('marina_departure_id_0'); ?>"><?php esc_html_e('- All marinas -','boat-charter-booking-system') ?></label>
<?php
		foreach($this->data['dictionary']['marina'] as $index=>$value)
		{
?>
										<input type="checkbox" value="<?php echo esc_attr($index); ?>" id="<?php BCBSHelper::getFormName('marina_departure_id_'.$index); ?>" name="<?php BCBSHelper::getFormName('marina_departure_id[]'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['marina_departure_id'],$index); ?>/>
										<label for="<?php BCBSHelper::getFormName('marina_departure_id_'.$index); ?>"><?php echo esc_html($value['post']->post_title); ?></label>
<?php		
		}
?>
									</div>
								</li>  
								<li>
									<h5><?php esc_html_e('Return marina','boat-charter-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Select return marina.','boat-charter-booking-system'); ?></span>
									<div class="to-checkbox-button">
										<input type="checkbox" value="-1" id="<?php BCBSHelper::getFormName('marina_return_id_0'); ?>" name="<?php BCBSHelper::getFormName('marina_return_id[]'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['marina_return_id'],-1); ?>/>
										<label for="<?php BCBSHelper::getFormName('marina_return_id_0'); ?>"><?php esc_html_e('- All marinas -','boat-charter-booking-system') ?></label>
<?php
		foreach($this->data['dictionary']['marina'] as $index=>$value)
		{
?>
										<input type="checkbox" value="<?php echo esc_attr($index); ?>" id="<?php BCBSHelper::getFormName('marina_return_id_'.$index); ?>" name="<?php BCBSHelper::getFormName('marina_return_id[]'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['marina_return_id'],$index); ?>/>
										<label for="<?php BCBSHelper::getFormName('marina_return_id_'.$index); ?>"><?php echo esc_html($value['post']->post_title); ?></label>
<?php		
		}
?>
									</div>
								</li>  								
							</ul>
						</div>
						<div id="meta-box-price-rule-2-3">
							<ul class="to-form-field-list">
								<li>
									<h5><?php esc_html_e('Boats','boat-charter-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Select boats.','boat-charter-booking-system'); ?></span>
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
							</ul>
						</div>
						<div id="meta-box-price-rule-2-4">
							<ul class="to-form-field-list">
								<li>
									<h5><?php esc_html_e('Day number','boat-charter-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Select the starting day of the rental week.','boat-charter-booking-system'); ?></span>
									<div class="to-checkbox-button">
										<input type="checkbox" value="-1" id="<?php BCBSHelper::getFormName('departure_day_number_0'); ?>" name="<?php BCBSHelper::getFormName('departure_day_number[]'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['departure_day_number'],-1); ?>/>
										<label for="<?php BCBSHelper::getFormName('departure_day_number_0'); ?>"><?php esc_html_e('- All days -','boat-charter-booking-system') ?></label>
<?php
		for($i=1;$i<=7;$i++)
		{
?>
										<input type="checkbox" value="<?php echo esc_attr($i); ?>" id="<?php BCBSHelper::getFormName('departure_day_number_'.$i); ?>" name="<?php BCBSHelper::getFormName('departure_day_number[]'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['departure_day_number'],$i); ?>/>
										<label for="<?php BCBSHelper::getFormName('departure_day_number_'.$i); ?>"><?php echo esc_html(date_i18n('l',strtotime('Sunday +'.$i.' days'))); ?></label>
<?php
		}
?>								
									</div>						
								</li>
								<li>
									<h5><?php esc_html_e('Dates','boat-charter-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Enter departure date.','boat-charter-booking-system'); ?><br/>
										<?php esc_html_e('In case if the prices are not specified, plugin treats below dates as departure dates.','boat-charter-booking-system'); ?><br/>
										<?php esc_html_e('Otherwise, plugin uses below dates to calculate price for entire period (you have to also define price type in tab named "Options").','boat-charter-booking-system'); ?>
									</span>
									<div>
										<table class="to-table" id="to-table-rental-date">
											<tr>
												<th style="width:30%">
													<div>
														<?php esc_html_e('From','boat-charter-booking-system'); ?>
														<span class="to-legend">
															<?php esc_html_e('From.','boat-charter-booking-system'); ?>
														</span>
													</div>
												</th>
												<th style="width:30%">
													<div>
														<?php esc_html_e('To','boat-charter-booking-system'); ?>
														<span class="to-legend">
															<?php esc_html_e('To.','boat-charter-booking-system'); ?>
														</span>
													</div>
												</th>
												<th style="width:20%">
													<div>
														<?php esc_html_e('Price','boat-charter-booking-system'); ?>
														<span class="to-legend">
															<?php esc_html_e('Price.','boat-charter-booking-system'); ?>
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
														<input type="text" class="to-datepicker-custom" name="<?php BCBSHelper::getFormName('departure_date[start][]'); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" class="to-datepicker-custom" name="<?php BCBSHelper::getFormName('departure_date[stop][]'); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" maxlength="12" name="<?php BCBSHelper::getFormName('departure_date[price][]'); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','boat-charter-booking-system'); ?></a>
													</div>
												</td>
											</tr>						 
<?php
		if(isset($this->data['meta']['departure_date']))
		{
			if(is_array($this->data['meta']['departure_date']))
			{
				foreach($this->data['meta']['departure_date'] as $index=>$value)
				{
?>
											<tr>
												<td>
													<div>
														<input type="text" class="to-datepicker-custom" name="<?php BCBSHelper::getFormName('departure_date[start][]'); ?>" value="<?php echo esc_attr($Date->formatDateToDisplay($value['start'])); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" class="to-datepicker-custom" name="<?php BCBSHelper::getFormName('departure_date[stop][]'); ?>" value="<?php echo esc_attr($Date->formatDateToDisplay($value['stop'])); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" mexlength="12" name="<?php BCBSHelper::getFormName('departure_date[price][]'); ?>" value="<?php echo esc_attr($value['price']); ?>"/>
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
						<div id="meta-box-price-rule-2-5">
							<ul class="to-form-field-list">
								<li>
									<h5><?php esc_html_e('Rental days number','boat-charter-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Enter number of rental days (works for "Daily" billing type only).','boat-charter-booking-system'); ?><br/>
										<?php esc_html_e('To use prices defined in below table, you have to choose proper source type of price in tab named "Options".','boat-charter-booking-system'); ?>
									</span>
									<div>
										<table class="to-table" id="to-table-rental-day-number">
											<tr>
												<th style="width:30%">
													<div>
														<?php esc_html_e('From','boat-charter-booking-system'); ?>
														<span class="to-legend">
															<?php esc_html_e('From.','boat-charter-booking-system'); ?>
														</span>
													</div>
												</th>
												<th style="width:30%">
													<div>
														<?php esc_html_e('To','boat-charter-booking-system'); ?>
														<span class="to-legend">
															<?php esc_html_e('To.','boat-charter-booking-system'); ?>
														</span>
													</div>
												</th>
												<th style="width:20%">
													<div>
														<?php esc_html_e('Price','boat-charter-booking-system'); ?>
														<span class="to-legend">
															<?php esc_html_e('Price.','boat-charter-booking-system'); ?>
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
														<input type="text" maxlength="5" name="<?php BCBSHelper::getFormName('rental_day_count[start][]'); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" maxlength="5" name="<?php BCBSHelper::getFormName('rental_day_count[stop][]'); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" maxlength="12" name="<?php BCBSHelper::getFormName('rental_day_count[price][]'); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','boat-charter-booking-system'); ?></a>
													</div>
												</td>
											</tr>   
<?php
		if(isset($this->data['meta']['rental_day_count']))
		{
			if(is_array($this->data['meta']['rental_day_count']))
			{
				foreach($this->data['meta']['rental_day_count'] as $index=>$value)
				{
?>
											<tr>
												<td>
													<div>
														<input type="text" maxlength="5" name="<?php BCBSHelper::getFormName('rental_day_count[start][]'); ?>" value="<?php echo esc_attr($value['start']); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" maxlength="5" name="<?php BCBSHelper::getFormName('rental_day_count[stop][]'); ?>" value="<?php echo esc_attr($value['stop']); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" maxlength="12" name="<?php BCBSHelper::getFormName('rental_day_count[price][]'); ?>" value="<?php echo esc_attr($value['price']); ?>"/>
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
						<div id="meta-box-price-rule-2-6">
							<ul class="to-form-field-list">
								<li>
									<h5><?php esc_html_e('Rental hours number','boat-charter-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Enter number of rental hours (works for "Hourly" billing type only).','boat-charter-booking-system'); ?></span>
									<div>
										<table class="to-table" id="to-table-rental-hour-number">
											<tr>
												<th style="width:30%">
													<div>
														<?php esc_html_e('From','boat-charter-booking-system'); ?>
														<span class="to-legend">
															<?php esc_html_e('From.','boat-charter-booking-system'); ?>
														</span>
													</div>
												</th>
												<th style="width:30%">
													<div>
														<?php esc_html_e('To','boat-charter-booking-system'); ?>
														<span class="to-legend">
															<?php esc_html_e('To.','boat-charter-booking-system'); ?>
														</span>
													</div>
												</th>
												<th style="width:20%">
													<div>
														<?php esc_html_e('Price','boat-charter-booking-system'); ?>
														<span class="to-legend">
															<?php esc_html_e('Price.','boat-charter-booking-system'); ?>
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
														<input type="text" maxlength="12" name="<?php BCBSHelper::getFormName('rental_hour_count[start][]'); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" maxlength="12" name="<?php BCBSHelper::getFormName('rental_hour_count[stop][]'); ?>"/>
													</div>									
												</td>
											   <td>
													<div>
														<input type="text" maxlength="12" name="<?php BCBSHelper::getFormName('rental_hour_count[price][]'); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','boat-charter-booking-system'); ?></a>
													</div>
												</td>
											</tr>   
<?php
		if(isset($this->data['meta']['rental_hour_count']))
		{
			if(is_array($this->data['meta']['rental_hour_count']))
			{
				foreach($this->data['meta']['rental_hour_count'] as $index=>$value)
				{
?>
											<tr>
												<td>
													<div>
														<input type="text" maxlength="5" name="<?php BCBSHelper::getFormName('rental_hour_count[start][]'); ?>" value="<?php echo esc_attr($value['start']); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" maxlength="5" name="<?php BCBSHelper::getFormName('rental_hour_count[stop][]'); ?>" value="<?php echo esc_attr($value['stop']); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" maxlength="12" name="<?php BCBSHelper::getFormName('rental_hour_count[price][]'); ?>" value="<?php echo esc_attr($value['price']); ?>"/>
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
				<div id="meta-box-price-rule-3">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Prices','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Net prices.','boat-charter-booking-system'); ?></span>
							<div>
								<table class="to-table to-table-price">
									<tr>
										<th style="width:20%">
											<div>
												<?php esc_html_e('Name','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Name.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:30%">
											<div>
												<?php esc_html_e('Description','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Description.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:20%">
											<div>
												<?php esc_html_e('Price alter','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Price alter type.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>	
										<th style="width:20%">
											<div>
												<?php esc_html_e('Value','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Value.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>										
										<th style="width:10%">
											<div>
												<?php esc_html_e('Tax','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Tax.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>										  
									</tr>
									<tr>
										<td>
											<div class="to-clear-fix">
												<?php esc_html_e('Initial','boat-charter-booking-system'); ?>
											</div>
										</td>							
										<td>
											<div class="to-clear-fix">
												<?php esc_html_e('Initial, fixed fee added to the booking.','boat-charter-booking-system'); ?>
											</div>
										</td>	
										<td>
											<div class="to-clear-fix">
												<select name="<?php BCBSHelper::getFormName('price_initial_alter_type_id'); ?>">
<?php
		foreach($this->data['dictionary']['price_alter_type'] as $index=>$value)
		{
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['meta']['price_initial_alter_type_id'],$index,false)).'>'.esc_html($value[0]).'</option>';
		}
?>
												</select>												  
											</div>
										</td> 
										<td>
											<div class="to-clear-fix">
												<input type="text" maxlength="12" id="<?php BCBSHelper::getFormName('price_initial_value'); ?>" name="<?php BCBSHelper::getFormName('price_initial_value'); ?>" value="<?php echo esc_attr($this->data['meta']['price_initial_value']); ?>"/>
											</div>
										</td>	
										<td>
											<div class="to-clear-fix">
												<select name="<?php BCBSHelper::getFormName('price_initial_tax_rate_id'); ?>">
<?php
		echo '<option value="0" '.(BCBSHelper::selectedIf($this->data['meta']['price_initial_tax_rate_id'],0,false)).'>'.esc_html__('- Not set -','boat-charter-booking-system').'</option>';
		foreach($this->data['dictionary']['tax_rate'] as $index=>$value)
		{
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['meta']['price_initial_tax_rate_id'],$index,false)).'>'.esc_html($value['post']->post_title).'</option>';
		}
?>	   
												</select>
											</div>
										</td>	
									</tr>
									<tr>
										<td>
											<div class="to-clear-fix">
												<?php esc_html_e('Rental per day','boat-charter-booking-system'); ?>
											</div>
										</td>							
										<td>
											<div class="to-clear-fix">
												<?php esc_html_e('Price for a boat rent per day.','boat-charter-booking-system'); ?><br/>
												<?php esc_html_e('This price applies for "Daily" and "Daily and Hourly" billing type only.','boat-charter-booking-system'); ?>
											</div>
										</td>	
										<td>
											<div class="to-clear-fix">
												<select name="<?php BCBSHelper::getFormName('price_rental_day_alter_type_id'); ?>">
<?php
		foreach($this->data['dictionary']['price_alter_type'] as $index=>$value)
		{
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['meta']['price_rental_day_alter_type_id'],$index,false)).'>'.esc_html($value[0]).'</option>';
		}
?>
												</select>												  
											</div>
										</td>
										<td>
											<div class="to-clear-fix">
												<input type="text" maxlength="12" id="<?php BCBSHelper::getFormName('price_rental_day_value'); ?>" name="<?php BCBSHelper::getFormName('price_rental_day_value'); ?>" value="<?php echo esc_attr($this->data['meta']['price_rental_day_value']); ?>"/>
											</div>											
										</td>
										<td>
											<div class="to-clear-fix">
												<select name="<?php BCBSHelper::getFormName('price_rental_day_tax_rate_id'); ?>">
<?php
		echo '<option value="0" '.(BCBSHelper::selectedIf($this->data['meta']['price_rental_day_tax_rate_id'],0,false)).'>'.esc_html__('- Not set -','boat-charter-booking-system').'</option>';
		foreach($this->data['dictionary']['tax_rate'] as $index=>$value)
		{
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['meta']['price_rental_day_tax_rate_id'],$index,false)).'>'.esc_html($value['post']->post_title).'</option>';
		}
?>
												</select>												
											</div>
										</td>	
									</tr>									
									<tr>
										<td>
											<div class="to-clear-fix">
												<?php esc_html_e('Rental per hour','boat-charter-booking-system'); ?>
											</div>
										</td>							
										<td>
											<div class="to-clear-fix">
												<?php esc_html_e('Price for a boat rent per hour.','boat-charter-booking-system'); ?><br/>
												<?php esc_html_e('This price applies for "Hourly" and "Daily and Hourly" billing type only.','boat-charter-booking-system'); ?>
											 </div>
										</td>
										<td>
											<div class="to-clear-fix">
												<select name="<?php BCBSHelper::getFormName('price_rental_hour_alter_type_id'); ?>">
<?php
		foreach($this->data['dictionary']['price_alter_type'] as $index=>$value)
		{
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['meta']['price_rental_hour_alter_type_id'],$index,false)).'>'.esc_html($value[0]).'</option>';
		}
?>
												</select>												  
											</div>
										</td> 
										<td>
											<div class="to-clear-fix">
												<input type="text" maxlength="12" id="<?php BCBSHelper::getFormName('price_rental_hour_value'); ?>" name="<?php BCBSHelper::getFormName('price_rental_hour_value'); ?>" value="<?php echo esc_attr($this->data['meta']['price_rental_hour_value']); ?>"/>
											</div>
										</td>	
										<td>
											<div class="to-clear-fix">
												<select name="<?php BCBSHelper::getFormName('price_rental_hour_tax_rate_id'); ?>">
<?php
		echo '<option value="0" '.(BCBSHelper::selectedIf($this->data['meta']['price_rental_hour_tax_rate_id'],0,false)).'>'.esc_html__('- Not set -','boat-charter-booking-system').'</option>';
		foreach($this->data['dictionary']['tax_rate'] as $index=>$value)
		{
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['meta']['price_rental_hour_tax_rate_id'],$index,false)).'>'.esc_html($value['post']->post_title).'</option>';
		}
?>
												</select>												
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="to-clear-fix">
												<?php esc_html_e('Deposit','boat-charter-booking-system'); ?>
											</div>
										</td>							
										<td>
											<div class="to-clear-fix">
												<?php esc_html_e('Fixed value added to the booking.','boat-charter-booking-system'); ?><br/>
												<?php esc_html_e('This amount protects the owner against costs related to boat damage.','boat-charter-booking-system'); ?><br/> 
												<?php esc_html_e('Should be returned to the customer, if boat has no signs of damage.','boat-charter-booking-system'); ?><br/>
											</div>
										</td>
										<td>
											<div class="to-clear-fix">
												<select name="<?php BCBSHelper::getFormName('price_deposit_alter_type_id'); ?>">
<?php
		foreach($this->data['dictionary']['price_alter_type'] as $index=>$value)
		{
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['meta']['price_deposit_alter_type_id'],$index,false)).'>'.esc_html($value[0]).'</option>';
		}
?>
												</select>												  
											</div>
										</td> 
										<td>
											<div class="to-clear-fix">
												<input type="text" maxlength="12" id="<?php BCBSHelper::getFormName('price_deposit_value'); ?>" name="<?php BCBSHelper::getFormName('price_deposit_value'); ?>" value="<?php echo esc_attr($this->data['meta']['price_deposit_value']); ?>"/>
											</div>
										</td>	
										<td>
											<div class="to-clear-fix">
												<select name="<?php BCBSHelper::getFormName('price_deposit_tax_rate_id'); ?>">
<?php
		echo '<option value="0" '.(BCBSHelper::selectedIf($this->data['meta']['price_deposit_tax_rate_id'],0,false)).'>'.esc_html__('- Not set -','boat-charter-booking-system').'</option>';
		foreach($this->data['dictionary']['tax_rate'] as $index=>$value)
		{
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['meta']['price_deposit_tax_rate_id'],$index,false)).'>'.esc_html($value['post']->post_title).'</option>';
		}
?>								 
												</select>
											</div>
										</td>	
									</tr>
									<tr>
										<td>
											<div class="to-clear-fix">
												<?php esc_html_e('One way','boat-charter-booking-system'); ?>
											</div>
										</td>							
										<td>
											<div class="to-clear-fix">
												<?php esc_html_e('Fixed value added to the booking if boat is returned to different marina than departure marina.','boat-charter-booking-system'); ?><br/>
											</div>
										</td>	
										<td>
											<div class="to-clear-fix">
												<select name="<?php BCBSHelper::getFormName('price_one_way_alter_type_id'); ?>">
<?php
		foreach($this->data['dictionary']['price_alter_type'] as $index=>$value)
		{
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['meta']['price_one_way_alter_type_id'],$index,false)).'>'.esc_html($value[0]).'</option>';
		}
?>
												</select>												  
											</div>
										</td> 
										<td>
											<div class="to-clear-fix">
												<input type="text" maxlength="12" id="<?php BCBSHelper::getFormName('price_one_way_value'); ?>" name="<?php BCBSHelper::getFormName('price_one_way_value'); ?>" value="<?php echo esc_attr($this->data['meta']['price_one_way_value']); ?>"/>
											</div>
										</td>	
										<td>
											<div class="to-clear-fix">
												<select name="<?php BCBSHelper::getFormName('price_one_way_tax_rate_id'); ?>">
<?php
		echo '<option value="0" '.(BCBSHelper::selectedIf($this->data['meta']['price_one_way_tax_rate_id'],0,false)).'>'.esc_html__('- Not set -','boat-charter-booking-system').'</option>';
		foreach($this->data['dictionary']['tax_rate'] as $index=>$value)
		{
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['meta']['price_one_way_tax_rate_id'],$index,false)).'>'.esc_html($value['post']->post_title).'</option>';
		}
?>
												</select>								   
											</div>
										</td>	
									</tr>
									<tr>
										<td>
											<div class="to-clear-fix">
												<?php esc_html_e('Departure after business hours','boat-charter-booking-system'); ?>
											</div>
										</td>							
										<td>
											<div class="to-clear-fix">
												<?php esc_html_e('Fixed value added to the booking, if departure is after business hours.','boat-charter-booking-system'); ?>
											</div>
										</td>	
										<td>
											<div class="to-clear-fix">
												<select name="<?php BCBSHelper::getFormName('price_after_business_hour_departure_alter_type_id'); ?>">
<?php
		foreach($this->data['dictionary']['price_alter_type'] as $index=>$value)
		{
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['meta']['price_after_business_hour_departure_alter_type_id'],$index,false)).'>'.esc_html($value[0]).'</option>';
		}
?>
												</select>												  
											</div>
										</td> 
										<td>
											<div class="to-clear-fix">
												<input type="text" maxlength="12" id="<?php BCBSHelper::getFormName('price_after_business_hour_departure_value'); ?>" name="<?php BCBSHelper::getFormName('price_after_business_hour_departure_value'); ?>" value="<?php echo esc_attr($this->data['meta']['price_after_business_hour_departure_value']); ?>"/>
											</div>
										</td>	
										<td>
											<div class="to-clear-fix">
												<select name="<?php BCBSHelper::getFormName('price_after_business_hour_departure_tax_rate_id'); ?>">
<?php
		echo '<option value="0" '.(BCBSHelper::selectedIf($this->data['meta']['price_after_business_hour_departure_tax_rate_id'],0,false)).'>'.esc_html__('- Not set -','boat-charter-booking-system').'</option>';
		foreach($this->data['dictionary']['tax_rate'] as $index=>$value)
		{
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['meta']['price_after_business_hour_departure_tax_rate_id'],$index,false)).'>'.esc_html($value['post']->post_title).'</option>';
		}
?>
												</select>								   
											</div>
										</td>	
									</tr>
									<tr>
										<td>
											<div class="to-clear-fix">
												<?php esc_html_e('Return after business hours','boat-charter-booking-system'); ?>
											</div>
										</td>							
										<td>
											<div class="to-clear-fix">
												<?php esc_html_e('Fixed value added to the booking, if boat has been returned after business hours.','boat-charter-booking-system'); ?>
											</div>
										</td>	
										<td>
											<div class="to-clear-fix">
												<select name="<?php BCBSHelper::getFormName('price_after_business_hour_return_alter_type_id'); ?>">
<?php
		foreach($this->data['dictionary']['price_alter_type'] as $index=>$value)
		{
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['meta']['price_after_business_hour_return_alter_type_id'],$index,false)).'>'.esc_html($value[0]).'</option>';
		}
?>
												</select>												  
											</div>
										</td> 
										<td>
											<div class="to-clear-fix">
												<input type="text" maxlength="12" id="<?php BCBSHelper::getFormName('price_after_business_hour_return_value'); ?>" name="<?php BCBSHelper::getFormName('price_after_business_hour_return_value'); ?>" value="<?php echo esc_attr($this->data['meta']['price_after_business_hour_return_value']); ?>"/>
											</div>
										</td>	
										<td>
											<div class="to-clear-fix">
												<select name="<?php BCBSHelper::getFormName('price_after_business_hour_return_tax_rate_id'); ?>">
<?php
		echo '<option value="0" '.(BCBSHelper::selectedIf($this->data['meta']['price_after_business_hour_return_tax_rate_id'],0,false)).'>'.esc_html__('- Not set -','boat-charter-booking-system').'</option>';
		foreach($this->data['dictionary']['tax_rate'] as $index=>$value)
		{
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['meta']['price_after_business_hour_return_tax_rate_id'],$index,false)).'>'.esc_html($value['post']->post_title).'</option>';
		}
?>
												</select>								   
											</div>
										</td>	
									</tr>
								</table>
							</div>
						</li>
					</ul>
				</div>				
				<div id="meta-box-price-rule-4">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Price source','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Select price source.','boat-charter-booking-system'); ?>
							</span>
							<div class="to-clear-fix">
								<select name="<?php BCBSHelper::getFormName('price_source_type'); ?>">
<?php
		foreach($this->data['dictionary']['price_source_type'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['meta']['price_source_type'],$index,false)).'>'.esc_html($value[0]).'</option>';
?>
								</select>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Next rule processing','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php echo esc_html__('This option determine, whether prices will be set up based on this rule only or plugin has to processing next rule based on priority (order).','boat-charter-booking-system'); ?>
							</span>			   
							<div>
								<div class="to-radio-button">
									<input type="radio" value="1" id="<?php BCBSHelper::getFormName('process_next_rule_enable_1'); ?>" name="<?php BCBSHelper::getFormName('process_next_rule_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['process_next_rule_enable'],1); ?>/>
									<label for="<?php BCBSHelper::getFormName('process_next_rule_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
									<input type="radio" value="0" id="<?php BCBSHelper::getFormName('process_next_rule_enable_0'); ?>" name="<?php BCBSHelper::getFormName('process_next_rule_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['process_next_rule_enable'],0); ?>/>
									<label for="<?php BCBSHelper::getFormName('process_next_rule_enable_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
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
				/***/
				
				$('.to').themeOptionElement({init:true});
				
				/***/
				
				$('input[name="<?php BCBSHelper::getFormName('booking_form_id'); ?>[]"],input[name="<?php BCBSHelper::getFormName('marina_departure_id'); ?>[]"],input[name="<?php BCBSHelper::getFormName('marina_return_id'); ?>[]"],input[name="<?php BCBSHelper::getFormName('boat_id'); ?>[]"],input[name="<?php BCBSHelper::getFormName('departure_day_number'); ?>[]"]').on('change',function()
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
				
				/***/
				
				$('#to-table-rental-date').table();
				$('#to-table-rental-day-number').table();
				$('#to-table-rental-hour-number').table();
				$('#to-table-driver-age').table();
				
				/***/
				
				var timeFormat='<?php echo BCBSOption::getOption('time_format'); ?>';
				var dateFormat='<?php echo BCBSJQueryUIDatePicker::convertDateFormat(BCBSOption::getOption('date_format')); ?>';
				
				toCreateCustomDateTimePicker(dateFormat,timeFormat);
				
				/***/
			});
		</script>