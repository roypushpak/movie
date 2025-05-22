<?php require_once 'app/views/templates/headerMovie.php'?>
<h1 class="text-center">Your Ratings</h1>
<?php if (empty($data['ratings'])): ?>
  <p class="text-center">You have not rated any movies.</p>
<?php else: ?>
  <!--Create table for ratings.-->
<div class="table-responsive">
<table class="table">
  <thead>
    <tr>
      <th>Movie</th>
      <th>Rating</th>
      <th>Date Rated</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($data['ratings'] as $rating) { ?>
        <tr>
          <td><?= htmlspecialchars($rating['movie_name'])?></td>
          <td><?= str_repeat('⭐', $rating['rating'])?>(<?= $rating['rating']?>/5)</td>
          <td><?= date('M d, Y H:i', strtotime($rating['created_at']))?></td>
        </tr>
    <?php }; ?>
  </tbody>
</table>
</div>
  <?php endif; ?>

<?php require_once 'app/views/templates/footer.php'?>