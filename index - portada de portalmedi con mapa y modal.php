
<html lang="en">
<head>
  <meta charset="UTF-8" />  
  <title>PORTALMEDI</title>

  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

  <link rel="stylesheet" type="text/css" href="http://www.portalmedi.com.mx/merida/assets/css/custom.css">
  
  <link id="ait-style" rel="stylesheet" type="text/css" media="all"  href="http://www.portalmedi.com.mx/merida/assets/css/style.css"/>


  <script src="http://maps.googleapis.com/maps/api/js"></script>
<script>
function initialize() {
  var mapProp = {
    center:new google.maps.LatLng(17.887848,-97.593388),
    zoom:5,
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>


<style>
  select{
    box-sizing: border-box;
    /*width: 100%;*/
    width: 222px;
    height: 28px;
    margin-bottom: 0px;
    margin-right: 35px;
    padding: 0 5px 0;
    border: 1px solid #d5d5d5;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    border-bottom: 2px solid #c;
  }
</style>
  
<script type="text/javascript">
  $(document).ready(function() {
  $("#myModal").modal("show");
  });

</script>
</head>

<body>

  <div id="page" class="hfeed header-type-map" >
    <div class="topbar"></div>
    <header id="branding" role="banner" class="wpml-inactive register-inactive login-active site-header">
      <div class="wrapper header-holder">
        <div id="logo" class="left">
          <a class="trademark" href="#">
            <img src="http://www.portalmedi.com.mx/merida/assets/img/logo.png" alt="Business Finder" />
          </a>
        </div>

        <div class="menu-container right clearfix">
          <div class="menu-content defaultContentWidth clearfix right">
            <nav id="access" role="navigation">
              <span class="menubut bigbut">Menú Principal</span>
              <nav class="mainmenu">
                <ul id="menu-main-menu" class="menu">
                  <li   class="menu-item     "><a href="#">Inicio</a>
                  </li>

                  <li   class="menu-item  "><a href="#">¿Quienes Somos?</a>
                    <ul class="sub-menu">
                      <li  class="menu-item"><a href="#">Misión y Visión</a></li>
                    </ul>
                  </li>
                  <li  class="menu-item "><a href="#">Contácto</a>
                  <li  class="menu-item "><a href="#">Registro</a>
                    <ul class="sub-menu">
                      <li  class="menu-item  "><a href="#">Médicos</a></li>
                      <li  class="menu-item  "><a href="#">Pacientes</a></li>
                    </ul>
                  </li>
                  </li>
                  <li   class="menu-item  "><a href="#">Ubicación</a></li>
                <li  class="menu-item "><a href="#myModal"> Iniciar sesión</a></li>                 
                </ul>
              </nav>        
            </nav><!-- #access -->
            </div>
          </div>
        </div>
      </header><!-- #branding -->
      <div id="main" class="mainpage onecolumn">

        <div id="directory-search" class="regular-search" align="center">
          <div class="wrapper">
            <form action="" name="formKayworder" id="dir-search-form" method="post" class="dir-searchform">
              <div class="first-row clearfix">
                <div class="basic-search-form clearfix">
                  <div id="dir-search-inputs">
                    <b>Directorio</b>
                    <br>                    
                    <select  name="catalogo" id="cata" required="required" class="form-control">
                      <option value="" selected="selected">Todos</option>
                    </select>
                  </div>
                  <div id="dir-search-inputs">
                    <b>Zona</b>
                    <br>
                    
                    <select name="zona" id="zo" class="form-control">
                      <option value="" selected="selected">Todos</option>
                    </select>
                  </div>
                  <div id="dir-search-inputs">
                    <b>Especialidades</b>
                    <br>
                    <select name="especialidades" id="especi" class="form-control" >
                      <option value="" selected="selected">Todas</option>
                    </select>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div id="googleMap" style="width:100%; height:700px;"></div>

          <div id="directory-search" class="regular-search" align="center" >
            <div class="wrapper">
              <form action="" name="formKayword" id="dir-search-form" method="post" class="dir-searchform">
                 <div class="first-row clearfix">
                    <div class="basic-search-form clearfix">
                       <div id="dir-search-inputs">
                          <div id="dir-holder">
                             <div class="dir-holder-wrap">
                                <input type="text" name="keyword" id="keyword" value="" placeholder="Término de búsqueda..." class="dir-searchinput" />
                                <input type="hidden" name="catalogo" value="todas">
                                <div class="reset-ajax"></div>
                             </div>
                          </div>
                          <input type="text" name="categories" id="dir-searchinput-category-id" value="0" style="display: none;" />
                       </div>
                       <div id="dir-search-button">
                          <input type="submit" value="Buscar" class="dir-searchsubmit" />
                       </div>
                    </div>
                    
                 </div>
              </form>
            </div>
          </div>

          <br/>
          <hr/>
          <br>
          <div align="center">
          <img src="http://www.portalmedi.com.mx/merida/assets/img/banner/1408460885.jpg" alt="Business Finder" />
        </div>
        <br>


            <!-- Modal -->
<div class="modal " id="myModal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
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
        <footer id="colophon" >
          <div id="site-generator" class="wrapper">
            <div id="footer-text">
              <p><strong>© 2012 Copyright by Directorio Médico.</strong> All rights reserved. Lorem ipsum dolor sit amet consecteur...</p>
            </div>
            <nav class="footer-menu"><ul id="menu-footer-menu" class="menu"><li id="menu-item-8236" class="menu-item  current-menu-item page_item page-item-7 current_page_item menu-item-8236"><a href="<?php echo basE_url(); ?>">Inicio</a></li>
              <li  class="menu-item"><a href="#">Quienes somos</a></li>
              <li   class="menu-item"><a href="#">Misión y visión</a></li>
              <li   class="menu-item"><a href="#">Directorio</a></li>
              <li   class="menu-item"><a href="#">Registro</a></li>
              <li   class="menu-item"><a href="#">Contáctanos</a></li>
            </ul></nav></div>
          </footer>
        </div><!-- #psage -->



</body>
</html>



