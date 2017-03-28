<?php
namespace User;
/**
 * Created by Ana Zalozna
 * Date: 22/01/17
 * Time: 10:05 AM
 */
class BackendController extends \BController
{
	public function actionIndex(){
		//echo 'here';

		$model = \App::getInstance()->loadModel('user/user');
		if(!$model->checkLogin()){
			\App::getInstance()->redirect('/admin/login');
		}

		$data = [
			'h2' => $model->getWelcomeMSG(),
			'lastSession' => $model->getLastSession($_SESSION['user']['login'])
		];

		\App::getInstance()->setParam('title', 'Welcome');
		$this->render('backend/index', $data);
	}

	/**
	 * User login page
	 */
	public function actionLogin(){
		$data = [
			'h1' => 'Login',
			'errors' => [],
			'showForm' => True,
		];

		// Processing post query
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$model = \App::getInstance()->loadModel('user/user');

			//check login attempts for hack protection
			if($model->checkLoginAttempts($_POST['login'])) {

				// check login and password
				if ($model->check($_POST['login'], $_POST['password'])) {

					$model->writeLoginLog($_POST['login'], 1);
					// check if first login is less than 24 hour after account creation
					if(!$model->isLess24($_POST['login'])){

						$data['errors'][] = 'Your account is suspended';
						$data['showForm'] = False;
					}else{
						$model->setUserSession($_POST['login']);
						\App::getInstance()->redirect($model->getLoginLink($_POST['login']));
					}
				} else {
					$model->writeLoginLog($_POST['login'], 0);
					$data['errors'][] = 'Login or password incorrect';
				}
			}else{
				$data['errors'][] = 'Hack protection, try at '.$model->getUnLockTime($_POST['login']);
				$data['showForm'] = False;
			}
		}

		\App::getInstance()->setParam('title', 'Login');
		$this->render('backend/login', $data);
	}

	public function actionLogout(){
		session_destroy();
		\App::getInstance()->redirect('/admin/login');
	}

	/**
	 * Generate a users list. Show form to add and delete users
	 */
	public function actionUserList(){
		$model = \App::getInstance()->loadModel('user/user');
		if(!$model->checkLogin() || !$model->checkAccess([1])){
			\App::getInstance()->redirect('/admin');
		}

		$data = [
			'userList' => $model->getUserList(),
			'roles' => $model->getRoles(),
		];
		\App::getInstance()->setParam('title', 'User list');

		if($_SERVER['REQUEST_METHOD'] == 'GET'){
			$this->render('backend/user_list', $data);
		}else{
			// for ajax query
			$this->renderPartial('backend/user_list', $data);
		}
	}

	/**
	 *  Add new users
	 */
	public function actionAdd(){
		$model = \App::getInstance()->loadModel('user/user');
		if(!$model->checkLogin() || !$model->checkAccess([1]) || $_SERVER['REQUEST_METHOD'] !== 'POST'){
			\App::getInstance()->redirect('/admin');
		}

		$crud = \App::getInstance()->loadModel('user/CRUD');

		$data = $crud->add($_POST);
		$this->renderJson($data);
	}

	/**
	 *  Delete users
	 */
	public function actionDelete(){
		$model = \App::getInstance()->loadModel('user/user');
		if(!$model->checkLogin() || !$model->checkAccess([1]) || !isset($_GET['id'])){
			\App::getInstance()->redirect('/admin');
		}

		$crud = \App::getInstance()->loadModel('user/CRUD');
		$crud->delete((int)$_GET['id']);
		\App::getInstance()->redirect('/admin/users');
	}

	/**
	 * Change user data
	 */
	public function actionChange(){
		$model = \App::getInstance()->loadModel('user/user');
		if(!$model->checkLogin()){
			\App::getInstance()->redirect('/admin');
		}

		$data = [
			'email' => $_SESSION['user']['mail'],
			'errors' => [],
			'showSuccess' => false,
		];

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$crud = \App::getInstance()->loadModel('user/CRUD');
			$data['errors'] = $crud->saveChanges($_POST);
			if(!$data['errors']){
				$data['showSuccess'] = true;
				$data['email'] = $_SESSION['user']['mail'];
			}
		}

		\App::getInstance()->setParam('title', 'Change user data');

		$this->render('backend/change', $data);
	}
}