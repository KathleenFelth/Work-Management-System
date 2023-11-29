<!DOCTYPE HTML>
<html lang = "en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<link rel = "stylesheet" type = "text/css" href = "registering.css"/> 
  
</head>
<body>
<div class = "header">
<a href="adminmain.php?">
          <img alt="backbutt" src="backbutt.png"
          width="30" height="30">
       </a>
</div>
<div class="content">
    <center><h2>Please enter your details </h2></center>
   
    <form name="register" action="" method="post">
 
        
            
            <input type="text" name="fname" size="48" placeholder="First name"> 


            <input type="text" name="lname" size="48" placeholder="Last name"> 


            <label for = "dob"> <b>Date of birth</b> </label>
            <input type="date" name="dob" size="45">   

            <input type="text" name="address" size="48" placeholder="Residential address"> 
            
           
            <input type="text" name="position" size="48" placeholder="Position held"> 

            
            <input type="text" name="email" size="48" placeholder="Email address">

          
            <input type="text" name="phone" size="48" placeholder="Phone number"> 

            
            <input type="password" name="password" size="48" placeholder="Preferred password"> 

           
            <input type="password" name="conpassword" size="48" placeholder="Confirm password"> 

            <div class="form-group">
                 <label for="access"><b>User Access status<b></label>
                 <select name = "access" id="access" class="form-control">
                      <option value = "1"> Adminstrators Access</option>
                      <option value = "2"> User Access</option>
                 </select>

            

            <button type="submit" name="submit1"> Register new user</button> 
             
        
    </form>
	
	
	<?php
 include("dbcon.php");

 $errors = [];
 $fname = "";
 $lname = "";
 $dob = "";
 $address = "";
 $position = "";
 $email = "";
 $password = "";
 $phone = "";
 $access = "";
 $conpassword = "";

 
 if(isset($_POST["submit1"])){

  $phone = $_POST["phone"];
    $email = $_POST["email"];
    $conpassword = $_POST["conpassword"];
    $password = $_POST["password"];

  $sql = $conn ->query("select email from users"); 
  if($row = mysqli_fetch_assoc($sql)) {
  
  $regemail = $row['email'];

    

 if (empty($_POST['fname']) || empty($_POST['lname'])|| empty($_POST['dob'] )|| empty($_POST['address'] )|| empty($_POST['position'] )|| empty($_POST['email'] )|| empty($_POST['password'] )|| empty($_POST['phone'] )||  empty($_POST['access'] )||  empty($_POST['conpassword'] )) {

         
    echo "<div class='alert alert-danger'>Please make sure to fill all fileds.</div>";

  
    
  }
  elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){


    echo "<div class='alert alert-danger'>Please enter a valid email address.</div>";

  }
 
  elseif($email == $regemail){


    echo "<div class='alert alert-danger'>This email is already registered.</div>";

  }

  elseif(!preg_match('/^[0-9]{10}+$/', $phone)) {
   
    echo "<div class='alert alert-danger'>Please enter a valid phone number.</div>";
    }

 elseif($conpassword != $password){
     
    echo "<div class='alert alert-danger'>Your passwords dont match.</div>";

 }
		
  else{ 
    if (count($errors) === 0) {   
        $stmt = $conn->prepare ("insert into users(fname,lname,dob,email,password,address,number,position,role) values(?,?,?,?,?,?,?,?,?)"); //Insert query to register a person
        $stmt ->bind_param("ssssssisi",$fname,$lname,$dob,$email,$hashedpassword,$address,$phone,$position,$access);
 
            $fname = $_POST["fname"];
            $lname = $_POST["lname"];
            $dob = $_POST["dob"];  
            $address = $_POST["address"];
            $position = $_POST["position"];
           
            $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
            $access = $_POST["access"];
            
           
            $stmt-> execute();
            echo "<div class='alert alert-info'>A new user was successfully registered.</div>";

        $stmt-> close();
    }
	}
}
}

		
?>
</div>
</body>
</html>