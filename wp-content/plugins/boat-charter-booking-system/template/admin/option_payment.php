        <ul class="to-form-field-list">
            <li>
                <h5><?php esc_html_e('Booking status after successful payment','boat-charter-booking-system'); ?></h5>
                <span class="to-legend"><?php esc_html_e('Set selected status of the booking after the successful payment.','boat-charter-booking-system'); ?></span>
				<div class="to-radio-button">
					<input type="radio" value="-1" id="<?php BCBSHelper::getFormName('booking_status_payment_success_0'); ?>" name="<?php BCBSHelper::getFormName('booking_status_payment_success'); ?>" <?php BCBSHelper::checkedIf($this->data['option']['booking_status_payment_success'],-1); ?>/>
					<label for="<?php BCBSHelper::getFormName('booking_status_payment_success_0'); ?>"><?php esc_html_e('[No changes]','boat-charter-booking-system'); ?></label>
<?php
		foreach($this->data['dictionary']['booking_status'] as $index=>$value)
		{
?>
                    <input type="radio" value="<?php echo esc_attr($index); ?>" id="<?php BCBSHelper::getFormName('booking_status_payment_success_'.$index); ?>" name="<?php BCBSHelper::getFormName('booking_status_payment_success'); ?>" <?php BCBSHelper::checkedIf($this->data['option']['booking_status_payment_success'],$index); ?>/>
                    <label for="<?php BCBSHelper::getFormName('booking_status_payment_success_'.$index); ?>"><?php echo esc_html($value[0]); ?></label>
<?php		
        }
?>
				</div>
				<div class="to-clear-fix">
					<span class="to-legend-field"><?php esc_html_e('Set the same status if the booking sum is zero:','boat-charter-booking-system'); ?></span>
					<div class="to-radio-button">
						<input type="radio" value="1" id="<?php BCBSHelper::getFormName('booking_status_sum_zero_1'); ?>" name="<?php BCBSHelper::getFormName('booking_status_sum_zero'); ?>" <?php BCBSHelper::checkedIf($this->data['option']['booking_status_sum_zero'],1); ?>/>
						<label for="<?php BCBSHelper::getFormName('booking_status_sum_zero_1'); ?>"><?php esc_html_e('Enable','boat-charter-booking-system'); ?></label>
						<input type="radio" value="0" id="<?php BCBSHelper::getFormName('booking_status_sum_zero_0'); ?>" name="<?php BCBSHelper::getFormName('booking_status_sum_zero'); ?>" <?php BCBSHelper::checkedIf($this->data['option']['booking_status_sum_zero'],0); ?>/>
						<label for="<?php BCBSHelper::getFormName('booking_status_sum_zero_0'); ?>"><?php esc_html_e('Disable','boat-charter-booking-system'); ?></label>
					</div>
				</div>	
			</li> 
            <li>
                <h5><?php esc_html_e('Booking statuses synchronization','boat-charter-booking-system'); ?></h5>
                <span class="to-legend">
                    <?php esc_html_e('Synchronize booking statuses between plugin and wooCommerce.','boat-charter-booking-system'); ?>
                </span>
				<div class="to-radio-button">
<?php
		foreach($this->data['dictionary']['booking_status_synchronization'] as $index=>$value)
		{
?>
                    <input type="radio" value="<?php echo esc_attr($index); ?>" id="<?php BCBSHelper::getFormName('booking_status_synchronization_'.$index); ?>" name="<?php BCBSHelper::getFormName('booking_status_synchronization'); ?>" <?php BCBSHelper::checkedIf($this->data['option']['booking_status_synchronization'],$index); ?>/>
                    <label for="<?php BCBSHelper::getFormName('booking_status_synchronization_'.$index); ?>"><?php echo esc_html($value[0]); ?></label>
<?php		
        }
?>
				</div>
            </li>  
		</ul>

