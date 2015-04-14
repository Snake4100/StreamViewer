#! /usr/bin/python
# -*- coding: utf-8 -*-

import libxmp
import re
import rdflib
import os
import io
import sys
import json

dossierMusique = "Musique/"

wav_files = [ f for f in os.listdir(dossierMusique) if  f.endswith(".wav") ]

all_rdf = {}

for wav in wav_files:
	wav = "%s%s"%(dossierMusique, wav)
	xmpfile = libxmp.XMPFiles(file_path=wav, open_forupdate=True )
	xmp = xmpfile.get_xmp()

	motif = re.compile('(<rdf[:]RDF.*>)([\w\W]+)(</rdf[:]RDF>)')
	recherche = motif.search(str(xmp))
	rdf = ""

	if recherche is not None:
		rdf += recherche.group()

	all_rdf[wav]=rdf

print json.dumps(all_rdf)







