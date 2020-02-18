<?php

class Controller extends View
{
    /**
     * Render a view
     *
     * @param string $viewName The name of the view to include
     * @param array  $data Any data that needs to be available within the view
     *
     * @return void
     */
    
    public function view($viewName, $data = '')
    {
		// Create a new view and display the parsed contents
        $view = new View($viewName, $data);

    }

    /*
    * Default View
    */
    public function index()
    {
        $view = new View();
    }

    public function model($model)
    {
        require_once MODELS . ucfirst($model) . '.php';
        $model = $model.'Model';
        return new $model();
    }
}
