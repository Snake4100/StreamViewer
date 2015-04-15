<?php
	
	$dossier_musique = "Musique/";

	$fichiers = scandir($dossier_musique);

	foreach ($fichiers as $fichier){

		//si c'est un fichier wav
		if(strpos($fichier,'.wav') != false){

			$chemin = $dossier_musique.$fichier;

			$output = shell_exec("python get_rdf_data.py $chemin");
	
			$resultat = json_decode($output);
			var_dump($resultat);

$titre = " ";
$genre = " ";
$motsCles = " ";
$instrument = " ";
			foreach($resultat as $key => $data) {			
				if($key == 'titre'){
					$titre = $data;	
				}    		
				else if($key == 'genre'){
					$genre = $data;	
				}    		
				else if($key == 'motCles'){
					$motsCles = $data;	
				}    		
				else if($key == 'instrument'){
					$instrument = $data;	
				}    
				
				echo 'key: ' . $key .PHP_EOL;
			}
				echo 'titre: ' . $titre .PHP_EOL;
				echo 'genre: ' . $genre .PHP_EOL;
				echo 'motCles: ' . $motsCles .PHP_EOL;
				echo 'instruments: ' . $instrument .PHP_EOL;	
		}
	}

	



