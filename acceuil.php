<html>
 <head>
 	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- Concerne IE. Ne passe pas la validation W3C -->
    <meta name="viewport" content="width=device-width, initial-scale=1"><!-- Concerne les mobiles -->
    <title>StreamViewer</title>

    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
 </head>
 <body>
    <?php
        include 'nav.php';
     ?>

 	<header class="row">
        <div class="col-lg-12">
        	<h2 class="text-center">StreamViewer<h2>
        </div>
    </header>

    <br>
    <br>
    <br>


 	<div class="col-lg-3">
    </div>

 	<div class="col-lg-6">
 		<form enctype="multipart/form-data" action="http://localhost:8888/StreamViewer/src/index-search.php" method="post">
	 		<div class="form-group">
	    		<input type="text" name="toSearch" class="form-control" placeholder="Recherche ...">
	  		</div>
	  		<button type="submit" class="btn btn-default center-block">Rechercher</button>
		</form>
 	</div>

 	<div class="col-lg-3">
    </div>
 	
 </body>
</html>