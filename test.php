<?php
	echo "helo \n";

	$output = shell_exec("python get_all_rdf.py");
	
	$resultat = json_decode($output,true);

	echo "wesh ma gueule : \n";
	var_dump($resultat);



