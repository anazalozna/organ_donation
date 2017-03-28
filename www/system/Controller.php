<?php

/**
 * Created by Ana Zalozna
 * Date: 22/01/17
 * Time: 11:35 AM
 */
abstract class Controller
{
	/**
	 * Path to a View dir
	 *
	 * @var string $viewDir
	 */
	private $__viewDir;

	/**
	 * Path to a Models dir
	 *
	 * @var string $modelDir
	 */
	private $__modelDir;

	/**
	 *Keeps a name of template
	 *
	 * @var string $template
	 */
	protected $_template;

	/**
	 * Controller constructor.
	 *
	 * Set controller default data
	 */
	public function __construct(){
		$class = new ReflectionClass($this);

		$this->__viewDir = realpath(dirname($class->getFileName()).'/../views');
		$this->__modelDir = realpath(dirname($class->getFileName()).'/../models');

		$this->_template = Config::get('global')['site_template'];
	}

	/**
	 * Render view with template
	 *
	 * @param string $view
	 * @param array $data
	 */
	protected function render(string $view, array $data){
		$__content = $this->renderPartial($view, $data, true);
		require $_SERVER['DOCUMENT_ROOT'].'/templates/'.$this->_template.'.php';
	}

	/**
	 * Render view
	 *
	 * @param string $view
	 * @param array $data
	 * @param bool $return
	 * @return string
	 */
	protected function renderPartial(string $view, array $data, $return = false){
		if(file_exists($this->__viewDir.'/'.$view.'.php')){
			extract($data);
			ob_start();
			require $this->__viewDir.'/'.$view.'.php';
			$__content =  ob_get_clean();
		}else{
			if (Config::get('global')['debug']){
				App::getInstance()->showError('File '.$this->viewDir.'/'.$view.'.php was not found');
			}else{
				App::getInstance()->redirect('/404');
			}
		}

		if($return){
			return $__content;
		}

		echo $__content;
	}

	/**
	 * Generate Json data
	 *
	 * @param array $data
	 */
	protected function renderJson(array $data){
		header('Content-Type: application/json');
		echo json_encode($data);
	}
}