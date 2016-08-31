


textos a la izquierda
fechas centradas y con formato (d/m/Y) - <?=date('d/m/Y',strtotime($data->fecha))?> - <?=date('d/m/Y',strtotime($model->fecha))?> - 
monedas, fracciones a la derecha con formato (miles con coma y dos decimales) (<?=number_format($model->total,2,".",",")?>) <strong>$ '<?.number_format($model->total,2,".",",").' '.$desgloseReserva[1][$t]['moneda'].?>'</strong>

-------------------------------------form------------- (fecha)------------------------------------


<?php echo $form->hiddenField($model,'fecha',array('class'=>'form-control','maxlength'=>10,'value'=>date('d/m/Y'),'data-date-autoclose'=>true,'required'=>'required')); ?>

<?php Yii::app()->clientScript->registerScript('avisosForm','
    
     $("#Avisos_fecha").datepicker({"language": "es"});
	');
?>

MAIN  
CSS
<link rel="stylesheet" href="<?=Yii::app()->request->baseUrl?>/assets/css/plugins/bootstrap-datepicker/datepicker3.css" type="text/css" />

JS
<script src="<?=Yii::app()->request->baseUrl?>/assets/js/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script src="<?=Yii::app()->request->baseUrl?>/assets/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.js"></script>



-----------------------------------------------------------------------------------------------------------------




-------------------------------RENDER PARTIAL - FOREACH (IF - MODAL)----------------------------------------------

<?php $this->renderPartial("itemAl",array(
      'idGrupo'=>$dataAlumno->id_grupo,
    )); ?>



      <?php $conAlumnos = MaestroTareas::model()->findAll('id_grupo="'.$idGrupo.'" and publicar=1 order by fecha desc'); ?>
            
            <?php foreach($conAlumnos as $data): ?>

            <a data-toggle="modal" data-target="#tarea<?=$data->id_tarea?>" data-dismiss="modal"  class="list-group-item text-ellipsis">
                <i class="fa fa-circle text-success text-xs m-r-xs"></i>
                <span style= "font-size:18px"><?=$data->titulo_tarea?></span>
                <span class="pull-right text-info"><?=date('d/m/Y',strtotime($data->fecha))?></span>
                <span class="text-ellipsis m-t-xs text-muted-dk text-sm"><?=$data->tarea?></span>
            </a>
            <?php endforeach; ?>

    <?php foreach($conAlumnos as $data): ?>
    <?php $model = MaestroTareas::model()->findByPk($data->id_tarea); ?>
<!-- Modal -->
    <div class="modal fade" id="tarea<?=$data->id_tarea?>" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?=$model->titulo_tarea;?></h4>
                </div>
                <div class="modal-body">
                    <p class="pull-right">Entrega: <?=date('d/m/Y',strtotime($model->fecha_entrega));?></p>
                    
                    <b><?=$model->idMateria->materia;?></b><br>
                    <b><?=$model->idMaestro->nombre?> <?=$model->idMaestro->apellido_p?> <?=$model->idMaestro->apellido_m?></b>
                    
                    <p><b>Observaciones:</b><br><?=$model->observ;?></p>
                        <?php if (!empty($model->tarea)): ?>
                        <div class="modal-footer">
                            <a class="btn btn-md btn-addon btn-info waves-effect" href="<?=Yii::app()->createUrl('tareas/download',array('file'=>$model->tarea))?>">
                                <i class="fa fa-cloud-download"></i>Descargar Archivo
                            </a>
                        </div>
                        <?php endif ?>
                    
                </div>
               
            </div>
            <!-- /.Modal content-->
        </div>
    </div>
</div>
    <?php endforeach; ?>


-------------------------------------------------------------------------------------------------------------------





-------------------------------- DATAPROVIDER - ITEM ------------------------------------------------------------------------------------



<?php
                        $dataProvider=new CActiveDataProvider('Avisos',array('criteria'=>
                            array('select'=>'*',
                                //'condition'=>'(id_ciclo=:ciclo or id_nivel=:nivel or id_grupo=:grupo) and id_alumno is null and visible=1',
                                //'params'=>array(':ciclo'=>$grupo->id_ciclo,':nivel'=>$grupo->id_nivel,':grupo'=>$grupo->id_grupo),
                                'condition'=>'id_ciclo=:ciclo and id_nivel is null and id_grupo is null and id_alumno is null and visible=1 or id_ciclo=:ciclo and id_nivel=:nivel and id_grupo is null and id_alumno is null and visible=1',
                                'params'=>array('ciclo'=>$grupo->id_ciclo,':nivel'=>$grupo->id_nivel),                        
                                'order'=>'fecha DESC',
                                'limit'=>10)));
                                
                        $dataProvider->pagination->pageSize=100; 
                        $this->widget('zii.widgets.CListView', array(
                        'dataProvider'=>$dataProvider,
                        'ajaxUpdate'=>false,
                        'itemView'=>'itemAvisos',   // refers to the partial view named '_post'
                        'summaryText'=>false,
                        'emptyText' => '<div class="col-md-4"><div class="alert alert-info" role="alert">No hay Avisos Generales</div></div>',
                       ));
                    ?>

<?php
//$this->pageTitle = Yii::app()->params['appTitle'];
//$this->addMetaProperty('og:title', Yii::app()->params['appTitle']);
$profile = Profile::model()->findByPk(Yii::app()->user->id);
if($profile->id_tipo == 2){ //alumno

    $grupoAlumno = AlumnoGrupo::model()->find('id_alumno='.$profile->id_usuario);
    $grupo = Grupos::model()->findByPk($grupoAlumno->id_grupo);

?>
        
        <a href="<?=Yii::app()->createUrl("avisos/avisos",array("id"=>$data->idAviso))?>" class="list-group-item text-ellipsis">
            <i class="fa fa-circle text-success text-xs m-r-xs"></i>
            <span class="text-md"><?=$data->titulo?></span>
            <span class="pull-right text-info"><?=date('d/m/Y',strtotime($data->fecha))?></span>
            <span class="text-ellipsis m-t-xs text-muted-dk text-sm"><?=$data->aviso?></span>
        </a>            

<? }
else if($profile->id_tipo == 1){ //maestro   
?>
       <?/* <div class="row">

            <div class="col-md-10">*/?>
        <a href="<?=Yii::app()->createUrl("avisos/avisos",array("id"=>$data->idAviso))?>" class="list-group-item text-ellipsis">
            <i class="fa fa-circle text-success text-xs m-r-xs"></i>
            <span class="text-md"><?=$data->titulo?></span>
            <span class="pull-right text-info"><?=date('d/m/Y',strtotime($data->fecha))?></span>
            <span class="text-ellipsis m-t-xs text-muted-dk text-sm"><?=$data->aviso?></span>
        </a>
        <?/*</div>

            <div class="col-md-2">
            <div class="col-md-6">
                <a href="<?=Yii::app()->controller->createUrl('update',array("id"=>$data->idAviso))?>" class="md-btn md-fab pos-fix yellow"><i class="mdi-content-add i-24"></i></a>
            </div>
            <div class="col-md-6">
                <a href="<?=Yii::app()->controller->createUrl('delete',array("id"=>$data->idAviso))?>" class="md-btn md-fab pos-fix green"><i class="mdi-content-remove i-24"></i></a>
            </div>
            </div>
        </div>*/?>
<? }

else if($profile->id_tipo == 3){ //Administrador  
?>

        <a href="<?=Yii::app()->createUrl("avisos/avisos",array("id"=>$data->idAviso))?>" class="list-group-item text-ellipsis">
            <i class="fa fa-circle text-success text-xs m-r-xs"></i>
            <span class="text-md"><?=$data->titulo?></span>
            <span class="pull-right text-info"><?=date('d/m/Y',strtotime($data->fecha))?></span>
            <span class="text-ellipsis m-t-xs text-muted-dk text-sm"><?=$data->aviso?></span>
        </a>

<? }

?>

             


------------------------------- ITEM  - FOREACH -  CONTROLLER--------------------------------------------

<?
public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','avisos'),
				'users'=>array('@'),
			),


public function actionAvisos($id)
	{
		$this->render('avisos',array(
			'model'=>$this->loadModel($id),
		));
	}
?>


<?php
//$this->pageTitle = Yii::app()->params['appTitle'];
//$this->addMetaProperty('og:title', Yii::app()->params['appTitle']);
$profile = Profile::model()->findByPk(Yii::app()->user->id);
if($profile->id_tipo == 2){ //alumno

    $grupoAlumno = AlumnoGrupo::model()->find('id_alumno='.$profile->id_usuario);
    $grupo = Grupos::model()->findByPk($grupoAlumno->id_grupo);

?>
        
       <ul class="list-group md-whiteframe-z1">
            <?php foreach ($avisos as $aviso): ?>
                <li class="list-group-item">
                    <a href="<?=Yii::app()->createUrl('avisos/avisos',array('id'=>$aviso->idAviso));?>">
                        <span class="block font-bold text-info">
                            <?=$aviso->titulo?>
                            <span class="pull-right badge bg-info">GENERAL</span>       
                        </span>
                        <div class="text-fade h-2x">
                            <!--
                            <span class="pull-right badge bg-default">PERSONAL</span>
                            <span class="pull-right badge bg-info">GENERAL</span>
                            -->
                            <span class="">
                                <?=$aviso->aviso?>
                            </span>
                        </div>
                    </a>
                </li>
            <?php endforeach ?>
            <li class="list-group-item">
                <a href="<?=Yii::app()->createUrl('avisos/index');?>">
                    <span class="block text-center text-info">VER MÁS</span>
                </a>
            </li>
        </ul>        

<? }
else if($profile->id_tipo == 1){ //maestro   
?>
    
<? }

else if($profile->id_tipo == 3){ //Administrador  
?>



<? }

?>




------------------------------------------------------------------------------------------------------------------------------------




------------------  FILTRAR OBJETOS EN LUGAR DE OTROS EN EL GRID ----------------


<?php/*

'columns'=>array(
                    'idAviso',
        //'aviso',

        /* FILTRAR FECHA CON FORMATO */        
        array('headerHtmlOptions'=>array('style' =>'text-align:center;', ),'htmlOptions'=>array('style' =>'text-align:center;', ),'name'=>'fecha', 'value'=>'implode("/",array_reverse(explode("-",$data->fecha)))'),      
        'titulo',
        //'id_ciclo',        
        //'id_nivel',

        /* FILTRAR NOMBRE EN LUGAR DE ID (CONCATENANDO) */ 
        array(
               'name'=>'id_grupo',
               'value'=>'$data->idGrupo->grado." ".$data->idGrupo->letra',
                 ),  
        array(
               'name'=>'id_alumno',
               'value'=>'$data->idAlumno->nombre." ".$data->idAlumno->apellido_p',
                 ),  
        //'id_maestro',
        //'fecha_creacion',
       
       /* FILTRAR SI O NO EN LUGAR DE 1 O 0 */
        array(
               'name'=>'visible','value'=>'($data->visible==1)?"SI":"NO"',
                 ),          

        /* FILTRAR NOMBRES EN LUGAR DE NUMEROS POR MEDIO DE UNA FUNCION DESDE EL MODELO*/
        array('name'=>'posicion','value'=>'Banners::posicion($data->posicion)'),      

        /* FUNCION EN EL MODELO PARA ASIGNAR NOMBRE EN LUGAR DE NUMERO EN EL GRID DE INDEX*/
        public static function posicion($p)

    {

        switch ($p){

            case 1: $nombre = "Slider"; break;

            case 2: $nombre = "Lateral Izquierdo"; break;

            case 3: $nombre = "Libro de Firmas"; break;

            case 4: $nombre = "Ceremonia Nupcial"; break;

            case 5: $nombre = "Registro"; break;

        }

        return $nombre;

    }

?>



-------------------------------------------------------------------------------------------------------------------------------------


---------------------- ACCESOS POR USUARIO - TIPO --------------------

<?php
$profile = Profile::model()->findByPk(Yii::app()->user->id);
if($profile->id_tipo == 2){ //alumno
	$grupoAlumno = AlumnoGrupo::model()->find('id_alumno='.$profile->id_usuario);
	$grupo = Grupos::model()->findByPk($grupoAlumno->id_grupo);
?>
<?php $this->renderPartial('escritorio_alumno', array('avisos'=>$avisos,'tareas'=>$tareas,'grupoAlumno'=>$grupoAlumno,'grupo'=>$grupo)); ?>
<? }elseif($profile->id_tipo == 1){ //maestro ?>
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
	tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
	consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
	cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
<? }elseif($profile->id_tipo == 3){ //Administrador ?>
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
	tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
	consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
	cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
<? } ?>



----------------------------------------- ------------

------------------  MODEL - SEARCH - (MOSTRAR FILAS POR USUARIO)  ----------------------------------------

<?
public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		/* AGREGAR UESTA LINEA QUE DEFINIRA EL TIPO DE USUARIO */
		
		$profile = Profile::model()->findByPk(Yii::app()->user->id);

		$criteria=new CDbCriteria;

		/* EL SEARCH SE QUEDA TAL CUAL */

		$criteria->compare('id_maestro',$this->id_maestro);

		/* SOLO SE AGRGAN UNAS LINEAS DE CODIGO DEPEDIENDO DEL USUARIO */

		if($profile->id_tipo == 1){ //MAESTRO

			 $criteria->addCondition("id_maestro = '".$profile->id_usuario."'");
				//$criteria->addCondition("id_maestro = 62");

		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'fecha DESC'),
			'pagination'=>array('pageSize'=>10),
		));
	}

	?>



---------------------------------------------------------------------------------

<?php if (!empty($model)) : ?>
///////////
<?php else: ?>
<p class="nodata"><?php echo 'No data to display'; ?></p>
<?php endif; ?>


-------------------------------------------------------------------------------------------------------------------


 <div class=" margin-bottom-40 container" style="background-color:#FFFFFF; color:#FFFFFF;" >
        <div class=" container" style="background-color:#0750D4; color:#FFFFFF;;  padding:10px; margin: auto" align="center">
        <div class="col-md-3">
            <div class="col-md-8 col-md-offset-3" style="background-color:#E05402">
        <span style="font-size:10px"> ALIMENTOS Y BARES</span>
     </div>
        </div>

        <div class="col-md-3">
            <div class="col-md-8 col-md-offset-3" style="background-color:#E4004A">
         <span style="font-size:10px"> SALUD Y BIENESTAR</span>
      </div>
      <div class="col-md-8 col-md-offset-3" style="background-color:#0AC54C">
          <span style="font-size:10px">MASCOTAS</span>
      </div>
        </div>

        <div class="col-md-3" >
            <div class="col-md-8 col-md-offset-3" style="background-color:#EAA200">
          <span style="font-size:10px">TALLERES Y SERVICIOS</span>
        </div>
    </div>


-------------------------------------------------------------------------------------------------------------------
<?

$id = Yii::app()->user->id;
		//$cliente = Cliente::model()->findAll();
		$model = $this->loadModel($id);
		//$dataProvider=new CActiveDataProvider('Perfiles');
		$this->render('index',array(
			'model'=>$model,
		));


capital * inte mens (10%/5%) / 360 = 0.2 * 30d * 12 mese

(1000/100)*(100/10)/.27*30*12

((((($row["prestamo"] / 100) * $f["interes_ordinario"]) / 360) * 30) * 12)

?>


-------------------------------------------------------------------------------------------------------------------

<div class="col-md-12" style="text-align:center">
<h3>Tu empresa lo necesita, y t&uacute; tambi&eacute;n.</h3>
<a class="btn btn-warning btn-lg " id="btn_pago">Pago de inscripcion</a>

<p><img alt="" src="/ckfinder/userfiles/images/tarjetas.jpg" style="height:40px; width:214px" /></p>
</div>



<div class="row">
          <div class="col-md-8" style="text-align:center">
          <h3>Tu empresa lo necesita, y t&uacute; tambi&eacute;n.</h3>
          <a class="btn btn-warning btn-lg " data-toggle="modal" data-target=".bs-example-modal-lg" id="btn_pago" style="color:#FFF;font-weight:bold;margin-top:10px">Pago de inscripcion</a>

          <p><img alt="" src="/ckfinder/userfiles/images/tarjetas.jpg" style="height:40px; width:214px" /></p>
          </div>

          <div class="col-md-4">
          </div>
      </div>

-------------------------------------------------------------------------------------------------------------------

 <!-- C:\AppServ\www\yii\framework\yiic.bat webapp C:\AppServ\www\nombre aplicacion

http://localhost/yii/requirements -->


<div stile="width:200px;height:100px;border:1px solid blue;"> </div>


<div class="content-box-blue">Introduce tu contenido aquí.</div>

<div style="padding:12px;background-color:#E2E3E4;line-height:1.4;">


<p1><font color="64D5D9"><small><strong>Un absceso de pulm&oacute;n es una cavidad llena de pus en el pulm&oacute;n, rodeada de tejido inflamado, y causada por una infecci&oacute;n.</strong></small></font></p1>


<div style="padding:12px;background-color:#E2E3E4;line-height:1.4;">


<?=Yii::app()->createUrl('site/seccion/id/1')?>

<style type="text/css">h1 {color: #00ff00}
h2 {color: #64D5D9}
h6 {color: #000000}

p{color: rgb(0,0,0)}
</style>


------------------------------------------------------------------------------------------------------------------

	 <!-- PARA SUBLIME ACCESO A SNIPPETS

html:5 + tab
div>ul>li*5 
div>ul>li
div, p o ul
nav.menu>ul>li.menu-item*5>a{Enlace $}
ul.generic-list>lorem10.item-$*4
p*3>lorem15 -->

-------------------------------------------------------------------------------------------------------------------

Hola! <?php echo $_SESSION['username']; ?>

-------------------------------------------------------------------------------------------------------------------


<?=						/*vista / controller  ,   parametros */
Yii::app()->createUrl("avisos/avisos",array("id"=>$data->idAviso))

?>


-------------------------------------------------------------------------------------------------------------------



