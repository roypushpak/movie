<?php
// Is the user authenticated?
$isAuthenticated = isset($_SESSION['auth']);
// Which controller?
$currentController = isset($_SESSION['controller']) ? $_SESSION['controller'] : '';
// Set active class.
function setActive($page) {
  global $currentController;
  return ($currentController === $page) ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <link rel="stylesheet" href="/css/styles.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="icon" href="/favicon.png">
  <title>Project: <?= ucfirst($currentController)?></title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="mobile-web-app-capable" content="yes">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Project</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <!--Allow all users to access Movie Search, All User Ratings, Login and Signup.-->
          <li class="nav-item">
            <a class="nav-link <?= setActive('movie')?>" href="/movie">Movie Search</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/movie/allRatings">All User Ratings</a>
          </li>
          <!--Allow only logged in users to access home, your ratings, and logout.-->
          <?php if ($isAuthenticated): ?>
              <li class="nav-item">
                <a class="nav-link <?= setActive('home')?>" href="/home">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/movie/ratings">Your Ratings</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/logout">Logout</a>
              </li>
          <?php else: ?>
              <li class="nav-item">
                <a class="nav-link <?= setActive('login')?>" href="/login">Login</a>
               </li>
              <li class="nav-item">
                <a class="nav-link <?= setActive('create')?>" href="/create">Signup</a>
               </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
</nav>
<div class="container">
  <!--Added breadcrumbs.-->
  <?php 
  require_once 'app/views/components/breadcrumb.php';
  $itemsForBreadcrumb = [
    ['title' => 'Movie Search', 'link' => '/movie']
  ];
  if ($currentController !== 'movie') {
    $itemsForBreadcrumb[] = ['title' => ucfirst($currentController), 'link' => '/' . $currentController];
  }
  if (isset($_SESSION['method']) && $_SESSION['method'] !== 'index') {
    $itemsForBreadcrumb[] = ['title' => ucfirst($_SESSION['method']), 'link' => '#'];
  }
  breadCrumb($itemsForBreadcrumb);
?>
</div>
<main class="container">