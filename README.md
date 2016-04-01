Web Service Security (WSS)
==========================

An open source library to help you protect your web service using token validation.

Written by [Luan Rodrigues](https://github.com/luoldrigues) for [CodeIgniter Framework 3.x](https://codeigniter.com/).


-------------------------------------------------------------------
## Index
 * [Server Requirements](#server-requirements)
 * [Installation](#installation)
    * [Warning](#warning)
    * [Copy the library files](#copy-the-library-files)
    * [Configurations / Settings](#configurations--settings)
 * [Usage](#usage)
    * [Generating a token](#generating-a-token)
    * [Validating a token](#validating-a-token)
    * [Get user id](#get-user-id)
    * [Get token data](#get-token-data)
 * [Example](#example)
    * [Result](#result)
 * [Licence](#licence)


-------------------------------------------------------------------
## Server Requirements
 - Apache 2.2 or newer
 - CodeIgniter Framework 3.x
 - PHP Mcrypt module
 - PHP version 5.4 or newer is recommended.


-------------------------------------------------------------------
## Installation
You may need to install the PHP Mcrypt Module. This instructions is valid to the Linux CentOS 6 or 7
```sh
$ sudo yum install php-mcrypt.x86_64 -y
```

### Warning
This is just a library, I assume you already have a CodeIgniter project installed in your computer.
If you don't have it already installed, please access the [Codeigniter Installation Docs](http://www.codeigniter.com/user_guide/#installation) and follow its instructions in order to get it done before continue here.

### Copy the library files
To install this library is very easy, you just need to copy two files in its respective folders. So, let's get started
 1. Copy the [Library](/application/libraries/Wss.php) file into the "libraries" folder.
 2. Copy the [Config](/application/config/wss.php) file into the "config" folder.

As you can see this repository already has the structure folders "application", "application/config" and "application/libraries" for your better understanding. Just copy the "application" folder and paste in your project.
Voalat! Installation finished successfully.

### Configurations / Settings
The wss.php file, inside of the "config" folder is your settings file.

Now, you must configure your settings such as the token timelife, your private key, etc.
 1. Open the wss.php file inside of the config folder.
 2. Edit and save your settings. For each field there is an explanation below:

 **$config['encryption_key']**: This field is your private key that will be used to encrypt and decrypt your token data, so your token will be unique and it can not be decoded by another key. Write there your private key replacing the string "_PASTE-HERE-YOUR-PRIVATE-KEY_".

 **$config['token_lifetime']**: The token_lifetime field is how long your token will be valid. This value is in seconds, so if you want to make your token valid for 1 hour, you should write 3600. You may want to set your token without limit, to do that, set this value as 0.

 **$config['token_delimiter']**: This field define the delimiter of your token data. The delimiter must not be a value that might be found in some part of your token data. Common Delimiters: ';', '|' or ':'.

 **$config['debug']**: The last one is the debug. This will allowed you to see some error in case that you are not getting what you expected to see.


-------------------------------------------------------------------
## Usage
Before you use this library, you must load it.
```php
    // Load wss library
    $this->load->library('wss');
```
If you have any question here, please take a look at [Using CodeIgniter Libraries](http://www.codeigniter.com/user_guide/general/libraries.html)

### Generating a token
To generate a new token, call the function getToken. You must set the fist parameter which is the user id. The second parameter is optional.
```php
    $user_id = 1;
    $extra_info = array(
        'user_name' => 'Example',
        'other_info' => 'Whatever information you want'
    );
    $token = $this->wss->getToken($user_id, $extra_info);
    echo $token;
```
PS: The token size will change according to its data. So, as much more data you put there, it will make the token bigger.

### Validating a token
In order to validate a token, you have to vall the function validateToken. You may pass the token parameter, or if it's comming by $_POST["token"], you don't need to set this parameter.
```php
    $token = "PASTE YOUR TOKEN HERE. See Generating a token";
    if($this->wss->validateToken($token))
    {
        echo 'This is a valid token';
    }
    else
    {
        echo 'Sorry, this token is invalid. It might be expirated.';
    }
```

### Get user id
To get your user id from the token, you can use getUserId or getTokenData function. In order to do that you have 2 options. 1. You send the token as parameter of this function. or 2. send the token by POST in a field name "token".
```php
    $token = "PASTE YOUR TOKEN HERE. See Generating a token;
    $user_id = $this->wss->getUserId($token);
    var_dump($user_id);
```

### Get token data
To get back your $extra_info (sent in [Generating a token](#generating-a-token)), you may use the getTokenData function. You may send the token parameter, or if it's comming by $_POST["token"], you don't need to set it.
```php
    $token = "PASTE YOUR TOKEN HERE. See Generating a token;
    $token_data = $this->wss->getTokenData($token);
    print_r($token_data);
```


-------------------------------------------------------------------
## Example

```php
    // Load wss library
    $this->load->library('wss');

    // Generating a token to the user_id 10
    $user_id = 10;
    $token = $this->wss->getToken($user_id);

    // Show token
    echo '<p><b>Token</b>:<br />';
    var_dump($token);
    echo '</p>';

    // Validating the token
    if($this->wss->validateToken($token))
    {
        // if valid token
        echo '<p>This is a valid token</p>';
    }
    else
    {
        // if invalid token
        echo '<p>Sorry, this token is invalid. It might be expirated.</p>';
    }

    // Getting the user_id from token
    $user_id = $this->wss->getUserId($token);

    // Show user_id
    echo '<p><b>User_id</b>:<br />';
    var_dump($user_id);
    echo '</p>';

    // Getting Token Data
    $token_data = $this->wss->getTokenData($token);

    // Show token data
    echo '<p><b>User_id</b>:<br />';
    var_dump($token_data);
    echo '</p>';

    // Licence
    echo '<p><b>Licence</b>: <br />';
    echo 'GNU License &lt;http://gnu.org/licenses/gpl.html&gt;.<br />This is a free software! You are allowed to change and redistribute it for free. <br />Written by Luan Rodrigues - <a href="https://github.com/luoldrigues/wss" target="_blank">https://github.com/luoldrigues/wss</a></p>';

    // For more details
    echo '<p>For more details access <a href="https://github.com/luoldrigues/wss" target="blank">Web Service Security (WSS)</a>.</p>';
```

### Result
```php
Token:
string(70) "1NtGxwM6cGypL4BTAOxt8VdY06jtDGshq1zaGCNr7t1%2FSCrlGPliTKYx%2Ff%2BkmRQK"

This is a valid token

User_id:
int(10)

User_id:
array(2) { ["uid"]=> int(10) ["tm"]=> int(1459481075) }

Licence:
GNU License <http://gnu.org/licenses/gpl.html>.
This is a free software! You are allowed to change and redistribute it for free.
Written by Luan Rodrigues - https://github.com/luoldrigues/wss

For more details access Web Service Security (WSS).
```

-------------------------------------------------------------------
## Licence

GNU License <http://gnu.org/licenses/gpl.html>.
This is a free software! You are allowed to change and redistribute it for free.

Written by Luan Rodrigues - https://github.com/luoldrigues/wss