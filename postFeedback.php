<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['username']) && isset($_POST['email'])){
    include "db_conn.php";
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $username = validate($_POST['username']);
    $email = validate($_POST['email']);
    $feedback = validate($_POST['feedback']);
    $approved = 0;
    $edited = 0;
    $image = null;
    // $targetDir = "uploads/"; 
    // if(!empty($_FILES["img"]["name"])){ 
    //     $fileName = basename($_FILES["img"]["name"]); 
    //     $targetFilePath = $targetDir . $fileName; 
    //     $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION); 
    //     $allowTypes = array('jpg','png','jpeg','gif'); 
    //     if(in_array($fileType, $allowTypes)){ 
    //         if(move_uploaded_file($_FILES["img"]["tmp_name"], $targetFilePath)){ 
    //             $image = $fileName;
    //         }else{ 
    //             $statusMsg = "Sorry, there was an error uploading your file."; 
    //             header("Location: index.php?error=Sorry, there was an error uploading your file");
    //             exit();
    //         } 
    //     }else{ 
    //         header("Location: index.php?error=Invalid image format");
    //         exit();
    //     } 
    // }else{ 
    //     header("Location: index.php?error=Please select a file to upload");
    //     exit();
    // } 
    if (isset($_FILES['img'])){
        if (!empty($_FILES["img"]["name"])){
            $img_name = $_FILES['img']['name'];
            $tmp_name = $_FILES['img']['tmp_name'];
            $img_size = $_FILES['img']['size'];
            $error = $_FILES['img']['error'];
            if ($error === 0){
                if ($img_size <= 1024*1024){
                    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                    $img_ex_lc = strtolower($img_ex);
                    $allowed_exs = array("jpg", "png", "jpeg");
                    if (in_array($img_ex_lc, $allowed_exs)){
                        $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                        $img_upload_path = 'uploads/'.$new_img_name;
                        if (move_uploaded_file($tmp_name, $img_upload_path)){
                            $image = $new_img_name;
                        } else {
                            header("Location: index.php?error=Could not upload the image");
                            exit();
                        }
                    } else {
                        header("Location: index.php?error=Invalid image format");
                        exit();
                    }
                } else {
                    header("Location: index.php?error=Image size must be under 1Mb");
                    exit();
                }
            } else {
                header("Location: index.php?error=Please select the image");
                exit();
            }
        }
    }
    
    if (empty($username) || empty($email) || empty($feedback)) {
        header('Location: index.php');
        exit();
    } else {
        $sql = "INSERT INTO feedbacks (username, email, feedback, approved, created_at, edited, img) VALUES ('$username', '$email', '$feedback', '$approved', NOW(), '$edited', '$image')";
        mysqli_query($conn, $sql);
        header("Location: index.php");
        exit();
    }
    
} else {
    header('Location: index.php');
    exit();
}