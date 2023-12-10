<?php
require('dbconn.php');
?>
<?php





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
	<div id="verificationModal" style="display:none;">
		<h2>Enter Verification Code</h2>
		<p>Please check your email for the verification code.</p>
		<form id="verificationForm">
			<input type="text" name="verificationCode" placeholder="Verification Code" required>
			<input type="submit" value="Verify">
		</form>
	</div>
	<?php
	if (isset($_POST['signin'])) {
		$u = $_POST['RollNo'];
		$p = $_POST['Password'];
		$c = $_POST['Category'];

		$sql = "select * from LMS.user where RollNo='$u'";

		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$x = $row['Password'];
		$y = $row['Type'];
		if (strcasecmp($x, $p) == 0 && !empty($u) && !empty($p)) { //echo "Login Successful";
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
			//   if($y=='Admin')
			//   echo header("Location:admin/index.php");
			// elseif ($y == 'librarian') {
			// echo header("Location:librarian/index.php");

			// }if ($y =='student') {
			// 	echo header("Location:student/index.php");
			// }
			//   elseif (condition) {
			//   	 echo	header("Location:staff/index.php");
			//   }


		} else {
			echo "<script type='text/javascript'>alert('Failed to Login! Incorrect IDNo or Password')</script>";
		}
	}

	require('./vendor/phpmailer/phpmailer/src/SMTP.php');
	require('./vendor/phpmailer/phpmailer/src/PHPMailer.php');

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	if (isset($_POST['signup'])) {
		$name = $_POST['Name'];
		$email = $_POST['Email'];
		$password = $_POST['Password'];
		$mobno = $_POST['PhoneNumber'];
		$rollno = $_POST['RollNo'];
		$category = $_POST['Category'];
		$department = $_POST['Department'];
		$type = 'Student';

		// Generate a verification code
		$verificationCode = mt_rand(100000, 999999);

		// Insert user data into the database
		$sql = "INSERT INTO LMS.user (Name, Type, Category, Department, RollNo, EmailId, MobNo, Password, Status, VerificationCode) 
            VALUES ('$name', '$type', '$category', '$department', '$rollno', '$email', '$mobno', '$password', 'Not Verified', '$verificationCode')";

		if ($conn->query($sql) === TRUE) {
			// Send email with verification code
			$mail = new PHPMailer(true);
			try {
				$mail->isSMTP();
				$mail->Host = 'smtp.gmail.com';
				$mail->SMTPAuth = true;
				$mail->Username = 'ojt.rms.group.4@gmail.com';
				$mail->Password = 'hbpezpowjedwoctl';
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
				$mail->Port = 587;

				$mail->setFrom('ojt.rms.group.4@gmail.com', 'Library Management System');
				$mail->addAddress($email, $name);

				$mail->isHTML(true);
				$mail->Subject = 'Email Verification';
				$mail->Body    = 'Your verification code is: ' . $verificationCode;

				// Check if the email was sent successfully
				if ($mail->send()) {
					// Show the verification modal
					echo "<script>
        document.getElementById('verificationModal').style.display = 'block';

        document.getElementById('verificationForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var verificationCode = document.getElementsByName('verificationCode')[0].value;
            if (verificationCode === '$verificationCode') {
                alert('Verification successful! You can now log in.');
                window.location.href = 'index.php';
            } else {
                alert('Verification failed. Please try again.');
            }
        });
    </script>";
				} else {
					echo "<script type='text/javascript'>alert('Failed to send verification email. Please try again.')</script>";
				}
			} catch (Exception $e) {
				echo "Mailer Error: " . $mail->ErrorInfo;
			}
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