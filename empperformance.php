<!DOCTYPE html>
<html>
    <head>
     <link rel = "stylesheet" type = "text/css" href = "performancestyle.css"/> 
    </head>

<body>

<div class="header">
 
<a href="adminmain.php?">
         <img alt="backbutt" src="backbutt.png"
         width=30" height="30">
      </a>

</div>


 <div class="contents"> 
  <form name="performance" action="" method="post">

  <h3>Compare employees performance</h3>
 
   <ul>                   
      <li><label for = "empid"> <b>Employees ID</b> </label></li>
      <input type="text" name="empid" class="input"> 
       
      
      <li><label for = "datef"> <b>Upper date range </b> </label></li>
      <input type="date" name="datef" class="dates"> 

      
      <li><label for = "dates"> <b>Lower date range</b> </label></li>
      <input type="date" name="dates" class="dates"> 

      <li><label for = "empid1"> <b>Employees ID</b> </label></li>
      <input type="text" name="empid1" class="input"> 
      
      
      <li><label for = "datef1"> <b>Upper date range </b> </label></li>
      <input type="date" name="datef1" class="dates"> 

      
      <li><label for = "dates1"> <b>Lower date range</b> </label></li>
      <input type="date" name="dates1" class="dates"> 
      <break>
      
      <button type="submit" name="submit" class="buttoncompare"> Compare </button>

      
    </ul>
  </form>
</div>

<div class = "wrapper">
  <div class = "row">
   
     <div class = "column">
       <table>
			
      <tr>
        
        <thead>
        <th>First name</th>
        <th>Last name</th>
        <th>Number of tasks done on time</th>
        <th>Number of tasks missed</th>
        
      </tr>
      </thead>
     
    <tbody>
    <?php
       mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        require_once 'dbcon.php';

          $empid = "";
          $datef = "";
          $dates = "";

        if(isset($_POST['submit'])){
          
          if (empty($_POST['empid']) || empty($_POST['datef'])|| empty($_POST['dates'] )) {

            echo '<script>alert ("Please make sure to fill all fields") </script>';
            
          
          }
            
        else{ 
         
        $empid = $_POST['empid'];
        $datef = date('Y-m-d',strtotime($_POST['datef']));
        $dates = date('Y-m-d',strtotime($_POST['dates']));

        $query = $conn->query("SELECT fname, lname from users WHERE eid = '$empid'");
        $count = 1;
        while($fetch = $query->fetch_array()){
          
      ?>
      <tr>
      
        <td><?php echo $fetch['fname']?></td>
        <td><?php echo $fetch['lname']?></td>

        <td>
          
        <?php 
        require_once 'dbcon.php';
        $query = $conn->query("SELECT count(1) from tasks WHERE pf = '0' and stats ='1' and eemail = '$empid' and datepost BETWEEN '$datef' AND '$dates'");
        
        while($fetch1 = $query->fetch_array()){
        $number = $fetch1[0];
        echo $number;}?>
        
      
    
    </td>

        <td>
        <?php 
        require_once 'dbcon.php';
        $query = $conn->query("SELECT count(1) from tasks WHERE pf = '1' and stats ='0' and eemail = '$empid' and datepost BETWEEN '$datef' AND '$dates'");
      
        while($fetch2 = $query->fetch_array()){
        $number = $fetch2[0];
        echo $number;}?>
        
        </td>

        <td colspan="2">
        
      </tr>
      <?php
        }

        }

      }
      ?>
      </tbody>
    
      </table>
    </div>
    
<div class = "column">
  
  <table>
			
      <tr>
        
        <thead>
        <th>First name</th>
        <th>Last name</th>
        <th>Number of tasks done on time</th>
        <th>Number of tasks missed</th>
        
      </tr>
      </thead>
     
    <tbody>
    <?php
       mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        require_once 'dbcon.php';

          $empid1 = "";
          $datef1 = "";
          $dates1 = "";

        if(isset($_POST['submit'])){     
          
          if (empty($_POST['empid1']) || empty($_POST['datef1'])|| empty($_POST['dates1'] )) {

            echo '<script>alert ("Please make sure to fill all fields") </script>';
            
          
          }
            
        else{ 
         
        $empid1 = $_POST['empid1'];
        $datef1 = date('Y-m-d',strtotime($_POST['datef1']));
        $dates1 = date('Y-m-d',strtotime($_POST['dates1']));

        $query = $conn->query("SELECT fname, lname from users WHERE eid = '$empid1'");
        $count = 1;
        while($fetch = $query->fetch_array()){
          
      ?>
      <tr>
      
        <td><?php echo $fetch['fname']?></td>
        <td><?php echo $fetch['lname']?></td>

        <td>
          
        <?php 
        require_once 'dbcon.php';
        $query = $conn->query("SELECT count(1) from tasks WHERE pf = '0' and stats ='1' and eemail = '$empid1' and datepost BETWEEN '$datef1' AND '$dates1'");
        
        while($fetch3 = $query->fetch_array()){
        $number = $fetch3[0];
        echo $number;}?>
        
      
    
    </td>

        <td>
        <?php 
        require_once 'dbcon.php';
        $query = $conn->query("SELECT count(1) from tasks WHERE pf = '1' and stats ='0' and eemail = '$empid1' and datepost BETWEEN '$datef1' AND '$dates1'");
      
        while($fetch4 = $query->fetch_array()){
        $number = $fetch4[0];
        echo $number;}?>
        
        </td>

        <td colspan="2">
        
      </tr>
      <?php
        }

        }

      }
      ?>
         </tbody>
    
       </table>
      </div>
    </div>
  </div>

  <div class = "generate">
      
  </div>

</body>

</html>