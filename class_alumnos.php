<?php
require_once("default/class_mysqlconnector.php");

function generar_matricula($niv,$id)
{
	$matricula=mysql_fetch_array(mysql_query("SELECT matricula FROM alumnos WHERE id_alumno='".$id."'"));
	if($matricula['matricula']=="")
	{
		$rCiclo=mysql_fetch_array(mysql_query("select * from ciclos where id_ciclo='".$_POST["id_ciclo"]."'"));
		$a1=explode("-",$rCiclo["fecha_ini"]);
		$anio=substr($a1[0], -2);
		$max="01";

		$currentID = mysql_query("SELECT MAX( matricula ) AS current_id FROM alumnos WHERE matricula LIKE  '".$anio.$nivel.$niv.$grado."%'");
		$row = mysql_fetch_array($currentID);
		if($row["current_id"]!=null)
		{
			$max=substr($row["current_id"], strlen($row["current_id"])-2,2)+1;
			if ($max<10)
				$max = "0".$max;

		}

		$matri=$anio.$niv.$max;
	}
	else
		$matri=$matricula['matricula'];
	
	return $matri;
}

class class_alumnos extends class_mysqlconnector{
	function __construct(){
	}
	function consultar_alumno($id){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();
			$this->setKey("id_alumno", $id);
			$row_m=$this->DevuelveFila("alumnos");
			
			$this->CometerTransaccion();
			$this->Desconectar();
			return $row_m;
		}catch(Exception $e){
			$this->DeshacerTransaccion();
			echo $e;
		}
	}
	function obtener_familia_alumno($id_alumno){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();
			
			$this->setKey("id_alumno", $id_alumno);
			$row_m=$this->DevuelveFila("alumnos_familia");
			$id_familia=$row_m["id_familia"];
			
			$this->CometerTransaccion();
			$this->Desconectar();
			return $id_familia;
		}catch(Exception $e){
			$this->DeshacerTransaccion();
			echo $e;
		}

	}
	function consultar_familia_alumno($id){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();
			
			$qf=$this->EjecutarConsulta("SELECT f.*, IF(f.tutor='1',f.nombre_p,f.nombre_m) AS padre_tutor FROM alumnos_datos_familia f WHERE f.id_familia='".$id."'");
			$row_m=mysql_fetch_array($qf);

			/*$this->setKey("id_familia", $id);
			$row_m=$this->DevuelveFila("alumnos_datos_familia");*/
			
			$this->CometerTransaccion();
			$this->Desconectar();
			return $row_m;
		}catch(Exception $e){
			$this->DeshacerTransaccion();
			echo $e;
		}
	}


	function obtener_sql_personas($id){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();

			$sql=$this->EjecutarConsulta("SELECT * FROM alumnos_datos_personas WHERE id_alumno='".$id."' ORDER BY id_persona ASC");
			
			$this->CometerTransaccion();
			$this->Desconectar();
			return $sql;
		}catch(Exception $e){
			$this->DeshacerTransaccion();
			echo $e;
		}
	}
	function consultar_salud_alumno($id){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();
			$this->setKey("id_alumno", $id);
			$row_m=$this->DevuelveFila("alumnos_datos_salud");
			
			$this->CometerTransaccion();
			$this->Desconectar();
			return $row_m;
		}catch(Exception $e){
			//$this->DeshacerTransaccion();
			echo $e;
		}
	}
	function consultar_fiscal_alumno($id){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();
			$this->setKey("id_alumno", $id);
			$row_m=$this->DevuelveFila("alumnos_datos_fiscales");
			
			$this->CometerTransaccion();
			$this->Desconectar();
			return $row_m;
		}catch(Exception $e){
			//$this->DeshacerTransaccion();
			echo $e;
		}
	}
	function consultar_hermanos($id_familia){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();

			$q="SELECT * FROM alumnos_datos_hermanos WHERE id_familia='".$id_familia."' ORDER BY edad ASC";
			$sql=$this->EjecutarConsulta($q);
			
			$this->CometerTransaccion();
			$this->Desconectar();
			return $sql;
		}catch(Exception $e){
			$this->DeshacerTransaccion();
			echo $e;
		}
	}
	function consultar_casa($id_familia){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();
			$this->setKey("id_familia", $id_familia);
			$row=$this->DevuelveFila("alumnos_datos_casa");
			
			$this->CometerTransaccion();
			$this->Desconectar();
			return $row;
		}catch(Exception $e){
			//$this->DeshacerTransaccion();
			echo $e;
		}
	}
	function consultar_procedencia($id){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();
			$this->setKey("id_alumno", $id);
			$row_m=$this->DevuelveFila("alumnos_datos_procedencia");
			
			$this->CometerTransaccion();
			$this->Desconectar();
			return $row_m;
		}catch(Exception $e){
			//$this->DeshacerTransaccion();
			echo $e;
		}
	}
	function consultar_datos_yuc($id){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();
			$this->setKey("id_alumno", $id);
			$row_m=$this->DevuelveFila("alumnos_datos_yuc");
			
			$this->CometerTransaccion();
			$this->Desconectar();
			return $row_m;
		}catch(Exception $e){
			//$this->DeshacerTransaccion();
			echo $e;
		}
	}

	function consultar_datos_yuc_transporte($id){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();
			$this->setKey("id_alumno", $id);
			$row_m=$this->DevuelveFila("alumnos_datos_yuc_transporte");
			
			$this->CometerTransaccion();
			$this->Desconectar();
			return $row_m;
		}catch(Exception $e){
			//$this->DeshacerTransaccion();
			echo $e;
		}
	}

	function consultar_datos_yuc_servicios($id){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();
			$this->setKey("id_alumno", $id);
			$row_m=$this->DevuelveFila("alumnos_datos_yuc_servicios");
			
			$this->CometerTransaccion();
			$this->Desconectar();
			return $row_m;
		}catch(Exception $e){
			//$this->DeshacerTransaccion();
			echo $e;
		}
	}

	function consultar_alumno_id_transporte($id){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();
			$qf=$this->EjecutarConsulta("SELECT id_transporte_alumno FROM alumnos_datos_yuc_transporte WHERE id_alumno='".$id."'");
			$row_m=mysql_fetch_array($qf);
			
			$this->CometerTransaccion();
			$this->Desconectar();
			return $row_m['id_transporte_alumno'];
		}catch(Exception $e){
			$this->DeshacerTransaccion();
			echo $e;
		}
	}

	function consultar_estatus_alumno($id){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();
			
			$this->setKey("id_alumno", $id);
			$row=$this->DevuelveFila("alumnos_datos_yuc_estatus");
			
			$this->CometerTransaccion();
			$this->Desconectar();
			return $row;
		}catch(Exception $e){
			$this->DeshacerTransaccion();
			echo $e;
		}
	}
	
	function obtener_sql_personas_autorizadas_transporte($id){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();
			$sql=$this->EjecutarConsulta("SELECT * FROM pers_autorizadas_transp_alumno_yuc WHERE id_transporte_alumno='".$id."' ORDER BY id_persona_autorizada ASC");
			
			$this->CometerTransaccion();
			$this->Desconectar();
			return $sql;
		}catch(Exception $e){
			$this->DeshacerTransaccion();
			echo $e;
		}
	}

	function consultar_datos_yuc_optativas($id_grupo){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();
			$qf=$this->EjecutarConsulta("SELECT grado, letra, (SELECT descrip FROM niveles WHERE id_nivel=(SELECT id_nivel FROM grupos WHERE id_grupo='".$id_grupo."')) as nnivel, (SELECT nombre_ciclo FROM ciclos WHERE id_ciclo=(SELECT id_ciclo FROM grupos WHERE id_grupo='".$id_grupo."')) as nciclo FROM grupos WHERE id_grupo='".$id_grupo."'");
			$row_m=mysql_fetch_array($qf);
			
			$this->CometerTransaccion();
			$this->Desconectar();
			return $row_m;
		}catch(Exception $e){
			$this->DeshacerTransaccion();
			echo $e;
		}
	}

	function consultar_datos_yuc_optativas_alumno($id){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();
			$qf=$this->EjecutarConsulta("SELECT nombre, apellido_p, apellido_m FROM alumnos WHERE id_alumno='".$id."'");
			$row_m=mysql_fetch_array($qf);
			
			$this->CometerTransaccion();
			$this->Desconectar();
			return $row_m;
		}catch(Exception $e){
			$this->DeshacerTransaccion();
			echo $e;
		}
	}

	function consultar_datos_yuc_optativas_materias($id){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();
			$qf=$this->EjecutarConsulta("SELECT g.*, m.materia as nmateria FROM materias_grupo g LEFT JOIN materias m ON m.id_materia=g.id_materia WHERE id_grupo='".$id."' AND m.optativa='1' ORDER BY posicion ASC");
			
			$this->CometerTransaccion();
			$this->Desconectar();
			return $qf;
		}catch(Exception $e){
			$this->DeshacerTransaccion();
			echo $e;
		}
	}

/*	function consultar_datos_yuc_optativas_materias_alumno($id, $id_grupo){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();
			$qf=$this->EjecutarConsulta("SELECT ma.id_mat_alumno as idMat_alumo, (select id_materia from materias_grupo where id_grupo='".$id_grupo."') as id_materia FROM materias_alumnos ma LEFT JOIN materias_grupo mg ON mg.id_materia_grupo=ma.id_materia_grupo WHERE ma.id_alumno='".$id."'");
			$sql=$this->EjecutarConsulta($qf);
			
			$this->CometerTransaccion();
			$this->Desconectar();
			return $qf;
		}catch(Exception $e){
			$this->DeshacerTransaccion();
			echo $e;
		}
	}*/
	
	function guardar_alumno_mat_optativas(){

		try{
			$this->Conectar();
			$this->IniciarTransaccion();
			
			$q=$this->EjecutarConsulta("SELECT MAX(ma.posicion) AS pos FROM materias_alumnos ma LEFT JOIN materias_grupo mg ON mg.id_materia_grupo=ma.id_materia_grupo LEFT JOIN grupos g ON g.id_grupo=mg.id_grupo WHERE ma.id_alumno='".$_POST["id_alumno"]."' AND g.id_grupo='".$_POST["id_grupo"]."'");
			$rw=mysql_fetch_array($q);	mysql_free_result($q);
			$pos=((int)$rw["pos"]+1);
			
			$qf=$this->EjecutarConsulta("SELECT g.* FROM materias_grupo g LEFT JOIN materias m ON m.id_materia=g.id_materia WHERE id_grupo='".$_POST["id_grupo"]."' AND m.optativa='1' ORDER BY posicion ASC");
			
			while($row=mysql_fetch_array($qf)){			
				$q2=$this->EjecutarConsulta("SELECT ma.id_mat_alumno FROM materias_alumnos ma LEFT JOIN materias_grupo mg ON mg.id_materia_grupo=ma.id_materia_grupo WHERE ma.id_alumno='".$_POST["id_alumno"]."' AND ma.id_materia_grupo='".$row["id_materia_grupo"]."'");
				
				$rw2=mysql_fetch_array($q2);
				$idm=$row["id_materia_grupo"];
				$id_mat=$_POST["materia_".$idm];

				if($rw2["id_mat_alumno"]!=""){
					if($id_mat==$row["id_materia_grupo"]){
						//$this->setValue("id_materia_grupo",$idm);
						//$this->setValue("id_alumno",$_POST['id_alumno']);
						//$this->Actualizar("materias_alumno");
						$mensaje = 'Materias Optativas Guardadas Correctamente';
					}else{
						$this->setKey("id_mat_alumno",$rw2["id_mat_alumno"]);
						$this->Eliminar("materias_alumnos");
						$mensaje = 'Materias Optativas Guardadas Correctamente';
					}
				}else{
					if(!empty($_POST["materia_".$idm])){
						$this->setValue("id_materia_grupo",$idm);
						$this->setValue("id_alumno",$_POST['id_alumno']);
						$this->setValue("posicion",$pos);
						$this->Insertar("materias_alumnos");
						$pos++;
						$mensaje = 'Materias Optativas Guardadas Correctamente';
					}
				}
			}
			$this->CometerTransaccion();
			$this->Desconectar();
			$var="mensaje=".$mensaje;
			return $var;
		}catch(Exception $e){
			$this->DeshacerTransaccion();
			echo $e;
		}
	}

	function guardar_alumno(){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();
				
			if($_POST["id_alumno"]==""){

				$this->setValueMayus("nombre",$_POST["nombre"]);
				$this->setValueMayus("apellido_p",$_POST["apaterno"]);  	
				$this->setValueMayus("apellido_m",$_POST["amaterno"]); 	
				$this->setValueFecha("fecha_nac",$_POST["fecha_nac"]); 
				$this->setValue("sexo",$_POST["sexo"]); 						
				$this->setValueMayus("curp",$_POST["curp"]);
				$this->setValueMayus("direccion",$_POST["direccion_alumno"]);
				$this->setValue("tel",$_POST["tel_alumno"]);
				$this->setValue("email",$_POST["email_alumno"]);
				$this->setValue("fecha_alta",date("Y-m-d")); 						
				$this->Insertar("alumnos");
				$id=$this->UltimoID();
				$mensaje = 'Alumno Insertado Correctamente';
				
				if($id!=""){
					////////// AUMENTAR FOLIO	//////////
					/*$this->setValue("folio",$sig_folio);
					$this->setKey("id_folio",1);
					$this->Actualizar("foliador_matricula");*/
					
					///////// DATOS FAMILIA	////////////
					if($_POST["id_familia"]!=""){
						$this->setValue("id_familia", $_POST["id_familia"]);
						$this->setValue("id_alumno", $id);
						$this->Insertar("alumnos_familia");
						$id_familia=$_POST["id_familia"];
					}else{
						$tipo_par=array("","p","m","t");
						if($_POST["tipo_1"]=="1"){ $t=$tipo_par[1]; }elseif($_POST["tipo_1"]=="2"){ $t=$tipo_par[2]; 
						}elseif($_POST["tipo_1"]=="3"){ $t=$tipo_par[3]; }else{ $t="";}
						if($t!=""){
//							echo $t."-"."nombre_".$t.$_POST["nombre_1"]."<br />";
							$this->setValueMayus("nombre_".$t,$_POST["nombre_1"]);
							$this->setValueMayus("direccion_".$t,$_POST["direccion_1"]);
							$this->setValueMayus("trabajo_".$t,$_POST["lugar_trabajo_1"]);
							$this->setValue("tel_trabajo_".$t,$_POST["tel_trabajo_1"]);
							$this->setValue("cel_".$t,$_POST["cel_1"]);
							$this->setValue("email_".$t,$_POST["email_1"]);
							$this->setValue("tel_".$t,$_POST["tel_1"]);
							$this->setValueMayus("profesion_".$t,$_POST["profesion_1"]);
							$this->setValue("puesto_".$t,$_POST["puesto_1"]);
							$this->setValue("direccion_trabajo_".$t,$_POST["direccion_trabajo_1"]);
							$this->setValue("horario_".$t,$_POST["horario_1"]);
							$this->setValue("cel_compania_".$t,$_POST["cel_compania_1"]);
						}
						if($_POST["tipo_2"]=="1"){ $t=$tipo_par[1]; }elseif($_POST["tipo_2"]=="2"){ $t=$tipo_par[2]; 
						}elseif($_POST["tipo_2"]=="3"){ $t=$tipo_par[3]; }else{ $t="";}
						if($t!=""){
//							echo $t."-"."nombre_".$t.$_POST["nombre_2"]."<br />";
							$this->setValueMayus("nombre_".$t,$_POST["nombre_2"]);
							$this->setValueMayus("direccion_".$t,$_POST["direccion_2"]);
							$this->setValueMayus("trabajo_".$t,$_POST["lugar_trabajo_2"]);
							$this->setValue("tel_trabajo_".$t,$_POST["tel_trabajo_2"]);
							$this->setValue("cel_".$t,$_POST["cel_2"]);
							$this->setValue("email_".$t,$_POST["email_2"]);
							$this->setValue("tel_".$t,$_POST["tel_2"]);
							$this->setValueMayus("profesion_".$t,$_POST["profesion_2"]);
							$this->setValue("puesto_".$t,$_POST["puesto_2"]);
							$this->setValue("direccion_trabajo_".$t,$_POST["direccion_trabajo_2"]);
							$this->setValue("horario_".$t,$_POST["horario_2"]);
							$this->setValue("cel_compania_".$t,$_POST["cel_compania_2"]);
						}
						if($_POST["tipo_3"]=="1"){ $t=$tipo_par[1]; }elseif($_POST["tipo_3"]=="2"){ $t=$tipo_par[2]; 
						}elseif($_POST["tipo_3"]=="3"){ $t=$tipo_par[3]; }else{ $t="";}
						if($t!=""){
//							echo $t."-"."nombre_".$t.$_POST["nombre_3"]."<br />";
							$this->setValueMayus("nombre_".$t,$_POST["nombre_3"]);
							$this->setValueMayus("direccion_".$t,$_POST["direccion_3"]);
							$this->setValueMayus("trabajo_".$t,$_POST["lugar_trabajo_3"]);
							$this->setValue("tel_trabajo_".$t,$_POST["tel_trabajo_3"]);
							$this->setValue("cel_".$t,$_POST["cel_3"]);
							$this->setValue("email_".$t,$_POST["email_3"]);
							$this->setValue("tel_".$t,$_POST["tel_3"]);
							$this->setValueMayus("profesion_".$t,$_POST["profesion_3"]);
							$this->setValue("puesto_".$t,$_POST["puesto_3"]);
							$this->setValue("direccion_trabajo_".$t,$_POST["direccion_trabajo_3"]);
							$this->setValue("horario_".$t,$_POST["horario_3"]);
							$this->setValue("cel_compania_".$t,$_POST["cel_compania_3"]);
						}
						$this->setValueMayus("tutor",$_POST["tutor"]);
						$this->setValueMayus("nombre_fam",$_POST["nombre_fam"]);
						$this->setValue("cel_fam",$_POST["cel_fam"]);
						$this->setValue("parentesco_fam",$_POST["parentesco_fam"]);
						$this->setValue("tel_fam",$_POST["tel_fam"]);
						$this->setValue("trabajo_fam",$_POST["lugar_trabajo_fam"]);
						$this->setValue("cel_compania_fam",$_POST["cel_compania_fam"]);
						$a=$this->Insertar("alumnos_datos_familia");					
						$id_familia=$this->UltimoID();
						
						$this->setValue("id_familia", $id_familia);
						$this->setValue("id_alumno", $id);
						$this->Insertar("alumnos_familia");
					}
					
					///// HERMANOS	///////////
					$hermanos=$_POST["fhermano"];					
					$edad=$_POST["fedad"];
					$id_h=$_POST["fid_hermano"];
					$cont=$_POST["contadorfilas_h"];
					for($i=1; $i<$cont; $i++){ 
						if($hermanos[$i]!=""){
							$this->setKey("id_familia", $id_familia);
							$this->setKey("id_hermano", $id_h);
							$rwh=$this->DevuelveFila("alumnos_datos_hermanos");
							
							$this->setValueMayus("nombre",$hermanos[$i]);
							$this->setValue("edad",$edad[$i]);
							$this->setValue("id_familia", $id_familia);
							if($rwh["id_hermano"]==""){
								$this->Insertar("alumnos_datos_hermanos");
							}else{
								$this->setKey("id_hermano",$rwh["id_hermano"]);
								$this->Actualizar("alumnos_datos_hermanos");
							}
						}else{
							if($id_h[$i]!=""){
								$this->EjecutarConsulta("DELETE FROM alumnos_datos_hermanos WHERE id_hermano='".$id_h."'");
							}
						}
					}
					
					////// DATOS DE PERSONAS AUTORIZADAS ///////
					/*for($j=1; $j<=3; $j++){
						if($_POST["nombre_auto".$j]!=""){
							$band=0;
							$name=$_FILES["foto_auto".$j]["name"];
							$tmp_name=$_FILES["foto_auto".$j]["tmp_name"];
							$n=explode(".",$name);
							$c_n=count($n);
							$dir="fotos/personas/";
							if(!file_exists($dir)){ mkdir($dir,0777);}
							$foto=$id."persona".$j.".".$n[1];
							@unlink($dir.$foto);
							if($name!=""){
								$band=resamplear($tmp_name,$dir.$foto,0,150,1);
								if($band==1){
									$mensaje.="<br />Foto de la Persona Autorizada ".$j." fue Insertada Correctamente";
								}else{ $mensaje.="<br />Foto de la Persona Autorizada ".$j." NO Insertada";}
							}						
							$this->setValue("nombre",$_POST["nombre_auto".$j]);
							$this->setValue("apellido_p",$_POST["apellido_p_auto".$j]);
							$this->setValue("apellido_m",$_POST["apellido_m_auto".$j]);
							$this->setValue("direccion",$_POST["direccion_auto".$j]);
							$this->setValue("parentesco",$_POST["parentesco_auto".$j]);
							$this->setValue("telefono",$_POST["tel_auto".$j]);
							$this->setValue("celular",$_POST["cel__auto".$j]);
							if($band==1){
								$this->setValue("foto",$foto);
							}
							if($_POST["id_persona".$j]!=""){
								$this->setValue("id_alumno",$id);
								$this->setKey("id_persona",$_POST["id_persona".$j]);
								$this->Actualizar("alumnos_datos_personas");								
							}else{
								$this->setValue("id_alumno",$id);
								$this->Insertar("alumnos_datos_personas");
							}
						}
					}*/
					
					////// DATOS SALUD-URGENCIAS	///////
					$this->setValue("tipo_sangre",$_POST["tipo_sangre"]);
					$this->setValue("limitaciones",$_POST["limitaciones"]);
					$this->setValue("alergias",$_POST["alergias"]);
					$this->setValue("padecimiento",$_POST["padecimiento"]);
					$this->setValue("observaciones",$_POST["observ"]);
					$this->setValue("medico",$_POST["medico"]);
					$this->setValue("cel_medico",$_POST["cel_medico"]);
					$this->setValue("trabajo_medico",$_POST["trabajo_medico"]);
					$this->setValue("tel_medico",$_POST["tel_medico"]);
					$this->setValue("id_alumno",$id);
					$b=$this->Insertar("alumnos_datos_salud");
					
					///// DATOS FISCALES	///////
					if($_POST["prestacion"]==1){ $presta=1; }else{ $presta=0; }
					$this->setValue("rfc",$_POST["rfc"]);
					$this->setValue("razon_social",$_POST["razon_social"]);
					$this->setValue("direccion_fiscal",$_POST["direccion_fiscal"]);
					$this->setValue("cp_fiscal",$_POST["cp_fiscal"]);
					//$this->setValue("ciudad_fiscal",$_POST["ciudad_fiscal"]);
					$this->setValue("calle_fiscal",$_POST["calle_fiscal"]);
					$this->setValue("nexterior_fiscal",$_POST["nexterior_fiscal"]);
					$this->setValue("ninterior_fiscal",$_POST["ninterior_fiscal"]);
					$this->setValue("colonia_fiscal",$_POST["colonia_fiscal"]);
					$this->setValue("referencia_fiscal",$_POST["referencia_fiscal"]);
					$this->setValue("municipio_fiscal",$_POST["municipio_fiscal"]);
					$this->setValue("pais_fiscal",$_POST["pais_fiscal"]);
					$this->setValue("localidad_fiscal",$_POST["localidad_fiscal"]);
					$this->setValue("email_fiscal",$_POST["email_fiscal"]);
					$this->setValue("estado_fiscal",$_POST["estado_fiscal"]);
					$this->setValue("prestacion",$presta);
					$this->setValue("id_alumno",$id);
					$c=$this->Insertar("alumnos_datos_fiscales");
					
					//// PERSONAS CASA	///////////
					/*$this->setKey("id_alumno", $id);
					$rwf=$this->DevuelveFila("alumnos_familia");
					$id_familia=$rwf["id_familia"];
					
					$this->setKey("id_familia",$id_familia);
					$rwc=$this->DevuelveFila("alumnos_datos_casa");
					
					$this->setValue("mama",$_POST["mama"]);
					$this->setValue("papa",$_POST["papa"]);
					$this->setValue("hermanos",$_POST["hermanos"]);
					$this->setValue("h_quienes",$_POST["quienesh"]);
					$this->setValue("abuelitos_p",$_POST["abuelitos_p"]);
					$this->setValue("abuelitos_m",$_POST["abuelitos_m"]);
					$this->setValue("num_tias",$_POST["tia"]);
					$this->setValue("num_tios",$_POST["tio"]);
					$this->setValue("nom_tias",$_POST["tia_nombre"]);
					$this->setValue("nom_tios",$_POST["tio_nombre"]);
					$this->setValue("otros",$_POST["otros"]);
					$this->setValue("id_familia",$id_familia);
					if($rwc["id_personas"]==""){
						$this->Insertar("alumnos_datos_casa");
					}else{
						$id_casa=$rwc["id_personas"];
						$this->setKey("id_personas", $id_casa);
						$this->Actualizar("alumnos_datos_casa");
					}*/
					//// PROCEDENCIA	//////////
					$this->setValue("escuela_proc",$_POST["escuela_proc"]);
					$this->setValue("practica",$_POST["practica"]);
					$this->setValue("cuales",$_POST["cuales"]);
					$this->setValue("observaciones",$_POST["observaciones"]);
					$this->setValue("id_alumno",$id);
					$this->Insertar("alumnos_datos_procedencia");
					
					//// EXTRA -DETALLES	///////
					/*$q=$this->EjecutarConsulta("SELECT * FROM alumnos_preguntas_detalles ORDER BY id_pregunta ASC");
					while($rw=mysql_fetch_array($q)){
						$id_preg=$rw["id_pregunta"];
						$r1=$_POST[$id_preg];
						$r2=$_POST[$id_preg.'_R'];
						$cual=$_POST[$id_preg.'_cual'];
						$this->setValue("id_alumno",$id);
						$this->setValue("id_pregunta",$id_preg);
						$this->setValue("R1",$r1);
						$this->setValue("R2",$r2);
						$this->setValue("cual",$cual);
						$this->Insertar("alumnos_datos_detalles");
					}*/	
				}				
			}else{		//////////// ACTUALIZAR ALUMNO	////////////////
				$id=$_POST["id_alumno"];
				$this->setValueMayus("nombre",$_POST["nombre"]);
				$this->setValueMayus("apellido_p",$_POST["apaterno"]);  	
				$this->setValueMayus("apellido_m",$_POST["amaterno"]); 	
				$this->setValueFecha("fecha_nac",$_POST["fecha_nac"]); 
				$this->setValue("sexo",$_POST["sexo"]); 						
				$this->setValueMayus("curp",$_POST["curp"]);				
				$this->setValueMayus("direccion",$_POST["direccion_alumno"]);
				$this->setValue("tel",$_POST["tel_alumno"]);
				$this->setValue("email",$_POST["email_alumno"]);
				$this->setKey("id_alumno", $id);
				$this->Actualizar("alumnos");
				
				if($id!=""){
				///////// DATOS FAMILIA	////////////
					$this->setKey("id_alumno", $_POST["id_alumno"]);
					$rw=$this->DevuelveFila("alumnos_familia");
					
					$tipo_par=array("","p","m","t");
					
					if($_POST["id_familia"]=="" && $_POST["nuevo"]==1){ 
						if($_POST["tipo_1"]=="1"){ $t=$tipo_par[1]; }elseif($_POST["tipo_1"]=="2"){ $t=$tipo_par[2]; 
						}elseif($_POST["tipo_1"]=="3"){ $t=$tipo_par[3]; }else{ $t="";}
						if($t!=""){
							$this->setValueMayus("nombre_".$t,$_POST["nombre_1"]);
							$this->setValueMayus("direccion_".$t,$_POST["direccion_1"]);
							$this->setValueMayus("trabajo_".$t,$_POST["lugar_trabajo_1"]);
							$this->setValue("tel_trabajo_".$t,$_POST["tel_trabajo_1"]);
							$this->setValue("cel_".$t,$_POST["cel_1"]);
							$this->setValue("email_".$t,$_POST["email_1"]);
							$this->setValue("tel_".$t,$_POST["tel_1"]);
							$this->setValueMayus("profesion_".$t,$_POST["profesion_1"]);
							$this->setValue("puesto_".$t,$_POST["puesto_1"]);
							$this->setValue("direccion_trabajo_".$t,$_POST["direccion_trabajo_1"]);
							$this->setValue("horario_".$t,$_POST["horario_1"]);
							$this->setValue("cel_compania_".$t,$_POST["cel_compania_1"]);
						}
						if($_POST["tipo_2"]=="1"){ $t=$tipo_par[1]; }elseif($_POST["tipo_2"]=="2"){ $t=$tipo_par[2]; 
						}elseif($_POST["tipo_2"]=="3"){ $t=$tipo_par[3]; }else{ $t="";}
						if($t!=""){
							$this->setValueMayus("nombre_".$t,$_POST["nombre_2"]);
							$this->setValueMayus("direccion_".$t,$_POST["direccion_2"]);
							$this->setValueMayus("trabajo_".$t,$_POST["lugar_trabajo_2"]);
							$this->setValue("tel_trabajo_".$t,$_POST["tel_trabajo_2"]);
							$this->setValue("cel_".$t,$_POST["cel_2"]);
							$this->setValue("email_".$t,$_POST["email_2"]);
							$this->setValue("tel_".$t,$_POST["tel_2"]);
							$this->setValueMayus("profesion_".$t,$_POST["profesion_2"]);
							$this->setValue("puesto_".$t,$_POST["puesto_2"]);
							$this->setValue("direccion_trabajo_".$t,$_POST["direccion_trabajo_2"]);
							$this->setValue("horario_".$t,$_POST["horario_2"]);
							$this->setValue("cel_compania_".$t,$_POST["cel_compania_2"]);
						}
						if($_POST["tipo_3"]=="1"){ $t=$tipo_par[1]; }elseif($_POST["tipo_3"]=="2"){ $t=$tipo_par[2]; 
						}elseif($_POST["tipo_3"]=="3"){ $t=$tipo_par[3]; }else{ $t="";}
						if($t!=""){
							$this->setValueMayus("nombre_".$t,$_POST["nombre_3"]);
							$this->setValueMayus("direccion_".$t,$_POST["direccion_3"]);
							$this->setValueMayus("trabajo_".$t,$_POST["lugar_trabajo_3"]);
							$this->setValue("tel_trabajo_".$t,$_POST["tel_trabajo_3"]);
							$this->setValue("cel_".$t,$_POST["cel_3"]);
							$this->setValue("email_".$t,$_POST["email_3"]);
							$this->setValue("tel_".$t,$_POST["tel_3"]);
							$this->setValueMayus("profesion_".$t,$_POST["profesion_3"]);
							$this->setValue("puesto_".$t,$_POST["puesto_3"]);
							$this->setValue("direccion_trabajo_".$t,$_POST["direccion_trabajo_3"]);
							$this->setValue("horario_".$t,$_POST["horario_3"]);
							$this->setValue("cel_compania_".$t,$_POST["cel_compania_3"]);
						}
						$this->setValueMayus("tutor",$_POST["tutor"]);						
						$this->setValueMayus("nombre_fam",$_POST["nombre_fam"]);
						$this->setValue("cel_fam",$_POST["cel_fam"]);
						$this->setValue("parentesco_fam",$_POST["parentesco_fam"]);
						$this->setValue("tel_fam",$_POST["tel_fam"]);
						$this->setValue("trabajo_fam",$_POST["lugar_trabajo_fam"]);
						$this->setValue("cel_compania_fam",$_POST["cel_compania_fam"]);
						$a=$this->Insertar("alumnos_datos_familia");
						$id_familia=$this->UltimoID();
	
						$this->setValue("id_familia", $id_familia);
						$this->setValue("id_alumno", $id);
						$this->Insertar("alumnos_familia");
						
					}elseif($_POST["id_familia"]!="" && $_POST["nuevo"]==1){
						if($_POST["tipo_1"]=="1"){ $t=$tipo_par[1]; }elseif($_POST["tipo_1"]=="2"){ $t=$tipo_par[2]; 
						}elseif($_POST["tipo_1"]=="3"){ $t=$tipo_par[3]; }else{ $t="";}
						if($t!=""){
							$this->setValueMayus("nombre_".$t,$_POST["nombre_1"]);
							$this->setValueMayus("direccion_".$t,$_POST["direccion_1"]);
							$this->setValueMayus("trabajo_".$t,$_POST["lugar_trabajo_1"]);
							$this->setValue("tel_trabajo_".$t,$_POST["tel_trabajo_1"]);
							$this->setValue("cel_".$t,$_POST["cel_1"]);
							$this->setValue("email_".$t,$_POST["email_1"]);
							$this->setValue("tel_".$t,$_POST["tel_1"]);
							$this->setValueMayus("profesion_".$t,$_POST["profesion_1"]);
							$this->setValue("puesto_".$t,$_POST["puesto_1"]);
							$this->setValue("direccion_trabajo_".$t,$_POST["direccion_trabajo_1"]);
							$this->setValue("horario_".$t,$_POST["horario_1"]);
							$this->setValue("cel_compania_".$t,$_POST["cel_compania_1"]);
						}
						if($_POST["tipo_2"]=="1"){ $t=$tipo_par[1]; }elseif($_POST["tipo_2"]=="2"){ $t=$tipo_par[2]; 
						}elseif($_POST["tipo_2"]=="3"){ $t=$tipo_par[3]; }else{ $t="";}
						if($t!=""){
							$this->setValueMayus("nombre_".$t,$_POST["nombre_2"]);
							$this->setValueMayus("direccion_".$t,$_POST["direccion_2"]);
							$this->setValueMayus("trabajo_".$t,$_POST["lugar_trabajo_2"]);
							$this->setValue("tel_trabajo_".$t,$_POST["tel_trabajo_2"]);
							$this->setValue("cel_".$t,$_POST["cel_2"]);
							$this->setValue("email_".$t,$_POST["email_2"]);
							$this->setValue("tel_".$t,$_POST["tel_2"]);
							$this->setValueMayus("profesion_".$t,$_POST["profesion_2"]);
							$this->setValue("puesto_".$t,$_POST["puesto_2"]);
							$this->setValue("direccion_trabajo_".$t,$_POST["direccion_trabajo_2"]);
							$this->setValue("horario_".$t,$_POST["horario_2"]);
							$this->setValue("cel_compania_".$t,$_POST["cel_compania_2"]);
						}
						if($_POST["tipo_3"]=="1"){ $t=$tipo_par[1]; }elseif($_POST["tipo_3"]=="2"){ $t=$tipo_par[2]; 
						}elseif($_POST["tipo_3"]=="3"){ $t=$tipo_par[3]; }else{ $t="";}
						if($t!=""){
							$this->setValueMayus("nombre_".$t,$_POST["nombre_3"]);
							$this->setValueMayus("direccion_".$t,$_POST["direccion_3"]);
							$this->setValueMayus("trabajo_".$t,$_POST["lugar_trabajo_3"]);
							$this->setValue("tel_trabajo_".$t,$_POST["tel_trabajo_3"]);
							$this->setValue("cel_".$t,$_POST["cel_3"]);
							$this->setValue("email_".$t,$_POST["email_3"]);
							$this->setValue("tel_".$t,$_POST["tel_3"]);
							$this->setValueMayus("profesion_".$t,$_POST["profesion_3"]);
							$this->setValue("puesto_".$t,$_POST["puesto_3"]);
							$this->setValue("direccion_trabajo_".$t,$_POST["direccion_trabajo_3"]);
							$this->setValue("horario_".$t,$_POST["horario_3"]);
							$this->setValue("cel_compania_".$t,$_POST["cel_compania_3"]);
						}
						$this->setValueMayus("tutor",$_POST["tutor"]);
						$this->setValueMayus("nombre_fam",$_POST["nombre_fam"]);
						$this->setValue("cel_fam",$_POST["cel_fam"]);
						$this->setValue("parentesco_fam",$_POST["parentesco_fam"]);
						$this->setValue("tel_fam",$_POST["tel_fam"]);
						$this->setValue("trabajo_fam",$_POST["lugar_trabajo_fam"]);
						$this->setValue("cel_compania_fam",$_POST["cel_compania_fam"]);
						$a=$this->Insertar("alumnos_datos_familia");
						$id_familia=$this->UltimoID();

						$this->setValue("id_familia", $id_familia);
						$this->setValue("id_alumno", $id);
						$this->setKey("id_relacion",$rw["id_relacion"]); 
						$this->Actualizar("alumnos_familia");
						
					}elseif($_POST["id_familia"]!="" && $_POST["nuevo"]==0){
						if($rw["id_familia"]!="" && $rw["id_familia"]==$_POST["id_familia"]){
							if($_POST["tipo_1"]=="1"){ $t=$tipo_par[1]; }elseif($_POST["tipo_1"]=="2"){ $t=$tipo_par[2]; 
							}elseif($_POST["tipo_1"]=="3"){ $t=$tipo_par[3]; }else{ $t="";}
							if($t!=""){
								$this->setValueMayus("nombre_".$t,$_POST["nombre_1"]);
								$this->setValueMayus("direccion_".$t,$_POST["direccion_1"]);
								$this->setValueMayus("trabajo_".$t,$_POST["lugar_trabajo_1"]);
								$this->setValue("tel_trabajo_".$t,$_POST["tel_trabajo_1"]);
								$this->setValue("cel_".$t,$_POST["cel_1"]);
								$this->setValue("email_".$t,$_POST["email_1"]);
								$this->setValue("tel_".$t,$_POST["tel_1"]);
								$this->setValueMayus("profesion_".$t,$_POST["profesion_1"]);
								$this->setValue("puesto_".$t,$_POST["puesto_1"]);
								$this->setValue("direccion_trabajo_".$t,$_POST["direccion_trabajo_1"]);
								$this->setValue("horario_".$t,$_POST["horario_1"]);
								$this->setValue("cel_compania_".$t,$_POST["cel_compania_1"]);
							}
							if($_POST["tipo_2"]=="1"){ $t=$tipo_par[1]; }elseif($_POST["tipo_2"]=="2"){ $t=$tipo_par[2]; 
							}elseif($_POST["tipo_2"]=="3"){ $t=$tipo_par[3]; }else{ $t="";}
							if($t!=""){
								$this->setValueMayus("nombre_".$t,$_POST["nombre_2"]);
								$this->setValueMayus("direccion_".$t,$_POST["direccion_2"]);
								$this->setValueMayus("trabajo_".$t,$_POST["lugar_trabajo_2"]);
								$this->setValue("tel_trabajo_".$t,$_POST["tel_trabajo_2"]);
								$this->setValue("cel_".$t,$_POST["cel_2"]);
								$this->setValue("email_".$t,$_POST["email_2"]);
								$this->setValue("tel_".$t,$_POST["tel_2"]);
								$this->setValueMayus("profesion_".$t,$_POST["profesion_2"]);
								$this->setValue("puesto_".$t,$_POST["puesto_2"]);
								$this->setValue("direccion_trabajo_".$t,$_POST["direccion_trabajo_2"]);
								$this->setValue("horario_".$t,$_POST["horario_2"]);
								$this->setValue("cel_compania_".$t,$_POST["cel_compania_2"]);
							}
							if($_POST["tipo_3"]=="1"){ $t=$tipo_par[1]; }elseif($_POST["tipo_3"]=="2"){ $t=$tipo_par[2]; 
							}elseif($_POST["tipo_3"]=="3"){ $t=$tipo_par[3]; }else{ $t="";}
							if($t!=""){
								$this->setValueMayus("nombre_".$t,$_POST["nombre_3"]);
								$this->setValueMayus("direccion_".$t,$_POST["direccion_3"]);
								$this->setValueMayus("trabajo_".$t,$_POST["lugar_trabajo_3"]);
								$this->setValue("tel_trabajo_".$t,$_POST["tel_trabajo_3"]);
								$this->setValue("cel_".$t,$_POST["cel_3"]);
								$this->setValue("email_".$t,$_POST["email_3"]);
								$this->setValue("tel_".$t,$_POST["tel_3"]);
								$this->setValueMayus("profesion_".$t,$_POST["profesion_3"]);
								$this->setValue("puesto_".$t,$_POST["puesto_3"]);
								$this->setValue("direccion_trabajo_".$t,$_POST["direccion_trabajo_3"]);
								$this->setValue("horario_".$t,$_POST["horario_3"]);
								$this->setValue("cel_compania_".$t,$_POST["cel_compania_3"]);
							}
							$this->setValue("tutor",$_POST["tutor"]);
							$this->setValueMayus("nombre_fam",$_POST["nombre_fam"]);
							$this->setValue("cel_fam",$_POST["cel_fam"]);
							$this->setValue("parentesco_fam",$_POST["parentesco_fam"]);
							$this->setValue("tel_fam",$_POST["tel_fam"]);
							$this->setValue("trabajo_fam",$_POST["lugar_trabajo_fam"]);
							$this->setValue("cel_compania_fam",$_POST["cel_compania_fam"]);
							$this->setKey("id_familia", $_POST["id_familia"]);
							$this->Actualizar("alumnos_datos_familia");
							
						}elseif($rw["id_familia"]!="" && $rw["id_familia"]!=$_POST["id_familia"]){
						
							if($_POST["tipo_1"]=="1"){ $t=$tipo_par[1]; }elseif($_POST["tipo_1"]=="2"){ $t=$tipo_par[2]; 
							}elseif($_POST["tipo_1"]=="3"){ $t=$tipo_par[3]; }else{ $t="";}
							if($t!=""){
								$this->setValueMayus("nombre_".$t,$_POST["nombre_1"]);
								$this->setValueMayus("direccion_".$t,$_POST["direccion_1"]);
								$this->setValueMayus("trabajo_".$t,$_POST["lugar_trabajo_1"]);
								$this->setValue("tel_trabajo_".$t,$_POST["tel_trabajo_1"]);
								$this->setValue("cel_".$t,$_POST["cel_1"]);
								$this->setValue("email_".$t,$_POST["email_1"]);
								$this->setValue("tel_".$t,$_POST["tel_1"]);
								$this->setValueMayus("profesion_".$t,$_POST["profesion_1"]);
								$this->setValue("puesto_".$t,$_POST["puesto_1"]);
								$this->setValue("direccion_trabajo_".$t,$_POST["direccion_trabajo_1"]);
								$this->setValue("horario_".$t,$_POST["horario_1"]);
								$this->setValue("cel_compania_".$t,$_POST["cel_compania_1"]);
							}
							if($_POST["tipo_2"]=="1"){ $t=$tipo_par[1]; }elseif($_POST["tipo_2"]=="2"){ $t=$tipo_par[2]; 
							}elseif($_POST["tipo_2"]=="3"){ $t=$tipo_par[3]; }else{ $t="";}
							if($t!=""){
								$this->setValueMayus("nombre_".$t,$_POST["nombre_2"]);
								$this->setValueMayus("direccion_".$t,$_POST["direccion_2"]);
								$this->setValueMayus("trabajo_".$t,$_POST["lugar_trabajo_2"]);
								$this->setValue("tel_trabajo_".$t,$_POST["tel_trabajo_2"]);
								$this->setValue("cel_".$t,$_POST["cel_2"]);
								$this->setValue("email_".$t,$_POST["email_2"]);
								$this->setValue("tel_".$t,$_POST["tel_2"]);
								$this->setValueMayus("profesion_".$t,$_POST["profesion_2"]);
								$this->setValue("puesto_".$t,$_POST["puesto_2"]);
								$this->setValue("direccion_trabajo_".$t,$_POST["direccion_trabajo_2"]);
								$this->setValue("horario_".$t,$_POST["horario_2"]);
								$this->setValue("cel_compania_".$t,$_POST["cel_compania_2"]);
							}
							if($_POST["tipo_3"]=="1"){ $t=$tipo_par[1]; }elseif($_POST["tipo_3"]=="2"){ $t=$tipo_par[2]; 
							}elseif($_POST["tipo_3"]=="3"){ $t=$tipo_par[3]; }else{ $t="";}
							if($t!=""){
								$this->setValueMayus("nombre_".$t,$_POST["nombre_3"]);
								$this->setValueMayus("direccion_".$t,$_POST["direccion_3"]);
								$this->setValueMayus("trabajo_".$t,$_POST["lugar_trabajo_3"]);
								$this->setValue("tel_trabajo_".$t,$_POST["tel_trabajo_3"]);
								$this->setValue("cel_".$t,$_POST["cel_3"]);
								$this->setValue("email_".$t,$_POST["email_3"]);
								$this->setValue("tel_".$t,$_POST["tel_3"]);
								$this->setValueMayus("profesion_".$t,$_POST["profesion_3"]);
								$this->setValue("puesto_".$t,$_POST["puesto_3"]);
								$this->setValue("direccion_trabajo_".$t,$_POST["direccion_trabajo_3"]);
								$this->setValue("horario_".$t,$_POST["horario_3"]);
								$this->setValue("cel_compania_".$t,$_POST["cel_compania_3"]);
							}
							$this->setValue("tutor",$_POST["tutor"]);
							$this->setValueMayus("nombre_fam",$_POST["nombre_fam"]);
							$this->setValue("cel_fam",$_POST["cel_fam"]);
							$this->setValue("parentesco_fam",$_POST["parentesco_fam"]);
							$this->setValue("tel_fam",$_POST["tel_fam"]);
							$this->setValue("trabajo_fam",$_POST["lugar_trabajo_fam"]);
							$this->setValue("cel_compania_fam",$_POST["cel_compania_fam"]);
							$this->setKey("id_familia", $_POST["id_familia"]);
							$a=$this->Actualizar("alumnos_datos_familia");
							
							$this->setValue("id_familia", $_POST["id_familia"]);
							$this->setValue("id_alumno", $id);
							$this->setKey("id_relacion", $rw["id_relacion"]);
							$this->Actualizar("alumnos_familia");
							
						}elseif($rw["id_familia"]=="" && $_POST["id_familia"]!=""){
							if($_POST["tipo_1"]=="1"){ $t=$tipo_par[1]; }elseif($_POST["tipo_1"]=="2"){ $t=$tipo_par[2]; 
							}elseif($_POST["tipo_1"]=="3"){ $t=$tipo_par[3]; }else{ $t="";}
							if($t!=""){
								$this->setValueMayus("nombre_".$t,$_POST["nombre_1"]);
								$this->setValueMayus("direccion_".$t,$_POST["direccion_1"]);
								$this->setValueMayus("trabajo_".$t,$_POST["lugar_trabajo_1"]);
								$this->setValue("tel_trabajo_".$t,$_POST["tel_trabajo_1"]);
								$this->setValue("cel_".$t,$_POST["cel_1"]);
								$this->setValue("email_".$t,$_POST["email_1"]);
								$this->setValue("tel_".$t,$_POST["tel_1"]);
								$this->setValueMayus("profesion_".$t,$_POST["profesion_1"]);
								$this->setValue("puesto_".$t,$_POST["puesto_1"]);
								$this->setValue("direccion_trabajo_".$t,$_POST["direccion_trabajo_1"]);
								$this->setValue("horario_".$t,$_POST["horario_1"]);
								$this->setValue("cel_compania_".$t,$_POST["cel_compania_1"]);
							}
							if($_POST["tipo_2"]=="1"){ $t=$tipo_par[1]; }elseif($_POST["tipo_2"]=="2"){ $t=$tipo_par[2]; 
							}elseif($_POST["tipo_2"]=="3"){ $t=$tipo_par[3]; }else{ $t="";}
							if($t!=""){
								$this->setValueMayus("nombre_".$t,$_POST["nombre_2"]);
								$this->setValueMayus("direccion_".$t,$_POST["direccion_2"]);
								$this->setValueMayus("trabajo_".$t,$_POST["lugar_trabajo_2"]);
								$this->setValue("tel_trabajo_".$t,$_POST["tel_trabajo_2"]);
								$this->setValue("cel_".$t,$_POST["cel_2"]);
								$this->setValue("email_".$t,$_POST["email_2"]);
								$this->setValue("tel_".$t,$_POST["tel_2"]);
								$this->setValueMayus("profesion_".$t,$_POST["profesion_2"]);
								$this->setValue("puesto_".$t,$_POST["puesto_2"]);
								$this->setValue("direccion_trabajo_".$t,$_POST["direccion_trabajo_2"]);
								$this->setValue("horario_".$t,$_POST["horario_2"]);
								$this->setValue("cel_compania_".$t,$_POST["cel_compania_2"]);
							}
							if($_POST["tipo_3"]=="1"){ $t=$tipo_par[1]; }elseif($_POST["tipo_3"]=="2"){ $t=$tipo_par[2]; 
							}elseif($_POST["tipo_3"]=="3"){ $t=$tipo_par[3]; }else{ $t="";}
							if($t!=""){
								$this->setValueMayus("nombre_".$t,$_POST["nombre_3"]);
								$this->setValueMayus("direccion_".$t,$_POST["direccion_3"]);
								$this->setValueMayus("trabajo_".$t,$_POST["lugar_trabajo_3"]);
								$this->setValue("tel_trabajo_".$t,$_POST["tel_trabajo_3"]);
								$this->setValue("cel_".$t,$_POST["cel_3"]);
								$this->setValue("email_".$t,$_POST["email_3"]);
								$this->setValue("tel_".$t,$_POST["tel_3"]);
								$this->setValueMayus("profesion_".$t,$_POST["profesion_"]);
								$this->setValue("puesto_".$t,$_POST["puesto_3"]);
								$this->setValue("direccion_trabajo_".$t,$_POST["direccion_trabajo_3"]);
								$this->setValue("horario_".$t,$_POST["horario_3"]);
								$this->setValue("cel_compania_".$t,$_POST["cel_compania_3"]);
							}
							$this->setValue("tutor",$_POST["tutor"]);
							$this->setValueMayus("nombre_fam",$_POST["nombre_fam"]);
							$this->setValue("cel_fam",$_POST["cel_fam"]);
							$this->setValueMayus("parentesco_fam",$_POST["parentesco_fam"]);
							$this->setValue("tel_fam",$_POST["tel_fam"]);
							$this->setValue("trabajo_fam",$_POST["lugar_trabajo_fam"]);
							$this->setValue("cel_compania_fam",$_POST["cel_compania_fam"]);
							$this->setKey("id_familia", $_POST["id_familia"]);
							$a=$this->Actualizar("alumnos_datos_familia");
							
							$this->setValue("id_familia", $_POST["id_familia"]);
							$this->setValue("id_alumno", $id);
							$this->Insertar("alumnos_familia");
						}
					}
					if($_POST["id_familia"]!=""){ $id_familia=$_POST["id_familia"]; }
					
					///// HERMANOS	///////////
					$hermanos=$_POST["fhermano"];					
					$edad=$_POST["fedad"];
					$id_h=$_POST["fid_hermano"];
					$cont=$_POST["contadorfilas_h"];
					for($i=1; $i<$cont; $i++){ 
						if($hermanos[$i]!=""){
							$this->setKey("id_familia", $id_familia);
							$this->setKey("id_hermano", $id_h[$i]);
							$rwh=$this->DevuelveFila("alumnos_datos_hermanos");
							
							$this->setValueMayus("nombre",$hermanos[$i]);
							$this->setValue("edad",$edad[$i]);
							$this->setValue("id_familia", $id_familia);
							if($rwh["id_hermano"]==""){
								$this->Insertar("alumnos_datos_hermanos");
							}else{
								$this->setKey("id_hermano",$rwh["id_hermano"]);
								$this->Actualizar("alumnos_datos_hermanos");
							}
						}else{
							if($id_h[$i]!=""){
								$this->EjecutarConsulta("DELETE FROM alumnos_datos_hermanos WHERE id_hermano='".$id_h[$i]."'");
							}
						}
					}
					////// DATOS DE PERSONAS AUTORIZADAS ///////
					/*for($j=1; $j<=3; $j++){
						if($_POST["nombre_auto".$j]!=""){
							$band=0;
							$name=$_FILES["foto_auto".$j]["name"];
							$tmp_name=$_FILES["foto_auto".$j]["tmp_name"];
							$n=explode(".",$name);
							$c_n=count($n);
							$dir="fotos/personas/";
							if(!file_exists($dir)){ mkdir($dir,0777);}
							$foto=$id."persona".$j.".".$n[1];
							@unlink($dir.$foto);
							if($name!=""){
								$band=resamplear($tmp_name,$dir.$foto,0,150,1);
								if($band==1){
									$mensaje.="<br />Foto de la Persona Autorizada ".$j." fue Insertada Correctamente";
								}else{ $mensaje.="<br />Foto de la Persona Autorizada ".$j." NO Insertada";}
							}						
							$this->setValue("nombre",$_POST["nombre_auto".$j]);
							$this->setValue("apellido_p",$_POST["apellido_p_auto".$j]);
							$this->setValue("apellido_m",$_POST["apellido_m_auto".$j]);
							$this->setValue("direccion",$_POST["direccion_auto".$j]);
							$this->setValue("parentesco",$_POST["parentesco_auto".$j]);
							$this->setValue("telefono",$_POST["tel_auto".$j]);
							$this->setValue("celular",$_POST["cel__auto".$j]);
							if($band==1){
								$this->setValue("foto",$foto);
							}
							if($_POST["id_persona".$j]!=""){
								$this->setValue("id_alumno",$id);
								$this->setKey("id_persona",$_POST["id_persona".$j]);
								$this->Actualizar("alumnos_datos_personas");								
							}else{
								$this->setValue("id_alumno",$id);
								$this->Insertar("alumnos_datos_personas");
							}
						}
					}*/

					///////// DATOS SALUD-URGENCIAS	///////
					$this->setKey("id_alumno",$id);
					$rw_s=$this->DevuelveFila("alumnos_datos_salud");
					
					$this->setValue("tipo_sangre",$_POST["tipo_sangre"]);
					$this->setValue("limitaciones",$_POST["limitaciones"]);
					$this->setValue("alergias",$_POST["alergias"]);
					$this->setValue("padecimiento",$_POST["padecimiento"]);
					$this->setValue("observaciones",$_POST["observ"]);
					$this->setValue("medico",$_POST["medico"]);
					$this->setValue("cel_medico",$_POST["cel_medico"]);
					$this->setValue("trabajo_medico",$_POST["trabajo_medico"]);
					$this->setValue("tel_medico",$_POST["tel_medico"]);
					if($rw_s["id_expediente"]!=""){
						$this->setKey("id_alumno",$id);
						$b=$this->Actualizar("alumnos_datos_salud");
					}else{
						$this->setValue("id_alumno",$id);
						$this->Insertar("alumnos_datos_salud");
					}
					///// DATOS FISCALES	///////
					if($_POST["prestacion"]==1){ $presta=1; }else{ $presta=0; }
					$this->setValue("rfc",$_POST["rfc"]);
					$this->setValue("razon_social",$_POST["razon_social"]);
					$this->setValue("direccion_fiscal",$_POST["direccion_fiscal"]);
					$this->setValue("cp_fiscal",$_POST["cp_fiscal"]);
					//$this->setValue("ciudad_fiscal",$_POST["ciudad_fiscal"]);
					$this->setValue("calle_fiscal",$_POST["calle_fiscal"]);
					$this->setValue("nexterior_fiscal",$_POST["nexterior_fiscal"]);
					$this->setValue("ninterior_fiscal",$_POST["ninterior_fiscal"]);
					$this->setValue("colonia_fiscal",$_POST["colonia_fiscal"]);
					$this->setValue("referencia_fiscal",$_POST["referencia_fiscal"]);
					$this->setValue("municipio_fiscal",$_POST["municipio_fiscal"]);
					$this->setValue("pais_fiscal",$_POST["pais_fiscal"]);
					$this->setValue("localidad_fiscal",$_POST["localidad_fiscal"]);
					$this->setValue("email_fiscal",$_POST["email_fiscal"]);
					$this->setValue("estado_fiscal",$_POST["estado_fiscal"]);
					$this->setValue("prestacion",$presta);
					$this->setKey("id_alumno",$id);
					$c=$this->Actualizar("alumnos_datos_fiscales");
					
					//// PERSONAS CASA	//////////
					/*$this->setKey("id_alumno", $id);
					$rwf=$this->DevuelveFila("alumnos_familia");
					$id_familia=$rwf["id_familia"];
					
					$this->setKey("id_familia",$id_familia);
					$rwc=$this->DevuelveFila("alumnos_datos_casa");
					
					$this->setValue("mama",$_POST["mama_ksa"]);
					$this->setValue("papa",$_POST["papa_ksa"]);
					$this->setValue("hermanos",$_POST["hermanos_ksa"]);
					$this->setValue("h_quienes",$_POST["quienes_h_ksa"]);
					$this->setValue("abuelitos_p",$_POST["abuelitos_p_ksa"]);
					$this->setValue("abuelitos_m",$_POST["abuelitos_m_ksa"]);
					$this->setValue("num_tias",$_POST["tia_ksa"]);
					$this->setValue("num_tios",$_POST["tio_ksa"]);
					$this->setValue("nom_tias",$_POST["tia_nombre_ksa"]);
					$this->setValue("nom_tios",$_POST["tio_nombre_ksa"]);
					$this->setValue("otros",$_POST["otros_ksa"]);
					$this->setValue("id_familia",$id_familia);
					if($rwc["id_personas"]==""){
						$d=$this->Insertar("alumnos_datos_casa");
					}else{
						$id_casa=$rwc["id_personas"];
						$this->setKey("id_personas", $id_casa);
						$d=$this->Actualizar("alumnos_datos_casa");
					}*/
					
					//// PROCEDENCIA	//////////
					$this->setValue("escuela_proc",$_POST["escuela_procede"]);
					$this->setValue("practica",$_POST["practica_procede"]);
					$this->setValue("cuales",$_POST["cuales_procede"]);
					$this->setValue("observaciones",$_POST["observaciones_procede"]);
					if($_POST["id_procedencia"]==""){
						$this->Insertar("alumnos_datos_procedencia");
					}else{
						$this->setKey("id_alumno",$id);
						$e=$this->Actualizar("alumnos_datos_procedencia");
					}
					//// EXTRA -DETALLES	///////
					/*$q=$this->EjecutarConsulta("SELECT * FROM alumnos_preguntas_detalles ORDER BY id_pregunta ASC");
					while($rw=mysql_fetch_array($q)){
						$id_preg=$rw["id_pregunta"];
						$this->setKey("id_alumno",$id);
						$this->setKey("id_pregunta", $id_preg);
						$rw2=$this->DevuelveFila("alumnos_datos_detalles");
						$id_detalle=$rw2["id_detalle"];
						$r1=$_POST[$id_preg];
						$r2=$_POST[$id_preg.'_R'];
						$cual=$_POST[$id_preg.'_cual'];
						$this->setValue("id_alumno",$id);
						$this->setValue("id_pregunta",$id_preg);
						$this->setValue("R1",$r1);
						$this->setValue("R2",$r2);
						$this->setValue("cual",$cual);
						if($id_detalle==""){
							$f=$this->Insertar("alumnos_datos_detalles");
						}else{
							$this->setKey("id_detalle",$id_detalle);
							$f=$this->Actualizar("alumnos_datos_detalles");
						}
					}	*/				
				}
				$mensaje = 'Alumno Actualizado Correctamente.';
			}
			
			//// SITUACION FAMILIA	/////
			$this->setValue("situacion_padres",$_POST["situacion_padres"]);
			$this->setValue("situacion_otros",$_POST["situacion_otros"]);
			$this->setValueMayus("lugar_familia",$_POST["lugar_familia"]);
			$this->setValue("num_her_h",$_POST["num_her_h"]);
			$this->setValue("num_her_m",$_POST["num_her_m"]);
			$this->setValue("vive_con",$_POST["vive_con"]);
			$this->setValue("vive_otros",$_POST["vive_otros"]);
			if($_POST["id_datos_yuc"]!=""){
				$this->setKey("id_datos_yuc",$_POST["id_datos_yuc"]);
				$this->Actualizar("alumnos_datos_yuc");				
			}else{
				$this->setValue("id_alumno",$id);
				$this->Insertar("alumnos_datos_yuc");
			}	
			
			/////// DOCUMENTOS RECIBIDOS
			for($i=1; $i<=12; $i++){				
				$rw=$this->obtener_fila_doc($i, $id);
				if($i!=12){
					for($k=1; $k<=3; $k++){ 
						if($k<3){
							$op=$_POST["D".$i."_".$k];
							$this->setValue("op".$k, $op);
						}
						if($i!=11){ 
							$op=$_POST["D".$i."_".$k];
							$this->setValue("otro",$op);
						}
					}
				}else{
					$op=$_POST["D".$i];
					$this->setValueMayus("otro",$op);
				}
				$this->setValue("documento", $i);
				if($rw["id_doc"]!=""){
					$this->setKey("id_doc",$rw["id_doc"]);
					$this->Actualizar("alumnos_documentos");
				}else{
					$this->setValue("id_alumno",$id);
					$this->Insertar("alumnos_documentos");
				}
			}//// FIN DOCUMENTOS
			
			// guardar transporte alumnos //
			$b_transporte=0;
			if(!empty($_POST["calle_trans"]) || !empty($_POST["numero_trans"]) || !empty($_POST["cruzamientos_trans"])){
				$this->setValue("calle",$_POST["calle_trans"]);
				$this->setValue("numero",$_POST["numero_trans"]);
				$this->setValue("cruzamientos",$_POST["cruzamientos_trans"]);
				$this->setValue("colonia",$_POST["colonia_trans"]);
				$this->setValue("cp",$_POST["cp_trans"]);
				$this->setValue("referencia",$_POST["referencia_trans"]);
				$this->setValue("cuota_inicial",$_POST["cuota_inicial_trans"]);
				$this->setValueFecha("fecha_inicio",$_POST["fecha_inicio_trans"]);
				
				if($_POST["id_transporte_alumno"]!=""){
					$this->setKey("id_transporte_alumno",$_POST["id_transporte_alumno"]);
					$this->Actualizar("alumnos_datos_yuc_transporte");	
					//$this->EjecutarConsulta("DELETE FROM pers_autorizadas_transp_alumno_yuc WHERE id_transporte_alumno='".$_POST["id_transporte_alumno"]."'");
					$b_transporte=1;
				}else{
					$this->setValue("id_alumno",$id);
					$this->Insertar("alumnos_datos_yuc_transporte");
					$myId_transporte=$this->UltimoID();
					$b_transporte=1;
				}	
			}
			//guardar personas autorizadas transporte			
			if($b_transporte==1){
				if(!empty($_POST["id_transporte_alumno"])){ 
					$id_transporte=$_POST["id_transporte_alumno"];
					$this->EjecutarConsulta("DELETE FROM pers_autorizadas_transp_alumno_yuc WHERE id_transporte_alumno='".$_POST["id_transporte_alumno"]."'");

				}else{ 
					$id_transporte=$myId_transporte;
				}
				for($it=1; $it<=$_POST['cuantaspersonas']; $it++){	
					$this->setValue("id_transporte_alumno",$id_transporte);
					$this->setValue("nombre_completo",$_POST["nombre_completo_trans".$it]);
					$this->setValue("parentesco",$_POST["parentesco_trans".$it]);
					$this->setValue("telefono_casa",$_POST["tel_casa_trans".$it]);
					$this->setValue("telefono_trabajo",$_POST["tel_trabajo_trans".$it]);
					$this->setValue("telefono_celular",$_POST["celular_trans".$it]);
					if(!empty($id_transporte) && !empty($_POST["nombre_completo_trans".$it]) &&  !empty($_POST["parentesco_trans".$it])){	
						$this->Insertar("pers_autorizadas_transp_alumno_yuc");
					}
				
				}
			}
			
			//guardar servicios
			$this->setValue("estancia",$_POST["radio_estancia"]);
			$this->setValue("transporte",$_POST["radio_transporte"]);
			
			if($_POST["id_servicio_alumno"]!=""){
				$this->setKey("id_servicio_alumno",$_POST["id_servicio_alumno"]);
				$this->Actualizar("alumnos_datos_yuc_servicios");	
			}else{
				$this->setValue("id_alumno",$id);
				$this->Insertar("alumnos_datos_yuc_servicios");
			}	
			
			///GUARDAR ESTATUS ALUMNO
			$nuevo=($_POST["estado_alumno_nuevo"]==1?1:0);
			$reingreso=($_POST["estado_alumno_reingreso"]==1?1:0);
			$repetidor=($_POST["estado_alumno_repetidor"]==1?1:0);
			$this->setValue("nuevo",$nuevo);
			$this->setValue("reingreso",$reingreso);
			$this->setValue("repetidor",$repetidor);
			if($_POST["id_estatus"]!=""){
				$this->setKey("id_estatus", $_POST["id_estatus"]);
				$this->Actualizar("alumnos_datos_yuc_estatus");
			}else{
				$this->setValue("id_alumno", $id);
				$this->Insertar("alumnos_datos_yuc_estatus");
			}
			
			//// FOTO ALUMNO
			$tmp_name=$_FILES["foto"]["tmp_name"];
			$name=$_FILES["foto"]["name"];
			$n=explode(".",$name);
			$c_n=count($n);
			chmod("fotos/alumnos/", 0777);
			$dir="fotos/alumnos/";
			if(!file_exists($dir)){ mkdir($dir,0777);}
			$foto=$id.".".$n[1];
			@unlink($dir.$foto);
			if($name!=""){
				$band=resamplear($tmp_name,$dir.$foto,0,150,1);
				if($band==1){
					$this->setValue("foto", $foto);
					$this->setKey("id_alumno", $id);
					$this->Actualizar("alumnos");
					$mensaje.="<br />Foto Insertada Correctamente";
				}else{ $mensaje.="<br />Foto NO Insertada";}
			}
			chmod("fotos/alumnos/", 0755);
			
			$this->CometerTransaccion();
			$this->Desconectar();
			$var="id_alumno=".$id."&mensaje=".$mensaje;
			return $var;
		}catch(Exception $e){
			$this->DeshacerTransaccion();
			echo $e;
		}
	}

	function desinscribe_alumno(){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();
			$id = $_GET["id_alumno"];
			//// ELIMINA INSCRIPCION
			// $this->EjecutarConsulta("DELETE FROM alumno_grupo WHERE id_alumno='".$id."' AND id_grupo='".$_GET["id_grupo"]."'");
			$sql="UPDATE alumno_grupo SET estado = '1', fecha_baja='".date("Y-m-d")."', usuario_activa_baja='".$_SESSION["usuario_elabora"]."' WHERE id_alumno='".$id."' AND id_grupo='".$_GET["id_grupo"]."' AND id_relacion='".$_GET["id_relacion"]."'";
			$this->EjecutarConsulta($sql);
			//// ELIMINA BOLETA PAGO
			/*$this->EjecutarConsulta("DELETE FROM boleta_pago WHERE id_alumno='".$id."' AND id_grupo='".$_GET["id_grupo"]."'");
			//// ELIMINA CONCEPTOS ALUMNO
			$q=$this->EjecutarConsulta("SELECT ca.id AS id_concepto_alumno
					   FROM conceptos_alumnos ca 
					   LEFT JOIN conceptos_nivel cn ON ca.id_concepto_nivel = cn.id_concepto_nivel 
					   LEFT JOIN conceptos c ON c.id_concepto = cn.id_concepto 
					   WHERE ca.id_alumno = '".$id."' AND cn.id_ciclo = '".$_GET["id_ciclo"]."' 
					   AND cn.id_nivel = '".$_GET["id_nivel"]."'");
			while($rw=mysql_fetch_array($q)){
				$this->EjecutarConsulta("DELETE FROM conceptos_alumnos WHERE id='".$rw["id_concepto_alumno"]."'");
				$this->EjecutarConsulta("DELETE FROM conceptos_alumnos_mes WHERE id_concepto_alumno='".$rw["id_concepto_alumno"]."'");
			}
			//// ELIMINA MATERIAS ALUMNO
			$q=$this->EjecutarConsulta("SELECT * FROM materias_grupo WHERE id_grupo='".$_GET["id_grupo"]."'");
			while($rw=mysql_fetch_array($q)){
				$this->EjecutarConsulta("DELETE FROM materias_alumnos WHERE id_alumno='".$id."' AND id_materia_grupo='".$rw["id_materia_grupo"]."'");
			}*/
			$var="mensaje=Alumno Desinscrito Correctamente!";
			
			$this->CometerTransaccion();
			$this->Desconectar();
			
			return $var;
		}catch(Exception $e){
			$this->DeshacerTransaccion();
			echo $e;
		}
	}
	
	function obtener_cuotas($id_grupo,$op){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();
			
			$this->setKey("id_grupo",$id_grupo);
			$rw=$this->DevuelveFila("grupos");
			
			if($op==1){
				$sql="select cn.id_concepto_nivel, (SELECT c.descrip FROM conceptos c WHERE c.id_concepto=cn.id_concepto) AS concepto, (SELECT c.importe FROM conceptos c WHERE c.id_concepto=cn.id_concepto) AS importe from conceptos_nivel cn where cn.tipo_c='03' AND cn.id_ciclo='".$rw["id_ciclo"]."' and cn.id_nivel='".$rw["id_nivel"]."' AND cn.grado='".$rw["grado"]."'";
			}else{
				$sql="select cn.id_concepto_nivel, (SELECT c.descrip FROM conceptos c WHERE c.id_concepto=cn.id_concepto) AS concepto, (SELECT c.importe FROM conceptos c WHERE c.id_concepto=cn.id_concepto) AS importe from conceptos_nivel cn where cn.tipo_c='04' and cn.id_ciclo='".$rw["id_ciclo"]."' and cn.id_nivel='".$rw["id_nivel"]."' AND cn.grado='".$rw["grado"]."'";
			}
			
			$q=$this->EjecutarConsulta($sql);
			$rw=mysql_fetch_array($q);
			
			$this->CometerTransaccion();
			$this->Desconectar();
			return $rw;
		}catch(Exception $e){
			$this->DeshacerTransaccion();
			echo $e;
		}		
	}
	function consultar_inscribe($id_alumno){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();

			$this->CometerTransaccion();
			$this->Desconectar();
		}catch(Exception $e){
			$this->DeshacerTransaccion();
			echo $e;
		}		
	}
	function inscribir_alumno(){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();
			
			$sql="SELECT ag.id_relacion FROM alumno_grupo ag 
				LEFT JOIN grupos g ON g.id_grupo=ag.id_grupo 
				WHERE g.id_ciclo='".$_POST["id_ciclo"]."' AND ag.id_alumno='".$_POST["id_alumno"]."' AND estado='0'";

			
			$q=$this->EjecutarConsulta($sql);
			$rw_al=mysql_fetch_array($q);
			
			if($rw_al["id_relacion"]==""){	
				$this->setKey("id_folio",1);
				$rw_f=$this->DevuelveFila("foliador_matricula");
				$max=(int)$rw_f["folio"];	$sig_folio=$max+1;
				//$matricula=generar_matricula($max);

				$q=$this->EjecutarConsulta("select nombre,apellido_p,apellido_m from alumnos where id_alumno='".$_POST["id_alumno"]."'");
				$rw=mysql_fetch_array($q);
				$user=substr($rw["apellido_p"],0,2).substr($rw["apellido_m"],0,1).substr($rw["nombre"],0,1);
				$cambiar=array('á','é','í','ó','ú');
				$por=array('a','e','i','o','u');
				$usuario=strtolower(str_replace($cambiar,$por,$user));		
				for($s='',$i = 0,$z=strlen($a = 'abcdefghijklmnopqrstuvwxyz0123456789')-1; $i!= 6; $x = rand(0,$z), $clave.=$a{$x}, $i++);
				
				$this->setKey("id_alumno",$_POST["id_alumno"]);
				$rw_fam=$this->DevuelveFila("alumnos_familia");
				if($rw_fam["id_familia"]!="" && $rw_fam["user"]=="" && $rw_fam["pass"]){
					$this->setKey("id_familia", $rw_fam["id_familia"]);
					$rw_familia=$this->DevuelveFila("alumnos_datos_familia");
					$fam=explode(" ",$rw_familia["nombre_t"]);
					$num=count($fam);
					$user_p=substr($fam[$num-2],0,2).substr($fam[$num-1],0,2).substr($fam[0],0,2);
					$cambiar=array('á','é','í','ó','ú','Á','É','Í','Ó','Ú');
					$por=array('a','e','i','o','u','A','E','I','0','U');
					$usuario_p=strtolower(str_replace($cambiar,$por,$user_p));		
					for($s='',$i = 0,$z=strlen($a = 'abcdefghijklmnopqrstuvwxyz0123456789')-1; $i!= 6; $x = rand(0,$z), $clave_p.=$a{$x}, $i++);
		
					$this->setValue("user", $usuario_p);
					$this->setValue("pass",$clave_p);
					$this->setKey("id_familia", $rw_fam["id_familia"]);
					$this->Actualizar("alumnos_datos_familia");
				}
				/////////// INSERT alumno_grupo				
				$this->setValue("id_grupo", $_POST["id_grupo"]);
				$this->setValue("id_alumno", $_POST["id_alumno"]);
				$this->setValue("fecha_inscribe", date("Y-m-d"));				
				$this->setValue("ingreso", $_POST["ingreso"]);				
				$this->setValue("repetidor", $_POST["repetidor"]);				
				$this->Insertar("alumno_grupo");
				$id_alum_gpo=$this->UltimoID();


				$qq=$this->EjecutarConsulta("select * from grupos g  where id_grupo='".$_POST["id_grupo"]."'");
				$data=mysql_fetch_array($qq);
				$grado=$data["grado"];
				$nivel=$data["id_nivel"];
				$niv=$data["id_nivel"]."0".$data["grado"];
				$matricula=generar_matricula($niv,$_POST['id_alumno']);

				//////////// ASIGNAR CLAVES ALUMNO
				$this->setValue("matricula",$matricula);			///NO GENERAR MATRICULA MIENTRAS YA ESTA CREADA	
				$this->setValue("user", $usuario);
				$this->setValue("pass",$clave);
				$this->setKey("id_alumno", $_POST["id_alumno"]);
				$this->Actualizar("alumnos");
				//////////// ASIGNAR CLAVES FAMILIA
				/////// ACTUALIZAR MATRICULA	/////
			/*
				$sig_folio_matri=$max+1;
				$this->setValue("folio",$sig_folio_matri);
				$this->setKey("id_folio",1);
				$this->Actualizar("foliador_matricula");
			*/

				/* NIVELES
					0 maternal
					1 kinder
					2 primaria
					3 secundaria
					4 prepa
					5 carrera

				*/

				$sqlgr="SELECT * FROM grupos g where id_grupo=".$_POST["id_grupo"];
				$rwgr=mysql_query($sqlgr);
				$niv=$rwgr["id_nivel"]."0".$rwgr["grado"];
						
				$matricula=generar_matricula($niv,$_POST['id_alumno']);
				$this->setValueMayus("matricula",$matricula);			
				$this->setKey("id_alumno", $_POST["id_alumno"]);
				$this->Actualizar("alumnos");
				
				//////////	AGREGAR MATERIAS AL ALUMNO	///////////////////////
				$q2=$this->EjecutarConsulta("SELECT g.* FROM materias_grupo g LEFT JOIN materias m ON m.id_materia=g.id_materia WHERE id_grupo='".$_POST["id_grupo"]."' AND m.optativa='0' ORDER BY posicion ASC");
				$i=1;
				while($rw2=mysql_fetch_array($q2)){
					$this->setValue("id_materia_grupo", $rw2["id_materia_grupo"]);
					$this->setValue("id_alumno_grupo", $id_alum_gpo);
					$this->setValue("id_alumno", $_POST["id_alumno"]);
					$this->setValue("posicion",$i);					
					$this->Insertar("materias_alumnos");
					$i++;
				}
				//////////	AGREGAR MATERIAS OPTATIVAS AL ALUMNO	///////////////////////
				$q2=$this->EjecutarConsulta("SELECT g.* FROM materias_grupo g LEFT JOIN materias m ON m.id_materia=g.id_materia WHERE id_grupo='".$_POST["id_grupo"]."' AND m.optativa='1' ORDER BY posicion ASC");
				//$i=1;
				while($rw2=mysql_fetch_array($q2)){
					$this->setValue("id_materia_grupo", $rw2["id_materia_grupo"]);
					$this->setValue("id_alumno_grupo", $id_alum_gpo);
					$this->setValue("id_alumno", $_POST["id_alumno"]);
					$this->setValue("posicion",$i);
					$this->Insertar("materias_alumnos");
					$i++;
				}
						/*
				////	ALTA DE BOLETA_PAGO
				$qmes=$this->EjecutarConsulta("select * from meses_pagar where id_ciclo='".$_POST["id_ciclo"]."' order by id asc");
				while($rmes=mysql_fetch_array($qmes)){	$mesciclo[]=$rmes["mes"];	}
				
				$qm=$this->EjecutarConsulta("select * from boleta_pago where id_alumno='".$_POST["id_alumno"]."' AND id_grupo='".$_POST["id_grupo"]."'");
				$rM=mysql_fetch_array($qm);
				$qC=$this->EjecutarConsulta("select * from ciclos where id_ciclo='".$_POST["id_ciclo"]."'");
				$rCiclo=mysql_fetch_array($qC);
				$a1=split("-",$rCiclo["fecha_ini"]);  $anio1=$a1[0];
				$a2=split("-",$rCiclo["fecha_fin"]);  $anio2=$a2[0];
				
				$fecha=date("Y-m-d");
				$fec=$rCiclo["fecha_ini"];
				$fc=explode("-",$fec);
				$hoymk=mktime(0,0,0,date("m"),date("d"),date("Y"));
				$ciclomk=mktime(0,0,0,$fc[1],$fc[2],$fc[0]);;
				
				$this->setValue("id_alumno_grupo", $id_alum_gpo);
				$this->setValue("id_grupo", $_POST["id_grupo"]);
				$this->setValue("id_alumno", $_POST["id_alumno"]);
				if($hoymk > $ciclomk){
					for($i=0;$i<count($mesciclo);$i++){
						if($mesciclo[$i]>=8 && $mesciclo[$i]<=12){ $anio=$anio1;	}else{ $anio=$anio2;	}
						$mes=date("M",mktime(0,0,0,$mesciclo[$i],1,$anio));
						$meshoy=date("n");
						$mk_hoy=mktime(0,0,0,date("m"),date("d"),date("Y"));
						$mk_mes=mktime(0,0,0,$mesciclo[$i],date("t",mktime(0,0,0,$mesciclo[$i],1,$anio)),$anio);
						
						if($mesciclo[$i]==$meshoy){ break;}
						if($mk_hoy > $mk_mes){ //if($fec<$fecha){
							$meses_pag.="`".$mes."`, ";
							$values_pag.=" '1',";
							$this->setValue($mes, 1);
						}
					}
				}
				$this->setValue("inscrip", 0);
				$this->Insertar("boleta_pago");
				//$this->EjecutarConsulta("INSERT INTO boleta_pago(id_grupo, id_alumno, ".$meses_pag." inscrip) VALUES('".$idCiclo."', '".$idNivel."', '".$idAlumno."', ".$values_pag." '0')");
				////////////// CONCEPTOS INSCRIPCION	////////////////
				$cargo=0; $desc=0;
					*/
				####CAMBIADO XXYYZZ boleta_pago
				/*$this->setValue("id_concepto_nivel", $_POST["id_cuota_insc"]);
				$this->setValue("id_alumno", $_POST["id_alumno"]);
				$this->setValue("id_alumno_grupo", $id_alum_gpo);
				$this->Insertar("conceptos_alumnos");
				$id_conce_alumno=$this->UltimoID();
				$ids_c_a[]=$id_conce_alumno;
				
				$this->setValue("id_concepto_alumno",$id_conce_alumno);
				$this->Insertar("conceptos_alumnos_mes");

				*/
				
										
				$id_insc=$_POST["fid_conce_insc"];
				$imp_insc=$_POST["fimp_insc"];
				$tipo_insc=$_POST["ftipo_insc"];
				for($k=1; $k<=count($id_insc); $k++){
					if($id_insc[$k]!=""){
						$this->setValue("id_concepto_nivel", $id_insc[$k]);
						$this->setValue("id_alumno", $_POST["id_alumno"]);
						$this->setValue("id_alumno_grupo", $id_alum_gpo);
						$this->Insertar("conceptos_alumnos");
						$id_conce_alumno=$this->UltimoID();
						
						$this->setValue("id_concepto_alumno",$id_conce_alumno);
						$this->Insertar("conceptos_alumnos_mes");
						
						if($tipo_insc[$k]=="Cargo"){ 
							$cargo+=$imp_insc[$k]; 
						}else{ 
							$ids_c_a[]=$id_conce_alumno;
							$desc+=$imp_insc[$k]; 
						}
					}
				}
				$sub_insc=$desc;//$cargo-
				////	MARCAR COMO PAGADO
				/*if($_POST["cuota_insc"]==$sub_insc){
					$this->setValue("inscrip",1);
					$this->setKey("id_grupo",$_POST["id_grupo"]);
					$this->setKey("id_alumno",$_POST["id_alumno"]);
					$this->Actualizar("boleta_pago");
					
					for($c_a=0; $c_a<count($ids_c_a); $c_a++){
						$this->setValue("estatus",1);
						$this->setKey("id_concepto_alumno",$ids_c_a[$c_a]);
						$this->Actualizar("conceptos_alumnos_mes");						
					}
				}*/
				
				
				////////////////// CUOTA COLEGIATURA		//////////////////
				$this->setValue("id_concepto_nivel", $_POST["id_cuota_cole"]);
				$this->setValue("id_alumno", $_POST["id_alumno"]);
				$this->setValue("id_alumno_grupo", $id_alum_gpo);
				$this->Insertar("conceptos_alumnos");
				$id_conce_alumno=$this->UltimoID();
				$ids_c_b[]=$id_conce_alumno;
				for($i=0;$i<count($mesciclo);$i++){
					$this->setValue("id_concepto_alumno",$id_conce_alumno);
					$this->setValue("mes",$mesciclo[$i]);
					$this->Insertar("conceptos_alumnos_mes");
				}

				////////////////// CONCEPTOS COLEGIATURA	//////////////////
				$cargo_c=0; $desc_c=0;
				$id_cole=$_POST["fid_conce_cole"];
				$imp_cole=$_POST["fimp_cole"];
				$tipo_cole=$_POST["ftipo_cole"];
				for($k=1; $k<=count($id_cole); $k++){
					if($id_cole[$k]!=""){
						$this->setValue("id_concepto_nivel", $id_cole[$k]);
						$this->setValue("id_alumno", $_POST["id_alumno"]);
						$this->setValue("id_alumno_grupo", $id_alum_gpo);
						$this->Insertar("conceptos_alumnos");
						$id_conce_alumno=$this->UltimoID();					
						for($i=0;$i<count($mesciclo);$i++){
							$this->setValue("id_concepto_alumno",$id_conce_alumno);
							$this->setValue("mes",$mesciclo[$i]);
							$this->Insertar("conceptos_alumnos_mes");
							if($tipo_cole[$k]!="Cargo"){ $ids_c_b[]=$id_conce_alumno;}
						}
						if($tipo_cole[$k]=="Cargo"){ 
							$cargo_c+=$imp_cole[$k]; 
						}else{ 
							$desc_c+=$imp_cole[$k]; 
						}
					}
				}
				$sub_cole=$desc_c;//$cargo_c-
				////	MARCAR COMO PAGADO
				/*if($_POST["cuota_cole"]==$sub_cole){
					$meses_pagar=""; $values_pagar="";
					for($i=0;$i<count($mesciclo);$i++){
						$mes=date("M",mktime(0,0,0,$mesciclo[$i],1,1));
						$meses_pagar.="`".$mes."`='1'";
						if($i<(count($mesciclo)-1)){ $meses_pagar.=", "; }
						$this->setValue($mes, 1);
					}
					$this->setKey("id_alumno", $_POST["id_alumno"]);
					$this->setKey("id_grupo", $_POST["id_grupo"]);
					$this->Actualizar("boleta_pago");
					
					for($c_a=0; $c_a<count($ids_c_b); $c_a++){
						$this->setValue("estatus",1);
						$this->setKey("id_concepto_alumno",$ids_c_b[$c_a]);
						$this->Actualizar("conceptos_alumnos_mes");						
					}
					//$this->EjecutarConsulta("update boleta_pago set ".$meses_pagar." where idAlumno='".$idAlumno."' AND idCiclo='".$idCiclo."'");
				}///// FIN MARCAR COMO PAGADO
				*/
				$msj="mensaje=Alumno Inscrito Correctamente!";
			}else{ $msj="error"; }
			
			$this->CometerTransaccion();
			$this->Desconectar();
			return $msj;
		}catch(Exception $e){
			$this->DeshacerTransaccion();
			echo $e;
		}		
	}
	
	function generar_claves_alumno(){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();

			$this->setKey("id_alumno", $_POST["id_alumno"]);
			$rw=$this->DevuelveFila("alumnos");
			$user=substr($rw["apellido_p"],0,2).substr($rw["apellido_m"],0,1).substr($rw["nombre"],0,1);
			$cambiar=array('á','é','í','ó','ú');
			$cambiar2=array('Á','É','Í','Ó','Ú');
			$por=array('a','e','i','o','u');
			$usuario=strtolower(str_replace($cambiar,$por,$user));
			$usuario=strtolower(str_replace($cambiar2,$por,$user));
			for($s='', $i = 0, $z=strlen($a = 'abcdefghijklmnopqrstuvwxyz0123456789')-1; $i!= 5; $x = rand(0,$z), $clave.=$a{$x}, $i++);
			$contrasena=$clave;
			$var[0]=$usuario;
			$var[1]=$contrasena;
			$this->CometerTransaccion();
			$this->Desconectar();
			
			return $var;
		}catch(Exception $e){
			$this->DeshacerTransaccion();
			echo $e;
		}
	}
	function guardar_claves_alumno(){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();
			
			if($_POST["usuario2"]!=""){ $user=$_POST["usuario2"]; }else{ $user=$_POST["usuario"]; }
			if($_POST["contrasena2"]!=""){ $pass=$_POST["contrasena2"]; }else{ $pass=$_POST["contrasena"]; }
			$this->setValue("user",$user);
			$this->setValue("pass",$pass);
			$this->setKey("id_alumno",$_POST["id_alumno"]);
			$this->Actualizar("alumnos");
			$msj="Claves Actualizadas Correctamente";

			$this->CometerTransaccion();
			$this->Desconectar();
			$mensaje="mensaje=".$msj;
			return $mensaje;
		}catch(Exception $e){
			$this->DeshacerTransaccion();
			echo $e;
		}
	}
	
	function guardar_tarea(){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();

			$fecha=date("Y-m-d");
			if($_POST["publicar"]==1){ $publicar=1; }else{ $publicar=""; }
			if($_POST["id_maestro"]!=""){ $tipo_m="maestro"; }else{ $tipo_m=$_SESSION["nivel"]; }
			
			if($_POST["fecha_entrega"]){
				$this->setValueFecha("fecha_entrega",$_POST["fecha_entrega"]); 
			}
			if($_POST["id_tarea"]==""){
				$tarea_name='';
			}else{
				$tarea_name=$_POST["tarea_aux"];
			}
			$this->setValue("id_maestro",$_POST["id_maestro"]);				
			$this->setValue("tipo_maestro",$tipo_m);		
			$this->setValue("id_grupo",$_POST["id_grupo"]);
			$this->setValue("id_ciclo",$_POST["id_ciclo"]);  	
			$this->setValue("id_materia",$_POST["id_materia"]); 	
			$this->setValue("titulo_tarea",$_POST["titulo_tarea"]); 
			$this->setValue("tarea",$tarea_name);
			$this->setValue("observ",$_POST["observ"]);
			$this->setValue("fecha",$fecha);
			$this->setValue("publicar",$publicar);
			
			if($_POST["id_tarea"]==""){
				$this->Insertar("maestro_tareas");
				$id=$this->UltimoID();
				$mensaje = 'Tarea Insertada Correctamente';
			}else{
				$this->setKey("id_tarea", $_POST["id_tarea"]);
				$this->Actualizar("maestro_tareas");
				$id=$_POST["id_tarea"];
				$mensaje = 'Tarea Actualizada Correctamente.';
			}

			if($_FILES['tarea']['name']!=''){
				
				$name=$id."_".$_FILES['tarea']['name'];
				include("ftp_config.php");
				$dir="admin/tareas/"; //$FTP_Root;
				
				$id_con = ftp_connect($FTP_Host);
				$resultado_login = ftp_login($id_con, $FTP_User, $FTP_Pass);
				chmod("tareas/", 0777);
				$nombre_archivo = $dir."/".$name;
				$Local_Resource = $_FILES['tarea']['tmp_name'];
				
				if($id_con!="" && $resultado_login!=""){
					if(ftp_put($id_con, $nombre_archivo, $Local_Resource, FTP_BINARY)){
						$this->setValue("tarea",$name);
						$this->setKey("id_tarea", $id);
						$this->Actualizar("maestro_tareas");
						
						if($name!=$_POST["tarea_aux"]){ @unlink("tareas/".$_POST["tarea_aux"]); }
						ftp_close($id_con);
					}else{
						ftp_close($id_con);
						$mensaje.='<br />No se pudo guardar el archivo.';
					}
				}else{
					$mensaje.='<br />No se pudo conectar via ftp para el guardado del archivo.';
				}
				chmod("tareas/", 0755);
			}

			$this->CometerTransaccion();
			$this->Desconectar();
			$var="id_tarea=".$id."&mensaje=".$mensaje;
			return $var;
		}catch(Exception $e){
			$this->DeshacerTransaccion();
			echo $e;
		}
	}

	function consultar_tarea($id_tarea){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();
			$this->setKey("id_tarea", $id_tarea);
			$row=$this->DevuelveFila("maestro_tareas");
			
			$this->CometerTransaccion();
			$this->Desconectar();
			return $row;
		}catch(Exception $e){
			//$this->DeshacerTransaccion();
			echo $e;
		}
	}

	function guardar_aviso(){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();

			$fecha=date("Y-m-d");
			if($_POST["publicar"]==1){$publicar=1; }else{ $publicar="";}
			if(($_POST["tipo_aviso"])=='general'){$id_alumno='';}else{$id_alumno=$_POST["id_alumno"];}
			if($_POST["id_maestro"]!=""){ $tipo_m="maestro";	}else{ $tipo_m=$_POST["tipo_maestro"];}			
			
			$this->setValue("id_maestro",$_POST["id_maestro"]);				
			$this->setValue("tipo_maestro",$tipo_m);
			$this->setValue("id_grupo",$_POST["id_grupo"]);
			$this->setValue("titulo_aviso",$_POST["titulo_aviso"]); 
			$this->setValue("aviso",$_POST["aviso"]);
			$this->setValue("fecha",$fecha);
			$this->setValue("tipo_aviso",$_POST["tipo_aviso"]);
			$this->setValue("id_alumno",$id_alumno);
			$this->setValue("publicar",$publicar);
			
			if($_POST["id_aviso"]==""){
				$this->Insertar("maestro_avisos");
				
				$id=$this->UltimoID();
				$mensaje = 'Aviso Insertado Correctamente';
			}else{
				$this->setKey("id_aviso", $_POST["id_aviso"]);
				$this->Actualizar("maestro_avisos");

				$id=$_POST["id_aviso"];
				$mensaje = 'Aviso Actualizado Correctamente.';
			}
			
			$this->CometerTransaccion();
			$this->Desconectar();
			$var="id_aviso=".$id."&mensaje=".$mensaje;
			return $var;
		}catch(Exception $e){
			$this->DeshacerTransaccion();
			echo $e;
		}
	}
	
	function validar_existe_conce_alumno($id_con_nivel, $id_alumno){
		$q=$this->EjecutarConsulta("SELECT * FROM conceptos_alumnos WHERE id_concepto_nivel='".$id_con_nivel."' AND id_alumno='".$id_alumno."'");
		$rw=mysql_fetch_array($id_conce);
		
		if($rw["id"]!=""){
			return true;
		}else{
			return false;
		}
	}

	function eliminar_conceptos_alumnos($id_alumno, $ids){
		$mes=date("m");
		
		$sql="SELECT a.*, a.id AS id_concepto_alumno, n.tipo_c, n.id_ciclo  
		FROM conceptos_alumnos a 
			LEFT JOIN conceptos_nivel n ON n.id_concepto_nivel=a.id_concepto_nivel 
		WHERE  a.id_alumno='".$id_alumno."' ";
		if($ids!=""){ $sql.=" AND a.id_concepto_nivel NOT IN (".$ids.") ORDER BY n.tipo_c ASC"; }
		//echo $sql;
		$q=$this->EjecutarConsulta($sql);
		while($rw=mysql_fetch_array($q)){
			$id_ciclo=$rw["id_ciclo"];
			$qm=$this->EjecutarConsulta("SELECT * FROM meses_pagar WHERE id_ciclo='".$id_ciclo."' ORDER BY id ASC");
			$band=0;	$i=0;	$band_conce=0;
			while($rm=mysql_fetch_array($qm)){	
				if($i==0 && $rm["mes"]==$mes){ 	$band_conce=1;	}
				if($rm["mes"]==$mes){	$band=1;	}
				if($band==1){
					$meses[]=$rm["mes"];
				}
				$i++;
			}
			
			if($rw["tipo_c"]=='01'){
				$qm=$this->EjecutarConsulta("SELECT * FROM conceptos_alumnos_mes WHERE id_concepto_alumno='".$rw["id"]."'");
				$rm=mysql_fetch_array($qm);
				if($rm["estatus"]==0){
					if($band_conce==1){
						$this->EjecutarConsulta("DELETE FROM conceptos_alumnos WHERE id_alumno = '".$id_alumno."' AND id_concepto_nivel='".$rw["id_concepto_nivel"]."'");
					}else{
						$this->EjecutarConsulta("UPDATE conceptos_alumnos SET estatus='1' WHERE id_alumno = '".$id_alumno."' AND id_concepto_nivel='".$rw["id_concepto_nivel"]."'");
					}
							
					$this->EjecutarConsulta("DELETE FROM conceptos_alumnos_mes WHERE id_concepto_alumno = '".$rw["id_concepto_alumno"]."' AND mes='0'");
					
				}
			}elseif($rw["tipo_c"]=='02'){				
				$band=1;
				$qm=$this->EjecutarConsulta("SELECT * FROM conceptos_alumnos_mes WHERE id_concepto_alumno='".$rw["id"]."' AND estatus='1'");
				while($rm=mysql_fetch_array($qm)){
					if($rw["id_conce_mes"]!=""){
						$band=0;
						break;
					}
				}
				if($band==1){
					if($band_conce==1){
						$this->EjecutarConsulta("DELETE FROM conceptos_alumnos WHERE id_alumno = '".$id_alumno."' AND id_concepto_nivel='".$rw["id_concepto_nivel"]."'");
					}else{
						$this->EjecutarConsulta("UPDATE conceptos_alumnos SET estatus='1' WHERE id_alumno = '".$id_alumno."' AND id_concepto_nivel='".$rw["id_concepto_nivel"]."'");
					}
					for($i=0; $i<count($meses); $i++){
						$this->EjecutarConsulta("DELETE FROM conceptos_alumnos_mes WHERE id_concepto_alumno = '".$rw["id_concepto_alumno"]."' AND mes='".$meses[$i]."'");
					}
				}
			}		
		}
	}
	function guardar_conceptos(){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();
			
			$id_alumno = $_POST['id_alumno'];
			$descuento_col = $_POST['descuento_col'];
			$cargo_col = $_POST['cargo_col'];
			$descuento_insc = $_POST['descuento_insc'];
			$cargo_insc = $_POST['cargo_insc'];
			$id_ciclo=$_POST["id_ciclo"];
			$id_nivel=$_POST["id_nivel"];
			$id_grupo=$_POST["id_grupo"];
			if($id_ciclo=="" || $id_nivel=="" || $id_grupo==""){
				$cve=split("-",$_POST["ids_grupo"]);
				$id_ciclo=$cve[0];
				$id_nivel=$cve[1];
				$id_grupo=$cve[2];
			}
			$mes_es=date("m");
			$fecha=date("Y-m-d");
			if($id_alumno != ''){
				foreach($id_alumno as $ID){
					// -- descuentos colegiatura -- //
					$ID=(int)$ID;	$ids="";
					//echo $ID."<br />";
					$q_al=$this->EjecutarConsulta("SELECT * FROM alumno_grupo ag WHERE ag.id_alumno='".$ID."' AND ag.id_grupo='".$id_grupo."'");
					$rw_gpo=mysql_fetch_array($q_al);  mysql_free_result($q_al);
					$id_alumno_grupo=$rw_gpo["id_relacion"];
					
					$q_ci=$this->EjecutarConsulta("SELECT * FROM ciclos c WHERE c.id_ciclo='".$id_ciclo."'");
					$rw_ci=mysql_fetch_array($q_ci);  mysql_free_result($q_ci);
					$fecha_ini_ciclo=$rw_ci["fecha_ini"];	$f1=explode("-",$fecha_ini_ciclo);	$anio1=$f1[0];
					$fecha_fin_ciclo=$rw_ci["fecha_fin"];	$f2=explode("-",$fecha_fin_ciclo);	$anio2=$f2[0];
					
					$q_al=$this->EjecutarConsulta("SELECT * FROM boleta_pago b WHERE b.id_alumno='".$ID."' AND b.id_grupo='".$id_grupo."'");
					$rw_bol=mysql_fetch_array($q_al);  mysql_free_result($q_al);
					
					if($descuento_col[$ID] != ''){
						foreach($descuento_col[$ID] as $valor){
							if($valor!=""){
								$desc_col[$ID][]=$valor;
							}
						}

						for($r=0; $r<count($desc_col[$ID]); $r++){
							$id_con_nivel = $desc_col[$ID][$r];
							//echo $id_con_nivel."<br />";
							$q=$this->EjecutarConsulta("SELECT * FROM conceptos_alumnos WHERE id_concepto_nivel='".$id_con_nivel."' AND id_alumno='".$ID."'");
							$rwcc=mysql_fetch_array($q);
							$band_1=0;
							if($rwcc["id"]==""){
								$qc=$this->EjecutarConsulta("select * from conceptos_nivel where id_concepto_nivel='".$id_con_nivel."'");
								$rc=mysql_fetch_array($qc);
								$id_ciclo=$rc["id_ciclo"];

								$this->setValue('id_concepto_nivel',$id_con_nivel);
								$this->setValue('id_alumno',$ID);
								$this->setValue('id_alumno_grupo',$id_alumno_grupo);
								$this->setValue('estatus','0');
								$this->Insertar('conceptos_alumnos');
								$id_conce_alumno=$this->UltimoID();
							}else{
								//echo $rwcc["id"]."--- descuento colegiatrua<br />";
								$this->setKey('id',$rwcc["id"]);
								$this->setValue('id_concepto_nivel',$id_con_nivel);
								$this->setValue('id_alumno',$ID);
								$this->setValue('estatus','0');
								$this->setValue('id_alumno_grupo',$id_alumno_grupo);
								$this->Actualizar('conceptos_alumnos');
								$id_conce_alumno=$rwcc["id"];
								if($rwcc["estatus"]==0){	$band_1=1;	}
							}
							//echo $rw_bol["id_inscripcion"]." ".$id_conce_alumno." ".$band_1."<br />";
							if($id_conce_alumno!=''){//	&& $band_1==0
								$band=0;
								$qm=$this->EjecutarConsulta("SELECT * FROM meses_pagar WHERE id_ciclo='".$id_ciclo."' ORDER BY id ASC");
								while($rm=mysql_fetch_array($qm)){
									$band=0;
									if($rm["mes"]>=8 && $rm["mes"]<=12){ $anio=$anio1;	}else{ $anio=$anio2;	}
									$d_fin=date("t", mktime(0,0,0,$rm["mes"],1,$anio));
									$fecha_fin_mes = date("Y-m-d", mktime(0,0,0,$rm["mes"],$d_fin,$anio));
									
									if( ($mes_es==$rm["mes"]) && ($fecha > $fecha_fin_mes) ){ $band=1; }
									//echo "desc  ($mes_es==".$rm["mes"].") && ($fecha_es > $fecha_fin_mes) ".$band."<br />";
									if($band==0){
										$month_en=date("M",mktime(0,0,0,$rm["mes"],1,date("Y")));
										if($rw_bol[$month_en]==1){ $estatus=1;	}else{ $estatus=0;}
										$qma=$this->EjecutarConsulta("SELECT * FROM conceptos_alumnos_mes WHERE id_concepto_alumno='".$id_conce_alumno."' AND mes='".$rm["mes"]."'");
										$rwma=mysql_fetch_array($qma);
										if($rwma["id_conce_mes"]==''){
											if($estatus!=1){
												$this->setValue('id_concepto_alumno',$id_conce_alumno);
												$this->setValue('mes',$rm["mes"]);
												$this->setValue('estatus','0');
												$this->Insertar('conceptos_alumnos_mes');
											}
										}
									}
								}
							}
							$ids.=$id_con_nivel;
							if($r<(count($descuento_col[$ID])-1)){ $ids.=",";}
						}
						//$this->EjecutarConsulta("DELETE FROM conceptos_alumnos WHERE id_alumno = '".$ID."' AND id_concepto_nivel NOT IN (".$ids.")"  );
					}
					
					// -- cargos colegiatura -- //
					if($cargo_col[$ID] != ''){	if($ids!=""){ $ids.=","; }else{ $ids=""; }
						foreach($cargo_col[$ID] as $valor){
							if($valor!=""){
								$car_col[$ID][]=$valor;
							}
						}
						//echo "<br />cargo=";print_r($car_col[$ID]);
						for($r=0; $r<count($car_col[$ID]); $r++){
							$id_con_nivel = $car_col[$ID][$r];
							$q=$this->EjecutarConsulta("SELECT * FROM conceptos_alumnos WHERE id_concepto_nivel='".$id_con_nivel."' AND id_alumno='".$ID."'");
							$rwcc=mysql_fetch_array($q);
							$band_1=0;
							if($rwcc["id"]==""){
								$qc=$this->EjecutarConsulta("select * from conceptos_nivel where id_concepto_nivel='".$id_con_nivel."'");
								$rc=mysql_fetch_array($qc);
								$id_ciclo=$rc["id_ciclo"];
								//echo $id_con_nivel."<br />";
								$this->setValue('id_concepto_nivel',$id_con_nivel);
								$this->setValue('id_alumno',$ID);
								$this->setValue('id_alumno_grupo',$id_alumno_grupo);
								$this->setValue('estatus','0');
								$this->Insertar('conceptos_alumnos');
								$id_conce_alumno=$this->UltimoID();
							}else{
								$this->setKey('id',$rwcc["id"]);
								$this->setValue('estatus','0');
								$this->setValue('id_alumno_grupo',$id_alumno_grupo);
								$this->Actualizar('conceptos_alumnos');
								$id_conce_alumno=$rwcc["id"];								
								if($rwcc["estatus"]==0){	$band_1=1;	}
							}
							if($id_conce_alumno!=''	&& $band_1==0){
								$band=0;
								$qm=$this->EjecutarConsulta("SELECT * FROM meses_pagar WHERE id_ciclo='".$id_ciclo."' ORDER BY id ASC");
								while($rm=mysql_fetch_array($qm)){
									$band=0;
									if($rm["mes"]>=8 && $rm["mes"]<=12){ $anio=$anio1;	}else{ $anio=$anio2;	}
									$d_fin=date("t", mktime(0,0,0,$rm["mes"],1,$anio));
									$fecha_fin_mes = date("Y-m-d", mktime(0,0,0,$rm["mes"],$d_fin,$anio));
									
									if( ($mes_es==$rm["mes"]) && ($fecha > $fecha_fin_mes) ){ $band=1; }
									//echo "cargos  ".$anio." - ($mes_es==".$rm["mes"].") && ($fecha_es > $fecha_fin_mes) ".$band."<br />";
									if($band==0){
										$month_en=date("M",mktime(0,0,0,$rm["mes"],1,date("Y")));
										if($rw_bol["$month_en"]==1){ $estatus=1;	}else{ $estatus=0;}
										
										$qma=$this->EjecutarConsulta("SELECT * FROM conceptos_alumnos_mes WHERE id_concepto_alumno='".$id_conce_alumno."' AND mes='".$rm["mes"]."'");
										$rwma=mysql_fetch_array($qma);
										if($rwma["id_conce_mes"]==''){
											if($estatus!=1){
												$this->setValue('id_concepto_alumno',$id_conce_alumno);
												$this->setValue('mes',$rm["mes"]);
												$this->setValue('estatus','0');
												$this->Insertar('conceptos_alumnos_mes');
											}
										}
									}
								}
							}
							$ids.=$id_con_nivel;
							if($r<(count($car_col[$ID])-1)){ $ids.=",";}
						}
						//echo $ids;
						//$this->EjecutarConsulta("DELETE FROM conceptos_alumnos WHERE id_alumno = '".$ID."' AND id_concepto_nivel NOT IN (".$ids.")"  );
					}
					
					// -- descuentos inscripcion -- //
					//print_r($_POST);
					//print_r($descuento_insc[$ID]);
					if($descuento_insc[$ID] != ''){	if($ids!=""){ $ids.=","; }
						foreach($descuento_insc[$ID] as $valor){
							if($valor!=""){
								$desc_insc[$ID][]=$valor;
							}
						}
						for($r=0; $r<count($desc_insc[$ID]); $r++){
							$id_con_nivel = $desc_insc[$ID][$r];
							$q=$this->EjecutarConsulta("SELECT * FROM conceptos_alumnos WHERE id_concepto_nivel='".$id_con_nivel."' AND id_alumno='".$ID."'");
							$rwcc=mysql_fetch_array($q);
							//echo $rwcc["id"]."<br />";
							if($rwcc["id"]==""){
								$qc=$this->EjecutarConsulta("select * from conceptos_nivel where id_concepto_nivel='".$id_con_nivel."'");
								$rc=mysql_fetch_array($qc);
								$id_ciclo=$rc["id_ciclo"];
								//echo $id_con_nivel."<br />";
								$this->setValue('id_concepto_nivel',$id_con_nivel);
								$this->setValue('id_alumno',$ID);
								$this->setValue('id_alumno_grupo',$id_alumno_grupo);
								$this->setValue('estatus','0');
								$this->Insertar('conceptos_alumnos');
								$id_conce_alumno=$this->UltimoID();
								
								$this->setValue('id_concepto_alumno',$id_conce_alumno);
								$this->setValue('mes',0);
								$this->setValue('estatus','0');
								$this->Insertar('conceptos_alumnos_mes');
							}else{
								//echo $id_con_nivel."<br />";
								$this->setKey('id_concepto_nivel',$id_con_nivel);
								$this->setKey('id_alumno',$ID);
								$this->setKey('id_alumno_grupo',$id_alumno_grupo);
								$this->setValue('estatus','0');
								$this->Actualizar('conceptos_alumnos');
								
								$this->setKey('id_concepto_alumno',$rwcc["id"]);
								$this->setKey('mes',0);
								$this->setValue('estatus','0');
								$this->Actualizar('conceptos_alumnos_mes');
							}
							$ids.=$id_con_nivel;
							if($r<(count($descuento_insc[$ID])-1)){ $ids.=",";}
						}
						//$this->eliminar_conceptos_alumnos($ID, $ids, '01');
						//$this->EjecutarConsulta("DELETE FROM conceptos_alumnos WHERE id_alumno = '".$ID."' AND id_concepto_nivel NOT IN (".$ids.")"  );
					}
					
					// -- cargos inscripcion -- //
					//print_r($cargo_insc[$ID]);
					if($cargo_insc[$ID] != ''){ if($ids!=""){ $ids.=","; }
						foreach($cargo_insc[$ID] as $valor){
							if($valor!=""){
								$car_insc[$ID][]=$valor;
							}
						}
						for($r=0; $r<count($car_insc[$ID]); $r++){
							$id_con_nivel = $car_insc[$ID][$r];
							
							$q=$this->EjecutarConsulta("SELECT * FROM conceptos_alumnos WHERE id_concepto_nivel='".$id_con_nivel."' AND id_alumno='".$ID."'");
							$rwcc=mysql_fetch_array($q);
							
							if($rwcc["id"]==""){
								$qc=$this->EjecutarConsulta("select * from conceptos_nivel where id_concepto_nivel='".$id_con_nivel."'");
								$rc=mysql_fetch_array($qc);
								$id_ciclo=$rc["id_ciclo"];
								//echo $id_con_nivel."<br />";
								$this->setValue('id_concepto_nivel',$id_con_nivel);
								$this->setValue('id_alumno',$ID);
								$this->setValue('id_alumno_grupo',$id_alumno_grupo);
								$this->setValue('estatus','0');
								$this->Insertar('conceptos_alumnos');
								$id_conce_alumno=$this->UltimoID();
								
								$this->setValue('id_concepto_alumno',$id_conce_alumno);
								$this->setValue('mes',0);
								$this->setValue('estatus','0');
								$this->Insertar('conceptos_alumnos_mes');
								//echo "INSERT ".$id_con_nivel."-".$id_conce_alumno."<br />";
							}else{
								//echo $id_con_nivel."<br />";
								$this->setKey('id_concepto_nivel',$id_con_nivel);
								$this->setKey('id_alumno',$ID);
								$this->setKey('id_alumno_grupo',$id_alumno_grupo);
								$this->setValue('estatus','0');
								$this->Actualizar('conceptos_alumnos');
								
								$this->setKey('id_concepto_alumno',$rwcc["id"]);
								$this->setKey('mes',0);
								$this->setValue('estatus','0');
								$this->Actualizar('conceptos_alumnos_mes');
							}
							$ids.=$id_con_nivel;
							if($r<(count($cargo_insc[$ID])-1)){ $ids.=",";}
						}						
						//$this->EjecutarConsulta("DELETE FROM conceptos_alumnos WHERE id_alumno = '".$ID."' AND id_concepto_nivel NOT IN (".$ids.")"  );
					}
					$this->eliminar_conceptos_alumnos($ID, $ids);
					$importe_pago_col=$this->validar_cuota_alumno($ID, $id_ciclo, $id_nivel, $id_grupo);
				}
			}
					
			$this->CometerTransaccion();
			$this->Desconectar();
			
			return $var;
		}catch(Exception $e){
			$this->DeshacerTransaccion();
			echo $e;
		}
	}
	function validar_cuota_alumno($id_alumno, $id_ciclo, $id_nivel, $id_grupo){		
		/// VALIDAR  ACTIVAR Y DESACTIVAR MESES EN BOLETA
		////// CONFIGURACION ESPECIFICA COLEGIO YUCATAN ////// DIAS DE APLICACION DESC
		$dia_ini_yuc=1;
		$dia_fin_yuc=9;
		$dia_pago_yuc=8;
	
		
		$str_ciclo = "SELECT * FROM ciclos WHERE id_ciclo = '".$id_ciclo."'";
		$sql_ciclo = $this->EjecutarConsulta($str_ciclo);
		$arr_ciclo = mysql_fetch_array($sql_ciclo);
		
		$a1 = split("-",$arr_ciclo['fecha_ini']);  
		$anio1 = $a1[0];
		$a2 = split("-",$arr_ciclo['fecha_fin']);  
		$anio2 = $a2[0]; 
		$m_fin_ciclo = $a2[1];
		$fin_ciclo = $arr_ciclo['fecha_fin']; 
		
		// ------------------------ SACAR NIVEL, GRADO -------------------------------------------- //	
		$str_nivel = "SELECT g.id_grupo, g.id_nivel,g.grado FROM alumno_grupo ag INNER JOIN grupos g ON g.id_grupo = ag.id_grupo 
					  WHERE ag.id_alumno = ".$id_alumno." AND g.id_ciclo = ".$id_ciclo;
		$sql_nivel = $this->EjecutarConsulta($str_nivel);
		$arr_nivel = mysql_fetch_array($sql_nivel);
		$id_nivel = $arr_nivel['id_nivel'];
		$id_grupo = $arr_nivel['id_grupo'];
		$grado = $arr_nivel['grado'];

		$str_meses_pagar = "SELECT m.mes, (SELECT DATE_FORMAT(CONCAT('0000-',m.mes,'-00'),'%b') FROM boleta_pago b WHERE b.id_alumno = ".$id_alumno." AND b.id_grupo='".$id_grupo."') AS mes_boleta FROM meses_pagar m where m.id_ciclo = ".$id_ciclo." ORDER BY m.id ASC";
		//echo $str_meses_pagar;
		$sql_meses_pagar = $this->EjecutarConsulta($str_meses_pagar);
		$num_meses_a_pagar = mysql_num_rows($sql_meses_pagar);
		$c=0;	$i=0;
		while($rwm=mysql_fetch_array($sql_meses_pagar)){			
			$day=1; $month=$rwm["mes"]; 
			if((int)$month >= 8 && (int)$month <= 12){ $year = $anio1; }else{ $year = $anio2;	}
			
			// -------------------- CUOTA DE COLEGIATURA POR MES ------------------- //		
			$str_cuota = "SELECT c.importe, c.descrip AS concepto, cm.id_conce_mes, cm.estatus AS pagado
							FROM conceptos_alumnos ca 
							INNER JOIN conceptos_alumnos_mes cm On cm.id_concepto_alumno=ca.id
							INNER JOIN conceptos_nivel cn ON ca.id_concepto_nivel=cn.id_concepto_nivel 
							INNER JOIN conceptos c ON c.id_concepto = cn.id_concepto 
							WHERE cn.tipo_c = '04' 
							AND cn.id_ciclo = '".$id_ciclo."'
							AND cn.id_nivel = '".$id_nivel."' 
							AND cn.grado = '".$grado."'
							AND ca.id_alumno = '".$id_alumno."'
							AND cm.mes='".$rwm["mes"]."'";
			$sql_cuota = $this->EjecutarConsulta($str_cuota);
			$arr_cuota = mysql_fetch_array($sql_cuota);		mysql_free_result($sql_cuota);
			$importe_cuota=$arr_cuota['importe'];

			$mes_es=date("M",mktime(0,0,0,$month,1,date("Y"))); 
			$q_b=$this->EjecutarConsulta("SELECT `".$mes_es."` AS pagado FROM boleta_pago WHERE id_alumno='".$id_alumno."' AND id_grupo='".$id_grupo."'");
			$rw_boleta=mysql_fetch_array($q_b);
			$pagado_mes=$rw_boleta["pagado"];
			// ------------------------------- FIN CUOTA -----------------------------//

			//---- CUOTAS PROGRAMADAS POR CONFIG. CAJA ----///
			$cuota_extra=0;		$concepto_cuota_extra="";
			$str_cargos_caja = "SELECT * FROM conceptos_configurables 
						WHERE id_ciclo = '".$id_ciclo."' AND (id_nivel = '".$id_nivel."' OR id_nivel = 0) 
						AND (grado ='".$grado."' OR grado = '0') 
						AND tipo_c = 'C' AND aplicar_por='3'";
			//echo $str_cargos_caja."<br />";						
			$sql_cargos_caja = $this->EjecutarConsulta($str_cargos_caja);  $ccc=0;
			while($arr_cargos_caja = mysql_fetch_array($sql_cargos_caja)){
				$l = 0;
				if($m >= 8 && $m <= 12){ $anio = $anio1;	}else{ 		$anio = $anio2;			}
				$ma = mktime(0,0,0,$month, $day, $year); /// FECHA DEL DIA DE HOY
				$mp = mktime(0,0,0,$m,date("t",mktime(0,0,0,$m,1,$anio)),$anio);  //// MES A PAGAR FECHA DEL ULTIMO DIA DEL MES
				
				if($arr_cargos_caja["tipo_imp"] != 'pesos'){ 
					$importe = ($importe_cuota * $arr_cargos_caja["importe"])/100; 
				}else{ 
					$importe = $arr_cargos_caja["importe"];
				}
				if($arr_cargos_caja['aplicar_por'] == '3'){
					if($m==$arr_cargos_caja["N"]){
						$cuota_extra = $importe;										
						$concepto_cuota_extra = $arr_cargos_caja["concepto"];
						$ccc++;
					}
				}
			}
			if($concepto_cuota_extra!=""){	$concepto[$i].=" Y ".strtoupper($concepto_cuota_extra);	}
			$importe_cuota+=$cuota_extra;
			/// FIN CUOTA EXTRA ////			
			
			// ------------------------ DESCUENTOS ------------------//		
			$band=0;
			$str_descuentos = "SELECT cn.id_concepto_nivel, c.descrip AS concepto, c.tipo_importe, c.importe, cm.id_conce_mes 
							   FROM conceptos_alumnos ca 
							   LEFT JOIN conceptos_alumnos_mes cm ON cm.id_concepto_alumno=ca.id 
							   LEFT JOIN conceptos_nivel cn ON ca.id_concepto_nivel = cn.id_concepto_nivel 
							   LEFT JOIN conceptos c ON c.id_concepto = cn.id_concepto 
							   WHERE cn.tipo_c = '02' AND ca.id_alumno = '".$id_alumno."' AND cn.id_ciclo = '".$id_ciclo."' AND cn.id_nivel = '".$id_nivel."' 
							   AND (cn.grado = '".$grado."' OR cn.grado = 0) AND c.tipo = 'D' AND cm.mes='".$rwm["mes"]."'";	
			//echo $str_descuentos."<br />";
			$fecha_actual = mktime(0,0,0,$month,$day,$year);
			if($m >= 8 && $m <= 12){ 	$anio = $anio1;	}else{ 	$anio = $anio2;	}
			$fecha_final_mes = mktime(0,0,0,$m,$dia_fin_yuc,$anio);
			
			if($fecha_actual<=$fecha_final_mes){
				$sql_descuentos = $this->EjecutarConsulta($str_descuentos);
				$q = 0;
				$sum_descuentos = 0;
				while($arr_descuentos = mysql_fetch_array($sql_descuentos)){
					if($arr_descuentos['tipo_importe'] != 'pesos'){ 
						$importe = ($importe_cuota * $arr_descuentos['importe'])/100;
					}else{ 
						$importe = $arr_descuentos['importe'];
					}
					$sum_descuentos += $importe; 
					$band=1;
					$q++;
				}
			}
			//$descuentos[$i]=$sum_descuentos;
			///  FIN DESCUENTOS CUOTA ///

			// ------------------------ BECAS ------------------//		
			$str_becas = "SELECT cn.id_concepto_nivel, c.descrip AS concepto, c.tipo_importe, c.importe, cm.id_conce_mes 
							   FROM conceptos_alumnos ca 
							   LEFT JOIN conceptos_alumnos_mes cm ON cm.id_concepto_alumno=ca.id 
							   LEFT JOIN conceptos_nivel cn ON ca.id_concepto_nivel = cn.id_concepto_nivel 
							   LEFT JOIN conceptos c ON c.id_concepto = cn.id_concepto 
							   WHERE cn.tipo_c = '02' AND ca.id_alumno = '".$id_alumno."' 
							   AND cn.id_ciclo = '".$id_ciclo."' AND cn.id_nivel = '".$id_nivel."' 
							   AND (cn.grado = '".$grado."' OR cn.grado = 0) AND c.tipo = 'B' AND cm.mes='".$rwm["mes"]."'";// AND ca.estatus = '0'
			$sql_becas = $this->EjecutarConsulta($str_becas);
			$q = 0;
			$sum_becas = 0;	$band2=0;
			while($arr_becas = mysql_fetch_array($sql_becas)){
				if($arr_becas['tipo_importe'] != 'pesos'){ 
					$importe = ($importe_cuota * $arr_becas['importe'])/100;
				}else{ 
					$importe = $arr_becas['importe'];
				}
				$sum_becas += $importe; 
				$q++;
				$band2=1;
			}
			$becas=$sum_becas;
			//// FIN BECAS CUOTA	////
			
			// ------------------------ DESCUENTOS CONCEPTOS CONFIGURABLES ------------- //		
			$str_desc_caja = "SELECT * FROM conceptos_configurables 
							  WHERE id_ciclo = '".$id_ciclo."' AND (id_nivel = '".$id_nivel."' OR id_nivel = 0) 
							  AND (grado = '".$grado."' OR grado = 0) 
							  AND tipo_c = 'D' ORDER BY if(aplicar_por = '2',N,id_config) ASC";
			//echo $str_desc_caja."<br />";
			$cuota = $importe_cuota;
			$sum_desc_caja = 0;//$sum_descuentos;								//Total a aplicar en formula para conceptos q sean tipo porcentaje, pudiera ser solo la cuota, 
			$total_cuota_desc = $cuota - $sum_descuentos;	//+ $sum_cargos		//depende de la forma como la escuela lo quiera manejar	
			
			if($band==0 && $band2==0){/// SI HAY DESC NO APLICA OPORTUNOS			
				$sql_desc_caja = $this->EjecutarConsulta($str_desc_caja);
				while($arr_desc_caja = mysql_fetch_array($sql_desc_caja)){
					$aplicar_por = $arr_desc_caja['aplicar_por'];
					if($aplicar_por == '0'){	//Por Periodo (Dia inicial - Dia final) de cada mes
						// ---- fecha actual --- //
						$fecha_actual = mktime(0,0,0,$month,$day,$year);  /// FECHA DE PAGO
						// ---- fecha inicial y fincal ---- //
						if($m >= 8 && $m <= 12){ 
							$anio = $anio1;	
						}else{ 
							$anio = $anio2;	
						}
						$fecha_inicial = mktime(0,0,0,$m,$arr_desc_caja['dia_ini'],$anio);
						$fecha_final = mktime(0,0,0,$m,$arr_desc_caja['dia_fin'],$anio);
						if(($fecha_inicial <= $fecha_actual && $fecha_actual <= $fecha_final)  || ($fecha_actual<=$fecha_inicial)){ 
							if($arr_desc_caja['tipo_imp'] != 'pesos'){ 
								$importe_desc_caja = ($total_cuota_desc * $arr_desc_caja['importe'])/100; 
							}else{ 
								$importe_desc_caja = $arr_desc_caja['importe'];
							}
							$sum_desc_caja = $sum_desc_caja + $importe_desc_caja;
						}
					}
				}
			}
			$sum_desc_caja_aux = $sum_desc_caja;
			$tot_descuentos = $sum_desc_caja_aux+$sum_descuentos;
			$descuentos=$tot_descuentos;
			// ----------- FIN DESCUENTOS CAJA ------------------ //

			
			// ------------ PAGOS REALIZADOS CUOTA---------- //			
			$str_pagos = "SELECT r.id_factura, d.descrip, d.importe, r.fecha_cobro 
						  FROM recibos_conceptos d 
							LEFT JOIN recibos r ON d.id_factura = r.id_factura 
							WHERE r.tipo_r = '02' 
							AND r.id_alumno = '".$id_alumno."' 
							AND r.id_ciclo = '".$id_ciclo."'  
							AND r.estado = 'P' 
							AND d.id_conce_mes='".$arr_cuota['id_conce_mes']."'
							GROUP BY r.id_factura 
						  ORDER BY r.fecha_cobro DESC";
			//echo $str_pagos."<br />";
			$sql_pagos = $this->EjecutarConsulta($str_pagos);
			$PAGOS=0;	$suma_conce_pagos=0;	$band=0;	$suma_pagos_es=0;
			$desc_pagados=0; 	$desc_caja_pagados=0;	$becas_pagados=0;	$cargos_caja_pagados=0;
			while($arr_pagos = mysql_fetch_array($sql_pagos)){
				$importe_pagos=$arr_pagos["importe"];
				$PAGOS += $importe_pagos;
				$fp=split("-",$arr_pagos["fecha_cobro"]);
				if($m >= 8 && $m <= 12){  $anio = $anio1;	}else{ 	$anio = $anio2;		}
				
				$fecha_actual=mktime(0,0,0,$month,$day,$year);
				$tolera_mes = mktime(0,0,0,$m,$dia_fin_yuc,$anio);
				$fecha_pago_es = mktime(0,0,0,$fp[1],$fp[2],$fp[0]);
				//echo date("d/m/Y",$fecha_actual)." ".date("d/m/Y",$tolera_mes)." ".date("d/m/Y",$fecha_pago_es);
				if($fecha_pago_es<=$tolera_mes && $tolera_mes<$fecha_actual){
					$sql=$this->EjecutarConsulta("SELECT * FROM recibos_conceptos WHERE id_factura='".$arr_pagos["id_factura"]."' AND tipo!='C'");
					while($rw_pagos=mysql_fetch_array($sql)){
						$suma_pagos_es+=$importe_pagos;
						if($rw_pagos["tipo"]=="D"){		$desc_pagados+=((-1)*$rw_pagos["importe"]);			}
						if($rw_pagos["tipo"]=="DC"){	$desc_caja_pagados+=((-1)*$rw_pagos["importe"]);	}
						if($rw_pagos["tipo"]=="B"){ 	$becas_pagados+=((-1)*$rw_pagos["importe"]);		}
						if($rw_pagos["tipo"]=="C" || $rw_pagos["tipo"]=="CC"){
							$cargos_caja_pagados+=$rw_pagos["importe"];
						}
					}
					$band=1;
				}
			}
			//echo $band." ".$desc_pagados." ".$desc_caja_pagados."<br />";
			$abonos=$PAGOS;
			if($band==1){
				//$pp_cuota=(($arr_cuota['importe']-($desc_pagados+$desc_caja_pagados))+$cargos_caja_pagados)-$suma_pagos_es;
				$pp_cuota=(($importe_cuota-($desc_pagados+$desc_caja_pagados))+$cargos_caja_pagados)-$suma_pagos_es;
				if($pp_cuota<=$suma_pagos_es){ 
					$band=2;	
					$descuentos+=($desc_pagados+$desc_caja_pagados);
					$becas+=$becas_pagados;
					$atrasos=$cargos_caja_pagados;
					
					$sum_descuentos+=$desc_pagados; 
					$sum_becas+=$becas_pagados; 
					$sum_desc_caja_aux+=$desc_caja_pagados;
					$sum_cargos_caja+=$cargos_caja_pagados;
				}
			}		
			
			$cant_pagar_mes=(($importe_cuota-$sum_descuentos-$sum_becas-$sum_desc_caja_aux)+$sum_cargos_caja)-$PAGOS;
			//echo $cant_pagar_mes."= ((".$arr_cuota['importe']."-$sum_descuentos-$sum_becas-$sum_desc_caja_aux)+$sum_cargos_caja))-$PAGOS<br /><br />";
			$i++; 			
			if($cant_pagar_mes<=0){ 
				$q_b=$this->EjecutarConsulta("UPDATE boleta_pago SET `".$mes_es."`='1' WHERE id_alumno='".$id_alumno."' AND id_grupo='".$id_grupo."'");
			}elseif($pagado_mes==0){
				$q_b=$this->EjecutarConsulta("UPDATE boleta_pago SET `".$mes_es."`='0' WHERE id_alumno='".$id_alumno."' AND id_grupo='".$id_grupo."'");
			}
			$cant_pagar_mes=0;

		// --------- -- FIN PAGOS REALIZADOS CUOTA------- //
		}
	}

	function vaciar_conceptos_alumno($id_alumno){
		try{
	    $this->Conectar();
		$this->IniciarTransaccion();
		$this->EjecutarConsulta("DELETE FROM conceptos_alumnos WHERE id_alumno = ".$id_alumno);
		$this->CometerTransaccion();
		$this->Desconectar();
	  }catch(Exception $e){
	    $this->DeshacerTransaccion();
		echo $e;
	  }
	}

	function consultar_aviso($id_aviso){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();
			$this->setKey("id_aviso", $id_aviso);
			$row=$this->DevuelveFila("maestro_avisos");
			
			$this->CometerTransaccion();
			$this->Desconectar();
			return $row;
		}catch(Exception $e){
			//$this->DeshacerTransaccion();
			echo $e;
		}
	}
	
	function consultar_transporte($id_alumno){
		try{
			$this->Conectar();
			$this->IniciarTransaccion();
			$this->setKey("id_alumno", $id_aviso);
			$row=$this->DevuelveFila("alumnos_datos_yuc_transporte");
			
			$this->CometerTransaccion();
			$this->Desconectar();
			return $row;
			
		}catch(Exception $e){
			//$this->DeshacerTransaccion();
			echo $e;
		}
	}

	function elimina_avisos(){
		try{
	    $this->Conectar();
		$ids = str_replace("\'","'",$_GET[ids]);
		
		$this->EjecutarConsulta("DELETE FROM maestro_avisos WHERE id_aviso IN ('$ids')");
		$mensaje = 'Aviso(s) Eliminado(s) Correctamente';
		$this->CometerTransaccion();
		$this->Desconectar();
		return $mensaje;
	  }catch(Exception $e){
	    $this->DeshacerTransaccion();
		echo $e;
	  }
	}

	function elimina_tareas(){
		try{
	    $this->Conectar();
		$ids = str_replace("\'","",$_GET[ids]);
		$id=split(",",$ids);
		
		for($i=0; $i<count($id); $i++){
			//echo "SELECT tarea FROM maestro_tareas WHERE id_tarea ='".$id[$i]."'";
			$sql=$this->EjecutarConsulta("SELECT tarea FROM maestro_tareas WHERE id_tarea ='".$id[$i]."'");
			$fila=mysql_fetch_array($sql);
			chmod("tareas/", 0777);
			@unlink("tareas/".$fila["tarea"]);
			chmod("tareas/", 0755);
			
			$this->EjecutarConsulta("DELETE FROM maestro_tareas WHERE id_tarea = '".$id[$i]."'");
		}
		$mensaje = 'Tarea(s) Eliminado(s) Correctamente';
		$this->CometerTransaccion();
		$this->Desconectar();
		return $mensaje;
	  }catch(Exception $e){
	    $this->DeshacerTransaccion();
		echo $e;
	  }
	}
	function obtener_fila_doc($i,$id_alumno){
		if($id_alumno!=""){
			$this->setKey("documento",$i);
			$this->setKey("id_alumno",$id_alumno);
			$rw=$this->DevuelveFila("alumnos_documentos");
		}
		return $rw;
	}
	function validar_curp($curp){
		$this->setKey("curp",$curp);
		$rw=$this->DevuelveFila("alumnos");

		return $rw;
	}
}
?>