<!doctype html>
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'C:\wamp64\www\game\vendor\autoload.php';

$verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "gamestore";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} else {

if (isset($_REQUEST['register'])) {
	$fname = $_REQUEST['first_name'];
	$lname = $_REQUEST['last_name'];
	$email = $_REQUEST['email'];
	$pass = $_REQUEST['password'];
	$cpass = $_REQUEST['confirm_password'];
	$age=$_REQUEST['Age'];

	// Create connection

	// Check connection
		if ($pass === $cpass) {
			$emailquery = "SELECT * FROM persons WHERE email='$email'";
			$emailsql = mysqli_query($conn, $emailquery);
			$emailcount = mysqli_num_rows($emailsql);
			if($emailcount>0){
				echo "<script type='text/javascript'>alert('email or username already exist');</script>";
			} else {
				$query = "INSERT INTO persons(FirstName, LastName, Email, Password,age,verification_code) VALUES('$fname','$lname','$email','$pass','$age','$verification_code')";
				$sql = mysqli_query($conn, $query);


				$mail = new PHPMailer(true);

				try {
					$conn = mysqli_connect("localhost", "root","root","gamestore");
					if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
					} else {
					//Enable verbose debug output
					$mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;
		
					//Send using SMTP
					$mail->isSMTP();
		
					//Set the SMTP server to send through
					$mail->Host = 'smtp.gmail.com';
		
					//Enable SMTP authentication
					$mail->SMTPAuth = true;
		
					//SMTP username
					$mail->Username = 'dev.260802@gmail.com';
		
					//SMTP password
					$mail->Password = 'kyifetrgwchmzwnm';
		
					//Enable TLS encryption;
					$mail->SMTPSecure = 'tls';
		
					//TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
					$mail->Port = 587;
		
					//Recipients
					$mail->setFrom('dev.260802@gmail.com', 'your_website_name');
		
					//Add a recipient
					$mail->addAddress($email, $fname);
		
					//Set email format to HTML
					$mail->isHTML(true);
		
		            $vr=substr(number_format(time() * rand(), 0, '', ''), 0, 6);
					$mail->Subject = 'Email verification';
					$mail->Body    = '<p>Your verification code is: <b style="font-size: 30px;">' . $verification_code . '</b></p>';
		
					$mail->send();
                    
				}
					} catch (Exception $e) {
				echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
				}   

				if ($sql) {
					// echo "<script type='text/javascript'>alert('You are now registered');</script>";
					header("Location: http://localhost/game/email/email-verification.php");
					// header("Location: http://localhost/game/login_1.php");
				} else {
					die("Error" . $conn->error);
				}
				$conn->close();
			}
		} 
		else {
			echo "<script type='text/javascript'>alert('Incorrect data');</script>";
		}

	}
}
?>
<html>
<head>
		<title> REGISTER </title>
		<link rel="stylesheet" href="css/style_regi.css">
	

	</head>
	<body>
	
	<div class="loginBox">
		
		<h2></h2>
		<form>
			<div class="signup-form">
    <form  method="post" action="index_regi.php">
		<h2>Register to GAMESTORE</h2>
		<p class="hint-text">Create your account</p>
        <div class="form-group">
			<div class="row">
				<div class="col-xs-6"><input type="text" class="form-control" name="first_name" placeholder="First Name" required></div>
				<div class="col-xs-6"><input type="text" class="form-control" name="last_name" placeholder="Last Name" required></div>
				<!-- <div class="col-xs-6"><input type="number" class="form-control" name="Age" placeholder="Age" required></div> -->
				<div class="col-xs-6"><input type="text" class="form-control" name="Age" placeholder="Age" required></div>
			</div>        	
        </div>

        <div class="form-group">

<div class="col-xs-6"><input type="text" class="form-control" name="email" placeholder="email" required="required"></div>
		<div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password" required="required">
        </div>
		<div class="form-group">
            <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required="required">
        </div>        
        <div class="form-group">
<br>
			<label class="checkbox-inline"><input type="checkbox" required="required"> I hereby accept <a href="#">Terms of Use</a> &amp; <a href="#">Privacy Policy</a></label>
		</div>
		<div class="form-group">
            <button type="submit" class="btn btn-success btn-lg btn-block" name="register">Register Now</button>
        </div>
    </form>
	<div class="text-center">Already have an account? <a href="login_1.html">Sign in</a></div>
</div>
			
			
	
	</body>
</html>