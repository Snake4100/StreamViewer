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
        	<h2 class="text-center">Ajouter une musique sur StreamViewer !<h2>
        </div>
    </header>

    <br>
    <br>
    <br>

    <div class="col-lg-4">
    </div>

    <div class="col-lg-4">
        <form enctype="multipart/form-data" action="http://localhost:8888/StreamViewer/script_upload_fichier.php" method="post">
            <div class="form-group">

                <!-- MAX_FILE_SIZE doit précéder le champ input de type file -->
                <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
                <!-- Le nom de l'élément input détermine le nom dans le tableau $_FILES -->
                <!--<input name="userfile" type="file" class="form-control"/>-->
                <input name="userfile" type="file" class="filestyle center-block" data-size="lg">
                <br>
                <input type="submit" value="Envoyer le fichier" class="btn btn-default center-block"/>
            </div>
        </form>
    </div>

    <div class="col-lg-4">
    </div>
    
 	
 </body>
</html>