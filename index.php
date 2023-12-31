<?php
require('dbconn.php');
require './vendor/phpmailer/phpmailer/src/Exception.php';
require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
require './vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>

<!DOCTYPE html>
<html>

<!-- Head -->

<head>

	<title>Library Management System</title>

	<!-- Meta-Tags -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="keywords" content="Library Member Login Form Widget Responsive, Login Form Web Template, Flat Pricing Tables, Flat Drop-Downs, Sign-Up Web Templates, Flat Web Templates, Login Sign-up Responsive Web Template, Smartphone Compatible Web Template, Free Web Designs for Nokia, Samsung, LG, Sony Ericsson, Motorola Web Design" />
	<script type="application/x-javascript">
		addEventListener("load", function() {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!-- //Meta-Tags -->

	<!-- Style -->
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all">

	<!-- Fonts -->
	<link href="//fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
	<!-- //Fonts -->

</head>
<!-- //Head -->

<!-- Body -->

<body>

	<h1>LIBRARY MANAGEMENT SYSTEM</h1>

	<div class="container">

		<div class="login">
			<h2>Sign In</h2>
			<form action="index.php" method="post">
				<input type="text" Name="RollNo" placeholder="ID number" required="">
				<input type="password" Name="Password" placeholder="Password" required="">
				<div class="send-button">
					<!--<form>-->
					<input type="submit" name="signin" value="Sign In">
			</form>
		</div>

		<div class="clear"></div>
	</div>

	<div class="register">
		<h2>Sign Up</h2>
		<form action="index.php" method="post">
			<input type="text" Name="Name" placeholder="Name" required>
			<input type="text" Name="Email" placeholder="Email" required>
			<input type="password" Name="Password" placeholder="Password" required>
			<input type="text" Name="PhoneNumber" placeholder="Phone Number" required>
			<input type="text" Name="RollNo" placeholder="ID Number" required="">

			<select name="Category" id="Category" style="background-color: dimgray; opacity:0.2;">
				<option value="Student">Student</option>
				<option value="Faculty">Faculty</option>
				<option value="Staff">Staff</option>

			</select>
			<select name="Department" id="Category" style="background-color: dimgray; opacity: 0.2;">
				<option value="Compstud">Compstud</option>
				<option value="Education">Education</option>
				<option value="Agriculture">Agriculture</option>
				<option value="Jr.HighSchool">Jr.HighSchool</option>
				<option value="Sr.HighSchool">Sr.HighSchool</option>

			</select>
			<br>


			<br>
			<div class="send-button">
				<input type="submit" name="signup" value="Sign Up">
		</form>
	</div>
	<p>By creating an account, you agree to our <a class="underline" href="">Terms and Conditions</a></p>
	<div class="clear"></div>
	</div>

	<div class="clear"></div>

	</div>

	<div class="footer w3layouts agileits">
		<p> &copy; 2023 | Library Management System </a></p>

	</div>
	<?php
	if (isset($_POST['signin'])) {
		$u = $_POST['RollNo'];
		$rawPassword = $_POST['Password']; // Password entered by the user

		// MD5 the entered password
		$md5Password = md5($rawPassword);

		$c = $_POST['Category'];

		$sql = "SELECT * FROM LMS.user WHERE RollNo='$u'";

		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$storedPassword = $row['Password'];
			$y = $row['Type'];
			$status = $row['Status'];

			// Compare the MD5 hashed entered password with the stored MD5 hash
			if ($md5Password == $storedPassword && !empty($u) && !empty($rawPassword)) {
				if ($status == 'Verified') {
					// Login Successful
					$_SESSION['RollNo'] = $u;

					if ($y == 'Admin') {
						echo header("Location:admin/index.php");
					} elseif ($y == 'librarian') {
						echo header("Location:librarian/index.php");
					} elseif ($y == 'Student') {
						echo header("Location:student/index.php");
					} else {
						echo header('Location:staff/index.php');
					}
				} else {
					echo "<script type='text/javascript'>
		alert('Failed to Login! Your account is not verified.')
	</script>";
				}
			} else {
				echo "<script type='text/javascript'>
		alert('Failed to Login! Incorrect IDNo or Password')
	</script>";
			}
		} else {
			echo "<script type='text/javascript'>
		alert('Failed to Login! User not found.')
	</script>";
		}
	}



	/*
	if (isset($_POST['signup'])) {
	$name = $_POST['Name'];
	$email = $_POST['Email'];
	$password = $_POST['Password'];
	$mobno = $_POST['PhoneNumber'];
	$rollno = $_POST['RollNo'];
	$category = $_POST['Category'];
	$department = $_POST['Department'];
	$type = 'Student';
	$status = 'Not Verified';

	$sql = "insert into LMS.user (Name,Type,Category,Department,RollNo,EmailId,MobNo,Password, Status) values ('$name','$type','$category','$department','$rollno','$email','$mobno','$password', '$status')";

	if ($conn->query($sql) === TRUE) {
	echo "<script type='text/javascript'>
		alert('Registration Successful')
	</script>";
	} else {
	//echo "Error: " . $sql . "<br>" . $conn->error;
	echo "<script type='text/javascript'>
		alert('User Exists')
	</script>";
	}
	} */



	if (isset($_POST['signup'])) {
		$name = $_POST['Name'];
		$email = $_POST['Email'];
		$password = $_POST['Password'];
		$mobno = $_POST['PhoneNumber'];
		$rollno = $_POST['RollNo'];
		$category = $_POST['Category'];
		$department = $_POST['Department'];
		$type = 'Student';
		$verificationCode = mt_rand(100000, 999999);
		$status = 'Not Verified';
		$md5Password = md5($password);
		$sql = "insert into LMS.user (Name,Type,Category,Department,RollNo,EmailId,MobNo,Password, Status, VerificationCode) values ('$name','$type','$category','$department','$rollno','$email','$mobno','$md5Password', '$status', '$verificationCode')";

		if ($conn->query($sql) === TRUE) {
			// Send verification email
			$mail = new PHPMailer(true);

			// Server settings
			$mail->isSMTP();
			$mail->Host = 'smtp.gmail.com';
			$mail->SMTPAuth = true;
			$mail->Username = 'ojt.rms.group.4@gmail.com';
			$mail->Password = 'hbpezpowjedwoctl';
			$mail->SMTPSecure = 'tls';
			$mail->Port = 587;

			// Sender information
			$mail->setFrom('ojt.rms.group.4@gmail.com', 'Library Management System');
			$mail->addAddress($email, $name);
			$mail->isHTML(true);
			$mail->Subject = 'Library Management System - Email Verification';
			$mail->Body = "Your verification code is: $verificationCode";
			try {
				$mail->send();
				echo "<script type='text/javascript'>
		alert('Registration Successful. Check your email for verification.');
		window.location.href = 'verification_modal.php?RollNo=" . urlencode($rollno) . "';
	</script>";
			} catch (Exception $e) {
				echo "<script type='text/javascript'>
		alert('Error sending verification email');
	</script>";
			}
		} else {
			echo "<script type='text/javascript'>
		alert('Error Inserting');
	</script>";
		}
	}


	?>



</body>
<!-- //Body -->

</html>
<?php
// }
// else {
//     echo "<script type='text/javascript'>alert('System Expired')</script>";
// } 


?>