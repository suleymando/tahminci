<?php
// app/core/App.php
class App {
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // Check for admin route
        if (isset($url[0]) && $url[0] == 'admin') {
            $this->controller = 'AdminController';
            array_shift($url);

            if (isset($url[0])) {
                $this->method = $url[0];
                array_shift($url);
            }
        } elseif (isset($url[0]) && $url[0] == 'install') {
             $this->controller = 'InstallController';
             $this->method = 'index';
        }
        else {
             // Default frontend routing could go here (e.g. /coupon/1)
             if(isset($url[0]) && $url[0] == 'coupon') {
                 $this->controller = 'CouponController';
                 array_shift($url);
                 if(isset($url[0])) {
                     $this->method = 'show';
                     $this->params = [$url[0]];
                 }
             }
        }

        require_once __DIR__ . '/../controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        if (isset($url[0])) {
            if (method_exists($this->controller, $url[0])) {
                $this->method = $url[0];
                unset($url[0]);
            }
        }

        if(!empty($url)) {
            $this->params = array_values($url);
        }

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}
