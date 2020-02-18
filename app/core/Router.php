<?php

class Router
{
    protected $routes = [];
    protected $params = [];

    public function add($route, $params = [])
    {

        // Add start and end delimiters, and case insensitive flag
        $route = ucfirst($route);
        $this->routes[$route] = $params;
    }

    /**
     * Get all the routes from the routing table
     *
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Get the currently matched parameters
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Match the route to the routes in the routing table, setting the $params
     *
     * @param string $url The route URL
     *
     * @return boolean  true if a match found, false otherwise
     */
    public function match($url, $params)
    {
        if (array_key_exists( $url, $this->getRoutes() )){
            $this->params = $params;
            return true;
        }

        return false;
    }

    /**
     * Dispatch the route, creating the controller object and running the
     * action method
     *
     * @param string $url The route URL
     *
     * @return void
     */
    public function dispatch($url)
    {    	
    	$url = explode('/', $url);
    	$url_dispatch = ucfirst($url[0]);
    	$params = (isset($url[1]) && $url[1] !== false) ? $url[1] : false; // Only two params for this example
    	$ids = (isset($url[2]) && $url[2] !== false) ? $url[2] : false; // Only two params for this example

    	//Dispatch Section
        if ($this->match($url_dispatch, $params)) {
        	$controllerName = ucfirst($url_dispatch);
			if (file_exists(CONTROLLERS . $controllerName.'.php')) {

				require_once(CONTROLLERS . $controllerName.'.php');
				$controller = new $controllerName();
				
				if ($params !== false) {
					$actionName = $params;
					if (method_exists ( $controller , $actionName )) {
						$ids = (is_numeric($ids)) ? $ids : false;
						$controller->{$actionName}($ids);
					}
					else {
						$controller->index();
					}
				}
				else
				{
					// default action
					$controller->index();
				}
			}		

        } else {
        	require_once(CONTROLLERS . 'Errors.php');
			$controller = new Errors();
			$controller->error404();
        }
    }

}