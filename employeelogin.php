<!DOCTYPE HTML>
<html lang = "en">
<head>

     <link rel = "stylesheet" type = "text/css" href = "loginsstyle.css"/> 
     <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
   

</head>

<body style = "background: url(loginpic.png); background-size: 100%;">
<div class="content">
    <center><h1> Please enter your login information </h1></center>
    
    <form name="login" action="" method="post">
 
        
            
            <label for = "email"> <b>Enter your email</b> </label>
            <input type="text" name="email" size="48"> 
            
            
            <label for = "password"> <b>Enter Your Password </b> </label>
            <input type="password" name="password" size="48"> 
            
            
            <button type="submit" name="submit"> Login </button>
         
            <span class ="password"> <a href = "frgtpas.php"> Forgot  password? </a> </span>
       
    </form>
	
    </div>

    <?php
	if(isset($_POST['submit'])){
    
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];
   
    
    //Validation
    //check for empty values
    if(empty($email) || empty($password)) {
      
      header("Location:employeelogin.php?error=emptyfields&username=".$email);
    
      exit();
      
    } else {
      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);  //error handling
      //DB Connection
      require_once 'dbcon.php';
      
      //Query the DB
      $sql = "SELECT * FROM employee WHERE eemail='$email'";
      $stmt = mysqli_stmt_init($conn);

      
      
      //if cannot query the DB
      if(!mysqli_stmt_prepare($stmt, $sql)) {
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        
        header("Location:employeelogin.php?error=sqlerror");
        exit();
        
      } else {
        
        //passing the values
       mysqli_stmt_bind_param($stmt, "s", $email);
       mysqli_stmt_execute($stmt);
        
        $result = mysqli_stmt_get_result($stmt);
        
        if($row = mysqli_fetch_assoc($result)) {
           $pass = $row['epassword'];
           //validating passwords here
          
          
          
        

          if(password_verify($password,$pass)) {

            session_start();
            $_SESSION['login_employee'] = $row['eid'];

            header("Location:empmain.php?");
            exit();
            

          } else {
            header("Location:employeelogin.php?error=invalidCredentials");
            
            exit();

          }

          
        } else {
          
          
          header("Location:employeelogin.php?error=invalidCredentials");
          exit();

          
        }
        
      }
      
    }
}    
?>
  
  
	</div>
</body>
</html>