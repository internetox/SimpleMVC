<?php


class View
{
	public $view;

    public function __construct($viewFile = 'index', $data = false)
	{
		$viewFile = (is_string($viewFile)) ? $viewFile : 'index' ;
		$this->view = $viewFile;
		require(VIEWS. $viewFile . '.php');
	}
}