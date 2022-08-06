# Nuts_LUA
DB=runtime/repos.db

echo "nuts3_id","lau_id","lau_national","lau_latin","change","population","area","degurba","degchange","coastal","coastalchange","city_id","cityidchange","cityname","greater_city_id","greater_city_id_change","greater_city_name","fua_id","new_fua_id","fua_name" > data/definitivo/nuts.csv
python3 /usr/local/bin/xlsx2csv.py -E "Change log" "Overview*" "Comments" -i -p '' -a data/definitivo/Europa_Nuts_Jerarquía.xlsx | grep -v ",POPULATION,TOTAL" >> data/definitivo/nuts.csv

# Postcodes
# dbf-rb -c data/definitivo/PCODE_2020_PT_SH.dbf > data/definitivo/post.csv 2>/dev/null
rm $DB
sqlite3 -init console/controllers/import_territories.cfg $DB

