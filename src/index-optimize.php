#!/usr/bin/php -Cq
<?php
require_once __DIR__ . '/zendsearch/vendor/autoload.php';

#On récupère le nom de l'index
$indexName = $argv[1];

#Test si l'index existe ou non
if(!file_exists($indexName))
{
	echo "Erreur, index inexistant". PHP_EOL;
}
else
{	
	#On ouvre l'index afin de lancer l'optimisation
	#S'il est ouvert, on l'optimise
	#Sinon, une exception est générée
	try{
		$index = \ZendSearch\Lucene\Lucene::open($indexName);
		$index->optimize();
	}
	catch(\ZendSearch\Lucene\Exception\RuntimeException $e){
		echo "Index erreur, fin de l'operation" . PHP_EOL;
	}
}