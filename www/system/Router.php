<?php

/**
 * Created by Ana Zalozna
 * Date: 21/01/17
 * Time: 10:49 PM
 */
class Router
{
	/**
	 * @var Controller $__controller
	 */
	private $__controller;

	/**
	 * Controller action name
	 * @var string $__action
	 */
	private $__action;

	/**
	 * @var array $__routes
	 */
	private $__routes;

	/**
	 * @var string $__url
	 */
	private $__url;

	/**
	 * Keeps urls params
	 *
	 * @var array
	 */
	private $__params = [];

	/**
	 * Router constructor.
	 */
	public function __construct(){
		$this->__routes = Config::get('routes');
	}

	/**
	 * Run a route
	 */
	public function run(){
		foreach ($this->__routes as $route => $path){
			if($this->compare($route)){
				$this->parse($path);
				return;
			}
		}

		App::getInstance()->redirect('/404');
	}

	/**
	 * @param string $url
	 */
	public function setUrl(string $url){
		$this->__url = $url;
	}

	/**
	 * Compare url and rout path.
	 *
	 * @param string $route
	 * @return bool
	 */
	private function compare(string $route): bool {
		if(preg_match("#^$route$#", trim($this->__url, '/'), $matches)){
			foreach ($matches as $key => $value) {
				if ($key == 0){
					continue;
				}
				$this->__params[$key] = $value;
			}
			return true;
		}
		return false;
	}
	/**
	 * Set Controller and Action by path
	 *
	 * @param string $path
	 */
	private function parse(string $path){
		if(preg_match('#^(.+?)/(.+?)/(.+?)(?:/(.+))?$#', $path, $matches)){
			try{
				if(isset($matches[4])) {
					$this->setGetParams($matches[4]);
				}
				$this->setController($matches[1], $matches[2], $matches[3]);
			}catch(Exception $e){
				$this->setController('system', 'Error', '404');
			}
		}
	}

	/**
	 * @return Controller
	 */
	public function getController(): Controller {
		return $this->__controller;
	}

	/**
	 * @return string
	 */
	public function getAction(): string {
		return $this->__action;
	}

	/**
	 * Set controller and action
	 *
	 * @param string $moduleName
	 * @param string $controllerName
	 * @param string $actionName
	 * @throws Exception
	 */
	public function setController(string $moduleName, string $controllerName, string $actionName){
		$realPath = "/modules/$moduleName/controllers/$controllerName.php";
		require_once($_SERVER['DOCUMENT_ROOT'].$realPath);

		$controllerName = '\\'.ucfirst($moduleName).'\\'.$controllerName;
		$this->__controller = new $controllerName;
		$this->__action = $actionName;

		if(!method_exists($this->__controller, $this->__action)){
			throw new Exception('Method does not exist');
		}
	}

	/**
	 * Parse $queryParams adn set to $_GET
	 *
	 * @param string $queryParams
	 */
	private function setGetParams(string $queryParams){
		foreach (explode('/', $queryParams) as $part) {
			list($key, $value) = explode(':', $part);
			$_GET[$key] = $this->__params[trim($value, '$')];
		}
	}
}