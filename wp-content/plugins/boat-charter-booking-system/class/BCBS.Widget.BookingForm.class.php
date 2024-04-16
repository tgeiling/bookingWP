<?php

/******************************************************************************/
/******************************************************************************/

class BCBSWidgetBookingForm extends BCBSWidget 
{
	/**************************************************************************/
	
	function __construct() 
	{
		parent::__construct('bcbs_widget_booking_form',esc_html__('Boat Charter Booking Form','boat-charter-booking-system'),array('description'=>esc_html__('Displays booking form.','boat-charter-booking-system')),array());
	}
	
	/**************************************************************************/
	
	function widget($argument,$instance) 
	{
		$argument['_data']['file']='widget_booking_form.php';
		parent::widget($argument,$instance);
	}
	
	/**************************************************************************/
	
	function update($new_instance,$old_instance)
	{
		$instance=array();
		$instance['title']=$new_instance['title'];
		$instance['boat_id']=(int)$new_instance['boat_id'];
		$instance['booking_form_id']=(int)$new_instance['booking_form_id'];
		$instance['booking_form_style_id']=(int)$new_instance['booking_form_style_id'];
		$instance['booking_form_url']=$new_instance['booking_form_url'];
		$instance['booking_form_currency']=$new_instance['booking_form_currency'];
		return($instance);
	}
	
	/**************************************************************************/
	
	function form($instance) 
	{	
		$instance['_data']['file']='widget_booking_form.php';
		$instance['_data']['field']=array('title','boat_id','booking_form_id','booking_form_style_id','booking_form_url','booking_form_currency');
		parent::form($instance);
	}
	
	/**************************************************************************/
	
	function register($class=null)
	{
		parent::register(is_null($class) ? get_class() : $class);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/