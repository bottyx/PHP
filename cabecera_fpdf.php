<?php
require_once("clases/default/class_mysqlconnector.php");
$con2 = new class_mysqlconnector();
$con2->Conectar();
	$str_reporte = "SELECT * FROM reportes_pie_cabecera WHERE id = 1";
	$sql_reporte = $con2->EjecutarConsulta($str_reporte);
	$arr_reporte = mysql_fetch_array($sql_reporte);
	
	$str_escuela = "SELECT * FROM escuela WHERE id = 1";
	$sql_escuela = $con2->EjecutarConsulta($str_escuela);
	$row_escuela = mysql_fetch_array($sql_escuela);

	switch($tipo_reporte){
		case 'cedula':
			$title_reporte = 'CERTIFICADO CERTIFICADO CERTIFICADO CERTIFICADO';
			break;
		default: break;
	}
	$this->SetX(5);
	if($arr_reporte['logo_zona'] == 'C'){ 
		if($arr_reporte['logo_alineacion'] == 'I'){
			$horizontal == 1 ? $x = 20 : $x = 20;
		}elseif($arr_reporte['logo_alineacion'] == 'D'){
			$horizontal == 1 ? $x = 190 : $x = 190;
		}else{
			$horizontal == 1 ? $x = 100 : $x = 100;
		}
		$img = "images_config/".$arr_reporte['logo_reporte'];
		$horizontal == 1 ? $y = 8 : $y = 8;
		$this->Image($img,$x,$y,10);
	}
	
	if($arr_reporte['logo_zona'] == 'A'){ 
		$sp = split('\-',$arr_reporte['logo_alineacion']);
		if($sp[0] == 'I'){
			$horizontal == 1 ? $x = 20 : $x = 20;	
		}elseif($sp[0] == 'D'){
			$horizontal == 1 ? $x = 190 : $x = 190;
		}else{
			$horizontal == 1 ? $x = 100 : $x = 100;
		}
		$img = "images_config/".$arr_reporte['logo_reporte'];
		$horizontal == 1 ? $y = 6 : $y = 6;
		$this->Image($img,$x,$y,10);
	}
	
	if($arr_reporte['pag_zona'] == 'C'){ 
		if($arr_reporte['pag_alineacion'] == 'I'){
			$x = 30;	$align="L";
		}elseif($arr_reporte['pag_alineacion'] == 'D'){
			$x = 520; $align="R";
		}else{
			$x = 250;	$align="C";
		}
		//$this->SetY(900);
		$this->SetFont('Arial','',8);
		$this->Cell(0,10,'Pagina: '.$this->PageNo().'/{nb}',0,0,$align);
	}
	//$this->SetY(10);
	if($arr_reporte['cabecera_alineacion'] == 'I'){
		$align_cabecera = 'L';
	}elseif($arr_reporte['cabecera_alineacion'] == 'D'){
		$align_cabecera = 'R';
	}else{
		$align_cabecera = 'C';
	} 
	$this->SetX(5);
	$this->SetFont('Arial','B',12);
	$this->Cell(0, 5, "CERTIFICADO", 0, 0, $align_cabecera);
	//$this->Cell(0, 5, ($row_escuela['nombre']), 0, 0, $align_cabecera);
	$this->Ln(5);
	$this->SetFont('Arial','',10);
	$this->Cell(0, 5, ($title_reporte), 0, 0, 'C');
	$this->SetFont('Arial','',9);
	$this->Ln(2);
	$this->Cell(50);
	$this->Cell(100,2,'____________________________________________________________________________________',0,0,'C');
	if(empty($fecha_inicio) == false){
		$this->Ln(5);
		$this->SetFont('Arial','B',7);
		$this->Cell(0, 5, 'DEL '.$fecha_inicio.' AL '.$fecha_fin, 0, 0, 'C');
	}
	if(empty($subtitle_reporte) == false){
		$this->Ln(5);
		$this->SetFont('Arial','B',9);
		$this->Cell(0, 5, $subtitle_reporte, 0, 0, 'C');
	}

	//if($subtitle_reporte!=""){ $this->ezText($subtitle_reporte,8,array('justification'=>'center')); }
?>