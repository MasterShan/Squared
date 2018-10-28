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
    public function __construct($url = false, $query = false) 
    {
        if($url) {
            $this->url = $url;
            if($query) {
                $this->parameters($query);
                $this->run();
            }
        }else{
            $this->url = null;
        }
    }
    
    /**
     * Set the URL if it wasn't set in the constructor
     * 
     * @param string $url
     * 
     * @return this
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
     * Add query parameters for GET requests
     * 
     * @param array|object $query
     * 
     * @return this
     */
    public function parameters($query)
    {
        if(!is_null($this->url)) {
            $this->url .= '?' . http_build_query($query);
        }else{
            throw new RedirectException("URL not defined at parameter builder");
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