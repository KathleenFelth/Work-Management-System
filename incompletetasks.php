<?php  
 function fetch_data()  

 {  
      $output = '';  
      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
      include ('dbcon.php');

      $StDate = new DateTime("first day of last month");
      $EnDate = new DateTime("last day of last month");

     $StartDate = $StDate->format('Y-m-d');
     $EndDate = $EnDate->format('Y-m-d');
     
      $query = $conn -> query("SELECT users.fname, users.lname, users.eid, tasks.task, tasks.deadline 
      FROM users, tasks
      WHERE users.eid = tasks.eemail AND tasks.stats = 0 AND tasks.pf = 1 AND tasks.datepost BETWEEN '$StartDate' AND '$EndDate' ");  

 

      while($row = $query -> fetch_array())  
      { 
               
            
        
     $output .= '<tr>  
    
                          <td>'.$row["eid"].'</td>    
                          <td>'.$row["fname"].'</td>
                          <td>'.$row["lname"].'</td>
                          <td>'.$row["task"].'</td>
                          <td>'.$row["deadline"].'</td>
                          
                          
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
              $this->Cell(0, 15, 'Incomplete tasks passed the deadline for the last month', 0, false, 'C', 0, '', 0, false, 'M', 'M');
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
                <th width="30%">Late task</th>  
                <th width="15%">Deadline</th>
                              
           </tr>  
      ';  
      $content .= fetch_data();  
      $content .= '</table>';  
      $obj_pdf->writeHTML($content);  
      $obj_pdf->Output('Incomplete tasks.pdf', 'I');  
 }  
   
          
     