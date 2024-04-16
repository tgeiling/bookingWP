<?php

/******************************************************************************/
/******************************************************************************/

class BCBSBookingFormSummary
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->data=array();
	}
	
	/**************************************************************************/
	
	function add($data,$layout=1,$html=false)
	{
		array_push($this->data,array('data'=>$data,'layout'=>$layout,'html'=>$html));
	}
	
	/**************************************************************************/
	
	function createField($name,$value,$html=false)
	{
		$html=
		'
			<div class="bcbs-summary-field-name">'.($html ? $name : esc_html($name)).'</div>
			<div class="bcbs-summary-field-value">'.($html ? $value : esc_html($value)).'</div>
		';
		
		return($html);
	}
	
	/**************************************************************************/
	
	function create($header,$step=-1)
	{
		$html=null;
		$Validation=new BCBSValidation();
		
		foreach($this->data as $data)
		{
			switch($data['layout'])
			{
				case 1:
					
					$html.=
					'
						<div class="bcbs-summary-field">
							'.$this->createField($data['data'][0],$data['data'][1],$data['html']).'
						</div>
					';

				break;
			
				case 2:
					
					$html.=
					'
						<div class="bcbs-summary-field">
							<div class="bcbs-layout-50x50 bcbs-clear-fix">
								<div class="bcbs-layout-column-left">						
									'.$this->createField($data['data'][0][0],$data['data'][0][1],$data['html']).'
								</div>
								<div class="bcbs-layout-column-right">
									'.$this->createField($data['data'][1][0],$data['data'][1][1],$data['html']).'
								</div>
							</div>
						</div>
					';
					
				break;
			
				case 3:
					
					$add=null;
					foreach($data['data'][1] as $value)
					{
						if($Validation->isNotEmpty($add)) $add.='<br>';
						$add.=$value;
					}
					
					$html.=
					'
						<div class="bcbs-summary-field">
							'.$this->createField(esc_html($data['data'][0]),$add,true).'
						</div>
					';   
					
				break;
			}
		}
		
		$html=
		'
			<div class="bcbs-summary">
				<div class="bcbs-summary-header">
					<h4>'.esc_html($header).'</h4>
					'.($step==-1 ? null : '<a href="#" data-step="'.$step.'">'.esc_html__('Edit','boat-charter-booking-system').'</a>').'
				</div>				 
				'.$html.'
			</div>
		';
		
		$this->data=array();
		
		return($html);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/