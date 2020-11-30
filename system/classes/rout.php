<?php
/**
 * rout class is used for routing the application based on the url
 * 
 * rout class is used to connect the controller file,call the controller method from the viewing part url
 * 
 */
class rout 
{  
    // Default contorller, method, params
    public $controller = "userController";
    public $method     = "index";
    public $params     = [];
    /**
     * __construct() method will invoke first when the object of rout is created
     * 
     * It will take the url and checks that in controller floder the url mention controller file is exist or not
     * It will also includes the controller
     * Instantiate controller
     * It will also checks the method exists in controller of not after finding the controller
     * Also instantiate the params
     * 
     * @return call_user_func_array([$this->controller, $this->method], $this->params);
     */
    public function __construct()
    {
        $url = $this->url();
        if(!empty($url))
        {
            //checks the controller file exists or not
            if(file_exists("../application/controllers/" . $url[0] . ".php"))
            {
                $this->controller = $url[0];
                unset($url[0]);
            } 
            else 
            {
                echo "<div style='margin:0;padding: 10px;background-color:silver;'>Sorry  ".$url[0].".php not found</div>";
            }
        }
        
        // Include controller
        require_once "../application/controllers/" . $this->controller . ".php";
        // Instantiate controller
        $this->controller = new $this->controller;

        //checks the method exists in a specific controller file or not
        if(isset($url[1]) && !empty($url[1]))
        {
            if(method_exists($this->controller, $url[1]))
            {
                $this->method = $url[1];
                unset($url[1]);
            } 
            else 
            {
                echo "<div style='margin:0;padding: 10px;background-color:silver;'>Sorry  method ".$url[1]." not found</div>";
            }
        }

        if(isset($url))
        {
            $this->params = $url;
        }
        else
        {
            $this->params = [];
        }
        call_user_func_array([$this->controller, $this->method], $this->params);
    }
    /**
     * url() get the url using $_GET() method and it will trim,filter and returns the clean url
     * 
     * @return $url
     */
    public function url()
    {
        if(isset($_GET['url']))
        {
            $url = $_GET['url'];
            $url = rtrim($url);
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode("/", $url);
            return $url;
        }
    }
}
?>