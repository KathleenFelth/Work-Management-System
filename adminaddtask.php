<!DOCTYPE HTML>
<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);  //error handling
    include("dbcon.php");//initiate database connection
     session_start();// initiate session
?>

<html lang = "en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    
     <link rel = "stylesheet" type = "text/css" href = "adminaddtask.css"/> 

</head>
<body>

<div class="header">
 
<a href="adminmain.php?">
         <img alt="backbutt" src="backbutt.png"
         width="30" height="30">
      </a>

</div>


      <div class="contents">
      <h2><center>Add new tasks</center></h2>
	    <form method="post" action="" name="tasksinputs">
        
        <ul>
        
          <li><label for ="name"> <b>Task name</b> </label></li>
            <input type="text" name="name" class="input"placeholder="Enter tasks here">

          <li><label for ="datep"> <b>Date of notification</b> </label></li>
            <input type="date" name="datep" class="dates">

          <li><label for ="datef"> <b>Deadline</b> </label></li>
            <input type="date" name="datef" class="dates">
            <br>

          <li><label for ="eid"> <b>Employee ID</b> </label></li>
            <input type="text" name="eid" class="dates" placeholder="To add task or delete employee">
            
		    <button type="submit" name="submit" class="add_button1">Add Task</button>

        <button class ="add_button1" name="delete" type="submit">Delete employee</button><br>

        <li><label for ="empname"> <b>Employee Name</b> </label></li>
            <input type="text" name="empname" class="input" placeholder="Enter employee's first name to search">

        <button type="submit" name="search" class="add_button">Search</button>
        
        <button type="submit" name="allemps" class="add_button1">All employees</button>
        </ul>  
    <?php    
        if(isset($_POST["search"])){ ?>
					
           <table class="tableone">
     
				<tr>
        
          <thead>
					<th>Employees ID</th>
					<th>First name</th>
					<th>Last name</th>
          <th>Employee email</th>
					<th>Date of birth</th>
          <th>Home address</th>
          <th>Number</th>
          <th>Position</th>
          
				</tr>
        </thead>
       
			<tbody>
      <?php
					
          $sql = $conn ->query("SELECT * from users where fname='$_POST[empname]'"); 
          if ($sql-> num_rows > 0) {
					while($fetch=mysqli_fetch_assoc($sql)){
            
				?>
				<tr>
        
					<td style="height:50px;width:100px"><center><?php echo $fetch['eid']?></center></td>
					<td style="height:50px;width:100px"><?php echo $fetch['fname']?></td>
          <td style="height:50px;width:100px"><?php echo $fetch['lname']?></td>
          <td style="height:50px;width:100px"><?php echo $fetch['email']?></td>
          <td style="height:50px;width:100px"><center><?php echo $fetch['dob']?></center></td>          
          <td style="height:50px;width:100px"><center><?php echo $fetch['address']?></center></td>
          <td style="height:50px;width:100px"><?php echo $fetch['number']?></td>
          <td style="height:50px;width:100px"><?php echo $fetch['position']?></td>

          
				</tr>
				<?php
          }
        
					}
          else { echo "0 results"; }

        }
				?>
			</tbody>
      
		</table>
				
         <!-- echo "<table>";
          $sql = "SELECT * from employee where empfname='$_POST[empname]'";
          $result = $conn-> query($sql);
          if ($result-> num_rows > 0) {
           while($row = $result-> fetch_assoc()) {
            echo "<tr><td>" . $row["eid"] . "</td><td>" . $row["empfname"] . "</td><td>". $row["emplname"]. "<td>" . $row["edob"] . "</td><td>" . $row["eemail"] . "</td><td>" . $row["eaddress"] . "</td><td>" . $row["eposition"] . "</td></tr>";
          }
          echo "</table>";
          } else { echo "0 results"; }
          $conn->close();
            
            
          }
          ?>-->
            <?php    
        if(isset($_POST["delete"])){
					
				
          $sql = $conn->prepare ("DELETE FROM users WHERE eid = ?");
          $sql->bind_param("i", $_POST["eid"]); 
          $result = $sql->execute();
          $sql->close(); 
          $conn->close();
       
               if ($result) {
                echo "<div class='alert alert-success'>The employee has been deleted.</div>";
               } else {
                 echo 'mannn you dead';//you in trouble naoww
               }
            
          }
          ?>

<?php
             
     $errors = [];
     $name = "";
     $datep = "";
     $datef = "";
     $eid = "";
  
     
     if (isset($_POST['submit'])) {

         
        if (empty($_POST['name']) || empty($_POST['datep'])|| empty($_POST['datef'] )|| empty($_POST['eid'] )) {

         
          echo "<div class='alert alert-success'>Please make sure to fill all fields.</div>";
          
        }
          
      else{ 
         
      
           $name = $_POST['name']; //inputs from the form
           $datep = $_POST['datep'];
           $datef = $_POST['datef'];
           $eid = $_POST['eid'];
       
           // Inserting into tasks Table
                                                
             if (count($errors) === 0) {          //database column names
               $query = "INSERT INTO tasks SET task=?, datepost=?, deadline=?, eemail =?";
               $stmt = $conn->prepare($query);
               $stmt->bind_param('ssss', $name, $datep, $datef, $eid);// binding parameters to avoid sql injections
               $result = $stmt->execute();//executing the bound insertion statements
       
               if ($result) {
                echo "<div class='alert alert-success'>The task was added.</div>";
               } else {
                 echo 'mannn you dead';//you in trouble naoww
               }
           }
         }
        }
    

           ?>



	    </form>
      </div>
  
      <?php
      if(isset($_POST["allemps"])){?>
      <table class="tableone">
      
				<tr>
        
          <thead>
					<th>Employees ID</th>
					<th>First name</th>
					<th>Last name</th>
          <th>Employee email</th>
					<th>Date of birth</th>
          <th>Home address</th>
          <th>Number</th>
          <th>Position</th>
          
				</tr>
        </thead>
       
			<tbody>
      <?php
					
          $sql = $conn ->query("select eid,fname,lname,dob,email,address,number,position from users where role = 2"); 
          
					while($fetch=mysqli_fetch_assoc($sql)){
            
				?>
				<tr>
        
					<td style="height:50px;width:100px"><center><?php echo $fetch['eid']?></center></td>
					<td style="height:50px;width:100px"><center><?php echo $fetch['fname']?></center></td>
          <td style="height:50px;width:100px"><center><?php echo $fetch['lname']?></center></td>
          <td style="height:50px;width:100px"><center><?php echo $fetch['dob']?></center></td>
          <td style="height:50px;width:100px"><center><?php echo $fetch['email']?></center></td>
          <td style="height:50px;width:100px"><center><?php echo $fetch['address']?></center></td>
          <td style="height:50px;width:100px"><center><?php echo $fetch['number']?></center></td>
          <td style="height:50px;width:100px"><center><?php echo $fetch['position']?></center></td>

          
				</tr>
				<?php
					}

        }
				?>
			</tbody>
      
		</table>

  
  

          </body>

          </html>