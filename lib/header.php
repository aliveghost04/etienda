
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">E-Tienda</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
       <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li class="divider"></li>
            <li><a href="#">Separated link</a></li>
            <li class="divider"></li>
            <li><a href="#">One more separated link</a></li>
          </ul>
        </li>
      </ul>
      <form action="categories.php" class="navbar-form navbar-left" role="search" onSubmit="return validarBusqueda();">
        <div class="form-group has-feedback">
          <label class="" for="search">&nbsp;</label>
          <input type="text" class="form-control" id="search" name="search" placeholder="Busqueda" value="<?php if (isset($_GET['search'])) echo $_GET['search']?>">
          <span class="glyphicon glyphicon-search form-control-feedback"></span>
        </div>
        <input id="searchb" type="submit" class="btn btn-info prueba" value="Buscar" data-toggle="popover" data-placement="bottom" data-content="*Introduzca el articulo que desea buscar">
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li><?php 
            if(isset($_SESSION["loged"])) {
              if ($_SESSION['loged'] == true) 
                include("lib/identified.php");
            } else {
              include("lib/not_identified.php");
            }?>  
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<a href="index.php"><h1 class="center-block">E-Tienda <br> <small>Donde encuentras todo lo que necesitas</small></h1></a>