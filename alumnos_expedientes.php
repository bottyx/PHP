<?php 
include("seguridad_permisos.php");
header('Content-Type: text/html; charset=UTF-8');
include("clases/default/nocache.php");
require("clases/funciones_comunes.php");
require_once("clases/default/class_mysqlconnector.php");
$con = new class_mysqlconnector();

include("clases/class_alumnos.php");
$cone = new class_alumnos();
$title="Expedientes de Alumnos";

if($_POST["id_ciclo"]){ $id_ciclo=$_POST["id_ciclo"]; }else{ if($_GET["id_ciclo"]){ $id_ciclo=$_GET["id_ciclo"]; }else{ $id_ciclo=obtener_ciclo_activo($con); }}
if($_POST["busca_por"]!="") $busca_por=$_POST["busca_por"]; else $busca_por=$_GET["busca_por"];
if($_POST["id_nivel"]!="") $id_nivel=$_POST["id_nivel"]; else $id_nivel=$_GET["id_nivel"];
if($_POST["id_grupo"]!="") $id_grupo=$_POST["id_grupo"]; else $id_grupo=$_GET["id_grupo"];
if($_POST["nombre"]!="") $nombre=$_POST["nombre"]; else $nombre=$_GET["nombre"];
if($_POST["matricula"]!="") $matricula=$_POST["matricula"]; else $matricula=$_GET["matricula"];
$rel=$_POST["rel"]!=""?$_POST["rel"]:$_GET["rel"];
if($_SESSION["id_maestro_user"]!="" && $_SESSION["tipo_user"]==1){ $id_maestro=$_SESSION["id_maestro_user"];}else{ $id_maestro="";}
if($_POST["id_grupo_maestro"]!=""){ $id_grupo_maestro=$_POST["id_grupo_maestro"]; $gm=split("-",$id_grupo_maestro); $id_ciclo=$gm[0]; $id_nivel=$gm[1]; $id_grupo=$gm[2];
}elseif($_GET["id_grupo_maestro"]){ $id_grupo_maestro=$_GET["id_grupo_maestro"]; $gm=split("-",$id_grupo_maestro); $id_ciclo=$gm[0]; $id_nivel=$gm[1]; $id_grupo=$gm[2];	}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$title;?></title>
<link href="css/principal.css" rel="stylesheet" type="text/css" />
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/menu.css" type="text/css" />
<link rel="stylesheet" href="css/thickbox.css" type="text/css" />
<link href="css/forms.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/funciones_alumnos.js"></script>
<script type="text/javascript" src="js/dolphin.js"></script>
<script type="text/javascript" src="js/principal.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/thickbox.js"></script>
</head>
<body>
<div align="center">
	<? 
		include('cabecera.php');
		include('menu_principal_view.php');
	?>
<? 	if(isset($_GET['mensaje'])){?>
		<br /><div align="center" class="mensaje"><?=$_GET['mensaje'];?></div>
<?	}?>
    <br />
    <div id="content">
      <div id="filtro_grupo" style="margin:0px;">
      <form id="form1" name="form1" method="post" action="alumnos_expedientes.php?rel=<?=$rel?>&id_modulo=<?=$val_id_modulo?>&opcion=<?=$val_opcion?>&title=<?=$title;?>">
      <table width="960" border="0" cellpadding="0" cellspacing="0" style="margin:0px; background:url(clases/images/grid4/th5.jpg) repeat-x;">
      <tr height="20">
        <td height="20">&nbsp;&nbsp;</td>
        <td><select name="id_ciclo" id="id_ciclo" style="width:220px; margin:0px;" onchange="mostrar_tipo_busca('ciclo',this.value);" >
          <option value="">Seleccione el Ciclo</option>
          <? $sql_ciclo="select * from ciclos where activo!='2' ORDER BY id_ciclo ASC";
				$consu_ci=$cone->EjecutarConsulta($sql_ciclo);
				while($f_ciclo=mysql_fetch_array($consu_ci)){ ?>
          <option value="<?=$f_ciclo["id_ciclo"];?>" <? if($id_ciclo==$f_ciclo["id_ciclo"]) echo 'selected="selected"';?>>
            <?=$f_ciclo["nombre_ciclo"];?>
            </option>
          <? }?>
        </select></td>
<?	if($id_maestro==""){?>
        <td height="20" align="left" style="padding:2px">
          <select name="busca_por" id="busca_por" onchange="mostrar_tipo_busca(this.value, '');" style="width:180px; margin:0px;">
            <option value="nivel" <? if($busca_por=="" || $busca_por=="nivel"){ echo 'selected="selected"'; }?>>Busca por Nivel</option>
            <option value="nombre" <? if($busca_por=="nombre"){ echo 'selected="selected"'; }?>>Busca por Nombre</option>
            <option value="matri" <? if($busca_por=="matri"){ echo 'selected="selected"'; }?>>Busca por Matr&iacute;cula</option>
            </select>
          &nbsp;&nbsp;
        </td>
        <td height="20" align="left">
          <div id="tipo_busca">
	<?	if($_POST["busca_por"]=="nombre"){?>
    	<strong class="buscador_letras">Nombre o Apellido:&nbsp;</strong>
        <input name="nombre" type="text" id="nombre" style="width:150px; text-transform:uppercase;" value="<?=$_POST["nombre"]?>" />
	<?	}elseif($_POST["busca_por"]=="matri"){?>
    	<strong class="buscador_letras">Matr&iacute;cula:&nbsp;</strong>
        <input name="matricula" type="text" id="matricula" style="width:150px; text-transform:uppercase;" value="<?=$_POST["matricula"]?>" />
    <?	}else{?>
    <label>
      <select name="id_nivel" id="id_nivel" style="width:150px; margin:0px;" onchange="mostrar_grupos_alumnos(document.getElementById('id_ciclo').value, this.value);">
        <option value="">Seleccione el Nivel</option>
        <?	$sqlNiveles = "SELECT n.* FROM ciclo_niveles cn
							LEFT JOIN niveles n ON n.id_nivel = cn.id_nivel
							WHERE cn.id_ciclo='".$id_ciclo."' AND n.estatus = '0'
							ORDER BY n.id_nivel ASC";
			$consu_n=$cone->EjecutarConsulta($sqlNiveles);
                    while($f_nivel=mysql_fetch_array($consu_n)){?>
        <option value="<?=$f_nivel["id_nivel"]?>" <? if($id_nivel==$f_nivel["id_nivel"]) echo 'selected="selected"';?>>
          <?=$f_nivel["descrip"]?>
          </option>
        <? }?>
      </select>
    </label>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <span id="grupos">
              <label>
                <select name="id_grupo" id="id_grupo" style="width:150px; margin:0px;" >
                  <option value="">Elige Grupo: </option>
          <?  if($id_nivel){
                  $consu_g=$cone->EjecutarConsulta("select * from grupos WHERE id_nivel='".$id_nivel."' AND id_ciclo='".$id_ciclo."' AND estatus='0' GROUP BY grado,letra ASC");
                  while($f_grupo=mysql_fetch_array($consu_g)){?>
                  <option value="<?=$f_grupo["id_grupo"]?>" <? if($id_grupo==$f_grupo["id_grupo"]) echo 'selected="selected"';?>><?=$f_grupo["grado"]." - ".$f_grupo["letra"];?></option>
                  <? }
              }?>
                </select>
              </label>
              </span>
	<?	}?>
          </div></td>
        <td height="20" align="left"><label>
          <input type="submit" name="buscar" id="buscar" value="BUSCAR" class="button_buscar" />
        </label></td>
<?	}else{?>
        <td align="right"><strong class="txt_white">Grupos Asignados al Profesor:</strong>&nbsp;&nbsp;</td>      
        <td align="left">
        <select name="id_grupo_maestro" id="id_grupo_maestro">
        	<option value="">Elige Grupo: </option>
        <?	$sql="SELECT CONCAT(g.id_ciclo,'-',g.id_nivel,'-',g.id_grupo) AS id_grupo,
				  (SELECT c.nombre_ciclo FROM ciclos c WHERE c.id_ciclo=g.id_ciclo) AS ciclo,
				  (SELECT n.descrip FROM niveles n WHERE n.id_nivel=g.id_nivel) AS nivel,
				  CONCAT(g.grado,'-',g.letra) AS grupo
				FROM
				  (SELECT m.id_grupo
				   FROM materias_maestro m
				   WHERE m.id_maestro='".$id_maestro."'
				   UNION ALL
				   SELECT gm.id_grupo
				   FROM grupo_maestro gm
				   WHERE gm.id_maestro='".$id_maestro."'
				  )AS x
				  LEFT JOIN grupos g ON g.id_grupo=x.id_grupo
				ORDER BY g.id_ciclo, g.id_nivel, g.id_grupo ASC";
			$grupos_maestros=$con->EjecutarConsulta($sql);
			while($rwgm=mysql_fetch_array($grupos_maestros)){?>
            <option value="<?=$rwgm["id_grupo"]?>" <? if($id_grupo_maestro==$rwgm["id_grupo"]) echo 'selected="selected"';?>><?=$rwgm["ciclo"]."  ".$rwgm["nivel"]."  ".$rwgm["grupo"];?></option>
        <?	}?>
        </select>
        </td>      
        <td height="20" align="left">
        <label>
          <input type="submit" name="buscar" id="buscar" value="BUSCAR" class="button_buscar" />
        </label>
        </td>
<?	}?>
      </tr>
</table>
         </form>

      </div>
        <!------FIN DE FILTRO------------>
        <div id="grid_grupos" style="margin:0px">
<?php
if($id_maestro==''){
	if($permisos[0]==3){
		$borar_insc="<a  href=\"javascript:void(0);\" onclick=\'javascript: if(confirm(\"\\\u00BFSeguro que desea eliminar al Alumno(a)?\")) window.location.href=\"alumnos_control.php?op=4&id_modulo=".$val_id_modulo."&opcion=".$val_opcion."&id_relacion=',ag.id_relacion,'&id_alumno=',ag.id_alumno,'&id_nivel=',g.id_nivel,'&id_ciclo=',g.id_ciclo,'&id_grupo=',g.id_grupo,'&nombre=$_POST[nombre]&matricula=$_POST[matricula]','&ir=alumnos_expedientes\";\'><img src=\"images/usercerrado.png\" alt=\"Borrar Inscripci&oacute;n\" width=\"16\" height=\"16\" border=\"0\" hspace=\"10\" /></a>";
		
		$optativas=",'&nbsp;&nbsp;&nbsp;&nbsp;', '<a  href=\"alumnos_mat_optativas.php?id_alumno=',ag.id_alumno,'&id_grupo=',ag.id_grupo,'&rel=".$_GET['rel']."&id_modulo=".$val_id_modulo."&opcion=".$val_opcion."\&keepThis=true&TB_iframe=true&height=340&width=500\" class=\"thickbox\" target=\"_blank\" title=\"Materias Optativas de ', UPPER(CONCAT(a.apellido_p,' ',a.apellido_m,' ',a.nombre)),'\"><img src=\"images/materias_maestro.png\" title=\"Materias Optativas\" width=\"24\" height=\"24\" border=\"0\" hspace=\"10\" /></a>'";
	}else{
		$borar_insc="";
		$optativas="";
	}
	$sSQL ="SELECT ag.id_alumno, UPPER(CONCAT(a.apellido_p,' ',a.apellido_m,' ',a.nombre)) AS nombre, a.matricula, 
			(SELECT n.descrip FROM niveles n WHERE n.id_nivel = g.id_nivel) AS nivel, CONCAT(g.grado,' - ',g.letra) AS grupo,
			CONCAT('<a href=\"alumnos_form_pass.php?op=6&id_modulo=".$val_id_modulo."&opcion=".$val_opcion."&id_alumno=',ag.id_alumno,'&keepThis=true&TB_iframe=true&height=240&width=400\" class=\"thickbox\" title=\"Contrase&ntilde;a Alumno(a): \"><img src=\"images/user.png\" title=\"Contrase&ntilde;a Alumno\" border=\"0\" hspace=\"10\" /></a>','&nbsp;&nbsp;&nbsp;&nbsp;','".$borar_insc."'".$optativas.",'&nbsp;&nbsp;&nbsp;&nbsp;',
			'<a  href=\"pdf_expediente.php?id_alumno=',ag.id_alumno,'\" target=\"_blank\">
			<img src=\"images/print.png\" title=\"Imprimir Expediente del Alumno\" width=\"24\" height=\"24\" border=\"0\" hspace=\"10\" />
			</a>
			',
			'<a  href=\"pdf_expediente.php?id_alumno=',ag.id_alumno,'&idCiclo=',g.id_ciclo,'&idNivel=',g.id_nivel,'&idGrupo=',ag.id_grupo,'\" target=\"_blank\">
			<img src=\"images/print.png\" title=\"Imprimir Expediente del Alumno\" width=\"24\" height=\"24\" border=\"0\" hspace=\"10\" />
			</a>
			') 
			AS acciones
			FROM alumno_grupo ag
			LEFT JOIN alumnos a ON a.id_alumno=ag.id_alumno
			LEFT JOIN grupos g ON g.id_grupo = ag.id_grupo 
			WHERE ag.estado='0' ";
			//	,'<a  href=\"alumnos_mat_optativas.php?id_alumno=',ag.id_alumno,'\" target=\"_blank\"><img src=\"images/print.png\" title=\"Materias Optativas\" width=\"24\" height=\"24\" border=\"0\" hspace=\"10\" /></a>'LEFT JOIN alumno_grupo ag ON ag.id_alumno = a.id_alumno
			//,'&nbsp;&nbsp;&nbsp;&nbsp;','<a href=\"pdf_tarjeta_pago.php?id_alumno=',ag.id_alumno,'&id_ciclo=',g.id_ciclo,'\" target=\"_blank\"><img src=\"images/print_pago.png\" width=\"24\" height=\"24\" border=\"0\" alt=\"Imprimir Tarjeta de Pago\" hspace=\"10\" ></a>'
	$band_w=1;
	if($busca_por=="nivel"){
		if($id_ciclo!=""){			
			$sSQL .=" AND g.id_ciclo = '".$id_ciclo."'";
			$band_w=1;
		}
		if($id_nivel!=""){
			if($band_w==1){ $sSQL.=" AND g.id_nivel='".$id_nivel."' ";
			}else{	$sSQL.="WHERE  g.id_ciclo = '".$id_ciclo."' AND g.id_nivel='".$id_nivel."' ";	}
			$band_w=1;
		}
		if($id_grupo!=""){
			if($band_w==1){ $sSQL.=" AND g.id_grupo='".$id_grupo."' ";
			}else{ $sSQL.=" WHERE g.id_grupo='".$id_grupo."'"; }
		}		
		$var="busca_por=".$busca_por."&id_ciclo=".$id_ciclo."&id_nivel=".$id_nivel."&id_grupo=".$id_grupo;
	}elseif($busca_por=="nombre"){
		$sSQL.="AND  g.id_ciclo = '".$id_ciclo."' AND a.apellido_p LIKE '".$nombre."%' OR a.apellido_m LIKE '".$nombre."%' OR a.nombre LIKE '".$nombre."%'";
		$var="busca_por=".$busca_por."&id_ciclo=".$id_ciclo."&nombre=".$nombre;
	}elseif($busca_por=="matri"){
		$sSQL.="AND  g.id_ciclo = '".$id_ciclo."' AND a.matricula LIKE '".$matricula."'";
		$var="busca_por=".$busca_por."&id_ciclo=".$id_ciclo."&matricula=".$matricula;
	}else{
		$sSQL .="AND g.id_ciclo = '".$id_ciclo."'";
	}
	$sSQL.=" ORDER BY g.id_nivel,g.grado,g.letra,a.apellido_p, a.apellido_m, a.nombre ASC";
}else{
	$sSQL="SELECT ag.id_alumno, UPPER(CONCAT(a.apellido_p,' ',a.apellido_m,' ',a.nombre)) AS nombre, a.matricula,
			(SELECT c.nombre_ciclo FROM ciclos c WHERE c.id_ciclo=g.id_ciclo) AS ciclo,
			(SELECT n.descrip FROM niveles n WHERE n.id_nivel = g.id_nivel) AS nivel, CONCAT(g.grado,' - ',g.letra) AS grupo,
			CONCAT('<a href=\"alumnos_form_pass.php?op=6&id_modulo=".$val_id_modulo."&opcion=".$val_opcion."&id_alumno=',ag.id_alumno,'&keepThis=true&TB_iframe=true&height=240&width=400\" class=\"thickbox\" title=\"Contrase&ntilde;a Alumno(a): \"><img src=\"images/user.png\" title=\"Contrase&ntilde;a Alumno\" border=\"0\" hspace=\"10\" /></a>','&nbsp;&nbsp;&nbsp;&nbsp;','<a  href=\"pdf_expediente.php?id_alumno=',ag.id_alumno,'\" target=\"_blank\"><img src=\"images/print.png\" title=\"Imprimir Expediente del Alumno\" width=\"24\" height=\"24\" border=\"0\" hspace=\"10\" /></a>') AS acciones
		FROM alumno_grupo ag
		  INNER JOIN alumnos a On a.id_alumno=ag.id_alumno
		  INNER JOIN grupos g ON g.id_grupo=ag.id_grupo
		  LEFT JOIN grupo_maestro gm ON gm.id_grupo=ag.id_grupo
		  LEFT JOIN materias_maestro mm ON mm.id_grupo=ag.id_grupo
		WHERE ag.estado='0' AND (gm.id_maestro='".$id_maestro."' OR mm.id_maestro='".$id_maestro."')";
	if($id_grupo_maestro){
		$sSQL.=" AND ag.id_grupo='".$id_grupo."'";
		$var="id_grupo_maestro=".$id_grupo_maestro;
	}
	if($busca_por=="nombre"){
		$sSQL.="AND a.apellido_p LIKE '".$nombre."%' OR a.apellido_m LIKE '".$nombre."%' OR a.nombre LIKE '".$nombre."%'";
		$var="busca_por=".$busca_por."&id_ciclo=".$id_ciclo."&nombre=".$nombre;
	}
	$ext=30;	$ext2=50;
}	
//echo $sSQL;
	require_once("clases/class_grid.php");
	$grid = new grid();
	$grid->tiene_detalle=false;
	if($permisos[0]<2){
		$grid->setPermisosManual(0,0,0);
	}else{
		$grid->setPermisosManual(0,1,0);
	}
	//$grid->setPermisos($permisos[0],true); //código tomado de conceptos_catalogo.php
	$grid->setPagina("alumnos_expedientes");
	$grid->setPaginaDetalle("alumnos_form_registro");	// form abre popup
	
	$grid->setTitleDetalle("Editar Expediente del Alumno");
	$grid->setSQL($sSQL);

	$grid->setColumn("id_alumno","Id",true,30,"center",false,"",0);
	$grid->setColumn("nombre", "Nombre",false,300-$ext,"left",true);
	$grid->setColumn("matricula", "Matr&iacute;cula",false,150-$ext2,"left",true);
	if($id_maestro!=''){
		$grid->setColumn("ciclo", "Ciclo Escolar",false,150,"left",true);
	}
	$grid->setColumn("nivel", "Nivel",false,100,"left",true);
	$grid->setColumn("grupo", "Grupo",false,100,"center",true);
	$grid->setColumn("acciones", "Acciones",false,215-$ext-$ext2,"center",true);
	
	$grid->setGrid(360,960,"px","px");
	$grid->setBuscarPor("nombre","matricula");
	if($_GET["p"]!=""){
		$nombre=$_GET["p"];
		$var="busca_por=nivel&id_ciclo=".$id_ciclo."&p=".$nombre;
	}
	$grid->setLlaves("id_modulo=".$val_id_modulo."&opcion=".$val_opcion."&".$var."&height=450&width=850&TB_iframe=1&keepThis=1");
	// PARA REPORTES
	$grid->setPDFTitulo('');
	$grid->display();
?>
	</div>
    </div>
</div>
</body>
</html>
 