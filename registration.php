<?php
session_start();
require_once('database/dbconnection.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>G59 Registration Page</title>
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
                        <h1>Register Form</h1>
                    </div>

                    <div class="card-body">
                    <label for="txtFname">Enter firstname:</label>
                    <input type="text" id="txtFname" class="form-control">

                    <label for="txtLname">Enter lastname:</label>
                    <input type="text" id="txtLname" class="form-control">

                    <label for="txtEmail">Enter email:</label>
                    <input type="email" id="txtEmail" class="form-control">

                    <label for="txtPass">Enter password:</label>
                    <input type="password" id="txtPass" class="form-control">

                    <label for="txtPhone">Enter phone number:</label>
                    <input type="phone" id="txtPhone" class="form-control">

                    <label for="txtHireDate">Enter hire date:</label>
                    <input type="date" id="txtHireDate" class="form-control">

                    <label for="selJob">Select job title:</label>
                    <select class="form-select" id="selJob">
                        <option value=""></option>
                        <?php 
          $sql = "SELECT * FROM jobs";
          $query = $conn->query($sql);
          while($row = $query->fetch_assoc()){
            $job_id = $row['job_id'];
            $job_title = $row['job_title'];
            $min_salary = $row['min_salary'];
            $max_salary = $row['max_salary'];
          ?>
                        <option value="<?php echo $job_id; ?>"><?php echo $job_title; ?></option>
                        <?php
          }
          ?>
                    </select>
                    <label for="txtSalary">Enter salary:</label>
                    <input type="number" id="txtSalary" class="form-control">
                    <label for="txtCommission">Enter commission:</label>
                    <input type="number" id="txtCommission" class="form-control">

                    <label for="selManager">Select manager:</label>
                    <select class="form-select" id="selManager">
                        <option value=""></option>
                        <?php 
          $sql = "SELECT employee_id,first_name, last_name FROM employees";
          $query = $conn->query($sql);
          while($row = $query->fetch_assoc()){
            $employee_id = $row['employee_id'];
            $name = $row['first_name'] . " " . $row['last_name'];
          ?>
                        <option value="<?php echo $employee_id; ?>"><?php echo $name; ?></option>
                        <?php
          }
          ?>
                    </select>

                    <label for="selDepartment">Select department:</label>
                    <select class="form-select" id="selDepartment">
                        <option value=""></option>
                        <?php 
          $sql = "SELECT * FROM departments";
          $query = $conn->query($sql);
          while($row = $query->fetch_assoc()){
            $department_id = $row['department_id'];
            $department_name = $row['department_name'];
          ?>
                        <option value="<?php echo $department_id; ?>"><?php echo $department_name; ?></option>
                        <?php
          }
          ?>
                    </select>
                        <br>
                        <div class="d-grid">
                            <button type="button" class="btn btn-primary btn-lg" id="btnRegister">REGISTER</button>
        
                        </div>



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
    function register(values) {
        $.ajax({
            type: 'POST',
            url: 'php_operation/checkregister.php',
            data: values,
            dataType: 'JSON',
            success: function(response) {
                var status = response.status;
                var error = response.error;
                if (status === 'success') showAlert('success', 'Success', 'Registration Successful!');
                else showAlert('error', 'Error', error);
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
                if (icon == 'success') window.location = 'login.php';
            }
        });
    }

    $(document).ready(function() {
        $(document).on('click', '#btnRegister', function() {
            var fname = $('#txtFname').val();
            var lname = $('#txtLname').val();
            var email = $('#txtEmail').val();
            var pass = $('#txtPass').val();
            var phone = $('#txtPhone').val();
            var hire_date = $('#txtHireDate').val();
            var job_id = $('#selJob').val();
            var salary = $('#txtSalary').val();
            var commission = $('#txtCommission').val();
            var manager_id = $('#selManager').val();
            var department_id = $('#selDepartment').val();

            if (fname == "") {
                showAlert('error', 'Empty Fields', 'Please enter firstname!');
                return;
            }
            if (lname == "") {
                showAlert('error', 'Empty Fields', 'Please enter lastname! ');
                return;
            }
            if (email == "") {
                showAlert('error', 'Empty Fields', 'Please enter email! ');
                return;
            }
            if (email == "") {
                showAlert('error', 'Empty Fields', 'Please enter email! ');
                return;
            }
            if (pass == "") {
                showAlert('error', 'Empty Fields', 'Please enter your password! ');
                return;
            }
            if (phone == "") {
                showAlert('error', 'Empty Fields', 'Please enter phone number! ');
                return;
            }
            if (hire_date == "") {
                showAlert('error', 'Empty Fields', 'Please select the hire date! ');
                return;
            }
            if (job_id == "") {
                showAlert('error', 'Empty Fields', 'Please select job title! ');
                return;
            }
            if (salary == "") {
                showAlert('error', 'Empty Fields', 'Please enter salary! ');
                return;
            }
            if (commission == "") {
                showAlert('error', 'Empty Fields', 'Please enter commission! ');
                return;
            }
            if (manager_id == "") {
                showAlert('error', 'Empty Fields', 'Please select your manager! ');
                return;
            }
            if (department_id == "") {
                showAlert('error', 'Empty Fields', 'Please select your department! ');
                return;
            }

            // Set values as object
            var values = {
                "fname": fname,
                "lname": lname,
                "email": email,
                "pass": pass,
                "phone": phone,
                "hire_date": hire_date,
                "job_id": job_id,
                "salary": salary,
                "commission": commission,
                "manager_id": manager_id,
                "department_id": department_id
            };

            register(values);
        });
    });
</script>


</body>

</html>
