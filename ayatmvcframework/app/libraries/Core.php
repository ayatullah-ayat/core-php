<?php 

/*
   * App Core Class
   * Creates URL & loads core controller
   * URL FORMAT - /controller/method/params
*/
class Core {
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct()
    {
        // LOADING THE CONTROLLER FROM THE URL - /posts/edit/2
        $url = $this->getUrl();
        if(file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            $this->currentController = ucwords($url[0]);
            unset($url[0]);
        }

        include_once('../app/controllers/' . $this->currentController . '.php');
        // instantiated or created a object
        $this->currentController = new $this->currentController; // $Pages = $Pages;
        
        // MAPPING METHODS AND PARAMETERS
        if(isset($url[1])) {
            if(method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }
        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl() {
        if(isset($_GET['url'])) {
            $url = rtrim($_GET['url']);
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            // print_r($url);
            return $url;
        }
    }
}


?>