<?php
require '../vendor/autoload.php';

//Ouverture du rdf
$graph = EasyRdf_Graph::newAndLoad('http://localhost:8888/StreamViewer/travelling.rdf');

//Recupération de tous les instruments
$instruments = $graph->allOfType('http://example.org#instrument');

//Liste de tous les instruments
foreach($instruments as $instrument){
	
	echo $instrument  .PHP_EOL;
}
echo "fini"  .PHP_EOL;