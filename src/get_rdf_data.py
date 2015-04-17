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

def get_RDF(file):
	xmpfile = libxmp.XMPFiles(file_path=wav, open_forupdate=True )
	xmp = xmpfile.get_xmp()

	motif = re.compile('(<rdf[:]RDF.*>)([\w\W]+)(</rdf[:]RDF>)')
	recherche = motif.search(str(xmp))
	rdf = '<?xml version="1.0"?>'

	if recherche is not None:
		rdf += recherche.group()

	return rdf

wav = sys.argv[1]
rdfData = {}
if os.path.isfile(wav):	
	#on crée un fichier temporaire avec le rdf
	rdf = open("temp.rdf", "wb")
	rdf.write(get_RDF(wav))
	rdf.close()

	"""rdfFile = wav.split('.')[0]+".rdf"
	
	rdf = open(rdfFile,"r").read()"""

	rdf = open("temp.rdf","r").read()

	g = rdflib.Graph()
	result = g.parse(data = rdf, format="application/rdf+xml")

	
	#on récupére le titre
	titres = g.query('SELECT ?title  where { ?alt <http://www.w3.org/1999/02/22-rdf-syntax-ns#_1> ?title . ?x <http://purl.org/dc/elements/1.1/title> ?alt.}')
	
	for titre in titres:
		titre = "%s"%titre

		rdfData['titre'] = titre
		
	#on récupére le genre
	genres = g.query('SELECT ?genre  where { ?alt <http://www.w3.org/1999/02/22-rdf-syntax-ns#_1> ?genre . ?x <http://purl.org/dc/elements/1.1/genre> ?alt.}')
	
	for genre in genres:
		genre = "%s"%genre
		rdfData['genre'] = genre

	#on récupére les mots cles
	motCles = g.query("SELECT ?mot_cle  where {  ?x <http://purl.org/dc/elements/1.1/mots-cles> ?alt . ?alt ?y ?mot_cle. }")
	
	motsClesStr =""
	for mot_cle in motCles :
		mot_cle = "%s "%mot_cle
		if not "http://" in mot_cle:
			motsClesStr += mot_cle
	rdfData['motCles'] = motsClesStr
			
		
	#on récupére les instruments
	instruments = g.query('SELECT distinct ?instrument  where {  ?x <http://purl.org/dc/elements/1.1/instruments> ?alt . ?bag ?y ?instrument. }')
	
	instrumentStr =""
	for instrument in instruments:
		instrument = "%s "%instrument
		if not "http://" in instrument:
			instrumentStr += instrument
	rdfData['instrument'] = instrumentStr	
	
	#print rdfData
	print json.dumps(rdfData)





