<!DOCTYPE HTML>
<html lang="en">
<head>
     <meta charset = "utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" >
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


    <link rel = "stylesheet" type = "text/css" href = "loginsstyle.css"/> 

</head>
<body>

<div class="content">
    <center><h1> Enter your login information </h1></center>
    
    <form name="login" action="" method="post">
 
        
            
            <input type="text" name="email" size="48" placeholder="Please enter your email"> 
            
            <input type="password" name="password" size="48"placeholder="Please enter your password"> 
            
            
            <button type="submit" name="submit"> Login </button>
         
            

    </form>
	
	<?php
   
	if(isset($_POST['submit'])){
    
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];
    
    //Validating and checking for empty values
    
    if(empty($email) || empty($password)) {
      
      
      echo "<div class='alert alert-success'>Please make sure to fill all fields</div>";
      exit();
      
    } else {
      
      //initiate the database connection, refering the connection file
      require_once 'dbcon.php';
      
      //Querying the database
      $sql = "SELECT * FROM users WHERE email= ?";
      $stmt = mysqli_stmt_init($conn);
      
      //if the database cant be queried 
      if(!mysqli_stmt_prepare($stmt, $sql)) {
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        
        header("Location:adminlogin.php?error=sqlerror");
        exit();
        
      } else {
        
        //passing the values
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        
        $result = mysqli_stmt_get_result($stmt);
        
        if($row = mysqli_fetch_assoc($result)) {
           $pass = $row['password'];
           $role = $row['role'];
           //validating passwords here
          

          if(password_verify($password,$pass)) {

            if($role == 2){
            session_start();
            $_SESSION['login_employee'] = $row['eid'];

            header("Location:empmain.php?success");
            exit();
            }
            elseif($role == 1){
              session_start();
              $_SESSION['login_admin'] = $row['eid'];
  
              header("Location:adminmain.php?success");
              exit();

            }

          } else {
            
            echo "<div class='alert alert-success'>Invalid Credentials</div>";
           
            exit();

          }

          
        } else {
          
          
          echo "<div class='alert alert-success'>Invalid Credentials</div>";
          exit();

          
        }
        
      }
      
    }
}    
?>
  
  
	</div>
</body>
</html>