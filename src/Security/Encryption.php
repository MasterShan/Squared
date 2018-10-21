<?php

namespace App\Security;

use App\Config;

class Encryption
{
    
    /**
     * Encryption cipher
     * @var cipher
     */
    protected $cipher;
    
    /**
     * Init vector
     * @var $iv
     */
    protected $iv;
    
    /**
     * Encryption method
     * @var $method
     */
    protected $method = 'AES-256-CBC';
    
    /**
     * Setup local variables
     */
    public function __construct()
    {
        $this->cipher = Config::CIPHER;
        $this->iv = 'qYALI7wikL1WdXkD';
    }
    
    /**
     * Encrypt data
     * 
     * @param string $data
     * @param bool   $base64
     */
    public function encrypt($data, $base64 = false)
    {
        $res = openssl_encrypt($data, $this->check_method(), $this->cipher, 0, $this->iv);
        if(!$base64)
        {
            return $res;
        }
        return base64_encode($res);
    }
    
    /**
     * Decrypt data
     * @param string $data
     * @param bool   $base64
     * 
     * Note: the base64 parameter should only be enabled if the data given
     * is in base64 format.
     */
    public function decrypt($data, $base64 = false)
    {
        if(!$base64)
        {
            return openssl_decrypt($data, $this->check_method(), $this->cipher, 0, $this->iv);
        }
        return openssl_decrypt(base64_decode($data), $this->check_method(), $this->cipher, 0, $this->iv);
    }
    
    /**
     * Check if method is valid
     * 
     * @return void|method
     */
    public function check_method()
    {
        $method = $this->method;
        if(is_null($method)) {
            throw new EncryptionException("Method cannot be null");
        }
        if(!in_array($method, openssl_get_cipher_methods(true))) {
            throw new EncryptionException("Invalid method");
        }
        return $method;
    }
    
}

?>