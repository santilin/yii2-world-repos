																				LAU_ID
CNTR_CODE	NUTS_ID	NUTS3_ID 	NAME_LATN			POSTCODES 		TIPO		NAT_CODE(INE_MUNI)		NAT_CODE2
ES			ES62				Región de Murcia
ES			ES62	ES620		Santomera			30140						30901
ES			ES62	ES620		El Siscar			30149						309010004*

ES			ES62	ES620		Molina de Segura	30500--			Municipio 	30027					30027000000
ES			ES62	ES620		Altorreal 							Otras entid	30027					30027001402


# Geonames
http://download.geonames.org/export/dump/


COMM_LB_2016_4326.csv => Geolocalizacion3035.csv

Europa_Nuts_Jerarquia.xlsx => nuts.csv

PCODE_2020_PT_SH.dbf => post.csv

https://raw.githubusercontent.com/inigoflores/ds-codigos-postales/master/data/codigos_postales_municipios_join.csv => es_postcodes.csv




Productos y servicios:
https://consultas2.oepm.es/clinmar/inicio.action



FUA_ID: Functional Urban Areas
LAU: Local Administrative Units
DEGURBA: Índice de urbanización.


CREATE INDEX `yii2idx-territorios-taxon` ON `territorios` (`nuts3_id`);
CREATE INDEX `yii2idx-territorios-nombre` ON `territorios` (`fua_id`);


== España
http://centrodedescargas.cnig.es/CentroDescargas/buscadorCatalogo.do?codFamilia=02122#
Nomenclátor Geográfico de Municipios y Entidades de Población: BD_Municipios_entidades.zip





https://en.wikipedia.org/wiki/NUTS_statistical_regions_of_Spain
==
Subdivisiones de todos los países

== post codes degurba para France Germany Spain Switzerland United Kingdom
https://github.com/saschagobel/degurba-postcode-areas

== USA
https://www.naturalearthdata.com/downloads/10m-cultural-vectors/10m-admin-2-counties/

== ALL
https://data.humdata.org/dataset/kontur-boundaries
sqlite3
select * from kontur_boundaries where hasc is not null;
https://github.com/nvkelso/natural-earth-vector

== Australia
= Nueva zelanda: https://www.stats.govt.nz/methods/functional-urban-areas-methodology-and-classification/

== EUROPA
https://en.wikipedia.org/wiki/Nomenclature_of_Territorial_Units_for_Statistics#National_structures
https://gisco-services.ec.europa.eu/tercet/flat-files


https://ec.europa.eu/eurostat/web/gisco/overview
post.csv: Códigos postales de europa. Sólo ciudades, no está el siscar
PC_2020_PT_SH.zip

"OBJECTID","POSTCODE","CNTR_ID","PC_CNTR","NUTS3_2021","CODE","GISCO_ID","NSI_CODE","LAU_NAT","LAU_LATIN","COASTAL","CITY_ID","GREATER_CI","FUA_ID","DGURBA"

OBJECTID "2572922",
POSTCODE "30140",
CNTR_ID "ES",
PC_CNTR "ES_30140",
NUTS3_2021: "'ES620'", Todas las ciudades de Murcia
CODE "'30140'",
GISCO_ID "ES_30901", Todas las municipios de Santomera
NSI_CODE "30901",
LAU_NAT "Santomera",
LAU_LATIN "Santomera",
COASTAL: "NO",
CITY_ID "", Si es una ciudad
GREATER_CI "",
FUA_ID "ES007L2",
DGURBA "2"



https://ec.europa.eu/eurostat/web/nuts/local-administrative-units
https://gisco-services.ec.europa.eu/distribution/v2/nuts/nuts-2021-files.html
	Principales ciudades europeas, para GIS

Países y provincias: https://gisco-services.ec.europa.eu/distribution/v2/nuts/csv/NUTS_AT_2021.csv

https://gisco-services.ec.europa.eu/distribution/v2/lau/lau-2020-files.html
- densidad de población, no vale.



= Geolocalización:
https://gisco-services.ec.europa.eu/distribution/v2/communes/communes-2016-files.html
https://gisco-services.ec.europa.eu/distribution/v2/communes/csv/COMM_LB_2016_3035.csv





