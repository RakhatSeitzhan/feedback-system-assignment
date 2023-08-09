<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" type = "text/css" href = "index.css">
    <title>Login</title>
</head>
<body>
    <form class = "Form" action = "auth.php" method = "post" enctype = "multipart/form-data">
        <?php if (isset($_GET['error'])) {?>
            <div id = "ErrorMessage"><?php echo $_GET['error']; ?></div>
        <?php } ?>
        <div>Log in</div>
        <input type = "text"  placeholder = "User name" name = "username"/>
        <input type = "password"  placeholder = "Password" name = "password"/>
        <button class = "Button" type = "submit">Login</button> 
    </form>
</body>
</html>