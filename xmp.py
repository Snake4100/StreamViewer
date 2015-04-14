#! /usr/bin/python
# -*- coding: utf-8 -*-

import libxmp
import re
import rdflib
import tempfile
import os
import io

nameSpace_DC = "http://purl.org/dc/elements/1.1/"
nameSpace_ex = "http://example.org#"
dossierMusique = "Musique/"

rdf_files = [ f for f in os.listdir(dossierMusique) if  f.endswith(".rdf") ]

for fichier_rdf in rdf_files:
	fichier_wav = "%s%s.wav"%(dossierMusique, fichier_rdf.split(".")[0])

	#si le fichier wav correspondant existe
	if os.path.isfile(fichier_wav):

		#on récupére le xmp du fichier wav
		xmpfile = libxmp.XMPFiles(file_path=fichier_wav, open_forupdate=True )
		meta = libxmp.XMPMeta()


		#on récupére le fichier rdf que l'on veut insérer dans le wav
		rdf = open("%s%s"%(dossierMusique, fichier_rdf),"r").read()

		g = rdflib.Graph()
		result = g.parse(data = rdf, format="application/rdf+xml")


		#on récupére le titre
		resutlat = g.query('SELECT ?titre where { ?musique <http://example.org#titre> ?titre  . }')

		for titre in resutlat:
			titre = "%s"%titre
			#meta.set_property(nameSpace_DC, 'title', str(titre).encode('utf-8'))
			meta.set_localized_text(nameSpace_DC, 'title', 'fr-FR','fr-FR', str(titre).encode('utf-8'))

		#on récupére le genre
		resutlat = g.query('SELECT ?nom_genre where { ?musique <http://example.org#genre> ?genre. ?genre <http://example.org#name> ?nom_genre }')

		for genre in resutlat:
			genre = "%s"%genre
			#meta.set_property(nameSpace_DC, 'subject', str(genre).encode('utf-8'))
			meta.set_localized_text(nameSpace_DC, 'genre', 'fr-FR','fr-FR', str(genre).encode('utf-8'))

		#on récupére les mots cles
		resultat = g.query('SELECT ?mot_cle where { ?musique <http://example.org#mots-cles> ?motsCles . ?motsCles <http://example.org#mot-cle> ?x . ?x <http://example.org#name> ?mot_cle }')

		for mot_cle in resultat:
			mot_cle = "%s"%mot_cle
			meta.append_array_item(nameSpace_DC, 'mots-cles', str(mot_cle).encode('utf-8'),{'prop_value_is_array':libxmp.consts.XMP_PROP_VALUE_IS_ARRAY})

		#on récupére les instruments
		resultat = g.query('SELECT ?instrument where {?musique <http://example.org#instruments> ?instruments . ?instruments <http://example.org#instrument> ?x . ?x <http://example.org#name> ?instrument }')

		for instrument in resultat:
			instrument = "%s"%instrument
			print instrument
			meta.append_array_item(nameSpace_DC, 'instruments', str(instrument).encode('utf8'),{'prop_value_is_array':libxmp.consts.XMP_PROP_VALUE_IS_ARRAY})


		#test if file could be update 
		print 'file could be update = ', xmpfile.can_put_xmp(meta)

		#update the file with xmp metadata
		xmpfile.put_xmp(meta)
		xmpfile.close_file(close_flags=1)

		#on réouvre pour voire si ça a marché
		xmpfile = libxmp.XMPFiles(file_path=fichier_wav, open_forupdate=True )
		xmp = xmpfile.get_xmp()

		print xmp
	

"""xmpfile = libxmp.XMPFiles(file_path="../Musique/Luiz.wav", open_forupdate=True )
xmp = xmpfile.get_xmp()
print xmp
#create meta data
meta = libxmp.XMPMeta()
print 'alt2 = ',meta.set_localized_text(nameSpace_DC, 'title', 'en-US','en-US', 'music file')
print 'alt1 = ',meta.set_localized_text(nameSpace_DC, 'title', 'fr-FR','fr-FR', 'fichier musicale')
print 'bag1 = ',meta.append_array_item(nameSpace_DC, 'subject', 'pop', {'prop_value_is_array':libxmp.consts.XMP_PROP_VALUE_IS_ARRAY})
print 'bag2 = ',meta.append_array_item(nameSpace_DC, 'subject','electro')

#test if file could be update 
print 'file could be update = ', xmpfile.can_put_xmp(meta)

#update the file with xmp metadata
xmpfile.put_xmp(meta)
xmpfile.close_file(close_flags=1)

xmpfile = libxmp.XMPFiles(file_path="../Musique/Luiz.wav", open_forupdate=True )
xmp = xmpfile.get_xmp()

print xmp"""