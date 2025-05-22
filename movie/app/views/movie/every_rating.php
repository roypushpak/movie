<?php require_once 'app/views/templates/headerMovie.php'?>
<h2 class="text-center">Every Movie Rating by Username</h2>
<?php if (!empty($data['ratings'])): ?>
  <!--Create table for all ratings.-->
  <div class="table-responsive">
    <table class="table">
      <thead class="table">
        <tr>
          <th>Username</th>
          <th>Movie Name</th>
          <th>Rating</th>
          <th>Date Rated</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data['ratings'] as $rating): ?>
          <tr>
            <td><?= htmlspecialchars($rating['username'])?></td>
            <td><?= htmlspecialchars($rating['movie_name'])?></td>
            <td><?= str_repeat('⭐', $rating['rating'])?>(<?= $rating['rating']?>/5)</td>
            <td><?= date('M d, Y H:i', strtotime($rating['created_at']))?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php else: ?>
    <p class="text-center">No user ratings available!</p>
  <?php endif; ?>
<?php require_once 'app/views/templates/footer.php'?>