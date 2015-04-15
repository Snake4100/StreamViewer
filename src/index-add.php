
<?php
require_once __DIR__ . '/../vendor/autoload.php';

#On récupère le nom de l'index
$fileName = "searchEngine";

$titre = $_GET["title"];
$genre = $_GET["genre"];
$instruments = $_GET["in"];
$motCles = $_GET["mc"];

#Ensuite, test si l'index existe ou non
if(!file_exists($fileName))
{
	echo "Erreur, index inexistant". PHP_EOL;
}
else if($fileName != null)
{	
	
	//On créé ensuite un nouveau document
	$doc = new \ZendSearch\Lucene\Document();
	
	//Auquel on va ajouter les champs souhaités
	$doc->addField(\ZendSearch\Lucene\Document\Field::text('title', $titre));
	$doc->addField(\ZendSearch\Lucene\Document\Field::text('genre', $genre));
	
	//A tester
	$instruments = getInstruments();
	$motCles = getMotCles();
	
	
	$doc->addField(\ZendSearch\Lucene\Document\Field::text('instrument', $instruments));
	
	$doc->addField(\ZendSearch\Lucene\Document\Field::text('motCle', $motCles));
	
	
	
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
	}
}

function getInstruments()
{
    return array('piano synthe saxo');
}

function getMotCles()
{
    return array('Doux Bruitage Exotique');
}