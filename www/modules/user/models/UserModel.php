<?php
namespace User;
/**
 * Created by Ana Zalozna
 * Date: 22/01/17
 * Time: 2:28 PM
 */
class UserModel extends \Model
{
	/**
	 * Check if user can log in
	 *
	 * @param string $login
	 * @param string $pass
	 * @return bool
	 */
	public function check(string $login, string $pass): bool{
		$result = $this->queryRow('SELECT pass FROM users WHERE login = :login', ['login' => $login]);

		if(!$result){
			return false;
		}

		return password_verify($pass, $result['pass']);
	}

	/**
	 * Set user session
	 *
	 * @param string $user
	 */
	public function setUserSession(string $user){
		$result = $this->queryRow('SELECT role, mail FROM users WHERE login = :login', ['login' => $user]);
		$_SESSION['user'] = [
			'role' => $result['role'],
			'mail' => $result['mail'],
			'login' => $user,
		];
	}

	/**
	 * Check if user is logged in
	 *
	 * @return bool
	 */
	public function checkLogin(): bool{
		return isset($_SESSION['user']['role']);
	}

	/**
	 * Show welcome message to user
	 *
	 * @return string
	 */
	public function getWelcomeMSG(): string{
		$date = \Config::getDateTime();
		$hour = $date->format('H');

		if($hour < 12){
			$dayPart = 'morning';
		} elseif ($hour < 18){
			$dayPart = 'afternoon';
		} else {
			$dayPart = 'evening';
		}

		return "Good $dayPart {$_SESSION['user']['login']}";
	}

	/**
	 * Write success/failure log to db
	 *
	 * @param string $login
	 * @param int $success
	 */
	public function writeLoginLog(string $login, int $success){
		$data = [
			'login' => $login,
			'date' => \Config::getDateTime()->format('Y-m-d H:i:s'),
			'ip' => $_SERVER['REMOTE_ADDR'],
			'success' => $success
		];
		$this->insertRow('login_log', $data);
	}

	/**
	 * Check login attempts for hack protection
	 *
	 * @param string $login
	 * @return bool
	 */
	public function checkLoginAttempts(string $login): bool{
		$sql = 'SELECT count(*) counter FROM login_log
				WHERE login = :login
				AND date BETWEEN DATE_SUB(NOW(), INTERVAL 30 MINUTE) AND NOW()
				AND success = 0';

		$result = $this->queryRow($sql, ['login' => $login]);

		return (int)$result['counter'] < 3;
	}

	/**
	 * Get unlock time to let login
	 *
	 * @param string $login
	 * @return string
	 */
	public function getUnLockTime(string $login): string{
		$sql = 'SELECT `date` as unlock_time FROM login_log
				WHERE login = :login
				AND `date` BETWEEN DATE_SUB(NOW(), INTERVAL 30 MINUTE) AND NOW()
				AND success = 0
				ORDER BY `date`';

		$result = $this->queryRow($sql, ['login' => $login]);

		//calc data for next attempts
		$date = \Config::getDateTime($result['unlock_time']);
		$date->modify('+30 minutes');
		return $date->format('g:i a');
	}

	public function getLastSession(string $login): string {
		$sql = 'SELECT `date` FROM login_log
				WHERE login = :login
				AND success = 1
				ORDER BY `date` DESC 
				LIMIT 1,1';

		$result = $this->queryRow($sql, ['login' => $login]);
		if(!$result){
			return 'This is your first visit.';
		}
		return 'Last visit in '.\Config::getDateTime($result['date'])->format('M j, g:i a');
	}

	/**
	 * Check if user's role has rights
	 *
	 * @param array $roles
	 * @return bool
	 */
	public function checkAccess(array $roles): bool {
		$sql = 'SELECT id FROM users 
				WHERE login = :login
				AND role IN(:roles)';

		$result = $this->queryRow($sql, ['roles' => implode(',', $roles), 'login' => $_SESSION['user']['login']]);

		if($result){
			return true;
		}

		return false;
	}

	/**
	 * Get list of users
	 *
	 * @return array
	 */
	public function getUserList(): array {
		$sql = 'SELECT u.id, u.login, u.mail, r.name role FROM users u
				INNER JOIN roles r ON u.role = r.id
				WHERE u.login != :mylogin';

		return $this->queryRows($sql, ['mylogin' => $_SESSION['user']['login']]);
	}


	/**
	 * Get list of user roles
	 *
	 * @return array
	 */
	public function getRoles(): array {
		$sql = 'SELECT id, name FROM roles';
		return $this->queryRows($sql);
	}

	/**
	 * Check if it is first user login
	 *
	 * @param string $login
	 * @return bool
	 */
	public function isFirstLogin(string $login): bool {
		$sql = "SELECT count(*) as logins FROM users u
				INNER JOIN login_log ll ON ll.login = u.login
				WHERE ll.date > u.creation_datetime
				AND ll.success = :success
				AND u.login = :login";

		$result = $this->queryRow($sql, ['success' => 1, 'login' => $login]);

		return $result['logins'] == 1;
	}

	/**
	 * Get redirection link after login
	 *
	 * @param string $login
	 * @return string
	 */
	public function getLoginLink(string $login): string {
		if($this->isFirstLogin($login)){
			return '/admin/user/change';
		}

		return '/admin';
	}

	/**
	 * Check login in 24 after account creation
	 *
	 * @param string $login
	 * @return bool
	 */
	public function isLess24(string $login): bool {
		$sql = "SELECT count(*) logins FROM users u
				INNER JOIN login_log ll ON ll.login = u.login
				WHERE ll.date > u.creation_datetime
				AND ll.date BETWEEN u.creation_datetime AND DATE_ADD(u.creation_datetime, INTERVAL 24 HOUR)
				AND ll.success = :success
				AND u.login = :login";

		$result = $this->queryRow($sql, ['success' => 1, 'login' => $login]);

		return $result['logins'] > 0;
	}
}