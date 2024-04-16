<?php	
		global $post;
		
		$Validation=new BCBSValidation();

		$class=array('bcbs-main','bcbs-booking-form-id-'.$this->data['booking_form_post_id'],'bcbs-clear-fix','bcbs-hidden');
		
		if($this->data['widget_mode']==1)
			array_push($class,'bcbs-booking-form-widget-mode','bcbs-booking-form-widget-mode-style-'.$this->data['widget_booking_form_style_id']);
?>
		<div<?php echo BCBSHelper::createCSSClassAttribute($class); ?> id="<?php echo esc_attr($this->data['booking_form_html_id']); ?>">
			
			<form name="bcbs-form" enctype="multipart/form-data">
<?php
		if((int)$this->data['meta']['navigation_top_enable']===1)
		{
			if($this->data['widget_mode']!=1)
			{
?>
				<div class="bcbs-main-navigation-default bcbs-clear-fix" data-step-count="<?php echo count($this->data['step']['dictionary']); ?>">
					<ul class="bcbs-list-reset">
<?php
				foreach($this->data['step']['dictionary'] as $index=>$value)
				{
					$class=array();
					if($index==1) array_push($class,'bcbs-state-selected');
?>		   
						<li data-step="<?php echo esc_attr($index); ?>"<?php echo BCBSHelper::createCSSClassAttribute($class); ?> >
							<div></div>
							<a href="#">
								<span>
									<span class="bcbs-meta-icon-24-tick"></span>
									<span class="bcbs-meta-icon-16-yacht"></span>
									<span></span>
								</span>
								<span><?php echo esc_html($value['navigation']['label']); ?></span>
							</a>
						</li>	   
<?php		  
				}
?>
					</ul>
				</div>
				
				<div class="bcbs-main-navigation-responsive bcbs-clear-fix">
					<div class="bcbs-form-field">
						<label class="bcbs-form-field-label"><?php esc_html_e('Go To:','boat-charter-booking-system'); ?></label>
						<select name="<?php BCBSHelper::getFormName('navigation_responsive'); ?>" data-value="1">
<?php
				foreach($this->data['step']['dictionary'] as $index=>$value)
				{
?>			
							<option value="<?php echo esc_attr($index); ?>">
								<?php echo esc_html($value['navigation']['number'].'. '.$value['navigation']['label']); ?>
							</option>	   
<?php		  
				}		  
?>				
						</select>
					</div>
				</div>
<?php
			}
		}
?>
				<div class="bcbs-main-content bcbs-clear-fix">
<?php
		for($i=1;$i<=($this->data['widget_mode']===1 ? 1 : 5);$i++)
		{
?> 
					<div class="bcbs-main-content-step-<?php echo esc_attr($i); ?>">
<?php
			echo BCBSTemplate::outputS($this->data,PLUGIN_BCBS_TEMPLATE_PATH.'public/public-step-'.$i.'.php');
?>
					</div>
<?php
		}
?>
				</div>
				
				<input type="hidden" name="action" data-value=""/>
				
				<input type="hidden" name="<?php BCBSHelper::getFormName('step'); ?>" data-value="1"/>
				<input type="hidden" name="<?php BCBSHelper::getFormName('step_request'); ?>" data-value="1"/>

				<input type="hidden" name="<?php BCBSHelper::getFormName('boat_id'); ?>" data-value="<?php echo esc_attr($this->data['boat_id']); ?>"/>
				<input type="hidden" name="<?php BCBSHelper::getFormName('boat_id_only'); ?>" data-value="<?php echo esc_attr($this->data['boat_id_only']); ?>"/>
				
				<input type="hidden" name="<?php BCBSHelper::getFormName('payment_id'); ?>" data-value="0"/>
				<input type="hidden" name="<?php BCBSHelper::getFormName('booking_extra_id'); ?>" data-value="0"/>
				
				<input type="hidden" name="<?php BCBSHelper::getFormName('booking_form_id'); ?>" data-value="<?php echo esc_attr($this->data['booking_form_post_id']); ?>"/>
				
				<input type="hidden" name="<?php BCBSHelper::getFormName('post_id'); ?>" data-value="<?php echo esc_attr($post->ID); ?>"/>
				
				<input type="hidden" name="<?php BCBSHelper::getFormName('currency'); ?>" data-value="<?php echo esc_attr($this->data['currency']); ?>"/>
								
			</form>
			
			<div id="bcbs-payment-form">
<?php
		foreach($this->data['dictionary']['marina'] as $index=>$value)
		{
			if(in_array(3,$value['meta']['payment_id']))
			{
				echo BCBSPaymentPaypal::createPaymentForm($post->ID,$index,$value);
			}
		}
?>  
			</div>
<?php
		if((int)$this->data['meta']['form_preloader_enable']===1)
		{
?>
			<div id="bcbs-preloader"></div>
<?php
		}
?>
			<div id="bcbs-preloader-start"></div>
			
		</div>

		<script type="text/javascript">
			jQuery(document).ready(function($)
			{
				$('#<?php echo esc_attr($this->data['booking_form_html_id']); ?>').BCBSBookingForm(
				{
					booking_form_id:<?php echo (int)$this->data['post']->ID; ?>,
					plugin_version:'<?php echo PLUGIN_BCBS_VERSION; ?>',
					widget:
					{
						mode:<?php echo (int)$this->data['widget_mode']; ?>,
						booking_form_url:'<?php echo esc_url($this->data['widget_booking_form_url']); ?>'
					},
					ajax_url:'<?php echo esc_url($this->data['ajax_url']); ?>',
					plugin_url:'<?php echo PLUGIN_BCBS_URL; ?>',
					time_format:'<?php echo BCBSOption::getOption('time_format'); ?>',
					date_format:'<?php echo BCBSOption::getOption('date_format'); ?>',
					date_format_js:'<?php echo BCBSJQueryUIDatePicker::convertDateFormat(BCBSOption::getOption('date_format')); ?>',
					timepicker_step:'<?php echo esc_attr($this->data['meta']['timepicker_step']); ?>',
					boat_count_enable:<?php echo (int)$this->data['meta']['boat_count_enable']; ?>,
					summary_sidebar_sticky_enable:<?php echo (int)$this->data['meta']['summary_sidebar_sticky_enable']; ?>,
					marina_departure_id:<?php echo (int)$this->data['marina_departure_id']; ?>,
					marina_return_id:<?php echo (int)$this->data['marina_return_id']; ?>,
					marina_info:<?php echo json_encode($this->data['marina_info']); ?>,
					marina_date_exclude:<?php echo json_encode($this->data['marina_date_exclude']); ?>,
					marina_business_hour:<?php echo json_encode($this->data['marina_business_hour']); ?>,
					marina_departure_period:<?php echo json_encode($this->data['marina_departure_period']); ?>,
					marina_coordinate:<?php echo json_encode($this->data['marina_coordinate']); ?>,
					marina_after_business_hour_departure_enable:<?php echo json_encode($this->data['marina_after_business_hour_departure_enable']); ?>,
					marina_after_business_hour_return_enable:<?php echo json_encode($this->data['marina_after_business_hour_return_enable']); ?>,
					marina_date_departure_return_the_same_enable:<?php echo json_encode($this->data['marina_date_departure_return_the_same_enable']); ?>,
					marina_boat_id_default:<?php echo json_encode($this->data['marina_boat_id_default']); ?>,
					marina_client_country_default:<?php echo json_encode($this->data['marina_client_country_default']); ?>,
					marina_payment_paypal_redirect_duration:<?php echo json_encode($this->data['marina_payment_paypal_redirect_duration']); ?>,
					client_coordinate:<?php echo json_encode($this->data['client_coordinate']); ?>,
					gooogleMapOption:
					{
						draggable:
						{
							enable:<?php echo (int)$this->data['meta']['google_map_draggable_enable']; ?>
						},
						scrollwheel:
						{
							enable:<?php echo (int)$this->data['meta']['google_map_scrollwheel_enable']; ?>
						},
						mapControl:
						{
							enable:<?php echo (int)$this->data['meta']['google_map_map_type_control_enable']; ?>,
							id:'<?php echo esc_attr($this->data['meta']['google_map_map_type_control_id']); ?>',
							style:'<?php echo esc_attr($this->data['meta']['google_map_map_type_control_style']); ?>',
							position:'<?php echo esc_attr($this->data['meta']['google_map_map_type_control_position']); ?>'
						},
						zoomControl:
						{
							enable:<?php echo (int)$this->data['meta']['google_map_zoom_control_enable']; ?>,
							style:'<?php echo esc_attr($this->data['meta']['google_map_zoom_control_style']); ?>',
							position:'<?php echo esc_attr($this->data['meta']['google_map_zoom_control_position']); ?>',
							level:<?php echo (int)$this->data['meta']['google_map_zoom_control_level']; ?>
						},
						style:<?php echo ($Validation->isEmpty($this->data['meta']['google_map_style']) ? '[]' : $this->data['meta']['google_map_style']); ?>
					},
					booking_form_color:<?php echo json_encode($this->data['booking_form_color']); ?>,
					is_rtl:<?php echo (int)is_rtl(); ?>,
					scroll_to_booking_extra_after_select_boat_enable:<?php echo (int)$this->data['meta']['scroll_to_booking_extra_after_select_boat_enable']; ?>,
					current_date:'<?php echo date_i18n('d-m-Y'); ?>',
					current_time:'<?php echo date_i18n('H:i'); ?>'
				}).setup();
			});
		</script>
			