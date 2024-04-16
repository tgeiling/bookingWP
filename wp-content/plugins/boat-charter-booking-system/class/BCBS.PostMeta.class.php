<?php

/******************************************************************************/
/******************************************************************************/

class BCBSPostMeta
{
	/**************************************************************************/
	
	static function getPostMeta($post)
	{
		$data=array();
		
		$prefix=PLUGIN_BCBS_CONTEXT.'_';
		
		if(!is_object($post)) $post=get_post($post);
		
		$meta=get_post_meta($post->ID);
		
		if(!is_array($meta)) $meta=array();
		
		foreach($meta as $metaIndex=>$metaData)
		{
			if(preg_match('/^'.$prefix.'/',$metaIndex))
				$data[preg_replace('/'.$prefix.'/','',$metaIndex)]=$metaData[0];
		}
		
		switch($post->post_type)
		{
			case PLUGIN_BCBS_CONTEXT.'_booking':
				
				self::unserialize($data,array('booking_extra','coordinate','payment_stripe_data','payment_paypal_data','form_element_panel','form_element_field'));
  
				$Booking=new BCBSBooking();
				$Booking->setPostMetaDefault($data);
				
			break;
			
			case PLUGIN_BCBS_CONTEXT.'_booking_form':
				
				self::unserialize($data,array('marina_id','currency','field_mandatory','boat_attribute_enable','style_color','form_element_panel','form_element_field','form_element_agreement','geolocation_enable','marina_selection_mandatory'));
  
				$BookingForm=new BCBSBookingForm();
				$BookingForm->setPostMetaDefault($data);
				
			break;			

			case PLUGIN_BCBS_CONTEXT.'_booking_extra':
				
				self::unserialize($data,array('boat'));
				
				$BookingExtra=new BCBSBookingExtra();
				$BookingExtra->setPostMetaDefault($data);
				
			break;
				
			case PLUGIN_BCBS_CONTEXT.'_boat':
				
				self::unserialize($data,array('marina_id','gallery_image_id','attribute','date_exclude'));
				
				$Boat=new BCBSBoat();
				$Boat->setPostMetaDefault($data);
				
			break;
		
			case PLUGIN_BCBS_CONTEXT.'_boat_attr':
				
				self::unserialize($data,array('attribute_value'));

				$BoatAttribute=new BCBSBoatAttribute();
				$BoatAttribute->setPostMetaDefault($data);
				
			break;
		
			case PLUGIN_BCBS_CONTEXT.'_price_rule':
				
				self::unserialize($data,array('booking_form_id','marina_departure_id','marina_return_id','boat_id','departure_day_number','departure_date','rental_day_count','rental_hour_count'));
				
				$PriceRule=new BCBSPriceRule();
				$PriceRule->setPostMetaDefault($data);
				
			break;
		
			case PLUGIN_BCBS_CONTEXT.'_marina':
				
				self::unserialize($data,array('boat_charter_date','boat_availability_check_type','business_hour','date_exclude','payment_id','payment_stripe_method','country_available'));
				
				$Marina=new BCBSMarina();
				$Marina->setPostMetaDefault($data);
   
				if(!is_array($data['payment_id'])) $data['payment_id']=array();
				
			break;
			
			case PLUGIN_BCBS_CONTEXT.'_coupon':
				
				self::unserialize($data,array('boat_id','boat_category_id','discount_rental_day_count'));
				
				$Coupon=new BCBSCoupon();
				$Coupon->setPostMetaDefault($data);
				
			break;
		
			case PLUGIN_BCBS_CONTEXT.'_tax_rate':
				
				$TaxRate=new BCBSTaxRate();
				$TaxRate->setPostMetaDefault($data);
				
			break;
		
			case PLUGIN_BCBS_CONTEXT.'_email_account':
				
				$EmailAccount=new BCBSEmailAccount();
				$EmailAccount->setPostMetaDefault($data);
				
			break;
		}
		
		return($data);
	}
	
	/**************************************************************************/
	
	static function unserialize(&$data,$unserializeIndex)
	{
		foreach($unserializeIndex as $index)
		{
			if(isset($data[$index]))
				$data[$index]=maybe_unserialize($data[$index]);
		}
	}
	
	/**************************************************************************/
	
	static function updatePostMeta($post,$name,$value)
	{
		$name=PLUGIN_BCBS_CONTEXT.'_'.$name;
		$postId=(int)(is_object($post) ? $post->ID : $post);
		
		update_post_meta($postId,$name,$value);
	}
	
	/**************************************************************************/
	
	static function removePostMeta($post,$name)
	{
		$name=PLUGIN_BCBS_CONTEXT.'_'.$name;
		$postId=(int)(is_object($post) ? $post->ID : $post);
		
		delete_post_meta($postId,$name);
	}
		
	/**************************************************************************/
	
	static function createArray(&$array,$index)
	{
		$array=array($index=>array());
		return($array);
	}

	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/