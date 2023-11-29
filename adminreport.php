<?php  
 function fetch_data()  

 {  
      $output = '';  
      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
      include ('dbcon.php');

      

      $query = $conn -> query("SELECT * from users where `role` = 1");  

      while($row = $query -> fetch_array())  
      { 
               
          
     $output .= '<tr>  
    
                          <td>'.$row["eid"].'</td>    
                          <td>'.$row["fname"].'</td>
                          <td>'.$row["lname"].'</td>
                          <td>'.$row["dob"].'</td>
                          <td>'.$row["email"].'</td>
                          <td>'.$row["address"].'</td>
                          <td>'.$row["number"].'</td>
                          <td>'.$row["position"].'</td>
                          
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
              $this->Cell(0, 15, 'Administrator details', 0, false, 'C', 0, '', 0, false, 'M', 'M');
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
                <th width="14%">First name</th>  
                <th width="14%">Last name</th>
                <th width="15%">Date of birth</th>  
                <th width="16%">Email</th>
                <th width="15%">Address</th>
                <th width="15%">Number</th>
                <th width="13%">Position</th>                
           </tr>  
      ';  
      $content .= fetch_data();  
      $content .= '</table>';  
      $obj_pdf->writeHTML($content);  
      $obj_pdf->Output('Administrator report.pdf', 'I');  
 }  
   
          
     