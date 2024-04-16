<?php

/******************************************************************************/
/******************************************************************************/

$Currency=new BCBSCurrency();
$BookingForm=new BCBSBookingForm();
$VisualComposer=new BCBSVisualComposer();

vc_map
( 
	array
	(
		'base'=>BCBSBookingForm::getShortcodeName(),
		'name'=>esc_html__('Boat Charter Booking Form','boat-charter-booking-system'),
		'description'=>esc_html__('Displays booking from.','boat-charter-booking-system'),
		'category'=>esc_html__('Content','templatica'),
		'params'=>array
		(
			array
			(
				'type'=>'dropdown',
				'param_name'=>'booking_form_id',
				'heading'=>esc_html__('Booking form','boat-charter-booking-system'),
				'description'=>esc_html__('Select booking form which has to be displayed.','boat-charter-booking-system'),
				'value'=>$VisualComposer->createParamDictionary($BookingForm->getDictionary()),
				'admin_label'=>true
			),
			array
			(
				'type'=>'dropdown',
				'param_name'=>'currency',
				'heading'=>esc_html__('Currency','boat-charter-booking-system'),
				'description'=>esc_html__('Select currency of booking form.','boat-charter-booking-system'),
				'value'=>$VisualComposer->createParamDictionary($Currency->getCurrency()),
				'admin_label'=>true
			)
		)
	)
);  