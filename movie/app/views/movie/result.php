<?php require_once 'app/views/templates/headerMovie.php'?>
<?php if (isset($data['movie']) && is_array($data['movie'])): ?>
<h1 class="text-center"><?= htmlspecialchars($data['movie']['Title'])?> (<?= htmlspecialchars($data['movie']['Year']) ?>)</h1>
<div class="container">
<div class="row">
  <div class="col-md-3">
    <!--Display movie poster.-->
    <img src="<?= htmlspecialchars($data['movie']['Poster'])?>" alt="Movie Poster" class="img-fluid rounded shadow">
</div>
  <div class="col-md-7">
    <div class="card shadow">
      <div class="card-body">
        <!--Display the movie details using cards.-->
        <h3 class="text-center" class="card-title">Details of the Movie</h3>
        <div class="row">
          <div class="col-md-5">
    <p><strong>Year:</strong> <?= htmlspecialchars($data['movie']['Year'])?></p>
    <p><strong>Released:</strong> <?= htmlspecialchars($data['movie']['Released'])?></p>
    <p><strong>Director(s):</strong> <?= htmlspecialchars($data['movie']['Director'])?></p>
    <p><strong>Writer(s):</strong> <?= htmlspecialchars($data['movie']['Writer'])?></p>
    <p><strong>Actor(s):</strong> <?= htmlspecialchars($data['movie']['Actors'])?></p>
    <p><strong>Rated:</strong> <?= htmlspecialchars($data['movie']['Rated'])?></p>
          </div>
          <div class="col-md-5">
    <p><strong>Runtime:</strong> <?= htmlspecialchars($data['movie']['Runtime'])?></p
    <p><strong>Genre(s):</strong> <?= htmlspecialchars($data['movie']['Genre'])?></p>
    <p><strong>Countries:</strong> <?= htmlspecialchars($data['movie']['Country'])?></p>
    <p><strong>Language(s):</strong> <?= htmlspecialchars($data['movie']['Language'])?></p>
    <p><strong>Award(s):</strong> <?= htmlspecialchars($data['movie']['Awards'])?></p>
    <p><strong>Box Office Amount:</strong> <?= htmlspecialchars($data['movie']['BoxOffice']) ?></p>
          </div>
        </div>
    <p><strong>Plot Summary: </strong><?= htmlspecialchars($data['movie']['Plot'])?></p>
      </div>
    </div>
    <div class="card shadow">
      <div class="card-body">
        <!--Display online ratings.-->
    <h3 class="text-center" class="card-title">Online Ratings</h3>
    <?php if (isset($data['movie']['Ratings']) && is_array($data['movie']['Ratings'])): ?>
      <ul class="list-group list-group-flush">
        <?php foreach ($data['movie']['Ratings'] as $rating): ?>
          <li class="list-group-item d-flex align-items-center justify-content-between"><?= htmlspecialchars($rating['Source']) ?> <span class="badge bg-dark"><?= htmlspecialchars($rating['Value']) ?></span></li>
        <?php endforeach; ?>
      </ul>
  <?php endif; ?>
  </div>
</div>
  </div>
</div>
</div>
  <br>
  <!--Display user ratings.-->
<h3 class="text-center">User Ratings</h3>
<div class="container">
  <div class="row justify-content-center">
<?php if (!empty($data['user_ratings'])): ?>
  <ul class="list-group text-center">
    <?php foreach ($data['user_ratings'] as $rating): ?>
      <li class="list-group-item">
        <?= htmlspecialchars($rating['username'])?>: 
        <?= str_repeat('⭐', $rating['rating']) . str_repeat('☆', 5 - $rating['rating']) ?>
        (<?= $rating['rating'] ?>/5)
      </li>
    <?php endforeach; ?>
  </ul>
  <?php else: ?>
  <p class="text-center">No user ratings available.</p>
  <?php endif; ?>
  </div>
</div>
  <br>
  <div class="text-center">
    <!--Display average user rating.-->
  <p><strong>Average User Rating:</strong>
  <?php
    if(!empty($data['user_ratings'])) {
      $average = array_sum(array_column($data['user_ratings'], 'rating')) / count($data['user_ratings']);
      echo number_format($average, 1) . '/5';
    }
    else {
      echo 'N/A';
    }
    ?>
  </p>
  </div>
<?php if (isset($_SESSION['auth'])): ?>
      <!--Get the user to rate this movie using radio buttons.-->
<h2 class="text-center">Rate this movie</h2>
<form action="/movie/rate" method="POST">
  <input type="hidden" name="movie_name" value="<?= htmlspecialchars($data['movie']['Title'])?>">
  <div class="btn-group d-flex justify-content-center" aria-label="Movie Rating" role="group">    
  <?php
  $ratings = [1 => '⭐☆☆☆☆ (1/5)', 2 => '⭐⭐☆☆☆ (2/5)', 3 => '⭐⭐⭐☆☆ (3/5)', 4 => '⭐⭐⭐⭐☆ (4/5)', 5 => '⭐⭐⭐⭐⭐ (5/5)'];
  foreach ($ratings as $value => $label):
  ?>
    <input type="radio" name="rating" class="btn-check" id="rating<?= $value ?>" value="<?= $value ?>" required>
    <label class="btn btn-outline-dark" for="rating<?= $value ?>"><?= $label ?></label>
    <?php endforeach; ?>
  </div>
  <br>
  <div class="text-center">
  <button type="submit" class="btn btn-dark">Submit Rating</button>
  </div>
</form>
<?php else: ?>
  <p class="text-center"><a href="/login">Login</a> to rate movies.</p>
<?php endif; ?>
<br>
<h2 class="text-center">Get an AI-generated Review for this Movie</h2>
<form action="/movie/review" method="POST">
    <input name="movie_name" type="hidden" value="<?= htmlspecialchars($data['movie']['Title'])?>">
    <div class="form-group">
      <!--Use dropdown menu for choosing rating for ai-generated review.-->
      <label for="review-rating">Rating for Review:</label>
      <select class="form-select" name="rating" id="review-rating" required>
        <option value="">Select a rating</option>
        <option value="1">⭐☆☆☆☆ (1/5)</option>
        <option value="2">⭐⭐☆☆☆ (2/5)</option>
        <option value="3">⭐⭐⭐☆☆ (3/5)</option>
        <option value="4">⭐⭐⭐⭐☆ (4/5)</option>
        <option value="5">⭐⭐⭐⭐⭐ (5/5)</option>
      </select>
    </div>
    <br>
    <div class="text-center">
    <button type="submit" class="btn btn-dark">Get a Review</button>
    </div>
</form>
  <?php else: ?>
    <p>No data is available for this movie.</p>
  <?php endif; ?>
<?php require_once 'app/views/templates/footer.php'?>