<?php

/**
 * Class for Router
 */
class Router
{
	protected $routes=[
		'GET'=>[],
		'POST'=>[]
	];

	public function define($routes)
	{
		$this->routes=$routes;
	}

	public function get($uri,$controller)
	{
		$this->routes['GET'][$uri]=$controller;
	}

	public function post($uri,$controller)
	{
		$this->routes['POST'][$uri]=$controller;
	}

	public function direct($uri,$requestType)
	{
		
		$id=explode("/", $uri);
		if(isset($id[1]) && is_numeric($id[1]))
			$uri=$id[0];

		if(array_key_exists($uri, $this->routes[$requestType]))
			return $this->routes[$requestType][$uri];

		throw new Exception("PAGE Not Found", 1);
		
	}

	public static function load($file)
	{
		$router=new static;

		require $file;

		return $router;	
	}
}