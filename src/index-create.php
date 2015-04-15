
<?php
require_once __DIR__ . '/../vendor/autoload.php';

#On récupère le nom de l'index
$indexName = "searchEngine";

#Test si l'index existe ou non
if(file_exists($indexName))
{
	echo "Erreur, index déjà existant". PHP_EOL;
}
else
{	
	#S'il n'existe pas, on le créé
	$index = \ZendSearch\Lucene\Lucene::create($indexName);
}