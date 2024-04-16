<?php

/******************************************************************************/
/******************************************************************************/

class BCBSBoatAvailabilityCalendar
{
	/**************************************************************************/
	   
	function __construct()
	{
		
	}
	
	
	/**************************************************************************/
	
	function createHeaderDate($year,$monthName)
	{
		$html=
		'
			<h2>'.esc_html($monthName.' '.$year).'</h2>
			<a href="#" title="'.esc_attr('Previous month','boat-charter-booking-system').'"><span class="bcbs-meta-icon-24-arrow-horizontal"></span></a>
			<a href="#" title="'.esc_attr('Next month','boat-charter-booking-system').'"><span class="bcbs-meta-icon-24-arrow-horizontal"></span></a>
		';
		
		return($html);
	}
	
	/**************************************************************************/
	
	function ajax()
	{
		$response=array();
	
		$data=BCBSHelper::getPostOption();
		
		$response['error']=$this->checkRequest($data['boat_availability_calendar_boat_id'],$data['boat_availability_calendar_booking_form_id']);
		if(count($response['error'])) die();
		
		$date=$this->getDate();

		$response['boat_availability_calendar_calendar']=$this->createBoatAvailabilityCalendar($date['boat_availability_calendar_year_number'],$date['boat_availability_calendar_month_number'],$data['boat_availability_calendar_boat_id']);
		$response['boat_availability_calendar_header']=$date['boat_availability_calendar_month_name'].' '.$date['boat_availability_calendar_year_number'];
		
		BCBSHelper::createJSONResponse($response);
	}
	
	/**************************************************************************/
	
	function getDate()
	{
		$DateTime=new DateTime();
		$Validation=new BCBSValidation();
		
		/***/
		
		$year=null;
		$month=null;
	
		/***/
		
		$data=BCBSHelper::getPostOption();
			
		if(array_key_exists('boat_availability_calendar_year_number',$data))
			$year=$data['boat_availability_calendar_year_number'];	
		if(array_key_exists('boat_availability_calendar_month_number',$data))
			$month=$data['boat_availability_calendar_month_number'];		
		
		/***/
		
		if(($Validation->isNotEmpty($year)) && ($Validation->isNotEmpty($month)))
			$DateTime->setDate($year,$month,1);
		
		/***/
		
		$response=array();
		
		$response['boat_availability_calendar_year_number']=$DateTime->format('Y');
		$response['boat_availability_calendar_month_number']=$DateTime->format('m');
		$response['boat_availability_calendar_month_name']=$DateTime->format('F');
		
		return($response);
	}
	
	/**************************************************************************/
	
	function createBoatAvailabilityCalendarShortcode($attr)
	{
		$default=array
		(
			'boat_id'=>0,
			'booking_form_id'=>0
		);
		
		$attribute=shortcode_atts($default,$attr);	
	
		$data=array();
		
		$data['error']=$this->checkRequest($attribute['boat_id'],$attribute['booking_form_id']);
		
		$data['boat_availability_calendar_boat_id']=$attribute['boat_id'];
		$data['boat_availability_calendar_booking_form_id']=$attribute['booking_form_id'];
		
		$data['boat_availability_calendar_booking_form_html_id']=BCBSHelper::createId('bcbs_boat_availability_calendar');
		
		if(count($data['error'])===0)
		{
			$date=$this->getDate();

			$data['boat_availability_calendar_year_number']=$date['boat_availability_calendar_year_number'];
			$data['boat_availability_calendar_month_number']=$date['boat_availability_calendar_month_number'];

			$data['boat_availability_calendar_calendar']=$this->createBoatAvailabilityCalendar($date['boat_availability_calendar_year_number'],$date['boat_availability_calendar_month_number'],$attribute['boat_id']);

			$data['boat_availability_calendar_header']=$this->createHeaderDate($date['boat_availability_calendar_year_number'],$date['boat_availability_calendar_month_name']);

			$data['ajax_url']=admin_url('admin-ajax.php');
		}
		
		$Template=new BCBSTemplate($data,PLUGIN_BCBS_TEMPLATE_PATH.'public/boat_availability_calendar.php');
		return($Template->output());		
	}

	/**************************************************************************/
	
	function createBoatAvailabilityCalendar($year,$month,$boatId)
	{
		$html=null;
		
		$Date=new BCBSDate();
		
		/***/
		
		$date=$this->getAvaialability($year,$month,$boatId);
			
		/***/
		
		$tableHeadHtml=null;
		for($i=1;$i<=7;$i++)
			$tableHeadHtml.='<th><div>'.esc_html($Date->day[$i][0][0]).'</div></th>';
		
		/***/
		
		$cellCounter=0;
		
		$tableCellHtml=null;
		$tableBodyHtml=null;
		
		$DateTime=new DateTime('01-'.$month.'-'.$year);
		
		for($i=1;$i<=31;$i++)
		{
			$dayOfWeekNumber=$DateTime->format('N');
			
			if($i===1)
			{
				for($j=1;$j<$dayOfWeekNumber;$j++) $tableCellHtml.='<td><div></div></td>';
				$cellCounter+=$dayOfWeekNumber-1;
			}
			
			$title=null;
			$class=array();
			
			if(isset($date[$i])) 
			{
				$title=$date[$i]['text'];
				$class[]='bcbs-boat-availability-calendar-date-not-available';
			}
			
			$tableCellHtml.=
			'
				<td'.BCBSHelper::createCSSClassAttribute($class).' title="'.esc_attr($title).'">
					<div>
						'.$DateTime->format('d').'
					</div>
				</td>
			';
			
			$cellCounter++;
			
			$DateTime->modify('+1 day');
			
			$break=false;
			
			if((int)$DateTime->format('n')!==(int)$month)
			{
				$break=true;
				
				if($cellCounter%7!==0)
				{
					$maxCellCounter=(floor($cellCounter/7)+1)*7;
				
					for($j=$cellCounter;$j<$maxCellCounter;$j++) $tableCellHtml.='<td><div></div></td>';
				
					$cellCounter=$maxCellCounter;
				}
			}
			
			if($cellCounter%7===0)
			{
				$tableBodyHtml.='<tr>'.$tableCellHtml.'</tr>';
				$tableCellHtml=null;
			}
			
			if($break) break;
		}
		
		/***/
		
		$html.=
		'
			<table cellspacing="0px" cellpadding="0px">
				<thead>
					'.$tableHeadHtml.'
				</thead>
				<tbody>
					'.$tableBodyHtml.'
				</tbody>
			</table>
		';
			
		/***/
		
		return($html);
	}
	
	/**************************************************************************/

	function getAvaialability($year,$month,$boatId)
	{
		$date=array();
		
		$Boat=new BCBSBoat();
		$Date=new BCBSDate();
		$Marina=new BCBSMarina();
		$Validation=new BCBSValidation();
		
		$boatDictionary=$Boat->getDictionary();
		$marinaDictionary=$Marina->getDictionary();
		
		/***/
		
		if(array_key_exists($boatId,$boatDictionary))
		{
			/***/
			
			if((is_array($boatDictionary[$boatId]['meta']['date_exclude'])) && (count($boatDictionary[$boatId]['meta']['date_exclude'])))
			{
				$dateExclude=$boatDictionary[$boatId]['meta']['date_exclude'];
				
				for($i=1;$i<=31;$i++)
				{
					if(checkdate($month,$i,$year)) 
					{
						$dateTemp=$i.'-'.$month.'-'.$year;

						foreach($dateExclude as $dateExcludeIndex=>$dateExcludeValue)	
						{
							if($Date->dateInRange($dateTemp,$dateExcludeValue['start_date'],$dateExcludeValue['stop_date']))
							{
								$date[$i]['marina_id']=array(-1);
							}

						}
					}
				}
			}
		
			/***/
			
			if((is_array($boatDictionary[$boatId]['meta']['marina_id'])) && (count($boatDictionary[$boatId]['meta']['marina_id'])))
			{
				$marina=$boatDictionary[$boatId]['meta']['marina_id'];
				
				foreach($marina as $marinaId)
				{
					if(array_key_exists($marinaId,$marinaDictionary))
					{
						if((is_array($marinaDictionary[$marinaId]['meta']['date_exclude'])) && (count($marinaDictionary[$marinaId]['meta']['date_exclude'])))
						{
							$dateExclude=$marinaDictionary[$marinaId]['meta']['date_exclude'];
							
							for($i=1;$i<=31;$i++)
							{
								if(checkdate($month,$i,$year)) 
								{
									$dateTemp=$i.'-'.$month.'-'.$year;

									foreach($dateExclude as $dateExcludeIndex=>$dateExcludeValue)	
									{
										if($Date->dateInRange($dateTemp,$dateExcludeValue['start'],$dateExcludeValue['stop']))
										{
											$date[$i]['marina_id'][]=$marinaId;

											if(count($date[$i]['marina_id'])===count($marina))
											{
												$date[$i]['marina_id']=array(-1);
											}
										}
									}
								}
							}							
						}
					}
				}
			}
		
			/***/
			
			global $post;
			
			$argument=array
			(
				'post_type'=>BCBSBooking::getCPTName(),
				'post_status'=>'publish',
				'posts_per_page'=>-1,
				'suppress_filters'=>true,
				'meta_query'=>array
				(
					array
					(
						'key'=>PLUGIN_BCBS_CONTEXT.'_boat_id',
						'value'=>$boatId,
						'compare'=>'='
					)
				)
			);
		
			$query=new WP_Query($argument);	
			if($query===false) return(false);

			while($query->have_posts())
			{
				$query->the_post();	

				$meta=BCBSPostMeta::getPostMeta($post);
			
				$status=BCBSOption::getOption('booking_status_nonblocking');
				if(is_array($status))
				{
					if(in_array($meta['booking_status_id'],$status)) continue;
				}	
	
				for($i=1;$i<=31;$i++)
				{
					if(checkdate($month,$i,$year)) 
					{
						$dateTemp=$i.'-'.$month.'-'.$year;
						if($Date->dateInRange($dateTemp,$meta['departure_date'],$meta['return_date']))
						{
							$date[$i]['marina_id']=array(-1);
						}
					}
				}					
			}
			
			/***/
		}
		
		/***/
		
		foreach($date as $index=>$value)
		{
			if(in_array(-1,$value['marina_id']))
			{
				$date[$index]['text']=__('This boat is not available in all marinas.','boat-charter-booking-system');
			}
			else
			{
				$text=null;
				
				foreach($value['marina_id'] as $marinaId)
				{
					if($Validation->isNotEmpty($text)) $text.=',';
					$text.=$marinaDictionary[$marinaId]['post']->post_title;
				}
				
				$date[$index]['text']=sprintf(__('This boat is not available in the following marinas: %s.','boat-charter-booking-system'),$text);
			}
		}
		
		/***/
		
		return($date);
	}
	
	/**************************************************************************/
	
	function checkRequest($boatId,&$bookingFormId)
	{
		$Boat=new BCBSBoat();
		$BookingForm=new BCBSBookingForm();
		
		/***/
		
		$error=array();
		
		/***/
		
		if((int)BCBSOption::getOption('billing_type')!=2)
		{
			$error['id']=1;
			$error['message']=__('Calendar works only in the "Daily" billing type.','boat-charter-booking-system');
			return($error);			
		}
		
		/***/
		
		$dictionary=$Boat->getDictionary();
		if(!array_key_exists($boatId,$dictionary))
		{
			$error['id']=2;
			$error['message']=__('Boat with provided ID doesn\'t exist.','boat-charter-booking-system');
			return($error);
		}
		
		/***/
		
		$dictionary=$BookingForm->getDictionary();
		if(!array_key_exists($bookingFormId,$dictionary))
		{
			if(count($dictionary))
			{
				$bookingFormId=array_key_first($dictionary);
			}
			else
			{
				$error['id']=3;
				$error['message']=__('Booking form with provided ID doesn\'t exist.','boat-charter-booking-system');
				return($error);				
			}
		}

		/***/
		
		return($error);
	}
		
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/