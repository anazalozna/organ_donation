<?php
namespace Pages;
/**
 * Created by Ana Zalozna
 * Date: 20/02/17
 * Time: 5:29 PM
 */
class FrontendController extends \Controller
{
	/**
	 * Get page info from db
	 */
	public function actionPage () {
		$model = \App::getInstance()->loadModel('pages/pages');
		if($_SERVER['REQUEST_URI'] == '/') {
			$page_data = $model->getPage('home');
		}else{
			$page_data = $model->getPage($_GET['alias']);
		}

		$data = [
			'content' => $page_data['content'],
			'main_title' => $page_data['main_title'],
            'alias' => $page_data['alias'],
		];

		\App::getInstance()->setParam('title', 'Organ Donation');
		$this->render('frontend/page', $data);
	}
}