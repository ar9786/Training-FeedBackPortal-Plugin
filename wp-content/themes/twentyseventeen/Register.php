<?php
/*
Template Name: Register
*/
require_once('common.php');
require_once(ABSPATH . WPINC . '/registration.php');
global $wpdb, $user_ID;
//Check whether the user is already logged in
if ($user_ID) {

	// They're already logged in, so we bounce them back to the homepage.

	header( 'Location:' . home_url() );

} else {

	$errors = array();

	if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
			
		// Check username is present and not already in use
		$username = $wpdb->escape($_REQUEST['username']);
		if ( strpos($username, ' ') !== false ) { 
		    $errors['username'] = "Sorry, no spaces allowed in usernames";
		}
		if(empty($username)) { 
			$errors['username'] = "Please enter a username";
		} elseif( username_exists( $username ) ) {
			$errors['username'] = "Username already exists, please try another";
		}

		// Check email address is present and valid
		$email = $wpdb->escape($_REQUEST['email']);
		if( !is_email( $email ) ) { 
			$errors['email'] = "Please enter a valid email";
		} elseif( email_exists( $email ) ) {
			$errors['email'] = "This email address is already in use";
		}

		// Check password is valid
		if(0 === preg_match("/.{6,}/", $_POST['password'])){
		  $errors['password'] = "Password must be at least six characters";
		}

		// Check password confirmation_matches
		if(0 !== strcmp($_POST['password'], $_POST['password_confirmation'])){
		  $errors['password_confirmation'] = "Passwords do not match";
		}

		// Check terms of service is agreed to
		if($_POST['terms'] != "Yes"){
			$errors['terms'] = "You must agree to Terms of Service";
		}

		if(0 === count($errors)) {

			$password = $_POST['password'];

			$new_user_id = wp_create_user( $username, $password, $email );
			
			update_user_meta( $new_user_id, 'user_department',$_REQUEST['user_department'] );
			
			// You could do all manner of other things here like send an email to the user, etc. I leave that to you.
			
			$emails = $email;
			$title = "New Registration";
			$url = site_url().'/wp-login.php';
			$message = "Click here to login : \n{$url}";
			wp_mail($emails, "New Post Published: {$title}", $message);
			

			$success = 1;

			header( 'Location:' . get_bloginfo('url') . '/wp-login.php/?success=1&u=' . $username );

		}

	}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<style>
body {
    padding-top: 90px;
}
.panel-login {
	border-color: #ccc;
	-webkit-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
	-moz-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
	box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
}
.panel-login>.panel-heading {
	color: #00415d;
	background-color: #fff;
	border-color: #fff;
	text-align:center;
}
.panel-login>.panel-heading a{
	text-decoration: none;
	color: #666;
	font-weight: bold;
	font-size: 15px;
	-webkit-transition: all 0.1s linear;
	-moz-transition: all 0.1s linear;
	transition: all 0.1s linear;
}
.panel-login>.panel-heading a.active{
	color: #029f5b;
	font-size: 18px;
}
.panel-login>.panel-heading hr{
	margin-top: 10px;
	margin-bottom: 0px;
	clear: both;
	border: 0;
	height: 1px;
	background-image: -webkit-linear-gradient(left,rgba(0, 0, 0, 0),rgba(0, 0, 0, 0.15),rgba(0, 0, 0, 0));
	background-image: -moz-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
	background-image: -ms-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
	background-image: -o-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
}
.panel-login input[type="text"],.panel-login input[type="email"],.panel-login input[type="password"] {
	height: 45px;
	border: 1px solid #ddd;
	font-size: 16px;
	-webkit-transition: all 0.1s linear;
	-moz-transition: all 0.1s linear;
	transition: all 0.1s linear;
}
.panel-login input:hover,
.panel-login input:focus {
	outline:none;
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
	border-color: #ccc;
}
.btn-login {
	background-color: #59B2E0;
	outline: none;
	color: #fff;
	font-size: 14px;
	height: auto;
	font-weight: normal;
	padding: 14px 0;
	text-transform: uppercase;
	border-color: #59B2E6;
}
.btn-login:hover,
.btn-login:focus {
	color: #fff;
	background-color: #53A3CD;
	border-color: #53A3CD;
}
.forgot-password {
	text-decoration: underline;
	color: #888;
}
.forgot-password:hover,
.forgot-password:focus {
	text-decoration: underline;
	color: #666;
}

.btn-register {
	background-color: #1CB94E;
	outline: none;
	color: #fff;
	font-size: 14px;
	height: auto;
	font-weight: normal;
	padding: 14px 0;
	text-transform: uppercase;
	border-color: #1CB94A;
}
.btn-register:hover,
.btn-register:focus {
	color: #fff;
	background-color: #1CA347;
	border-color: #1CA347;
}
</style>
</head>
<body>
<div class="container">
    	<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							
							<div class="col-xs-12">
								<a href="#" id="register-form-link">Register</a>
							</div>
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								
								<form id="register-form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" role="form" >
									<div class="form-group">
										<input type="text"  name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="" autocomplete="off">
										<span><?php if(isset($errors['username'])) echo $errors['username']; ?></span>
									</div>
									<div class="form-group">
										<input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="" autocomplete="off">
										<span><?php if(isset($errors['email'])) echo $errors['email']; ?></span>
									</div>
									<div class="form-group">
										<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
										<span><?php if(isset($errors['password'])) echo $errors['password']; ?></span>
									</div>
									<div class="form-group">
										<input type="password" name="password_confirmation" id="password_confirmation" tabindex="2" class="form-control" placeholder="Confirm Password">
										<span><?php if(isset($errors['password_confirmation'])) echo $errors['password_confirmation']; ?></span>
									</div>
									<div class="form-group">
										<select name="user_department" class="form-control">
									<?php $dept_fetch = deptFetch($wpdb);
									foreach($dept_fetch as $val){ ?>
									<option value="<?php echo $val->id; ?>"><?php echo $val->dept_name; ?></option>
									<?php } ?>
										</select>
									</div>
								<input name="terms" id="terms" type="checkbox" value="Yes">
								<label for="terms">I agree to the Terms of Service</label>
								<span><?php if(isset($errors['terms'])) echo $errors['terms']; ?></span>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Register Now">
												<a href="http://localhost/HrFeedBackPortal/wp-login.php">Login</a>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
</div>
</body>
</html>