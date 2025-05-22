<?php

class Movie extends Controller {
  // Blank constructor.
  public function __construct() {
    }
  // Show index view of movie.
  public function index() {
    $this->view('movie/index', []);
  }
  // Create movie search function.
  public function search() {
    // Get movie using get or post.
    if(isset($_GET['movie']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
      $movie_title = $_GET['movie'];
    }
    else if(isset($_POST['movie']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
      $movie_title = $_POST['movie'];
    }
    // Otherwise send to /movie.
    else {
      header('Location: /movie');
      exit;
    } 
    // Omdb model.
    $omdb = $this->model('Omdb');
    //Search movie by title.
    $movie = $omdb->search_movie($movie_title);

    if(isset($movie['Response']) && $movie['Response'] === 'True' && $movie) {
      // Get the ratings for the specific movie and display.
      $rating_model = $this->model('Rating');
      $user_ratings = $rating_model->getMovieRatings($movie['Title']);
      $this->view('movie/result', ['movie' => $movie, 'user_ratings' => $user_ratings]);
    }
      // Otherwise print movie was not found.
    else {
      $this->view('movie/index', ['error' => 'The movie was not found']);
    }
  }
  // Create rate function.
  public function rate() {
    // Make sure the user is logged in to rate movies.
    if(!isset($_SESSION['auth'])) {
      $_SESSION['error'] = "Login to rate movies.";
      header('Location: /login');
      exit;
    }
    // Send to /movie.
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      header('Location: /movie');
      exit;
    }
    //Get movie name and rating.
    $movie_name = $_POST['movie_name'] ?? '';
    $rating = $_POST['rating'] ?? '';
    // Ensure the rating is between 1-5 and that the movie name and rating are not empty.
    if (!in_array($rating, ['1', '2', '3', '4', '5']) || empty($movie_name) || empty($rating)) {
      // Print error message.
      $_SESSION['error'] = "Rating must be between 1 and 5, please try again. The movie name or rating cannot be blank.";
      // Go to /movie.
      header('Location: /movie');
      exit;
    }
    // Session variable for user_id and rating model.
    $user_id = $_SESSION['user_id'];
    $rating_model = $this->model('Rating');
    // Print rating was successful or not.
    if ($rating_model->saveRating($user_id, $movie_name, $rating)) {
      $_SESSION['success'] = "The rating was saved successfully!";
    }
    else {
      $_SESSION['error'] = "The rating was not saved!";
    }
    header('Location: /movie');
    exit;
  }
    /*COSC Project
      movie[search...]
    [SEARCH BUTTON]
    */
  // Create review function.
  public function review() {
    if($_SERVER['REQUEST_METHOD'] !== 'POST') {
      header('Location: /movie');
      exit;
    }
    $movie_title = $_POST['movie_name'] ?? '';
    $rating = $_POST['rating'] ?? '';
    // Check ratings is between 1 and 5 and movie title isn't empty.
    if (empty($movie_title) || !in_array($rating, ['1', '2', '3', '4', '5'])) {
      $_SESSION['error'] = "A movie title and rating is required to generate a review.";
      header('Location: /movie');
      exit;
    }
    // Get gemini model and generate a review.
    $gemini = $this->model('Gemini');
    $review = $gemini->generate_review($movie_title, $rating);
    $this->view('movie/review', ['movie_title' => $movie_title, 'rating' => $rating, 'review' => $review]);
  }
  // Create ratings function where the user has to logged in to give a rating.
  public function ratings() {
    if(!isset($_SESSION['auth'])) {
      header('Location: /login');
      exit;
    }
    $user_id = $_SESSION['user_id'] ?? 0;
    $rating_model = $this->model('Rating');
    // Get the specific user's ratings and display.
    $ratings = $rating_model->getUserRatings($user_id);
    $this->view('movie/ratings', ['ratings' => $ratings]);
  }
  // Get all users' ratings and display.
  public function allRatings() {
    $rating_model = $this->model('Rating');
    $every_rating = $rating_model->getAllRatings();
    $this->view('movie/every_rating', ['ratings' => $every_rating]);
  }
}