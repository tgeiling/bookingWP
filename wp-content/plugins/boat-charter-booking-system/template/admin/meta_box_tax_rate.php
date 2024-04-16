<?php 
		echo BCBSHelper::displayNonce($this->data);; 
?>	
		<div class="to">
			<div class="ui-tabs">
				<ul>
					<li><a href="#meta-box-tax-rate-1"><?php esc_html_e('General','boat-charter-booking-system'); ?></a></li>
				</ul>
				<div id="meta-box-tax-rate-1">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Value','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Percentage value of tax rate. Floating point values are allowed, up to two decimal places in the range 0-100.','boat-charter-booking-system'); ?></span>
							<div>
								<input type="text" maxlength="5" name="<?php BCBSHelper::getFormName('tax_rate_value'); ?>" id="<?php BCBSHelper::getFormName('tax_rate_value'); ?>" value="<?php echo esc_attr($this->data['meta']['tax_rate_value']); ?>"/>
							</div>
						</li>  
						<li>
							<h5><?php esc_html_e('Default tax rate','boat-charter-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Mark this tax rate as default.','boat-charter-booking-system'); ?></span>
							<div class="to-radio-button">
								<input type="radio" value="1" id="<?php BCBSHelper::getFormName('tax_rate_default_1'); ?>" name="<?php BCBSHelper::getFormName('tax_rate_default'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['tax_rate_default'],1); ?>/>
								<label for="<?php BCBSHelper::getFormName('tax_rate_default_1'); ?>"><?php esc_html_e('Yes','boat-charter-booking-system'); ?></label>
								<input type="radio" value="0" id="<?php BCBSHelper::getFormName('tax_rate_default_0'); ?>" name="<?php BCBSHelper::getFormName('tax_rate_default'); ?>" <?php BCBSHelper::checkedIf($this->data['meta']['tax_rate_default'],0); ?>/>
								<label for="<?php BCBSHelper::getFormName('tax_rate_default_0'); ?>"><?php esc_html_e('No','boat-charter-booking-system'); ?></label>
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
			});
		</script>