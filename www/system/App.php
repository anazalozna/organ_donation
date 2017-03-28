<?php

/**
 * Created by Ana Zalozna
 * Date: 22/01/17
 * Time: 11:04 AM
 */

/**
 * Class Singleton (from wikipedia https://ru.wikipedia.org/wiki/%D0%9E%D0%B4%D0%B8%D0%BD%D0%BE%D1%87%D0%BA%D0%B0_(%D1%88%D0%B0%D0%B1%D0%BB%D0%BE%D0%BD_%D0%BF%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D0%B8%D1%80%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D1%8F)#PHP_5.4)
 */
trait Singleton {
	static private $instance = null;

	private function __construct() { /* ... @return Singleton */ }  // protection from creation through new Singleton
	private function __clone() { /* ... @return Singleton */ }  // protection from creation through clonning
	private function __wakeup() { /* ... @return Singleton */ }  // protection from creation through unserialize

	static public function getInstance() {
		return
			self::$instance===null
				? self::$instance = new static()//new self()
				: self::$instance;
	}
}

class App
{
	use Singleton;

	/**
	 * @var Router $__route
	 */
	private $__route;

	/**
	 * Custom params
	 *
	 * @var array $__params
	 */
	private $__params = [];

	/**
	 * Set router
	 * @param Router $route
	 */
	public function setRoute(Router $route){
		$this->__route = $route;
	}

	/**
	 * Execute Controller's action
	 *
	 * @param bool $return
	 */
	public function execute($return = false){
		$controller = $this->__route->getController();
		$action = $this->__route->getAction();

		if($return){
			return $controller->$action();
		}

		$controller->$action();
	}

	/**
	 * Set custom var
	 *
	 * @param $key
	 * @param $value
	 */
	public function setParam($key, $value){
		$this->__params[$key] = $value;
	}

	/**
	 * Get custom param
	 *
	 * @param $key
	 * @return mixed
	 */
	public function getParam($key){
		return isset($this->__params[$key]) ? $this->__params[$key] : null;
	}

	/**
	 * Load and return a model
	 *
	 * @param string $path
	 * @return Model
	 */
	public function loadModel(string $path): Model {
		list($module, $model) = explode('/', $path);
		$model = ucfirst($model).'Model';
		require_once($_SERVER['DOCUMENT_ROOT']."/modules/$module/models/{$model}.php");
		$model = '\\'.ucfirst($module).'\\'.$model;
		return new $model;
	}

	public function redirect(string $url, $code=302){
		header('Location: '.$url, true, $code);
		die;
	}

	/**
	 * Show error message
	 *
	 * @param string $msg
	 */
	public function showError(string $msg){
		if(function_exists('xdebug_print_function_stack')){
			xdebug_print_function_stack($msg);
			die;
		}

		echo $msg . "<br><br>\n\n";
		$e = new Exception();
		print_r($e->getTraceAsString());
		die;
	}

	/**
	 * Loads a controller
	 *
	 * @param string $path
	 * @param bool $return
	 */
	public function loadController(string $path, $return = true){
		list($module, $controllerName, $actionName) = explode('/', $path);

		$controllerName = ucfirst($controllerName).'Controller';
		$actionName = 'action'.ucfirst($actionName);

		$this->__route->setController($module, $controllerName, $actionName);

		if($return){
			return $this->execute(true);
		}

		$this->execute();
	}
}