<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Web Service Security (WSS)
 *
 * An open source library to help you protect your web service using token validation. Developed by Luan Rodrigues for CodeIgniter Framework 3.x.
 *
 * @author      Luan Rodrigues (luoldrigues@gmail.com)
 * @version     Version 1.0
 * @link        https://github.com/luoldrigues/wss
 */

class Wss
{
    /**
     * Define initial settings
     */
    public function __construct($params = array())
    {
        // Requirements validation
        $this->requirements($params);
    }


    /**
     * PRIVATE METHOD
     * Prevents dependencies errors.
     *
     * @param  [array]      $params     (required)      Config file settings
     * @return [none]
     */
    private function requirements($params)
    {
        // Mcrypt module dependence validation
        if(!extension_loaded('mcrypt'))
        {
            throw new Exception('PHP mcrypt module is required');
        }

        // Encryption Key validation
        if(!array_key_exists('encryption_key', $params))
        {
            throw new Exception('You must set your "encryption_key" in your library config file.');
        }
    }
}