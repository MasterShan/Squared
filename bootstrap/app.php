<?php
class Bootstrap
{
    
    /*
    +-------------------------------------------------------------------------------
    | Stitch the app together
    +-------------------------------------------------------------------------------
    |
    | Make the app have different variables for different
    | instances of classes.
    |
    */
    public function __construct()
    {
        $this->router  = require $_SERVER['DOCUMENT_ROOT'] . "/resources/routes/app.php";
    }
    
}

/*
+-------------------------------------------------------------------------------
| Return bootstrapper
+-------------------------------------------------------------------------------
|
| Return our bootstrapper to the index file.
|
*/
return $app = new Bootstrap;