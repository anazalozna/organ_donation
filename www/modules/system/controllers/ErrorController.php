<?php
namespace System;
/**
 * Created by Ana Zalozna
 * Date: 22/01/17
 * Time: 12:02 PM
 */
class ErrorController extends \Controller
{
	/**
	 * Show 404 page
	 */
	public function action404(){
		//echo '404';
		$data = [
			'h2' => 'Page was not found'
		];

		header('HTTP/1.0 404 Not Found');

		\App::getInstance()->setParam('title', '404');
		$this->render('error/404', $data);
	}
}