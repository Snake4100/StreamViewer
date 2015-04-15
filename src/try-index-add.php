
<?php
require_once __DIR__ . '/../vendor/autoload.php';

#On récupère le nom de l'index
$fileName = "searchEngine";



#Ensuite, test si l'index existe ou non
if(!file_exists($fileName))
{
	echo "Erreur, index inexistant". PHP_EOL;
}
else 
{	
	
	//On créé ensuite un nouveau document
	$doc = new \ZendSearch\Lucene\Document();
	
	
	$titre = getTitre($rdfData);
	$genre = getGenre($rdfData);
	$instruments = getInstruments($rdfData);
	$motCles = getMotCles($rdfData);
	
	//Auquel on va ajouter les champs souhaités
	$doc->addField(\ZendSearch\Lucene\Document\Field::text('title', $titre));
	$doc->addField(\ZendSearch\Lucene\Document\Field::text('genre', $genre));
	$doc->addField(\ZendSearch\Lucene\Document\Field::text('instrument', $instruments));
	$doc->addField(\ZendSearch\Lucene\Document\Field::text('motCle', $motCles));
	
	
	/*
	try{
		#On ouvre notre index, on recherche si notre document possède un attribut correspondant au chemin de ce fichier.
		
		$index = \ZendSearch\Lucene\Lucene::open($fileName);
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
	}*/
}

function getInstruments($rdfData)
{
    return array('piano synthe saxo');
}

function getMotCles($rdfData)
{
    return array('Doux Bruitage Exotique');
}

function getTitre($rdfData)
{
	return $_GET["titre"];

	//Recupération du titre
	$titre = $rdfData->allOfType('http://purl.org/dc/elements/1.1/#title');
	
	echo "titre: " . $titre .PHP_EOL;
	return $titre;
}

function getGenre($rdfData)
{
	return $_GET["genre"];
	
	
	//Recupération du genre
	$genre = $rdfData->allOfType('http://purl.org/dc/elements/1.1/#genre');
	
	echo "genre: " . $genre .PHP_EOL;
	return $genre;
}
