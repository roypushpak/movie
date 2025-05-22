<?php require_once 'app/views/templates/headerMovie.php' ?>
<div class="container">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="display-5 text-center">Home</h2>
                <h1> Welcome, <?=$_SESSION['username'] ?></h1>
                <p class="lead"> <?= date("F jS, Y"); ?></p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 text-center">
            <p> <a href="/logout">Click here to logout</a></p>
        </div>
    </div>

    <?php require_once 'app/views/templates/footer.php' ?>
