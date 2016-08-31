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
	//TAMAÑO DE LETRA
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

	$texto = "CONTRATO MUTUO CON GARANTÍA PRENDARIA QUE CELEBRAN ".utf8_decode($f["nombre_empresa"]).", 'EL PROVEEDOR', CON DOMICILIO EN: ".utf8_decode($f["direccion_sucursal"]).
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
	
	
	/*$data[] = array('COL1'=>'INTERÉS '.strtoupper($f["nombre_interes"]).': '.$f["interes_ordinario"]."%/PRÉSTAMO",'COL2'=>'ALMACENAJE: '.$f["interes_almacenaje"]."%/PRÉSTAMO",'COL3'=>'FECHA VENCIMIENTO: '.$f["fecha_sigpago"]);
	$data[] = array('COL1'=>'MORATORIO:'.$f["cargo_atraso"]."% X DIA/PRÉSTAMO",'COL2'=>'CAT: '.$f["cat"]."% DE CARACTER INFORMATIVO",'COL3'=>'LIMITE REFRENDO/DESEMPEÑO: '.$f["fecha_vence"]);
	$data[] = array('COL1'=>'IVA: '.$f["iva"],'COL2'=>'PÉRDIDA DEL CONTRATO: '.$f["perdida"]." PESOS",'COL3'=>'FECHA COMERCIALIZACIÓN: '.$f["fecha_comercializacion"]);
	$data[] = array('COL1'=>'','COL2'=>'COMISIÓN POR VENTA: '.$f["comision"]."%",'COL3'=>'');
	*/
	$pdf->ezText("",$font_size, array('justification'=>'full',  'spacing' =>$spacing));
	$pdf->ezText("Metodología de cálculo de interés: tasa de interés anual fija dividida entre 360 días por el importe del saldo insoluto del préstamo por el número de días efectivamente transcurridos.",$font_size, array('justification'=>'full',  'spacing' =>$spacing));
	$pdf->ezText("----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------",$font_size, array('justification'=>'full',  'spacing' =>$spacing));
	$pdf->ezText("Plazo del préstamo (fecha límite para el refrendo o desempeño): ".$f["fecha_vence"].".",$font_size, array('justification'=>'full',  'spacing' =>$spacing));


	$pdf->ezSetDy(-5);
	$pdf->ezTable($data,$titles2,'',$options2);
	unset($data);


	$titles3=array('OPCIONES'=>'','NUMERO'=>'NÚMERO','IMPORTE'=>'IMPORTE DEL MUTUO','INTERESES'=>'INTERESES','ALMACENAJE'=>'ALMACENAJE','IVA'=>'IVA','REFRENDO'=>'POR REFRENDO','DESEMPEÑO'=>'POR DESEMPEÑO','PAGOS'=>'CUANDO SE REALIZAN LOS PAGOS');

	$options3= array('shaded'=>0,'xPos'=>311,'showHeadings'=>1,'rowGap' => $spacing,
					'showLines'=>1,'fontSize' =>$font_size,'cols'=>array(
							'OPCIONES'=>array('justification'=>'left','width'=>70),
							'NUMERO'=>array('justification'=>'left','width'=>70),
							'IMPORTE'=>array('justification'=>'right','width'=>60),							
							'INTERESES'=>array('justification'=>'right','width'=>50),
							'ALMACENAJE'=>array('justification'=>'right','width'=>70),
							'IVA'=>array('justification'=>'right','width'=>70),
							'REFRENDO'=>array('justification'=>'right','width'=>70),
							'DESEMPEÑO'=>array('justification'=>'right','width'=>70),
							'PAGOS'=>array('justification'=>'right','width'=>70)
						));

$result_detalle=$con->EjecutarConsulta($sql_detalle);
	$total_avaluo = 0;
	$total_prestamo =0;
	/*while ($row= mysql_fetch_array($result_detalle)){
		$total_avaluo += $row["avaluo"];
		$total_prestamo +=$row["prestamo"];
		$data[]=array('OPCIONES'=>strtoupper(utf8_decode($row["0"])),'NUMERO'=>$row["0"],'IMPORTE'=>$row["porcentaje_prestamo_avaluo"],'INTERESES'=>number_format($row["interes_ordinario"]),'ALMACENAJE'=>number_format($row["interes_almacenaje"]),'IVA'=>number_format($row["iva"]),'REFRENDO'=>number_format($row["0"]),'EMPEÑO'=>number_format($row["0"]),'PAGOS'=>number_format($row["0"]);	
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
		$data[]=array('OPCIONES'=>strtoupper(utf8_decode($row["0"])),'NUMERO'=>$row["0"],'IMPORTE'=>$row["porcentaje_prestamo_avaluo"],'INTERESES'=>number_format($row["interes_ordinario"]),'ALMACENAJE'=>number_format($row["interes_almacenaje"]),'IVA'=>number_format($row["iva"]),'REFRENDO'=>number_format($row["0"]),'EMPEÑO'=>number_format($row["0"]),'PAGOS'=>number_format($row["0"]);	
	}*/

	//$data1[]=array('CMT'=>'COSTO MENSUAL TOTAL', 'CDT'=>'COSTO DIARIO TOTAL','PORCENTAJE'=>'TOTALES', 'AVALUO'=>number_format($total_avaluo,2,'.',','),'PRESTAMO'=>number_format($total_prestamo,2,'.',','));	
	$pdf->ezSetDy(-5);
	$pdf->ezTable($data1,$titles5,'',$options5);
	$pdf->ezText("",$font_size, array('justification'=>'full',  'spacing' =>$spacing));
	$pdf->ezText("Cuide su capacidad de pago, generalmente no debe de exceder del 35% de sus ingresos",$font_size, array('justification'=>'full',  'spacing' =>$spacing));
	$pdf->ezText("Si usted no paga en tiempo y forma corre el riesgo de perder sus prendas",$font_size, array('justification'=>'full',  'spacing' =>$spacing));	
	$pdf->ezText("----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------",$font_size, array('justification'=>'full',  'spacing' =>$spacing));
	$pdf->ezText("Autorización: Los datos personales pueden utilizarse para mercadeo: ( ) Sí ( ) NO",$font_size, array('justification'=>'full',  'spacing' =>$spacing));
	$pdf->ezText("GARANTÍA: Para garantizar el pago de este préstamo, el consumidor deja en garantía el bien que se describe a continuación:",$font_size, array('justification'=>'full',  'spacing' =>$spacing));

	unset($data);


	/*$titles6=array('DP'=>'DESCRIPCION DE LA PRENDA');

	$options6= array('shaded'=>0,'xPos'=>311,'showHeadings'=>1,'rowGap' => $spacing,
					'showLines'=>1,'fontSize' =>$font_size,'cols'=>array(
							'DP'=>array('justification'=>'left','width'=>300)
						));
	
	$pdf->ezSetDy(-5);
	$pdf->ezTable($data6,$titles6,'',$options6);
	unset($data6);*/

	$titles7=array('CARAC'=>'CARACTERISTICAS','AVA'=>'AVALUO','PRES'=>'PRESTAMO','PA'=>'%PRESTAMO SOBRE AVALÚO');

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


	$COL1 = "CONTRATO DE MUTUO CON INTERÉS Y GARANTÍA PRENDARIA (PRÉSTAMO) QUE CELEBRAN POR UNA PARTE “EL PROVEEDOR” CUYO NOMBRE APARECE EN EL RUBRO DE LA CARÁTULA, REPRESENTADO EN ESTE ACTO POR SU REPRESENTANTE LEGAL________________________, Y POR LA OTRA, LA PERSONA CUYO NOMBRE Y DOMICILIO APARECE EN LA CARÁTULA, A QUIEN EN LO SUCESIVO Y PARA EFECTOS DEL PRESENTE CONTRATO SE LE DENOMINARÁ “EL CONSUMIDOR”; LAS PARTES SE SUJETAN AL TENOR DE LAS SIGUIENTES DECLARACIONES Y CLÁUSULAS:
D E C L A R A C I O N E S:
I.- Declara “EL PROVEEDOR”:

A) Ser una persona física de nacionalidad mexicana, con capacidad legal para celebrar el presente contrato.
B) Que el domicilio, teléfono, Registro Federal de Contribuyentes y correo electrónico del EL PROVEEDOR se encuentran en la carátula del presente contrato.
C) Que cuenta con la capacidad, infraestructura, servicios, recursos necesarios y personal debidamente capacitado, para dar cabal cumplimiento a las obligaciones derivadas del presente contrato.
II.- DECLARA “EL CONSUMIDOR”:
A) Llamarse como ha quedado plasmado en el proemio de este contrato.
B) Que manifiesta su voluntad para obligarse en los términos y condiciones del presente contrato, y que cuenta con la capacidad legal para la celebración del mismo.
C) Que su domicilio, teléfono y correo electrónico se encuentran señalados en la carátula del presente contrato.
D) El consumidor manifiesta bajo protesta en decir verdad que es el legal, legítimo e indiscutible propietario de la prenda que entrega en garantía de este contrato, y de todo cuanto en derecho, uso y costumbre corresponden y que puede acreditar dicha calidad jurídica ante terceros y/o cualquier autoridad que lo requiera.
Expuesto lo anterior, las partes se sujetan al contenido de las siguientes:
C L Á U S U L A S
1.- Objeto.- EL PROVEEDOR entrega a EL CONSUMIDOR la cantidad de dinero en efectivo, equivalente al porcentaje de la valuación que se ha practicado a la prenda, en calidad de mutuo mercantil con interés y garantía prendaría (préstamo) y EL CONSUMIDOR, se obliga, al término del contrato, a pagar al PROVEEDOR, la totalidad del préstamo, más los intereses, y las comisiones que se estipulan en la carátula del presente contrato.
2.- Prenda. Con objeto de garantizar el cumplimiento de todas y cada una de las obligaciones derivadas de este contrato, EL CONSUMIDOR entregará a EL PROVEEDOR a título de prenda, el o los bienes muebles usados que se describen en la carátula del presente contrato, en el entendido de que esta entrega de ninguna manera convierte a EL PROVEEDOR en propietario de la prenda, ni implica el reconocimiento por parte de éste, de que tal bien sea propiedad de EL CONSUMIDOR ni compromete, ni limita los derechos que terceras personas pudieran tener sobre el mismo.
3.- Valor de la prenda.- El valor de la prenda es el que se plasma en la carátula del presente contrato, ambas partes reconocen que el mismo es resultado de un avalúo practicado por EL PROVEEDOR, con la autorización y conformidad de EL CONSUMIDOR.
4.- Obligaciones. EL CONSUMIDOR y EL PROVEEDOR aceptan y se obligan expresamente durante la vigencia del contrato a lo siguiente:
CONSUMIDOR.
a) Cumplir con todas las obligaciones derivadas del presente contrato.
b) Notificar a EL PROVEEDOR, dentro de un plazo que no exceda de 10 días naturales, siguientes a partir de aquel en que haya tenido conocimiento de la existencia de cualquier acción, demanda, litigio o procedimiento en su contra, que comprometan a la prenda.
c) No enajenar, gravar, o comprometer los bienes entregados en garantía prendaría, mientras esté vigente el presente contrato.
d) EL CONSUMIDOR no podrá en ningún momento y por ningún motivo, ceder, dar en prenda, o traspasar, a título gratuito, oneroso, total o parcialmente los derechos y obligaciones que le deriven de este contrato, ni el derecho a la propiedad o a la posesión de los bienes otorgados en garantía prendaria (prenda), sin el consentimiento expreso y por escrito de EL PROVEEDOR.
PROVEEDOR.
a) EL PROVEEDOR se compromete a no usar el objeto otorgado en prenda como garantía del mutuo, por lo que únicamente tendrá la guarda y custodia de la prenda.
b) EL PROVEEDOR hará la guarda y custodia de la prenda en los términos de lo dispuesto en el artículo 2876 fracción I del Código Civil Federal; en ningún caso será responsable de los daños y deterioros que pudiere sufrir por el simple transcurso del tiempo.
c) EL PROVEEDOR deberá informar al CONSUMIDOR el Costo Anual Total (CAT), el Costo Mensual Total (CMT) y el Costo Diario Total (CDT) al momento de la celebración del presente contrato.
5.- Defensa de la Prenda.- Si EL PROVEEDOR fuere perturbado en la posesión de la prenda, por causas imputables a EL CONSUMIDOR, avisará por escrito a este último, en un plazo que no exceda de tres días naturales para que lleve a cabo las acciones legales pertinentes; si éste no cumpliere con esta obligación será responsable de todos los daños y perjuicios causados.
6.- Reposición de la Prenda. Si en el cumplimiento de mandato legítimo de autoridad competente, EL PROVEEDOR fuere desposeído de la prenda, EL CONSUMIDOR le entregará a su entera satisfacción otra prenda equivalente en peso, calidad, contenido, modelo, marca y valor, dentro de los 10 días naturales siguientes a la notificación que por escrito haga EL PROVEEDOR. En caso de omisión por parte de EL CONSUMIDOR a la mencionada notificación, desde este momento ambas partes acuerdan que sus derechos quedan a salvo para que éste último los haga valer en la forma y vía que considere convenientes.
7.- Procedimiento para la Restitución de la Prenda para el Caso de Pérdida o Deterioro. En caso de pérdida o deterioro de la cosa dada en prenda, EL PROVEEDOR deberá contar con una garantía suficiente que le permita resarcir el siniestro, debiendo seguir el siguiente procedimiento:
a) EL PROVEEDOR deberá notificar a EL CONSUMIDOR, en un plazo que no exceda de 3 días naturales, siguientes de ocurrido el siniestro, por vía telefónica, correo electrónico, correo certificado, listas y/o anuncios publicados en el establecimiento de EL PROVEEDOR.
b) EL CONSUMIDOR, deberá presentarse en el establecimiento donde firmó el contrato, en días y horas de servicio indicados en la carátula, o en el domicilio fiscal del proveedor, con la siguiente documentación:
1) Contrato de adhesión,
2) Identificación de EL CONSUMIDOR, COTITULAR Y/O BENEFICIARIO.
c) EL PROVEEDOR recibirá la documentación anterior, y le dará al consumidor un comprobante en el cual se hará la descripción de los documentos presentados, así como de la prenda motivo de la reclamación, misma que deberá coincidir con la establecida en el contrato, indicando el valor de la prenda conforme al avaluó practicado. El comprobante deberá de contener número de reclamación, razón social del proveedor, RFC., domicilio, nombre y firma de quien recibe la reclamación.
d) El PROVEEDOR se obliga a restituir o pagar la prenda, a elección de EL CONSUMIDOR, en el término de 10 días naturales siguientes a la entrega de la documentación por parte de este último.
e) EL PROVEEDOR pagará al CONSUMIDOR el valor de la prenda conforme al avalúo realizado y que está estipulado en la carátula de este contrato, del cual se disminuirá la cantidad entregada por concepto de mutuo, los intereses y el almacenaje que se hayan devengado hasta la fecha de ocurrido el siniestro y conforme a los porcentajes que se indica en la carátula. EL PROVEEDOR podrá realizar el pago en efectivo o mediante la entrega de un bien equivalente en modelo, marca, calidad, contenido, peso y valor a elección del CONSUMIDOR; en ambos casos EL PROVEEDOR deberá pagar un 20% sobre el valor del avalúo, como pena convencional, siempre y cuando el siniestro haya ocurrido por negligencia de éste.
Tratándose de metales preciosos, el valor de reposición del bien no podrá ser inferior al valor real que tenga el metal en el mercado al momento de la reposición.
8. Costo Anual Total (CAT).- Es el costo de financiamiento que para fines informativos y de comparación, incorpora la totalidad de los costos y gastos del préstamo. El referido Costo Anual Total se calculará utilizando la metodología establecida por el Banco de México, vigente en la fecha del cálculo respectivo.
Para el cálculo de Costo Mensual Total (CMT) y del Costo Diario Total (CDT) se utilizará la misma metodología que se aplica para el cálculo del CAT establecida por el Banco de México, ajustando los valores de intervalo de tiempo que correspondan para el tipo de préstamo que se trate, vigente en la fecha del cálculo respectivo.
9.- Intereses.- Metodología cálculo de interés ordinario.- El préstamo causará una tasa de interés fija del porcentaje anual mencionado en la carátula, sobre saldos insolutos más el Impuesto al Valor Agregado (IVA) cuando corresponda; el cálculo de intereses se realizará multiplicando el saldo insoluto del préstamo, por la tasa de interés dividido entre 360 días por año, multiplicando por el número de días transcurridos. La tasa de interés así como su metodología de cálculo no podrán modificarse durante la vigencia del presente contrato.
10.- Comisiones.- EL CONSUMIDOR se obliga, en su caso, a pagar a EL PROVEEDOR:
a).-Comisión por Almacenaje: El método de cálculo de comisión por almacenaje se realizará multiplicando el saldo insoluto del préstamo otorgado, por la tasa de almacenaje diaria que aparece en la carátula de este contrato, más el Impuesto al Valor Agregado, por el número de días efectivamente transcurridos.
b).-Comisión por Comercialización: Si EL CONSUMIDOR no cumpliese con el pago oportuno de la obligación principal, intereses y comisiones estipuladas en el presente contrato, EL PROVEEDOR procederá a comercializar el bien otorgado en garantía prendaría descrito en este contrato, con lo que EL CONSUMIDOR queda obligado a pagar a EL PROVEEDOR una comisión por el porcentaje detallado en la carátula, sobre el monto del préstamo.
";
$COL2="c).- Comisión por Reposición del Contrato.- El PROVEEDOR cobrará al CONSUMIDOR por Reposición de Contrato, el monto que se menciona en la carátula. La solicitud de reposición deberá hacerse por escrito y presentado identificación.
d).- Desempeño Extemporáneo.- EL PROVEEDOR cobrará al CONSUMIDOR por concepto de desempeño extemporáneo lo señalado en la carátula del presente contrato.
EL PROVEEDOR no podrá modificar las comisiones, ni la metodología de cálculo estipuladas en este contrato durante la vigencia del mismo.
11.- Monto del préstamo.- El monto del préstamo es equivalente al porcentaje del valor del avalúo que se menciona en la carátula y El CONSUMIDOR se obliga a restituir dicha cantidad, más los intereses, almacenaje y comisiones en su caso.
12.- Causas de Terminación del contrato.- Serán causas de terminación del contrato:
a) Pago del Préstamo.- En el plazo establecido en la carátula del presente contrato EL CONSUMIDOR deberá reintegrar el importe del mutuo, conjuntamente con los intereses, almacenaje y las comisiones pactadas en el contrato. El pago será hecho en el establecimiento en que se suscribe el mismo, en moneda de curso legal; cuando el término de la opción de pago corresponda a un día inhábil, el pago deberá hacerse el siguiente día hábil. Realizado el pago EL CONSUMIDOR recibirá la prenda en el mismo lugar en que la entregó, otorgándose ambas partes el finiquito más amplio que en derecho proceda.
b) Pago Anticipado.- EL CONSUMIDOR tendrá el derecho de cubrir el saldo total del mutuo, sus intereses, almacenaje y demás comisiones pactadas, antes del vencimiento del plazo establecido en la carátula del presente contrato, conforme a las opciones de pago descritas en éste, en cuyo caso EL CONSUMIDOR deberá presentarse en el establecimiento. Efectuado el pago se procederá a la devolución de la prenda en el acto.
13.- Comercialización de la Prenda.- Para el caso de que EL CONSUMIDOR no cumpliera oportunamente con la obligación de restituir el mutuo, los intereses, almacenaje y demás comisiones pactadas en el contrato, en este acto se otorga expresamente a favor de EL PROVEEDOR un mandato aplicado a actos concretos de comercio, en los términos del artículo 273 del Código de Comercio, para que a título de comisionista en su nombre y representación y sin necesidad de agotar trámite alguno, efectúe la venta de la prenda, tomando como referencia el valor del avalúo estipulado en la cláusula tercera del presente contrato, sirviendo como notificación de la fecha de inicio de su comercialización la indicada en la carátula de este contrato. Para los efectos de la exención a que se refiere el artículo 9 fracción IV, de la Ley de Impuesto al Valor Agregado, EL CONSUMIDOR reconoce explícitamente ser el enajenante de la prenda, que esta es usada y no tener la condicion jurídica de empresa.
14.- Aplicación del Producto de la Venta y Remanente.- EL CONSUMIDOR autoriza al PROVEEDOR a aplicar el producto de la venta de la prenda, al pago de la obligación principal, a los intereses, almacenaje, y comisión por comercialización. Si al realizar la venta o el remate de la prenda hubiera algún remanente, el mismo será puesto a disposición del CONSUMIDOR, a partir del tercer día siguiente a la comercialización de la prenda, para lo cual el PROVEEDOR dentro de dicho plazo, notificará por teléfono, correo electrónico, correo certificado y/o listas colocadas en el establecimiento respecto de la venta de la prenda. El remanente no cobrado en un lapso de doce meses calendario, contados a partir de la fecha de comercialización de la prenda quedará a favor de EL PROVEEDOR.
15.- Desempeño Extemporáneo.- En el caso de que la prenda no haya sido comercializada después de la “FECHA LIMITE DE REFRENDO O DESEMPEÑO”, tal como se señala en la carátula de este contrato, EL CONSUMIDOR podrá recuperar la prenda previo acuerdo con EL PROVEEDOR y pago del mutuo, de los intereses, almacenaje y las comisiones pactadas en el presente contrato.
16.- Refrendo.- EL CONSUMIDOR podrá refrendar el contrato, antes o en la fecha de su terminación, con el consentimiento de EL PROVEEDOR, siempre y cuando EL CONSUMIDOR cubra el pago de los intereses, almacenaje y comisiones efectivamente devengadas al momento del refrendo. Al efectuarse el refrendo se firmará un nuevo contrato con intereses, almacenaje y comisiones aplicables al momento del refrendo.
17.- Pena Convencional.- En caso de incumplimiento de cualquiera de las obligaciones a cargo de EL PROVEEDOR, éste pagará a EL CONSUMIDOR una pena convencional del 20 % (veinte por ciento) sobre el monto del avalúo.
18.- Nulidad.- De haber alguna causal de nulidad determinada por autoridad competente, la misma afectará solamente a la cláusula en la que específicamente se hubiere incurrido en el vicio señalado.
19.- Legitimidad.- Para el ejercicio de los derechos o el cumplimiento de los deberes a su cargo, EL CONSUMIDOR o en su defecto su Cotitular, beneficiario o representante legal, invariablemente deberán presentar a EL PROVEEDOR este contrato, así como una identificación expedida por autoridad competente, en el establecimiento donde suscribió el contrato, en los días y horas de servicio indicados en la carátula de este contrato. En caso de extravío del contrato EL CONSUMIDOR podrá tramitar su reposición solicitándolo por escrito y cubriendo el importe señalado en la carátula del mismo.
20.- Confidencialidad.- Ambas partes convienen en que el acuerdo de voluntades que suscriben tiene el carácter de confidencial, por lo que EL PROVEEDOR se obliga a mantener los datos relativos a EL CONSUMIDOR con tal carácter y únicamente podrá ser revelada la información contenida en el mismo por mandamiento de autoridad competente; de igual forma se obliga a no ceder o transmitir a terceros con fines mercadotécnicos o publicitarios los datos e información proporcionada por EL CONSUMIDOR con motivo del contrato, ni enviar publicidad sobre los bienes y servicios, salvo que conste la autorización expresa de EL CONSUMIDOR en la carátula del presente contrato.
21.- Notificaciones.- Las partes acuerdan que cualquier notificación o aviso con motivo del contrato, deberá realizarse en los domicilios que se hayan establecido por las mismas, los cuales se indican en la carátula; de igual manera, las partes podrán efectuar avisos o comunicados mediante, teléfono, correo electrónico, correo certificado y/o listas colocadas en el establecimiento.
22.- Días Inhábiles.- Todas las obligaciones contenidas en este contrato, cuyo vencimiento tenga lugar en un día inhábil, deberá considerarse que el vencimiento de las mismas, será el día hábil siguiente.
En caso de Persona Moral
23.- Derecho Aplicable.- Este contrato se rige por lo dispuesto en la Ley Federal de Protección al Consumidor y su Reglamento, la Norma Oficial Mexicana NOM-179-SCFI-2007 Servicios de mutuo con interés y garantía prendaria, Disposiciones de carácter general a que se refiere la Ley para la Transparencia y Ordenamiento de los Servicios Financieros en materia de Contratos de Adhesión, Publicidad, Estados de Cuenta y Comprobantes de Operación emitidos por las Entidades Comerciales y demás ordenamientos aplicables.
En caso de Persona Física
24.- Derecho Aplicable.- Este contrato se rige por lo dispuesto en la Ley Federal de Protección al Consumidor y su Reglamento, la Norma Oficial Mexicana NOM-179-SCFI-2007 Servicios de mutuo con interés y garantía prendaría y demás ordenamientos aplicables.
25.- Aclaraciones, Quejas o Reclamaciones.-En caso de aclaraciones, quejas o reclamaciones, EL CONSUMIDOR deberá comunicarse al centro de atención de EL PROVEEDOR, al número telefónico o presentarse en el domicilio que se establece en la carátula. EL PROVEEDOR deberá proporcionar un número de reporte al CONSUMIDOR, con el que se identificará la aclaración, queja o reclamación y se dará seguimiento al trámite, el cual será atendido en un tiempo no mayor a 10 días naturales.
26.- Jurisdicción.- Para todo lo relativo a la interpretación, aplicación y cumplimiento del contrato, las partes acuerdan someterse en la vía administrativa a la Procuraduría Federal del Consumidor, y en caso de subsistir diferencias, a la jurisdicción de los tribunales competentes del lugar donde se celebra este contrato.
Leído que fue y una vez hecha la explicación de su alcance legal y contenido, este contrato fue suscrito por duplicado en el lugar y en la fecha que se indica en la carátula de este contrato, entregándosele una copia del mismo a EL CONSUMIDOR
 




                                                   ____________________                    ____________________
                                                      EL CONSUMIDOR                            EL PROVEEDOR


Este contrato fue aprobado y registrado por la Procuraduría Federal del Consumidor bajo el número de 1745-2015 de fecha 23 de marzo de 2015. Cualquier variación del presente contrato en perjuicio de EL CONSUMIDOR, frente al contrato de adhesión registrado, se tendrá por no puesta.";

	$data[] = array('CM'=>$COL1,'CD'=>$COL2);

	$pdf->ezTable($data,$titles4,'',$options4);
	unset($data);

	$pdf->ezSetDy(-5);
	$pdf->ezStream();	
	?>

	


	