<?php
session_start();
?>
<!DOCTYPE html>
<html lang = "en">
  <head>
   
  <meta charset = "utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" >
	 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

     <link rel = "stylesheet" type = "text/css" href = "empmain.css"/> 
 </head>
  <body>
  <?php


if (! empty($_SESSION['login_employee']))
{
    ?>
<div id="main">

<div class="header">
  
 
  <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Welcome</span>
</div>

<div id="mySidenav" class="sidenav">
                  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                        
                  <a href="todo.php">To-do lists</a>
                  <a href="empprofile.php">Your profile</a>     
                  <a href="files.php">Upload files</a>
                
                  <form method="post" action="">
                    <button type="submit" name="submit" class="logout">Log out</button>
                  </form>
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
        
  
<br>
<br>
<div class="card border-dark mb-3" style="width: 40rem;" >
		
		<div class="card-body">
		<h5 class="card-title"><center>Todays announcements</center></h5>
		<p class="card-text">
      <?php
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        include("dbcon.php");

        $date = new DateTime();
        $currentdate = $date->format('Y-m-d');
        
      $sql=mysqli_query($conn, "SELECT content FROM announcements where dateposted = '$currentdate'");
      if ($sql-> num_rows > 0) {
      while($row=mysqli_fetch_assoc($sql))

      {

      echo "<b>";
      echo "<table class= 'table border=2 align=center cellpadding=5 cellspacing=5'>";
      echo "<tr>";
          echo "<td>";
              echo "<b> Announcement: </b>";
          echo "</td>";
          echo "<td>";
          echo $row['content'];
          echo "</td>";
      echo "</tr>";

      echo "</table>";
      echo "</b>";

      }
      echo "</table>";
    } else { echo "There are no announcements yet"; }  

      ?></p>

        </div>
    </div>

            
      
   <?php
    }else{
      echo '<script>alert ("You are logged out") </script> <a href="index.html">Click here</a> to log back in.';

    }
   ?> 
   
   <?php
// connect to the database
include 'dbcon.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


$sql = "SELECT * FROM applications";
$result = mysqli_query($conn, $sql);

$files = mysqli_fetch_all($result, MYSQLI_ASSOC);



               
 ?> 





<div class="tablestyle">

<center><h5>Download your applications here<h5><center>

<table>

<tbody>
  <?php foreach ($files as $file): 
   $filename = $file['filename'];
    ?>
    <tr>
 
      <td><a href="applications.php?aid=<?php echo $file['aid']?>"> <?php echo "$filename" ?></a></td>
    </tr>
  <?php endforeach;?>

</tbody>
</table>
  </div>
  </div>
<?php
if (isset($_GET['aid'])) {
    $id = $_GET['aid'];

    // fetch file to download from database
    $sql = "SELECT * FROM applications WHERE aid=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'files/' . $file['filename'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('files/' . $file['filename']));
        ob_clean();
        flush();
        readfile('files/' . $file['filename']);

           // testing if system registers download
           $newCount = $file['downloadfile'] + 1;
           $updateQuery = "UPDATE applications SET downloadfile=$newCount WHERE fileID=$id";
           mysqli_query($conn, $updateQuery);
           exit;
        
    }

}
?> 

<?php
    if (isset($_POST['submit'])) {

      session_start();
      unset($_SESSION["login_employee"]);
      header("Location:index.html");
      
    }
  ?>

</body>
</html>