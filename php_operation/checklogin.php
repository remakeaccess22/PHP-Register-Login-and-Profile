<?php 
session_start();
require_once('../database/dbconnection.php');
$response = array();
$status = "";
$error = "";

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM employees WHERE email='$email' AND password='$password' ";
$query = $conn->query($sql);
$exist = $query->num_rows;

if($exist>0){
    $status = "success";
    $error = "";
        while($row = $query->fetch_assoc()){
            $employee_id = $row['employee_id'];
            $_SESSION['userid'] = $employee_id;
        }
   
}else{
    $status = "error";
    $error = "Invalid Account!";
}
 
$response[] = array(
    'status'=>$status,
    'error'=>$error
);

echo json_encode($response);

?>