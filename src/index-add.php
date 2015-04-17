
<?php
require '/Applications/MAMP/htdocs/StreamViewer/vendor/autoload.php';

#On récupère le nom de l'index
$indexName = "/Applications/MAMP/htdocs/StreamViewer/src/searchEngine";



#Ensuite, test si l'index existe ou non
if(!file_exists($indexName))
{
	echo "Erreur, index inexistant". PHP_EOL;
}
else 
{	
	$fichier = $argv[1];
	
	$output = shell_exec("python /Applications/MAMP/htdocs/StreamViewer/src/get_rdf_data.py $fichier");
	
	$rdfData = json_decode($output,true);
	

	
	//On créé ensuite un nouveau document
	$doc = new \ZendSearch\Lucene\Document();
	
	
	$titre = " ";
	$genre = " ";
	$motsCles = " ";
	$instruments = " ";
	
	foreach($rdfData as $key => $data) {			
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
			$instruments = $data;	
		}    
		
	}
				echo 'Titre: ' . $titre ."<br/>";
				echo 'Genre: ' . $genre ."<br/>";
				echo 'Mot Cles: ' . $motsCles ."<br/>";
				//echo 'Instruments: ' . $instruments ."<br/>";	
	
	//Auquel on va ajouter les champs souhaités
	$doc->addField(\ZendSearch\Lucene\Document\Field::text('title', $titre));
	$doc->addField(\ZendSearch\Lucene\Document\Field::text('genre', $genre));
	$doc->addField(\ZendSearch\Lucene\Document\Field::text('instruments', $instruments));
	$doc->addField(\ZendSearch\Lucene\Document\Field::text('motCles', $motsCles));
	$doc->addField(\ZendSearch\Lucene\Document\Field::text('chemin', "/StreamViewer/Musique/".$titre . ".wav"));
	
	
	
	try{
		#On ouvre notre index, on recherche si notre document possède un attribut correspondant au chemin de ce fichier.
		
		$index = \ZendSearch\Lucene\Lucene::open($indexName);
		$resultFind = $index->find("fichier:".$fichier);
		
		#On test si notre fichier est déjà indexé ou pas.
		#Si il n'est pas déjà indexé, on le fait
		
		if(count($resultFind) ==0){
			$index->addDocument($doc);
			echo "<br/><h3>Musique ajoutée : " . $titre ."</h3>";
		}
		#Sinon, on arrête le traitement.
		else{
			echo "Erreur, document déjà existant" . PHP_EOL;
		}
		
		//Optimisation de l'index
		$index->optimize();
	}
	catch(\ZendSearch\Lucene\Exception\RuntimeException $e){
		echo "Index erreur, fin de l'operation" . PHP_EOL;
	}
}

