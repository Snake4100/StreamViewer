
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
	
	if(!file_exists(str_replace('.wav', '.rdf',$fichier))){
		echo "Erreur, fichier RDF non trouvé".PHP_EOL;
		return;	
	}
	
	
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
				echo 'titre: ' . $titre .PHP_EOL;
				echo 'genre: ' . $genre .PHP_EOL;
				echo 'motCles: ' . $motsCles .PHP_EOL;
				echo 'instruments: ' . $instruments .PHP_EOL;	
	
	//Auquel on va ajouter les champs souhaités
	$doc->addField(\ZendSearch\Lucene\Document\Field::text('title', $titre));
	$doc->addField(\ZendSearch\Lucene\Document\Field::text('genre', $genre));
	$doc->addField(\ZendSearch\Lucene\Document\Field::text('instruments', $instruments));
	$doc->addField(\ZendSearch\Lucene\Document\Field::text('motCles', $motsCles));
	
	
	
	try{
		#On ouvre notre index, on recherche si notre document possède un attribut correspondant au chemin de ce fichier.
		
		$index = \ZendSearch\Lucene\Lucene::open($indexName);
		$resultFind = $index->find("title:".$titre);
		
		#On test si notre fichier est déjà indexé ou pas.
		#Si il n'est pas déjà indexé, on le fait
		
		if(count($resultFind) ==0){
			$doc->addField(\ZendSearch\Lucene\Document\Field::text('title', $titre));
			$index->addDocument($doc);
			echo "Music added: " . $titre .PHP_EOL;
		}
		#Sinon, on arrête le traitement.
		else{
			echo "Erreur, document déjà existant" . PHP_EOL;
		}
		
		$index->optimize();
	}
	catch(\ZendSearch\Lucene\Exception\RuntimeException $e){
		echo "Index erreur, fin de l'operation" . PHP_EOL;
	}
}

