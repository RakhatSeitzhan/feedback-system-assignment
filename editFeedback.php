<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['id'])){
    include "db_conn.php";
    $feedback = $_POST['feedback'];
    $id = $_POST['id'];
    $query = "UPDATE feedbacks SET feedback='$feedback', edited=1 WHERE id='$id'";
    $conn->query($query);
    header("Location:index.php");
    exit();
} else {
    header('Location: index.php?error=Invalid feedback id!');
    exit();
}