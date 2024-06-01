<?php
session_start();
require_once('database/dbconnection.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>G59 San Miguel Corporation</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="sweetalert/sweetalert2.min.css">
    <link rel="stylesheet" href="datatables/datatables.min.css">

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-5 offset-sm-3">
                <div class="card mt-3">
                    <div class="card-header">
                        <h1>Sign In</h1>
                    </div>

                    <div class="card-body">
                        <label for="txtEmail" class="form-label">Enter email</label>
                        <input type="email" class="form-control" id="txtEmail">
                        <label for="txtPassword" class="form-label">Enter password</label>
                        <input type="password" class="form-control" id="txtPassword">
                        <br>
                        <div class="d-grid">
                            <button type="button" class="btn btn-primary btn-lg" id="btnLogin">LOGIN</button>
                        </div>
                    </div>
                    <div class="text-center">
                    <p>Don't have an account? <a href="registration.php">Register here</a></p>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="sweetalert/sweetalert2.all.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="datatables/datatables.min.js"></script>
    <script>
    $(document).on('click', '#btnLogin', function() {
        var email = $('#txtEmail').val();
        var password = $('#txtPassword').val();

        if (email == "") {
            showAlert('error', 'Empty Fields!', 'Please enter your email!');
            return;
        }
        if (password == "") {
            showAlert('error', 'Empty Fields!', 'Please enter your password!');
            return;
        }

        var values = {
            'email': email,
            'password': password,
        }

        login(values);

    });

    function login(values) {
        $.ajax({
            type: 'POST',
            url: 'php_operation/checklogin.php',
            data: values,
            dataType: 'JSON',
            success: function(response) {
                var status = response[0].status;
                var error = response[0].error;
                if (status == "success") { 
                    showAlert('success', 'Success', 'Login Successful!');

                }
                if (status == "error") showAlert('error', 'Error', error);

            }
        });

    }

    function showAlert(icon, title, content) {
        Swal.fire({
            icon: icon,
            title: title,
            text: content,
            confirmButtonText: 'CONTINUE',
            allowEscapeKey: false,
            allowOutsideClick: false,
        }).then((result) => {

            if (result.isConfirmed) {
                if (icon == 'success') window.location = 'profile.php'; //reload the page


            }
        });


    }
    </script>
</body>

</html>