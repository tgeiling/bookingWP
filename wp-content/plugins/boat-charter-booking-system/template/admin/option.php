		<div class="to to-to" style="display:none">

			<form name="to_form" id="to_form" method="POST" action="#">

				<div id="to_notice"></div> 

				<div class="to-header to-clear-fix">

					<div class="to-header-left">

						<div>
							<h3><?php esc_html_e('QuanticaLabs','boat-charter-booking-system'); ?></h3>
							<h6><?php esc_html_e('Plugin Options','boat-charter-booking-system'); ?></h6>
						</div>

					</div>

					<div class="to-header-right">

						<div>
							<h3>
								<?php esc_html_e('Boat and Yacht Charter Booking System','boat-charter-booking-system'); ?>
							</h3>
							<h6>
								<?php echo sprintf(esc_html__('WordPress Plugin ver. %s','boat-charter-booking-system'),PLUGIN_BCBS_VERSION); ?>
							</h6>
							&nbsp;&nbsp;
							<a href="<?php echo esc_url('http://support.quanticalabs.com'); ?>" target="_blank"><?php esc_html_e('Support Forum','boat-charter-booking-system'); ?></a>
							<a href="<?php echo esc_url('https://1.envato.market/boat-and-yacht-charter-booking-system-for-wordpress'); ?>" target="_blank"><?php esc_html_e('Plugin site','boat-charter-booking-system'); ?></a>
						</div>

						<a href="<?php echo esc_url('http://quanticalabs.com'); ?>" class="to-header-right-logo"></a>

					</div>

				</div>

				<div class="to-content to-clear-fix">

					<div class="to-content-left">

						<ul class="to-menu" id="to_menu">
							<li>
								<a href="#general"><?php esc_html_e('General','boat-charter-booking-system'); ?><span></span></a>
							</li>
							<li>
								<a href="#import_demo"><?php esc_html_e('Import demo','boat-charter-booking-system'); ?><span></span></a>
							</li>
							<li>
								<a href="#payment"><?php esc_html_e('Payments','boat-charter-booking-system'); ?><span></span></a>
							</li>
							<li>
								<a href="#coupon_creator"><?php esc_html_e('Coupons creator','boat-charter-booking-system'); ?><span></span></a>
							</li>
							<li>
								<a href="#exchange_rate"><?php esc_html_e('Exchange rates','boat-charter-booking-system'); ?><span></span></a>
							</li>
							<li>
								<a href="#log_manager"><?php esc_html_e('Log manager','boat-charter-booking-system'); ?><span></span></a>
								<ul>
									<li><a href="#log_manager_mail"><?php esc_html_e('Mail','boat-charter-booking-system'); ?></a></li>
									<li><a href="#log_manager_twilio"><?php esc_html_e('Twilio','boat-charter-booking-system'); ?></a></li>
									<li><a href="#log_manager_stripe"><?php esc_html_e('Stripe','boat-charter-booking-system'); ?></a></li>
									<li><a href="#log_manager_paypal"><?php esc_html_e('PayPal','boat-charter-booking-system'); ?></a></li>
									<li><a href="#log_manager_nexmo"><?php esc_html_e('Vonage','boat-charter-booking-system'); ?></a></li>
									<li><a href="#log_manager_fixerio"><?php esc_html_e('Fixer.io','boat-charter-booking-system'); ?></a></li>
									<li><a href="#log_manager_telegram"><?php esc_html_e('Telegram','boat-charter-booking-system'); ?></a></li>
									<li><a href="#log_manager_geolocation"><?php esc_html_e('Geolocation','boat-charter-booking-system'); ?></a></li>
									<li><a href="#log_manager_google_calendar"><?php esc_html_e('Google Calendar','boat-charter-booking-system'); ?></a></li>
								</ul>		
							</li>
						</ul>

					</div>

					<div class="to-content-right" id="to_panel">
<?php
		$content=array
		(
			'general',
			'import_demo',
			'payment',
			'coupon_creator',
			'exchange_rate',
			'log_manager_mail',
			'log_manager_nexmo',
			'log_manager_stripe',
			'log_manager_paypal',
			'log_manager_fixerio',
			'log_manager_twilio',
			'log_manager_telegram',
			'log_manager_geolocation',
			'log_manager_google_calendar'
		);

		foreach($content as $value)
		{
?>
						<div id="<?php echo esc_attr($value); ?>">
<?php
				echo BCBSTemplate::outputS($this->data,PLUGIN_BCBS_TEMPLATE_PATH.'admin/option_'.$value.'.php');
?>
						</div>
<?php
		}
?>
					</div>

				</div>

				<div class="to-footer to-clear-fix">

					<div class="to-footer-left">

						<ul class="to-social-list">
							<li><a href="<?php echo esc_url('http://themeforest.net/user/QuanticaLabs?ref=quanticalabs'); ?>" class="to-social-list-envato" title="<?php esc_attr_e('Envato','boat-charter-booking-system'); ?>"></a></li>
							<li><a href="<?php echo esc_url('http://www.facebook.com/QuanticaLabs'); ?>" class="to-social-list-facebook" title="<?php esc_attr_e('Facebook','boat-charter-booking-system'); ?>"></a></li>
							<li><a href="<?php echo esc_url('https://twitter.com/quanticalabs'); ?>" class="to-social-list-twitter" title="<?php esc_attr_e('Twitter','boat-charter-booking-system'); ?>"></a></li>
							<li><a href="<?php echo esc_url('http://quanticalabs.tumblr.com/'); ?>" class="to-social-list-tumblr" title="<?php esc_attr_e('Tumblr','boat-charter-booking-system'); ?>"></a></li>
						</ul>

					</div>

					<div class="to-footer-right">
						<input type="submit" value="<?php esc_attr_e('Save changes','boat-charter-booking-system'); ?>" name="Submit" id="Submit" class="to-button"/>
					</div>			

				</div>

				<input type="hidden" name="action" id="action" value="<?php echo esc_attr(PLUGIN_BCBS_CONTEXT.'_option_page_save'); ?>" />

				<script type="text/javascript">

					jQuery(document).ready(function($)
					{
						$('.to').themeOption({afterSubmit:function(response)
						{
							if(typeof(response.global.reload)!='undefined')
								location.reload();

							return(false);
						}});

						var element=$('.to').themeOptionElement({init:true});

						element.bindBrowseMedia('input[name="bcbs_logo_browse"]');
						element.bindBrowseMedia('input[name="bcbs_attachment_woocommerce_email_browse"]',false,2,'');
					});

				</script>

			</form>

		</div>