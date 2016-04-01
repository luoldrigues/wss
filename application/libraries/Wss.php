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
    // Protected Variables
    protected $instance;
    protected $debug;

    // Local Variables
    private $encryption_key;
    private $token_lifetime;
    private $token_delimiter;


    /**
     * Define initial settings
     */
    public function __construct($params = array())
    {
        // Requirements validation
        $this->requirements($params);

        // Load instance
        $this->instance or $this->instance =& get_instance();

        // Load session library
        array_key_exists('session', $this->instance)  or $this->instance->load->library("session");

        // Load config file settings
        array_key_exists('debug', $params)               and $this->debug               = $params['debug'];
        array_key_exists('encryption_key', $params)      and $this->encryption_key      = $params['encryption_key'];
        array_key_exists('token_lifetime', $params)      and $this->token_lifetime      = $params['token_lifetime'];
        array_key_exists('token_delimiter', $params)     and $this->token_delimiter     = $params['token_delimiter'];

        // Default Settings. This will be always used when its settings is not specified in the config file.
        $this->token_lifetime  or $this->token_lifetime  = 3600; // Set token lifetime as 3600 seconds (1 hour)
        $this->token_delimiter or $this->token_delimiter = ';';  // Define semicolon
    }


    /**
     * PRIVATE METHOD
     * Algorithm to generate a Token. It return a base64 encoded string.
     *
     * @param  [mixed]     $data       (required)      Token data to be encrypted.
     * @return [string]
     */
    private function genToken($data)
    {
        $data = json_encode($data, true);

        $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC),MCRYPT_DEV_URANDOM);

        $token = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, hash('sha256', $this->encryption_key, true), $data, MCRYPT_MODE_CBC, $iv);
        $token .= $iv;

        return urlencode(base64_encode($token));
    }


    /**
     * PRIVATE METHOD
     * Decode a base64 token.
     *
     * @param  [string]     $data       (required)      String data to be encoded. It might be a json string.
     * @return [string]
     */
    private function token_base64_decode($token)
    {
        $_token = urldecode($token);

        $decode = base64_decode($_token);
        if(base64_encode($decode) === $_token)
        {
            return $decode;
        }

        $decode = base64_decode($token);
        if(base64_encode($decode) === $token)
        {
            return $decode;
        }

        return null;
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