<!DOCTYPE html>

<html lang = "en">
    <head>

    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel = "stylesheet" type = "text/css" href = "admineditprofile.css"/> 
    </head>
    
    <body>
    <div class="header">
 
 <a href="adminmain.php?">
          <img alt="backbutt" src="backbutt.png"
          width="30" height="30">
       </a>
 
 </div>
        
        <div class="container">
        <h2><center>Edit your profile here </center></h2>
        <h3></h3>

        <form action="" method="post">

        <?php 
        
        session_start();
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 
        include("dbcon.php");	
			$sql=mysqli_query($conn, "SELECT * FROM users where eid='$_SESSION[login_admin]';");
			while($row=mysqli_fetch_assoc($sql))
			
			{?>

            <div class="form-group row">
                <label for="staticid" class="col-sm-2 col-form-label">Your ID:</label>
                <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticid" value="<?php echo $row['eid'];?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="staticfname" class="col-sm-2 col-form-label">First name:</label>
                <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticfname" value="<?php echo $row['fname'];?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="staticlname" class="col-sm-2 col-form-label">Last name:</label>
                <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticlname" value="<?php echo $row['lname'];?>">
                </div>
            </div>

            <div class="form-group">
            <label for="dob">Date of birth</label>
            <input type="date" class="form-control" id="dob" value="<?php echo $row['dob'];?>" name="dob">
            </div>

            <div class="form-group">
            <label for="aemail">Email</label>
            <input type="text" class="form-control" id="aemail" value="<?php echo $row['email'];?>" name="aemail">
            </div>

            <div class="form-group">
            <label for="aaddress">Home address</label>
            <input type="text" class="form-control" id="aaddress" value="<?php echo $row['address'];?>" name="aaddress">
            </div>

            <div class="form-group">
            <label for="number">Phone number</label>
            <input type="text" class="form-control" id="number" value="<?php echo $row['number'];?>" name="anumber">
            </div>

            <div class="form-group">
            <label for="aposition">Current postion</label>
            <input type="text" class="form-control" id="aposition" value="<?php echo $row['position'];?>" name="aposition">
            </div>
            <span class ="password"> <a href = "adminchangepassword.php"> Want to change your password?</a> </span>
            <?php
        } ?>
                  

        <?php
	
        
            if(isset($_POST["submit"]))
            {
               
              $stmt = $conn->prepare("update users set dob = ?,email = ?,address = ?,number = ? ,position = ? where eid='$_SESSION[login_admin]';"); // update query
              $stmt ->bind_param ("sssis",$dob,$aemail,$aaddress,$anumber,$aposition);    
                  
              $dob = $_POST["dob"];
              $aemail = $_POST["aemail"];			
              $aaddress = $_POST["aaddress"];
              $anumber = $_POST["anumber"];
              $aposition = $_POST["aposition"];

                  $stmt-> execute();
                  echo "<div class='alert alert-success'>Your profile was edited successfully.</div>";
      
              $stmt-> close();
              


            }


        ?>

      <center><button type="submit" name="submit" class="button">Edit</button></center>
     </div>
   </form>
  </body>
</html>
