<?php
class Rating {
  // Save rating function.
  public function saveRating($userId, $movieName, $rating) {
    $db = db_connect();
    try {
      // Check to see if a rating already exixts in the database.
      $checkStatement = $db->prepare("select id from ratings where user_id = :userId and movie_name = 
 :movieName");
      $checkStatement->execute([':userId' => $userId, ':movieName' => $movieName]);
      $existingRating = $checkStatement->fetch(PDO::FETCH_ASSOC);
      // Update the existing user rating.
      if ($existingRating) {
       $statement = $db->prepare("update ratings set rating = :rating where id = :id");
       $statement->execute([':rating' => $rating, ':id' => $existingRating['id']]);
      }
      else {
        // Insert a new user rating.
    $statement = $db->prepare("insert into ratings (user_id, movie_name, rating) values (:userId, :movieName, :rating)");
    return $statement->execute([':userId' => $userId, ':movieName' => $movieName, ':rating' => $rating]);
  }
  return true;
}
catch(PDOException $exception) {
  // Display error.
  echo "Error in saving the rating: " . $exception->getMessage();
  return false;
  }
}
  // getUserRatings function.
  public function getUserRatings($userId) {
    $db = db_connect();
    // Select movie name, rating and created at and display to user.
    $statement = $db->prepare("select movie_name, rating, created_at from ratings where user_id = :userId order by created_at desc");
    $statement->execute([':userId' => $userId]);
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
  }
  // Get movie ratings function to display on specific movies.
  public function getMovieRatings($movieName) {
    $db = db_connect();
    // Display only the username and rating.
    $statement = $db->prepare("select ratings.rating, users.username from ratings join users on ratings.user_id = users.id where movie_name = :movieName order by ratings.created_at desc");
    $statement->execute([':movieName' => $movieName]);
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
  }
  // Create getallratings function.
  public function getAllRatings() {
    // Connect to database
    $db = db_connect();
    // Select id, username, movie name, created at time and execute then fetch and return.
    $statement = $db->prepare("select ratings.id, users.username, ratings.movie_name, ratings.rating, ratings.created_at from ratings join users on ratings.user_id = users.id order by ratings.created_at desc");
    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
  }
}