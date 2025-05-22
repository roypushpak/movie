<?php

class User {

    public $username;
    public $password;
    public $auth = false;

    public function __construct() {
        
    }

    public function test () {
      $db = db_connect();
      $statement = $db->prepare("select * from users;");
      $statement->execute();
      $rows = $statement->fetch(PDO::FETCH_ASSOC);
      return $rows;
    }

    public function create_user($username, $password) {
      $db = db_connect();
      // Hash the password.
      $hash = password_hash($password, PASSWORD_DEFAULT);
      // Create an SQL statement to insert the new user into the database using the username and the password hash.
      $statement = $db->prepare("INSERT into users (username, password_hash) VALUES ('$username', '$hash')");
      return $statement->execute();
    }
    public function usernameExists($username) {
      // Connect to database.
      $db = db_connect();
      // Check if the username already exists in the database by querying database.
      $statement = $db->prepare("select * from users where username = :username");
      $statement->bindValue(':username', $username);
      $statement->execute();
      // Check if any matches occur and return either true or false.
      return $statement->fetch() ? true : false;
    }
    public function attemptLog($username, $attempt) {
      $db = db_connect();
      $statement = $db->prepare("insert into log (username, attempt) VALUES (:username, :attempt)");
      $statement->bindValue(':username', $username);
      $statement->bindValue(':attempt', $attempt);
      $statement->execute();
    }
    public function locked($username) {
      // Connect to database.
      $db = db_connect();
      $sixtySeconds = date('Y-m-d H:i:s', time() - 60);
      $statement = $db->prepare("select count(*) as count_number from log where username = :username and attempt = 'bad' and time >= :sixtySeconds order by time desc limit 3");
      $statement->bindValue(':username', $username);
      $statement->bindValue(':sixtySeconds', $sixtySeconds);
      $statement->execute();
      $badAttempts = $statement->fetch(PDO::FETCH_ASSOC);
      // Return true if >= 3 failed attempts.
      return $badAttempts['count_number'] >= 3;
    }
    public function authenticate($username, $password) {
        /*
         * if username and password good then
         * $this->auth = true;
         */
		$username = strtolower($username);
    // Check if data is requested.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if ($this->locked($username)) {
        $_SESSION['locked_text'] = " Account is locked for 60 seconds.";
        exit;
      }
      $username = $_REQUEST['username'];
      $password = $_REQUEST['password'];
		$db = db_connect();
        $statement = $db->prepare("select * from users WHERE username = :name;");
        $statement->bindValue(':name', $username);
        $statement->execute();
        $rows = $statement->fetch(PDO::FETCH_ASSOC);
		
		if (password_verify($password, $rows['password_hash'])) {
			$this->attemptLog($username, 'good');
      $_SESSION['auth'] = 1;
			$_SESSION['username'] = ucwords($username);
      $_SESSION['user_id'] = $rows['id'];
      $_SESSION['is_admin'] = $rows['is_admin'];
			unset($_SESSION['failedAuth']);
			header('Location: /home');
			die;
		} else {
      $this->attemptLog($username, 'bad');
			if(isset($_SESSION['failedAuth'])) {
				$_SESSION['failedAuth'] ++; //increment
			}
      else {
				$_SESSION['failedAuth'] = 1;
			}
			header('Location: /login');
			die;
		}
    }

}
    public function getUserId($username) {
      // Connect to database.
      $db = db_connect();
      $statement = $db->prepare("select id from users where username = :username");
      $statement->bindValue('username', $username, PDO::PARAM_STR);
      $statement->execute();
      $rows = $statement->fetch(PDO::FETCH_ASSOC);
      return $rows['id'];
    }
    public function getLoginsTotal() {
      // Connect to database.
      $db = db_connect();
      $statement = $db->prepare("select username, count(*) as login_count from log where attempt = 'good' group by username order by login_count desc");
      $statement->execute();
      $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
      return $rows;
    }
}