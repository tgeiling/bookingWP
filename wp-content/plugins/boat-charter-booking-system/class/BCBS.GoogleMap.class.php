<?php

/******************************************************************************/
/******************************************************************************/

class BCBSGoogleMap
{
	/**************************************************************************/

	function __construct()
	{
		$this->position=array
		(
			'TOP_CENTER'=>esc_html__('Top center','boat-charter-booking-system'),
			'TOP_LEFT'=>esc_html__('Top left','boat-charter-booking-system'),
			'TOP_RIGHT'=>esc_html__('Top right','boat-charter-booking-system'),
			'LEFT_TOP'=>esc_html__('Left top','boat-charter-booking-system'),
			'RIGHT_TOP'=>esc_html__('Right top','boat-charter-booking-system'),
			'LEFT_CENTER'=>esc_html__('Left center','boat-charter-booking-system'),
			'RIGHT_CENTER'=>esc_html__('Right center','boat-charter-booking-system'),
			'LEFT_BOTTOM'=>esc_html__('Left bottom','boat-charter-booking-system'),
			'RIGHT_BOTTOM'=>esc_html__('Right bottom','boat-charter-booking-system'),
			'BOTTOM_CENTER'=>esc_html__('Bottom center','boat-charter-booking-system'),
			'BOTTOM_LEFT'=>esc_html__('Bottom left','boat-charter-booking-system'),
			'BOTTOM_RIGHT'=>esc_html__('Bottom right','boat-charter-booking-system')
		);

		$this->mapTypeControlId=array
		(
			'ROADMAP'=>esc_html__('Roadmap','boat-charter-booking-system'),
			'SATELLITE'=>esc_html__('Satellite','boat-charter-booking-system'),
			'HYBRID'=>esc_html__('Hybrid','boat-charter-booking-system'),
			'TERRAIN'=>esc_html__('Terrain','boat-charter-booking-system')
		);

		$this->mapTypeControlStyle=array
		(
			'DEFAULT'=>esc_html__('Default','boat-charter-booking-system'),
			'HORIZONTAL_BAR'=>esc_html__('Horizontal Bar','boat-charter-booking-system'),
			'DROPDOWN_MENU'=>esc_html__('Dropdown Menu','boat-charter-booking-system')
		);

		$this->routeAvoid=array
		(
			'tolls'=>esc_html__('Tolls','boat-charter-booking-system'),
			'highways'=>esc_html__('Highways','boat-charter-booking-system'),
			'ferries'=>esc_html__('Ferries','boat-charter-booking-system')
		);
	}
	
	/**************************************************************************/
	
	function getMapTypeControlStyle()
	{
		return($this->mapTypeControlStyle);
	}
   
	 /**************************************************************************/
	
	function getPosition()
	{
		return($this->position);
	}
	
	/**************************************************************************/
	
	function getMapTypeControlId()
	{
		return($this->mapTypeControlId);
	}
	
	/**************************************************************************/
	
	function getRouteAvoid()
	{
		return($this->routeAvoid);
	}

	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/