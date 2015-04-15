<?php
	
	$dossier_musique = "Musique/";

	$fichiers = scandir($dossier_musique);

	foreach ($fichiers as $fichier){

		//si c'est un fichier wav
		if(strpos($fichier,'.wav') != false){

			$chemin = $dossier_musique.$fichier;

			$output = shell_exec("python get_all_rdf.py $chemin");
	
			$resultat = json_decode($output,true);

			var_dump($resultat);
		}
	}

	



