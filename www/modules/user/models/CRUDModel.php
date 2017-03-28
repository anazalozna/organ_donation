<?php
/**
 * Created by Ana Zalozna
 * Date: 02/02/17
 * Time: 8:03 PM
 */

namespace User;

class CRUDModel extends \Model
{
	/**
	 * Validate and add new users
	 *
	 * @param array $formData
	 * @return array
	 */
	public function add(array $formData): array {
		$errors = $this->validation($formData);
		$users = $this->convertForm($formData);

		if($errors){
			return $errors;
		}

		foreach($users as $user){
			$pass = $this->generatePassword();
			$row = [
				'login' => $user['login'],
				'mail'  => $user['email'],
				'role'  => $user['role'],
				'pass'  => password_hash($pass, PASSWORD_DEFAULT),
			];
			try{
				$this->insertRow('users', $row);
				if(!$this->sentEmail($row, $pass)){
					$errors[] = "Letter was not sent";
				}
			}catch (\PDOException $e){
				$errors[] = "Login '{$user['login']}' or email '{$user['email']}' already exists";
			}

		}

		return $errors;
	}

	/**
	 * Delete user by id
	 *
	 * @param int $id
	 */
	public function delete(int $id){
		$this->deleteById($id, 'users');
	}

	/**
	 * Form data validation
	 *
	 * @param array $formData
	 * @return array
	 */
	private function validation(array $formData): array {
		$errors = [];
		$requiredData = ['role', 'login', 'email'];

		if(count($formData) !== count($requiredData)){
			$errors[] = 'Missed fields';
		}

		foreach ($requiredData as $field) {
			if(!isset($formData[$field])){
				$errors[] = "Field $field is missing";
			}
		}

		if($errors){
			return $errors;
		}

		$roles = $this->getRoles();

		foreach ($formData['role'] as $key => $value){
			if(!in_array($value, $roles)){
				$errors[] = "Undefined role for user {$formData['login'][$key]}";
			}
		}

		return $errors;
	}

	/**
	 * Ger user role ids
	 *
	 * @return array
	 */
	private function getRoles(): array {
		$ids = [];
		$result = $this->queryRows('SELECT id FROM roles');
		foreach ($result as $row) {
			$ids[] = $row['id'];
		}
		return $ids;
	}

	/**
	 *  Convert form data to more readable data
	 *
	 * @param array $formData
	 * @return array
	 */
	private function convertForm(array $formData): array {
		$users = [];
		foreach($formData as $fieldKey => $fields) {
			foreach ($fields as $key => $value) {
				$users[$key][$fieldKey] = $value;
			}
		}
		return $users;
	}

	/**
	 * Generate random string
	 * http://stackoverflow.com/questions/4356289/php-random-string-generator
	 *
	 * @param int $length
	 * @return string
	 */
	private function generatePassword($length = 20): string {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ[]/!@#$%^&*()_+=-';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	/**
	 * Sent email to user after creating new account
	 * https://github.com/sendgrid/sendgrid-php
	 *
	 * @param array $userData
	 * @param string $pass
	 * @return bool
	 */
	private function sentEmail(array $userData, string $pass): bool {
		$from_user = $_SESSION['user']['login'];
		$from_email = $_SESSION['user']['login'].'@'.explode(':', $_SERVER['HTTP_HOST'])[0];
		$to = $userData['mail'];
		$subject = 'Account created';
		$message =  "<h3><a href='http://{$_SERVER['HTTP_HOST']}/admin/login'>Login page</a></h3>".
			"<ul>".
			"<li>Login: {$userData['login']}</li>".
			"<li>Password: $pass</li>".
			"</ul>";

		$from = new \SendGrid\Email($from_user, $from_email);
		$to = new \SendGrid\Email($userData['login'], $to);
		$content = new \SendGrid\Content("text/html", $message);
		$mail = new \SendGrid\Mail($from, $subject, $to, $content);
		$sg = new \SendGrid(\Config::get('global')['SendGridAPI_key']);
		$response = $sg->client->mail()->send()->post($mail);

		return $response->statusCode() == 202;
	}


	/**
	 * Change user mail and password
	 *
	 * @param array $userData
	 * @return array
	 */
	public function saveChanges(array $userData): array {
		$errors = [];
		$updateData = [];

		//check for empty data
		if(!$userData['email'] && !$userData['password']){
			return ['Empty values'];
		}

		// prepare data for update
		if(trim($userData['email'])){
			$updateData['mail'] = trim($userData['email']);
		}
		if(trim($userData['password'])){
			$updateData['pass'] = password_hash(trim($userData['password']), PASSWORD_DEFAULT);
		}

		// prepare sql
		$columns = '';
		foreach ($updateData as $key => $value){
			$columns .= "$key = :$key, ";
		}
		$columns = trim($columns, ', ');
		$sql = "UPDATE users SET $columns WHERE login = :login";

		// save to db
		try{
			$stmt = $this->_pdo->prepare($sql);
			$stmt->execute(array_merge($updateData, ['login' => $_SESSION['user']['login']]));
		}catch (\PDOException $e){
			$errors[] = 'There was an error in saving data.';
		}

		// save to session
		if(!$errors && trim($userData['email'])){
			$_SESSION['user']['mail'] = trim($userData['email']);
		}

		return $errors;
	}
}