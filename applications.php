
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
 
 <a href="adminmain.php?">
          <img alt="backbutt" src="backbutt.png"
          width="30" height="30">
       </a>
 
 </div>

  <div class="content">
        <form action="applications.php" method="post" enctype="multipart/form-data" >

          <h3>Upload applications here</h3>
                 
          <input type="file" name="myfile"> 
          
          <button type="submit"  name="save" class= "submit_button">upload</button> 
        
        </form>

        
     

    <?php
// connect to the database
include 'dbcon.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
session_start();

$sql = "SELECT * FROM applications";
$result = mysqli_query($conn, $sql);

$files = mysqli_fetch_all($result, MYSQLI_ASSOC);
// Uploads files
if (isset($_POST['save'])) { 
    // name of the uploaded file from the form
    $filename = $_FILES['myfile']['name'];

    // file destination on the server
    $destination = 'files/' . $filename;

    // getting the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    // the physical file on a temporary uploads directory on the server
    $file = $_FILES['myfile']['tmp_name'];
    

    if (!in_array($extension, ['zip', 'pdf', 'docx'])) {

        echo "The file extention is not accepted. Please make sure its is docx,pdf or zip.";
    } 
    elseif ($_FILES['myfile']['size'] > 1000000) { // file size specification
        echo "File too large!";
    }
    else {
        // moving the file to desired location (temporary)
        if (move_uploaded_file($file, $destination)) {
            $sql = "INSERT INTO applications (filename, downloadfile) VALUES ('$filename',  0)";
            if (mysqli_query($conn, $sql)) {
                echo "<div class='alert alert-success'>File uploaded successfully.</div>";
            }
        } else {
          echo "<div class='alert alert-success'>File upload failed.</div>";
        }
    }
}

               
 ?> 
 </div>
<div class="tablestyle">
<table>
<thead>
    
    <th>Filename</th>   
    <th>Action</th>
</thead>
<tbody>
  <?php foreach ($files as $file): 
   
    ?>
    <tr>
      
    <td style="height:50px;width:250px"><?php echo $file['filename']; ?></td>
      
      
      <td><a href="applications.php?aid=<?php echo $file['aid'] ?>">Download</a></td>
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