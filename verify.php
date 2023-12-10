<?php
require('dbconn.php');

if (isset($_POST['verify'])) {
    $enteredCode = $_POST['verificationCode'];
    $rollNo = isset($_POST['RollNo']) ? $_POST['RollNo'] : '';

    if (!empty($rollNo)) {
        // Fetch user data from the database
        $sql = "SELECT VerificationCode FROM LMS.user WHERE RollNo='$rollNo'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $storedCode = $row['VerificationCode'];

            if ($enteredCode == $storedCode) {
                $md5VerificationCode = md5($storedCode);
                // Verification successful, update the status to 'Verified'
                $updateSql = "UPDATE LMS.user SET Status='Verified', VerificationCode='$md5VerificationCode' WHERE RollNo='$rollNo'";

                $conn->query($updateSql);

                echo "<script type='text/javascript'>alert('Verification successful. Your account is now verified.'); window.location.href = 'index.php'</script>";
            } else {
                echo "<script type='text/javascript'>alert('Verification code is incorrect.'); window.location.href = 'verification_modal.php'</script>";
            }
        } else {
            echo "<script type='text/javascript'>alert('User not found.'); window.location.href = 'index.php'</script>";
        }
    } else {
        echo "<script type='text/javascript'>alert('RollNo not provided.'); window.location.href = 'index.php'</script>";
    }
}
