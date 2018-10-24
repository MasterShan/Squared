<?php

namespace Squared\Redirect;

class Redirect
{
    
    /**
     * @var url
     */
    private $url;
    
    /**
     * Create a new redirect
     * 
     * @param string|bool $url
     */
    public function __construct($url = false) 
    {
        if($url) {
           $this->url = $url;
           $this->run();
        }else{
            $this->url = null;
        }
    }
    
    /**
     * Set the URL if it wasn't set in the constructor
     * 
     * @param string $url
     */
    public function setUrl($url = null) 
    {
        if(!is_null($url)) {
            $this->url = $url;
        }else{
            throw new RedirectException("URL not defined at setter");
        }
        return $this;
    }
    /**
     * Run redirect to url
     */
    public function run()
    {
        if(!is_null($this->url)) {
            $url = $this->url;
            header("Location: $url");
        }else{
            throw new RedirectException("URL not defined.");
        }
    }
    
}

?>