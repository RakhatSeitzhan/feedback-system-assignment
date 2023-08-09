<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback system</title>
    <link rel = "stylesheet" type = "text/css" href = "index.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let orderBy = 'created_at';
        function handleSelectChange(e){
            orderBy = e.target.value;
            fetchData();
        }
        function fetchData() {
            $.ajax({
                url: 'getFeedbacks.php', 
                type: 'GET',
                data: {orderBy},
                success: function(response) {
                    $('#AllFeedbacks').html(response); 
                }
            });
        }
        $(document).ready(function() {
            $('#OrderSelector').change(handleSelectChange)
            fetchData();
        });
    </script>
</head>
<body>
    <?php if (isset($_GET['error'])):?>
    <div id = "ErrorMessage"><?php echo $_GET['error'] ?></div>
    <?php endif ?>
    <div class = "flex-row">
        <div>
            <?php
                session_start();  
                $isAdmin = false;
                if(isset($_SESSION['username'])){
                    if ($_SESSION['username'] == 'admin'){
                        $isAdmin = true;
                    }
                }
                if (!$isAdmin) {
            ?>
                <div><span> <a href="login.php">Log in</a></span> if you are an admin</div>
            <?php } else { ?>
                <a href="logout.php">Log out</a>
            <?php  } ?>
            <form class = "Form" action = "postFeedback.php" method = "post" enctype = "multipart/form-data">
                <div>Leave your feedback!</div>
                <input type = "text" required placeholder = "User name" name = "username"/>
                <input type = "email" required placeholder = "Email" name = "email"/>
                <textarea type = "text" rows="5" required placeholder = "Write your feedback here" name = "feedback"></textarea>
                <input type = "file" name = "img"/>
                <button class = "Button" type = "submit">Submit</button> 
            </form>
        </div>
        <div class = "flex-col">
            <div class = "flex-row">
                <div>Sort by</div>
                <select id = "OrderSelector" default = "date">
                    <option value = "created_at">Date</option>
                    <option value = "username">Username</option>
                    <option value = "email">Email</option>
                    <option value = "id">Id</option>
                </select>
            </div>
            <div id = "AllFeedbacks"></div>
        </div>
        
    </div>
</body>
</html>