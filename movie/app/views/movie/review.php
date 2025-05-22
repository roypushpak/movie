<?php require_once 'app/views/templates/headerMovie.php'?>
<!--Diisplay ai-generated review without ## or ** using a card.-->
<h1 class="text-center">Review for <?= htmlspecialchars($data['movie_title']) ?></h1>
<h2 class="text-center">Rating: <?= htmlspecialchars($data['rating']) ?>/5</h2>
<div class="card">
  <div class="card-body">
    <?php 
    $review_symbols = str_replace(['##', '**'], '', $data['review']);
    echo nl2br(htmlspecialchars($review_symbols))?>
</div>
</div>

<?php require_once 'app/views/templates/footer.php'?>