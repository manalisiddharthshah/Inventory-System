<?php
    /**
     * For Link the Css files
     */
    function linkCSS($cssPath)
    {  
        $url = BASEURL . "/" .$cssPath;
        echo '<link rel="stylesheet" href="'. $url .'">';
    }
    /**
     * For Link the Js files
     */
    function linkJS($jsPath){

        $url = BASEURL. "/". $jsPath;
        echo '<script src="'. $url .'"></script>';
    }
?>