#! /usr/bin/python
# -*- coding: utf-8 -*-

import libxmp
import re
import rdflib
import os
import io
import sys
import json
import sys

wav = sys.argv[1]
rdfData = {}
if os.path.isfile(wav):
	xmpfile = libxmp.XMPFiles(file_path=wav, open_forupdate=True )
	xmp = xmpfile.get_xmp()
	
	rdfFile = wav.split('.')[0]+".rdf"
	
	motif = re.compile('(<rdf[:]RDF.*>)([\w\W]+)(</rdf[:]RDF>)')
	recherche = motif.search(str(xmp))
	
	rdf = open(rdfFile,"r").read()

	g = rdflib.Graph()
	result = g.parse(data = rdf, format="application/rdf+xml")


	#on récupére le titre
	titres = g.query('SELECT ?titre where { ?musique <http://example.org#titre> ?titre  . }')
	for titre in titres:
		titre = "%s"%titre
		rdfData['titre'] = titre
		
	#on récupére le genre
	genres = g.query('SELECT ?nom_genre where { ?musique <http://example.org#genre> ?genre. ?genre <http://example.org#name> ?nom_genre }')
	for genre in genres:
		genre = "%s"%genre
		rdfData['genre'] = genre

	#on récupére les mots cles
	motCles = g.query('SELECT ?mot_cle where { ?musique <http://example.org#mots-cles> ?motsCles . ?motsCles <http://example.org#mot-cle> ?x . ?x <http://example.org#name> ?mot_cle }')
	motsClesStr =""
	for mot_cle in motCles:
		motsClesStr += "%s "%mot_cle
	rdfData['motCles'] = motsClesStr
			
		
	#on récupére les instruments
	instruments = g.query('SELECT ?instrument where {?musique <http://example.org#instruments> ?instruments . ?instruments <http://example.org#instrument> ?x . ?x <http://example.org#name> ?instrument }')
	instrumentStr =""
	for instrument in instruments:
		instrumentStr += "%s "%instrument
	rdfData['instrument'] = instrumentStr	
	
	print json.dumps(rdfData)





