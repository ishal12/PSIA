<?php
    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);    
  
    // set document information
    // $pdf->SetCreator(PB-AOF);
    $pdf->SetAuthor('PB-AOF');
    $pdf->SetTitle('Laporan Buku Besar');
    $pdf->SetSubject('Laporan Buku Besar');
    $pdf->SetKeywords('');   
  
    // // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_BUKU_BESAR, PDF_HEADER_STRING);
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

    //untuk kas
	$table ='<table style="width:560px;">';
	$table .='<thead style="width:560px; ">
            <tr>
                <th  style="border:1px solid #000; font-weight:bold; width: 185px; text-align: center;" colspan="2">Kas Di Tangan</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">No Akun: 101</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">Saldo</th>
                <th rowspan="2" style="border:1px solid #000; font-weight:bold; width: 60px; text-align: center;">No Bukti</th>
            </tr>
            <tr>
        		<th style="border:1px solid #000; width: 55px; text-align: center;">Tanggal</th>
        		<th style="border:1px solid #000; width: 130px; text-align: center; ">Keterangan</th>
        		<th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
        		<th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
    		</tr>
            </thead>';
            $saldoawal= $kas[0]['SaldoAwal'];
    		foreach($kas as $key=>$value){
    			if($key == 0){
                    $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">01-'.date("m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">Saldo Awal</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;"></td></tr>
                    ';
                }				
				$table.='<tr style="width:560px;">
					<td style="border:1px solid #000; width: 55px; height: 30px;">'.date("d-m-Y",strtotime($value["Tanggal"])).'</td>
					<td style="border:1px solid #000; width: 130px; height: 30px;">'.$value["Keterangan"].'</td>
					<td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalDebet"].'</td>
					<td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalKredit"].'</td>
                    ';
                $saldoawal = $saldoawal+$value["NominalDebet"]-$value['NominalKredit'];
                if($value['SaldoNormal']==1){
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
    		}
    			    
	$table .='</tbody></table>';
    
    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 0, 0, true, 'C', true);   
 	$pdf->LastPage();
    
    // Add a page
    // This method has several options, check the source code documentation for more information.
    $pdf->AddPage(); 
  
    // set text shadow effect
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));    
  
    // Set some content to print

// Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true); 

    //untuk rekening baca baca
    $table ='<table style="width:560px;">';
    $table .='<thead style="width:560px; ">
            <tr>
                <th style="border:1px solid #000; font-weight:bold; width: 185px; text-align: center;" colspan="2">Rekening Baca-Baca</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">No Akun: 102</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">Saldo</th>
                <th rowspan="2" style="border:1px solid #000; font-weight:bold; width: 60px; text-align: center;">No Bukti</th>
            </tr>
            <tr>
                <th style="border:1px solid #000; width: 55px; text-align: center;">Tanggal</th>
                <th style="border:1px solid #000; width: 130px; text-align: center; ">Keterangan</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
            </tr>
            </thead>';
            $saldoawal= $rekeningBacaBaca[0]['SaldoAwal'];
            foreach($rekeningBacaBaca as $key=>$value){
                if($key == 0){
                    $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">01-'.date("m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">Saldo Awal</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;"></td></tr>
                    ';
                }               
                $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">'.date("d-m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">'.$value["Keterangan"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalDebet"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalKredit"].'</td>
                    ';
                $saldoawal = $saldoawal+$value["NominalDebet"]-$value['NominalKredit'];
                if($value['SaldoNormal']==1){
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
            }
                    
    $table .='</tbody></table>';
    
    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 0, 0, true, 'C', true);   
    $pdf->LastPage();


    // Rekening Suka Sendiri
    $pdf->AddPage(); 
  
    // set text shadow effect
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));    
  
    // Set some content to print

// Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true); 

    //untuk rekening baca baca
    $table ='<table style="width:560px;">';
    $table .='<thead style="width:560px; ">
            <tr>
                <th style="border:1px solid #000; font-weight:bold; width: 185px; text-align: center;" colspan="2">Rekening Suka Sendiri</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">No Akun: 103</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">Saldo</th>
                <th rowspan="2" style="border:1px solid #000; font-weight:bold; width: 60px; text-align: center;">No Bukti</th>
            </tr>
            <tr>
                <th style="border:1px solid #000; width: 55px; text-align: center;">Tanggal</th>
                <th style="border:1px solid #000; width: 130px; text-align: center; ">Keterangan</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
            </tr>
            </thead>';
            $saldoawal= $rekeningSukaSendiri[0]['SaldoAwal'];
            foreach($rekeningSukaSendiri as $key=>$value){
                if($key == 0){
                    $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">01-'.date("m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">Saldo Awal</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;"></td></tr>
                    ';
                }               
                $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">'.date("d-m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">'.$value["Keterangan"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalDebet"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalKredit"].'</td>
                    ';
                $saldoawal = $saldoawal+$value["NominalDebet"]-$value['NominalKredit'];
                if($value['SaldoNormal']==1){
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
            }
                    
    $table .='</tbody></table>';
    
    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 0, 0, true, 'C', true);   
    $pdf->LastPage();

    // Piutang Dagang
    $pdf->AddPage(); 
  
    // set text shadow effect
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));    
  
    // Set some content to print

// Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true); 

    //untuk rekening baca baca
    $table ='<table style="width:560px;">';
    $table .='<thead style="width:560px; ">
            <tr>
                <th style="border:1px solid #000; font-weight:bold; width: 185px; text-align: center;" colspan="2">Piutan Dagang</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">No Akun: 104</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">Saldo</th>
                <th rowspan="2" style="border:1px solid #000; font-weight:bold; width: 60px; text-align: center;">No Bukti</th>
            </tr>
            <tr>
                <th style="border:1px solid #000; width: 55px; text-align: center;">Tanggal</th>
                <th style="border:1px solid #000; width: 130px; text-align: center; ">Keterangan</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
            </tr>
            </thead>';
            $saldoawal= $piutangDagang[0]['SaldoAwal'];
            foreach($piutangDagang as $key=>$value){
                if($key == 0){
                    $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">01-'.date("m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">Saldo Awal</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;"></td></tr>
                    ';
                }               
                $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">'.date("d-m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">'.$value["Keterangan"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalDebet"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalKredit"].'</td>
                    ';
                $saldoawal = $saldoawal+$value["NominalDebet"]-$value['NominalKredit'];
                if($value['SaldoNormal']==1){
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
            }
                    
    $table .='</tbody></table>';
    
    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 0, 0, true, 'C', true);   
    $pdf->LastPage();

    // Piutang Cek
    $pdf->AddPage(); 
  
    // set text shadow effect
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));    
  
    // Set some content to print

// Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true); 

    //untuk rekening baca baca
    $table ='<table style="width:560px;">';
    $table .='<thead style="width:560px; ">
            <tr>
                <th style="border:1px solid #000; font-weight:bold; width: 185px; text-align: center;" colspan="2">Piutang Cek</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">No Akun: 105</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">Saldo</th>
                <th rowspan="2" style="border:1px solid #000; font-weight:bold; width: 60px; text-align: center;">No Bukti</th>
            </tr>
            <tr>
                <th style="border:1px solid #000; width: 55px; text-align: center;">Tanggal</th>
                <th style="border:1px solid #000; width: 130px; text-align: center; ">Keterangan</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
            </tr>
            </thead>';
            $saldoawal= $piutangCek[0]['SaldoAwal'];
            foreach($piutangCek as $key=>$value){
                if($key == 0){
                    $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">01-'.date("m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">Saldo Awal</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;"></td></tr>
                    ';
                }               
                $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">'.date("d-m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">'.$value["Keterangan"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalDebet"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalKredit"].'</td>
                    ';
                $saldoawal = $saldoawal+$value["NominalDebet"]-$value['NominalKredit'];
                if($value['SaldoNormal']==1){
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
            }
                    
    $table .='</tbody></table>';
    
    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 0, 0, true, 'C', true);   
    $pdf->LastPage();

    // Sediaan Barang Alat Tulis
    $pdf->AddPage(); 
  
    // set text shadow effect
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));    
  
    // Set some content to print

// Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true); 

    //untuk rekening baca baca
    $table ='<table style="width:560px;">';
    $table .='<thead style="width:560px; ">
            <tr>
                <th style="border:1px solid #000; font-weight:bold; width: 185px; text-align: center;" colspan="2">Sedian Barang Alat Tulis</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">No Akun: 106</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">Saldo</th>
                <th rowspan="2" style="border:1px solid #000; font-weight:bold; width: 60px; text-align: center;">No Bukti</th>
            </tr>
            <tr>
                <th style="border:1px solid #000; width: 55px; text-align: center;">Tanggal</th>
                <th style="border:1px solid #000; width: 130px; text-align: center; ">Keterangan</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
            </tr>
            </thead>';
            $saldoawal= $sediaanBarangAlatTulis[0]['SaldoAwal'];
            foreach($sediaanBarangAlatTulis as $key=>$value){
                if($key == 0){
                    $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">01-'.date("m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">Saldo Awal</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;"></td></tr>
                    ';
                }               
                $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">'.date("d-m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">'.$value["Keterangan"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalDebet"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalKredit"].'</td>
                    ';
                $saldoawal = $saldoawal+$value["NominalDebet"]-$value['NominalKredit'];
                if($value['SaldoNormal']==1){
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
            }
                    
    $table .='</tbody></table>';
    
    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 0, 0, true, 'C', true);   
    $pdf->LastPage();

    // Sediaan Barang Rumah Tangga
    $pdf->AddPage(); 
  
    // set text shadow effect
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));    
  
    // Set some content to print

// Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true); 

    $table ='<table style="width:560px;">';
    $table .='<thead style="width:560px; ">
            <tr>
                <th style="border:1px solid #000; font-weight:bold; width: 185px; text-align: center;" colspan="2">Sedian Barang Rumah Tangga</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">No Akun: 107</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">Saldo</th>
                <th rowspan="2" style="border:1px solid #000; font-weight:bold; width: 60px; text-align: center;">No Bukti</th>
            </tr>
            <tr>
                <th style="border:1px solid #000; width: 55px; text-align: center;">Tanggal</th>
                <th style="border:1px solid #000; width: 130px; text-align: center; ">Keterangan</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
            </tr>
            </thead>';
            $saldoawal= $sediaanBarangRumahTangga[0]['SaldoAwal'];
            foreach($sediaanBarangRumahTangga as $key=>$value){
                if($key == 0){
                    $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">01-'.date("m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">Saldo Awal</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;"></td></tr>
                    ';
                }               
                $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">'.date("d-m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">'.$value["Keterangan"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalDebet"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalKredit"].'</td>
                    ';
                $saldoawal = $saldoawal+$value["NominalDebet"]-$value['NominalKredit'];
                if($value['SaldoNormal']==1){
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
            }
                    
    $table .='</tbody></table>';
    
    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 0, 0, true, 'C', true);   
    $pdf->LastPage();  
   
    // Sediaan Habis Pakai
    $pdf->AddPage(); 
  
    // set text shadow effect
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));    
  
    // Set some content to print

// Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true); 

    $table ='<table style="width:560px;">';
    $table .='<thead style="width:560px; ">
            <tr>
                <th style="border:1px solid #000; font-weight:bold; width: 185px; text-align: center;" colspan="2">Sedian Habis Pakai</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">No Akun: 108</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">Saldo</th>
                <th rowspan="2" style="border:1px solid #000; font-weight:bold; width: 60px; text-align: center;">No Bukti</th>
            </tr>
            <tr>
                <th style="border:1px solid #000; width: 55px; text-align: center;">Tanggal</th>
                <th style="border:1px solid #000; width: 130px; text-align: center; ">Keterangan</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
            </tr>
            </thead>';
            $saldoawal= $sediaanHabisPakai[0]['SaldoAwal'];
            foreach($sediaanHabisPakai as $key=>$value){
                if($key == 0){
                    $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">01-'.date("m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">Saldo Awal</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;"></td></tr>
                    ';
                }               
                $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">'.date("d-m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">'.$value["Keterangan"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalDebet"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalKredit"].'</td>
                    ';
                $saldoawal = $saldoawal+$value["NominalDebet"]-$value['NominalKredit'];
                if($value['SaldoNormal']==1){
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
            }
                    
    $table .='</tbody></table>';
    
    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 0, 0, true, 'C', true);   
    $pdf->LastPage();

    // Kendaraan
    $pdf->AddPage(); 
  
    // set text shadow effect
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));    
  
    // Set some content to print

// Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true); 

    $table ='<table style="width:560px;">';
    $table .='<thead style="width:560px; ">
            <tr>
                <th style="border:1px solid #000; font-weight:bold; width: 185px; text-align: center;" colspan="2">Kendaraan</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">No Akun: 110</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">Saldo</th>
                <th rowspan="2" style="border:1px solid #000; font-weight:bold; width: 60px; text-align: center;">No Bukti</th>
            </tr>
            <tr>
                <th style="border:1px solid #000; width: 55px; text-align: center;">Tanggal</th>
                <th style="border:1px solid #000; width: 130px; text-align: center; ">Keterangan</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
            </tr>
            </thead>';
            $saldoawal= $kendaraan[0]['SaldoAwal'];
            foreach($kendaraan as $key=>$value){
                if($key == 0){
                    $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">01-'.date("m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">Saldo Awal</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;"></td></tr>
                    ';
                }               
                $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">'.date("d-m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">'.$value["Keterangan"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalDebet"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalKredit"].'</td>
                    ';
                $saldoawal = $saldoawal+$value["NominalDebet"]-$value['NominalKredit'];
                if($value['SaldoNormal']==1){
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
            }
                    
    $table .='</tbody></table>';
    
    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 0, 0, true, 'C', true);   
    $pdf->LastPage();

    // Skumulasi Depresiasi Kendaraan
    $pdf->AddPage(); 
  
    // set text shadow effect
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));    
  
    // Set some content to print

// Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true); 

    $table ='<table style="width:560px;">';
    $table .='<thead style="width:560px; ">
            <tr>
                <th style="border:1px solid #000; font-weight:bold; width: 185px; text-align: center;" colspan="2">Akumulasi Depresiasi Kendaraan</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">No Akun: 111</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">Saldo</th>
                <th rowspan="2" style="border:1px solid #000; font-weight:bold; width: 60px; text-align: center;">No Bukti</th>
            </tr>
            <tr>
                <th style="border:1px solid #000; width: 55px; text-align: center;">Tanggal</th>
                <th style="border:1px solid #000; width: 130px; text-align: center; ">Keterangan</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
            </tr>
            </thead>';
            $saldoawal= $akumulasiDepresiasiKendaraan[0]['SaldoAwal'];
            foreach($akumulasiDepresiasiKendaraan as $key=>$value){
                if($key == 0){
                    $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">01-'.date("m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">Saldo Awal</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;"></td></tr>
                    ';
                }               
                $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">'.date("d-m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">'.$value["Keterangan"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalDebet"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalKredit"].'</td>
                    ';
                $saldoawal = $saldoawal+$value["NominalDebet"]-$value['NominalKredit'];
                if($value['SaldoNormal']==1){
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
                 else
                {
                    $saldoawal = $saldoawal+$value["NominalKredit"]-$value['NominalDebet'];
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
            }
                    
    $table .='</tbody></table>';
    
    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 0, 0, true, 'C', true);   
    $pdf->LastPage();

    // Hutang Dagang
    $pdf->AddPage(); 
  
    // set text shadow effect
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));    
  
    // Set some content to print

// Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true); 

    //untuk rekening baca baca
    $table ='<table style="width:560px;">';
    $table .='<thead style="width:560px; ">
            <tr>
                <th style="border:1px solid #000; font-weight:bold; width: 185px; text-align: center;" colspan="2">Hutang Dagang</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">No Akun: 201</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">Saldo</th>
                <th rowspan="2" style="border:1px solid #000; font-weight:bold; width: 60px; text-align: center;">No Bukti</th>
            </tr>
            <tr>
                <th style="border:1px solid #000; width: 55px; text-align: center;">Tanggal</th>
                <th style="border:1px solid #000; width: 130px; text-align: center; ">Keterangan</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
            </tr>
            </thead>';
            $saldoawal= $hutangDagang[0]['SaldoAwal'];
            foreach($hutangDagang as $key=>$value){
                if($key == 0){
                    $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">01-'.date("m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">Saldo Awal</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;"></td></tr>
                    ';
                }               
                $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">'.date("d-m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">'.$value["Keterangan"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalDebet"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalKredit"].'</td>
                    ';
                $saldoawal = $saldoawal+$value["NominalDebet"]-$value['NominalKredit'];
                if($value['SaldoNormal']==1){
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
                else
                {
                    $saldoawal = $saldoawal+$value["NominalKredit"]-$value['NominalDebet'];
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
            }
                    
    $table .='</tbody></table>';
    
    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 0, 0, true, 'C', true);   
    $pdf->LastPage();
  

   // Hutang Bank
    $pdf->AddPage(); 
  
    // set text shadow effect
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));    
  
    // Set some content to print

// Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true); 

    //untuk rekening baca baca
    $table ='<table style="width:560px;">';
    $table .='<thead style="width:560px; ">
            <tr>
                <th style="border:1px solid #000; font-weight:bold; width: 185px; text-align: center;" colspan="2">Hutang Bank</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">No Akun: 202</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">Saldo</th>
                <th rowspan="2" style="border:1px solid #000; font-weight:bold; width: 60px; text-align: center;">No Bukti</th>
            </tr>
            <tr>
                <th style="border:1px solid #000; width: 55px; text-align: center;">Tanggal</th>
                <th style="border:1px solid #000; width: 130px; text-align: center; ">Keterangan</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
            </tr>
            </thead>';
            $saldoawal= $hutangBank[0]['SaldoAwal'];
            foreach($hutangBank as $key=>$value){
                if($key == 0){
                    $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">01-'.date("m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">Saldo Awal</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;"></td></tr>
                    ';
                }               
                $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">'.date("d-m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">'.$value["Keterangan"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalDebet"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalKredit"].'</td>
                    ';
                $saldoawal = $saldoawal+$value["NominalDebet"]-$value['NominalKredit'];
                if($value['SaldoNormal']==1){
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
                else
                {
                    $saldoawal = $saldoawal+$value["NominalKredit"]-$value['NominalDebet'];
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
            }
                    
    $table .='</tbody></table>';
    
    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 0, 0, true, 'C', true);   
    $pdf->LastPage();
  
  // hutang Cek
    $pdf->AddPage(); 
  
    // set text shadow effect
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));    
  
    // Set some content to print

// Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true); 

    //untuk rekening baca baca
    $table ='<table style="width:560px;">';
    $table .='<thead style="width:560px; ">
            <tr>
                <th style="border:1px solid #000; font-weight:bold; width: 185px; text-align: center;" colspan="2">Hutang Cek</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">No Akun: 203</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">Saldo</th>
                <th rowspan="2" style="border:1px solid #000; font-weight:bold; width: 60px; text-align: center;">No Bukti</th>
            </tr>
            <tr>
                <th style="border:1px solid #000; width: 55px; text-align: center;">Tanggal</th>
                <th style="border:1px solid #000; width: 130px; text-align: center; ">Keterangan</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
            </tr>
            </thead>';
            $saldoawal= $hutangCek[0]['SaldoAwal'];
            foreach($hutangCek as $key=>$value){
                if($key == 0){
                    $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">01-'.date("m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">Saldo Awal</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;"></td></tr>
                    ';
                }               
                $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">'.date("d-m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">'.$value["Keterangan"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalDebet"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalKredit"].'</td>
                    ';
                $saldoawal = $saldoawal+$value["NominalDebet"]-$value['NominalKredit'];
                if($value['SaldoNormal']==1){
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
                else
                {
                    $saldoawal = $saldoawal+$value["NominalKredit"]-$value['NominalDebet'];
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
            }
                    
    $table .='</tbody></table>';
    
    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 0, 0, true, 'C', true);   
    $pdf->LastPage();

    // Sediaan Barang Alat Tulis
    $pdf->AddPage(); 
  
    // set text shadow effect
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));    
  
    // Set some content to print

// Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true); 

    //untuk rekening baca baca
    $table ='<table style="width:560px;">';
    $table .='<thead style="width:560px; ">
            <tr>
                <th style="border:1px solid #000; font-weight:bold; width: 185px; text-align: center;" colspan="2">Hutang PPN</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">No Akun: 204</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">Saldo</th>
                <th rowspan="2" style="border:1px solid #000; font-weight:bold; width: 60px; text-align: center;">No Bukti</th>
            </tr>
            <tr>
                <th style="border:1px solid #000; width: 55px; text-align: center;">Tanggal</th>
                <th style="border:1px solid #000; width: 130px; text-align: center; ">Keterangan</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
            </tr>
            </thead>';
            $saldoawal= $hutangPPN[0]['SaldoAwal'];
            foreach($hutangPPN as $key=>$value){
                if($key == 0){
                    $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">01-'.date("m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">Saldo Awal</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;"></td></tr>
                    ';
                }               
                $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">'.date("d-m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">'.$value["Keterangan"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalDebet"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalKredit"].'</td>
                    ';
                $saldoawal = $saldoawal+$value["NominalDebet"]-$value['NominalKredit'];
                if($value['SaldoNormal']==1){
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
                else
                {
                    $saldoawal = $saldoawal+$value["NominalKredit"]-$value['NominalDebet'];
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
            }
                    
    $table .='</tbody></table>';
    
    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 0, 0, true, 'C', true);   
    $pdf->LastPage();

    // Sediaan Barang Alat Tulis
    $pdf->AddPage(); 
  
    // set text shadow effect
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));    
  
    // Set some content to print

// Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true); 

    //untuk rekening baca baca
    $table ='<table style="width:560px;">';
    $table .='<thead style="width:560px; ">
            <tr>
                <th style="border:1px solid #000; font-weight:bold; width: 185px; text-align: center;" colspan="2">Modal Pemilik</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">No Akun: 301</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">Saldo</th>
                <th rowspan="2" style="border:1px solid #000; font-weight:bold; width: 60px; text-align: center;">No Bukti</th>
            </tr>
            <tr>
                <th style="border:1px solid #000; width: 55px; text-align: center;">Tanggal</th>
                <th style="border:1px solid #000; width: 130px; text-align: center; ">Keterangan</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
            </tr>
            </thead>';
            $saldoawal= $modalPemilik[0]['SaldoAwal'];
            foreach($modalPemilik as $key=>$value){
                if($key == 0){
                    $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">01-'.date("m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">Saldo Awal</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;"></td></tr>
                    ';
                }               
                $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">'.date("d-m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">'.$value["Keterangan"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalDebet"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalKredit"].'</td>
                    ';
                $saldoawal = $saldoawal+$value["NominalDebet"]-$value['NominalKredit'];
                if($value['SaldoNormal']==1){
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
                else
                {
                    $saldoawal = $saldoawal+$value["NominalKredit"]-$value['NominalDebet'];
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
            }
                    
    $table .='</tbody></table>';
    
    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 0, 0, true, 'C', true);   
    $pdf->LastPage();

     // Sediaan Barang Alat Tulis
    $pdf->AddPage(); 
  
    // set text shadow effect
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));    
  
    // Set some content to print

// Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true); 

    //untuk rekening baca baca
    $table ='<table style="width:560px;">';
    $table .='<thead style="width:560px; ">
            <tr>
                <th style="border:1px solid #000; font-weight:bold; width: 185px; text-align: center;" colspan="2">Prive</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">No Akun: 302</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">Saldo</th>
                <th rowspan="2" style="border:1px solid #000; font-weight:bold; width: 60px; text-align: center;">No Bukti</th>
            </tr>
            <tr>
                <th style="border:1px solid #000; width: 55px; text-align: center;">Tanggal</th>
                <th style="border:1px solid #000; width: 130px; text-align: center; ">Keterangan</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
            </tr>
            </thead>';
            $saldoawal= $prive[0]['SaldoAwal'];
            foreach($prive as $key=>$value){
                if($key == 0){
                    $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">01-'.date("m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">Saldo Awal</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;"></td></tr>
                    ';
                }               
                $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">'.date("d-m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">'.$value["Keterangan"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalDebet"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalKredit"].'</td>
                    ';
                $saldoawal = $saldoawal+$value["NominalDebet"]-$value['NominalKredit'];
                if($value['SaldoNormal']==1){
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
                else
                {
                    $saldoawal = $saldoawal+$value["NominalKredit"]-$value['NominalDebet'];
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
            }
                    
    $table .='</tbody></table>';
    
    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 0, 0, true, 'C', true);   
    $pdf->LastPage();

      // Sediaan Barang Alat Tulis
    $pdf->AddPage(); 
  
    // set text shadow effect
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));    
  
    // Set some content to print

// Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true); 

    //untuk rekening baca baca
    $table ='<table style="width:560px;">';
    $table .='<thead style="width:560px; ">
            <tr>
                <th style="border:1px solid #000; font-weight:bold; width: 185px; text-align: center;" colspan="2">Penjualan</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">No Akun: 401</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">Saldo</th>
                <th rowspan="2" style="border:1px solid #000; font-weight:bold; width: 60px; text-align: center;">No Bukti</th>
            </tr>
            <tr>
                <th style="border:1px solid #000; width: 55px; text-align: center;">Tanggal</th>
                <th style="border:1px solid #000; width: 130px; text-align: center; ">Keterangan</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
            </tr>
            </thead>';
            $saldoawal= $penjualan[0]['SaldoAwal'];
            foreach($penjualan as $key=>$value){
                if($key == 0){
                    $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">01-'.date("m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">Saldo Awal</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;"></td></tr>
                    ';
                }               
                $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">'.date("d-m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">'.$value["Keterangan"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalDebet"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalKredit"].'</td>
                    ';
                $saldoawal = $saldoawal+$value["NominalDebet"]-$value['NominalKredit'];
                if($value['SaldoNormal']==1){
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
                else
                {
                    $saldoawal = $saldoawal+$value["NominalKredit"]-$value['NominalDebet'];
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
            }
                    
    $table .='</tbody></table>';
    
    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 0, 0, true, 'C', true);   
    $pdf->LastPage();

       // Sediaan Barang Alat Tulis
    $pdf->AddPage(); 
  
    // set text shadow effect
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));    
  
    // Set some content to print

// Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true); 

    //untuk rekening baca baca
    $table ='<table style="width:560px;">';
    $table .='<thead style="width:560px; ">
            <tr>
                <th style="border:1px solid #000; font-weight:bold; width: 185px; text-align: center;" colspan="2">'.$diskonPenjualan[0]["NamaAkun"].'</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">No Akun: '.$diskonPenjualan[0]["NoAkun"].'</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">Saldo</th>
                <th rowspan="2" style="border:1px solid #000; font-weight:bold; width: 60px; text-align: center;">No Bukti</th>
            </tr>
            <tr>
                <th style="border:1px solid #000; width: 55px; text-align: center;">Tanggal</th>
                <th style="border:1px solid #000; width: 130px; text-align: center; ">Keterangan</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
            </tr>
            </thead>';
            $saldoawal= $diskonPenjualan[0]['SaldoAwal'];
            foreach($diskonPenjualan as $key=>$value){
                if($key == 0){
                    $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">01-'.date("m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">Saldo Awal</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;"></td></tr>
                    ';
                }               
                $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">'.date("d-m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">'.$value["Keterangan"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalDebet"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalKredit"].'</td>
                    ';
                $saldoawal = $saldoawal+$value["NominalDebet"]-$value['NominalKredit'];
                if($value['SaldoNormal']==1){
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
                else
                {
                    $saldoawal = $saldoawal+$value["NominalKredit"]-$value['NominalDebet'];
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
            }
                    
    $table .='</tbody></table>';
    
    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 0, 0, true, 'C', true);   
    $pdf->LastPage();

       // Sediaan Barang Alat Tulis
    $pdf->AddPage(); 
  
    // set text shadow effect
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));    
  
    // Set some content to print

// Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true); 

    //untuk rekening baca baca
    $table ='<table style="width:560px;">';
    $table .='<thead style="width:560px; ">
            <tr>
                <th style="border:1px solid #000; font-weight:bold; width: 185px; text-align: center;" colspan="2">Pendapatan Lain-Lain</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">No Akun: 403</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">Saldo</th>
                <th rowspan="2" style="border:1px solid #000; font-weight:bold; width: 60px; text-align: center;">No Bukti</th>
            </tr>
            <tr>
                <th style="border:1px solid #000; width: 55px; text-align: center;">Tanggal</th>
                <th style="border:1px solid #000; width: 130px; text-align: center; ">Keterangan</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
            </tr>
            </thead>';
            $saldoawal= $pendapatanLain[0]['SaldoAwal'];
            foreach($pendapatanLain as $key=>$value){
                if($key == 0){
                    $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">01-'.date("m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">Saldo Awal</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;"></td></tr>
                    ';
                }               
                $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">'.date("d-m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">'.$value["Keterangan"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalDebet"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalKredit"].'</td>
                    ';
                $saldoawal = $saldoawal+$value["NominalDebet"]-$value['NominalKredit'];
                if($value['SaldoNormal']==1){
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
                else
                {
                    $saldoawal = $saldoawal+$value["NominalKredit"]-$value['NominalDebet'];
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
            }
                    
    $table .='</tbody></table>';
    
    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 0, 0, true, 'C', true);   
    $pdf->LastPage();

      // Sediaan Barang Alat Tulis
    $pdf->AddPage(); 
  
    // set text shadow effect
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));    
  
    // Set some content to print

// Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true); 

    //untuk rekening baca baca
    $table ='<table style="width:560px;">';
    $table .='<thead style="width:560px; ">
            <tr>
                <th style="border:1px solid #000; font-weight:bold; width: 185px; text-align: center;" colspan="2">HPP</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">No Akun: 501</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">Saldo</th>
                <th rowspan="2" style="border:1px solid #000; font-weight:bold; width: 60px; text-align: center;">No Bukti</th>
            </tr>
            <tr>
                <th style="border:1px solid #000; width: 55px; text-align: center;">Tanggal</th>
                <th style="border:1px solid #000; width: 130px; text-align: center; ">Keterangan</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
            </tr>
            </thead>';
            $saldoawal= $HPP[0]['SaldoAwal'];
            foreach($HPP as $key=>$value){
                if($key == 0){
                    $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">01-'.date("m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">Saldo Awal</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;"></td></tr>
                    ';
                }               
                $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">'.date("d-m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">'.$value["Keterangan"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalDebet"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalKredit"].'</td>
                    ';
                $saldoawal = $saldoawal+$value["NominalDebet"]-$value['NominalKredit'];
                if($value['SaldoNormal']==1){
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
                else
                {
                    $saldoawal = $saldoawal+$value["NominalKredit"]-$value['NominalDebet'];
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
            }
                    
    $table .='</tbody></table>';
    
    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 0, 0, true, 'C', true);   
    $pdf->LastPage();

      // Sediaan Barang Alat Tulis
    $pdf->AddPage(); 
  
    // set text shadow effect
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));    
  
    // Set some content to print

// Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true); 

    //untuk rekening baca baca
    $table ='<table style="width:560px;">';
    $table .='<thead style="width:560px; ">
            <tr>
                <th style="border:1px solid #000; font-weight:bold; width: 185px; text-align: center;" colspan="2">Biaya Gaji</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">No Akun: 506</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">Saldo</th>
                <th rowspan="2" style="border:1px solid #000; font-weight:bold; width: 60px; text-align: center;">No Bukti</th>
            </tr>
            <tr>
                <th style="border:1px solid #000; width: 55px; text-align: center;">Tanggal</th>
                <th style="border:1px solid #000; width: 130px; text-align: center; ">Keterangan</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
            </tr>
            </thead>';
            $saldoawal= $biayaGaji[0]['SaldoAwal'];
            foreach($biayaGaji as $key=>$value){
                if($key == 0){
                    $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">01-'.date("m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">Saldo Awal</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;"></td></tr>
                    ';
                }               
                $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">'.date("d-m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">'.$value["Keterangan"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalDebet"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalKredit"].'</td>
                    ';
                $saldoawal = $saldoawal+$value["NominalDebet"]-$value['NominalKredit'];
                if($value['SaldoNormal']==1){
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
                else
                {
                    $saldoawal = $saldoawal+$value["NominalKredit"]-$value['NominalDebet'];
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
            }
                    
    $table .='</tbody></table>';
    
    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 0, 0, true, 'C', true);   
    $pdf->LastPage();

       // Sediaan Barang Alat Tulis
    $pdf->AddPage(); 
  
    // set text shadow effect
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));    
  
    // Set some content to print

// Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true); 

    //untuk rekening baca baca
    $table ='<table style="width:560px;">';
    $table .='<thead style="width:560px; ">
            <tr>
                <th style="border:1px solid #000; font-weight:bold; width: 185px; text-align: center;" colspan="2">Biaya Sediaan</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">No Akun: 507</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">Saldo</th>
                <th rowspan="2" style="border:1px solid #000; font-weight:bold; width: 60px; text-align: center;">No Bukti</th>
            </tr>
            <tr>
                <th style="border:1px solid #000; width: 55px; text-align: center;">Tanggal</th>
                <th style="border:1px solid #000; width: 130px; text-align: center; ">Keterangan</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
            </tr>
            </thead>';
            $saldoawal= $biayaSediaan[0]['SaldoAwal'];
            foreach($biayaSediaan as $key=>$value){
                if($key == 0){
                    $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">01-'.date("m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">Saldo Awal</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;"></td></tr>
                    ';
                }               
                $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">'.date("d-m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">'.$value["Keterangan"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalDebet"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalKredit"].'</td>
                    ';
                $saldoawal = $saldoawal+$value["NominalDebet"]-$value['NominalKredit'];
                if($value['SaldoNormal']==1){
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
                else
                {
                    $saldoawal = $saldoawal+$value["NominalKredit"]-$value['NominalDebet'];
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
            }
                    
    $table .='</tbody></table>';
    
    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 0, 0, true, 'C', true);   
    $pdf->LastPage();

       // Sediaan Barang Alat Tulis
    $pdf->AddPage(); 
  
    // set text shadow effect
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));    
  
    // Set some content to print

// Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true); 

    //untuk rekening baca baca
    $table ='<table style="width:560px;">';
    $table .='<thead style="width:560px; ">
            <tr>
                <th style="border:1px solid #000; font-weight:bold; width: 185px; text-align: center;" colspan="2">Biaya Depresiasi</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">No Akun: 508</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">Saldo</th>
                <th rowspan="2" style="border:1px solid #000; font-weight:bold; width: 60px; text-align: center;">No Bukti</th>
            </tr>
            <tr>
                <th style="border:1px solid #000; width: 55px; text-align: center;">Tanggal</th>
                <th style="border:1px solid #000; width: 130px; text-align: center; ">Keterangan</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
            </tr>
            </thead>';
            $saldoawal= $biayaDepresiasi[0]['SaldoAwal'];
            foreach($biayaDepresiasi as $key=>$value){
                if($key == 0){
                    $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">01-'.date("m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">Saldo Awal</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;"></td></tr>
                    ';
                }               
                $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">'.date("d-m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">'.$value["Keterangan"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalDebet"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalKredit"].'</td>
                    ';
                $saldoawal = $saldoawal+$value["NominalDebet"]-$value['NominalKredit'];
                if($value['SaldoNormal']==1){
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
                else
                {
                    $saldoawal = $saldoawal+$value["NominalKredit"]-$value['NominalDebet'];
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
            }
                    
    $table .='</tbody></table>';
    
    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 0, 0, true, 'C', true);   
    $pdf->LastPage();

       // Sediaan Barang Alat Tulis
    $pdf->AddPage(); 
  
    // set text shadow effect
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));    
  
    // Set some content to print

// Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true); 

    //untuk rekening baca baca
    $table ='<table style="width:560px;">';
    $table .='<thead style="width:560px; ">
            <tr>
                <th style="border:1px solid #000; font-weight:bold; width: 185px; text-align: center;" colspan="2">Biaya Listrik Telpon</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">No Akun: 509</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">Saldo</th>
                <th rowspan="2" style="border:1px solid #000; font-weight:bold; width: 60px; text-align: center;">No Bukti</th>
            </tr>
            <tr>
                <th style="border:1px solid #000; width: 55px; text-align: center;">Tanggal</th>
                <th style="border:1px solid #000; width: 130px; text-align: center; ">Keterangan</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
            </tr>
            </thead>';
            $saldoawal= $biayaListrikTelp[0]['SaldoAwal'];
            foreach($biayaListrikTelp as $key=>$value){
                if($key == 0){
                    $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">01-'.date("m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">Saldo Awal</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;"></td></tr>
                    ';
                }               
                $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">'.date("d-m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">'.$value["Keterangan"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalDebet"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalKredit"].'</td>
                    ';
                $saldoawal = $saldoawal+$value["NominalDebet"]-$value['NominalKredit'];
                if($value['SaldoNormal']==1){
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
                else
                {
                    $saldoawal = $saldoawal+$value["NominalKredit"]-$value['NominalDebet'];
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
            }
                    
    $table .='</tbody></table>';
    
    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 0, 0, true, 'C', true);   
    $pdf->LastPage();

     // Sediaan Barang Alat Tulis
    $pdf->AddPage(); 
  
    // set text shadow effect
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));    
  
    // Set some content to print

// Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true); 

    //untuk rekening baca baca
    $table ='<table style="width:560px;">';
    $table .='<thead style="width:560px; ">
            <tr>
                <th style="border:1px solid #000; font-weight:bold; width: 185px; text-align: center;" colspan="2">Rugi Penjualan Aset Tetap</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">No Akun: 515</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">Saldo</th>
                <th rowspan="2" style="border:1px solid #000; font-weight:bold; width: 60px; text-align: center;">No Bukti</th>
            </tr>
            <tr>
                <th style="border:1px solid #000; width: 55px; text-align: center;">Tanggal</th>
                <th style="border:1px solid #000; width: 130px; text-align: center; ">Keterangan</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
            </tr>
            </thead>';
            $saldoawal= $rugiPenjualanAsetTetap[0]['SaldoAwal'];
            foreach($rugiPenjualanAsetTetap as $key=>$value){
                if($key == 0){
                    $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">01-'.date("m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">Saldo Awal</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;"></td></tr>
                    ';
                }               
                $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">'.date("d-m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">'.$value["Keterangan"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalDebet"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalKredit"].'</td>
                    ';
                $saldoawal = $saldoawal+$value["NominalDebet"]-$value['NominalKredit'];
                if($value['SaldoNormal']==1){
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
                else
                {
                    $saldoawal = $saldoawal+$value["NominalKredit"]-$value['NominalDebet'];
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
            }
                    
    $table .='</tbody></table>';
    
    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 0, 0, true, 'C', true);   
    $pdf->LastPage();

     // Sediaan Barang Alat Tulis
    $pdf->AddPage(); 
  
    // set text shadow effect
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));    
  
    // Set some content to print

// Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true); 

    //untuk rekening baca baca
    $table ='<table style="width:560px;">';
    $table .='<thead style="width:560px; ">
            <tr>
                <th style="border:1px solid #000; font-weight:bold; width: 185px; text-align: center;" colspan="2">Biaya Lain-Lain</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">No Akun: 520</th>
                <th style="border:1px solid #000; font-weight:bold; width: 134px; text-align: center;" colspan="2">Saldo</th>
                <th rowspan="2" style="border:1px solid #000; font-weight:bold; width: 60px; text-align: center;">No Bukti</th>
            </tr>
            <tr>
                <th style="border:1px solid #000; width: 55px; text-align: center;">Tanggal</th>
                <th style="border:1px solid #000; width: 130px; text-align: center; ">Keterangan</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Debet</th>
                <th style="border:1px solid #000; width: 67px; text-align: center;">Kredit</th>
            </tr>
            </thead>';
            $saldoawal= $biayaLain[0]['SaldoAwal'];
            foreach($biayaLain as $key=>$value){
                if($key == 0){
                    $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">01-'.date("m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">Saldo Awal</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;"></td></tr>
                    ';
                }               
                $table.='<tr style="width:560px;">
                    <td style="border:1px solid #000; width: 55px; height: 30px;">'.date("d-m-Y",strtotime($value["Tanggal"])).'</td>
                    <td style="border:1px solid #000; width: 130px; height: 30px;">'.$value["Keterangan"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalDebet"].'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">'.$value["NominalKredit"].'</td>
                    ';
                $saldoawal = $saldoawal+$value["NominalDebet"]-$value['NominalKredit'];
                if($value['SaldoNormal']==1){
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
                else
                {
                    $saldoawal = $saldoawal+$value["NominalKredit"]-$value['NominalDebet'];
                    $table.='<td style="border:1px solid #000; width: 67px; height: 30px;">'.$saldoawal.'</td>
                    <td style="border:1px solid #000; width: 67px; height: 30px;">0</td>
                    <td style="border:1px solid #000; width: 60px height: 30px;">'.$value["NoBukti"].'</td>
                </tr>';
                }
            }
                    
    $table .='</tbody></table>';
    
    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 0, 0, true, 'C', true);   
    $pdf->LastPage();
    // Close and output PDF document
    // This method has several options, check the source code documentation for more information.
    ob_clean();
    $pdf->Output('LaporanBukuBesar.pdf', 'I');    
  
    //============================================================+
    // END OF FILE
    //============================================================+

?>