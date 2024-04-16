<?php 
		echo BCBSHelper::displayNonce($this->data);; 
		
		$Date=new BCBSDate();
		$PriceRule=new BCBSPriceRule();
		$Validation=new BCBSValidation();
		
		$BookingFormElement=new BCBSBookingFormElement();
?>	
		<div class="to">
			<div class="ui-tabs">
				<ul>
					<li><a href="#meta-box-booking-1"><?php esc_html_e('General','boat-charter-booking-system'); ?></a></li>
					<li><a href="#meta-box-booking-2"><?php esc_html_e('Billing','boat-charter-booking-system'); ?></a></li>
					<li><a href="#meta-box-booking-3"><?php esc_html_e('Boat','boat-charter-booking-system'); ?></a></li>
					<li><a href="#meta-box-booking-4"><?php esc_html_e('Extras','boat-charter-booking-system'); ?></a></li>
					<li><a href="#meta-box-booking-5"><?php esc_html_e('Client','boat-charter-booking-system'); ?></a></li>
					<li><a href="#meta-box-booking-6"><?php esc_html_e('Payment','boat-charter-booking-system'); ?></a></li>
				</ul>
				<div id="meta-box-booking-1">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Status','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Booking status.','boat-charter-booking-system'); ?></span>
							<div class="to-radio-button">
<?php
		foreach($this->data['dictionary']['booking_status'] as $index=>$value)
		{
?>
								<input type="radio" value="<?php echo esc_attr($index); ?>" id="<?php BCBSHelper::getFormName('booking_status_id_'.$index); ?>" name="<?php BCBSHelper::getFormName('booking_status_id'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['booking_status_id'],$index); ?>/>
								<label for="<?php BCBSHelper::getFormName('booking_status_id_'.$index); ?>"><?php echo esc_html($value[0]); ?></label>
<?php		
		}
?>
							</div>
						</li>	   
						<li>
							<h5><?php esc_html_e('Departure date and time','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Departure date and time.','boat-charter-booking-system'); ?></span>
							<div class="to-field-disabled">
								<?php echo esc_html($Date->formatDateToDisplay($this->data['meta']['departure_date']).' '.$Date->formatTimeToDisplay($this->data['meta']['departure_time']));  ?>
							</div>
						</li> 
<?php
		if((int)$this->data['meta']['all_marina_departure_selected']===0)
		{
?>
						<li>
							<h5><?php esc_html_e('Departure marina','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Departure marina.','boat-charter-booking-system'); ?></span>
							<div class="to-field-disabled">
								<?php echo esc_html($this->data['meta']['marina_departure_name']);  ?> 
								<div class="to-float-right"><?php edit_post_link(esc_html__('Edit','boat-charter-booking-system'),null,null,$this->data['meta']['marina_departure_id']); ?></div>
							</div>
						</li>	
<?php
		}
?>
						<li>
							<h5><?php esc_html_e('Return date and time','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Return date and time.','boat-charter-booking-system'); ?></span>
							<div class="to-field-disabled">
								<?php echo esc_html($Date->formatDateToDisplay($this->data['meta']['return_date']).' '.$Date->formatTimeToDisplay($this->data['meta']['return_time']));  ?>
							</div>
						</li> 
<?php
		if((int)$this->data['meta']['all_marina_return_selected']===0)
		{
?>
						<li>
							<h5><?php esc_html_e('Return marina','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Return marina.','boat-charter-booking-system'); ?></span>
							<div class="to-field-disabled">
								<?php echo esc_html($this->data['meta']['marina_return_name']);  ?>
								<div class="to-float-right"><?php edit_post_link(esc_html__('Edit','boat-charter-booking-system'),null,null,$this->data['meta']['marina_return_id']); ?></div>
							</div>
						</li>		
<?php
		}
?>
						<li>
							<h5><?php esc_html_e('Order total amount','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Order total amount.','boat-charter-booking-system'); ?></span>
							<div class="to-field-disabled">
								<?php echo esc_html($this->data['billing']['summary']['value_gross_format_2']);  ?>
							</div>
						</li>  
<?php
		if((int)$this->data['meta']['payment_deposit_type']!==0)
		{
?>
						<li>
							<h5><?php esc_html_e('To Pay','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('To Pay (deposit).','boat-charter-booking-system'); ?>
							</span>
							<div class="to-field-disabled">
								<?php echo esc_html(BCBSPrice::format($this->data['billing']['summary']['pay'],$this->data['meta']['currency_id']));  ?>
							</div>
						</li>			  
<?php		  
		}

		if($Validation->isNotEmpty($this->data['meta']['comment']))
		{
?>
						<li>
							<h5><?php esc_html_e('Comments to order','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Client comments.','boat-charter-booking-system'); ?></span>
							<div class="to-field-disabled">
								<?php echo esc_html($this->data['meta']['comment']);  ?>
							</div>
						</li>						 
<?php
		}
		if($Validation->isNotEmpty($this->data['meta']['coupon_code']))
		{
?>
						<li>
							<h5><?php esc_html_e('Coupon code','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Coupon code.','boat-charter-booking-system'); ?></span>
							<div class="to-field-disabled">
								<?php echo esc_html($this->data['meta']['coupon_code']);  ?>
							</div>
						</li>  
						<li>
							<h5><?php esc_html_e('Percentage discount','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Percentage discount.','boat-charter-booking-system'); ?></span>
							<div class="to-field-disabled">
								<?php echo esc_html($this->data['meta']['coupon_discount_percentage']);  ?>%
							</div>
						</li>  
<?php
		}
?>
					</ul>
				</div>
				<div id="meta-box-booking-2">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Billing','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Billing.','boat-charter-booking-system'); ?></span>
							<div>	
								<table class="to-table">
									<tr>
										<th style="width:5%">
											<div>
												<?php esc_html_e('ID','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('ID.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:25%">
											<div>
												<?php esc_html_e('Item','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Name of the item.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>										
										<th style="width:10%">
											<div>
												<?php esc_html_e('Unit','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Name of the unit.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:10%" class="to-align-right">
											<div>
												<?php esc_html_e('Quantity','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Quantity.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th> 
										<th style="width:10%" class="to-align-right">
											<div>
												<?php esc_html_e('Price','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Net unit price.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>	 
										<th style="width:10%" class="to-align-right">
											<div>
												<?php esc_html_e('Value','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Net value.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>  
										<th style="width:15%" class="to-align-right">
											<div>
												<?php esc_html_e('Tax','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Tax rate in percentage.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>	  
										<th style="width:15%" class="to-align-right">
											<div>
												<?php esc_html_e('Total amount','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Total gross amount.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>											 
									</tr>
<?php
		$i=0;
		foreach($this->data['billing']['detail'] as $index=>$value)
		{
?>		   
									<tr>
										<td>
											<div>
												<?php echo esc_html(++$i); ?>
											</div>
										</td>
										<td>
											<div>
												<?php echo esc_html($value['name']); ?>
											</div>
										</td>										
										<td>
											<div>
												<?php echo esc_html($value['unit']); ?>
											</div>
										</td>												
										<td class="to-align-right">
											<div>
												<?php echo esc_html($value['quantity']); ?>
											</div>
										</td>	 
										<td class="to-align-right">
											<div>
												<?php echo esc_html($value['price_net_format_1']); ?>
											</div>
										</td>											 
										<td class="to-align-right">
											<div>
												<?php echo esc_html($value['value_net_format_1']); ?>
											</div>
										</td>  
										<td class="to-align-right">
											<div>
												<?php echo esc_html($value['tax_value_format_1']); ?>
											</div>
										</td>  
										<td class="to-align-right">
											<div>
												<?php echo esc_html($value['value_gross_format_1']); ?>
											</div>
										</td>	  
									</tr>			
<?php
		}
?>
									<tr>
										<td><div>-</div></td>
										<td><div>-</div></td>
										<td><div>-</div></td>
										<td class="to-align-right"><div>-</div></td>
										<td class="to-align-right"><div>-</div></td>
										<td class="to-align-right">
											<div>
												<?php echo esc_html($this->data['billing']['summary']['value_net_format_1']); ?>
											</div>
										</td>  
										<td class="to-align-right"><div>-</div></td>
										<td class="to-align-right">
											<div>
												<?php echo esc_html($this->data['billing']['summary']['value_gross_format_2']); ?>
											</div>
										</td>	  
									</tr> 
								</table>
							</div>
						</li>	  
					</ul>
				</div>
				<div id="meta-box-booking-3">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Name','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Boat name.','boat-charter-booking-system'); ?></span>
							<div class="to-field-disabled">
								<?php echo esc_html($this->data['meta']['boat_name']) ?>
								<div class="to-float-right"><?php edit_post_link(esc_html__('Edit','boat-charter-booking-system'),null,null,$this->data['meta']['boat_id']); ?></div>
							</div>
						</li> 
						<li>
							<h5><?php esc_html_e('Boat prices','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Base prices of the boat.','boat-charter-booking-system'); ?></span>
							<div>	
								<table class="to-table">
									<tr>
										<th style="width:30%">
											<div>
												<?php esc_html_e('Price name','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Price name.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:40%">
											<div>
												<?php esc_html_e('Value','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Value.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:40%">
											<div>
												<?php esc_html_e('Tax rate','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Tax rate.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
									</tr>
<?php
		foreach($PriceRule->getPriceUseType() as $index=>$value)
		{
?>
									<tr>
										<td>
											<div><?php echo esc_html($value[0]) ?></div>
										</td>
										<td>
											<div class="to-clear-fix">
												<div class="to-field-disabled">
													<?php echo BCBSPrice::format($this->data['meta']['price_'.$index.'_value'],$this->data['meta']['currency_id']); ?>
												</div>
											</div>
										</td>
										<td>
											<div class="to-clear-fix">
												<div class="to-field-disabled">
													<?php echo esc_html($this->data['meta']['price_'.$index.'_tax_rate_value'].'%'); ?>
												</div>
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
				</div>
				<div id="meta-box-booking-4">
<?php
			if(count($this->data['meta']['booking_extra']))
			{
?>
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Booking extras','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('List of add-ons ordered.','boat-charter-booking-system'); ?></span>
							<div>	
								<table class="to-table">
									<tr>
										<th style="width:40%">
											<div>
												<?php esc_html_e('Name','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Name.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th class="to-align-right" style="width:10%">
											<div>
												<?php esc_html_e('Quantity','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Quantity.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th class="to-align-right" style="width:10%">
											<div>
												<?php esc_html_e('Price','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Net unit price.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th class="to-align-right" style="width:10%">
											<div>
												<?php esc_html_e('Value','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Net value.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th class="to-align-right" style="width:10%">
											<div>
												<?php esc_html_e('Tax','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Tax rate in percentage.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th class="to-align-right" style="width:10%">
											<div>
												<?php esc_html_e('Total amount','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Total gross amount.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>										
									</tr> 
<?php
				foreach($this->data['billing']['detail'] as $index=>$value)
				{
					if($value['type']=='booking_extra')
					{
?>
									<tr>
										<td style="width:40%">
											<div>
												<?php echo esc_html($value['name']); ?>
												<div class="to-float-right"><?php edit_post_link(esc_html__('Edit','boat-charter-booking-system'),null,null,$value['id']); ?></div>
											</div>
										</td>
										<td class="to-align-right" style="width:10%">
											<div>
												<?php echo esc_html($value['quantity']); ?>
											</div>
										</td>
										<td class="to-align-right" style="width:10%">
											<div>
												<?php echo esc_html($value['price_net_format_1']); ?>
											</div>
										</td>										
										<td class="to-align-right" style="width:10%">
											<div>
												<?php echo esc_html($value['value_net_format_1']); ?>
											</div>
										</td>											
										<td class="to-align-right" style="width:15%">
											<div>
												<?php echo esc_html($value['tax_value_format_1']); ?>
											</div>
										</td>											
										<td class="to-align-right" style="width:15%">
											<div>
												<?php echo esc_html($value['value_gross_format_1']); ?>
											</div>
										</td>											  
									</tr>	  
<?php			  
					}
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
				<div id="meta-box-booking-5">
				   <ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Client details','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Client contact details.','boat-charter-booking-system'); ?><br/>
							</span>
							<div>
								<span class="to-legend-field"><?php esc_html_e('First name:','boat-charter-booking-system'); ?></span>
								<div class="to-field-disabled"><?php echo esc_html($this->data['meta']['client_contact_detail_first_name']) ?></div>								
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Last name:','boat-charter-booking-system'); ?></span>
								<div class="to-field-disabled"><?php echo esc_html($this->data['meta']['client_contact_detail_last_name']) ?></div>								
							</div>								
							<div>
								<span class="to-legend-field"><?php esc_html_e('E-mail address:','boat-charter-booking-system'); ?></span>
								<div class="to-field-disabled"><?php echo esc_html($this->data['meta']['client_contact_detail_email_address']) ?></div>								
							</div>									
							<div>
								<span class="to-legend-field"><?php esc_html_e('Phone number:','boat-charter-booking-system'); ?></span>
								<div class="to-field-disabled"><?php echo esc_html($this->data['meta']['client_contact_detail_phone_number']) ?></div>								
							</div> 
<?php
		echo BCBSBookingFormElement::displayFieldS(1,$this->data['meta']);
?>
						</li>
<?php
		if((int)$this->data['meta']['client_billing_detail_enable']===1)
		{
?>
						<li>
							<h5><?php esc_html_e('Billing address','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Billing address details.','boat-charter-booking-system'); ?><br/>
							</span>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Company name:','boat-charter-booking-system'); ?></span>
								<div class="to-field-disabled"><?php echo esc_html($this->data['meta']['client_billing_detail_company_name']) ?></div>								
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Tax number:','boat-charter-booking-system'); ?></span>
								<div class="to-field-disabled"><?php echo esc_html($this->data['meta']['client_billing_detail_tax_number']) ?></div>								
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Street name:','boat-charter-booking-system'); ?></span>
								<div class="to-field-disabled"><?php echo esc_html($this->data['meta']['client_billing_detail_street_name']) ?></div>								
							</div>						   
							<div>
								<span class="to-legend-field"><?php esc_html_e('Street number:','boat-charter-booking-system'); ?></span>
								<div class="to-field-disabled"><?php echo esc_html($this->data['meta']['client_billing_detail_street_number']) ?></div>								
							</div>		  
							<div>
								<span class="to-legend-field"><?php esc_html_e('City:','boat-charter-booking-system'); ?></span>
								<div class="to-field-disabled"><?php echo esc_html($this->data['meta']['client_billing_detail_city']) ?></div>								
							</div>		  
							<div>
								<span class="to-legend-field"><?php esc_html_e('State:','boat-charter-booking-system'); ?></span>
								<div class="to-field-disabled"><?php echo esc_html($this->data['meta']['client_billing_detail_state']) ?></div>								
							</div>	
							<div>
								<span class="to-legend-field"><?php esc_html_e('Postal code:','boat-charter-booking-system'); ?></span>
								<div class="to-field-disabled"><?php echo esc_html($this->data['meta']['client_billing_detail_postal_code']) ?></div>								
							</div>	
							<div>
								<span class="to-legend-field"><?php esc_html_e('Country:','boat-charter-booking-system'); ?></span>
								<div class="to-field-disabled"><?php echo esc_html($this->data['client_billing_detail_country_name']) ?></div>								
							</div>	  
<?php
			echo BCBSBookingFormElement::displayFieldS(2,$this->data['meta']);
?>
						</li>
<?php		  
		}

		$panel=$BookingFormElement->getPanel($this->data['meta']);

		foreach($panel as $panelIndex=>$panelValue)
		{
			if(in_array($panelValue['id'],array(1,2))) continue;
?>
						<li>
							<h5><?php echo esc_html($panelValue['label']); ?></h5>
							<span class="to-legend">
								<?php echo esc_html($panelValue['label']); ?>
							</span>							
							<?php echo BCBSBookingFormElement::displayFieldS($panelValue['id'],$this->data['meta']); ?>
						</li>	
<?php
		}
?>
					</ul>
				</div>
				<div id="meta-box-booking-6">
<?php
		if($Validation->isNotEmpty($this->data['meta']['payment_name']))
		{
?>
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Payment details','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Payment details.','boat-charter-booking-system'); ?><br/>
							</span>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Payment method:','boat-charter-booking-system'); ?></span>
								<div class="to-field-disabled"><?php echo esc_html($this->data['meta']['payment_name']) ?></div>								
							</div>
						</li>
<?php
            if(in_array($this->data['meta']['payment_id'],array(2,3)))
            {
?>
                        <li>
                            <h5><?php esc_html_e('Transactions','boat-charter-booking-system'); ?></h5>
                            <span class="to-legend">
                                <?php esc_html_e('List of registered transactions for this payment.','boat-charter-booking-system'); ?><br/>
                            </span>
<?php
				if(array_key_exists('payment_stripe_data',$this->data['meta']))
				{
					if((is_array($this->data['meta']['payment_stripe_data'])) && (count($this->data['meta']['payment_stripe_data'])))
					{
?>						
                            <div>	
                                <table class="to-table to-table-fixed-layout">
                                     <thead>
                                        <tr>
                                            <th style="width:15%">
                                                <div>
                                                    <?php esc_html_e('Transaction ID','boat-charter-booking-system'); ?>
                                                    <span class="to-legend"><?php esc_html_e('Transaction ID.','boat-charter-booking-system'); ?></span>
                                                </div>
                                            </th>
                                            <th style="width:15%">
                                                <div>
                                                    <?php esc_html_e('Type','boat-charter-booking-system'); ?>
                                                    <span class="to-legend"><?php esc_html_e('Type.','boat-charter-booking-system'); ?></span>
                                                </div>
                                            </th>
                                            <th style="width:15%">
                                                <div>
                                                    <?php esc_html_e('Date','boat-charter-booking-system'); ?>
                                                    <span class="to-legend"><?php esc_html_e('Date.','boat-charter-booking-system'); ?></span>
                                                </div>
                                            </th>	
                                            <th style="width:55%">
                                                <div>
                                                    <?php esc_html_e('Details','boat-charter-booking-system'); ?>
                                                    <span class="to-legend"><?php esc_html_e('Status.','boat-charter-booking-system'); ?></span>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>	
                                    <tbody>
<?php
						foreach($this->data['meta']['payment_stripe_data'] as $index=>$value)
						{
?>
                                        <tr>
                                            <td><div><?php echo esc_html($value->id); ?></div></td>
                                            <td><div><?php echo esc_html($value->type); ?></div></td>
                                            <td><div><?php echo esc_html(date_i18n(BCBSOption::getOption('date_format').' '.BCBSOption::getOption('time_format'),$value->created)); ?></div></td>
                                            <td>
												<div class="to-toggle-details">
													<a href="#"><?php esc_html_e('Toggle details','boat-charter-booking-system'); ?></a>
													<div class="to-hidden">
														<pre>
															<?php var_dump($value); ?>
														</pre>
													</div>
												</div>
											</td>
                                        </tr>
<?php
						}
?>
                                    </tbody>
								</table>
							</div>
<?php						
					}
				}
				else if(array_key_exists('payment_paypal_data',$this->data['meta']))
				{
					if((is_array($this->data['meta']['payment_paypal_data'])) && (count($this->data['meta']['payment_paypal_data'])))
					{
?>

                            <div>	
                                <table class="to-table">
                                    <thead>
                                        <tr>
                                            <th style="width:15%">
                                                <div>
                                                    <?php esc_html_e('Transaction ID','boat-charter-booking-system'); ?>
                                                    <span class="to-legend"><?php esc_html_e('Transaction ID.','boat-charter-booking-system'); ?></span>
                                                </div>
                                            </th>
                                            <th style="width:15%">
                                                <div>
                                                    <?php esc_html_e('Status','boat-charter-booking-system'); ?>
                                                    <span class="to-legend"><?php esc_html_e('Type.','boat-charter-booking-system'); ?></span>
                                                </div>
                                            </th>
                                            <th style="width:15%">
                                                <div>
                                                    <?php esc_html_e('Date','boat-charter-booking-system'); ?>
                                                    <span class="to-legend"><?php esc_html_e('Date.','boat-charter-booking-system'); ?></span>
                                                </div>
                                            </th>	
                                            <th style="width:55%">
                                                <div>
                                                    <?php esc_html_e('Details','boat-charter-booking-system'); ?>
                                                    <span class="to-legend"><?php esc_html_e('Details.','boat-charter-booking-system'); ?></span>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
						foreach($this->data['meta']['payment_paypal_data'] as $index=>$value)
						{
?>
                                        <tr>
                                            <td><div><?php echo esc_html($value['txn_id']); ?></div></td>
                                            <td><div><?php echo esc_html($value['payment_status']); ?></div></td>
                                            <td><div><?php echo esc_html($value['payment_date']); ?></div></td>
											<td>
												<div class="to-toggle-details">
													<a href="#"><?php esc_html_e('Toggle details','boat-charter-booking-system'); ?></a>
													<div class="to-hidden">
														<pre>
															<?php var_dump($value); ?>
														</pre>
													</div>
												</div>
											</td>
                                        </tr>
<?php
						}
?>
                                    </tbody>
                                </table>
                            </div>
<?php				
					}
				}
?>
						</li>
<?php				
			}
?>
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
				
				$('.to-toggle-details>a').on('click',function(e)
				{
					e.preventDefault();
					$(this).parents('td:first').css('max-width','0px');
					$(this).next('div').toggleClass('to-hidden');
				});
			});
		</script>