
<?php
require_once __DIR__ . '/../vendor/autoload.php';

#On récupère le nom de l'index
$indexName = "searchEngine";
#Puis l'élément à rechercher
$toSearch = $_GET["toSearch"];

#Ensuite, test si l'index existe ou non
if(!file_exists($indexName))
{
	echo "Erreur, index inexistant". PHP_EOL;
}
else if($toSearch != null)
{				
	#On ouvre l'index afin de lancer la recherche
	#On lancer la recherche, et on affhiche le score ainsi que le nom du fichier
	#Sinon, une exception est générée
	try{
		
		$index = \ZendSearch\Lucene\Lucene::open($indexName);
		$musicsByGenre = $index->find("genre:".$toSearch);
		$musicsByTitle = $index->find("title:".$toSearch);
		$musicsByMotsCles = $index->find("motCles:".$toSearch);
		$musicsByInstrument = $index->find("instruments:".$toSearch);
		$musics = array_merge($musicsByTitle, $musicsByGenre);
		
		foreach($musics as $music){
			echo "<li>Titre: " . $music->title . ", Genre : " . $music->genre . ", Mots Cles : " . $music->motsCles . ", Instruments : " . $music->instruments ."</li>";
		}
		
		
	}
	catch(\ZendSearch\Lucene\Exception\RuntimeException $e){
		echo "Erreur lors/après l'ouverture de l'index. Fin de l'exécution" . PHP_EOL;
	}
}