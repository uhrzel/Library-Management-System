<?php
require('dbconn.php');
if (isset($_POST['verify'])) {
    $enteredVerificationCode = $_POST['verificationCode'];
    $userRollNo = $_SESSION['RollNo']; // Assuming $u is the RollNo

    $verificationQuery = "SELECT * FROM `user` WHERE `RollNo` = '$userRollNo' AND BINARY `VerificationCode` = '$enteredVerificationCode'";
    $verificationResult = $conn->query($verificationQuery);

    if ($verificationResult && $verificationResult->num_rows > 0) {
        // Update the user's status to "Verified" and clear the verification code
        $updateStatusQuery = "UPDATE `user` SET `Status` = 'Verified', `VerificationCode` = '' WHERE `RollNo` = '$userRollNo'";
        $conn->query($updateStatusQuery);

        // Redirect to a success page or perform other actions
        echo "<script type='text/javascript'>alert('Verification Successful!');window.location.href = 'index.php';</script>";
    } else {
        echo "<script type='text/javascript'>alert('Invalid verification code for user RollNo: $userRollNo. Please try again.');window.location.href = 'verification_modal.php';</script>";
    }
}
