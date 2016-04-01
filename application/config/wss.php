<?php

/**
 * Web Service Security (WSS)
 *
 * An open source library to help you protect your web service using token validation. Developed by Luan Rodrigues for CodeIgniter Framework 3.x.
 *
 * @author      Luan Rodrigues (luoldrigues@gmail.com)
 * @version     Version 1.0
 * @link        https://github.com/luoldrigues/wss
 */

// Configure your private key. It might be a random string.
$config['encryption_key'] = '_PASTE-HERE-YOUR-PRIVATE-KEY_';

// Configure how long its token will be valid. Set 0 to define as unlimited lifetime.
$config['token_lifetime'] = 3600;

// Configure a delimiter to separe token data. Common Delimiters: ';', '|' or ':'.
$config['token_delimiter'] = ';';

// Set true to get debugs
$config['debug'] = false;