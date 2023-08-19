# Nuts_LUA
DATADIR=data
DB=runtime/repos_aux.db
if [ -f $HOME/.local/bin/xlsx2csv ]; then
	XLS2CSV=$HOME/.local/bin/xlsx2csv
else
	XLS2CSV="python3 /usr/local/bin/xlsx2csv.py"
fi

echo "nuts3_id","lau_id","lau_national","lau_latin","change","population","area","degurba","degchange","coastal","coastalchange","city_id","cityidchange","cityname","greater_city_id","greater_city_id_change","greater_city_name","fua_id","new_fua_id","fua_name" > $DATADIR/nuts.csv
$XLS2CSV -a -I BE BG CZ DK -p '' $DATADIR/Europa_Nuts_Jerarquía.xlsx | grep -v ",POPULATION,TOTAL" >> $DATADIR/nuts.csv
$XLS2CSV -a -I DE EE IE EL -p '' $DATADIR/Europa_Nuts_Jerarquía.xlsx | grep -v ",POPULATION,TOTAL" >> $DATADIR/nuts.csv
$XLS2CSV -a -I ES FR HR IT -p '' $DATADIR/Europa_Nuts_Jerarquía.xlsx | grep -v ",POPULATION,TOTAL" >> $DATADIR/nuts.csv
$XLS2CSV -a -I CY LV LU HU -p '' $DATADIR/Europa_Nuts_Jerarquía.xlsx | grep -v ",POPULATION,TOTAL" >> $DATADIR/nuts.csv
$XLS2CSV -a -I MT NL AT PL -p '' $DATADIR/Europa_Nuts_Jerarquía.xlsx | grep -v ",POPULATION,TOTAL" >> $DATADIR/nuts.csv
$XLS2CSV -a -I PT RO SI SK -p '' $DATADIR/Europa_Nuts_Jerarquía.xlsx | grep -v ",POPULATION,TOTAL" >> $DATADIR/nuts.csv
$XLS2CSV -a -I FI SE UK IS -p '' $DATADIR/Europa_Nuts_Jerarquía.xlsx | grep -v ",POPULATION,TOTAL" >> $DATADIR/nuts.csv
$XLS2CSV -a -I LI NO CH ME -p '' $DATADIR/Europa_Nuts_Jerarquía.xlsx | grep -v ",POPULATION,TOTAL" >> $DATADIR/nuts.csv
$XLS2CSV -a -I MK AL RS TR -p '' $DATADIR/Europa_Nuts_Jerarquía.xlsx | grep -v ",POPULATION,TOTAL" >> $DATADIR/nuts.csv
$XLS2CSV -a -I BA XK -p '' $DATADIR/Europa_Nuts_Jerarquía.xlsx | grep -v ",POPULATION,TOTAL" >> $DATADIR/nuts.csv

Postcodes
dbf-rb -c $DATADIR/PCODE_2020_PT_SH.dbf > $DATADIR/post.csv 2>/dev/null


pushd $DATADIR
wget https://raw.githubusercontent.com/inigoflores/ds-codigos-postales/master/data/codigos_postales_municipios_join.csv -O es_postcodes.csv
popd

rm $DB
sqlite3 -init console/controllers/import_territories.cfg $DB

