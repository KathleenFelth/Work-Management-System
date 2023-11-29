<?php
session_start();
?>

<!DOCTYPE html>
<html lang ="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1" >
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

   <link rel = "stylesheet" type = "text/css" href = "adminmain.css"/> 
</head>
<body>

<?php

if (! empty($_SESSION['login_admin']))
{
    ?>



<div id="mySidenav" class="sidenav">
  
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  
  
  <a href="empperformance.php">Employee Performance</a>
  <a href="adminprofile.php">Your profile</a>
  <a href="registering.php">Register a new user</a>
  <a href="adminaddtask.php"> Add tasks for employees</a>
  <a href="applications.php">Applications</a>
 
  <form method="post" action="">
  <button type="submit" name="submit" class="logout">Log out</button>
  </form>
</div>

<div id="main">

<div class="header">
 

<span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Welcome! </span>



</div>

<div class= "content">
  <h2>Reports available</h2>
<br>
<br>
<br>
<br>

  <a href="reportstester.php" class="bomb" role="button">Month end reports</a>
  <a href="yearendreport.php" class="bomb" role="button">Year end reports</a>
  <a href="employeereport.php" class="bomb" role="button">Employee report</a>
  <a href="adminreport.php" class="bomb" role="button">Administrators report</a>
  <a href="incompletetasks.php" class="bomb" role="button">Incomplete tasks report</a>
</div>


<div class="this">
    <center><h3>Please enter announcement details</h3></center>
   
    <form name="register" action="" method="post">
 
        
            <label for = "text"> <b>Content</b> </label>
            <input type="text" name="text" size="48"> 
            <br>

            <button type="submit" class="makeann"name="submit1"> Make a new announcement </button>
                 
    </form>
	


	<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
 include("dbcon.php");

 $date = new DateTime();
 $currentdate = $date->format('Y-m-d');
 
 if(isset($_POST["submit1"]))
		
	{ 
        $stmt = $conn->prepare ("insert into announcements(content,dateposted) values(?,?)"); //Insert query to register a person
        $stmt ->bind_param("ss",$text,$date);

            $date = date('Y-m-d');
            $text = $_POST["text"];         
            $stmt-> execute();
            echo "<div class='alert alert-success'>Announcement made</div>";

        $stmt-> close();
 
	}
   
    

?>
	</div>
</div>

<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
}
</script>

    <?php
}
else
{
  
  echo '<script>alert ("You are logged out") </script> <a href="index.html">Click here</a> to log back in.';
}
?>


  <?php
    if (isset($_POST['submit'])) {

      session_start();
      unset($_SESSION["login_admin"]);
      header("Location:index.html");
      
    }
  ?>






   
</body>
</html>