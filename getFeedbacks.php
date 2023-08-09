<?php

session_start();  
$isAdmin = false;
if(isset($_SESSION['username'])){
    if ($_SESSION['username'] == 'admin'){
        $isAdmin = true;
    }
}
include "db_conn.php";

$orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : 'created_at';
$query = "";
if (!$isAdmin){
    $query = "SELECT * FROM feedbacks WHERE approved=1 ORDER BY $orderBy";
} else {
    $query = "SELECT * FROM feedbacks ORDER BY $orderBy";
}
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $username = $row['username'];
        $email = $row['email'];
        $feedback = $row['feedback'];
        $approved = $row['approved'] ? "Approved" : "Not approved";
        $edited = $row['edited'] ? "Edited by administrator" : "";
        $date = $row['created_at'];
        $id = $row['id'];
        $img = 'uploads/'.$row['img'];
        echo 
        "<div class = 'Feedback'>" . 
        "
            <div class = 'Feedback__username'>{$username}</div> 
            <div class = 'Feedback__email'>{$email}</div> 
            <div class = 'Feedback__feedback'>{$feedback}</div> 
        ". (empty($img) ? 
        "
            <img src = {$img}></img>
        ": "")
        .
        "
            <div>{$edited}</div> 
            <div class = 'Feedback__date'>{$date}</div> 
        " . ($isAdmin ? 
        "
            <div>{$approved}</div>
            <form action = 'editFeedback.php' method = 'post'>
                <input type='hidden' name='id' value='$id' />
                <textarea rows = 5 cols = 30 name = 'feedback'>{$feedback}</textarea>
                <button class='Button' type = 'submit'>Save</button>
            </form>
            <div class = 'ButtonsContainer'>
                <form action = 'approveFeedback.php' method = 'post'>
                    <input type='hidden' name='id' value='$id' /> 
                    <button class='Button' type='submit'>Approve</button>
                </form>
                <form action = 'deleteFeedback.php' method = 'post'>
                    <input type='hidden' name='id' value='$id' /> 
                    <button class='Button' type='submit'>Delete</button>
                </form>
            </div>
            
        " : "") . 
        "</div>";
    }
} else {
    echo "<div>There are no approved feedbacks in the database</div>";
}

$conn->close();
?>