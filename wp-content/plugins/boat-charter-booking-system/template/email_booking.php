<?php
		$Date=new BCBSDate();
		$Validation=new BCBSValidation();
		$BookingFormElement=new BCBSBookingFormElement();
		
		if((int)$this->data['document_header_exclude']!==1)
		{
?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">

			<head>
<?php
			if(is_rtl())
			{
?>
				<style>
					body
					{
						direction:rtl;
					}
				</style>
<?php		
			}
?>
			</head>

			<body>
<?php
		}
?>
				<table cellspacing="0" cellpadding="0" width="100%" bgcolor="#EEEEEE" <?php echo BCBSEmail::displayStyle('base',1); ?>>
					
					<tr height="50px"><td></td></tr>
					
					<tr>
						
						<td>
							
							<table cellspacing="0" cellpadding="0" width="600px" border="0" align="center" bgcolor="#FFFFFF" <?php echo BCBSEmail::displayStyle('table',1); ?>>
							
<?php
		if((int)$this->data['document_header_exclude']!==1)
		{
			$logo=BCBSOption::getOption('logo');
			if($Validation->isNotEmpty($logo))
			{
?>
								<tr>
									<td>
										<img <?php echo BCBSEmail::displayStyle('logo',1); ?> src="<?php echo esc_attr($logo); ?>" alt=""/>
										<br/><br/>
									</td>
								</tr>						   
<?php
			}
		}
?>
								
								<tr>
									<td <?php echo BCBSEmail::displayStyle('header'); ?>><?php esc_html_e('General','boat-charter-booking-system'); ?></td>
								</tr>
								<tr><td <?php echo BCBSEmail::displayStyle('separator',3); ?>><td></tr>
								<tr>
									<td>
										<table cellspacing="0" cellpadding="0">
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('Title','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo wp_kses($this->data['booking']['booking_title'],array('a'=>array('href'))); ?></td>
											</tr>											
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('Status','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html($this->data['booking']['booking_status_name']); ?></td>
											</tr>
<?php
		if((int)$this->data['meta']['all_marina_departure_selected']===0)
		{
?>
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('Departure marina','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html($this->data['booking']['meta']['marina_departure_name']); ?></td>
											</tr>	
<?php
		}
?>
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('Departure date and time','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html(trim($Date->formatDateToDisplay($this->data['booking']['meta']['departure_date']).' '.$Date->formatTimeToDisplay($this->data['booking']['meta']['departure_time']))); ?></td>
											</tr>	
<?php
		if((int)$this->data['meta']['all_marina_return_selected']===0)
		{
?>
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('Return marina','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html($this->data['booking']['meta']['marina_return_name']); ?></td>
											</tr>	  
<?php
		}
?>
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('Return date and time','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html(trim($Date->formatDateToDisplay($this->data['booking']['meta']['return_date']).' '.$Date->formatTimeToDisplay($this->data['booking']['meta']['return_time']))); ?></td>
											</tr>
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('Rental period','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html($this->data['booking']['rental_period_label']); ?></td>
											</tr>
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('Order total amount','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html($this->data['booking']['billing']['summary']['value_gross_format_2']); ?></td>
											</tr>	
<?php
		if((int)$this->data['booking']['meta']['payment_deposit_type']!==0)
		{
?>
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('To Pay (deposit)','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html($this->data['booking']['billing']['summary']['pay_format_2']); ?></td>
											</tr>	
<?php		  
		}
		if($Validation->isNotEmpty($this->data['booking']['meta']['comment']))
		{
?>											
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('Comment','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html($this->data['booking']['meta']['comment']); ?></td>
											</tr>   
<?php
		}
?>
										</table>
									</td>
								</tr>
											
								<!-- -->
											
								<tr><td <?php echo BCBSEmail::displayStyle('separator',2); ?>><td></tr>
								<tr>
									<td <?php echo BCBSEmail::displayStyle('header'); ?>><?php esc_html_e('Boat','boat-charter-booking-system'); ?></td>
								</tr>
								<tr><td <?php echo BCBSEmail::displayStyle('separator',3); ?>><td></tr>
								<tr>
									<td>
										<table cellspacing="0" cellpadding="0">
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('Boat name','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html($this->data['booking']['meta']['boat_name']); ?></td>
											</tr>
										</table>
									</td>
								</tr>
											
								<!-- -->
											
<?php
		if(count($this->data['booking']['meta']['booking_extra']))
		{
?>											
								<tr><td <?php echo BCBSEmail::displayStyle('separator',2); ?>><td></tr>
								<tr>
									<td <?php echo BCBSEmail::displayStyle('header'); ?>><?php esc_html_e('Add-ons','boat-charter-booking-system'); ?></td>
								</tr>
								<tr><td <?php echo BCBSEmail::displayStyle('separator',3); ?>><td></tr>											
								<tr>
									<td>
										<table cellspacing="0" cellpadding="0">
											<tr>
												<td>
													<ol <?php echo BCBSEmail::displayStyle('list',1); ?>>
<?php
            foreach($this->data['booking']['billing']['detail'] as $index=>$value)
            {
				if($value['type']=='booking_extra')
				{
?>
														<li>
															<?php echo esc_html($value['quantity']); ?>
															<?php esc_html_e('x','boat-charter-booking-system'); ?>
															<?php echo esc_html($value['name']); ?> -
															<?php echo esc_html($value['value_gross_format_2']); ?>
														</li> 
<?php
				}
			}
?>
													</ol>
												</td>
											</tr>
										</table>
									</td>
								</tr>
<?php
		}
?>
											
								<!-- -->
											
								<tr><td <?php echo BCBSEmail::displayStyle('separator',2); ?>><td></tr>
								<tr>
									<td <?php echo BCBSEmail::displayStyle('header'); ?>><?php esc_html_e('Client details','boat-charter-booking-system'); ?></td>
								</tr>
								<tr><td <?php echo BCBSEmail::displayStyle('separator',3); ?>><td></tr>
								<tr>
									<td>
										<table cellspacing="0" cellpadding="0">
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('First name','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html($this->data['booking']['meta']['client_contact_detail_first_name']); ?></td>
											</tr>
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('Last name','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html($this->data['booking']['meta']['client_contact_detail_last_name']); ?></td>
											</tr>
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('E-mail address','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html($this->data['booking']['meta']['client_contact_detail_email_address']); ?></td>
											</tr>
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('Phone number','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html($this->data['booking']['meta']['client_contact_detail_phone_number']); ?></td>
											</tr>
<?php
		echo BCBSBookingFormElement::displayFieldS(1,$this->data['booking']['meta'],2,array('style'=>$this->data['style']));
?>
										</table>
									</td>
								</tr> 
											
								<!-- -->
											
<?php
		if((int)$this->data['booking']['meta']['client_billing_detail_enable']===1)
		{
?>											
								<tr><td <?php echo BCBSEmail::displayStyle('separator',2); ?>><td></tr>
								<tr>
									<td <?php echo BCBSEmail::displayStyle('header'); ?>><?php esc_html_e('Billing address','boat-charter-booking-system'); ?></td>
								</tr>
								<tr><td <?php echo BCBSEmail::displayStyle('separator',3); ?>><td></tr>
								<tr>
									<td>
										<table cellspacing="0" cellpadding="0">											
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('Company name','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html($this->data['booking']['meta']['client_billing_detail_company_name']); ?></td>
											</tr>
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('Tax number','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html($this->data['booking']['meta']['client_billing_detail_tax_number']); ?></td>
											</tr>
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('Street name','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html($this->data['booking']['meta']['client_billing_detail_street_name']); ?></td>
											</tr>
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('Street number','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html($this->data['booking']['meta']['client_billing_detail_street_number']); ?></td>
											</tr>
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('City','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html($this->data['booking']['meta']['client_billing_detail_city']); ?></td>
											</tr>
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('State','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html($this->data['booking']['meta']['client_billing_detail_state']); ?></td>
											</tr>
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('Postal code','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html($this->data['booking']['meta']['client_billing_detail_postal_code']); ?></td>
											</tr>
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('Country','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html($this->data['booking']['client_billing_detail_country_name']); ?></td>
											</tr>
<?php
		echo BCBSBookingFormElement::displayFieldS(2,$this->data['booking']['meta'],2,array('style'=>$this->data['style']));
?>
										</table>
									</td>
								</tr>  
<?php
		}

		$panel=$BookingFormElement->getPanel($this->data['booking']['meta']);

		foreach($panel as $panelIndex=>$panelValue)
		{
			if(in_array($panelValue['id'],array(1,2))) continue;
?>
								<tr><td <?php echo BCBSEmail::displayStyle('separator',2); ?>><td></tr>
								<tr>
									<td <?php echo BCBSEmail::displayStyle('header'); ?>><?php echo esc_html($panelValue['label']); ?></td>
								</tr>
								<tr><td <?php echo BCBSEmail::displayStyle('separator',3); ?>><td></tr>
								<tr>
									<td>
										<table cellspacing="0" cellpadding="0">   
<?php
			echo BCBSBookingFormElement::displayFieldS($panelValue['id'],$this->data['booking']['meta'],2,array('style'=>$this->data['style']));
?>											
										</table>
									</td>
								</tr>
<?php
		}
?>
											
								<!-- -->
								
<?php
		if($Validation->isNotEmpty($this->data['booking']['meta']['payment_name']))
		{
?>
								<tr><td <?php echo BCBSEmail::displayStyle('separator',2); ?>><td></tr>
								<tr>
									<td <?php echo BCBSEmail::displayStyle('header'); ?>><?php esc_html_e('Payment','boat-charter-booking-system'); ?></td>
								</tr>
								<tr><td <?php echo BCBSEmail::displayStyle('separator',3); ?>><td></tr>
								<tr>
									<td>
										<table cellspacing="0" cellpadding="0">
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('Payment','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html($this->data['booking']['meta']['payment_name']); ?></td>
											</tr>
										</table>
									</td>
								</tr>  
<?php	
		}
?>
							</table>

						</td>

					</tr>
					
					<tr height="50px"><td></td></tr>
		
				</table> 
<?php
		if((int)$this->data['document_header_exclude']!==1)
		{
?>				
			</body>

		</html>
<?php
		}