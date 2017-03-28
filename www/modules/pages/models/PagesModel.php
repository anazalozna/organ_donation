<?php
namespace Pages;
/**
 * Created by Ana Zalozna
 * Date: 20/02/17
 * Time: 5:48 PM
 */
class PagesModel extends \Model
{
	/**
	 * Find data for requested page
	 *
	 * @param string $alias
	 * @return array
	 */
	public function getPage (string $alias) :array{
		$sql = "SELECT content, main_title, alias FROM pages
				WHERE alias = :alias";
		return $this->queryRow($sql, ['alias' => $alias]);
	}

	/**
	 * Find data for requested page by id
	 *
	 * @param int $id
	 * @return array
	 */
	public function getPageByID (int $id) :array{
		$sql = "SELECT content, main_title, alias FROM pages
				WHERE id = :id";
		return $this->queryRow($sql, ['id' => $id]);
	}

	/**
	 * Get all pages
	 *
	 * @return array
	 */
	public function getPages(): array{
		$sql = "SELECT main_title, alias, id FROM pages";
		return $this->queryRows($sql);
	}

	/**
	 * Update page data
	 *
	 * @param int $id
	 * @param array $data
	 * @return bool
	 */
	public function updatePage(int $id, array $data): bool{
		$sql = "UPDATE pages SET main_title = :title, alias = :alias, content = :content  WHERE id = :id";
		try{
			$stmt = $this->_pdo->prepare($sql);
			$stmt->execute(array_merge($data, ['id' => $id]));
			return True;
		}catch (\PDOException $e){
			return False;
		}
	}

	/**
	 * Send message from contact form
	 *
	 * @param array $user_data
	 */
	public function sendMessage(array $user_data){
		$from_user = 'Contact form';
		$from_email = 'contact'.'@'.explode(':', $_SERVER['HTTP_HOST'])[0];

		$subject = $user_data['subject'];
		$message =
			"<ul>".
			"<li>Name: {$user_data['name']}</li>".
			"<li>Email: {$user_data['email']}</li>".
			"<li>Phone: {$user_data['phone']}</li>".
			"</ul>";

		$message .= "<p>Message: {$user_data['message']}</p>";

		$from = new \SendGrid\Email($from_user, $from_email);
		$to = new \SendGrid\Email('Admin', \Config::get('global')['feedback_mail']);
		$content = new \SendGrid\Content("text/html", $message);
		$mail = new \SendGrid\Mail($from, $subject, $to, $content);
		$sg = new \SendGrid(\Config::get('global')['SendGridAPI_key']);
		$sg->client->mail()->send()->post($mail);
	}
}