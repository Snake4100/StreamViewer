<?php
//header("Location: http://localhost:8888/StreamViewer/acceuil.php");
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