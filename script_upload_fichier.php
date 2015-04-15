<?php
//header("Location: http://localhost:8888/StreamViewer/acceuil.php");
if(isset($_FILES['userfile']))
{ 	
	 ini_set('display_errors',1);
	 error_reporting(E_ALL);
	 
     $dossier = 'Musique/';
     $fichier = basename($_FILES['userfile']['name']);
     var_dump($_FILES['userfile']['name']);

     if(move_uploaded_file($_FILES['userfile']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
     {
          echo 'Upload effectué avec succès !';

          //appeler le script index-add.php avec en parametre le chemin du fichier

     }
     else //Sinon (la fonction renvoie FALSE).
     {
          echo 'Echec de l\'upload !';
     }
     
      
      //exit(); 
}	
?>