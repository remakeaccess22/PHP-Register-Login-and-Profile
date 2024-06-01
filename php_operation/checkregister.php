<?php
session_start();
require_once('../database/dbconnection.php');

$response = array();
$status = "";
$error = "";

$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$pass = mysqli_real_escape_string($conn, $_POST['pass']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$hire_date = mysqli_real_escape_string($conn, $_POST['hire_date']);
$job_id = mysqli_real_escape_string($conn, $_POST['job_id']);
$salary = mysqli_real_escape_string($conn, $_POST['salary']);
$commission = mysqli_real_escape_string($conn, $_POST['commission']);
$manager_id = mysqli_real_escape_string($conn, $_POST['manager_id']);
$department_id = mysqli_real_escape_string($conn, $_POST['department_id']);

if (empty($fname) || empty($lname) || empty($email) || empty($pass) || empty($phone) || empty($hire_date) || empty($job_id) || empty($salary) || empty($commission) || empty($manager_id) || empty($department_id)) {
    $status = "error";
    $error = "Empty Fields";
} else {
    $check_query = "SELECT * FROM employees WHERE email = '$email' AND first_name = '$fname' AND last_name = '$lname'";
    $check_result = $conn->query($check_query);
    if ($check_result->num_rows > 0) {
        $status = "error";
        $error = "Account already First Name, Last Name and Email exists! Please try again!";
    } else {
        $sql = "INSERT INTO employees (
            first_name,
            last_name,
            email,
            password,
            phone_number,
            hire_date,
            job_id,
            salary,
            commission_pct,
            manager_id,
            department_id
        ) 
        VALUES (
            '$fname',
            '$lname',
            '$email',
            '$pass',
            '$phone',
            '$hire_date',
            '$job_id',
            '$salary',
            '$commission',
            '$manager_id',
            '$department_id'
        )";
        $query = $conn->query($sql);
        if ($query) {
            $status = "success";
        } else {
            $status = "error";
            $error = "Can't add data! Please try again!";
        }
    }
}

$response["status"] = $status;
$response["error"] = $error;

echo json_encode($response);
?>
