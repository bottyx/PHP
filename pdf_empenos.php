<?php

header('Content-Type: text/html; charset=UTF-8');
    require_once('class.ezpdf.php');
	require("../clases/funciones_comunes.php");
	include("../clases/default/class_mysqlconnector.php");
	$con = new class_mysqlconnector();	

	$id_empeno=$_REQUEST["id_empeno"];

	// obtener datos de la cabecera

	$SQL = "SELECT e.*, DATE(e.fecha) AS fecha, (SELECT valor FROM configuracion WHERE id_configuracion =1) AS nombre_empresa, CONCAT(
			IF(r.d_calle IS NULL, '',CONCAT( 'Calle ',r.d_calle)),
			IF(r.d_num_ext IS NULL, '',CONCAT( ' No. ',r.d_num_ext)),
			IF(r.d_num_int IS NULL, '',CONCAT( ' Int. ',r.d_num_int)),	
			IF(r.d_cruzamientos IS NULL, '',CONCAT( ' POR ',r.d_cruzamientos)),
			IF(r.d_cp IS NULL, '',CONCAT( ' C.P. ',r.d_cp)),
			IF(r.d_colonia IS NULL, '',CONCAT( ' COL. ',r.d_colonia)),
			IF(r.d_id_localidad IS NULL, '',CONCAT( ', ',(SELECT UPPER(descripcion) FROM localidad WHERE id_localidad =r.d_id_localidad))),
			IF(r.d_id_municipio IS NULL, '',CONCAT( ', ',(SELECT UPPER(descripcion) FROM municipio WHERE id_municipio =r.d_id_municipio))),
			IF(r.d_id_estado IS NULL, '',CONCAT( ', ',(SELECT UPPER(descripcion) FROM estado WHERE id_estado =r.d_id_estado))),
			IF(r.d_pais IS NULL, '',CONCAT( ', ',r.d_pais))) AS direccion_sucursal,
	
			r.razon_social, r.rfc, CONCAT(c.nombre,' ',c.ap_paterno,' ',IF(c.ap_materno IS NULL, '',CONCAT( '',ap_materno))) AS cliente, CONCAT(
			IF(c.d_calle IS NULL, '',CONCAT( 'Calle ',c.d_calle)),
			IF(c.d_num_ext IS NULL, '',CONCAT( ' No. ',c.d_num_ext)),
			IF(c.d_num_int IS NULL, '',CONCAT( ' Int. ',c.d_num_int)),	
			IF(c.d_cruzamientos IS NULL, '',CONCAT( ' POR ',c.d_cruzamientos)),
			IF(c.d_cp IS NULL, '',CONCAT( ' C.P. ',c.d_cp)),
			IF(c.d_colonia IS NULL, '',CONCAT( ' COL. ',c.d_colonia)),
			IF(c.d_id_localidad IS NULL, '',CONCAT( ', ',(SELECT UPPER(descripcion) FROM localidad WHERE id_localidad =c.d_id_localidad))),
			IF(c.d_id_municipio IS NULL, '',CONCAT( ', ',(SELECT UPPER(descripcion) FROM municipio WHERE id_municipio =c.d_id_municipio))),
			IF(c.d_id_estado IS NULL, '',CONCAT( ', ',(SELECT UPPER(descripcion) FROM estado WHERE id_estado =c.d_id_estado))),
			IF(c.d_pais IS NULL, '',CONCAT( ', ',c.d_pais))) as direccion_cliente, c.ife,
			 p.interes_ordinario, p.interes_almacenaje, e.cat, DATE_FORMAT(e.fecha_vencimiento, '%d/%m/%Y') AS fecha_vence, DATE_FORMAT(e.fecha_siguiente_pago, '%d/%m/%Y') AS fecha_sigpago, DATE_FORMAT(ADDDATE(e.fecha_vencimiento, (SELECT valor FROM configuracion WHERE id_configuracion=17)),'%d/%m/%Y') AS fecha_comercializacion, interes_ordinario, interes_almacenaje,(SELECT valor FROM configuracion WHERE id_configuracion=16) AS perdida, p.cargo_atraso, pt.nombre as nombre_interes,  IF(e.aplica_iva=1, CONCAT(s.porcentaje_iva,'%/INTERES Y ALMACENAJE'), CONCAT('NO APLICA')) AS iva,(SELECT valor FROM configuracion WHERE id_configuracion=20) AS comision
			FROM empenos e
			LEFT JOIN razon_social_sucursal rss ON rss.id_sucursal = e.id_sucursal
			LEFT JOIN sucursales s ON s.id_sucursal = rss.id_sucursal
			LEFT JOIN razones_sociales r ON r.id_razon_social = rss.id_razon_social
			LEFT JOIN planes_empeno p ON p.id_plan_empeno = e.id_plan_empeno
			LEFT JOIN periodos_tiempo pt ON pt.id_periodo_tiempo = p.id_periodo_interes
			LEFT JOIN clientes c ON c.id_cliente = e.id_cliente
			WHERE id_empeno ='".$id_empeno."'";
	
	$result=$con->EjecutarConsulta($SQL);
	$f= mysql_fetch_array($result);
	//GENERANDO PDF
	$pdf = new Cezpdf("LETTER", 'portrait');
//	$pdf = new Cezpdf("MEDIA", 'landscape');	
	$euro_diff = array(193=>'Aacute',201=>'Eacute',205=>'Iacute',211=>'Oacute',218=>'Uacute',225=>'aacute',233=>'eacute',237=>'iacute',243=>'oacute',250=>'uacute',241=>'ntilde',209=>'Ntilde');
	$pdf->selectFont('../clases/fonts/Helvetica.afm',array('encoding'=>'WinAnsiEncoding','differences'=>$euro_diff));	
	//TAMA�O DE LETRA
	$font_size = 8; 
	// GENERAR CABECERA.
	$all = $pdf->openObject();
	$pdf->saveState();
	//$pdf->ezStartPageNumbers(547,704,10,'','','1');
	//$pdf->ezText("FOLIO NO.: ".$f["numero_contrato"],$font_size+2 , array('left'=>400));
	//$pdf->ezText("FECHA DE CELEBRACION DEL CONTRATO: ".fecha_larga($f["fecha"]),$font_size+2);
	$pdf->ezSetDy(-30);	
	$pdf->restoreState();
	$pdf->closeObject();
	$pdf->addObject($all,'all');	
	// FIN DE CABECERA
	
	//MARGEN EN CENTIMETROS
	$pdf->ezSetCmMargins(1,1,1,1);

	
	// POSITIVO SE VA HACIA ARRIBA, NEGATIVO SE BAJA
	// SALTO DE LINEA
	$pdf->ezSetDy(18);

	///contenido 
	$pdf->ezSetDy(-10);
	$pdf->ezText("FOLIO NO.: ".$f["numero_contrato"],$font_size+2 , array('left'=>400));
	$pdf->ezText("FECHA DE CELEBRACION DEL CONTRATO: ".fecha_larga($f["fecha"]),$font_size+2);

	$texto = "CONTRATO MUTUO CON GARANT�A PRENDARIA QUE CELEBRAN ".utf8_decode($f["nombre_empresa"]).", 'EL PROVEEDOR', CON DOMICILIO EN: ".utf8_decode($f["direccion_sucursal"]).
	", ".utf8_decode($f["razon_social"])." CON R.F.C. ".utf8_decode($f["rfc"]).", TEL: ".utf8_decode($f["telefono"]).", CORREO ELECTRONICO".utf8_decode($f["email"])." Y 'EL CONSUMIDOR' ".utf8_decode($f["cliente"]).
	", QUE  ";

	if($f["ife"]==''){

		$texto .= "NO PRESENTA INDENTIFICACION ";

	}else{

		$texto .= "SE IDENTIFICA CON IFE ".$f["ife"];

	}

	$spacing = .9;

	$texto .= " NUMERO".utf8_decode($f["d_calle"]).", CON DOMICILIO EN: ".utf8_decode($f["direccion_cliente"]).", TEL".utf8_decode($f["telefono_movil"]).", CORREO ELECTRONICO: ".utf8_decode($f["email"])." QUIEN DESIGNA COMO COTITULAR A: ".utf8_decode($f["cotitular"])." CON DOMICILIO EN "
	.utf8_decode($f["direccion_cliente"]).". Y BENEFICIARIO A: ".utf8_decode($f["beneficiario"])." SOLO PARA EFECTOS DE ESTE CONTRATO";

	$pdf->ezText(strtoupper($texto),$font_size, array( 'justification'=>'full',  'spacing' =>$spacing));
	$pdf->ezText("",$font_size, array( 'spacing' =>$spacing));
	$pdf->ezText("",$font_size, array( 'spacing' =>$spacing));
	$pdf->ezText("",$font_size, array( 'spacing' =>$spacing));

	//$pdf->ezText("DESCRIPCION DE LA(S) PRENDA(S): ",$font_size, array( 'aleft'=>250,  'spacing' =>$spacing));
	
	$titles=array('DESCRIP'=>'CAT, COSTO ANUAL TOTAL','CLASIF'=>'TASA DE INTERES ANUAL','PORCENTAJE'=>'MONTO DEL PRESTAMO (MUTUO)','AVALUO'=>'MONTO TOATL A APAGAR','PRESTAMO'=>'COMISIONES');

	$options= array('shaded'=>0,'xPos'=>311,'showHeadings'=>1,'rowGap' => $spacing,
					'showLines'=>1,'fontSize' =>$font_size,'cols'=>array(
							'DESCRIP'=>array('justification'=>'left','width'=>70),
							'CLASIF'=>array('justification'=>'left','width'=>70),
							'PORCENTAJE'=>array('justification'=>'right','width'=>60),							
							'AVALUO'=>array('justification'=>'right','width'=>50),
							'PRESTAMO'=>array('justification'=>'right','width'=>300)
						));


	$sql_detalle = "SELECT * FROM (
					SELECT de. porcentaje_prestamo_avaluo, consecutivo as num, t.descripcion as tipo, CONCAT('') AS clasificacion,
					CONCAT( IF(v.descripcion IS NOT NULL, v.descripcion, '' ), ' ', IF(iv.id_marca_vehiculo>0,(SELECT marca FROM marcas_vehiculo vm WHERE vm.id_marca_vehiculo = iv.id_marca_vehiculo), ''), ' ', IF(iv.id_modelo_vehiculo >0, (SELECT modelo FROM modelos_vehiculo mv WHERE mv.id_modelo_vehiculo = iv.id_modelo_vehiculo),''), ' ', IF(iv.anio >0, iv.anio, ''), IF(iv.numero_factura IS NOT NULL, CONCAT(' No. Factura: ', iv.numero_factura),''), IF(iv.numero_serie IS NOT NULL, CONCAT(' No. Serie:', iv.numero_serie), ''), IF(iv.placas IS NOT NULL, CONCAT(' Placas: ', iv.placas),''), ' ', IF(iv.id_color >0 ,(SELECT nombre FROM colores c WHERE c.id_color = iv.id_color), ''), ' ', IF(de.id_calificacion >0, (SELECT calificacion FROM calificaciones c WHERE c.id_calificacion = de.id_calificacion), ''), ' ', IF(i.descripcion IS NOT NULL, i.descripcion,''), ' ', IF(iv.detalles IS NOT NULL, iv.detalles,'')) as descripcion ,avaluo as avaluo, prestamo as prestamo 
					FROM detalle_empeno de 
					LEFT JOIN inventario i ON de.id_producto = i.id_producto
					LEFT JOIN inventario_vehiculos iv ON i.id_producto = iv.id_producto
					INNER JOIN tipos_producto t ON i.id_tipo_producto = t.id_tipo_producto
					INNER JOIN tipos_vehiculo v ON iv.id_tipo_vehiculo = v.id_tipo_vehiculo
					WHERE de.id_empeno='".$id_empeno."'
										
					UNION
					
				    SELECT de. porcentaje_prestamo_avaluo,  consecutivo AS num, t.descripcion AS tipo, clasificacion, CONCAT(IF(im.id_joyeria >0,(SELECT nombre FROM joyeria j WHERE j.id_joyeria = im.id_joyeria), ''), ' ', IF(im.id_metal >0,(SELECT nombre FROM metales m WHERE m.id_metal = im.id_metal),''), ' ', IF( im.peso_gramos IS NOT NULL, CONCAT(im.peso_gramos,' gr '), ''),  IF(de.id_calificacion >0, (SELECT calificacion FROM calificaciones c WHERE c.id_calificacion = de.id_calificacion),''), ' ',  IF(i.descripcion IS NOT NULL, i.descripcion, '')) AS descripcion, avaluo AS avaluo, prestamo AS prestamo 
					FROM detalle_empeno de
					LEFT JOIN inventario i ON de.id_producto = i.id_producto
					LEFT JOIN inventario_metales im ON i.id_producto = im.id_producto
					INNER JOIN tipos_producto t ON i.id_tipo_producto = t.id_tipo_producto
					INNER JOIN metales m ON im.id_metal = m.id_metal
					WHERE de.id_empeno='".$id_empeno."'
					
					UNION 
					SELECT de. porcentaje_prestamo_avaluo, consecutivo as num, t.descripcion as tipo, kilataje AS clasificacion, CONCAT(IF(p.nombre IS NOT NULL, p.nombre,''),' ', IF(ip.corte IS NOT NULL, ip.corte,''), ' ', IF(ip.id_color >0, (SELECT nombre FROM colores c WHERE c.id_color = ip.id_color), ''), ' ', IF( ip.puntos IS NOT NULL, CONCAT(ip.puntos, ' ptos '), ''),  IF(de.id_calificacion >0, (SELECT calificacion FROM calificaciones c WHERE c.id_calificacion = de.id_calificacion), ''), ' ', IF(i.descripcion IS NOT NULL, i.descripcion, '')) AS descripcion ,avaluo as avaluo, prestamo as prestamo 
					FROM detalle_empeno de 
					LEFT JOIN inventario i ON de.id_producto = i.id_producto
					LEFT JOIN inventario_piedras ip ON i.id_producto = ip.id_producto
					INNER JOIN tipos_producto t ON i.id_tipo_producto = t.id_tipo_producto
					INNER JOIN piedras p ON ip.id_piedra = p.id_piedra
					WHERE de.id_empeno='".$id_empeno."'
					
					UNION 
					SELECT de. porcentaje_prestamo_avaluo,  consecutivo as num, t.descripcion as tipo, CONCAT('') AS clasificacion, CONCAT(IF(a.descripcion IS NOT NULL, a.descripcion, ''),' ', IF( ia.id_marca_articulo >0, (SELECT marca FROM marcas_articulo ma WHERE ma.id_marca_articulo = ia.id_marca_articulo), ''), ' ', IF(ia.id_modelo_articulo >0, (SELECT nombre FROM modelos_articulo ma WHERE ma.id_modelo_articulo = ia.id_modelo_articulo), ''), IF(ia.numero_serie IS NOT NULL , CONCAT(' No. Serie: ', ia.numero_serie),''), ' ', IF(ia.id_color >0, (SELECT nombre FROM colores c WHERE c.id_color = ia.id_color), ''), ' ', IF(de.id_calificacion >0, (SELECT calificacion FROM calificaciones c WHERE c.id_calificacion = de.id_calificacion),''), ' ', IF(i.descripcion IS NOT NULL, i.descripcion, '')) AS descripcion ,avaluo as avaluo, prestamo as prestamo FROM detalle_empeno de 
					LEFT JOIN inventario i ON de.id_producto = i.id_producto
					LEFT JOIN inventario_articulos ia ON i.id_producto = ia.id_producto
					INNER JOIN tipos_producto t ON i.id_tipo_producto = t.id_tipo_producto
					INNER JOIN tipos_articulo a ON ia.id_tipo_articulo = a.id_tipo_articulo
					WHERE de.id_empeno='".$id_empeno."'
								
					)A
					ORDER BY A.num ASC ";

	$result_detalle=$con->EjecutarConsulta($sql_detalle);
	$total_avaluo = 0;
	$total_prestamo =0;
	while ($row= mysql_fetch_array($result_detalle)){
		$total_avaluo += $row["avaluo"];
		$total_prestamo +=$row["prestamo"];
		$data[]=array('DESCRIP'=>strtoupper(utf8_decode($row["descripcion"])),'CLASIF'=>$row["clasificacion"],'PORCENTAJE'=>$row["porcentaje_prestamo_avaluo"],'AVALUO'=>number_format($row["avaluo"],2,'.',','),'PRESTAMO'=>number_format($row["prestamo"],2,'.',','));	
	}

	$data[]=array('DESCRIP'=>'', 'CLASIF'=>'','PORCENTAJE'=>'TOTALES', 'AVALUO'=>number_format($total_avaluo,2,'.',','),'PRESTAMO'=>number_format($total_prestamo,2,'.',','));	
	$pdf->ezSetDy(-5);
	$pdf->ezTable($data,$titles,'',$options);
	unset($data);


	$titles2=array('COL1'=>'','COL2'=>'','COL3'=>'');
	$options2= array('shaded'=>0,'xPos'=>'310','showHeadings'=>0,  'colGap' => 3, 'rowGap' => $spacing,
					'showLines'=>1,'fontSize' =>$font_size,'cols'=>array(
					'COL1'=>array('justification'=>'left','width'=>180),
					'COL2'=>array('justification'=>'left','width'=>190),
					'COL3'=>array('justification'=>'left','width'=>200)
						));
	
	
	/*$data[] = array('COL1'=>'INTER�S '.strtoupper($f["nombre_interes"]).': '.$f["interes_ordinario"]."%/PR�STAMO",'COL2'=>'ALMACENAJE: '.$f["interes_almacenaje"]."%/PR�STAMO",'COL3'=>'FECHA VENCIMIENTO: '.$f["fecha_sigpago"]);
	$data[] = array('COL1'=>'MORATORIO:'.$f["cargo_atraso"]."% X DIA/PR�STAMO",'COL2'=>'CAT: '.$f["cat"]."% DE CARACTER INFORMATIVO",'COL3'=>'LIMITE REFRENDO/DESEMPE�O: '.$f["fecha_vence"]);
	$data[] = array('COL1'=>'IVA: '.$f["iva"],'COL2'=>'P�RDIDA DEL CONTRATO: '.$f["perdida"]." PESOS",'COL3'=>'FECHA COMERCIALIZACI�N: '.$f["fecha_comercializacion"]);
	$data[] = array('COL1'=>'','COL2'=>'COMISI�N POR VENTA: '.$f["comision"]."%",'COL3'=>'');
	*/
	$pdf->ezText("",$font_size, array('justification'=>'full',  'spacing' =>$spacing));
	$pdf->ezText("Metodolog�a de c�lculo de inter�s: tasa de inter�s anual fija dividida entre 360 d�as por el importe del saldo insoluto del pr�stamo por el n�mero de d�as efectivamente transcurridos.",$font_size, array('justification'=>'full',  'spacing' =>$spacing));
	$pdf->ezText("----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------",$font_size, array('justification'=>'full',  'spacing' =>$spacing));
	$pdf->ezText("Plazo del pr�stamo (fecha l�mite para el refrendo o desempe�o): ".$f["fecha_vence"].".",$font_size, array('justification'=>'full',  'spacing' =>$spacing));


	$pdf->ezSetDy(-5);
	$pdf->ezTable($data,$titles2,'',$options2);
	unset($data);


	$titles3=array('OPCIONES'=>'','NUMERO'=>'N�MERO','IMPORTE'=>'IMPORTE DEL MUTUO','INTERESES'=>'INTERESES','ALMACENAJE'=>'ALMACENAJE','IVA'=>'IVA','REFRENDO'=>'POR REFRENDO','DESEMPE�O'=>'POR DESEMPE�O','PAGOS'=>'CUANDO SE REALIZAN LOS PAGOS');

	$options3= array('shaded'=>0,'xPos'=>311,'showHeadings'=>1,'rowGap' => $spacing,
					'showLines'=>1,'fontSize' =>$font_size,'cols'=>array(
							'OPCIONES'=>array('justification'=>'left','width'=>70),
							'NUMERO'=>array('justification'=>'left','width'=>70),
							'IMPORTE'=>array('justification'=>'right','width'=>60),							
							'INTERESES'=>array('justification'=>'right','width'=>50),
							'ALMACENAJE'=>array('justification'=>'right','width'=>70),
							'IVA'=>array('justification'=>'right','width'=>70),
							'REFRENDO'=>array('justification'=>'right','width'=>70),
							'DESEMPE�O'=>array('justification'=>'right','width'=>70),
							'PAGOS'=>array('justification'=>'right','width'=>70)
						));

$result_detalle=$con->EjecutarConsulta($sql_detalle);
	$total_avaluo = 0;
	$total_prestamo =0;
	/*while ($row= mysql_fetch_array($result_detalle)){
		$total_avaluo += $row["avaluo"];
		$total_prestamo +=$row["prestamo"];
		$data[]=array('OPCIONES'=>strtoupper(utf8_decode($row["0"])),'NUMERO'=>$row["0"],'IMPORTE'=>$row["porcentaje_prestamo_avaluo"],'INTERESES'=>number_format($row["interes_ordinario"]),'ALMACENAJE'=>number_format($row["interes_almacenaje"]),'IVA'=>number_format($row["iva"]),'REFRENDO'=>number_format($row["0"]),'EMPE�O'=>number_format($row["0"]),'PAGOS'=>number_format($row["0"]);	
	}*/

	$data[]=array('DESCRIP'=>'', 'CLASIF'=>'','PORCENTAJE'=>'TOTALES', 'AVALUO'=>number_format($total_avaluo,2,'.',','),'PRESTAMO'=>number_format($total_prestamo,2,'.',','));	
	$pdf->ezSetDy(-5);
	$pdf->ezTable($data,$titles3,'',$options3);
	unset($data);


	$titles5=array('CMT'=>'COSTO MENSUAL TOTAL','CDT'=>'COSTO DIARIO TOTAL');

	$options5= array('shaded'=>0,'xPos'=>311,'showHeadings'=>1,'rowGap' => $spacing,
					'showLines'=>1,'fontSize' =>$font_size,'cols'=>array(
							'CMT'=>array('justification'=>'left','width'=>300),
							'CDT'=>array('justification'=>'right','width'=>300)
						));


	

/*$result_detalle=$con->EjecutarConsulta($sql_detalle);
	$total_avaluo = 0;
	$total_prestamo =0;/*
	/*while ($row= mysql_fetch_array($result_detalle)){
		$total_avaluo += $row["avaluo"];
		$total_prestamo +=$row["prestamo"];
		$data[]=array('OPCIONES'=>strtoupper(utf8_decode($row["0"])),'NUMERO'=>$row["0"],'IMPORTE'=>$row["porcentaje_prestamo_avaluo"],'INTERESES'=>number_format($row["interes_ordinario"]),'ALMACENAJE'=>number_format($row["interes_almacenaje"]),'IVA'=>number_format($row["iva"]),'REFRENDO'=>number_format($row["0"]),'EMPE�O'=>number_format($row["0"]),'PAGOS'=>number_format($row["0"]);	
	}*/

	//$data1[]=array('CMT'=>'COSTO MENSUAL TOTAL', 'CDT'=>'COSTO DIARIO TOTAL','PORCENTAJE'=>'TOTALES', 'AVALUO'=>number_format($total_avaluo,2,'.',','),'PRESTAMO'=>number_format($total_prestamo,2,'.',','));	
	$pdf->ezSetDy(-5);
	$pdf->ezTable($data1,$titles5,'',$options5);
	$pdf->ezText("",$font_size, array('justification'=>'full',  'spacing' =>$spacing));
	$pdf->ezText("Cuide su capacidad de pago, generalmente no debe de exceder del 35% de sus ingresos",$font_size, array('justification'=>'full',  'spacing' =>$spacing));
	$pdf->ezText("Si usted no paga en tiempo y forma corre el riesgo de perder sus prendas",$font_size, array('justification'=>'full',  'spacing' =>$spacing));	
	$pdf->ezText("----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------",$font_size, array('justification'=>'full',  'spacing' =>$spacing));
	$pdf->ezText("Autorizaci�n: Los datos personales pueden utilizarse para mercadeo: ( ) S� ( ) NO",$font_size, array('justification'=>'full',  'spacing' =>$spacing));
	$pdf->ezText("GARANT�A: Para garantizar el pago de este pr�stamo, el consumidor deja en garant�a el bien que se describe a continuaci�n:",$font_size, array('justification'=>'full',  'spacing' =>$spacing));

	unset($data);


	/*$titles6=array('DP'=>'DESCRIPCION DE LA PRENDA');

	$options6= array('shaded'=>0,'xPos'=>311,'showHeadings'=>1,'rowGap' => $spacing,
					'showLines'=>1,'fontSize' =>$font_size,'cols'=>array(
							'DP'=>array('justification'=>'left','width'=>300)
						));
	
	$pdf->ezSetDy(-5);
	$pdf->ezTable($data6,$titles6,'',$options6);
	unset($data6);*/

	$titles7=array('CARAC'=>'CARACTERISTICAS','AVA'=>'AVALUO','PRES'=>'PRESTAMO','PA'=>'%PRESTAMO SOBRE AVAL�O');

	$options7= array('shaded'=>0,'xPos'=>311,'showHeadings'=>1,'rowGap' => $spacing,
					'showLines'=>1,'fontSize' =>$font_size,'cols'=>array(
							'CARAC'=>array('justification'=>'left','width'=>100),
							'AVA'=>array('justification'=>'left','width'=>100),
							'PRES'=>array('justification'=>'left','width'=>100),
							'PA'=>array('justification'=>'left','width'=>100),
						));
	$data7[]=array('CARAC'=>'CARACTERISTICAS', 'AVA'=>'AVALUO','PRESS'=>'PRESTAMO');	
	$pdf->ezSetDy(-5);
	$pdf->ezTable($data7,$titles7,'',$options7);
	unset($data7);


	

	$titles4=array('CM'=>'','CD'=>'');

	$options4= array('shaded'=>0,'xPos'=>311,'showHeadings'=>0,'rowGap' => $spacing,
					'showLines'=>0,'fontSize' =>5.5,'cols'=>array(
							'CM'=>array('justification'=>'left','width'=>300),
							'CD'=>array('justification'=>'left','width'=>300)
						));


	$COL1 = "CONTRATO DE MUTUO CON INTER�S Y GARANT�A PRENDARIA (PR�STAMO) QUE CELEBRAN POR UNA PARTE �EL PROVEEDOR� CUYO NOMBRE APARECE EN EL RUBRO DE LA CAR�TULA, REPRESENTADO EN ESTE ACTO POR SU REPRESENTANTE LEGAL________________________, Y POR LA OTRA, LA PERSONA CUYO NOMBRE Y DOMICILIO APARECE EN LA CAR�TULA, A QUIEN EN LO SUCESIVO Y PARA EFECTOS DEL PRESENTE CONTRATO SE LE DENOMINAR� �EL CONSUMIDOR�; LAS PARTES SE SUJETAN AL TENOR DE LAS SIGUIENTES DECLARACIONES Y CL�USULAS:
D E C L A R A C I O N E S:
I.- Declara �EL PROVEEDOR�:

A) Ser una persona f�sica de nacionalidad mexicana, con capacidad legal para celebrar el presente contrato.
B) Que el domicilio, tel�fono, Registro Federal de Contribuyentes y correo electr�nico del EL PROVEEDOR se encuentran en la car�tula del presente contrato.
C) Que cuenta con la capacidad, infraestructura, servicios, recursos necesarios y personal debidamente capacitado, para dar cabal cumplimiento a las obligaciones derivadas del presente contrato.
II.- DECLARA �EL CONSUMIDOR�:
A) Llamarse como ha quedado plasmado en el proemio de este contrato.
B) Que manifiesta su voluntad para obligarse en los t�rminos y condiciones del presente contrato, y que cuenta con la capacidad legal para la celebraci�n del mismo.
C) Que su domicilio, tel�fono y correo electr�nico se encuentran se�alados en la car�tula del presente contrato.
D) El consumidor manifiesta bajo protesta en decir verdad que es el legal, leg�timo e indiscutible propietario de la prenda que entrega en garant�a de este contrato, y de todo cuanto en derecho, uso y costumbre corresponden y que puede acreditar dicha calidad jur�dica ante terceros y/o cualquier autoridad que lo requiera.
Expuesto lo anterior, las partes se sujetan al contenido de las siguientes:
C L � U S U L A S
1.- Objeto.- EL PROVEEDOR entrega a EL CONSUMIDOR la cantidad de dinero en efectivo, equivalente al porcentaje de la valuaci�n que se ha practicado a la prenda, en calidad de mutuo mercantil con inter�s y garant�a prendar�a (pr�stamo) y EL CONSUMIDOR, se obliga, al t�rmino del contrato, a pagar al PROVEEDOR, la totalidad del pr�stamo, m�s los intereses, y las comisiones que se estipulan en la car�tula del presente contrato.
2.- Prenda. Con objeto de garantizar el cumplimiento de todas y cada una de las obligaciones derivadas de este contrato, EL CONSUMIDOR entregar� a EL PROVEEDOR a t�tulo de prenda, el o los bienes muebles usados que se describen en la car�tula del presente contrato, en el entendido de que esta entrega de ninguna manera convierte a EL PROVEEDOR en propietario de la prenda, ni implica el reconocimiento por parte de �ste, de que tal bien sea propiedad de EL CONSUMIDOR ni compromete, ni limita los derechos que terceras personas pudieran tener sobre el mismo.
3.- Valor de la prenda.- El valor de la prenda es el que se plasma en la car�tula del presente contrato, ambas partes reconocen que el mismo es resultado de un aval�o practicado por EL PROVEEDOR, con la autorizaci�n y conformidad de EL CONSUMIDOR.
4.- Obligaciones. EL CONSUMIDOR y EL PROVEEDOR aceptan y se obligan expresamente durante la vigencia del contrato a lo siguiente:
CONSUMIDOR.
a) Cumplir con todas las obligaciones derivadas del presente contrato.
b) Notificar a EL PROVEEDOR, dentro de un plazo que no exceda de 10 d�as naturales, siguientes a partir de aquel en que haya tenido conocimiento de la existencia de cualquier acci�n, demanda, litigio o procedimiento en su contra, que comprometan a la prenda.
c) No enajenar, gravar, o comprometer los bienes entregados en garant�a prendar�a, mientras est� vigente el presente contrato.
d) EL CONSUMIDOR no podr� en ning�n momento y por ning�n motivo, ceder, dar en prenda, o traspasar, a t�tulo gratuito, oneroso, total o parcialmente los derechos y obligaciones que le deriven de este contrato, ni el derecho a la propiedad o a la posesi�n de los bienes otorgados en garant�a prendaria (prenda), sin el consentimiento expreso y por escrito de EL PROVEEDOR.
PROVEEDOR.
a) EL PROVEEDOR se compromete a no usar el objeto otorgado en prenda como garant�a del mutuo, por lo que �nicamente tendr� la guarda y custodia de la prenda.
b) EL PROVEEDOR har� la guarda y custodia de la prenda en los t�rminos de lo dispuesto en el art�culo 2876 fracci�n I del C�digo Civil Federal; en ning�n caso ser� responsable de los da�os y deterioros que pudiere sufrir por el simple transcurso del tiempo.
c) EL PROVEEDOR deber� informar al CONSUMIDOR el Costo Anual Total (CAT), el Costo Mensual Total (CMT) y el Costo Diario Total (CDT) al momento de la celebraci�n del presente contrato.
5.- Defensa de la Prenda.- Si EL PROVEEDOR fuere perturbado en la posesi�n de la prenda, por causas imputables a EL CONSUMIDOR, avisar� por escrito a este �ltimo, en un plazo que no exceda de tres d�as naturales para que lleve a cabo las acciones legales pertinentes; si �ste no cumpliere con esta obligaci�n ser� responsable de todos los da�os y perjuicios causados.
6.- Reposici�n de la Prenda. Si en el cumplimiento de mandato leg�timo de autoridad competente, EL PROVEEDOR fuere despose�do de la prenda, EL CONSUMIDOR le entregar� a su entera satisfacci�n otra prenda equivalente en peso, calidad, contenido, modelo, marca y valor, dentro de los 10 d�as naturales siguientes a la notificaci�n que por escrito haga EL PROVEEDOR. En caso de omisi�n por parte de EL CONSUMIDOR a la mencionada notificaci�n, desde este momento ambas partes acuerdan que sus derechos quedan a salvo para que �ste �ltimo los haga valer en la forma y v�a que considere convenientes.
7.- Procedimiento para la Restituci�n de la Prenda para el Caso de P�rdida o Deterioro. En caso de p�rdida o deterioro de la cosa dada en prenda, EL PROVEEDOR deber� contar con una garant�a suficiente que le permita resarcir el siniestro, debiendo seguir el siguiente procedimiento:
a) EL PROVEEDOR deber� notificar a EL CONSUMIDOR, en un plazo que no exceda de 3 d�as naturales, siguientes de ocurrido el siniestro, por v�a telef�nica, correo electr�nico, correo certificado, listas y/o anuncios publicados en el establecimiento de EL PROVEEDOR.
b) EL CONSUMIDOR, deber� presentarse en el establecimiento donde firm� el contrato, en d�as y horas de servicio indicados en la car�tula, o en el domicilio fiscal del proveedor, con la siguiente documentaci�n:
1) Contrato de adhesi�n,
2) Identificaci�n de EL CONSUMIDOR, COTITULAR Y/O BENEFICIARIO.
c) EL PROVEEDOR recibir� la documentaci�n anterior, y le dar� al consumidor un comprobante en el cual se har� la descripci�n de los documentos presentados, as� como de la prenda motivo de la reclamaci�n, misma que deber� coincidir con la establecida en el contrato, indicando el valor de la prenda conforme al avalu� practicado. El comprobante deber� de contener n�mero de reclamaci�n, raz�n social del proveedor, RFC., domicilio, nombre y firma de quien recibe la reclamaci�n.
d) El PROVEEDOR se obliga a restituir o pagar la prenda, a elecci�n de EL CONSUMIDOR, en el t�rmino de 10 d�as naturales siguientes a la entrega de la documentaci�n por parte de este �ltimo.
e) EL PROVEEDOR pagar� al CONSUMIDOR el valor de la prenda conforme al aval�o realizado y que est� estipulado en la car�tula de este contrato, del cual se disminuir� la cantidad entregada por concepto de mutuo, los intereses y el almacenaje que se hayan devengado hasta la fecha de ocurrido el siniestro y conforme a los porcentajes que se indica en la car�tula. EL PROVEEDOR podr� realizar el pago en efectivo o mediante la entrega de un bien equivalente en modelo, marca, calidad, contenido, peso y valor a elecci�n del CONSUMIDOR; en ambos casos EL PROVEEDOR deber� pagar un 20% sobre el valor del aval�o, como pena convencional, siempre y cuando el siniestro haya ocurrido por negligencia de �ste.
Trat�ndose de metales preciosos, el valor de reposici�n del bien no podr� ser inferior al valor real que tenga el metal en el mercado al momento de la reposici�n.
8. Costo Anual Total (CAT).- Es el costo de financiamiento que para fines informativos y de comparaci�n, incorpora la totalidad de los costos y gastos del pr�stamo. El referido Costo Anual Total se calcular� utilizando la metodolog�a establecida por el Banco de M�xico, vigente en la fecha del c�lculo respectivo.
Para el c�lculo de Costo Mensual Total (CMT) y del Costo Diario Total (CDT) se utilizar� la misma metodolog�a que se aplica para el c�lculo del CAT establecida por el Banco de M�xico, ajustando los valores de intervalo de tiempo que correspondan para el tipo de pr�stamo que se trate, vigente en la fecha del c�lculo respectivo.
9.- Intereses.- Metodolog�a c�lculo de inter�s ordinario.- El pr�stamo causar� una tasa de inter�s fija del porcentaje anual mencionado en la car�tula, sobre saldos insolutos m�s el Impuesto al Valor Agregado (IVA) cuando corresponda; el c�lculo de intereses se realizar� multiplicando el saldo insoluto del pr�stamo, por la tasa de inter�s dividido entre 360 d�as por a�o, multiplicando por el n�mero de d�as transcurridos. La tasa de inter�s as� como su metodolog�a de c�lculo no podr�n modificarse durante la vigencia del presente contrato.
10.- Comisiones.- EL CONSUMIDOR se obliga, en su caso, a pagar a EL PROVEEDOR:
a).-Comisi�n por Almacenaje: El m�todo de c�lculo de comisi�n por almacenaje se realizar� multiplicando el saldo insoluto del pr�stamo otorgado, por la tasa de almacenaje diaria que aparece en la car�tula de este contrato, m�s el Impuesto al Valor Agregado, por el n�mero de d�as efectivamente transcurridos.
b).-Comisi�n por Comercializaci�n: Si EL CONSUMIDOR no cumpliese con el pago oportuno de la obligaci�n principal, intereses y comisiones estipuladas en el presente contrato, EL PROVEEDOR proceder� a comercializar el bien otorgado en garant�a prendar�a descrito en este contrato, con lo que EL CONSUMIDOR queda obligado a pagar a EL PROVEEDOR una comisi�n por el porcentaje detallado en la car�tula, sobre el monto del pr�stamo.
";
$COL2="c).- Comisi�n por Reposici�n del Contrato.- El PROVEEDOR cobrar� al CONSUMIDOR por Reposici�n de Contrato, el monto que se menciona en la car�tula. La solicitud de reposici�n deber� hacerse por escrito y presentado identificaci�n.
d).- Desempe�o Extempor�neo.- EL PROVEEDOR cobrar� al CONSUMIDOR por concepto de desempe�o extempor�neo lo se�alado en la car�tula del presente contrato.
EL PROVEEDOR no podr� modificar las comisiones, ni la metodolog�a de c�lculo estipuladas en este contrato durante la vigencia del mismo.
11.- Monto del pr�stamo.- El monto del pr�stamo es equivalente al porcentaje del valor del aval�o que se menciona en la car�tula y El CONSUMIDOR se obliga a restituir dicha cantidad, m�s los intereses, almacenaje y comisiones en su caso.
12.- Causas de Terminaci�n del contrato.- Ser�n causas de terminaci�n del contrato:
a) Pago del Pr�stamo.- En el plazo establecido en la car�tula del presente contrato EL CONSUMIDOR deber� reintegrar el importe del mutuo, conjuntamente con los intereses, almacenaje y las comisiones pactadas en el contrato. El pago ser� hecho en el establecimiento en que se suscribe el mismo, en moneda de curso legal; cuando el t�rmino de la opci�n de pago corresponda a un d�a inh�bil, el pago deber� hacerse el siguiente d�a h�bil. Realizado el pago EL CONSUMIDOR recibir� la prenda en el mismo lugar en que la entreg�, otorg�ndose ambas partes el finiquito m�s amplio que en derecho proceda.
b) Pago Anticipado.- EL CONSUMIDOR tendr� el derecho de cubrir el saldo total del mutuo, sus intereses, almacenaje y dem�s comisiones pactadas, antes del vencimiento del plazo establecido en la car�tula del presente contrato, conforme a las opciones de pago descritas en �ste, en cuyo caso EL CONSUMIDOR deber� presentarse en el establecimiento. Efectuado el pago se proceder� a la devoluci�n de la prenda en el acto.
13.- Comercializaci�n de la Prenda.- Para el caso de que EL CONSUMIDOR no cumpliera oportunamente con la obligaci�n de restituir el mutuo, los intereses, almacenaje y dem�s comisiones pactadas en el contrato, en este acto se otorga expresamente a favor de EL PROVEEDOR un mandato aplicado a actos concretos de comercio, en los t�rminos del art�culo 273 del C�digo de Comercio, para que a t�tulo de comisionista en su nombre y representaci�n y sin necesidad de agotar tr�mite alguno, efect�e la venta de la prenda, tomando como referencia el valor del aval�o estipulado en la cl�usula tercera del presente contrato, sirviendo como notificaci�n de la fecha de inicio de su comercializaci�n la indicada en la car�tula de este contrato. Para los efectos de la exenci�n a que se refiere el art�culo 9 fracci�n IV, de la Ley de Impuesto al Valor Agregado, EL CONSUMIDOR reconoce expl�citamente ser el enajenante de la prenda, que esta es usada y no tener la condicion jur�dica de empresa.
14.- Aplicaci�n del Producto de la Venta y Remanente.- EL CONSUMIDOR autoriza al PROVEEDOR a aplicar el producto de la venta de la prenda, al pago de la obligaci�n principal, a los intereses, almacenaje, y comisi�n por comercializaci�n. Si al realizar la venta o el remate de la prenda hubiera alg�n remanente, el mismo ser� puesto a disposici�n del CONSUMIDOR, a partir del tercer d�a siguiente a la comercializaci�n de la prenda, para lo cual el PROVEEDOR dentro de dicho plazo, notificar� por tel�fono, correo electr�nico, correo certificado y/o listas colocadas en el establecimiento respecto de la venta de la prenda. El remanente no cobrado en un lapso de doce meses calendario, contados a partir de la fecha de comercializaci�n de la prenda quedar� a favor de EL PROVEEDOR.
15.- Desempe�o Extempor�neo.- En el caso de que la prenda no haya sido comercializada despu�s de la �FECHA LIMITE DE REFRENDO O DESEMPE�O�, tal como se se�ala en la car�tula de este contrato, EL CONSUMIDOR podr� recuperar la prenda previo acuerdo con EL PROVEEDOR y pago del mutuo, de los intereses, almacenaje y las comisiones pactadas en el presente contrato.
16.- Refrendo.- EL CONSUMIDOR podr� refrendar el contrato, antes o en la fecha de su terminaci�n, con el consentimiento de EL PROVEEDOR, siempre y cuando EL CONSUMIDOR cubra el pago de los intereses, almacenaje y comisiones efectivamente devengadas al momento del refrendo. Al efectuarse el refrendo se firmar� un nuevo contrato con intereses, almacenaje y comisiones aplicables al momento del refrendo.
17.- Pena Convencional.- En caso de incumplimiento de cualquiera de las obligaciones a cargo de EL PROVEEDOR, �ste pagar� a EL CONSUMIDOR una pena convencional del 20 % (veinte por ciento) sobre el monto del aval�o.
18.- Nulidad.- De haber alguna causal de nulidad determinada por autoridad competente, la misma afectar� solamente a la cl�usula en la que espec�ficamente se hubiere incurrido en el vicio se�alado.
19.- Legitimidad.- Para el ejercicio de los derechos o el cumplimiento de los deberes a su cargo, EL CONSUMIDOR o en su defecto su Cotitular, beneficiario o representante legal, invariablemente deber�n presentar a EL PROVEEDOR este contrato, as� como una identificaci�n expedida por autoridad competente, en el establecimiento donde suscribi� el contrato, en los d�as y horas de servicio indicados en la car�tula de este contrato. En caso de extrav�o del contrato EL CONSUMIDOR podr� tramitar su reposici�n solicit�ndolo por escrito y cubriendo el importe se�alado en la car�tula del mismo.
20.- Confidencialidad.- Ambas partes convienen en que el acuerdo de voluntades que suscriben tiene el car�cter de confidencial, por lo que EL PROVEEDOR se obliga a mantener los datos relativos a EL CONSUMIDOR con tal car�cter y �nicamente podr� ser revelada la informaci�n contenida en el mismo por mandamiento de autoridad competente; de igual forma se obliga a no ceder o transmitir a terceros con fines mercadot�cnicos o publicitarios los datos e informaci�n proporcionada por EL CONSUMIDOR con motivo del contrato, ni enviar publicidad sobre los bienes y servicios, salvo que conste la autorizaci�n expresa de EL CONSUMIDOR en la car�tula del presente contrato.
21.- Notificaciones.- Las partes acuerdan que cualquier notificaci�n o aviso con motivo del contrato, deber� realizarse en los domicilios que se hayan establecido por las mismas, los cuales se indican en la car�tula; de igual manera, las partes podr�n efectuar avisos o comunicados mediante, tel�fono, correo electr�nico, correo certificado y/o listas colocadas en el establecimiento.
22.- D�as Inh�biles.- Todas las obligaciones contenidas en este contrato, cuyo vencimiento tenga lugar en un d�a inh�bil, deber� considerarse que el vencimiento de las mismas, ser� el d�a h�bil siguiente.
En caso de Persona Moral
23.- Derecho Aplicable.- Este contrato se rige por lo dispuesto en la Ley Federal de Protecci�n al Consumidor y su Reglamento, la Norma Oficial Mexicana NOM-179-SCFI-2007 Servicios de mutuo con inter�s y garant�a prendaria, Disposiciones de car�cter general a que se refiere la Ley para la Transparencia y Ordenamiento de los Servicios Financieros en materia de Contratos de Adhesi�n, Publicidad, Estados de Cuenta y Comprobantes de Operaci�n emitidos por las Entidades Comerciales y dem�s ordenamientos aplicables.
En caso de Persona F�sica
24.- Derecho Aplicable.- Este contrato se rige por lo dispuesto en la Ley Federal de Protecci�n al Consumidor y su Reglamento, la Norma Oficial Mexicana NOM-179-SCFI-2007 Servicios de mutuo con inter�s y garant�a prendar�a y dem�s ordenamientos aplicables.
25.- Aclaraciones, Quejas o Reclamaciones.-En caso de aclaraciones, quejas o reclamaciones, EL CONSUMIDOR deber� comunicarse al centro de atenci�n de EL PROVEEDOR, al n�mero telef�nico o presentarse en el domicilio que se establece en la car�tula. EL PROVEEDOR deber� proporcionar un n�mero de reporte al CONSUMIDOR, con el que se identificar� la aclaraci�n, queja o reclamaci�n y se dar� seguimiento al tr�mite, el cual ser� atendido en un tiempo no mayor a 10 d�as naturales.
26.- Jurisdicci�n.- Para todo lo relativo a la interpretaci�n, aplicaci�n y cumplimiento del contrato, las partes acuerdan someterse en la v�a administrativa a la Procuradur�a Federal del Consumidor, y en caso de subsistir diferencias, a la jurisdicci�n de los tribunales competentes del lugar donde se celebra este contrato.
Le�do que fue y una vez hecha la explicaci�n de su alcance legal y contenido, este contrato fue suscrito por duplicado en el lugar y en la fecha que se indica en la car�tula de este contrato, entreg�ndosele una copia del mismo a EL CONSUMIDOR
 




                                                   ____________________                    ____________________
                                                      EL CONSUMIDOR                            EL PROVEEDOR


Este contrato fue aprobado y registrado por la Procuradur�a Federal del Consumidor bajo el n�mero de 1745-2015 de fecha 23 de marzo de 2015. Cualquier variaci�n del presente contrato en perjuicio de EL CONSUMIDOR, frente al contrato de adhesi�n registrado, se tendr� por no puesta.";

	$data[] = array('CM'=>$COL1,'CD'=>$COL2);

	$pdf->ezTable($data,$titles4,'',$options4);
	unset($data);

	$pdf->ezSetDy(-5);
	$pdf->ezStream();	
	?>

	


	