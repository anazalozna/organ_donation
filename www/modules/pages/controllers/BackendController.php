<?php
/**
 * Created by Ana Zalozna
 * Date: 07.03.17
 * Time: 16:54
 */

namespace Pages;


class BackendController extends \BController
{
	public function actionPages(){
		$user_model = \App::getInstance()->loadModel('user/user');
		if(!$user_model->checkLogin() || !$user_model->checkAccess([1])){
			\App::getInstance()->redirect('/admin');
		}

		$page_model = \App::getInstance()->loadModel('pages/pages');

		$data = [
			'pages' => $page_model->getPages()
		];

		\App::getInstance()->setParam('title', 'Pages');

		$this->render('backend/pages', $data);
	}

	public function actionEdit(){
		$user_model = \App::getInstance()->loadModel('user/user');
		if(!$user_model->checkLogin() || !$user_model->checkAccess([1]) || !isset($_GET['id'])){
			\App::getInstance()->redirect('/admin');
		}

		$page_model = \App::getInstance()->loadModel('pages/pages');
		$errors = [];

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$fields = ['title', 'alias', 'content'];
			foreach ($fields as $field){
				if(!isset($_POST[$field]) || !$_POST[$field]){
					$errors[] = "$field is empty!";
				}
			}

			if(!$errors){
				if(!$page_model->updatePage($_GET['id'], $_POST)){
					$errors[] = "Error saving data";
				}
			}
		}

		$page = $page_model->getPageByID($_GET['id']);

		$data = [
			'title' => $page['main_title'],
			'alias' => $page['alias'],
			'content' => $page['content'],
			'errors' => $errors
		];

		\App::getInstance()->setParam('title', 'Change page');

		$this->render('backend/edit_page', $data);
	}
}