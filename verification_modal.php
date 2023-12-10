<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Document</title>
</head>

<body>
    <div class="modal" id="verificationModal" tabindex="-1" role="dialog" aria-labelledby="verificationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verificationModalLabel">Enter Verification Code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Please check your email for the verification code.</p>
                    <form action="verify.php" id="verificationForm" method="post">
                        <!-- Add a hidden input field to store RollNo -->
                        <input type="hidden" name="RollNo" value="<?php echo isset($_GET['RollNo']) ? htmlspecialchars($_GET['RollNo']) : ''; ?>">
                        <input type="text" name="verificationCode" class="form-control" placeholder="Verification Code" required>
                        <input type="submit" class="btn btn-primary mt-2" name="verify" value="Verify">
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Your jQuery code to show the modal -->
    <script>
        $(document).ready(function() {
            $('#verificationModal').modal('show');
        });
    </script>

</body>

</html>