<?php 
		echo BCBSHelper::displayNonce($this->data);
		global $post;
?>	
		<div class="to">
			<div class="ui-tabs">
				<ul>
					<li><a href="#meta-box-booking-form-1"><?php esc_html_e('General','boat-charter-booking-system'); ?></a></li>
					<li><a href="#meta-box-booking-form-2"><?php esc_html_e('Form elements','boat-charter-booking-system'); ?></a></li>
					<li><a href="#meta-box-booking-form-3"><?php esc_html_e('Styles','boat-charter-booking-system'); ?></a></li>
					<li><a href="#meta-box-booking-form-4"><?php esc_html_e('Google Maps','boat-charter-booking-system'); ?></a></li>
				</ul>
				<div id="meta-box-booking-form-1">
					<div class="ui-tabs">
						<ul>
							<li><a href="#meta-box-booking-form-1-1"><?php esc_html_e('Main','boat-charter-booking-system'); ?></a></li>
							<li><a href="#meta-box-booking-form-1-2"><?php esc_html_e('Marinas','boat-charter-booking-system'); ?></a></li>
							<li><a href="#meta-box-booking-form-1-3"><?php esc_html_e('Prices','boat-charter-booking-system'); ?></a></li>
							<li><a href="#meta-box-booking-form-1-4"><?php esc_html_e('Look & Feel','boat-charter-booking-system'); ?></a></li>
						</ul>
						<div id="meta-box-booking-form-1-1">
							<ul class="to-form-field-list">
								<li>
									<h5><?php esc_html_e('Shortcode','boat-charter-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Copy and paste the shortcode on a page.','boat-charter-booking-system'); ?></span>
									<div class="to-field-disabled">
<?php
		$shortcode='['.PLUGIN_BCBS_CONTEXT.'_booking_form booking_form_id="'.$post->ID.'"]';
		echo esc_html($shortcode);
?>
										<a href="#" class="to-copy-to-clipboard to-float-right" data-clipboard-text="<?php echo esc_attr($shortcode); ?>" data-label-on-success="<?php esc_attr_e('Copied!','boat-charter-booking-system') ?>"><?php esc_html_e('Copy','boat-charter-booking-system'); ?></a>
									</div>
								</li>						
								<li>
									<h5><?php esc_html_e('Default booking status','boat-charter-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Default booking status of new order.','boat-charter-booking-system'); ?></span>
									<div class="to-radio-button">
<?php
		foreach($this->data['dictionary']['booking_status'] as $index=>$value)
		{
?>
										<input type="radio" value="<?php echo esc_attr($index); ?>" id="<?php BCBSHelper::getFormName('booking_status_id_default_'.$index); ?>" name="<?php BCBSHelper::getFormName('booking_status_id_default'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['booking_status_id_default'],$index); ?>/>
										<label for="<?php BCBSHelper::getFormName('booking_status_id_default_'.$index); ?>"><?php echo esc_html($value[0]); ?></label>
<?php		
		}
?>								
									</div>
								</li>	
								<li>
									<h5><?php esc_html_e('Geolocation','boat-charter-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Enable or disable geolocation.','boat-charter-booking-system'); ?></span>
									<div class="to-checkbox-button">
										<input type="checkbox" value="1" id="<?php BCBSHelper::getFormName('geolocation_enable_1'); ?>" name="<?php BCBSHelper::getFormName('geolocation_enable[]'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['geolocation_enable'],1); ?>/>
										<label for="<?php BCBSHelper::getFormName('geolocation_enable_1'); ?>"><?php esc_html_e('Client side','boat-charter-booking-system'); ?></label>
										<input type="checkbox" value="2" id="<?php BCBSHelper::getFormName('geolocation_enable_2'); ?>" name="<?php BCBSHelper::getFormName('geolocation_enable[]'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['geolocation_enable'],2); ?>/>
										<label for="<?php BCBSHelper::getFormName('geolocation_enable_2'); ?>"><?php esc_html_e('Server side','boat-charter-booking-system'); ?></label>
									</div>
								</li>						   
								<li>
									<h5><?php esc_html_e('WooCommerce','boat-charter-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Enable or disable WooCommerce support for this booking form.','boat-charter-booking-system'); ?><br/>
										<?php echo sprintf(__('Please make sure that you set up "Checkout page" in <a href="%s">WooCommerce settings</a>','boat-charter-booking-system'),admin_url('admin.php?page=wc-settings&tab=advanced')); ?>
									</span>
									<div class="to-radio-button">
										<input type="radio" value="1" id="<?php BCBSHelper::getFormName('woocommerce_enable_1'); ?>" name="<?php BCBSHelper::getFormName('woocommerce_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['woocommerce_enable'],1); ?>/>
										<label for="<?php BCBSHelper::getFormName('woocommerce_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
										<input type="radio" value="0" id="<?php BCBSHelper::getFormName('woocommerce_enable_0'); ?>" name="<?php BCBSHelper::getFormName('woocommerce_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['woocommerce_enable'],0); ?>/>
										<label for="<?php BCBSHelper::getFormName('woocommerce_enable_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
									</div>
								</li> 
								<li>
									<h5><?php esc_html_e('WooCommerce account','boat-charter-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Enable or disable possibility to create and login via wooCommerce account.','boat-charter-booking-system'); ?><br/>
										<?php esc_html_e('"Disable" means that login and register form will not be displayed.','boat-charter-booking-system'); ?><br/>
										<?php esc_html_e('"Enable as option" means that both forms will be available, but logging and/or creating an account depends on user preferences.','boat-charter-booking-system'); ?><br/>
										<?php esc_html_e('"Enable as mandatory" means that user have to be registered and logged before he sends a booking.','boat-charter-booking-system'); ?>
									</span>
									<div class="to-radio-button">
										<input type="radio" value="1" id="<?php BCBSHelper::getFormName('woocommerce_account_enable_type_1'); ?>" name="<?php BCBSHelper::getFormName('woocommerce_account_enable_type'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['woocommerce_account_enable_type'],1); ?>/>
										<label for="<?php BCBSHelper::getFormName('woocommerce_account_enable_type_1'); ?>"><?php esc_html_e('Enable as option','boat-charter-booking-system'); ?></label>
										<input type="radio" value="2" id="<?php BCBSHelper::getFormName('woocommerce_account_enable_type_2'); ?>" name="<?php BCBSHelper::getFormName('woocommerce_account_enable_type'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['woocommerce_account_enable_type'],2); ?>/>
										<label for="<?php BCBSHelper::getFormName('woocommerce_account_enable_type_2'); ?>"><?php esc_html_e('Enable as mandatory','boat-charter-booking-system'); ?></label>
										<input type="radio" value="0" id="<?php BCBSHelper::getFormName('woocommerce_account_enable_type_0'); ?>" name="<?php BCBSHelper::getFormName('woocommerce_account_enable_type'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['woocommerce_account_enable_type'],0); ?>/>
										<label for="<?php BCBSHelper::getFormName('woocommerce_account_enable_type_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
									</div>
								</li>
								<li>
									<h5><?php esc_html_e('Boats sorting','boat-charter-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Select sorting options of boats in booking form.','boat-charter-booking-system'); ?></span>
									<div class="to-clear-fix">
										<select name="<?php BCBSHelper::getFormName('boat_sorting_type'); ?>">
<?php
		foreach($this->data['dictionary']['boat_sorting_type'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['meta']['boat_sorting_type'],$index,false)).'>'.esc_html($value[0]).'</option>';
?>
										</select>
									</div>
								</li>  
							</ul>
						</div>
						<div id="meta-box-booking-form-1-2">
							<ul class="to-form-field-list">
								<li>
									<h5><?php esc_html_e('Marinas','boat-charter-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Select at least one marina.','boat-charter-booking-system'); ?>
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
									<h5><?php esc_html_e('Default departure marina','boat-charter-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Select default departure marina.','boat-charter-booking-system'); ?>
									</span>
									<div class="to-checkbox-button">
										<input type="radio" value="0" id="<?php BCBSHelper::getFormName('marina_departure_default_id_0'); ?>" name="<?php BCBSHelper::getFormName('marina_departure_default_id'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['marina_departure_default_id'],0); ?>/>
										<label for="<?php BCBSHelper::getFormName('marina_departure_default_id_0'); ?>"><?php echo esc_html_e('[None]','boat-charter-booking-system'); ?></label>
<?php
		foreach($this->data['dictionary']['marina'] as $index=>$value)
		{
?>
										<input type="radio" value="<?php echo esc_attr($index); ?>" id="<?php BCBSHelper::getFormName('marina_departure_default_id_'.$index); ?>" name="<?php BCBSHelper::getFormName('marina_departure_default_id'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['marina_departure_default_id'],$index); ?>/>
										<label for="<?php BCBSHelper::getFormName('marina_departure_default_id_'.$index); ?>"><?php echo esc_html(get_the_title($index)); ?></label>
<?php		
		}
?>								
									</div>
								</li>   								
								<li>
									<h5><?php esc_html_e('Default return marina','boat-charter-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Select default return marina.','boat-charter-booking-system'); ?>
									</span>
									<div class="to-checkbox-button">
										<input type="radio" value="0" id="<?php BCBSHelper::getFormName('marina_return_default_id_0'); ?>" name="<?php BCBSHelper::getFormName('marina_return_default_id'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['marina_return_default_id'],0); ?>/>
										<label for="<?php BCBSHelper::getFormName('marina_return_default_id_0'); ?>"><?php echo esc_html_e('[None]','boat-charter-booking-system'); ?></label>
<?php
		foreach($this->data['dictionary']['marina'] as $index=>$value)
		{
?>
										<input type="radio" value="<?php echo esc_attr($index); ?>" id="<?php BCBSHelper::getFormName('marina_return_default_id_'.$index); ?>" name="<?php BCBSHelper::getFormName('marina_return_default_id'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['marina_return_default_id'],$index); ?>/>
										<label for="<?php BCBSHelper::getFormName('marina_return_default_id_'.$index); ?>"><?php echo esc_html(get_the_title($index)); ?></label>
<?php		
		}
?>								
									</div>
								</li>   	
								<li>
									<h5><?php esc_html_e('Departure marina drop down list','boat-charter-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Select status of departure marina drop down list.','boat-charter-booking-system'); ?>
									</span>
									<div class="to-radio-button">
										<input type="radio" value="1" id="<?php BCBSHelper::getFormName('marina_departure_list_status_1'); ?>" name="<?php BCBSHelper::getFormName('marina_departure_list_status'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['marina_departure_list_status'],1); ?>/>
										<label for="<?php BCBSHelper::getFormName('marina_departure_list_status_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
										<input type="radio" value="2" id="<?php BCBSHelper::getFormName('marina_departure_list_status_2'); ?>" name="<?php BCBSHelper::getFormName('marina_departure_list_status'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['marina_departure_list_status'],2); ?>/>
										<label for="<?php BCBSHelper::getFormName('marina_departure_list_status_2'); ?>"><?php esc_html_e('Disable (use a default one)','boat-charter-booking-system'); ?></label>
									</div>
								</li>  								
								<li>
									<h5><?php esc_html_e('Return marina drop down list','boat-charter-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Select status of return marina drop down list.','boat-charter-booking-system'); ?>
									</span>
									<div class="to-radio-button">
										<input type="radio" value="1" id="<?php BCBSHelper::getFormName('marina_return_list_status_1'); ?>" name="<?php BCBSHelper::getFormName('marina_return_list_status'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['marina_return_list_status'],1); ?>/>
										<label for="<?php BCBSHelper::getFormName('marina_return_list_status_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
										<input type="radio" value="2" id="<?php BCBSHelper::getFormName('marina_return_list_status_2'); ?>" name="<?php BCBSHelper::getFormName('marina_return_list_status'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['marina_return_list_status'],2); ?>/>
										<label for="<?php BCBSHelper::getFormName('marina_return_list_status_2'); ?>"><?php esc_html_e('Disable (use a default one)','boat-charter-booking-system'); ?></label>
										<input type="radio" value="3" id="<?php BCBSHelper::getFormName('marina_return_list_status_3'); ?>" name="<?php BCBSHelper::getFormName('marina_return_list_status'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['marina_return_list_status'],3); ?>/>
										<label for="<?php BCBSHelper::getFormName('marina_return_list_status_3'); ?>"><?php esc_html_e('Disable (use a departure marina)','boat-charter-booking-system'); ?></label>
									</div>
								</li> 	
								<li>
									<h5><?php esc_html_e('Marina selection','boat-charter-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Set selection of the marina as mandatory by the customer.','boat-charter-booking-system'); ?><br/>
										<?php esc_html_e('If this feature is disbaled, then the "- All marinas -" option appears as the first element on the particular type of the marina drop down list.','boat-charter-booking-system'); ?><br/>
										<?php esc_html_e('If the marina drop down list is hidden, then the "- All marinas -" option is selected by default.','boat-charter-booking-system'); ?>
									</span>
									<div class="to-checkbox-button">
										<input type="checkbox" value="1" id="<?php BCBSHelper::getFormName('marina_selection_mandatory_1'); ?>" name="<?php BCBSHelper::getFormName('marina_selection_mandatory[]'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['marina_selection_mandatory'],1); ?>/>
										<label for="<?php BCBSHelper::getFormName('marina_selection_mandatory_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
										<input type="checkbox" value="2" id="<?php BCBSHelper::getFormName('marina_selection_mandatory_2'); ?>" name="<?php BCBSHelper::getFormName('marina_selection_mandatory[]'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['marina_selection_mandatory'],2); ?>/>
										<label for="<?php BCBSHelper::getFormName('marina_selection_mandatory_2'); ?>"><?php esc_html_e('Disable for a departure marina','boat-charter-booking-system'); ?></label>
										<input type="checkbox" value="3" id="<?php BCBSHelper::getFormName('marina_selection_mandatory_3'); ?>" name="<?php BCBSHelper::getFormName('marina_selection_mandatory[]'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['marina_selection_mandatory'],3); ?>/>
										<label for="<?php BCBSHelper::getFormName('marina_selection_mandatory_3'); ?>"><?php esc_html_e('Disable for a return marina','boat-charter-booking-system'); ?></label>
									</div>
								</li> 									
							</ul>
						</div>
						<div id="meta-box-booking-form-1-3">
							<ul class="to-form-field-list">
								<li>
									<h5><?php esc_html_e('Currencies','boat-charter-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Select available currencies.','boat-charter-booking-system'); ?><br/>
										<?php esc_html_e('You can set exchange rates for each selected currency in plugin options.','boat-charter-booking-system'); ?><br/>
										<?php esc_html_e('You can run booking form with particular currency by adding parameter "currency=CODE" to the query string of page on which booking form is located.','boat-charter-booking-system'); ?>
									</span>						
									<div class="to-clear-fix">
										<select multiple="multiple" class="to-dropkick-disable" name="<?php BCBSHelper::getFormName('currency[]'); ?>">
											<option value="-1" <?php BCBSHelper::selectedIf($this->data['meta']['currency'],-1); ?>><?php esc_html_e('- None -','boat-charter-booking-system'); ?></option>
<?php
		foreach($this->data['dictionary']['currency'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['meta']['currency'],$index,false)).'>'.esc_html($value['name'].' ('.$index.')').'</option>';
?>
										</select>												
									</div>
								</li>
								<li>
									<h5><?php esc_html_e('Coupons','boat-charter-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Enable or disable coupons for this booking form.','boat-charter-booking-system'); ?></span>
									<div class="to-radio-button">
										<input type="radio" value="1" id="<?php BCBSHelper::getFormName('coupon_enable_1'); ?>" name="<?php BCBSHelper::getFormName('coupon_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['coupon_enable'],1); ?>/>
										<label for="<?php BCBSHelper::getFormName('coupon_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
										<input type="radio" value="0" id="<?php BCBSHelper::getFormName('coupon_enable_0'); ?>" name="<?php BCBSHelper::getFormName('coupon_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['coupon_enable'],0); ?>/>
										<label for="<?php BCBSHelper::getFormName('coupon_enable_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
									</div>
								</li>
								<li>
									<h5><?php esc_html_e('Coupon','boat-charter-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Select coupon which should be automatically used.','boat-charter-booking-system'); ?><br/>
									</span>						
									<div class="to-clear-fix">
										<select name="<?php BCBSHelper::getFormName('coupon_id'); ?>">
											<option value="-1" <?php BCBSHelper::selectedIf($this->data['meta']['coupon_id'],-1); ?>><?php esc_html_e('- None -','boat-charter-booking-system'); ?></option>
<?php
		foreach($this->data['dictionary']['coupon'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['meta']['coupon_id'],$index,false)).'>'.esc_html($value['meta']['code']).'</option>';
?>
										</select>												
									</div>
								</li>
								<li>
									<h5><?php esc_html_e('Minimum order value','boat-charter-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Specify minimum gross value of the order.','boat-charter-booking-system'); ?>
									</span>
									<div><input type="text" maxlength="12" name="<?php BCBSHelper::getFormName('order_value_minimum'); ?>" value="<?php echo esc_attr($this->data['meta']['order_value_minimum']); ?>"/></div>								  
								</li>
								<li>
									<h5><?php esc_html_e('Hide fees','boat-charter-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Hide all additional fees in booking summary and include them to the price of selected boat.','boat-charter-booking-system'); ?>
									</span>
									<div class="to-radio-button">
										<input type="radio" value="1" id="<?php BCBSHelper::getFormName('booking_summary_hide_fee_1'); ?>" name="<?php BCBSHelper::getFormName('booking_summary_hide_fee'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['booking_summary_hide_fee'],1); ?>/>
										<label for="<?php BCBSHelper::getFormName('booking_summary_hide_fee_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
										<input type="radio" value="0" id="<?php BCBSHelper::getFormName('booking_summary_hide_fee_0'); ?>" name="<?php BCBSHelper::getFormName('booking_summary_hide_fee'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['booking_summary_hide_fee'],0); ?>/>
										<label for="<?php BCBSHelper::getFormName('booking_summary_hide_fee_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
									</div>
								</li>  
								<li>
									<h5><?php esc_html_e('Display net prices','boat-charter-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Display net prices and tax separately in booking summary.','boat-charter-booking-system'); ?>
									</span>
									<div class="to-radio-button">
										<input type="radio" value="1" id="<?php BCBSHelper::getFormName('booking_summary_display_net_price_1'); ?>" name="<?php BCBSHelper::getFormName('booking_summary_display_net_price'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['booking_summary_display_net_price'],1); ?>/>
										<label for="<?php BCBSHelper::getFormName('booking_summary_display_net_price_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
										<input type="radio" value="0" id="<?php BCBSHelper::getFormName('booking_summary_display_net_price_0'); ?>" name="<?php BCBSHelper::getFormName('booking_summary_display_net_price'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['booking_summary_display_net_price'],0); ?>/>
										<label for="<?php BCBSHelper::getFormName('booking_summary_display_net_price_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
									</div>
								</li>  
							</ul>
						</div>
						<div id="meta-box-booking-form-1-4">
							<div class="ui-tabs">
								<ul>
									<li><a href="#meta-box-booking-form-1-4-1"><?php esc_html_e('Main','boat-charter-booking-system'); ?></a></li>
									<li><a href="#meta-box-booking-form-1-4-2"><?php esc_html_e('Step #1','boat-charter-booking-system'); ?></a></li>
									<li><a href="#meta-box-booking-form-1-4-3"><?php esc_html_e('Step #2','boat-charter-booking-system'); ?></a></li>
									<li><a href="#meta-box-booking-form-1-4-4"><?php esc_html_e('Step #3','boat-charter-booking-system'); ?></a></li>
									<li><a href="#meta-box-booking-form-1-4-5"><?php esc_html_e('Step #4','boat-charter-booking-system'); ?></a></li>
									<li><a href="#meta-box-booking-form-1-4-6"><?php esc_html_e('Step #5','boat-charter-booking-system'); ?></a></li>
								</ul>
								<div id="meta-box-booking-form-1-4-1">							
									<ul class="to-form-field-list">
										<li>
											<h5><?php esc_html_e('Form preloader','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Enable or disable form preloader.','boat-charter-booking-system'); ?></span>
											<div class="to-radio-button">
												<input type="radio" value="1" id="<?php BCBSHelper::getFormName('form_preloader_enable_1'); ?>" name="<?php BCBSHelper::getFormName('form_preloader_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['form_preloader_enable'],1); ?>/>
												<label for="<?php BCBSHelper::getFormName('form_preloader_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
												<input type="radio" value="0" id="<?php BCBSHelper::getFormName('form_preloader_enable_0'); ?>" name="<?php BCBSHelper::getFormName('form_preloader_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['form_preloader_enable'],0); ?>/>
												<label for="<?php BCBSHelper::getFormName('form_preloader_enable_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
											</div>
										</li> 
										<li>
											<h5><?php esc_html_e('Top navigation','boat-charter-booking-system'); ?></h5>
											<span class="to-legend">
												<?php echo esc_html__('Enable or disable top navigation.','boat-charter-booking-system'); ?>
											</span>
											<div class="to-clear-fix">
												<div class="to-radio-button">
													<input type="radio" value="1" id="<?php BCBSHelper::getFormName('navigation_top_enable_1'); ?>" name="<?php BCBSHelper::getFormName('navigation_top_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['navigation_top_enable'],1); ?>/>
													<label for="<?php BCBSHelper::getFormName('navigation_top_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
													<input type="radio" value="0" id="<?php BCBSHelper::getFormName('navigation_top_enable_0'); ?>" name="<?php BCBSHelper::getFormName('navigation_top_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['navigation_top_enable'],0); ?>/>
													<label for="<?php BCBSHelper::getFormName('navigation_top_enable_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
												</div>								
											</div>
										</li>
										<li>
											<h5><?php esc_html_e('Sticky summary sidebar','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Enable or disable sticky option for summary sidebar.','boat-charter-booking-system'); ?></span>
											<div class="to-radio-button">
												<input type="radio" value="1" id="<?php BCBSHelper::getFormName('summary_sidebar_sticky_enable_1'); ?>" name="<?php BCBSHelper::getFormName('summary_sidebar_sticky_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['summary_sidebar_sticky_enable'],1); ?>/>
												<label for="<?php BCBSHelper::getFormName('summary_sidebar_sticky_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
												<input type="radio" value="0" id="<?php BCBSHelper::getFormName('summary_sidebar_sticky_enable_0'); ?>" name="<?php BCBSHelper::getFormName('summary_sidebar_sticky_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['summary_sidebar_sticky_enable'],0); ?>/>
												<label for="<?php BCBSHelper::getFormName('summary_sidebar_sticky_enable_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
											</div>
										</li> 										
									</ul>
								</div>
								<div id="meta-box-booking-form-1-4-2">							
									<ul class="to-form-field-list">
										<li>
											<h5><?php esc_html_e('Departure/return time field','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Select default state of billing details section.','boat-charter-booking-system'); ?></span>
											<div class="to-radio-button">
												<input type="radio" value="1" id="<?php BCBSHelper::getFormName('marina_departure_return_time_field_enable_1'); ?>" name="<?php BCBSHelper::getFormName('marina_departure_return_time_field_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['marina_departure_return_time_field_enable'],1); ?>/>
												<label for="<?php BCBSHelper::getFormName('marina_departure_return_time_field_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
												<input type="radio" value="0" id="<?php BCBSHelper::getFormName('marina_departure_return_time_field_enable_0'); ?>" name="<?php BCBSHelper::getFormName('marina_departure_return_time_field_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['marina_departure_return_time_field_enable'],0); ?>/>
												<label for="<?php BCBSHelper::getFormName('marina_departure_return_time_field_enable_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
											</div>
										</li>
										<li>
											<h5><?php esc_html_e('Timepicker interval','boat-charter-booking-system'); ?></h5>
											<span class="to-legend">
												<?php esc_html_e('The amount of time, in minutes, between each item in the dropdown.','boat-charter-booking-system'); ?><br/>
												<?php esc_html_e('Allowed are integer values from 1 to 9999.','boat-charter-booking-system'); ?><br/>
											</span>
											<div><input type="text" maxlength="4" name="<?php BCBSHelper::getFormName('timepicker_step'); ?>" value="<?php echo esc_attr($this->data['meta']['timepicker_step']); ?>"/></div>								  
										</li> 
										<li>
											<h5><?php esc_html_e('"Sail" field','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Define whether "Sail" field has to be enabled in the step #1 of booking form.','boat-charter-booking-system'); ?></span>
											<div class="to-radio-button">
												<input type="radio" value="1" id="<?php BCBSHelper::getFormName('captain_field_enable_1'); ?>" name="<?php BCBSHelper::getFormName('captain_field_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['captain_field_enable'],1); ?>/>
												<label for="<?php BCBSHelper::getFormName('captain_field_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
												<input type="radio" value="0" id="<?php BCBSHelper::getFormName('captain_field_enable_0'); ?>" name="<?php BCBSHelper::getFormName('captain_field_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['captain_field_enable'],0); ?>/>
												<label for="<?php BCBSHelper::getFormName('captain_field_enable_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
											</div>
										</li>
										<li>
											<h5><?php esc_html_e('"Sail" field default','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Default value of "Sail" field.','boat-charter-booking-system'); ?></span>
											<div class="bcbs-clear-fix">
												<select name="<?php BCBSHelper::getFormName('captain_field_default_value'); ?>">
													<option value="-1" <?php BCBSHelper::selectedIf($this->data['meta']['captain_field_default_value'],-1); ?>><?php esc_html_e('- None -','boat-charter-booking-system'); ?></option>
<?php
		foreach($this->data['dictionary']['boat_captain_status'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['meta']['captain_field_default_value'],$index,false)).'>'.esc_html($value[0]).'</option>';
?>
												</select>										
											</div>
										</li>
									</ul>
								</div>
								<div id="meta-box-booking-form-1-4-3">							
									<ul class="to-form-field-list">
										<li>
											<h5><?php esc_html_e('Boats filter bar','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Display filter bar on boats list.','boat-charter-booking-system'); ?></span>
											<div class="to-radio-button">
												<input type="radio" value="1" id="<?php BCBSHelper::getFormName('boat_filter_bar_enable_1'); ?>" name="<?php BCBSHelper::getFormName('boat_filter_bar_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['boat_filter_bar_enable'],1); ?>/>
												<label for="<?php BCBSHelper::getFormName('boat_filter_bar_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
												<input type="radio" value="0" id="<?php BCBSHelper::getFormName('boat_filter_bar_enable_0'); ?>" name="<?php BCBSHelper::getFormName('boat_filter_bar_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['boat_filter_bar_enable'],0); ?>/>
												<label for="<?php BCBSHelper::getFormName('boat_filter_bar_enable_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
											</div>
										</li>
										<li>
											<h5><?php esc_html_e('Total count of boats','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Display count of boats.','boat-charter-booking-system'); ?></span>
											<div class="to-radio-button">
												<input type="radio" value="1" id="<?php BCBSHelper::getFormName('boat_count_enable_1'); ?>" name="<?php BCBSHelper::getFormName('boat_count_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['boat_count_enable'],1); ?>/>
												<label for="<?php BCBSHelper::getFormName('boat_count_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
												<input type="radio" value="0" id="<?php BCBSHelper::getFormName('boat_count_enable_0'); ?>" name="<?php BCBSHelper::getFormName('boat_count_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['boat_count_enable'],0); ?>/>
												<label for="<?php BCBSHelper::getFormName('boat_count_enable_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
											</div>
										</li>	
										<li>
											<h5><?php esc_html_e('Boat attributes','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Enable or disable visibility of selected boats attributes displayed on list in step #2.','boat-charter-booking-system'); ?></span>
											<div class="to-checkbox-button">
												<input type="checkbox" value="1" id="<?php BCBSHelper::getFormName('boat_attribute_enable_1'); ?>" name="<?php BCBSHelper::getFormName('boat_attribute_enable[]'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['boat_attribute_enable'],1); ?>/>
												<label for="<?php BCBSHelper::getFormName('boat_attribute_enable_1'); ?>"><?php esc_html_e('Number of guests','boat-charter-booking-system'); ?></label>
												<input type="checkbox" value="2" id="<?php BCBSHelper::getFormName('boat_attribute_enable_2'); ?>" name="<?php BCBSHelper::getFormName('boat_attribute_enable[]'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['boat_attribute_enable'],2); ?>/>
												<label for="<?php BCBSHelper::getFormName('boat_attribute_enable_2'); ?>"><?php esc_html_e('Number of cabins','boat-charter-booking-system'); ?></label>
												<input type="checkbox" value="3" id="<?php BCBSHelper::getFormName('boat_attribute_enable_3'); ?>" name="<?php BCBSHelper::getFormName('boat_attribute_enable[]'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['boat_attribute_enable'],3); ?>/>
												<label for="<?php BCBSHelper::getFormName('boat_attribute_enable_3'); ?>"><?php esc_html_e('Length','boat-charter-booking-system'); ?></label>
											</div>
										</li> 	
										<li>
											<h5><?php esc_html_e('Scroll after selecting a boat','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Scroll user to booking add-ons section after selecting a boat.','boat-charter-booking-system'); ?></span>
											<div class="to-radio-button">
												<input type="radio" value="1" id="<?php BCBSHelper::getFormName('scroll_to_booking_extra_after_select_boat_enable_1'); ?>" name="<?php BCBSHelper::getFormName('scroll_to_booking_extra_after_select_boat_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['scroll_to_booking_extra_after_select_boat_enable'],1); ?>/>
												<label for="<?php BCBSHelper::getFormName('scroll_to_booking_extra_after_select_boat_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
												<input type="radio" value="0" id="<?php BCBSHelper::getFormName('scroll_to_booking_extra_after_select_boat_enable_0'); ?>" name="<?php BCBSHelper::getFormName('scroll_to_booking_extra_after_select_boat_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['scroll_to_booking_extra_after_select_boat_enable'],0); ?>/>
												<label for="<?php BCBSHelper::getFormName('scroll_to_booking_extra_after_select_boat_enable_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
											</div>
										</li> 
									</ul>
								</div>
								<div id="meta-box-booking-form-1-4-4">							
									<ul class="to-form-field-list">
										<li>
											<h5><?php esc_html_e('Billing details','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Select default state of billing details section.','boat-charter-booking-system'); ?></span>
											<div class="to-radio-button">
												<input type="radio" value="1" id="<?php BCBSHelper::getFormName('billing_detail_state_1'); ?>" name="<?php BCBSHelper::getFormName('billing_detail_state'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['billing_detail_state'],1); ?>/>
												<label for="<?php BCBSHelper::getFormName('billing_detail_state_1'); ?>"><?php esc_html_e('Unchecked','boat-charter-booking-system'); ?></label>
												<input type="radio" value="2" id="<?php BCBSHelper::getFormName('billing_detail_state_2'); ?>" name="<?php BCBSHelper::getFormName('billing_detail_state'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['billing_detail_state'],2); ?>/>
												<label for="<?php BCBSHelper::getFormName('billing_detail_state_2'); ?>"><?php esc_html_e('Checked','boat-charter-booking-system'); ?></label>
												<input type="radio" value="3" id="<?php BCBSHelper::getFormName('billing_detail_state_3'); ?>" name="<?php BCBSHelper::getFormName('billing_detail_state'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['billing_detail_state'],3); ?>/>
												<label for="<?php BCBSHelper::getFormName('billing_detail_state_3'); ?>"><?php esc_html_e('Mandatory','boat-charter-booking-system'); ?></label>
												<input type="radio" value="4" id="<?php BCBSHelper::getFormName('billing_detail_state_4'); ?>" name="<?php BCBSHelper::getFormName('billing_detail_state'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['billing_detail_state'],4); ?>/>
												<label for="<?php BCBSHelper::getFormName('billing_detail_state_4'); ?>"><?php esc_html_e('Hidden','boat-charter-booking-system'); ?></label>
											</div>
										</li>
										<li>
											<h5><?php esc_html_e('Fields mandatory','boat-charter-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Select which fields should be marked as mandatory.','boat-charter-booking-system'); ?></span>
											<div class="to-checkbox-button">
<?php
		foreach($this->data['dictionary']['field_mandatory'] as $index=>$value)
		{
?>
												<input type="checkbox" value="<?php echo esc_attr($index); ?>" id="<?php BCBSHelper::getFormName('field_mandatory_'.$index); ?>" name="<?php BCBSHelper::getFormName('field_mandatory['.$index.']'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['field_mandatory'],$index); ?>/>
												<label for="<?php BCBSHelper::getFormName('field_mandatory_'.$index); ?>"><?php echo esc_html($value['label']); ?></label>
<?php		
		}
?>								
											</div>
										</li> 										
									</ul>
								</div>
								<div id="meta-box-booking-form-1-4-5">							
									<div class="to-notice-small to-notice-small-error">
										<?php esc_html_e('There are no settings for this step.','boat-charter-booking-system'); ?>
									</div>	
								</div>
								<div id="meta-box-booking-form-1-4-6">							
									<ul class="to-form-field-list">
										<li>
											<h5><?php esc_html_e('"Thank You" page','boat-charter-booking-system'); ?></h5>
											<span class="to-legend">
												<?php esc_html_e('Enable or disable "Thank You" page in booking form.','boat-charter-booking-system'); ?><br/>
												<?php esc_html_e('Please note, that disabling this page is available only if wooCommerce support is enabled.','boat-charter-booking-system'); ?><br/>
												<?php esc_html_e('Then, customer is redirected to checkout page without information, that order has been sent.','boat-charter-booking-system'); ?>
											</span>
											<div class="to-radio-button">
												<input type="radio" value="1" id="<?php BCBSHelper::getFormName('thank_you_page_enable_1'); ?>" name="<?php BCBSHelper::getFormName('thank_you_page_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['thank_you_page_enable'],1); ?>/>
												<label for="<?php BCBSHelper::getFormName('thank_you_page_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
												<input type="radio" value="0" id="<?php BCBSHelper::getFormName('thank_you_page_enable_0'); ?>" name="<?php BCBSHelper::getFormName('thank_you_page_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['thank_you_page_enable'],0); ?>/>
												<label for="<?php BCBSHelper::getFormName('thank_you_page_enable_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
											</div>
										</li> 
										<li>
											<h5><?php esc_html_e('"Back to home" button on "Thank you" page','boat-charter-booking-system'); ?></h5>
											<span class="to-legend">
												<?php esc_html_e('Enter URL address and label for this button.','boat-charter-booking-system'); ?><br/>
												<?php esc_html_e('This button is displayed if payment processing is disabled or customer selects wire transfer or cash payment.','boat-charter-booking-system'); ?>
											</span>
											<div>
												<span class="to-legend-field"><?php esc_html_e('Label:','boat-charter-booking-system'); ?></span>
												<div>
													<input type="text" name="<?php BCBSHelper::getFormName('thank_you_page_button_back_to_home_label'); ?>" value="<?php echo esc_attr($this->data['meta']['thank_you_page_button_back_to_home_label']); ?>"/>
												</div>					 
											</div>
											<div>
												<span class="to-legend-field"><?php esc_html_e('URL address:','boat-charter-booking-system'); ?></span>
												<div>
													<input type="text" name="<?php BCBSHelper::getFormName('thank_you_page_button_back_to_home_url_address'); ?>" value="<?php echo esc_attr($this->data['meta']['thank_you_page_button_back_to_home_url_address']); ?>"/>
												</div>					 
											</div>
										</li>										
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="meta-box-booking-form-2">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Panels','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Table includes list of user defined panels (group of fields) used in client form.','boat-charter-booking-system'); ?><br/>
								<?php esc_html_e('Default tabs "Contact details" and "Billing address" cannot be modified.','boat-charter-booking-system'); ?>
							</span>
							<div class="to-clear-fix">
								<table class="to-table" id="to-table-form-element-field">
									<tr>
										<th style="width:85%">
											<div>
												<?php esc_html_e('Label','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Label of the panel.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:18%">
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
												<input type="hidden" name="<?php BCBSHelper::getFormName('form_element_panel[id][]'); ?>"/>
												<input type="text" name="<?php BCBSHelper::getFormName('form_element_panel[label][]'); ?>" title="<?php esc_attr_e('Enter label.','boat-charter-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','boat-charter-booking-system'); ?></a>
											</div>
										</td>										
									</tr>
<?php
		if(isset($this->data['meta']['form_element_panel']))
		{
			foreach($this->data['meta']['form_element_panel'] as $panelValue)
			{
?>
									<tr>
										<td>
											<div>
												<input type="hidden" value="<?php echo esc_attr($panelValue['id']); ?>" name="<?php BCBSHelper::getFormName('form_element_panel[id][]'); ?>"/>
												<input type="text" value="<?php echo esc_attr($panelValue['label']); ?>" name="<?php BCBSHelper::getFormName('form_element_panel[label][]'); ?>" title="<?php esc_attr_e('Enter label.','boat-charter-booking-system'); ?>"/>
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
							<h5><?php esc_html_e('Fields','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Table includes list of user defined fields used in client form.','boat-charter-booking-system'); ?><br/>
								<?php esc_html_e('Default fields located in tabs "Contact details" and "Billing address" cannot be modified.','boat-charter-booking-system'); ?>
							</span>
							<div class="to-clear-fix">
								<table class="to-table" id="to-table-form-element-panel">
									<tr>
										<th style="width:15%">
											<div>
												<?php esc_html_e('Label','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Label of the field.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:15%">
											<div>
												<?php esc_html_e('Type','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Field type.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>										
										<th style="width:5%">
											<div>
												<?php esc_html_e('Mandatory','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Mandatory.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>   
										<th style="width:20%">
											<div>
												<?php esc_html_e('Values','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('List of possible values to choose separated by semicolon.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>   										
										<th style="width:15%">
											<div>
												<?php esc_html_e('Error message','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Error message displayed in tooltip when field is empty.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>											  
										<th style="width:20%">
											<div>
												<?php esc_html_e('Panel','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Panel in which field has to be located.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>											 
										<th style="width:10%">
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
											<div class="to-clear-fix">
												<input type="hidden" name="<?php BCBSHelper::getFormName('form_element_field[id][]'); ?>"/>
												<input type="text" name="<?php BCBSHelper::getFormName('form_element_field[label][]'); ?>" title="<?php esc_attr_e('Enter label.','boat-charter-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div class="to-clear-fix">
												<select name="<?php BCBSHelper::getFormName('form_element_field[field_type][]'); ?>" class="to-dropkick-disable" id="form_element_field_field_type">
<?php
		foreach($this->data['dictionary']['field_type'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'">'.esc_html($value[0]).'</option>';
?>
												</select>
											</div>									
										</td>										
										<td>
											<div class="to-clear-fix">
												<select name="<?php BCBSHelper::getFormName('form_element_field[mandatory][]'); ?>" class="to-dropkick-disable" id="form_element_field_mandatory">
													<option value="1"><?php esc_html_e('Yes','boat-charter-booking-system'); ?></option>
													<option value="0"><?php esc_html_e('No','boat-charter-booking-system'); ?></option>
												</select>
											</div>
										</td>										
										<td>
											<div class="to-clear-fix">												
												<input type="text" name="<?php BCBSHelper::getFormName('form_element_field[dictionary][]'); ?>" title="<?php esc_attr_e('Enter values of list separated by semicolon.','boat-charter-booking-system'); ?>"/>
											</div>									
										</td>   										
										<td>
											<div class="to-clear-fix">												
												<input type="text" name="<?php BCBSHelper::getFormName('form_element_field[message_error][]'); ?>" title="<?php esc_attr_e('Enter error message.','boat-charter-booking-system'); ?>"/>
											</div>									
										</td>										
										<td>
											<div class="to-clear-fix">
												<select name="<?php BCBSHelper::getFormName('form_element_field[panel_id][]'); ?>" class="to-dropkick-disable" id="form_element_field_panel_id">
<?php
		foreach($this->data['dictionary']['form_element_panel'] as $index=>$value)
			echo '<option value="'.esc_attr($value['id']).'">'.esc_html($value['label']).'</option>';
?>
												</select>
											</div>									
										</td>
										<td>
											<div>
												<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','boat-charter-booking-system'); ?></a>
											</div>
										</td>										
									</tr>
<?php
		if(isset($this->data['meta']['form_element_field']))
		{
			foreach($this->data['meta']['form_element_field'] as $fieldValue)
			{
?>			   
									<tr>
										<td>
											<div class="to-clear-fix">
												<input type="hidden" value="<?php echo esc_attr($fieldValue['id']); ?>" name="<?php BCBSHelper::getFormName('form_element_field[id][]'); ?>"/>
												<input type="text" value="<?php echo esc_attr($fieldValue['label']); ?>" name="<?php BCBSHelper::getFormName('form_element_field[label][]'); ?>" title="<?php esc_attr_e('Enter label.','boat-charter-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div class="to-clear-fix">
												<select  id="<?php BCBSHelper::getFormName('form_element_field_field_type_'.$fieldValue['id']); ?>" name="<?php BCBSHelper::getFormName('form_element_field[field_type][]'); ?>">
<?php
				foreach($this->data['dictionary']['field_type'] as $index=>$value)
					echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($fieldValue['field_type'],$index,false)).'>'.esc_html($value[0]).'</option>';
?>
												</select>
											</div>									
										</td>	
										<td>
											<div class="to-clear-fix">
												<select id="<?php BCBSHelper::getFormName('form_element_field_mandatory_'.$fieldValue['id']); ?>" name="<?php BCBSHelper::getFormName('form_element_field[mandatory][]'); ?>">
													<option value="1" <?php BCBSHelper::selectedIf($fieldValue['mandatory'],1); ?>><?php esc_html_e('Yes','boat-charter-booking-system'); ?></option>
													<option value="0" <?php BCBSHelper::selectedIf($fieldValue['mandatory'],0); ?>><?php esc_html_e('No','boat-charter-booking-system'); ?></option>
												</select>
											</div>
										</td>
										<td>
											<div class="to-clear-fix">												
												<input type="text" value="<?php echo esc_attr($fieldValue['dictionary']); ?>" name="<?php BCBSHelper::getFormName('form_element_field[dictionary][]'); ?>" title="<?php esc_attr_e('Enter values of list separated by semicolon.','boat-charter-booking-system'); ?>"/>
											</div>									
										</td> 
										<td>
											<div class="to-clear-fix">												
												<input type="text" value="<?php echo esc_attr($fieldValue['message_error']); ?>" name="<?php BCBSHelper::getFormName('form_element_field[message_error][]'); ?>" title="<?php esc_attr_e('Enter error message.','boat-charter-booking-system'); ?>"/>
											</div>									
										</td>										
										<td>
											<div class="to-clear-fix">
												<select id="<?php BCBSHelper::getFormName('form_element_field_panel_id_'.$fieldValue['id']); ?>" name="<?php BCBSHelper::getFormName('form_element_field[panel_id][]'); ?>">
<?php
				foreach($this->data['dictionary']['form_element_panel'] as $index=>$value)
					echo '<option value="'.esc_attr($value['id']).'" '.(BCBSHelper::selectedIf($fieldValue['panel_id'],$value['id'],false)).'>'.esc_html($value['label']).'</option>';
?>
												</select>
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
							<h5><?php esc_html_e('Agreements','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Table includes list of agreements needed to accept by customer before sending the booking.','boat-charter-booking-system'); ?><br/>
								<?php esc_html_e('Each agreement consists of approval field (checkbox) and text of agreement.','boat-charter-booking-system'); ?>
							</span>
							<div class="to-clear-fix">
								<table class="to-table" id="to-table-form-element-agreement">
									<tr>
										<th style="width:85%">
											<div>
												<?php esc_html_e('Text','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Text of the agreement.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:15%">
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
												<input type="hidden" name="<?php BCBSHelper::getFormName('form_element_agreement[id][]'); ?>"/>
												<input type="text" name="<?php BCBSHelper::getFormName('form_element_agreement[text][]'); ?>" title="<?php esc_attr_e('Enter text.','boat-charter-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','boat-charter-booking-system'); ?></a>
											</div>
										</td>										
									</tr>
<?php
		if(isset($this->data['meta']['form_element_agreement']))
		{
			foreach($this->data['meta']['form_element_agreement'] as $agreementValue)
			{
?>
									<tr>
										<td>
											<div>
												<input type="hidden" value="<?php echo esc_attr($agreementValue['id']); ?>" name="<?php BCBSHelper::getFormName('form_element_agreement[id][]'); ?>"/>
												<input type="text" value="<?php echo esc_attr($agreementValue['text']); ?>" name="<?php BCBSHelper::getFormName('form_element_agreement[text][]'); ?>" title="<?php esc_attr_e('Enter text.','boat-charter-booking-system'); ?>"/>
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
				<div id="meta-box-booking-form-3">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Colors','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Specify color for each group of elements.','boat-charter-booking-system'); ?>
							</span> 
							<div class="to-clear-fix">
								<table class="to-table">
									<tr>
										<th style="width:20%">
											<div>
												<?php esc_html_e('Group number','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Group number.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:30%">
											<div>
												<?php esc_html_e('Default color','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Default value of the color.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:50%">
											<div>
												<?php esc_html_e('Color','boat-charter-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('New value (in HEX) of the color.','boat-charter-booking-system'); ?>
												</span>
											</div>
										</th>
									</tr>
<?php
		foreach($this->data['dictionary']['color'] as $index=>$value)
		{
?>
									<tr>
										<td>
											<div><?php echo esc_html($index); ?>.</div>
										</td>
										<td>
											<div class="to-clear-fix">
												<span class="to-color-picker-sample to-color-picker-sample-style-1" style="background-color:#<?php echo esc_attr($value['color']); ?>"></span>
												<span><?php echo '#'.esc_html($value['color']); ?></span>
											</div>
										</td>
										<td>
											<div class="to-clear-fix">	
												 <input type="text" class="to-color-picker" id="<?php BCBSHelper::getFormName('style_color_'.$index); ?>" name="<?php BCBSHelper::getFormName('style_color['.$index.']'); ?>" value="<?php echo esc_attr($this->data['meta']['style_color'][$index]); ?>"/>
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
				<div id="meta-box-booking-form-4">
					<ul class="to-form-field-list">  
						<li>
							<h5><?php esc_html_e('Status','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php echo esc_html__('Enable or disable Google Maps.','boat-charter-booking-system'); ?>
							</span>
							<div class="to-clear-fix">
								<div class="to-radio-button">
									<input type="radio" value="1" id="<?php BCBSHelper::getFormName('google_map_enable_1'); ?>" name="<?php BCBSHelper::getFormName('google_map_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['google_map_enable'],1); ?>/>
									<label for="<?php BCBSHelper::getFormName('google_map_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
									<input type="radio" value="0" id="<?php BCBSHelper::getFormName('google_map_enable_0'); ?>" name="<?php BCBSHelper::getFormName('google_map_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['google_map_enable'],0); ?>/>
									<label for="<?php BCBSHelper::getFormName('google_map_enable_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
								</div>								
							</div>
						</li> 			
						<li>
							<h5><?php esc_html_e('Draggable','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php echo esc_html__('Enable or disable dragging on the map.','boat-charter-booking-system'); ?></span> 
							<div class="to-radio-button">
								<input type="radio" value="1" id="<?php BCBSHelper::getFormName('google_map_draggable_enable_1'); ?>" name="<?php BCBSHelper::getFormName('google_map_draggable_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['google_map_draggable_enable'],1); ?>/>
								<label for="<?php BCBSHelper::getFormName('google_map_draggable_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
								<input type="radio" value="0" id="<?php BCBSHelper::getFormName('google_map_draggable_enable_0'); ?>" name="<?php BCBSHelper::getFormName('google_map_draggable_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['google_map_draggable_enable'],0); ?>/>
								<label for="<?php BCBSHelper::getFormName('google_map_draggable_enable_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
							</div>							
						</li>
						<li>
							<h5><?php esc_html_e('Scrollwheel','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php echo esc_html__('Enable or disable wheel scrolling on the map.','boat-charter-booking-system'); ?></span> 
							<div class="to-radio-button">
								<input type="radio" value="1" id="<?php BCBSHelper::getFormName('google_map_scrollwheel_enable_1'); ?>" name="<?php BCBSHelper::getFormName('google_map_scrollwheel_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['google_map_scrollwheel_enable'],1); ?>/>
								<label for="<?php BCBSHelper::getFormName('google_map_scrollwheel_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
								<input type="radio" value="0" id="<?php BCBSHelper::getFormName('google_map_scrollwheel_enable_0'); ?>" name="<?php BCBSHelper::getFormName('google_map_scrollwheel_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['google_map_scrollwheel_enable'],0); ?>/>
								<label for="<?php BCBSHelper::getFormName('google_map_scrollwheel_enable_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
							</div>							
						</li>
						<li>
							<h5><?php esc_html_e('Map type control','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Enter settings for a map type.','boat-charter-booking-system'); ?>
							</span> 
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('Status:','boat-charter-booking-system'); ?></span>
								<div class="to-radio-button">
									<input type="radio" value="1" id="<?php BCBSHelper::getFormName('google_map_map_type_control_enable_1'); ?>" name="<?php BCBSHelper::getFormName('google_map_map_type_control_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['google_map_map_type_control_enable'],1); ?>/>
									<label for="<?php BCBSHelper::getFormName('google_map_map_type_control_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
									<input type="radio" value="0" id="<?php BCBSHelper::getFormName('google_map_map_type_control_enable_0'); ?>" name="<?php BCBSHelper::getFormName('google_map_map_type_control_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['google_map_map_type_control_enable'],0); ?>/>
									<label for="<?php BCBSHelper::getFormName('google_map_map_type_control_enable_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
								</div>								
							</div>   
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('Type:','boat-charter-booking-system'); ?></span>
								<select name="<?php BCBSHelper::getFormName('google_map_map_type_control_id'); ?>" id="<?php BCBSHelper::getFormName('google_map_map_type_control_id'); ?>">
<?php
		foreach($this->data['dictionary']['google_map']['map_type_control_id'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['meta']['google_map_map_type_control_id'],$index,false)).'>'.esc_html($value).'</option>';
?>
								</select>								
							</div>  
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('Style:','boat-charter-booking-system'); ?></span>
								<select name="<?php BCBSHelper::getFormName('google_map_map_type_control_style'); ?>" id="<?php BCBSHelper::getFormName('google_map_map_type_control_style'); ?>">
<?php
		foreach($this->data['dictionary']['google_map']['map_type_control_style'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['meta']['google_map_map_type_control_style'],$index,false)).'>'.esc_html($value).'</option>';
?>
								</select>								
							</div>							  
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('Position:','boat-charter-booking-system'); ?></span>
								<select name="<?php BCBSHelper::getFormName('google_map_map_type_control_position'); ?>" id="<?php BCBSHelper::getFormName('google_map_map_type_control_position'); ?>">
<?php
		foreach($this->data['dictionary']['google_map']['position'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['meta']['google_map_map_type_control_position'],$index,false)).'>'.esc_html($value).'</option>';
?>
								</select>								
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Zoom','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Enter settings for a zoom.','boat-charter-booking-system'); ?>
							</span> 
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('Status:','boat-charter-booking-system'); ?></span>
								<div class="to-radio-button">
									<input type="radio" value="1" id="<?php BCBSHelper::getFormName('google_map_zoom_control_enable_1'); ?>" name="<?php BCBSHelper::getFormName('google_map_zoom_control_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['google_map_zoom_control_enable'],1); ?>/>
									<label for="<?php BCBSHelper::getFormName('google_map_zoom_control_enable_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
									<input type="radio" value="0" id="<?php BCBSHelper::getFormName('google_map_zoom_control_enable_0'); ?>" name="<?php BCBSHelper::getFormName('google_map_zoom_control_enable'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['google_map_zoom_control_enable'],0); ?>/>
									<label for="<?php BCBSHelper::getFormName('google_map_zoom_control_enable_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
								</div>								
							</div>  
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('Position:','boat-charter-booking-system'); ?></span>
								<select name="<?php BCBSHelper::getFormName('google_map_zoom_control_position'); ?>" id="<?php BCBSHelper::getFormName('google_map_zoom_control_position'); ?>">
<?php
		foreach($this->data['dictionary']['google_map']['position'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(BCBSHelper::selectedIf($this->data['meta']['google_map_zoom_control_position'],$index,false)).'>'.esc_html($value).'</option>';
?>
								</select>								
							</div>
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('Level:','boat-charter-booking-system'); ?></span>
								<div class="to-clear-fix">
									<div id="<?php BCBSHelper::getFormName('google_map_zoom_control_level'); ?>"></div>
									<input type="text" name="<?php BCBSHelper::getFormName('google_map_zoom_control_level'); ?>" id="<?php BCBSHelper::getFormName('google_map_zoom_control_level'); ?>" class="to-slider-range" readonly/>
								</div>								 
							</div>   
						</li>
						<li>
							<h5><?php esc_html_e('Style','boat-charter-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Enter (in JSON format) styles for map.','boat-charter-booking-system'); ?><br/>
								<?php echo sprintf(__('You can create your own styles using <a href="%s" target="_blank">Styling Wizard</a>.','boat-charter-booking-system'),'https://mapstyle.withgoogle.com/'); ?><br/>
							</span> 
							<div class="to-clear-fix">
								<textarea rows="1" cols="1" name="<?php BCBSHelper::getFormName('google_map_style'); ?>"><?php echo esc_html($this->data['meta']['google_map_style']); ?></textarea>
							</div>						  
						</li>
					</ul> 
				</div>
			</div>
		</div>
<?php
		$GeoLocation=new BCBSGeoLocation();
		$userDefaultCoordinate=$GeoLocation->getCoordinate();
?>
		<script type="text/javascript">
			jQuery(document).ready(function($)
			{	
				/***/
				
				var helper=new BCBSHelper();
				helper.getMessageFromConsole();
				
				/***/
				
				var element=$('.to').themeOptionElement({init:true});
				element.createSlider('#<?php BCBSHelper::getFormName('google_map_zoom_control_level'); ?>',1,21,<?php echo (int)$this->data['meta']['google_map_zoom_control_level']; ?>);
				
				/***/
				
				var timeFormat='<?php echo BCBSOption::getOption('time_format'); ?>';
				var dateFormat='<?php echo BCBSJQueryUIDatePicker::convertDateFormat(BCBSOption::getOption('date_format')); ?>';
				
				toCreateCustomDateTimePicker(dateFormat,timeFormat);

				/***/
				
				$('input[name="<?php BCBSHelper::getFormName('marina_selection_mandatory'); ?>[]"]').on('change',function()
				{
					var checkbox=$(this).parents('li:first').find('input');
					
					var value=parseInt($(this).val());
					if(value===1)
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
				
				$('#to-table-form-element-panel').table();
				$('#to-table-form-element-field').table();
				$('#to-table-form-element-agreement').table();
			});
		</script>