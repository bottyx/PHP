<?php
$cs=Yii::app()->clientScript;
$cs->registerScript('ajaxFirmaButton',
'$(document).ready(function() {

$("#btn-enviar").on("click",function(e) {
        $.ajax({
            type:"POST",
            url: "'.Yii::app()->createUrl("comentarios/validar").'",
            data:{data:$("#captchaC").val()},
            success:function(data)
            {
                var $myForm= $("#frm");
                if(data=="check")
                {
                    
                        $.ajax({
                        type: "POST",
                        url: "'.Yii::app()->createUrl("comentarios/enviar").'",
                        data: {Comentarios:{nombre:$("#Comentarios_nombre").val(),
                                comentario:$("#Comentarios_comentario").val(),
                                id_noticia:$("#Comentarios_id_noticia").val()
                              }},
                        success: function(data){
                          console.log(data);
                          $("#new_msj").modal("hide");
                        }
                      });
                }
                else if($myForm[0].checkValidity())
                {
                    alert("La captcha no coincide");
                }
            }

        });
    });

 });',
CClientScript::POS_END);

?>

