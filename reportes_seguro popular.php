
	//
	if($programa < 1)
	{
		$pdf->ezText(utf8_decode("<b>General</b>"),9,array('justification'=>'center'));
	}
	else
	{

	//if($programa > 1)

	//{

	$sql_f="SELECT c.*, f.descripcion as txt_programa FROM cont_poliza c LEFT JOIN fuente_financiamiento f ON f.id_fuente=c.programa ";
	$sql_foliador=$con->EjecutarConsulta($sql_f);
	if(mysql_num_rows($sql_foliador)>=1 ){
		//while($fila=mysql_fetch_array($sql_foliador)){
			 if ($programa = 1) {
			 	$programa = "costo Familiar";
			 	$subprograma = "No tiene";
			 }

			 if ($programa = 2) {
			 	$programa = "Seguro Popular";
			 }

			 $pdf->ezText(utf8_decode("<b>PROGRAMA: ".$programa." ".$anio."    SUBPROGRAMA: ".$subprograma."</b>"),9,array('justification'=>'center'));
			 //$pdf->ezSetDy(-10);		
		//}
	}

	//}
	}


if ($programa = 1) {
		$titulo_programa = "Costo Familiar";
		$pdf->ezText(utf8_decode("<b>PROGRAMA: ".$titulo_programa." ".$anio." </b>"),9,array('justification'=>'center'));
	}




if($programa){ $where=" AND id_programa='".$programa."'";  $where2=" AND programa='".$programa."'"; }
	if($subprograma){ $where=" AND id_sub ='".$subprograma."'"; $where2=" AND subprograma ='".$subprograma."'"; }
	if($id_folio){ $where=" AND c.id_folio ='".$id_folio."'"; }
	//
	$sql_f="SELECT c.*, f.descripcion as txt_programa FROM foliador_cheques c LEFT JOIN fuente_financiamiento f ON f.id_fuente=c.id_programa WHERE anio='".$anio."'".$where;
	//echo $sql_f;

	if($programa > 1)

	{

	$sql_foliador=$con->EjecutarConsulta($sql_f);
	if(mysql_num_rows($sql_foliador)>=1 ){
		while($fila=mysql_fetch_array($sql_foliador)){
			 $prog=$fila["id_programa"];
			 $sub=$fila["id_sub"];
			 $titulo_programa=$fila["txt_programa"];
			 $titulo_subprgrama=$fila["nom_sub"];
			 $pdf->ezText(utf8_decode("<b>PROGRAMA: ".$titulo_programa." ".$anio."    SUBPROGRAMA: ".$titulo_subprgrama."</b>"),9,array('justification'=>'center'));
			 //$pdf->ezSetDy(-10);		
		}
	}

	}