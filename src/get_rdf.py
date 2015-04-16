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

if os.path.isfile(wav):
	xmpfile = libxmp.XMPFiles(file_path=wav, open_forupdate=True )
	xmp = xmpfile.get_xmp()

	motif = re.compile('(<rdf[:]RDF.*>)([\w\W]+)(</rdf[:]RDF>)')
	recherche = motif.search(str(xmp))
	rdf = ""

	if recherche is not None:
		rdf += recherche.group()

	print json.dumps(rdf)







