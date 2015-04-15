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
        <form action="upload.php" method="post" enctype="multipart/form-data">
		    Select image to upload:
		    <input type="file" name="fileToUpload" id="fileToUpload">
		    <input type="submit" value="Upload Image" name="submit">
		</form>
    </div>

    <div class="col-lg-4">
    </div>
    
 	
 </body>
</html>