<?php 
		echo BCBSHelper::displayNonce($this->data);; 
?>	
		<div class="to">
			<div class="ui-tabs">
				<ul>
					<li><a href="#meta-box-booking-extra-1"><?php esc_html_e('General','boat-charter-booking-system'); ?></a></li>
					<li><a href="#meta-box-booking-extra-2"><?php esc_html_e('Boats','boat-charter-booking-system'); ?></a></li>
				</ul>
				<div id="meta-box-booking-extra-1">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Description','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Description of the additive.','boat-charter-booking-system'); ?></span>
							<div>
								<textarea rows="1" cols="1" name="<?php BCBSHelper::getFormName('description'); ?>" id="<?php BCBSHelper::getFormName('description'); ?>"><?php echo esc_html($this->data['meta']['description']); ?></textarea>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Quantity','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Define quantity.','boat-charter-booking-system'); ?></span>						
							<div>
								<span class="to-legend-field"><?php esc_html_e('Minimum:','boat-charter-booking-system'); ?></span>
								<input type="text" name="<?php BCBSHelper::getFormName('quantity_minimum'); ?>" id="<?php BCBSHelper::getFormName('quantity_minimum'); ?>" value="<?php echo esc_attr($this->data['meta']['quantity_minimum']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Default:','boat-charter-booking-system'); ?></span>
								<input type="text" name="<?php BCBSHelper::getFormName('quantity_default'); ?>" id="<?php BCBSHelper::getFormName('quantity_default'); ?>" value="<?php echo esc_attr($this->data['meta']['quantity_default']); ?>"/>
							</div>							
							<div>
								<span class="to-legend-field"><?php esc_html_e('Maximum:','boat-charter-booking-system'); ?></span>
								<input type="text" name="<?php BCBSHelper::getFormName('quantity_maximum'); ?>" id="<?php BCBSHelper::getFormName('quantity_maximum'); ?>" value="<?php echo esc_attr($this->data['meta']['quantity_maximum']); ?>"/>
							</div>							
							<div>
								<span class="to-legend-field"><?php esc_html_e('Equal to number of rental days (works for "Day" billing type only):','boat-charter-booking-system'); ?></span>							
								<div class="to-radio-button">
									<input type="radio" value="1" id="<?php BCBSHelper::getFormName('quantity_equal_rental_day_number_1'); ?>" name="<?php BCBSHelper::getFormName('quantity_equal_rental_day_number'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['quantity_equal_rental_day_number'],1); ?>/>
									<label for="<?php BCBSHelper::getFormName('quantity_equal_rental_day_number_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
									<input type="radio" value="0" id="<?php BCBSHelper::getFormName('quantity_equal_rental_day_number_0'); ?>" name="<?php BCBSHelper::getFormName('quantity_equal_rental_day_number'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['quantity_equal_rental_day_number'],0); ?>/>
									<label for="<?php BCBSHelper::getFormName('quantity_equal_rental_day_number_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
								</div>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Readonly (customer is not able to change quantity):','boat-charter-booking-system'); ?></span>							
								<div class="to-radio-button">
									<input type="radio" value="1" id="<?php BCBSHelper::getFormName('quantity_readonly_enable_1'); ?>" name="<?php BCBSHelper::getFormName('quantity_readonly_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['quantity_readonly_enable'],1); ?>/>
									<label for="<?php BCBSHelper::getFormName('quantity_readonly_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
									<input type="radio" value="0" id="<?php BCBSHelper::getFormName('quantity_readonly_enable_0'); ?>" name="<?php BCBSHelper::getFormName('quantity_readonly_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['quantity_readonly_enable'],0); ?>/>
									<label for="<?php BCBSHelper::getFormName('quantity_readonly_enable_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
								</div>
							</div>								
						</li>
						<li>
							<h5><?php esc_html_e('State of "Select" button','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('State of the "Select" booking add-ons button.','boat-charter-booking-system'); ?><br/>
								<?php esc_html_e('"Not selected" means, that button will not be checked by default.','boat-charter-booking-system'); ?><br/>
								<?php esc_html_e('"Selected" means, that button will be checked by default, but customer is able to uncheck it.','boat-charter-booking-system'); ?><br/>
								<?php esc_html_e('"Mandatory" means, that button will be checked by default and customer is not able to uncheck it.','boat-charter-booking-system'); ?>
							</span>						
							<div class="to-radio-button">
								<input type="radio" value="0" id="<?php BCBSHelper::getFormName('button_select_default_state_0'); ?>" name="<?php BCBSHelper::getFormName('button_select_default_state'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['button_select_default_state'],0); ?>/>
								<label for="<?php BCBSHelper::getFormName('button_select_default_state_0'); ?>"><?php esc_html_e('Not selected','boat-charter-booking-system'); ?></label>
								<input type="radio" value="1" id="<?php BCBSHelper::getFormName('button_select_default_state_1'); ?>" name="<?php BCBSHelper::getFormName('button_select_default_state'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['button_select_default_state'],1); ?>/>
								<label for="<?php BCBSHelper::getFormName('button_select_default_state_1'); ?>"><?php esc_html_e('Selected','boat-charter-booking-system'); ?></label>
								<input type="radio" value="2" id="<?php BCBSHelper::getFormName('button_select_default_state_2'); ?>" name="<?php BCBSHelper::getFormName('button_select_default_state'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['button_select_default_state'],2); ?>/>
								<label for="<?php BCBSHelper::getFormName('button_select_default_state_2'); ?>"><?php esc_html_e('Mandatory','boat-charter-booking-system'); ?></label>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Price','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Price settings. You can also set prices and tax rates for each marina/boat separately in tab named "Boats".','boat-charter-booking-system'); ?>
							</span>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Net price:','boat-charter-booking-system'); ?></span>
								<input maxlength="12" type="text" name="<?php BCBSHelper::getFormName('price'); ?>" id="<?php BCBSHelper::getFormName('price'); ?>" value="<?php echo esc_attr($this->data['meta']['price']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Tax rate:','boat-charter-booking-system'); ?></span>		
								<div>
									<select name="<?php BCBSHelper::getFormName('tax_rate_id'); ?>">
<?php
		echo '<option value="0" '.(BCBSHelper::selectedIf($this->data['meta']['tax_rate_id'],0,false)).'>'.esc_html__('- Not set -','boat-charter-booking-system').'</option>';
		foreach($this->data['dictionary']['tax_rate'] as $index=>$value)
		{
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['meta']['tax_rate_id'],$index,false)).'>'.esc_html($value['post']->post_title).'</option>';
		}
?>	   
									</select>
								</div>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Price type:','boat-charter-booking-system'); ?></span>
								<div class="to-radio-button">
<?php
		foreach($this->data['dictionary']['price_type'] as $index=>$value)
		{
?>
									<input type="radio" value="<?php echo esc_attr($index); ?>" id="<?php BCBSHelper::getFormName('price_type_'.$index); ?>" name="<?php BCBSHelper::getFormName('price_type'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['price_type'],$index); ?>/>
									<label for="<?php BCBSHelper::getFormName('price_type_'.$index); ?>"><?php echo esc_html($value[0]); ?></label>
<?php		
		}
?>								
								</div>
							</div>
						</li> 
					</ul>
				</div>
				<div id="meta-box-booking-extra-2">
<?php
		if((is_array($this->data['dictionary']['marina'])) && (count($this->data['dictionary']['marina'])))
		{
?>
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Boats','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Set booking add-ons availability for boats in marinas and (if its is needed) price with tax.','boat-charter-booking-system'); ?>
							</span>
							<div class="to-clear-fix">
								<table class="to-table">
									<tr>
										<th width="20%">
											<div>
												<?php esc_html_e('Marina','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Marina.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th width="20%">
											<div>
												<?php esc_html_e('Boat','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Boat.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th width="20%">
											<div>
												<?php esc_html_e('Availability','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Set availability in marina.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th> 
										<th width="20%">
											<div>
												<?php esc_html_e('Price','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Net price.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>   
										<th width="20%">
											<div>
												<?php esc_html_e('Tax rate','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Tax rate.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>	
									</tr>
<?php
			foreach($this->data['dictionary']['marina'] as $marinaIndex=>$marinaValue)
			{
?>			   
									<tbody id="to-marina-<?php echo esc_attr($index); ?>">
										<tr>
											<td rowspan="<?php echo count($this->data['dictionary']['boat'])+1; ?>">
												<div class="to-clear-fix">
													<div class="to-field-disabled">
														<?php echo esc_html($marinaValue['post']->post_title); ?>
													</div>
												</div>
											</td>
										</tr>
<?php
				foreach($this->data['dictionary']['boat'] as $boatIndex=>$boatValue)
				{
?>
										<tr>	
											<td>
												<div class="to-clear-fix">
													<div class="to-field-disabled">
														<?php echo esc_html($boatValue['post']->post_title); ?>
													</div>
												</div>
											</td>
											<td>
												<div class="to-clear-fix">
													<div class="to-radio-button">
														<input type="radio" value="1" id="<?php BCBSHelper::getFormName('boat_enable_'.$marinaIndex.'_'.$boatIndex.'_1'); ?>" name="<?php BCBSHelper::getFormName('boat['.$marinaIndex.']['.$boatIndex.'][enable]'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['boat'][$marinaIndex][$boatIndex]['enable'],1); ?>/>
														<label for="<?php BCBSHelper::getFormName('boat_enable_'.$marinaIndex.'_'.$boatIndex.'_1'); ?>"><?php esc_html_e('Available','boat-charter-booking-system'); ?></label>
														<input type="radio" value="0" id="<?php BCBSHelper::getFormName('boat_enable_'.$marinaIndex.'_'.$boatIndex.'_0'); ?>" name="<?php BCBSHelper::getFormName('boat['.$marinaIndex.']['.$boatIndex.'][enable]'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['boat'][$marinaIndex][$boatIndex]['enable'],0); ?>/>
														<label for="<?php BCBSHelper::getFormName('boat_enable_'.$marinaIndex.'_'.$boatIndex.'_0'); ?>"><?php esc_html_e('Not available','boat-charter-booking-system'); ?></label>
													</div>
												</div>
											</td> 
											<td>
												<div class="to-clear-fix">
													<input type="text" name="<?php BCBSHelper::getFormName('boat['.$marinaIndex.']['.$boatIndex.'][price]'); ?>" value="<?php echo esc_attr($this->data['meta']['boat'][$marinaIndex][$boatIndex]['price']); ?>" title="<?php esc_attr_e('Enter price.','boat-charter-booking-system'); ?>"/>
												</div>
											</td> 
											<td>
												<div class="to-clear-fix">
													<select name="<?php BCBSHelper::getFormName('boat['.$marinaIndex.']['.$boatIndex.'][tax_rate_id]'); ?>">
													<?php
															echo '<option value="0" '.(BCBSHelper::selectedIf($this->data['meta']['boat'][$marinaIndex][$boatIndex]['tax_rate_id'],0,false)).'>'.esc_html__('- Not set -','boat-charter-booking-system').'</option>';
															foreach($this->data['dictionary']['tax_rate'] as $taxRateId=>$taxRateValue)
															{
																echo '<option value="'.esc_attr($taxRateId).'" '.(BCBSHelper::selectedIf($this->data['meta']['boat'][$marinaIndex][$boatIndex]['tax_rate_id'],$taxRateId,false)).'>'.esc_html($taxRateValue['post']->post_title).'</option>';
															}
													?>
													</select>														
												</div>										
											</td>
										</tr>
<?php
				}
?>
									</tbody>
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
			</div>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function($)
			{	
				$('.to').themeOptionElement({init:true});
			});
		</script>