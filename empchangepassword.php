<DOCTYPE html>

    <html lang = "en">
    
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel = "stylesheet" type = "text/css" href = "adminchangepassword.css"/> 
   </head>

   <div class="header">
 
 <a href="empmain.php?">
          <img alt="backbutt" src="backbutt.png"
          width="30" height="30">
       </a>
 
 </div>


    <body>

    <div class="container">
        <h3>Change your password here </h3>
        
        <form method="post">
        

            <div class="form-group">           
            <input type="password" class="form-control" placeholder="Enter your current password here" name="cpwd">
            </div>

            <div class="form-group">            
            <input type="password" class="form-control" placeholder="Enter your new password" name="npwd">
            </div>

            <div class="form-group">            
            <input type="password" class="form-control" placeholder="Re-enter your new password" name="connpwd">
            </div>

            <button type="submit" name="change" class="button">Change</button>

            <?php
          session_start();
          mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 
          include("dbcon.php");

            if(isset($_POST["change"])){

            $oldpassword = $_POST["cpwd"];
            $newpassword = $_POST["npwd"];
            $conewpassword = $_POST["connpwd"];
          
            $sql = "SELECT * FROM users WHERE eid = '" . $_SESSION['login_employee'] . "'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_object($result);
             
            if (password_verify($oldpassword, $row->password))
            {
                // Check if password is same
                if ($newpassword == $conewpassword)
                {
                    // Change password
                    $sql = "UPDATE users SET `password` = '" . password_hash($newpassword, PASSWORD_DEFAULT) . "' WHERE eid = '" . $_SESSION['login_employee'] . "'";
                    mysqli_query($conn, $sql);
     
                    echo "<div class='alert alert-success'>Your password has been updated.</div>";
                }
                else
                {
                    echo "<div class='alert alert-danger'>Your passwords dont match!.</div>";
                }
            }
            else
            {
                echo "<div class='alert alert-danger'>Incorrect password!.</div>";
            }
            }
          ?>
        </form>
    </body>

</html>