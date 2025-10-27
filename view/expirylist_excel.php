<?php
ini_set("include_path", 'phpexcel/');
require_once 'PHPExcel.php';
include_once "control/display_report.class.php";
$objPHPExcel = new PHPExcel();

$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('Times New Roman');
 	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
 	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
 	$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
 	$objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
 	
 	$sharedStyle1 = new PHPExcel_Style();
 	
 	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
 	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
 	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(5);
 	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
 	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
 	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
 	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
 	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
 	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
 	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
 	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
 	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(12);
 	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(12);
 	$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(12);
 	$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(12);
 	$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(30);
 	$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(12);
 	$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(30);
 	$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(12);
 
 	$sharedStyle1->applyFromArray(
 			array('fill' 	=> array(
 					'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
 					'color'		=> array('argb' => 'FFFFFF00')
 			),
 					'font'=>array(
 							'name'=>'Times New Roman',
 							'size'=>14,
 							'bold'=>true
 					),
 					'alignment'=>array(
 							'horizontal'=>PHPExcel_Style_Alignment::VERTICAL_CENTER
 					),
 	
 	
 			  'borders' => array(
 			  		'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
 			  		'right'		=> array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
 			  		'left'		=> array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
 			  		'top'		=> array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
 			  )
 			));
 	
 	$totalformat=
 	array(
 			'font'=>array(
 					'name'=>'Times New Roman',
 					'size'=>11,
 					'bold'=>true
 			),
 			'alignment'=>array(
 					'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
 			),
 	
 	
 			'borders' => array(
 					'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
 					'right'		=> array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
 					'left'		=> array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
 					'top'		=> array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
 			)
 	);
 	$totalborder=
 	array(
 			'font'=>array(
 					'name'=>'Times New Roman',
 					'size'=>11,
 					'bold'=>true
 			),
 			'alignment'=>array(
 					'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
 			),
 			'alignment'=>array(
 					'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
 			),
 			'numberformat'=>array(
 					'code'=>PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00
 			),
 	
 			'borders' => array(
 					'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
 					'right'		=> array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
 					'left'		=> array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
 					'top'		=> array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
 			)
 	);
 	
 	$companyformat = array(
 			'borders' => array(
 					'outline' => array(
 							'style' => PHPExcel_Style_Border::BORDER_THIN,
 							'color' => array('argb' => 'FF000000'),
 					),
 			),
 			'font'=>array(
 					'name'=>'Times New Roman',
 					'size'=>11,
 					'bold'=>true
 			),
 	);
 	
 	$tableheader = array(
 			'borders' => array(
 					'allborders' => array(
 							'style' => PHPExcel_Style_Border::BORDER_THIN,
 							'color' => array('argb' => 'FF000000'),
 					),
 						
 					'bottom'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
 			),
 	
 	
 	
 			'font'=>array(
 					'name'=>'Times New Roman',
 					'size'=>11,
 					'bold'=>true
 			),
 	);
 	$tableheader1 = array(
 			'borders' => array(
 					'allborders' => array(
 							'style' => PHPExcel_Style_Border::BORDER_THIN,
 							'color' => array('argb' => 'FF000000'),
 					),
 						
 					'bottom'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
 			),
 	
 			'alignment'=>array(
 					'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
 			),
 	
 			'font'=>array(
 					'name'=>'Times New Roman',
 					'size'=>11,
 					'bold'=>true
 	
 			),
 	);
 	
 	$datacell = array(
 			'borders' => array(
 					'allborders' => array(
 							'style' => PHPExcel_Style_Border::BORDER_THIN,
 							'color' => array('argb' => 'FF000000'),
 					),
 						
 					'bottom'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
 	
 			),
 	
 	
 	
 			'font'=>array(
 					'name'=>'Times New Roman',
 					'size'=>10,
 	
 			),
 	);
 	$datacell1 = array(
 			'borders' => array(
 					'allborders' => array(
 							'style' => PHPExcel_Style_Border::BORDER_THIN,
 							'color' => array('argb' => 'FF000000'),
 					),
 						
 					'bottom'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
 	
 			),
 	
 	
 	
 			'font'=>array(
 					'name'=>'Times New Roman',
 					'size'=>11,
 					'color' => array('argb' => 'FF0000'),
 					'bold'=>true
 			),
 	);
 	$tableborder = array(
 			'borders' => array(
 	
 						
 					'bottom'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
 					'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
 			),
 	
 	
 	
 			'font'=>array(
 					'name'=>'Times New Roman',
 					'size'=>11,
 					'bold'=>true
 			),
 	);
 	
 	$datacell_border = array(
 			'borders' => array(
 	
 						
 					'bottom'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
 					'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
 			),
 	
 			'alignment'=>array(
 					'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
 			),
 	
 			'font'=>array(
 					'name'=>'Times New Roman',
 					'size'=>10,
 	
 	
 			),
 			'numberformat'=>array(
 					'code'=>PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00
 			),
 	);
	$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($tableheader);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "DOCUMENT EXPIRY LIST");
	$i=2;
 	$previous_division = 0;
 	$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':H'.$i)->applyFromArray($tableheader);
 	$objPHPExcel->getActiveSheet()->getStyle('AH'.$i)->applyFromArray($tableborder);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, 'No');
 	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, 'Clientname');
 	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, 'Description/Tag No');
 	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$i, 'Category');
 	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$i, 'Sub Category');
 	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$i, 'Inspection Date');
 	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, 'Next Inspection');
 	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$i, 'Comments');
	$reslt = $display_report->getExpiredReportInfo();
	$total_rec = mysql_result(mysql_query("SELECT FOUND_ROWS()"),0,0);
	$objPHPExcel->getActiveSheet()->setTitle('Simple');
	$i++;
	$count=1;
 	while($row = $display_report->objCommonFunc->fetchAssoc($reslt)) {
		$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':H'.$i)->applyFromArray($datacell);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i,  $count);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i,  $row['client_name']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i,  $row['rep_desc']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$i,  $row['cat_name']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$i,  $row['subcat_name']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$i,  $display_report->objCommonFunc->sql2date($row['rep_insp_date']));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i,  $display_report->objCommonFunc->sql2date($row['rep_next_insp_date']));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$i,  $row['rep_comments']);
		$i++;
		$count++;
	}
 	
 	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
 	$objPHPExcel->setActiveSheetIndex(0);
 	
 	
 	// Redirect output to a client’s web browser (Excel5)
 	header('Content-Type: application/vnd.ms-excel');
 	header('Content-Disposition: attachment;filename="Employee Index"');
 	header('Cache-Control: max-age=0');
 	
 	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
 	$objWriter->save('php://output');
 	exit;
?>