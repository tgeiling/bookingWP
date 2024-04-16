		<div class="bcbs-layout-25x75 bcbs-clear-fix">

			<div class="bcbs-layout-column-left"></div>

			<div class="bcbs-layout-column-right">
<?php
		$class=array((int)$this->data['meta']['boat_filter_bar_enable']===1 ? 'bcbs-layout-50x50' : 'bcbs-layout-100');
		array_push($class,'bcbs-clear-fix');
?>
				<div<?php echo BCBSHelper::createCSSClassAttribute($class); ?>>

					<div class="bcbs-layout-column-left">
						<div class="bcbs-boat-marina-selected-detail">
							<h2 class="bcbs-marina-selected-name"></h2>
							<div class="bcbs-marina-selected-address">
								<span class="bcbs-meta-icon-24-location"></span>
								<span></span>
							</div>
						</div>
						<div class="bcbs-boat-filer-marina">
							<div class="bcbs-form-panel bcbs-box-shadow">
								<div class="bcbs-form-panel-content bcbs-clear-fix">
									<div class="bcbs-form-field">
										<label><?php esc_html_e('Marina','boat-charter-booking-system'); ?></label>
										<select name="<?php BCBSHelper::getFormName('filter_boat_marina_id'); ?>">
											<option value="-1" <?php BCBSHelper::selectedIf(-1,$this->data['filter_boat_marina_id']); ?>><?php esc_html_e('- All marinas - ','boat-charter-booking-system'); ?></option>
<?php
			foreach($this->data['dictionary']['marina'] as $index=>$value)
			{
?>
											<option value="<?php echo esc_attr($index); ?>" <?php BCBSHelper::selectedIf($index,$this->data['filter_boat_marina_id']); ?>><?php esc_html_e($value['post']->post_title); ?></option>
<?php			  
			}
?>
										</select>						
									</div>
								</div>
							</div>
						</div>
					</div>
<?php
		if((int)$this->data['meta']['boat_filter_bar_enable']===1)
		{
?>
					<div class="bcbs-layout-column-right">
				
						<div class="bcbs-boat-filter bcbs-clear-fix">
					
							<div class="bcbs-form-panel bcbs-box-shadow">
								
								<div class="bcbs-form-panel-content bcbs-clear-fix">
					
									<div class="bcbs-form-field bcbs-form-field-width-50">
										<label><?php esc_html_e('Boat Type','boat-charter-booking-system'); ?></label>
										<select name="<?php BCBSHelper::getFormName('filter_boat_category'); ?>">
											<option value="0"><?php esc_html_e('- All boats -','boat-charter-booking-system') ?></option>
<?php
			foreach($this->data['dictionary']['boat_category'] as $index=>$value)
			{
?>
											<option value="<?php echo esc_attr($index); ?>"><?php echo esc_html($value['name']); ?></option>
<?php
			}
?>
										</select>						
									</div>

									<div class="bcbs-form-field bcbs-form-field-width-50">
										<label><?php esc_html_e('Guests','boat-charter-booking-system'); ?></label>
										<select name="<?php BCBSHelper::getFormName('filter_boat_guest'); ?>">
<?php
			for($i=$this->data['boat_guest_range']['min'];$i<=$this->data['boat_guest_range']['max'];$i++)
			{
?>
											<option value="<?php echo esc_attr($i); ?>"<?php echo ($i==1 ? ' selected="selected"' : ''); ?>><?php echo esc_html($i); ?></option>
<?php
			}
?>
										</select>
									</div>
						
								</div>
						
							</div>
					
						</div>
						
					</div>
<?php
		}
?>
				</div>
					
				<div class="bcbs-notice bcbs-hidden"></div>
				
				<div class="bcbs-boat-list">
					<ul class="bcbs-list-reset"></ul>
				</div>
				
				<div class="bcbs-booking-extra-list"></div>

			</div>

		</div>

		<div class="bcbs-clear-fix bcbs-main-content-navigation-button">
			<a href="#" class="bcbs-button bcbs-button-style-2 bcbs-button-step-prev">
				<span class="bcbs-meta-icon-24-arrow-horizontal-small"></span>
				<?php echo esc_html($this->data['step']['dictionary'][2]['button']['prev']); ?>
			</a> 
			<a href="#" class="bcbs-button bcbs-button-style-1 bcbs-button-step-next">
				<?php echo esc_html($this->data['step']['dictionary'][2]['button']['next']); ?>
				<span class="bcbs-meta-icon-24-arrow-horizontal-small"></span>
			</a> 
		</div>