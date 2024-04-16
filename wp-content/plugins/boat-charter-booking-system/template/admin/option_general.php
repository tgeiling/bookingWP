		<ul class="to-form-field-list">
			<li>
				<h5><?php esc_html_e('Billing type','boat-charter-booking-system'); ?></h5>
				<span class="to-legend"><?php esc_html_e('Select billing type.','boat-charter-booking-system'); ?></span>
				<div class="to-clear-fix">
					<select name="<?php BCBSHelper::getFormName('billing_type'); ?>" id="<?php BCBSHelper::getFormName('billing_type'); ?>">
<?php
		foreach($this->data['dictionary']['billing_type'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['option']['billing_type'],$index,false)).'>'.esc_html($value[0]).'</option>';
?>
					</select>
				</div>
			</li>
			<li>
				<h5><?php esc_html_e('Logo','boat-charter-booking-system'); ?></h5>
				<span class="to-legend"><?php esc_html_e('Select company logo.','boat-charter-booking-system'); ?></span>
				<div class="to-clear-fix">
					<input type="text" name="<?php BCBSHelper::getFormName('logo'); ?>" id="<?php BCBSHelper::getFormName('logo'); ?>" class="to-float-left" value="<?php echo esc_attr($this->data['option']['logo']); ?>"/>
					<input type="button" name="<?php BCBSHelper::getFormName('logo_browse'); ?>" id="<?php BCBSHelper::getFormName('logo_browse'); ?>" class="to-button-browse to-button" value="<?php esc_attr_e('Browse','boat-charter-booking-system'); ?>"/>
				</div>
			</li> 
			<li>
				<h5><?php esc_html_e('Google Maps API key','boat-charter-booking-system'); ?></h5>
				<span class="to-legend">
					<?php echo sprintf(esc_html__('You can generate your own key %s.','boat-charter-booking-system'),'<a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">'.esc_html__('here','boat-charter-booking-system').'</a>'); ?><br/>
					<?php esc_html_e('You have to enable libraries: Places, Maps JavaScript, Roads, Geocoding, Directions. ','boat-charter-booking-system'); ?>
				</span>
				<div class="to-clear-fix">
					<input type="text" name="<?php BCBSHelper::getFormName('google_map_api_key'); ?>" id="<?php BCBSHelper::getFormName('google_map_api_key'); ?>" value="<?php echo esc_attr($this->data['option']['google_map_api_key']); ?>"/>
				</div>
			</li>  
			<li>
				<h5><?php esc_html_e('Remove duplicated Google Maps scripts','boat-charter-booking-system'); ?></h5>
				<span class="to-legend">
					<?php esc_html_e('Enable this option to remove Google Maps script from theme and other, included plugins.','boat-charter-booking-system'); ?><br/>
					<?php esc_html_e('This option allows to prevent errors related with including the same script more than once.','boat-charter-booking-system'); ?>
				</span>
				<div class="to-clear-fix">
					 <div class="to-radio-button">
						<input type="radio" value="1" id="<?php BCBSHelper::getFormName('google_map_duplicate_script_remove_1'); ?>" name="<?php BCBSHelper::getFormName('google_map_duplicate_script_remove'); ?>" <?php BCBSHelper::checkedIf($this->data['option']['google_map_duplicate_script_remove'],1); ?>/>
						<label for="<?php BCBSHelper::getFormName('google_map_duplicate_script_remove_1'); ?>"><?php esc_html_e('Enable (remove)','boat-charter-booking-system'); ?></label>
						<input type="radio" value="0" id="<?php BCBSHelper::getFormName('google_map_duplicate_script_remove_0'); ?>" name="<?php BCBSHelper::getFormName('google_map_duplicate_script_remove'); ?>" <?php BCBSHelper::checkedIf($this->data['option']['google_map_duplicate_script_remove'],0); ?>/>
						<label for="<?php BCBSHelper::getFormName('google_map_duplicate_script_remove_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
					</div>
				</div>
			</li>	 
			<li>
				<h5><?php esc_html_e('Currency','boat-charter-booking-system'); ?></h5>
				<span class="to-legend"><?php esc_html_e('Currency.','boat-charter-booking-system'); ?></span>
				<div class="to-clear-fix">
					<select name="<?php BCBSHelper::getFormName('currency'); ?>" id="<?php BCBSHelper::getFormName('currency'); ?>">
<?php
		foreach($this->data['dictionary']['currency'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['option']['currency'],$index,false)).'>'.esc_html($index.' ('.$value['name'].')').'</option>';
?>
					</select>
				</div>
			</li>
			<li>
				<h5><?php esc_html_e('Date format','boat-charter-booking-system'); ?></h5>
				<span class="to-legend"><?php echo sprintf(esc_html__('Select the date format to be displayed. More info you can find here %s.','boat-charter-booking-system'),'<a href="https://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">Formatting Date and Time</a>'); ?></span>
				<div class="to-clear-fix">
					<input type="text" name="<?php BCBSHelper::getFormName('date_format'); ?>" id="<?php BCBSHelper::getFormName('date_format'); ?>" value="<?php echo esc_attr($this->data['option']['date_format']); ?>"/>
				</div>
			</li>  
			<li>
				<h5><?php esc_html_e('Time format','boat-charter-booking-system'); ?></h5>
				<span class="to-legend"><?php echo sprintf(esc_html__('Select the time format to be displayed. More info you can find here %s.','boat-charter-booking-system'),'<a href="https://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">Formatting Date and Time</a>'); ?></span>
				<div class="to-clear-fix">
					<input type="text" name="<?php BCBSHelper::getFormName('time_format'); ?>" id="<?php BCBSHelper::getFormName('time_format'); ?>" value="<?php echo esc_attr($this->data['option']['time_format']); ?>"/>
				</div>
			</li>			   
			<li>
				<h5><?php esc_html_e('Default sender e-mail account','boat-charter-booking-system'); ?></h5>
				<span class="to-legend">
					<?php esc_html_e('Select default e-mail account.','boat-charter-booking-system'); ?><br/>
					<?php esc_html_e('It will be used to sending email messages to clients about changing of booking status.','boat-charter-booking-system'); ?>
				</span>
				<div class="to-clear-fix">
					<select name="<?php BCBSHelper::getFormName('sender_default_email_account_id'); ?>" id="<?php BCBSHelper::getFormName('sender_default_email_account_id'); ?>">
<?php
		echo '<option value="-1" '.(BCBSHelper::selectedIf($this->data['option']['sender_default_email_account_id'],-1,false)).'>'.esc_html__('- Not set -','boat-charter-booking-system').'</option>';
		foreach($this->data['dictionary']['email_account'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['option']['sender_default_email_account_id'],$index,false)).'>'.esc_html($value['post']->post_title).'</option>';
?>
					</select>
				</div>
			</li>
			<li>
				<h5><?php esc_html_e('Geolocation server','boat-charter-booking-system'); ?></h5>
				<span class="to-legend">
					<?php esc_html_e('Select which servers has to handle geolocation requests.','boat-charter-booking-system'); ?><br/>
					<?php esc_html_e('For some of them, set up extra data could be needed.','boat-charter-booking-system'); ?><br/>
				</span>
				<div class="to-clear-fix">
					<span class="to-legend-field"><?php esc_html_e('Server:','boat-charter-booking-system'); ?></span>
					<div>
						<select name="<?php BCBSHelper::getFormName('geolocation_server_id'); ?>" id="<?php BCBSHelper::getFormName('geolocation_server_id'); ?>">
							<?php
									echo '<option value="-1" '.(BCBSHelper::selectedIf($this->data['option']['geolocation_server_id'],-1,false)).'>'.esc_html__('- Not set -','boat-charter-booking-system').'</option>';
									foreach($this->data['dictionary']['geolocation_server'] as $index=>$value)
									echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['option']['geolocation_server_id'],$index,false)).'>'.esc_html($value['name']).'</option>';
							?>
						</select>
					</div>
				</div>
				<div class="to-clear-fix">
					<span class="to-legend-field"><?php esc_html_e('API key for ipstack server:','boat-charter-booking-system'); ?></span>
					<div>
						<input type="text" name="<?php BCBSHelper::getFormName('geolocation_server_id_3_api_key'); ?>" id="<?php BCBSHelper::getFormName('geolocation_server_id_3_api_key'); ?>" value="<?php echo esc_attr($this->data['option']['geolocation_server_id_3_api_key']); ?>"/>
					</div>
				</div>
			</li> 
			<li>
				<h5><?php esc_html_e('WooCommerce new order attachment','boat-charter-booking-system'); ?></h5>
				<span class="to-legend"><?php esc_html_e('Select file which will be added to the new order e-mail message sent by wooCommerce.','boat-charter-booking-system'); ?></span>
				<div class="to-clear-fix">
					<input type="hidden" name="<?php BCBSHelper::getFormName('attachment_woocommerce_email'); ?>" id="<?php BCBSHelper::getFormName('attachment_woocommerce_email'); ?>" value="<?php echo esc_attr($this->data['option']['attachment_woocommerce_email']); ?>"/>
					<input type="button" name="<?php BCBSHelper::getFormName('attachment_woocommerce_email_browse'); ?>" id="<?php BCBSHelper::getFormName('attachment_woocommerce_email_browse'); ?>" class="to-button-browse to-button" value="<?php esc_attr_e('Browse','boat-charter-booking-system'); ?>"/>
				</div>
			</li>  
			<li>
				<h5><?php esc_html_e('Booking report','boat-charter-booking-system'); ?></h5>
				<span class="to-legend">
					<?php esc_html_e('Enable or disable sending (via e-mail) message with complete list of boats which will be received and returned for current day.','boat-charter-booking-system'); ?><br/>
				</span>
				<div class="to-clear-fix">
					<span class="to-legend-field"><?php esc_html_e('Status:','boat-charter-booking-system'); ?></span>
					<div class="to-clear-fix">
						<div class="to-radio-button">
							<input type="radio" value="1" id="<?php BCBSHelper::getFormName('email_report_status_1'); ?>" name="<?php BCBSHelper::getFormName('email_report_status'); ?>" <?php BCBSHelper::checkedIf($this->data['option']['email_report_status'],1); ?>/>
							<label for="<?php BCBSHelper::getFormName('email_report_status_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
							<input type="radio" value="0" id="<?php BCBSHelper::getFormName('email_report_status_0'); ?>" name="<?php BCBSHelper::getFormName('email_report_status'); ?>" <?php BCBSHelper::checkedIf($this->data['option']['email_report_status'],0); ?>/>
							<label for="<?php BCBSHelper::getFormName('email_report_status_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
						</div>
					</div>
				</div>
				<div class="to-clear-fix">
					<span class="to-legend-field"><?php esc_html_e('Sender account:','boat-charter-booking-system'); ?></span>
					<div class="to-clear-fix">
						<select name="<?php BCBSHelper::getFormName('email_report_sender_email_account_id'); ?>" id="<?php BCBSHelper::getFormName('email_report_sender_email_account_id'); ?>">
<?php
		echo '<option value="-1" '.(BCBSHelper::selectedIf($this->data['option']['email_report_sender_email_account_id'],-1,false)).'>'.esc_html__('- Not set -','boat-charter-booking-system').'</option>';
		foreach($this->data['dictionary']['email_account'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['option']['email_report_sender_email_account_id'],$index,false)).'>'.esc_html($value['post']->post_title).'</option>';
?>
						</select> 
					</div>
				</div>
				<div class="to-clear-fix">
					<span class="to-legend-field"><?php esc_html_e('List of recipients e-mail addresses separated by semicolon:','boat-charter-booking-system'); ?></span>
					<div class="to-clear-fix">
						<input type="text" name="<?php BCBSHelper::getFormName('email_report_recipient_email_address'); ?>" id="<?php BCBSHelper::getFormName('email_report_recipient_email_address'); ?>" value="<?php echo esc_attr($this->data['option']['email_report_recipient_email_address']); ?>"/>
					</div>						
				</div>
				<div class="to-clear-fix">
					<span class="to-legend-field"><?php esc_html_e('Cron event:','boat-charter-booking-system'); ?></span>
					<div class="to-field-disabled to-width-100">
<?php
		$command='59 23 * * * wget -O '.get_site_url().'?bcbs_run_code='.BCBSOption::getOption('run_code').' >/dev/null 2>&1';
		echo $command;
		echo '<a href="#" class="to-copy-to-clipboard to-float-right" data-clipboard-text="'.esc_attr($command).'" data-label-on-success="'.esc_attr__('Copied!','boat-charter-booking-system').'">'.esc_html__('Copy','boat-charter-booking-system').'</a>';
?>
					</div>						
				</div>	
			</li>
			<li>
				<h5><?php esc_html_e('Fixer.io API key','boat-charter-booking-system'); ?></h5>
				<span class="to-legend">
					<?php echo sprintf(esc_html__('Enter API key generated by %s.','boat-charter-booking-system'),'<a href="https://fixer.io/" target="_blank">Fixer.io</a>'); ?><br/>
				</span>
				<div class="to-clear-fix">
					<input type="text" name="<?php BCBSHelper::getFormName('fixer_io_api_key'); ?>" id="<?php BCBSHelper::getFormName('fixer_io_api_key'); ?>" value="<?php echo esc_attr($this->data['option']['fixer_io_api_key']); ?>"/>
				</div>
			</li>  
			<li>
				<h5><?php esc_html_e('Non-blocking booking statues','boat-charter-booking-system'); ?></h5>
				<span class="to-legend">
					<?php esc_html_e('Selected these statuses which don\'t block date/time during checking vehicle availability based on past bookings.','boat-charter-booking-system'); ?>
				</span>
				<div class="to-checkbox-button">
<?php
		foreach($this->data['dictionary']['booking_status'] as $index=>$value)
		{
?>
					<input type="checkbox" value="<?php echo esc_attr($index); ?>" id="<?php BCBSHelper::getFormName('booking_status_nonblocking_'.$index); ?>" name="<?php BCBSHelper::getFormName('booking_status_nonblocking[]'); ?>" <?php BCBSHelper::checkedIf($this->data['option']['booking_status_nonblocking'],$index); ?>/>
					<label for="<?php BCBSHelper::getFormName('booking_status_nonblocking_'.$index); ?>"><?php echo esc_html($value[0]); ?></label>
<?php		
		}
?>
				</div>
			</li>
		</ul>