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
 <div class="col-lg-3">
    </div>

 	<div class="col-lg-6">
 		<?php
//header("Location: http://localhost:8888/StreamViewer/acceuil.php");
include 'nav.php';

$target_dir = "/Applications/MAMP/htdocs/StreamViewer/Musique/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo shell_exec("php src/index-add.php ".$target_file);
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>

 	</div>

 	<div class="col-lg-3">
    </div>
 </body>
</html>