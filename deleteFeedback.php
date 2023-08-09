<?php 
if (isset($_POST['id'])){
    include "db_conn.php";
    $id = $_POST['id'];
    $query = "DELETE FROM feedbacks WHERE id='$id'";
    mysqli_query($conn, $query);
    header("Location:index.php");
    exit();
} else {
    header('Location: index.php?error=Invalid feedback id!');
    exit();
}