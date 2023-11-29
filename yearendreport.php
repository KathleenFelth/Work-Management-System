<?php  
 function fetch_data()  

 {  
      $output = '';  
      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
      include ('dbcon.php');

      $StDate = new DateTime("first day of january last year");
      $EnDate = new DateTime("last day of december last year");

     $StartDate = $StDate->format('Y-m-d');
     $EndDate = $EnDate->format('Y-m-d');

      $query = $conn -> query("SELECT users.fname, users.lname, users.eid,
      IfNull(T.incompleted_tasks,0) AS incomplete,
      IfNull(T.completed_tasks,0) AS complete,
      IfNull(T.late_tasks,0) AS late,
      IfNull(T.number_of_tasks,0) AS numbertask 
FROM   users
LEFT   JOIN (
 SELECT users.eid,
        SUM(CASE WHEN tasks.stats = 0 AND tasks.pf = 1 THEN 1 ELSE 0 END) AS incompleted_tasks,
        SUM(CASE WHEN tasks.stats = 1 AND tasks.pf = 0 THEN 1 ELSE 0 END) AS completed_tasks,
        SUM(CASE WHEN tasks.stats = 1 AND tasks.pf = 1 THEN 1 ELSE 0 END) AS late_tasks,
        SUM(CASE WHEN tasks.tid THEN 1 ELSE 0 END) AS number_of_tasks
 FROM   users
 LEFT   JOIN tasks ON tasks.eemail = users.eid
 WHERE  tasks.datepost BETWEEN '$StartDate' AND '$EndDate'
 GROUP  BY users.eid 
) AS T 
ON users.eid = T.eid WHERE users.role = 2;");  

      while($row = $query -> fetch_array())  
      { 
               
          $number = $row['incomplete'];   
          $number1 = $row['complete'];  
          $number2 = $row['late']; 
          $number3 = $row['numbertask'];
     $output .= '<tr>  
    
                          <td>'.$row["eid"].'</td>    
                          <td>'.$row["fname"].'</td>
                          <td>'.$row["lname"].'</td>
                          <td>'.$number.'</td>
                          <td>'.$number1.'</td>
                          <td>'.$number2.'</td>
                          <td>'.$number3.'</td>
                 </tr>  
                          ';  
      } 
      
      return $output;  
     }
     
     {
      require_once('library/tcpdf.php');  
      class MYPDF extends TCPDF {

          
          public function Header() {
               $this->SetY(+10);
              // Set font
              $this->SetFont('helvetica', 'I', 20);

              //heading
              $this->Cell(0, 15, 'Year end report for Employee progress', 0, false, 'C', 0, '', 0, false, 'M', 'M');
              $tDate=date('F j, Y');
              //positioning
              $this->SetY(+15);
              $this->SetFont('helvetica', 'I', 10);
              $this->Cell(0, 10, 'Date : '.$tDate, 0, false, 'C', 0, '', 0, false, 'T', 'M');
              
          }
      

          public function Footer() {
              // Position at 15 mm from the bottom
              $this->SetY(-15);
              // font
              $this->SetFont('helvetica', 'I', 8);
              // Page number
              $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
              
          }

          
      }
      $obj_pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
      //$obj_pdf->SetCreator(PDF_CREATOR);  
      // set margins
      $obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
      $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
      $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);       
      $obj_pdf->AddPage();  


      $content = '';  
      $content .= '  
      <table border="1" cellspacing="0" cellpadding="5">  
           <tr>  
                <th width="5%">ID</th> 
                <th width="20%">First name</th>  
                <th width="20%">Last name</th>
                <th width="15%">Late incomplete tasks</th>  
                <th width="15%">Completed tasks</th>
                <th width="15%">Late complete tasks</th>
                <th width="10%">No. of tasks for the year</th>                
           </tr>  
      ';  
      $content .= fetch_data();  
      $content .= '</table>';  
      $obj_pdf->writeHTML($content);  
      $obj_pdf->Output('Year end report.pdf', 'I');  
 }  
   
          
     