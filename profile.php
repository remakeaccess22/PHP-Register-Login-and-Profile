<?php
require_once('database/dbconnection.php');
require_once('php_operation/session_check.php');

$employee_id = $_SESSION['userid']; 

$sql = "SELECT employees.*, jobs.job_title, departments.department_name
        FROM employees 
        INNER JOIN jobs ON employees.job_id = jobs.job_id 
        INNER JOIN departments ON employees.department_id = departments.department_id
        WHERE employees.employee_id = $employee_id";

$query = $conn->query($sql);

if ($query->num_rows > 0) {
    $row = $query->fetch_assoc();
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $email = $row['email'];
    $phone_number = $row['phone_number'];
    $hire_date = $row['hire_date'];
    $salary = $row['salary'];
    $manager_id = $row['manager_id'];
    $job_title = $row['job_title'];
    $department_name = $row['department_name'];
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>G59 Profile Section</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="sweetalert/sweetalert2.min.css">
    <link rel="stylesheet" href="datatables/datatables.min.css">
    
</head>
<body style ="background-color: #F5F5F7;">
    <div class="container p-3 mt-2">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="bg-white rounded-3 p-3 mb-4 d-flex justify-content-between">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">User</a></li>
                        <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                    </ol>
                    <div>
                        <a href="#" id = "btnLogout">Logout</a>
                    </div>
                </nav>
            </div>
        </div>
        <main>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4 border-0 rounded-3">
                        <div class="card-body text-center">
                            <img id="avatar" src="./images/BlankProfile.webp" alt="avatar" class="rounded-circle img-fluid" style="width: 110px; height: 110px;">                            <h5 class="my-3"><?php echo $first_name . ' ' . $last_name?></h5>
                            <p class="text-muted mb-1"><?php echo $job_title?></p>
                            <p class="text-muted mb-4">San Miguel Corporation</p>
                            <div class="d-flex justify-content-center mb-2">
                                <button type="button" class="btn btn-primary btn-upload" data-mdb-ripple-color="light">
                                    <i class="fas fa-upload me-2"></i>Upload Profile Image
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-4 px-2 border-0 rounded-3">
                        <div class="card-body">
                            <div class="px-3 container">
                                <div class="row">
                                    <h2 class="my-3 fw-bold">User Profile</h2>
                                    <div class="col-12 mt-3">
                                        <div class="row">
                                            <h5 class="mb-2 col-4">Email:</h5>
                                            <p class="text-muted fw-light col-8"><?php echo $email; ?></p>
                                        </div>
                                        <div class="row">
                                            <h5 class="mb-2 col-4">Phone Number:</h5>
                                            <p class="text-muted fw-light col-8"><?php echo $phone_number; ?></p>
                                        </div>
                                        <div class="row">
                                            <h5 class="mb-2 col-4">Hire Date:</h5> 
                                            <p class="text-muted fw-light col-8"><?php echo $hire_date; ?></p>
                                        </div>
                                        <div class="row">
                                            <h5 class="mb-2 col-4">Salary:</h5>
                                            <p class="text-muted fw-light col-8"><?php echo $salary; ?></p>
                                        </div>
                                        <div class="row">
                                            <h5 class="mb-2 col-4">Department:</h5>
                                            <p class="text-muted fw-light col-8"><?php echo $department_name . ' ' . 'Department'; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card mb-4 px-2 border-0 rounded-3">
                        <div class="card-body">
                            <div class="px-3 container">
                                <div class="row">
                                    <h3 class="my-3 fw-bold">About Myself</h3>
                                    <div class="col-12">
                                        <div class="row">
                                            <p class="text-muted fw-light col-8">I am <?php echo $first_name . ' ' . $last_name?>, passionate to my work encapsulates a profound dedication and enthusiasm for the tasks, projects, or endeavors that you engage in professionally. </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <div class="container-fluid bg-white rounded-2">
            <footer class="text-center text-muted py-2">
                <p class = "my-3 text-muted small">© 2024 G59. Alayacyac, Jude Rafael S. | Alido, Aubrey Joy S. | Razonable, Juliana Gwyneth A.</p>
            </footer>
        </div>
    </div>
</body>
</html>

<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="sweetalert/sweetalert2.all.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="datatables/datatables.min.js"></script>
<script>

$(document).on('click', '.btn-upload', function() {
    UploadImage();
});

$(document).on('click', '#btnLogout', function() {
    confirmLogout();
});

function UploadImage() {
    Swal.fire({
        title: 'Upload Image',
        input: 'file',
        inputAttributes: {
            'accept': 'image/*',
            'aria-label': 'Upload your profile picture'
        }
    }).then((file) => {
        if (file.value) {
            const reader = new FileReader()
            reader.onload = (e) => {
                Swal.fire({
                    title: 'Your uploaded picture',
                    imageUrl: e.target.result,
                    imageAlt: 'The uploaded picture'
                })
                document.getElementById('avatar').src = e.target.result;
            }
            reader.readAsDataURL(file.value)
        }
    })
}

function confirmLogout() {
    Swal.fire({
        title: 'Are you sure you want to logout?',
        text: "You will be redirected to the login page.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#6c757d',
        reverseButtons: true,
        confirmButtonText: 'Yes, logout',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = 'php_operation/logout.php';
        }
    })
}

</script>