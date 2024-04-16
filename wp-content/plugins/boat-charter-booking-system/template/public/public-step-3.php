<?php
		$BookingFormElement=new BCBSBookingFormElement();
?>
		<div class="bcbs-layout-25x75 bcbs-clear-fix">

			<div class="bcbs-layout-column-left"></div>

			<div class="bcbs-layout-column-right">

				<div class="bcbs-notice bcbs-hidden"></div>
				
				<div class="bcbs-client-form"></div>

				<div id="bcbs-payment"></div>
<?php		
		echo BCBSBookingFormElement::createAgreementS($this->data['meta']);
?>
			</div>   
			
		</div>

		<div class="bcbs-clear-fix bcbs-main-content-navigation-button">
			<a href="#" class="bcbs-button bcbs-button-style-2 bcbs-button-step-prev">
				<span class="bcbs-meta-icon-24-arrow-horizontal-small"></span>
				<?php echo esc_html($this->data['step']['dictionary'][3]['button']['prev']); ?>
			</a> 
			<a href="#" class="bcbs-button bcbs-button-style-1 bcbs-button-step-next">
				<?php echo esc_html($this->data['step']['dictionary'][3]['button']['next']); ?>
				<span class="bcbs-meta-icon-24-arrow-horizontal-small"></span>
			</a> 
		</div>