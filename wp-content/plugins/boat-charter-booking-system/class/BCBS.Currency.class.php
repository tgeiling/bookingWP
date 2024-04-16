<?php

/******************************************************************************/
/******************************************************************************/

class BCBSCurrency
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->currency=BCBSGlobalData::setGlobalData('currency',array($this,'init'));
	}
	
	/**************************************************************************/
	
	function init()
	{
		$currency=array
		(
			'AFN'=>array
			(
				'name'=>__('Afghan afghani','boat-charter-booking-system'),
				'symbol'=>'AFN'
			),
			'ALL'=>array
			(
				'name'=>__('Albanian lek','boat-charter-booking-system'),
				'symbol'=>'ALL'
			),
			'DZD'=>array
			(
				'name'=>__('Algerian dinar','boat-charter-booking-system'),
				'symbol'=>'DZD'
			),
			'AOA'=>array
			(
				'name'=>__('Angolan kwanza','boat-charter-booking-system'),
				'symbol'=>'AOA'
			),
			'ARS'=>array
			(
				'name'=>__('Argentine peso','boat-charter-booking-system'),
				'symbol'=>'ARS'
			),
			'AMD'=>array
			(
				'name'=>__('Armenian dram','boat-charter-booking-system'),
				'symbol'=>'AMD'
			),
			'AWG'=>array
			(
				'name'=>__('Aruban florin','boat-charter-booking-system'),
				'symbol'=>'AWG'
			),
			'AUD'=>array
			(
				'name'=>__('Australian dollar','boat-charter-booking-system'),
				'symbol'=>'&#36;',
				'separator'=>'.'
			),
			'AZN'=>array
			(
				'name'=>__('Azerbaijani manat','boat-charter-booking-system'),
				'symbol'=>'AZN'
			),
			'BSD'=>array
			(
				'name'=>__('Bahamian dollar','boat-charter-booking-system'),
				'symbol'=>'BSD'
			),
			'BHD'=>array
			(
				'name'=>__('Bahraini dinar','boat-charter-booking-system'),
				'symbol'=>'BHD',
				'separator'=>'&#1643;'
			),
			'BDT'=>array
			(
				'name'=>__('Bangladeshi taka','boat-charter-booking-system'),
				'symbol'=>'BDT'
			),
			'BBD'=>array
			(
				'name'=>__('Barbadian dollar','boat-charter-booking-system'),
				'symbol'=>'BBD'
			),
			'BYR'=>array
			(
				'name'=>__('Belarusian ruble','boat-charter-booking-system'),
				'symbol'=>'BYR'
			),
			'BZD'=>array
			(
				'name'=>__('Belize dollar','boat-charter-booking-system'),
				'symbol'=>'BZD'
			),
			'BTN'=>array
			(
				'name'=>__('Bhutanese ngultrum','boat-charter-booking-system'),
				'symbol'=>'BTN'
			),
			'BOB'=>array
			(
				'name'=>__('Bolivian boliviano','boat-charter-booking-system'),
				'symbol'=>'BOB'
			),
			'BAM'=>array
			(
				'name'=>__('Bosnia and Herzegovina konvertibilna marka','boat-charter-booking-system'),
				'symbol'=>'BAM'
			),
			'BWP'=>array
			(
				'name'=>__('Botswana pula','boat-charter-booking-system'),
				'symbol'=>'BWP',
				'separator'=>'.'
			),
			'BRL'=>array
			(
				'name'=>__('Brazilian real','boat-charter-booking-system'),
				'symbol'=>'&#82;&#36;'
			),
			'GBP'=>array
			(
				'name'=>__('British pound','boat-charter-booking-system'),
				'symbol'=>'&pound;',
				'position'=>'left',
				'separator'=>'.',
			),
			'BND'=>array
			(
				'name'=>__('Brunei dollar','boat-charter-booking-system'),
				'symbol'=>'BND',
				'separator'=>'.'
			),
			'BGN'=>array
			(
				'name'=>__('Bulgarian lev','boat-charter-booking-system'),
				'symbol'=>'BGN'
			),
			'BIF'=>array
			(
				'name'=>__('Burundi franc','boat-charter-booking-system'),
				'symbol'=>'BIF'
			),
			'KYD'=>array
			(
				'name'=>__('Cayman Islands dollar','boat-charter-booking-system'),
				'symbol'=>'KYD'
			),
			'KHR'=>array
			(
				'name'=>__('Cambodian riel','boat-charter-booking-system'),
				'symbol'=>'KHR'
			),
			'CAD'=>array
			(
				'name'=>__('Canadian dollar','boat-charter-booking-system'),
				'symbol'=>'CAD',
				'separator'=>'.'
			),
			'CVE'=>array
			(
				'name'=>__('Cape Verdean escudo','boat-charter-booking-system'),
				'symbol'=>'CVE'
			),
			'XAF'=>array
			(
				'name'=>__('Central African CFA franc','boat-charter-booking-system'),
				'symbol'=>'XAF'
			),
			'GQE'=>array
			(
				'name'=>__('Central African CFA franc','boat-charter-booking-system'),
				'symbol'=>'GQE'
			),
			'XPF'=>array
			(
				'name'=>__('CFP franc','boat-charter-booking-system'),
				'symbol'=>'XPF'
			),
			'CLP'=>array
			(
				'name'=>__('Chilean peso','boat-charter-booking-system'),
				'symbol'=>'CLP'
			),
			'CNY'=>array
			(
				'name'=>__('Chinese renminbi','boat-charter-booking-system'),
				'symbol'=>'&yen;'
			),
			'COP'=>array
			(
				'name'=>__('Colombian peso','boat-charter-booking-system'),
				'symbol'=>'COP'
			),
			'KMF'=>array
			(
				'name'=>__('Comorian franc','boat-charter-booking-system'),
				'symbol'=>'KMF'
			),
			'CDF'=>array
			(
				'name'=>__('Congolese franc','boat-charter-booking-system'),
				'symbol'=>'CDF'
			),
			'CRC'=>array
			(
				'name'=>__('Costa Rican colon','boat-charter-booking-system'),
				'symbol'=>'CRC'
			),
			'HRK'=>array
			(
				'name'=>__('Croatian kuna','boat-charter-booking-system'),
				'symbol'=>'HRK'
			),
			'CUC'=>array
			(
				'name'=>__('Cuban peso','boat-charter-booking-system'),
				'symbol'=>'CUC'
			),
			'CZK'=>array
			(
				'name'=>__('Czech koruna','boat-charter-booking-system'),
				'symbol'=>'&#75;&#269;'
			),
			'DKK'=>array
			(
				'name'=>__('Danish krone','boat-charter-booking-system'),
				'symbol'=>'&#107;&#114;'
			),
			'DJF'=>array
			(
				'name'=>__('Djiboutian franc','boat-charter-booking-system'),
				'symbol'=>'DJF'
			),
			'DOP'=>array
			(
				'name'=>__('Dominican peso','boat-charter-booking-system'),
				'symbol'=>'DOP',
				'separator'=>'.'
			),
			'XCD'=>array
			(
				'name'=>__('East Caribbean dollar','boat-charter-booking-system'),
				'symbol'=>'XCD'
			),
			'EGP'=>array
			(
				'name'=>__('Egyptian pound','boat-charter-booking-system'),
				'symbol'=>'EGP'
			),
			'ERN'=>array
			(
				'name'=>__('Eritrean nakfa','boat-charter-booking-system'),
				'symbol'=>'ERN'
			),
			'EEK'=>array
			(
				'name'=>__('Estonian kroon','boat-charter-booking-system'),
				'symbol'=>'EEK'
			),
			'ETB'=>array
			(
				'name'=>__('Ethiopian birr','boat-charter-booking-system'),
				'symbol'=>'ETB'
			),
			'EUR'=>array
			(
				'name'=>__('European euro','boat-charter-booking-system'),
				'symbol'=>'&euro;'
			),
			'FKP'=>array
			(
				'name'=>__('Falkland Islands pound','boat-charter-booking-system'),
				'symbol'=>'FKP'
			),
			'FJD'=>array
			(
				'name'=>__('Fijian dollar','boat-charter-booking-system'),
				'symbol'=>'FJD',
				'separator'=>'.'
			),
			'GMD'=>array
			(
				'name'=>__('Gambian dalasi','boat-charter-booking-system'),
				'symbol'=>'GMD'
			),
			'GEL'=>array
			(
				'name'=>__('Georgian lari','boat-charter-booking-system'),
				'symbol'=>'GEL'
			),
			'GHS'=>array
			(
				'name'=>__('Ghanaian cedi','boat-charter-booking-system'),
				'symbol'=>'GHS'
			),
			'GIP'=>array
			(
				'name'=>__('Gibraltar pound','boat-charter-booking-system'),
				'symbol'=>'GIP'
			),
			'GTQ'=>array
			(
				'name'=>__('Guatemalan quetzal','boat-charter-booking-system'),
				'symbol'=>'GTQ',
				'separator'=>'.'
			),
			'GNF'=>array
			(
				'name'=>__('Guinean franc','boat-charter-booking-system'),
				'symbol'=>'GNF'
			),
			'GYD'=>array
			(
				'name'=>__('Guyanese dollar','boat-charter-booking-system'),
				'symbol'=>'GYD'
			),
			'HTG'=>array
			(
				'name'=>__('Haitian gourde','boat-charter-booking-system'),
				'symbol'=>'HTG'
			),
			'HNL'=>array
			(
				'name'=>__('Honduran lempira','boat-charter-booking-system'),
				'symbol'=>'HNL',
				'separator'=>'.'
			),
			'HKD'=>array
			(
				'name'=>__('Hong Kong dollar','boat-charter-booking-system'),
				'symbol'=>'&#36;',
				'separator'=>'.'
			),
			'HUF'=>array
			(
				'name'=>__('Hungarian forint','boat-charter-booking-system'),
				'symbol'=>'&#70;&#116;'
			),
			'ISK'=>array
			(
				'name'=>__('Icelandic krona','boat-charter-booking-system'),
				'symbol'=>'ISK'
			),
			'INR'=>array
			(
				'name'=>__('Indian rupee','boat-charter-booking-system'),
				'symbol'=>'&#8377;',
				'separator'=>'.'
			),
			'IDR'=>array
			(
				'name'=>__('Indonesian rupiah','boat-charter-booking-system'),
				'symbol'=>'Rp',
				'position'=>'left'
			),
			'IRR'=>array
			(
				'name'=>__('Iranian rial','boat-charter-booking-system'),
				'symbol'=>'IRR',
				'separator'=>'&#1643;'
			),
			'IQD'=>array
			(
				'name'=>__('Iraqi dinar','boat-charter-booking-system'),
				'symbol'=>'IQD',
				'separator'=>'&#1643;'
			),
			'ILS'=>array
			(
				'name'=>__('Israeli new sheqel','boat-charter-booking-system'),
				'symbol'=>'&#8362;',
				'separator'=>'.'
			),
			'YER'=>array
			(
				'name'=>__('Yemeni rial','boat-charter-booking-system'),
				'symbol'=>'YER'
			),
			'JMD'=>array
			(
				'name'=>__('Jamaican dollar','boat-charter-booking-system'),
				'symbol'=>'JMD'
			),
			'JPY'=>array
			(
				'name'=>__('Japanese yen','boat-charter-booking-system'),
				'symbol'=>'&yen;',
				'separator'=>'.'
			),
			'JOD'=>array
			(
				'name'=>__('Jordanian dinar','boat-charter-booking-system'),
				'symbol'=>'JOD'
			),
			'KZT'=>array
			(
				'name'=>__('Kazakhstani tenge','boat-charter-booking-system'),
				'symbol'=>'KZT'
			),
			'KES'=>array
			(
				'name'=>__('Kenyan shilling','boat-charter-booking-system'),
				'symbol'=>'KES'
			),
			'KGS'=>array
			(
				'name'=>__('Kyrgyzstani som','boat-charter-booking-system'),
				'symbol'=>'KGS'
			),
			'KWD'=>array
			(
				'name'=>__('Kuwaiti dinar','boat-charter-booking-system'),
				'symbol'=>'KWD',
				'separator'=>'&#1643;'
			),
			'LAK'=>array
			(
				'name'=>__('Lao kip','boat-charter-booking-system'),
				'symbol'=>'LAK'
			),
			'LVL'=>array
			(
				'name'=>__('Latvian lats','boat-charter-booking-system'),
				'symbol'=>'LVL'
			),
			'LBP'=>array
			(
				'name'=>__('Lebanese lira','boat-charter-booking-system'),
				'symbol'=>'LBP'
			),
			'LSL'=>array
			(
				'name'=>__('Lesotho loti','boat-charter-booking-system'),
				'symbol'=>'LSL'
			),
			'LRD'=>array
			(
				'name'=>__('Liberian dollar','boat-charter-booking-system'),
				'symbol'=>'LRD'
			),
			'LYD'=>array
			(
				'name'=>__('Libyan dinar','boat-charter-booking-system'),
				'symbol'=>'LYD'
			),
			'LTL'=>array
			(
				'name'=>__('Lithuanian litas','boat-charter-booking-system'),
				'symbol'=>'LTL'
			),
			'MOP'=>array
			(
				'name'=>__('Macanese pataca','boat-charter-booking-system'),
				'symbol'=>'MOP'
			),
			'MKD'=>array
			(
				'name'=>__('Macedonian denar','boat-charter-booking-system'),
				'symbol'=>'MKD'
			),
			'MGA'=>array
			(
				'name'=>__('Malagasy ariary','boat-charter-booking-system'),
				'symbol'=>'MGA'
			),
			'MYR'=>array
			(
				'name'=>__('Malaysian ringgit','boat-charter-booking-system'),
				'symbol'=>'&#82;&#77;',
				'separator'=>'.'
			),
			'MWK'=>array
			(
				'name'=>__('Malawian kwacha','boat-charter-booking-system'),
				'symbol'=>'MWK'
			),
			'MVR'=>array
			(
				'name'=>__('Maldivian rufiyaa','boat-charter-booking-system'),
				'symbol'=>'MVR'
			),
			'MRO'=>array
			(
				'name'=>__('Mauritanian ouguiya','boat-charter-booking-system'),
				'symbol'=>'MRO'
			),
			'MUR'=>array
			(
				'name'=>__('Mauritian rupee','boat-charter-booking-system'),
				'symbol'=>'MUR'
			),
			'MXN'=>array
			(
				'name'=>__('Mexican peso','boat-charter-booking-system'),
				'symbol'=>'&#36;',
				'separator'=>'.'
			),
			'MMK'=>array
			(
				'name'=>__('Myanma kyat','boat-charter-booking-system'),
				'symbol'=>'MMK'
			),
			'MDL'=>array
			(
				'name'=>__('Moldovan leu','boat-charter-booking-system'),
				'symbol'=>'MDL'
			),
			'MNT'=>array
			(
				'name'=>__('Mongolian tugrik','boat-charter-booking-system'),
				'symbol'=>'MNT'
			),
			'MAD'=>array
			(
				'name'=>__('Moroccan dirham','boat-charter-booking-system'),
				'symbol'=>'MAD',
				'position'=>'right'
			),
			'MZM'=>array
			(
				'name'=>__('Mozambican metical','boat-charter-booking-system'),
				'symbol'=>'MZM'
			),
			'NAD'=>array
			(
				'name'=>__('Namibian dollar','boat-charter-booking-system'),
				'symbol'=>'NAD'
			),
			'NPR'=>array
			(
				'name'=>__('Nepalese rupee','boat-charter-booking-system'),
				'symbol'=>'NPR'
			),
			'ANG'=>array
			(
				'name'=>__('Netherlands Antillean gulden','boat-charter-booking-system'),
				'symbol'=>'ANG'
			),
			'TWD'=>array
			(
				'name'=>__('New Taiwan dollar','boat-charter-booking-system'),
				'symbol'=>'&#78;&#84;&#36;',
				'separator'=>'.'
			),
			'NZD'=>array
			(
				'name'=>__('New Zealand dollar','boat-charter-booking-system'),
				'symbol'=>'&#36;',
				'separator'=>'.'
			),
			'NIO'=>array
			(
				'name'=>__('Nicaraguan cordoba','boat-charter-booking-system'),
				'symbol'=>'NIO',
				'separator'=>'.'
			),
			'NGN'=>array
			(
				'name'=>__('Nigerian naira','boat-charter-booking-system'),
				'symbol'=>'NGN',
				'separator'=>'.'
			),
			'KPW'=>array
			(
				'name'=>__('North Korean won','boat-charter-booking-system'),
				'symbol'=>'KPW',
				'separator'=>'.'
			),
			'NOK'=>array
			(
				'name'=>__('Norwegian krone','boat-charter-booking-system'),
				'symbol'=>'&#107;&#114;'
			),
			'OMR'=>array
			(
				'name'=>__('Omani rial','boat-charter-booking-system'),
				'symbol'=>'OMR',
				'separator'=>'&#1643;'
			),
			'TOP'=>array
			(
				'name'=>__('Paanga','boat-charter-booking-system'),
				'symbol'=>'TOP'
			),
			'PKR'=>array
			(
				'name'=>__('Pakistani rupee','boat-charter-booking-system'),
				'symbol'=>'PKR',
				'separator'=>'.'
			),
			'PAB'=>array
			(
				'name'=>__('Panamanian balboa','boat-charter-booking-system'),
				'symbol'=>'PAB',
				'separator'=>'.'
			),
			'PGK'=>array
			(
				'name'=>__('Papua New Guinean kina','boat-charter-booking-system'),
				'symbol'=>'PGK'
			),
			'PYG'=>array
			(
				'name'=>__('Paraguayan guarani','boat-charter-booking-system'),
				'symbol'=>'PYG'
			),
			'PEN'=>array
			(
				'name'=>__('Peruvian nuevo sol','boat-charter-booking-system'),
				'symbol'=>'PEN'
			),
			'PHP'=>array
			(
				'name'=>__('Philippine peso','boat-charter-booking-system'),
				'symbol'=>'&#8369;'
			),
			'PLN'=>array
			(
				'name'=>__('Polish zloty','boat-charter-booking-system'),
				'symbol'=>'&#122;&#322;',
				'position'=>'right'
			),
			'QAR'=>array
			(
				'name'=>__('Qatari riyal','boat-charter-booking-system'),
				'symbol'=>'QAR',
				'separator'=>'&#1643;'
			),
			'RON'=>array
			(
				'name'=>__('Romanian leu','boat-charter-booking-system'),
				'symbol'=>'lei'
			),
			'RUB'=>array
			(
				'name'=>__('Russian ruble','boat-charter-booking-system'),
				'symbol'=>'RUB'
			),
			'RWF'=>array
			(
				'name'=>__('Rwandan franc','boat-charter-booking-system'),
				'symbol'=>'RWF'
			),
			'SHP'=>array
			(
				'name'=>__('Saint Helena pound','boat-charter-booking-system'),
				'symbol'=>'SHP'
			),
			'WST'=>array
			(
				'name'=>__('Samoan tala','boat-charter-booking-system'),
				'symbol'=>'WST'
			),
			'STD'=>array
			(
				'name'=>__('Sao Tome and Principe dobra','boat-charter-booking-system'),
				'symbol'=>'STD'
			),
			'SAR'=>array
			(
				'name'=>__('Saudi riyal','boat-charter-booking-system'),
				'symbol'=>'SAR',
				'separator'=>'&#1643;'
			),
			'SCR'=>array
			(
				'name'=>__('Seychellois rupee','boat-charter-booking-system'),
				'symbol'=>'SCR'
			),
			'RSD'=>array
			(
				'name'=>__('Serbian dinar','boat-charter-booking-system'),
				'symbol'=>'RSD'
			),
			'SLL'=>array
			(
				'name'=>__('Sierra Leonean leone','boat-charter-booking-system'),
				'symbol'=>'SLL'
			),
			'SGD'=>array
			(
				'name'=>__('Singapore dollar','boat-charter-booking-system'),
				'symbol'=>'&#36;',
				'separator'=>'.'
			),
			'SYP'=>array
			(
				'name'=>__('Syrian pound','boat-charter-booking-system'),
				'symbol'=>'SYP',
				'separator'=>'&#1643;'
			),
			'SKK'=>array
			(
				'name'=>__('Slovak koruna','boat-charter-booking-system'),
				'symbol'=>'SKK'
			),
			'SBD'=>array
			(
				'name'=>__('Solomon Islands dollar','boat-charter-booking-system'),
				'symbol'=>'SBD'
			),
			'SOS'=>array
			(
				'name'=>__('Somali shilling','boat-charter-booking-system'),
				'symbol'=>'SOS'
			),
			'ZAR'=>array
			(
				'name'=>__('South African rand','boat-charter-booking-system'),
				'symbol'=>'&#82;'
			),
			'KRW'=>array
			(
				'name'=>__('South Korean won','boat-charter-booking-system'),
				'symbol'=>'&#8361;',
				'separator'=>'.'
			),
			'XDR'=>array
			(
				'name'=>__('Special Drawing Rights','boat-charter-booking-system'),
				'symbol'=>'XDR'
			),
			'LKR'=>array
			(
				'name'=>__('Sri Lankan rupee','boat-charter-booking-system'),
				'symbol'=>'LKR',
				'separator'=>'.'
			),
			'SDG'=>array
			(
				'name'=>__('Sudanese pound','boat-charter-booking-system'),
				'symbol'=>'SDG'
			),
			'SRD'=>array
			(
				'name'=>__('Surinamese dollar','boat-charter-booking-system'),
				'symbol'=>'SRD'
			),
			'SZL'=>array
			(
				'name'=>__('Swazi lilangeni','boat-charter-booking-system'),
				'symbol'=>'SZL'
			),
			'SEK'=>array
			(
				'name'=>__('Swedish krona','boat-charter-booking-system'),
				'symbol'=>'&#107;&#114;'
			),
			'CHF'=>array
			(
				'name'=>__('Swiss franc','boat-charter-booking-system'),
				'symbol'=>'&#67;&#72;&#70;',
				'separator'=>'.'
			),
			'TJS'=>array
			(
				'name'=>__('Tajikistani somoni','boat-charter-booking-system'),
				'symbol'=>'TJS'
			),
			'TZS'=>array
			(
				'name'=>__('Tanzanian shilling','boat-charter-booking-system'),
				'symbol'=>'TZS'
			),
			'THB'=>array
			(
				'name'=>__('Thai baht','boat-charter-booking-system'),
				'symbol'=>'&#3647;'
			),
			'TTD'=>array
			(
				'name'=>__('Trinidad and Tobago dollar','boat-charter-booking-system'),
				'symbol'=>'TTD'
			),
			'TND'=>array
			(
				'name'=>__('Tunisian dinar','boat-charter-booking-system'),
				'symbol'=>'TND'
			),
			'TRY'=>array
			(
				'name'=>__('Turkish new lira','boat-charter-booking-system'),
				'symbol'=>'&#84;&#76;'
			),
			'TMM'=>array
			(
				'name'=>__('Turkmen manat','boat-charter-booking-system'),
				'symbol'=>'TMM'
			),
			'AED'=>array
			(
				'name'=>__('UAE dirham','boat-charter-booking-system'),
				'symbol'=>'AED'
			),
			'UGX'=>array
			(
				'name'=>__('Ugandan shilling','boat-charter-booking-system'),
				'symbol'=>'UGX'
			),
			'UAH'=>array
			(
				'name'=>__('Ukrainian hryvnia','boat-charter-booking-system'),
				'symbol'=>'UAH'
			),
			'USD'=>array
			(
				'name'=>__('United States dollar','boat-charter-booking-system'),
				'symbol'=>'&#36;',
				'position'=>'left',
				'separator'=>'.',
				'separator2'=>','
			),
			'UYU'=>array
			(
				'name'=>__('Uruguayan peso','boat-charter-booking-system'),
				'symbol'=>'UYU'
			),
			'UZS'=>array
			(
				'name'=>__('Uzbekistani som','boat-charter-booking-system'),
				'symbol'=>'UZS'
			),
			'VUV'=>array
			(
				'name'=>__('Vanuatu vatu','boat-charter-booking-system'),
				'symbol'=>'VUV'
			),
			'VEF'=>array
			(
				'name'=>__('Venezuelan bolivar','boat-charter-booking-system'),
				'symbol'=>'VEF'
			),
			'VND'=>array
			(
				'name'=>__('Vietnamese dong','boat-charter-booking-system'),
				'symbol'=>'VND'
			),
			'XOF'=>array
			(
				'name'=>__('West African CFA franc','boat-charter-booking-system'),
				'symbol'=>'XOF'
			),
			'ZMK'=>array
			(
				'name'=>__('Zambian kwacha','boat-charter-booking-system'),
				'symbol'=>'ZMK'
			),
			'ZWD'=>array
			(
				'name'=>__('Zimbabwean dollar','boat-charter-booking-system'),
				'symbol'=>'ZWD'
			),
			'RMB'=>array
			(
				'name'=>__('Chinese Yuan','boat-charter-booking-system'),
				'symbol'=>'&yen;',
				'separator'=>'.'
			)
		);
		
		$currency=$this->useDefault($currency);

		return($currency);
	}
	
	/**************************************************************************/
	
	function useDefault($currency)
	{
		foreach($currency as $index=>$value)
		{
			if(!array_key_exists('separator',$value))
				$currency[$index]['separator']='.';
			if(!array_key_exists('separator2',$value))
				$currency[$index]['separator2']='';
			if(!array_key_exists('position',$value))
				$currency[$index]['position']='left';			
		}
		
		return($currency);
	}
	
	/**************************************************************************/
	
	function getCurrency($currency=null)
	{
		if(is_null($currency))
			return($this->currency);
		else return($this->currency[$currency]);
	}
	
	/**************************************************************************/
	
	function isCurrency($currency)
	{
		return(array_key_exists($currency,$this->getCurrency()));
	}
	
	/**************************************************************************/

	static function getBaseCurrency()
	{
		return(BCBSOption::getOption('currency'));
	}
	
	/**************************************************************************/
	
	static function getFormCurrency()
	{
		if(array_key_exists('currency',$_GET))
			$currency=BCBSHelper::getGetValue('currency',false);
		else $currency=BCBSHelper::getPostValue('currency');
		
		return($currency);
	}
	
	/**************************************************************************/
	
	static function getExchangeRate()
	{
		$rate=1;
		
		if(BCBSCurrency::getBaseCurrency()!=BCBSCurrency::getFormCurrency())
		{
			$rate=0;
			$dictionary=BCBSOption::getOption('currency_exchange_rate');
			
			if(array_key_exists(BCBSCurrency::getFormCurrency(),$dictionary))
				$rate=$dictionary[BCBSCurrency::getFormCurrency()];
		}
		
		return($rate);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/