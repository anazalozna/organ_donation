<?php
namespace menu;
/**
 * Created by Ana Zalozna
 * Date: 02/02/17
 * Time: 6:30 PM
 */
class BackendMenuModel extends \Model
{
	/**
	 * Get menu by user's role
	 *
	 * @return array
	 */
	public function getMenu(): array {

		if(!isset($_SESSION['user']['role'])){
			return [];
		}

		$sql = 'SELECT am.name, am.link FROM admin_menu am 
				LEFT JOIN admin_menu_roles amr ON amr.menu_id = am.id
				WHERE am.active = :active  
				AND amr.role_id  = :user
				ORDER BY sort';
		return $this->queryRows($sql, ['active' => 1, 'user' => $_SESSION['user']['role']]);
	}
}