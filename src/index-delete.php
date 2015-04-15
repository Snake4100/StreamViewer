
<?php
require_once __DIR__ . '/../vendor/autoload.php';

#On récupère le nom de l'index
$indexName = "searchEngine";

#Test si l'index existe ou non
if(!file_exists($indexName))
{
	echo "Erreur, index inexistant". PHP_EOL;
}
else
{	
	#On ouvre l'index afin de tester s'il est vraiment de type index
	#Si c'est le cas, on le supprime.
	#Sinon, une exception est générée
	try{
		$index = \ZendSearch\Lucene\Lucene::open($indexName);
   		deleteDirectory($indexName);
   		
		echo "Index supprimé avec succès". PHP_EOL;
	}
	catch(\ZendSearch\Lucene\Exception\RuntimeException $e){
		echo "Index erreur, fin de l'operation" . PHP_EOL;
	}
}

#Fonction de suppression du répertoire récursif (suppression successive des fichiers et dossiers, jusqu'à la source)
function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }
    if (!is_dir($dir)) {
        return unlink($dir);
    }
    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }
    return rmdir($dir);
}