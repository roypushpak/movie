<?php require_once 'app/views/templates/headerMovie.php'?>
<main role="main" class="container">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="display-5 text-center">You are not logged in!</h2>
							<h1 class="text-center">Login Page</h1>
            </div>
        </div>
    </div>
	
	<div style="display: flex; align-items: center; justify-content: center;"> 
	<?php
	if (isset($_SESSION['failedAuth'])) {
		echo "<div class='alert alert-danger d-inline-block text-center '>Unsuccessful attempt number " . $_SESSION['failedAuth'] . ".</div>";
		echo "<div class='alert alert-danger d-inline-block text-center '>Incorrect username or password. Try again." . "</div>";
	}
	if (isset($_SESSION['created_account'])) {
		echo "<div class='alert alert-success d-inline-block text-center text-align-center'>" . $_SESSION['created_account'] . "</div>";
		unset($_SESSION['created_account']);
	}
		if (isset($_SESSION['locked_text'])) {
			echo "<div class='alert alert-danger d-inline-block text-center'>" . $_SESSION['locked_text'] . "</div>";
			unset($_SESSION['locked_text']);
		}
	?>
			</div>
<div class="row justify-content-center">
    <div class="col-sm-auto">
		<form action="/login/verify" method="post" >
		<fieldset>
			<div class="form-group">
				<br>
				<label for="username">Username:</label>
				<input required type="text" class="form-control" name="username" placeholder="username">
			</div>
			<div class="form-group">
				<br>
				<label for="password">Password:</label>
				<input required type="password" class="form-control" name="password" placeholder="password">
			</div>
            <br>
			<div class="text-center">
		    <button type="submit" class="btn btn-dark btn-sm">Login</button>
			</div>
						<br>
		</fieldset>
		</form> 
	</div>
</div>
    <?php require_once 'app/views/templates/footer.php' ?>
