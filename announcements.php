<!DOCTYPE HTML>
<html>
<head>

     <link rel = "stylesheet" type = "text/css" href = "announcement.css"/> 

</head>
<body>

<div class="header">
 
<a href="adminmain.php?">
         <img alt="backbutt" src="backbutt.png"
         width="30" height="30">
      </a>

</div>

<div class="content">
    <center><h1>Please enter announcement details</h1></center>
   
    <form name="register" action="" method="post">
 
        
            <label for = "content"> <b>Content</b> </label>
            <input type="text" name="content" size="48"> 

            <button type="submit" name="submit1"> Make a new announcement </button>
                 
    </form>
	
	</div>
	<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
 include("dbcon.php");
 
 if(isset($_POST["submit1"]))
		
	{ 
        $stmt = $conn->prepare ("insert into announcements(content,dateposted) values(?,?)"); //Insert query to register a person
        $stmt ->bind_param("ss",$content,$date);

            $date = date('Y-m-d');
            $content = $_POST["content"];         
            $stmt-> execute();
        echo "Announcement made";

        $stmt-> close();
 
	}
    $date = new DateTime();
    $currentdate = $date->format('Y-m-d');
    $sql=mysqli_query($conn, "SELECT content FROM announcements where dateposted = '$currentdate'");
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

?>