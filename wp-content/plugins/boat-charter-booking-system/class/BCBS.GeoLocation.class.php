<?php

class BCBSGeoLocation
{
    function __construct()
    {
        $this->server = array(
            1 => array(
                'name' => esc_html__('KeyCDN [keycdn.com]', 'boat-charter-booking-system'),
                'api_url_address' => 'https://tools.keycdn.com/geo.json?host={CLIENT_IP}'
            ),
            2 => array(
                'name' => esc_html__('IP-API [ip-api.com]', 'boat-charter-booking-system'),
                'api_url_address' => 'http://ip-api.com/json/{CLIENT_IP}'
            ),
            3 => array(
                'name' => esc_html__('ipstack [ipstack.com]', 'boat-charter-booking-system'),
                'api_url_address' => 'http://api.ipstack.com/{CLIENT_IP}?access_key={API_KEY}'
            )
        );
    }

    function getIPAddress()
    {
        return null;
    }

    function getCountryCode()
    {
        return null;
    }

    function getCoordinate()
    {
        return array('lat' => 0, 'lng' => 0);
    }

    function getDocument()
    {
        return false;
    }

    function getServer()
    {
        return $this->server;
    }
}
