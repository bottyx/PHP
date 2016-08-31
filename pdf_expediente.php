<?php	//header("Content-Type: text/html; charset=UTF-8");
include("libreriasid.php");
require('fpdf.php');
include("escuela_control.php");
//require_once("clases/default/class_mysqlconnector.php");
$con = new class_mysqlconnector();
$con->Conectar();

include("clases/class_alumnos.php");
$alum = new class_alumnos();

$id_alumno=$_GET['id_alumno'];

$sqlNivel=$con->EjecutarConsulta("SELECT g.id_ciclo, g.id_nivel, ag.fecha_inscribe, g.grado, CONCAT(g.grado,'-',g.letra) AS grupo FROM alumno_grupo ag LEFT JOIN grupos g ON g.id_grupo=ag.id_grupo WHERE id_alumno='".$id_alumno."' ORDER BY id_ciclo DESC LIMIT 1");
$rw_g=mysql_fetch_array($sqlNivel);
$id_ciclo=$rw_g['id_ciclo'];
$id_nivel=$rw_g['id_nivel'];
$fecha_inscribe=$rw_g['fecha_inscribe'];
$grado=$rw_g["grado"];
$grupo=$rw_g["grupo"];

/*$sqlNivel=$con->EjecutarConsulta("SELECT g.id_ciclo, g.id_nivel, ag.fecha_inscribe, g.grado, CONCAT(g.grado,'-',g.letra) AS grupo FROM alumno_grupo ag LEFT JOIN grupos g ON g.id_grupo=ag.id_grupo WHERE id_alumno='".$id_alumno."' ORDER BY id_ciclo ASC");
$grado_aux="";	$i=0;
while($rw_i=mysql_fetch_array($sqlNivel)){
	if($grado_aux<$rw_i["grado"]){
		$grado_aux=$rw_i["grado"];
	}elseif($grado_aux==$rw_i["grado"]){
		$repite="X";
	}
	$i++;
}
if($i>1){ $reingreso="X";	}else{	$ingreso="X";	}*/

$qry_niveles=$con->EjecutarConsulta("SELECT UPPER(n.descrip) AS nivel, n.id_nivel FROM ciclo_niveles nc LEFT JOIN niveles n ON nc.id_nivel=n.id_nivel WHERE nc.id_ciclo='".$id_ciclo."'");
while($rw_n=mysql_fetch_array($qry_niveles)){
	$niveles_es[]=$rw_n["nivel"];
	if($rw_n["id_nivel"]==$id_nivel){$c="X"; }else{ $c=""; }
	$checked[]=$c;
}

$sSQL="SELECT a.id_alumno, a.nombre, a.apellido_p, a.apellido_m, a.fecha_nac, DATE_FORMAT(a.fecha_nac,'%d/%m/%Y') AS fecha_nacimiento, TIMESTAMPDIFF( YEAR, a.fecha_nac, CURRENT_DATE ) AS edad, a.sexo, a.curp, a.foto, a.tel,  a.direccion, a.elaboro, fi.*, p.escuela_proc, p.practica, p.cuales AS cuales_practica, p.horario AS horario_servicios, p.observaciones AS observ_procedencia,
y.situacion_padres, y.situacion_otros, y.lugar_familia, y.num_her_h, y.num_her_m, y.vive_con, y.vive_otros,
e.nuevo, e.reingreso, e.repetidor
FROM alumnos a
LEFT JOIN alumnos_datos_fiscales fi ON fi.id_alumno = a.id_alumno
LEFT JOIN alumnos_datos_procedencia p ON p.id_alumno = a.id_alumno
LEFT JOIN alumnos_datos_yuc y ON y.id_alumno=a.id_alumno 
LEFT JOIN alumnos_datos_yuc_estatus e ON e.id_alumno=a.id_alumno
WHERE a.id_alumno = '".$id_alumno."'";
//echo $sSQL;
$q=$con->EjecutarConsulta($sSQL);
$row=mysql_fetch_array($q);

$sql="SELECT  UPPER(f.nombre_t) AS tutor, UPPER(f.nombre_m) AS mama, UPPER(f.nombre_p) AS papa, f.* FROM alumnos_familia af LEFT JOIN alumnos_datos_familia f ON f.id_familia=af.id_familia WHERE af.id_alumno = '".$id_alumno."'";
$qF=$con->EjecutarConsulta($sql);
$rowF=mysql_fetch_array($qF);

//extract($row);
$ingreso=($row["nuevo"]==1?'X':'');
$reingreso=($row["reingreso"]==1?'X':'');
$repite=($row["repetidor"]==1?'X':'');
$nombreNivel=$row["nombre_nivel"];
$idAlumno=$row["id_alumno"];	$nombre=$row["nombre"];	$apellido_p=$row["apellido_p"]; $apellido_m=$row["apellido_m"]; 
$fecha_nac=$row["fecha_nac"];  if($row["sexo"]=="F"){ $sexo_f="X";   }elseif($row["sexo"]=="M"){ $sexo_m="X"; }
$curp=$row["curp"]; $tipo_sangre=$row["tipo_sangre"];  $telefono=$row["tel"]; $direccion=$row["direccion"];
$limitaciones=$row["limitaciones"]; $alergias=$row["alergias"]; $padecimiento=$row["padecimiento"]; $observaciones=$row["observaciones"]; $mama=$row["mama"]; 
$papa=$row["papa"];  $hermanos=$row["hermanos"];  $h_quienes=$row["h_quienes"]; 
$abuelitos_p=$row["abuelitos_p"]; $abuelitos_m=$row["abuelitos_m"];  $num_tias=$row["num_tias"]; $num_tios=$row["num_tios"]; $nom_tias=$row["nom_tias"]; $nom_tios=$row["nom_tios"]; $otros=$row["otros"]; $mama_tel=$row["mama_tel"]; $mama_cel=$row["mama_cel"]; $mama_lugar=$row["mama_lugar"]; 
$papa_tel=$row["papa_tel"]; $papa_cel=$row["papa_cel"]; $papa_lugar=$row["papa_lugar"]; 
$nombre_aux=$row["nombre_aux"]; $parentesco_aux=$row["parentesco_aux"]; $tel_aux=$row["tel_aux"]; $cel_aux=$row["cel_aux"]; $lugar_aux=$row["lugar_aux"]; 
$medico_menor=$row["medico"]; 
$medico_tel=$row["tel_medico"]; $medico_lugar_t=$row["trabajo_medico"]; $medico_cel=$row["medico_cel"]; 

/*$escuela_proc=utf8_decode($row["escuela_proc"]); $practica=$row["practica"]; $cuales=$row["cuales_practica"]; 
$horario_escolar=$row["horario_servicios"]; $observaciones=$row["observ_procedencia"];
$foto=$row["foto"];

if($row["situacion_padres"]==1){ $situacion_1="X"; }elseif($row["situacion_padres"]==2){ $situacion_2="X"; }elseif($row["situacion_padres"]==3){ $situacion_3="X";	
}elseif($row["situacion_padres"]==4){ $situacion_4="X"; }elseif($row["situacion_padres"]==5){ $situacion_5="X"; }
$situacion_otros=$row["situacion_otros"];	$lugar_familia=$row["lugar_familia"];	$num_her_h=$row["num_her_h"];	$num_her_m=$row["num_her_m"];
if($row["vive_con"]==1){ $vive_1="X"; }elseif($row["vive_con"]==2){ $vive_2="X"; }elseif($row["vive_con"]==3){ $vive_3="X";	
}elseif($row["vive_con"]==4){ $vive_4="X"; }
$vive_otros=$row["vive_otros"];*/

$elaboro=$row["elaboro"];

$alumno=utf8_decode($apellido_p." ".$apellido_m." ".$nombre);
$fecha_nacimiento=convierteFecha($fecha_nac,0);
$f=split("-",$fecha_nac);
//$edad = date("Y")-$f[0];
$fecha_nac2=$row["fecha_nacimiento"];
$fecha_control=date("d/m/Y");
$tiempo = tiempo_transcurrido($fecha_nac2, $fecha_control);
$edad = $tiempo[0]." año(s) ".$tiempo[1]." mes(es)";//$row['edad'];

/*
$id_familia=$rowF["id_familia"];
if($rowF["tutor"]==1){ $tutor_p="X"; $padre_tutor="SR. ".$rowF["nombre_p"]; }elseif($rowF["tutor"]==2){ $tutor_m="X"; $padre_tutor="SRA. ".$rowF["nombre_m"];}
$padre=utf8_decode($rowF["nombre_p"]);
$p_direccion=$rowF["direccion_trabajo_p"];  $p_lugar_trabajo=utf8_decode($rowF["trabajo_p"]);  $p_tel_trabajo=$rowF["tel_trabajo_p"];   $p_celular=$rowF["cel_p"];    
$p_email=$rowF["email_p"];   if($rowF["cel_compania_p"]==1){ $telcel_p="X"; }elseif($rowF["cel_compania_p"]==2){ $iusa_p="X";}

$p_domicilio=$rowF["direccion_p"];  $p_profesion=utf8_decode($rowF["profesion_p"]); $p_puesto=$rowF["puesto_p"];  $p_horario=$rowF["horario_p"];  $p_telefono=$rowF["tel_p"]; 


$madre=utf8_decode($rowF["nombre_m"]);
$m_direccion=$rowF["direccion_trabajo_m"];  $m_lugar_trabajo=utf8_decode($rowF["trabajo_m"]);  $m_tel_trabajo=$rowF["tel_trabajo_m"];   $m_celular=$rowF["cel_m"];    
$m_email=$rowF["email_m"];   if($rowF["cel_compania_m"]==1){ $telcel_m="X"; }elseif($rowF["cel_compania_m"]==2){ $iusa_m="X";}

$m_domicilio=$rowF["direccion_m"];  $m_profesion=utf8_decode($rowF["profesion_m"]); $m_puesto=$rowF["puesto_m"];  $m_horario=$rowF["horario_m"];  $m_telefono=$rowF["tel_m"]; 

if($padre==""){
	$padre=utf8_decode($rowF["nombre_t"]);
	$p_direccion=$rowF["direccion_trabajo_t"];  $p_lugar_trabajo=utf8_decode($rowF["trabajo_t"]);  $p_tel_trabajo=$rowF["tel_trabajo_t"];   $p_celular=$rowF["cel_t"];    
	$p_email=$rowF["email_t"];   
	
	$p_domicilio=$rowF["direccion_t"];  $p_profesion=utf8_decode($rowF["profesion_t"]); $p_puesto=$rowF["puesto_t"];  $p_horario=$rowF["horario_t"];  $p_telefono=$rowF["tel_t"]; 
}elseif($madre==""){
	$madre=utf8_decode($rowF["nombre_t"]);
	$m_direccion=$rowF["direccion_trabajo_t"];  $m_lugar_trabajo=utf8_decode($rowF["trabajo_t"]);  $m_tel_trabajo=$rowF["tel_trabajo_t"];   $m_celular=$rowF["cel_t"];    
	$m_email=$rowF["email_t"];   
	
	$m_domicilio=$rowF["direccion_t"];  $m_profesion=utf8_decode($rowF["profesion_t"]); $m_puesto=$rowF["puesto_t"];  $m_horario=$rowF["horario_t"];  $m_telefono=$rowF["tel_t"]; 
}
$nombre_fam=utf8_decode($rowF["nombre_fam"]);
$cel_fam=$rowF["cel_fam"];
if($rowF["cel_compania_fam"]==1){ $telcel_fam="X"; }elseif($rowF["cel_compania_fam"]==2){ $iusa_fam="X";}
$tel_fam=$rowF["tel_fam"];
$parentesco_fam=utf8_decode($rowF["parentesco_fam"]);
$lugar_fam=$rowF["trabajo_fam"];*/

class PDF extends FPDF{
	//Cabecera de página
	function Header(){
		//Arial bold 15
		//$this->SetFont('Arial','B',20);
		//Movernos a la derecha
		//$this->Cell(90);
		//Título
		$tipo_reporte="cedula";
		include("cabecera_fpdf.php");
/*		$this->Cell(30,5,'CENTRO ESCOLAR MIGUEL ALEMÁN, A.C.',0,0,'C');
		$this->Ln(7);
		$this->Cell(80);
		$this->SetFont('Arial','',12);
		$this->Cell(30,5,'         '.strtoupper($nombreNivel),0,0,'C');*/
	}
}

$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();

////	HOJA 1 ///////////////////

$pdf->AddPage();
$pdf->Ln(7);
$pdf->Cell(195,20,"",1,0,'L');

$pdf->SetFont('Arial','',9);
$pdf->Ln(1);

$pdf->Cell(15,4,"  Nivel: ",0,0,'L');

/*for($c_n=0; $c_n<count($niveles_es); $c_n++){
	$nivel_alumno=" ";
	$pdf->Cell(4,4,$checked[$c_n],1,0,'C');
	$pdf->Cell(30,4," ".utf8_decode($niveles_es[$c_n]),0,0,'L');
}*/
$pdf->Ln(7);
$pdf->Cell(15,4,"  GRADO:  ".$grado,0,0,'L');
$pdf->Cell(20,4,"_______________",0,0,'L');
$pdf->Ln(-0.5);
$pdf->Cell(100,4,"  ",0,0,'L');
$pdf->Cell(41,4,"  FECHA DE INSCRIPCION:  ".$fecha_inscribe,0,0,'L');
$pdf->Cell(20,4,"__________________________",0,0,'L');

$pdf->Ln(7);
$pdf->Cell(37,4,"  NUEVO INGRESO: ",0,0,'L');
$pdf->Cell(4,4,$ingreso,1,0,'C');

$pdf->Cell(25,4," 	",0,0,'L');
$pdf->Cell(30,4,"  REINGRESO:    ",0,0,'L');
$pdf->Cell(4,4,$reingreso,1,0,'C');

$pdf->Cell(25,4," 	",0,0,'L');
$pdf->Cell(30,4,"  REPETIDOR:    ",0,0,'L');
$pdf->Cell(4,4,$repite,1,0,'C');

$pdf->Ln(7);
$pdf->Cell(195,33,"",1,0,'L');
$pdf->Ln(1);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(190,4,"DATOS DEL ",0,0,'C');
$pdf->SetFont('Arial','',9);
$pdf->Ln(3);
$pdf->Cell(3,27,"",0,0,'L');
/*$pdf->Cell(25,27,"",1,0,'L');
if(@file_exists("fotos/alumnos/".$foto) && empty($foto) == false){
	$pdf->Image("fotos/alumnos/".$foto, 14, 50.5, 23, 25, "JPG");
}*/

$pdf->Ln(4);
$pdf->Cell(30,4,"",0,0,'L');
//$pdf->Cell(18,4,"  NOMBRE:  ".$alumno,0,0,'L');
$pdf->Cell(18,4,"  NOMBRE:  XXXXXXXXXX",0,0,'L');
$pdf->Cell(145,4,"_______________________________________________________________________________",0,0,'L');

$pdf->Ln(5);
$pdf->Cell(30,4,"",0,0,'L');
//$pdf->Cell(12,4,"  EDAD: ".$edad,0,0,'L');
$pdf->Cell(12,4,"  EDAD:  XX",0,0,'L');
$pdf->Cell(33,4,"__________________",0,0,'L');
$pdf->Cell(13,4,"  SEXO: ",0,0,'L');
$pdf->Cell(4,4,"F",0,0,'L');
$pdf->Cell(4,4,$sexo_f,1,0,'L');
$pdf->Cell(8,4,"M",0,0,'R');
$pdf->Cell(4,4,$sexo_m,1,0,'L');
$pdf->Cell(2,4,"",0,0,'L');
//$pdf->Cell(40,4,"  FECHA DE NACIMIENTO: ".$fecha_nacimiento,0,0,'L');
$pdf->Cell(40,4,"  FECHA DE NACIMIENTO:  XX-XX-XXXX",0,0,'L');
$pdf->Cell(30,4,"_____________________",0,0,'L');

$pdf->Ln(5);
$pdf->Cell(30,4,"",0,0,'L');
//$pdf->Cell(13,4,"  CURP:  ".$curp,0,0,'L');
$pdf->Cell(13,4,"  CURP:  XXXXXXXXXXXXXXX",0,0,'L');
$pdf->Cell(80,4,"_____________________________________",0,0,'L');
//$pdf->Cell(20,4,"  TELEFONO: ".$telefono,0,0,'L');
$pdf->Cell(20,4,"  TELEFONO:  XXXXX",0,0,'L');
$pdf->Cell(30,4,"_________________________",0,0,'L');

$pdf->Ln(5);
$pdf->Cell(30,4,"",0,0,'L');
//$pdf->Cell(21,4,"  DIRECCION: ".$direccion,0,0,'L');
$pdf->Cell(21,4,"  DIRECCION:   XXXXXXXXXXX",0,0,'L');
$pdf->Cell(145,4,"_____________________________________________________________________________",0,0,'L');

$pdf->Ln(5);
$pdf->Cell(30,4,"",0,0,'L');
$pdf->Cell(48,4,"  COLEGIO DE PROCEDENCIA:   ".$escuela_proc,0,0,'L');
$pdf->Cell(110,4,"______________________________________________________________",0,0,'L');

$pdf->Ln(7);
$pdf->Cell(195,24,"",1,0,'L');
$pdf->Ln(1);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(80,4,"",0,0,'L');
$pdf->Cell(30,4,"DATOS DEL ",0,0,'L');
$pdf->Cell(50,4,"",0,0,'L');
$pdf->Cell(20,4,"TUTOR",0,0,'L');
$pdf->Cell(4,4,$tutor_p,1,0,'L');

$pdf->SetFont('Arial','',9);
$pdf->Ln(7);
$pdf->Cell(18,4,"  NOMBRE:  ".$padre,0,0,'L');
$pdf->Cell(100,4,"_________________________________________________________",0,0,'L');

$pdf->Cell(16,4,"    E-MAIL:  ".$p_email,0,0,'L');
$pdf->Cell(70,4,"______________________________",0,0,'L');

$pdf->Ln(5);
$pdf->Cell(40,4,"  LUGAR DONDE LABORA: ".$p_lugar_trabajo,0,0,'L');
$pdf->Cell(81,4,"_____________________________________________",0,0,'L');
$pdf->Cell(22,4," TEL.OFICINA:  ".$p_tel_trabajo,0,0,'L');
$pdf->Cell(50,4,"_________________________",0,0,'L');

$pdf->Ln(5);
$pdf->Cell(18,4,"  CELULAR: ".$p_celular,0,0,'L');
$pdf->Cell(30,4,"_________________",0,0,'L');
$pdf->Cell(16,4,"  TELCEL",0,0,'L');
$pdf->Cell(4,4,$telcel_p,1,0,'L');
$pdf->Cell(19,4,"  IUSACELL",0,0,'L');
$pdf->Cell(4,4,$iusa_p,1,0,'L');
$pdf->Cell(5,4,"",0,0,'L');
$pdf->Cell(22,4,"  OCUPACION: ".$p_profesion,0,0,'L');
$pdf->Cell(30,4,"_______________________________________",0,0,'L');

$pdf->Ln(7);
$pdf->Cell(195,24,"",1,0,'L');
$pdf->Ln(1);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(80,4,"",0,0,'L');
$pdf->Cell(30,4,"DATOS DE LA ",0,0,'L');
$pdf->Cell(50,4,"",0,0,'L');
$pdf->Cell(20,4,"TUTOR",0,0,'L');
$pdf->Cell(4,4,$tutor_m,1,0,'L');

$pdf->SetFont('Arial','',9);
$pdf->Ln(7);
$pdf->Cell(18,4,"  NOMBRE:  ".$madre,0,0,'L');
$pdf->Cell(100,4,"_________________________________________________________",0,0,'L');

$pdf->Cell(16,4,"    E-MAIL:  ".$m_email,0,0,'L');
$pdf->Cell(70,4,"______________________________",0,0,'L');

$pdf->Ln(5);
$pdf->Cell(40,4,"  LUGAR DONDE LABORA: ".$m_lugar_trabajo,0,0,'L');
$pdf->Cell(81,4,"_____________________________________________",0,0,'L');
$pdf->Cell(22,4," TEL.OFICINA:  ".$m_tel_trabajo,0,0,'L');
$pdf->Cell(50,4,"_________________________",0,0,'L');

$pdf->Ln(5);
$pdf->Cell(18,4,"  CELULAR: ".$m_celular,0,0,'L');
$pdf->Cell(30,4,"_________________",0,0,'L');
$pdf->Cell(16,4,"  TELCEL",0,0,'L');
$pdf->Cell(4,4,$telcel_m,1,0,'L');
$pdf->Cell(19,4,"  IUSACELL",0,0,'L');
$pdf->Cell(4,4,$iusa_m,1,0,'L');
$pdf->Cell(5,4,"",0,0,'L');
$pdf->Cell(22,4,"  OCUPACION: ".$m_profesion,0,0,'L');
$pdf->Cell(30,4,"_______________________________________",0,0,'L');

$pdf->Ln(7);
$pdf->Cell(195,46,"",1,0,'L');
$pdf->Ln(1);
$pdf->Cell(46,4,"  PERSONA A QUIEN AVISAR: ".$nombre_fam,0,0,'L');
$pdf->Cell(78,4,"_____________________________________________",0,0,'L');

$pdf->Cell(27,4,"    PARENTESCO:  ".$parentesco_fam,0,0,'L');
$pdf->Cell(70,4,"____________________",0,0,'L');

$pdf->Ln(7);
$pdf->Cell(41,4,"  TELEFONO PARTICULAR: ".$tel_fam,0,0,'L');
$pdf->Cell(30,4,"__________________",0,0,'L');
$pdf->Cell(18,4,"  CELULAR: ".$cel_fam,0,0,'L');
$pdf->Cell(30,4,"__________________",0,0,'L');
$pdf->Cell(16,4,"  TELCEL",0,0,'L');
$pdf->Cell(4,4,$telcel_fam,1,0,'L');
$pdf->Cell(19,4,"  IUSACELL",0,0,'L');
$pdf->Cell(4,4,$iusa_fam,1,0,'L');

$pdf->Ln(7);
$pdf->Cell(47,4,"  SITUACION DE LOS PADRES: ",0,0,'L');
$pdf->Cell(17,4,"CASADOS",0,0,'L');
$pdf->Cell(4,4,$situacion_1,1,0,'L');
$pdf->Cell(2,4,"",0,0,'L');
$pdf->Cell(21,4,"SEPARADOS",0,0,'L');
$pdf->Cell(4,4,$situacion_2,1,0,'L');
$pdf->Cell(2,4,"",0,0,'L');
$pdf->Cell(23.5,4,"DIVORCIADOS",0,0,'L');
$pdf->Cell(4,4,$situacion_3,1,0,'L');
$pdf->Cell(2,4,"",0,0,'L');
$pdf->Cell(22,4,"UNION LIBRE",0,0,'L');
$pdf->Cell(4,4,$situacion_4,1,0,'L');
$pdf->Cell(2,4,"",0,0,'L');
$pdf->Cell(13,4,"OTROS      ".$situacion_otros,0,0,'L');
$pdf->Cell(4,4,$situacion_5,1,0,'L');
$pdf->Cell(20,4,"____________",0,0,'L');

$pdf->Ln(7);
$pdf->Cell(50,4,"  LUGAR OCUPA EN LA FAMILIA: ".$lugar_familia,0,0,'L');
$pdf->Cell(48,4,"___________________________",0,0,'L');

$pdf->Cell(41,4,"  NUMERO DE HERMANOS: ",0,0,'L');
$pdf->Cell(19,4,"  HOMBRES  ".$num_her_h,0,0,'L');
$pdf->Cell(8,4,"_____",0,0,'L');
$pdf->Cell(18,4,"  MUJERES  ".$num_her_m,0,0,'L');
$pdf->Cell(8,4,"_____",0,0,'L');

$pdf->Ln(7);
$pdf->Cell(23,4,"  VIVE CON: ",0,0,'L');
$pdf->Cell(28,4,"AMBOS PADRES",0,0,'L');
$pdf->Cell(4,4,$vive_1,1,0,'L');
$pdf->Cell(5,4,"",0,0,'L');
$pdf->Cell(18,4,"ABUELOS",0,0,'R');
$pdf->Cell(4,4,$vive_2,1,0,'L');
$pdf->Cell(5,4,"",0,0,'L');
$pdf->Cell(15,4,"MADRE",0,0,'R');
$pdf->Cell(4,4,$vive_3,1,0,'L');
$pdf->Cell(5,4,"",0,0,'L');
$pdf->Cell(15,4,"OTROS",0,0,'R');
$pdf->Cell(4,4,$vive_4,1,0,'L');
$pdf->Cell(40,4,"   ".$vive_otros,0,0,'L');
$pdf->Ln(0);
$pdf->Cell(130,4,"",0,0,'');
$pdf->Cell(48,4,"___________________________________",0,0,'L');


$pdf->Ln(7);
$observ_1 = substr($observaciones,0,100);
$observ_2 = substr($observaciones,100);
$pdf->Cell(30,4,"  OBSERVACIONES: ".$observ_1,0,0,'L');
$pdf->Ln(-0.1);
$pdf->Cell(31,4,"  ",0,0,'L');
$pdf->Cell(160,4,"___________________________________________________________________________________________",0,0,'L');
$pdf->Ln(5);
$pdf->Cell(190,4,"  ".$observ_2,0,0,'L');
$pdf->Ln(-0.5);
$pdf->Cell(190,4,"  ____________________________________________________________________________________________________________",0,0,'L');

$pdf->Ln(7);
$pdf->Cell(195,50,"",1,0,'L');
$pdf->Ln(1);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(190,4,"DOCUMENTOS ",0,0,'C');
$pdf->SetFont('Arial','',9);

$pdf->Ln(7);
$rw_doc=$alum->obtener_fila_doc(1, $id_alumno);
extract($rw_doc);
if($op1==1){$op1="X"; }else{ $op1=""; }	
if($op2==1){$op2="X"; }else{ $op2=""; }	
$pdf->Cell(42,4,"  ACTA DE NACIMIENTO: ",0,0,'L');
$pdf->Cell(4,4,"",0,0,'L');
$pdf->Cell(17,4,"ORIGINAL",0,0,'L');
$pdf->Cell(4,4,$op1,1,0,'L');
$pdf->Cell(2,4,"",0,0,'L');
$pdf->Cell(16,4,$otro." COPIAS",0,0,'L');
$pdf->Cell(4,4,$op2,1,0,'L');

$rw_doc=$alum->obtener_fila_doc(7, $id_alumno);
extract($rw_doc);
if($op1==1){$op1="X"; }else{ $op1=""; }	
if($op2==1){$op2="X"; }else{ $op2=""; }	
$pdf->Cell(7,4,"",0,0,'L');
$pdf->Cell(50,4,"  COMPROBANTE DE DOMICILIO: ",0,0,'L');
$pdf->Cell(4,4,"",0,0,'L');
$pdf->Cell(17,4,"ORIGINAL",0,0,'L');
$pdf->Cell(4,4,$op1,1,0,'L');

$pdf->Ln(7);
$rw_doc=$alum->obtener_fila_doc(2, $id_alumno);
extract($rw_doc);
if($op1==1){$op1="X"; }else{ $op1=""; }	
if($op2==1){$op2="X"; }else{ $op2=""; }	
$pdf->Cell(42,4,"  CALIFIC. ANTERIOR: ",0,0,'L');
$pdf->Cell(4,4,"",0,0,'L');
$pdf->Cell(17,4,"ORIGINAL",0,0,'L');
$pdf->Cell(4,4,$op1,1,0,'L');
$pdf->Cell(2,4,"",0,0,'L');
$pdf->Cell(16,4,$otro." COPIAS",0,0,'L');
$pdf->Cell(4,4,$op2,1,0,'L');

$rw_doc=$alum->obtener_fila_doc(8, $id_alumno);
extract($rw_doc);
if($op1==1){$op1="X"; }else{ $op1=""; }	
if($op2==1){$op2="X"; }else{ $op2=""; }	
$pdf->Cell(7,4,"",0,0,'L');
$pdf->Cell(50,4,"  CURP: ",0,0,'L');
$pdf->Cell(4,4,"",0,0,'L');
$pdf->Cell(17,4,"ORIGINAL",0,0,'L');
$pdf->Cell(4,4,$op1,1,0,'L');
$pdf->Cell(2,4,"",0,0,'L');
$pdf->Cell(16,4,$otro." COPIAS",0,0,'L');
$pdf->Cell(4,4,$op2,1,0,'L');


$pdf->Ln(7);
$rw_doc=$alum->obtener_fila_doc(3, $id_alumno);
extract($rw_doc);
if($op1==1){$op1="X"; }else{ $op1=""; }	
if($op2==1){$op2="X"; }else{ $op2=""; }	
$pdf->Cell(42,4,"  CERTIFICADO: ",0,0,'L');
$pdf->Cell(4,4,"",0,0,'L');
$pdf->Cell(17,4,"ORIGINAL",0,0,'L');
$pdf->Cell(4,4,$op1,1,0,'L');
$pdf->Cell(2,4,"",0,0,'L');
$pdf->Cell(16,4,$otro." COPIAS",0,0,'L');
$pdf->Cell(4,4,$op2,1,0,'L');

$rw_doc=$alum->obtener_fila_doc(9, $id_alumno);
extract($rw_doc);
if($op1==1){$op1="X"; }else{ $op1=""; }	
if($op2==1){$op2="X"; }else{ $op2=""; }	
$pdf->Cell(7,4,"",0,0,'L');
$pdf->Cell(50,4,"  CERT. PARCIAL: ",0,0,'L');
$pdf->Cell(4,4,"",0,0,'L');
$pdf->Cell(17,4,"ORIGINAL",0,0,'L');
$pdf->Cell(4,4,$op1,1,0,'L');
$pdf->Cell(2,4,"",0,0,'L');
$pdf->Cell(16,4,$otro." COPIAS",0,0,'L');
$pdf->Cell(4,4,$op2,1,0,'L');


$pdf->Ln(7);
$rw_doc=$alum->obtener_fila_doc(4, $id_alumno);
extract($rw_doc);
if($op1==1){$op1="X"; }else{ $op1=""; }	
if($op2==1){$op2="X"; }else{ $op2=""; }	
$pdf->Cell(42,4,"  CARTA BUENA CONDUCTA: ",0,0,'L');
$pdf->Cell(4,4,"",0,0,'L');
$pdf->Cell(17,4,"ORIGINAL",0,0,'L');
$pdf->Cell(4,4,$op1,1,0,'L');
$pdf->Cell(2,4,"",0,0,'L');
$pdf->Cell(16,4,$otro." COPIAS",0,0,'L');
$pdf->Cell(4,4,$op2,1,0,'L');

$rw_doc=$alum->obtener_fila_doc(10, $id_alumno);
extract($rw_doc);
if($op1==1){$op1="X"; }else{ $op1=""; }	
if($op2==1){$op2="X"; }else{ $op2=""; }	
$pdf->Cell(7,4,"",0,0,'L');
$pdf->Cell(50,4,"  CONST. ESTUDIOS: ",0,0,'L');
$pdf->Cell(4,4,"",0,0,'L');
$pdf->Cell(17,4,"ORIGINAL",0,0,'L');
$pdf->Cell(4,4,$op1,1,0,'L');
$pdf->Cell(2,4,"",0,0,'L');
$pdf->Cell(16,4,$otro." COPIAS",0,0,'L');
$pdf->Cell(4,4,$op2,1,0,'L');

$pdf->Ln(7);
$rw_doc=$alum->obtener_fila_doc(5, $id_alumno);
extract($rw_doc);
if($op1==1){$op1="X"; }else{ $op1=""; }	
if($op2==1){$op2="X"; }else{ $op2=""; }	
$pdf->Cell(42,4,"  CARTILLA DE VACUNACION: ",0,0,'L');
$pdf->Cell(4,4,"",0,0,'L');
$pdf->Cell(17,4,$otro." COPIAS",0,0,'L');
$pdf->Cell(4,4,$op1,1,0,'L');

$rw_doc=$alum->obtener_fila_doc(11, $id_alumno);
extract($rw_doc);
if($op1==1){$op1="X"; }else{ $op1=""; }	
if($op2==1){$op2="X"; }else{ $op2=""; }	
$pdf->Cell(29,4,"",0,0,'L');
$pdf->Cell(50,4,"  CARTA NO ADEUDO: ",0,0,'L');
$pdf->Cell(4,4,"",0,0,'L');
$pdf->Cell(17,4,"ORIGINAL",0,0,'L');
$pdf->Cell(4,4,$op1,1,0,'L');

$pdf->Ln(7);
$rw_doc=$alum->obtener_fila_doc(6, $id_alumno);
extract($rw_doc);
if($op1==1){$op1="X"; }else{ $op1=""; }	
if($op2==1){$op2="X"; }else{ $op2=""; }	
$pdf->Cell(42,4,"  FOTOS INFANTILES: ",0,0,'L');
$pdf->Cell(4,4,"",0,0,'L');
$pdf->Cell(17,4,"8 PIEZAS",0,0,'L');
$pdf->Cell(4,4,$op1,1,0,'L');
$pdf->Cell(2,4,"",0,0,'L');
$pdf->Cell(16,4,"P/CERT.",0,0,'L');
$pdf->Cell(4,4,$op2,1,0,'L');

$rw_doc=$alum->obtener_fila_doc(12, $id_alumno);
extract($rw_doc);
if($op1==1){$op1="X"; }else{ $op1=""; }	
if($op2==1){$op2="X"; }else{ $op2=""; }	
$pdf->Cell(7,4,"",0,0,'L');
$pdf->Cell(15,4,"  OTROS: ",0,0,'L');
$pdf->Cell(50,4,utf8_decode($otro),0,0,'L');
$pdf->Ln(0);
$pdf->Cell(111,4,"",0,0,'');
$pdf->Cell(48,4,"______________________________________________",0,0,'L');

$pdf->Ln(10);
$pdf->Cell(80,5,"FIRMA DEL PADRE O TUTOR",0,0,'C');
$pdf->Cell(35,5,"",0,0,'L');
$pdf->Cell(80,5,"RECEPCIONO",0,0,'C');
$pdf->Ln(15);
$pdf->Cell(80,5,"_____________________________________________",0,0,'L');
$pdf->Cell(35,5,"",0,0,'L');
$pdf->Cell(80,5,"_____________________________________________",0,0,'L');
$pdf->Ln(5);
$pdf->Cell(80,5,$padre_tutor,0,0,'C');
$pdf->Cell(35,5,"",0,0,'L');
$pdf->Cell(80,5,$elaboro,0,0,'C');

$pdf->Ln(5);
$pdf->Output();
?>