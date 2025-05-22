<?php require_once 'app/views/templates/headerMovie.php'?>
<!--Display success or failure of ratings.-->
<?php if (isset($_SESSION['success'])): ?>
  <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
  <?php unset($_SESSION['success']); ?>
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
  <?php unset($_SESSION['error']); ?>
<?php endif; ?>
<h1 class="text-center">Search for a Movie</h1>
<?php if (isset($data['error'])): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($data['error'])?></div>
<?php endif; ?>
<form action="/movie/search" method="POST">
  <!--Movie Search view-->
  <div class="form-group">
    <input name="movie" class="form-control" type="text" placeholder="Movie Name" required>
  </div>
  <br>
  <div class="text-center">
    <button type="submit" class="btn btn-dark">Search</button>
  </div>
</form>
<?php require_once 'app/views/templates/footer.php'?>