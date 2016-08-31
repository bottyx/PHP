<!DOCTYPE html>
<html lang="en">
<head>
  <title>PORTALMEDI</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

  <script src="http://maps.googleapis.com/maps/api/js"></script>
<script>
function initialize() {
  var mapProp = {
    center:new google.maps.LatLng(22.6606134,-99.4464559),
    zoom:5,
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>

<style type="text/css">
#menu{
  -moz-border-radius:5px;
  -webkit-border-radius:5px;
  border-radius:5px;
  -webkit-box-shadow:1px 1px 3px #888;
  -moz-box-shadow:1px 1px 3px #888;
}
#menu li{border-bottom:1px solid #FFF;}
#menu ul li, #menu li:last-child{border:none} 
a{
  display:block;
  color:#000;
  text-decoration:none;
  font-family:'Helvetica', Arial, sans-serif;
  font-size:13px;
  padding:3px 5px;
  text-shadow:1px 1px 1px #325179;
}
#menu a:hover{
  color:#F9B855;
  -webkit-transition: color 0.2s linear;
}
#menu ul a{background-color:#6594D1;}
#menu ul a:hover{
  background-color:#FFF;
  color:#2961A9;
  text-shadow:none;
  -webkit-transition: color, background-color 0.2s linear;
}
ul{
  display:block;
  background-color:#2961A9;
  margin:0;
  padding:0;
  width:130px;
  list-style:none;
}
#menu ul{background-color:#6594D1;}
#menu li ul {display:none;}  
</style>

</head>
<body>

<div id="googleMap" style="width:100%; height:700px;"></div>
<br/>
<div class="row" align="center">
<div>
</div>
</div>
<br/>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <!--<div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Seleccione su Ubicación</h4>
      </div>-->
      <?php function listar_archivos($carpeta){
        if(is_dir($carpeta)){
          if($dir = opendir($carpeta)){
              while(($archivo = readdir($dir)) !== false){
                  if($archivo != '.' && $archivo != '..' && $archivo != '.htaccess' && !is_numeric($archivo)){
                    $var = explode('.',$archivo);
                    if(count($var)<2&&($archivo!="cgi-bin")){
                      /*if($archivo  == "cgi-bin")
                      {
                      }*/
                      echo '<div class="col-sm-6 col-md-4">
                              <div class="thumbnail">
                                <img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMjQyIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDI0MiAyMDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzEwMCV4MjAwCkNyZWF0ZWQgd2l0aCBIb2xkZXIuanMgMi42LjAuCkxlYXJuIG1vcmUgYXQgaHR0cDovL2hvbGRlcmpzLmNvbQooYykgMjAxMi0yMDE1IEl2YW4gTWFsb3BpbnNreSAtIGh0dHA6Ly9pbXNreS5jbwotLT48ZGVmcz48c3R5bGUgdHlwZT0idGV4dC9jc3MiPjwhW0NEQVRBWyNob2xkZXJfMTUzNTg4YmQ0YWMgdGV4dCB7IGZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMnB0IH0gXV0+PC9zdHlsZT48L2RlZnM+PGcgaWQ9ImhvbGRlcl8xNTM1ODhiZDRhYyI+PHJlY3Qgd2lkdGg9IjI0MiIgaGVpZ2h0PSIyMDAiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSI4OS44NTkzNzUiIHk9IjEwNS4xIj4yNDJ4MjAwPC90ZXh0PjwvZz48L2c+PC9zdmc+" style="display: block;">
                                <div class="caption" style="padding: 0px;">
                                  <p style="padding: 0px;margin: 0px;">
                                    <a href="./'.$archivo.'">'.$archivo.'</a>
                                  </p>
                                </div>
                              </div>
                            </div>
                      ';
                      #echo $archivo;
                    }
                  }
              }
              closedir($dir);
          }
        }
      }?>
      <div class="modal-body" align="center">
        <div class="row">
          <?php echo listar_archivos('.');?>
        </div>
      </div>
  </div>
</div>
</div>


<script type="text/javascript">

$("#myModal").modal("show");

 $(document).keyup(function(event){
        if(event.which==27)
        {
            //$("#myModal").hide();
            $("#myModal").modal('hide');
        }
        /*$('#myModal').modal({
              backdrop: 'static',
              keyboard: false
            })*/
    });

</script>


</body>
</html>

    

   