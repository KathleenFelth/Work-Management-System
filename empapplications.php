
<!DOCTYPE html>
<html lang = "en">
  <head>
    <meta charset = "utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" >
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel ="stylesheet" type = "text/css" href="filesstyle.css"/>
    <title>Your Files </title>
  </head>
  <body >
  
  <div class="header">
 
 <a href="empmain.php?">
          <img alt="backbutt" src="backbutt.png"
          width="30" height="30">
       </a>
 
 </div>



        
     

    <?php
// connect to the database
include 'dbcon.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
session_start();

$sql = "SELECT * FROM applications";
$result = mysqli_query($conn, $sql);

$files = mysqli_fetch_all($result, MYSQLI_ASSOC);


// Uploads files


               
 ?> 
 </div>




<div class="tablestyle">

<center><h4>Download your applications here<h4><center>

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

</body>
</html>