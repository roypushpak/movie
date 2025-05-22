<?php

class Login extends Controller {

    public function index() {		
	    $this->view('login/index');
    }
    
    public function verify() {
			$username = $_REQUEST['username'];
			$password = $_REQUEST['password'];
		
			$user = $this->model('User');

			if ($user->locked($username)) {
				$_SESSION['locked_text'] = " Account is locked for 60 seconds.";
				header('Location: /login');
				exit;
			}
			
			if ($user->authenticate($username, $password)) {
				$_SESSION['auth'] = 1;
				$_SESSION['username'] = $username;
				$_SESSION['user_id'] = $user->getUserId($username);
				header('Location: /home');
				exit;
			}
			else {
				header('Location: /login');
				exit;
			}
    }
				}
?>