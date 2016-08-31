<?php
function redireccion($extra) {
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
header("Location: http://$host$uri/$extra");
}
function registrarLog($log) {
	$actividad=$_SESSION[usuario_nombre].' '.$log;
	$fecha=date("Y-m-d");
	$hora=date("H:i:s");
	mysql_query("insert into log (actividad,fecha,hora) values ('$actividad','$fecha','$hora') ");
	//redireccion($url);
}

//funciones de mysql
function consultaRegistro($sql){
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	echo mysql_error();
	mysql_free_result($result);
	return $row;
}
//funciones fechas
function convierteFecha($f,$imprime){
  $mescorto=array('','Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');
  $meslargo=array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
  $f=split("-",$f); 
  $mes=(int)$f[1];
  if($imprime==1){
	  echo $f[2]."-".$meslargo[$mes]."-".$f[0]; 
  }elseif($imprime==2){
	  echo $f[2]."-".$mescorto[$mes]."-".$f[0]; 
  }elseif($imprime==3){
	  $fecha=$f[2]."-".$mescorto[$mes]."-".$f[0]; 
	  return $fecha;  	
  }elseif($imprime==4){
	  $fecha=$f[2]." DE ".strtoupper($meslargo[$mes])." DEL ".$f[0]; 
	  return $fecha;  	
  }else{
	  $fecha=$f[2]."-".$meslargo[$mes]."-".$f[0]; 
	  return $fecha;
  }
}
function nombre_alumno($idAlumno){
	$row=consultaRegistro("select CONCAT(apellido_p,' ',apellido_m,' ',nombre) AS nombre from alumnos where idAlumno='".$idAlumno."'");
	$nombre=$row["nombre"];
	
	return $nombre;
}
function tipo_usuario($user){
	$usuarios=array("caja", "finanzas", "control", "director_k", "director_p", "director_s", "director_pre", "director_c1", "director_c2", "director_gral", "admin");
	$tipo_usuario=array("Cajera(o)", "Contabilidad", "Control Escolar", "Director Maternal y Kinder", "Director Primaria", "Director Secundaria", "Director Preparatoria", "Director SESCA", "Director ISC", "Director Gral.", "Administrador");
	for($i=0; $i<count($usuarios); $i++){
		if($usuarios[$i]==$user){
			$tipo=$tipo_usuario[$i];
			break;
		}
	}
	return $tipo;
}
function transporte($idAlumno){
	$tablas=array("alumnos","alumno_salud","personas_autorizadas","padres_tutores","personas_casa","datos_urgencias","procedencia");
	$forms=array("form_alumnos","exp_clinico","form_autorizados","form_padres","form_personas_casa","form_urgencias","form_procedencia");
	for($i=0; $i<=6; $i++)
	{
		$busca=mysql_query("select * from ".$tablas[$i]." where idAlumno='$idAlumno'");
		if(mysql_num_rows($busca)==0)
		{
			break;
		}
	}
	return $forms[$i];
}
function mesingles($m){
	$mesingles=array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
	$mes=(int)$m;
	return $mesingles[$mes];
}
function meslargo($m){
	$mesingles=array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
	$mes=(int)$m;
	return $mesingles[$mes];
}

function redondea($valor,$op){
	if($op==1){
		$float_redondeado=round($valor * 10) / 10; 
	}else if($op==2){
		$v=split(".",$valor);
		if(strlen($v[1])==3){
			$valor=number_format((round($valor * 100) / 100),1,'.',''); 
		}
		$float_redondeado=round($valor * 100) / 100; 
	}else if($op==3){
		$float_redondeado=round($valor * 1000) / 1000; 
	}
	
	return $float_redondeado; 
}
function tiempo_transcurrido($fecha_nacimiento, $fecha_control) {    
	$fecha_actual = $fecha_control;        
	if(!strlen($fecha_actual)){       $fecha_actual = date('d/m/Y');    }     
	// separamos en partes las fechas     
	$array_nacimiento = explode ( "/", $fecha_nacimiento );     
	$array_actual = explode ( "/", $fecha_actual );      
	$anos =  $array_actual[2] - $array_nacimiento[2]; // calculamos años     
	$meses = $array_actual[1] - $array_nacimiento[1]; // calculamos meses     
	$dias =  $array_actual[0] - $array_nacimiento[0]; // calculamos días      
	//ajuste de posible negativo en $días    
	if ($dias < 0){   
		--$meses;         //ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual        
		switch ($array_actual[1]) {           
			case 1: 
				$dias_mes_anterior=31;             
				break;           
			case 2:                  
				$dias_mes_anterior=31;             
				break;           
			case 3:               
				if (bisiesto($array_actual[2])){                 
					$dias_mes_anterior=29;                
					break;              
				}else{                 
					$dias_mes_anterior=28;
					break;
				}           
			case 4:
				$dias_mes_anterior=31;
				break;           
			case 5:
				$dias_mes_anterior=30; 
				break;           
			case 6:
				$dias_mes_anterior=31;
				break;           
			case 7:
				$dias_mes_anterior=30;
				break;           
			case 8:
				$dias_mes_anterior=31;
				break;           
			case 9:
				$dias_mes_anterior=31;
				break;           
			case 10:
				$dias_mes_anterior=30;
				break;           
			case 11:
				$dias_mes_anterior=31;
				break;           
			case 12:
				$dias_mes_anterior=30;
				break;        
		}
		$dias=$dias + $dias_mes_anterior;        
		if ($dias < 0){          
			--$meses;          
			if($dias == -1){	$dias = 30;	}          
			if($dias == -2)          {             $dias = 29;          }       
		}    
	}     
	//ajuste de posible negativo en $meses     
	if ($meses < 0){        
		--$anos;        
		$meses=$meses + 12;     
	}     
	$tiempo[0] = $anos;    $tiempo[1] = $meses;    $tiempo[2] = $dias;     
	
	return $tiempo; 
}  
function bisiesto($anio_actual){     
	$bisiesto=false;     //probamos si el mes de febrero del año actual tiene 29 días       
	if (checkdate(2,29,$anio_actual)){        $bisiesto=true;     }     
	return $bisiesto;  
} 
?>