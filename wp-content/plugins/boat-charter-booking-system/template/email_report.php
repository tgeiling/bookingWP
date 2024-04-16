<?php
		$Date=new BCBSDate();
		$Validation=new BCBSValidation();
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

				<table cellspacing="0" cellpadding="0" width="100%" bgcolor="#EEEEEE" <?php echo BCBSEmail::displayStyle('base',1); ?>>
					
					<tr height="50px"><td></td></tr>
					
					<tr>
						
						<td>
							
							<table cellspacing="0" cellpadding="0" width="600px" border="0" align="center" bgcolor="#FFFFFF" <?php echo BCBSEmail::displayStyle('table',1); ?>>
							
								<!-- -->
								
<?php
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
?>
								
								<!-- -->
								
<?php
		$i=0;
		foreach($this->data['booking'] as $index=>$value)
		{
?>
								<tr>
									<td <?php echo BCBSEmail::displayStyle('header'); ?>><?php esc_html_e($value['post']->post_title); ?></td>
								</tr>
								<tr><td <?php echo BCBSEmail::displayStyle('separator',3); ?>><td></tr>
								<tr>
									<td>
										<table cellspacing="0" cellpadding="0">
<?php
		if((int)$value['meta']['all_marina_departure_selected']===0)
		{
?>
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('Departure marina','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html($value['meta']['marina_departure_name']); ?></td>
											</tr>	
<?php
		}
?>
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('Departure date and time','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html($Date->formatDateToDisplay($value['meta']['departure_date']).' '.$Date->formatTimeToDisplay($value['meta']['departure_time'])); ?></td>
											</tr>	
<?php
		if((int)$value['meta']['all_marina_return_selected']===0)
		{
?>
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('Return marina','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html($value['meta']['marina_return_name']); ?></td>
											</tr>	
<?php
		}
?>
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('Return date and time','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html($Date->formatDateToDisplay($value['meta']['return_date']).' '.$Date->formatTimeToDisplay($value['meta']['return_time'])); ?></td>
											</tr>
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('Boat name','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html($value['meta']['boat_name']); ?></td>
											</tr>
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('First name','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html($value['meta']['client_contact_detail_first_name']); ?></td>
											</tr>
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('Last name','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html($value['meta']['client_contact_detail_last_name']); ?></td>
											</tr>
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('E-mail address','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html($value['meta']['client_contact_detail_email_address']); ?></td>
											</tr>
											<tr>
												<td <?php echo BCBSEmail::displayStyle('cell',1); ?>><?php esc_html_e('Phone number','boat-charter-booking-system'); ?></td>
												<td <?php echo BCBSEmail::displayStyle('cell',2); ?>><?php echo esc_html($value['meta']['client_contact_detail_phone_number']); ?></td>
											</tr>
										</table>
									</td>
								</tr>
<?php
			if((++$i)!==count($this->data['booking']))
			{
?>
								<tr><td <?php echo BCBSEmail::displayStyle('separator',2); ?>><td></tr>
<?php
			}
		}
?>
							</table>

						</td>

					</tr>
					
					<tr height="50px"><td></td></tr>
		
				</table> 
		
			</body>

		</html>