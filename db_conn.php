<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feedbacksystem";
$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
  die("Connection failed: " . $db->connect_error);
}

$sql1 = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql1) === FALSE) {
    echo "Error creating database: " . $conn->error;
} 
$conn->select_db($dbname);

$sql1 = "CREATE TABLE IF NOT EXISTS feedbacks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username text NOT NULL,
    email text NOT NULL,
    feedback text NOT NULL,
    edited tinyint(1) NOT NULL,
    approved tinyint(1) NOT NULL,
    created_at TIMESTAMP NOT NULL,
    img text
)";

if ($conn->query($sql1) === FALSE) {
    echo "Error creating table: " . $conn->error;
}

$result = $conn->query("SHOW TABLES LIKE 'users'");

if ($result->num_rows === 0) {
    $sql2 = "CREATE TABLE IF NOT EXISTS users (
        username text NOT NULL,
        password text NOT NULL
    )";
    if ($conn->query($sql2) === FALSE) {
        echo "Error creating table: " . $conn->error;
    }
    $adminQuery = "INSERT INTO users (username, password) VALUES ('admin', '123')";
    $conn->query($adminQuery);
}




