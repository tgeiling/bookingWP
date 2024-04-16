<?php
		$Marina=new BCBSMarina();
		$Validation=new BCBSValidation();
		
		/***/
		
		$htmlElement=array();
		
		$htmlElement['marina_departure_date_field']=
		'
			<div class="bcbs-form-field bcbs-form-field-icon bcbs-form-field-width-50">
				<span class="bcbs-meta-icon-24-date"></span>
				<label class="bcbs-form-field-label">'.esc_html__('Departure date','boat-charter-booking-system').'</label>
				<input type="text" name="'.BCBSHelper::getFormName('departure_date',false).'" class="bcbs-datepicker" value="'.BCBSRequest::get('departure_date').'"/>
			</div>	
		';
		
		$htmlElement['marina_return_date_field']=
		'
			<div class="bcbs-form-field bcbs-form-field-icon bcbs-form-field-width-50">
				<span class="bcbs-meta-icon-24-date"></span>
				<label class="bcbs-form-field-label">'.esc_html__('Return date','boat-charter-booking-system').'</label>
				<input type="text" name="'.BCBSHelper::getFormName('return_date',false).'" class="bcbs-datepicker" value="'.BCBSRequest::get('return_date').'"/>
			</div>	
		';
		
		if((int)$this->data['meta']['marina_departure_return_time_field_enable']===1)
		{
			$htmlElement['marina_departure_time_field']=
			'
				<div class="bcbs-form-field bcbs-form-field-icon bcbs-form-field-width-50">
					<span class="bcbs-meta-icon-24-date"></span>
					<label class="bcbs-form-field-label">'.esc_html__('Departure time','boat-charter-booking-system').'</label>
					<input type="text" name="'.BCBSHelper::getFormName('departure_time',false).'" class="bcbs-timepicker" value="'.BCBSRequest::get('departure_time').'"/>
				</div>
			';	
			
			$htmlElement['marina_return_time_field']=
			'
				<div class="bcbs-form-field bcbs-form-field-icon bcbs-form-field-width-50">
					<span class="bcbs-meta-icon-24-date"></span>
					<label class="bcbs-form-field-label">'.esc_html__('Return time','boat-charter-booking-system').'</label>
					<input type="text" name="'.BCBSHelper::getFormName('return_time',false).'" class="bcbs-timepicker" value="'.BCBSRequest::get('return_time').'"/>
				</div>
			';	
		}
		
		/***/
		
		$class=array();
		$columnRightEnable=true;
		
		if(($this->data['widget_mode']==1) || ((int)$this->data['google_map_enable']===0)) $columnRightEnable=false;
		
		array_push($class,($columnRightEnable ? 'bcbs-layout-50x50' : 'bcbs-layout-100'),'bcbs-clear-fix')
		
		/***/
?>
		<div class="bcbs-notice bcbs-hidden"></div>

		<div<?php echo BCBSHelper::createCSSClassAttribute($class); ?>>

			<div class="bcbs-layout-column-left">
				
				<h2><?php esc_html_e('Find and rent a boat','boat-charter-booking-system'); ?></h2>

				<div class="bcbs-form-panel bcbs-box-shadow">

					<div class="bcbs-form-panel-content bcbs-clear-fix">
<?php
		if((int)$this->data['marina_departure_field_enable']===1)
		{
?>
						<div<?php echo BCBSHelper::createCSSClassAttribute(array('bcbs-form-field bcbs-form-field-icon')); ?>>
							<span class="bcbs-meta-icon-24-location"></span>
							<label><?php esc_html_e('Place of departure','boat-charter-booking-system'); ?></label>
							<select name="<?php BCBSHelper::getFormName('marina_departure_id'); ?>">
<?php
			if(in_array(2,$this->data['meta']['marina_selection_mandatory']))
			{
?>
								<option value="-1" <?php BCBSHelper::selectedIf(-1,$this->data['marina_departure_id']); ?>><?php esc_html_e('- All marinas - ','boat-charter-booking-system'); ?></option>
							
<?php
			}

			foreach($this->data['dictionary']['marina'] as $index=>$value)
			{
?>
								<option value="<?php echo esc_attr($index); ?>" <?php BCBSHelper::selectedIf($index,$this->data['marina_departure_id']); ?>><?php esc_html_e($value['post']->post_title); ?></option>
<?php			  
			}
?>
							</select>
						</div> 
<?php
		}
?>
						<div class="bcbs-clear-fix">
<?php

								echo ($htmlElement['marina_departure_date_field'].(array_key_exists('marina_departure_time_field',$htmlElement) ? $htmlElement['marina_departure_time_field'] : $htmlElement['marina_return_date_field']));
?>
						</div>
<?php
		if((int)$this->data['marina_return_field_enable']===1 || (int)$this->data['meta']['marina_departure_return_time_field_enable']===1)
		{
			if((int)$this->data['marina_return_field_enable']===1)
			{
?>
						<div<?php echo BCBSHelper::createCSSClassAttribute(array('bcbs-form-field bcbs-form-field-icon')); ?>>
							<span class="bcbs-meta-icon-24-location"></span>
							<label><?php esc_html_e('Place of return','boat-charter-booking-system'); ?></label>
							<select name="<?php BCBSHelper::getFormName('marina_return_id'); ?>">
<?php
				if(in_array(3,$this->data['meta']['marina_selection_mandatory']))
				{
?>
								<option value="-1" <?php BCBSHelper::selectedIf(-1,$this->data['marina_departure_id']); ?>><?php esc_html_e('- All marinas - ','boat-charter-booking-system'); ?></option>
							
<?php
				}
				
				foreach($this->data['dictionary']['marina'] as $index=>$value)
				{
?>
								<option value="<?php echo esc_attr($index); ?>" <?php BCBSHelper::selectedIf($index,$this->data['marina_return_id']); ?>><?php esc_html_e($value['post']->post_title); ?></option>
<?php			  
				}
?>
							</select>
						</div> 
<?php
			}

			if((int)$this->data['meta']['marina_departure_return_time_field_enable']===1)
			{
?>
						<div class="bcbs-clear-fix">
<?php
										echo ($htmlElement['marina_return_date_field'].$htmlElement['marina_return_time_field']);
?>
						</div>
<?php
			}
		}
		
		if((int)$this->data['meta']['captain_field_enable']===1)
		{
?>
						<div<?php echo BCBSHelper::createCSSClassAttribute(array('bcbs-form-field bcbs-form-field-icon')); ?>>
							<span class="bcbs-meta-icon-24-anchor"></span>
							<label><?php esc_html_e('Sail','boat-charter-booking-system'); ?></label>
							<select name="<?php BCBSHelper::getFormName('captain_status'); ?>">
<?php
			foreach($this->data['dictionary']['captain_status'] as $index=>$value)
			{
?>
								<option value="<?php echo esc_attr($index); ?>" <?php BCBSHelper::selectedIf($index,$this->data['captain_status_selected']); ?>><?php echo esc_html($value[0]); ?></option>
<?php
			}
?>
							</select>
						</div> 						
<?php
		}
?>
					</div>
						
				</div>				
<?php
						$class=array('bcbs-button','bcbs-button-style-1');
						if($this->data['widget_mode']==1) array_push($class,'bcbs-button-widget-submit');
						else array_push($class,'bcbs-button-step-next');
?>
				<div class="bcbs-clear-fix">
					<a href="#" <?php echo BCBSHelper::createCSSClassAttribute($class); ?>>
						<?php esc_html_e('Search for Boat','boat-charter-booking-system'); ?>
					</a> 
				</div>
				
			</div>
<?php
		if($columnRightEnable)
		{
?>
			<div class="bcbs-layout-column-right">
				
				<div class="bcbs-google-map">
					
					<div id="bcbs_google_map"></div>
					
					<div id="bcbs-marina-info-frame">
<?php
			foreach($this->data['dictionary']['marina'] as $index=>$value)
			{
				$marinaMeta=$this->data['dictionary']['marina'][$index]['meta'];
?>
						<div data-marina-id="<?php echo esc_attr($index); ?>">
							
							<div class="bcbs-layout-r1">
							
								<div class="bcbs-layout-r1-c1">
<?php
				$thumbnail=get_the_post_thumbnail_url($index,PLUGIN_BCBS_CONTEXT.'_boat');
				if($thumbnail!==false) echo '<img src="'.esc_url($thumbnail).'" alt=""/>';
?>
									<a href="#" class="bcbs-button bcbs-button-style-3">
										<?php esc_html_e('Select','boat-charter-booking-system'); ?>
									</a>	
									
								</div>
								
								<div class="bcbs-layout-r1-c2">
									
									<h3 class="bcbs-marina-info-frame-marina-name">
										<?php echo esc_html($value['post']->post_title); ?>
										<span class="bcbs-meta-icon-24-close"></span>
									</h3>
									
									<div><?php echo wp_kses($Marina->displayAddress($index,', ',array('name')),array('br'=>array())); ?></div>									
									
									<div class="bcbs-layout-r1-c2-r1">
										
										<div class="bcbs-layout-r1-c2-r1-c1">
<?php
				if(($Validation->isNotEmpty($marinaMeta['berth_number'])) || ($Validation->isNotEmpty($marinaMeta['boat_max_length'])) || ($Validation->isNotEmpty($marinaMeta['boat_max_draught'])))
				{
?>
											<div class="bcbs-summary bcbs-summary-style-3">
												<div class="bcbs-summary-field">
													<div>
														<div class="bcbs-summary-field-name"><?php esc_html_e('Berth info','boat-charter-booking-system'); ?></div>
													</div>
<?php
					if($Validation->isNotEmpty($marinaMeta['berth_number'])) 
					{
?>		
													<div><?php echo sprintf(esc_html__('%s berths','boat-charter-booking-system'),$marinaMeta['berth_number']); ?></div>
<?php								
					}
					if($Validation->isNotEmpty($marinaMeta['boat_max_length'])) 
					{
?>		
													<div><?php echo sprintf(esc_html__('Max Length: %s','boat-charter-booking-system'),$marinaMeta['boat_max_length']); ?></div>
<?php								
					}
					if($Validation->isNotEmpty($marinaMeta['boat_max_draught'])) 
					{
?>		
													<div><?php echo sprintf(esc_html__('Max Draught: %s','boat-charter-booking-system'),$marinaMeta['boat_max_draught']); ?></div>
<?php								
					}
?>
												</div>	
											</div>
<?php
				}
?>
										</div>
										
										<div class="bcbs-layout-r1-c2-r1-c2">
<?php
				$businessHour=$Marina->displayBusinessHour($index);
				if($Validation->isNotEmpty($businessHour))
				{
?>							
											<div class="bcbs-summary bcbs-summary-style-3">
												<div class="bcbs-summary-field">
													<div>
														<div class="bcbs-summary-field-name"><?php esc_html_e('Business hours','boat-charter-booking-system'); ?></div>
													</div>
													<div><?php echo wp_kses($businessHour,array('br'=>array())); ?></div>
												</div>
											</div>
<?php
				}

?>
										</div>
										
									</div>
									
								</div>
								
							</div>
							
						</div>
<?php
			}
?>
					</div>
					
				</div>

			</div>
<?php
		}
?>			
		</div>