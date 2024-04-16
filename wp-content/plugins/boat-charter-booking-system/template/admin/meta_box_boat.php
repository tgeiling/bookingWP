<?php 
		global $post;

		echo BCBSHelper::displayNonce($this->data);; 

		if(!count($this->data['meta']['marina_id']))
		{
?>	
		<div class="notice notice-error">
			<p>
				<?php esc_html_e('Please assign boat to at least one location. Otherwise boat will not be available in booking form.','boat-charter-booking-system') ?>
			</p>
		</div>
<?php
		}
?>
		<div class="to">
			<div class="ui-tabs">
				<ul>
					<li><a href="#meta-box-boat-1"><?php esc_html_e('General','boat-charter-booking-system'); ?></a></li>
					<li><a href="#meta-box-boat-2"><?php esc_html_e('Prices','boat-charter-booking-system'); ?></a></li>
					<li><a href="#meta-box-boat-3"><?php esc_html_e('Attributes','boat-charter-booking-system'); ?></a></li>
					<li><a href="#meta-box-boat-4"><?php esc_html_e('Availability','boat-charter-booking-system'); ?></a></li>
				</ul>
				<div id="meta-box-boat-1">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Marinas','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Select at least one marina at which the boat is available.','boat-charter-booking-system'); ?>
							</span>
							<div class="to-checkbox-button">
<?php
		foreach($this->data['dictionary']['marina'] as $index=>$value)
		{
?>
								<input type="checkbox" value="<?php echo esc_attr($index); ?>" id="<?php BCBSHelper::getFormName('marina_id_'.$index); ?>" name="<?php BCBSHelper::getFormName('marina_id[]'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['marina_id'],$index); ?>/>
								<label for="<?php BCBSHelper::getFormName('marina_id_'.$index); ?>"><?php echo esc_html(get_the_title($index)); ?></label>
<?php		
		}
?>								
							</div>
						</li>  
						<li>
							<h5><?php esc_html_e('Dimension','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Width and length of the boat in meters.','boat-charter-booking-system'); ?>
							</span>
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('Width:','boat-charter-booking-system'); ?></span>
								<input type="text" maxlength="12" name="<?php BCBSHelper::getFormName('dimension_width'); ?>" value="<?php echo esc_attr($this->data['meta']['dimension_width']); ?>" id="<?php BCBSHelper::getFormName('dimension_width'); ?>"/>
							</div>							
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('Length:','boat-charter-booking-system'); ?></span>
								<input type="text" maxlength="12" name="<?php BCBSHelper::getFormName('dimension_length'); ?>" value="<?php echo esc_attr($this->data['meta']['dimension_length']); ?>" id="<?php BCBSHelper::getFormName('dimension_length'); ?>"/>
							</div>								
						</li> 
						<li>
							<h5><?php esc_html_e('Number of guests','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Maximum number of guests. Integer value from 1 to 999.','boat-charter-booking-system'); ?></span>
							<div>
								<input maxlength="3" type="text" name="<?php BCBSHelper::getFormName('guest_number'); ?>" id="<?php BCBSHelper::getFormName('guest_number'); ?>" value="<?php echo esc_attr($this->data['meta']['guest_number']); ?>"/>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Number of cabins','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Number of cabins. Integer value from 1 to 999.','boat-charter-booking-system'); ?></span>
							<div>
								<input maxlength="4" type="text" name="<?php BCBSHelper::getFormName('cabin_number'); ?>" id="<?php BCBSHelper::getFormName('cabin_number'); ?>" value="<?php echo esc_attr($this->data['meta']['cabin_number']); ?>"/>
							</div>
						</li>						
						<li>
							<h5><?php esc_html_e('Group code','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Group code is used to create a set of boats. Only one boat from the group with the same code will be displayed on booking form..','boat-charter-booking-system'); ?></span>
							<div>
								<input maxlength="255" type="text" name="<?php BCBSHelper::getFormName('group_code'); ?>" id="<?php BCBSHelper::getFormName('group_code'); ?>" value="<?php echo esc_attr($this->data['meta']['group_code']); ?>"/>
							</div>
						</li>   
						<li>
							<h5><?php esc_html_e('Captain','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Define whether captain is needed for this boat.','boat-charter-booking-system'); ?>
							</span>
							<div class="to-radio-button">
								<input type="radio" value="1" id="<?php BCBSHelper::getFormName('captain_status_1'); ?>" name="<?php BCBSHelper::getFormName('captain_status'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['captain_status'],1); ?>/>
								<label for="<?php BCBSHelper::getFormName('captain_status_1'); ?>"><?php esc_html_e('With Captain','boat-charter-booking-system'); ?></label>
								<input type="radio" value="2" id="<?php BCBSHelper::getFormName('captain_status_2'); ?>" name="<?php BCBSHelper::getFormName('captain_status'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['captain_status'],2); ?>/>
								<label for="<?php BCBSHelper::getFormName('captain_status_2'); ?>"><?php esc_html_e('Without Captain','boat-charter-booking-system'); ?></label>
								<input type="radio" value="3" id="<?php BCBSHelper::getFormName('captain_status_3'); ?>" name="<?php BCBSHelper::getFormName('captain_status'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['captain_status'],3); ?>/>
								<label for="<?php BCBSHelper::getFormName('captain_status_3'); ?>"><?php esc_html_e('With or Without captain','boat-charter-booking-system'); ?></label>
							</div>
						</li> 	
						<li>
							<h5><?php esc_html_e('Gallery','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Click on "Browse" button below to create a gallery for boat.','boat-charter-booking-system'); ?><br/>
								<?php esc_html_e('It is needed to set up "Featured image" for the boat to get gallery working.','boat-charter-booking-system'); ?>
							</span>
							<div class="to-clear-fix">
								<input type="hidden" name="<?php BCBSHelper::getFormName('gallery_image_id'); ?>" id="<?php BCBSHelper::getFormName('gallery_image_id'); ?>" value="<?php echo esc_attr(implode('.',$this->data['meta']['gallery_image_id'])); ?>"/>
								<input type="button" name="<?php BCBSHelper::getFormName('gallery_image_id_browse'); ?>" id="<?php BCBSHelper::getFormName('gallery_image_id_browse'); ?>" class="to-button-browse to-button to-margin-right-10" value="<?php esc_attr_e('Browse','boat-charter-booking-system'); ?>"/>
								<input type="button" name="<?php BCBSHelper::getFormName('gallery_image_id_remove'); ?>" id="<?php BCBSHelper::getFormName('gallery_image_id_remove'); ?>" class="to-button-browse to-button" value="<?php esc_attr_e('Remove','boat-charter-booking-system'); ?>"/>
							</div>
						</li>	
						<li>
							<h5><?php esc_html_e('Boat availability calendar','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Copy and paste the shortcode on a page.','boat-charter-booking-system'); ?></span>
							<div class="to-field-disabled">
<?php
		$shortcode='['.PLUGIN_BCBS_CONTEXT.'_boat_availability_calendar boat_id="'.$post->ID.'" booking_form_id=""]';
		echo esc_html($shortcode);
?>
								<a href="#" class="to-copy-to-clipboard to-float-right" data-clipboard-text="<?php echo esc_attr($shortcode); ?>" data-label-on-success="<?php esc_attr_e('Copied!','boat-charter-booking-system') ?>"><?php esc_html_e('Copy','boat-charter-booking-system'); ?></a>
							</div>
						</li>	
					</ul>
				</div>
				<div id="meta-box-boat-2">
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
										<th style="width:40%">
											<div>
												<?php esc_html_e('Description','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Description.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:30%">
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
												<?php esc_html_e('Fixed value added to the booking if boat is returned to different location than departure location.','boat-charter-booking-system'); ?><br/>
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
				<div id="meta-box-boat-3">
<?php
		if((isset($this->data['dictionary']['boat_attribute'])) && (count($this->data['dictionary']['boat_attribute'])))
		{
?>
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Attributes','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Specify attributes of the boat.','boat-charter-booking-system'); ?></span>
							<div>	
								<table class="to-table" id="to-table-boat-attribute">
									<tr>
										<th style="width:50%">
											<div>
												<?php esc_html_e('Attribute name','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Attribute name.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:50%">
											<div>
												<?php esc_html_e('Attribute value','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Attribute value(s).','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
									</tr>	   
<?php
			foreach($this->data['dictionary']['boat_attribute'] as $attributeIndex=>$attributeValue)
			{
?>
									<tr>
										<td>
											<div><?php echo esc_html($attributeValue['post']->post_title) ?></div>
										</td>
										<td>
											<div class="to-clear-fix">
<?php
				switch($attributeValue['meta']['attribute_type'])
				{
					case 1:
?>
												<input type="text" id="<?php BCBSHelper::getFormName('attribute['.$attributeIndex.']'); ?>" name="<?php BCBSHelper::getFormName('attribute['.$attributeIndex.']'); ?>" value="<?php echo esc_attr($this->data['meta']['attribute'][$attributeIndex]); ?>"/>
<?php					   
					break;
					case 2:
					case 3:

								$type=$attributeValue['meta']['attribute_type']==2 ? 'radio' : 'checkbox';
?>
												<div class="to-<?php echo esc_attr($type); ?>-button">
													<input type="<?php echo esc_attr($type); ?>" value="-1" id="<?php BCBSHelper::getFormName('attribute['.$attributeIndex.'][0]'); ?>" name="<?php BCBSHelper::getFormName('attribute['.$attributeIndex.'][]'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['attribute'][$attributeIndex],-1); ?>/>
													<label for="<?php BCBSHelper::getFormName('attribute['.$attributeIndex.'][0]'); ?>"><?php esc_html_e('- Not set -','boat-charter-booking-system'); ?></label>
<?php
								foreach($attributeValue['meta']['attribute_value'] as $data)
								{
?>						   
													<input type="<?php echo esc_attr($type); ?>" value="<?php echo (int)$data['id']; ?>" id="<?php BCBSHelper::getFormName('attribute['.$attributeIndex.']['.(int)$data['id'].']'); ?>" name="<?php BCBSHelper::getFormName('attribute['.$attributeIndex.'][]'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['attribute'][$attributeIndex],(int)$data['id']); ?>/>
													<label for="<?php BCBSHelper::getFormName('attribute['.$attributeIndex.']['.(int)$data['id'].']'); ?>"><?php echo esc_html($data['value']); ?></label>
<?php
								}
?>						
												</div>
<?php
					break;
				}
?>
											</div>
										</td>
									</tr>
<?php
			}
?>
								</table>
							</div>
						</li>
					</ul>
<?php
		}
?>
				</div>
				<div id="meta-box-boat-4">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Exclude dates','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Specify dates in which boat is not available. Past (or invalid date ranges) will be removed during saving.','boat-charter-booking-system'); ?></span>
							<div>	
								<table class="to-table" id="to-table-availability-exclude-date">
									<tr>
										<th style="width:40%" colspan="2">
											<div>
												<?php esc_html_e('Start Date','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Enter start date and time (optionally).','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:40%" colspan="2">
											<div>
												<?php esc_html_e('End Date','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Enter end date and time (optionally).','boat-charter-booking-system'); ?>
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
												<input type="text" class="to-datepicker-custom" name="<?php BCBSHelper::getFormName('date_exclude[]'); ?>" title="<?php esc_attr_e('Enter start date.','boat-charter-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" class="to-timepicker-custom" name="<?php BCBSHelper::getFormName('date_exclude[]'); ?>" title="<?php esc_attr_e('Enter start time.','boat-charter-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" class="to-datepicker-custom" name="<?php BCBSHelper::getFormName('date_exclude[]'); ?>" title="<?php esc_attr_e('Enter start date.','boat-charter-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" class="to-timepicker-custom" name="<?php BCBSHelper::getFormName('date_exclude[]'); ?>" title="<?php esc_attr_e('Enter start time.','boat-charter-booking-system'); ?>"/>
											</div>									
										</td>										
										<td>
											<div>
												<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','boat-charter-booking-system'); ?></a>
											</div>
										</td>
									</tr>
<?php
		$Date=new BCBSDate();
		if(count($this->data['meta']['date_exclude']))
		{
			foreach($this->data['meta']['date_exclude'] as $dateExcludeIndex=>$dateExcludeValue)
			{
?>
									<tr>
										<td>
											<div>
												<input type="text" class="to-datepicker-custom" name="<?php BCBSHelper::getFormName('date_exclude[]'); ?>" title="<?php esc_attr_e('Enter start date.','boat-charter-booking-system'); ?>" value="<?php echo esc_attr($Date->formatDateToDisplay($dateExcludeValue['start_date'])); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" class="to-timepicker-custom" name="<?php BCBSHelper::getFormName('date_exclude[]'); ?>" title="<?php esc_attr_e('Enter start time.','boat-charter-booking-system'); ?>"  value="<?php echo esc_attr($Date->formatTimeToDisplay($dateExcludeValue['start_time'])); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" class="to-datepicker-custom" name="<?php BCBSHelper::getFormName('date_exclude[]'); ?>" title="<?php esc_attr_e('Enter start date.','boat-charter-booking-system'); ?>" value="<?php echo esc_attr($Date->formatDateToDisplay($dateExcludeValue['stop_date'])); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" class="to-timepicker-custom" name="<?php BCBSHelper::getFormName('date_exclude[]'); ?>" title="<?php esc_attr_e('Enter start time.','boat-charter-booking-system'); ?>"  value="<?php echo esc_attr($Date->formatTimeToDisplay($dateExcludeValue['stop_time'])); ?>"/>
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
			</div>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function($)
			{	
				var element=$('.to').themeOptionElement({init:true});
				
				element.bindBrowseMedia('input[name="bcbs_gallery_image_id_browse"]',true,2);
				
				/***/
				
				$('#to-table-boat-attribute input[type="checkbox"]').on('change',function()
				{
					var value=parseInt($(this).val());

					var checkbox=$(this).parents('div:first').find('input');

					if(value===-1)
					{
						checkbox.prop('checked',false);
						checkbox.first().prop('checked',true);
					}
					else checkbox.first().prop('checked',false);
					
					checkbox.button('refresh');
				});
				
				/***/
				
				$('#<?php BCBSHelper::getFormName('gallery_image_id_remove'); ?>').on('click',function()
				{
					if(confirm('<?php esc_attr_e('Do you want to remove all images from this gallery?','boat-charter-booking-system'); ?>'))
					{
						$(this).prevAll('input[type="hidden"]').val('');
						alert('<?php esc_attr_e('All images have been removed from gallery.','boat-charter-booking-system'); ?>');
					}
				});
				
				/***/
				
				$('#to-table-availability-exclude-date').table();
				
				/***/
				
				var timeFormat='<?php echo BCBSOption::getOption('time_format'); ?>';
				var dateFormat='<?php echo BCBSJQueryUIDatePicker::convertDateFormat(BCBSOption::getOption('date_format')); ?>';
				
				toCreateCustomDateTimePicker(dateFormat,timeFormat);
			});
		</script>