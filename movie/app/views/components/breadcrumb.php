<?php
function breadCrumb($item1) {
  echo '<div class="container">';
  echo '<div class="row justify-content-center">';
  echo '<div class="col-auto">';
  echo '<nav aria-label="breadcrumb">';
  echo '<ol class="breadcrumb">';
  $finalIndex = count($item1) - 1;
  foreach ($item1 as $index1 => $item2) {
    if ($finalIndex === $index1) {
      echo '<li class="breadcrumb-item active" aria-current="page">' . htmlspecialchars($item2['title']) . '</li>';
    }
    else {
      echo '<li class="breadcrumb-item"><a href="' . htmlspecialchars($item2['link']) . '">' . htmlspecialchars($item2['title']) . '</a></li>';
    }
  }
  echo '</ol>';
  echo '</nav>';
  echo '</div>';
  echo '</div>';
  echo '</div>';
}
?>