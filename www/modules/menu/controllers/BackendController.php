<?php
namespace Menu;
/**
 * Created by Ana Zalozna
 * Date: 01/02/17
 * Time: 9:22 PM
 */
class BackendController extends \BController
{
	/**
	 * Generate and return admin menu
	 *
	 * @return string view render
	 */
	public function actionMenu(){
		$model = \App::getInstance()->loadModel('menu/backendMenu');
		$data = [
			'menuList' => $model->getMenu(),
		];
		return $this->renderPartial('backend/menu', $data, true);
	}

}