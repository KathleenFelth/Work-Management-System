<!doctype html>

<html lang ="en">

   <head>

	<meta charset = "utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" >
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
	<link rel = "stylesheet" type = "text/css" href = "adminprofile.css"/> 
   </head>


<body>

<div class="header">
 
<a href="empmain.php?">
         <img alt="backbutt" src="backbutt.png"
         width="30" height="30">
      </a>

</div>

 <div class="card" style="width: 40rem;" >
	   
	   <div class="card-body">
	   <h5 class="card-title"><center>Your Profile</center></h5>
	   <p class="card-text">
		   <?php 
   include ("dbcon.php");

		   session_start();
		   
		   $sql=mysqli_query($conn, "SELECT * FROM users where eid='$_SESSION[login_employee]';");
		   while($row=mysqli_fetch_assoc($sql))
		   
		   {
		   
		   echo "<b>";
		   echo "<table class= 'table border=2 align=center cellpadding=5 cellspacing=5'>";
		   echo "<tr>";
			   echo "<td>";
				   echo "<b> Your ID: </b>";
			   echo "</td>";
			   echo "<td>";
			   echo $row['eid'];
			   echo "</td>";
		   echo "</tr>";

		   echo "<tr>";
			   echo "<td>";
			   echo"<b> First Name: </b>";
			   echo "</td>";
			   echo "<td>";
				   echo $row['fname'];
			   echo "</td>";
		   echo "</tr>";
		   
			   echo "<tr>";
			   echo "<td>";
				   echo"<b> Last Name: </b>";
			   echo "</td>";
			   echo "<td>";
				   echo $row['lname'];
			   echo "</td>";
		   echo "</tr>";
		   
			   echo "<tr>";
			   echo "<td>";
				   echo"<b> Date of birth: </b>";
			   echo "</td>";
			   echo "<td>";
				   echo $row['dob'];
			   echo "</td>";
		   echo "</tr>";

			   echo "<tr>";
			   echo "<td>";
				   echo"<b> Your registered email: </b>";
			   echo "</td>";
			   echo "<td>";
				   echo $row['email'];
			   echo "</td>";
		   echo "</tr>";

		   echo "<tr>";
			   echo "<td>";
				   echo"<b> Your current address: </b>";
			   echo "</td>";
			   echo "<td>";
				   echo $row['address'];
			   echo "</td>";
		   echo "</tr>";

		   echo "<tr>";
		   echo "<td>";
			   echo"<b> Registered contact number: </b>";
		   echo "</td>";
		   echo "<td>";
			   echo $row['number'];
		   echo "</td>";
	   echo "</tr>";

	   echo "<tr>";
		   echo "<td>";
			   echo"<b> Position held: </b>";
		   echo "</td>";
		   echo "<td>";
			   echo $row['position'];
		   echo "</td>";
	   echo "</tr>";
		   
		   echo "</table>";
		   echo "</b>";
		   
	   }
	   ?></p>
	   <a href="empeditprofile.php" class="btn btn-primary">Edit your profile</a>
	   </div>
 </div>


   

   </body>

</html>