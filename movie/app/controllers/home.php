<?php

class Home extends Controller {
    public function __construct() {
       if (!isset($_SESSION['auth'])) {
         header('Location: /login');
         exit;
       } 
    }
    public function index() {
      $user = $this->model('User');
      $data = $user->test();
			
	    $this->view('home/index');
    }

}
?>