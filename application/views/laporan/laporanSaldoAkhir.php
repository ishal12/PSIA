-<?php
    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);    
  
    // set document information
    $pdf->SetCreator(PB-AOF);
    $pdf->SetAuthor('PB-AOF');
    $pdf->SetTitle('Laporan Saldo Akhir');
    $pdf->SetSubject('Laporan Saldo Akhir');
    $pdf->SetKeywords('');   
  
    // // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_AKHIR_POS, PDF_HEADER_SALDO_AKHIR, PDF_HEADER_STRING);
    // $pdf->setFooterData(array(0,64,0), array(0,64,128)); 
    
    // set header and footer fonts
    // $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    // $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
  
    // set default monospaced font
    // $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); 
  
    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);    
  
    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM); 
    
  
    // set default font subsetting mode
    $pdf->setFontSubsetting(true);   
  
    // Set font
    // dejavusans is a UTF-8 Unicode font, if you only need to
    // print standard ASCII chars, you can use core fonts like
    // helvetica or times to reduce file size.
    $pdf->SetFont('helvetica', '', 9, '', true);   
  
    // Add a page
    // This method has several options, check the source code documentation for more information.
    $pdf->AddPage(); 
  
    // set text shadow effect
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));    
  
    // Set some content to print
   
// Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true); 

    $table ='<table style="width:560px;">';
    $table .='<thead style="width:560px; ">
            <tr>
            <th style="border:1px solid #000; width: 50px; height: 20px; text-align: center;">No Akun</th>
            <th style="border:1px solid #000; width: 180px; text-align: center;">Nama Akun</th>
            <th style="border:1px solid #000; width: 90px; text-align: center;">Saldo Akhir</th>
            
        
            </tr>
            </thead>';
            foreach($vsaldoakhir as $value){
                                        
                $table.='<tr style="width:560px; ">
                    <td style="border:1px solid #000; width: 50px; height: 15px">'.$value["NoAkun"].'</td>
                    <td style="border:1px solid #000; width: 180px;">'.$value["NamaAkun"].'</td>
                    <td style="border:1px solid #000; width: 90px;">'.$value["SaldoAkhir"].'</td>
                    
                </tr>';
            }
                    
    $table .='</table>';
      
    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 0, 0, true, 'C', true);   
    $pdf->LastPage();
    // ---------------------------------------------------------    
  
    // Close and output PDF document
    // This method has several options, check the source code documentation for more information.
    ob_clean();
    $pdf->Output('LaporanSaldoAkhir.pdf', 'I');    
  
    //============================================================+
    // END OF FILE
    //============================================================+

?>