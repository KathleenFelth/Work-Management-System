<!DOCTYPE html>

<html lang = "en">
<head>
     <meta charset = "utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" >
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

     <link rel = "stylesheet" type = "text/css" href = "todostyle.css"/> 

</head>
<body >
<div class="header">
 
 <a href="empmain.php?">Home</a>
 
 </div>

      <div class="contents">
      <h2>Add new tasks</h2>
	    <form method="post" action="" name="tasksinputs">
        
        <ul>
        
          <li><label for ="name"> <b>Task name</b> </label></li>
            <input type="text" name="name" class="input">

          <li><label for ="datep"> <b>Date of notification</b> </label></li>
            <input type="date" name="datep" class="dates">

          <li><label for ="datef"> <b>Deadline</b> </label></li>
            <input type="date" name="datef" class="dates">

		    <button type="submit" name="submit" class="add_button">Add Task</button>
        <p id="time"></p>
        </ul>         
	    </form>

      <?php
 
 mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);  //error handling
    include("dbcon.php");//initiating database connection
     session_start();// initiating session
        
     
     $name = "";
     $datep = "";
     $datef = "";
  
     
     if (isset($_POST['submit'])) {

       if (empty($_POST['name']) || empty($_POST['datep'])|| empty($_POST['datef'] )) {

         
         echo "<div class='alert alert-success'>Please make sure to fill all fields</div>";
       
       }
         
     else{ 
           $name = $_POST['name']; //inputs from the form
           $datep = $_POST['datep'];
           $datef = $_POST['datef'];
           $id = $_SESSION['login_employee'];
         
           // Inserting into tasks Table
         
                   
               $query = "INSERT INTO tasks SET task=?, datepost=?, deadline=?, eemail =?";
               $stmt = $conn->prepare($query);
               $stmt->bind_param('sssi', $name, $datep, $datef, $id);// binding parameters to avoid sql injections
               $result = $stmt->execute();//executing the bound insertion statements
       
               if ($result) {
                   //it works
               } else {
                 echo 'mannn you dead';//you in trouble naoww
               }
           }
         }
           ?>

  </div>
	
  <br /><br /><br />
		<table>
  
				<tr>
          
          <thead>
					<th><center>Task number</center></th>
					<th><center>Task</center></th>
					<th><center>Date of notification</center></th>
					<th><center>Deadline</center></th><!--table headings -->
          
				</tr>
        </thead>
       
			<tbody>
      <?php
					require_once 'dbcon.php';
					$query = $conn->query("SELECT tid, task, datepost, deadline, stats from tasks WHERE eemail = '$_SESSION[login_employee]' AND stats = 0");
					$count = 1;
					while($fetch = $query->fetch_array()){ //database query
            
				?>
				<tr>
        
					<td style="height:50px;width:100px"><center><?php echo $count++?></center></td>
					<td style="height:50px;width:200px"><center><?php echo $fetch['task']?></center></td>
          <td style="height:50px;width:200px"><center><?php echo $fetch['datepost']?></center></td> <!--table data called here-->

          <td style="height:50px;width:400px">
            <?php
            require_once 'dbcon.php';

            $current_date = new DateTime(date('Y-m-d')); 
            $deadline = new DateTime($fetch['deadline']);
                  
            $datediffer = $current_date->diff($deadline);
            $days = $datediffer->format('%R%a');
                 
            //echo $days;
            if ($days < 5 && $days > 0 ) {
              echo "<font color=yellow> $days days close to you deadline </font>";
              echo $fetch['deadline'];
              }  
             
          elseif($days < 0 ){
          
            if($fetch['tid'] != ""){
              $tid = $fetch['tid'];
            echo "<font color=red> $days days passed your deadline </font>";
            $conn->query("UPDATE `tasks` SET `pf` = '1' WHERE `tid` = $tid") or die(mysqli_errno($conn));
            echo $fetch['deadline'];
            
            }
          }
          
           else{
            echo $fetch['deadline'];
           }
          
					?>
          </td>

          <td colspan="2">
          <td>
						
							<?php
              require_once 'dbcon.php';
								if($fetch['stats'] != "1"){
									echo 
									'<a href="taskupdate.php?tid='.$fetch['tid'].'"> Completed </a> ';// completed link
								}
							?>
							
						
					</td>
				</tr>
				<?php
					}
				?>
			</tbody>
        
		</table>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script type="text/javascript">
    var timestamp = '<?=time();?>';
     function updateTime(){
       $('#time').html(Date(timestamp));
       timestamp++;
   }
  $(function(){
  setInterval(updateTime, 1000);
   });
 </script>



</body>
</html>