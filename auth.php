<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['username']) && isset($_POST['password'])){
    session_start();
    include "db_conn.php";
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);

    if (empty($username) || empty($password)) {
        header('Location: login.php?error=Both username and password are required!');
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $queryResult = mysqli_query($conn, $sql);
        if (mysqli_num_rows($queryResult) === 1){
            $row = mysqli_fetch_assoc($queryResult);
            if ($row['password'] == $password){
                // No tokens and hashing are used
                // This method is not secure for production 
                // For only assignment purposes I will leave it as it is
                $_SESSION['username'] = $row['username'];
                header('Location: index.php');
                exit();
            }
        } else {
            header('Location: login.php?error=Incorrect user name or password!');
            exit();
        }
    }
    
} else {
    header('Location: index.php');
    exit();
}