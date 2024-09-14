
[//]: # (<<<<<MAIN)
# world-repos 0.0.1
World repositories

[//]: # (>>>>>MAIN)
# yii2-world-repos
World repos of all kinds: countries, cities ,villages, etc.

[//]: # (<<<<<INSTALL)
# Instalación

* Configurar config/smtp.php
* Configurar config/secrets.php
* Configurar config/db.php

```
mkdir -m 777 web/assets
mkdir -pm 777 runtime/logs runtime/HTML runtime/uploads
cd web
ln -s ../runtime/uploads .
cd ..
\# sqlite3
if [ -f runtime/world-repos.db ]; then
	chmod g+w runtime/world-repos.db
	chgrp www-data runtime/world-repos.db
	YII2_SQLITE3_DISABLE_FOREIGN_CHECKS=1 ./yii migrate
else
	./yii migrate
fi
```
## Configuración extra

### web.php:
```
$config['modules']['user']['administrators'] = ['santilin'];
```

[//]: # (>>>>>INSTALL)
[//]: # (<<<<<TESTS)
# Tests
Hay tres niveles estandar de tests:
## unitarios
En tests/unit, usan fixtures propias autogeneradas
## funcionales
* en `tests/functional`
* fixtures compartidas y no autogeneradas en `tests/fixtures`
## de aceptación
* en `tests/acceptance`,
* fixtures compartidas y no autogeneradas en `tests/fixtures`
* BDD. Usan el lenguaje gherkin

# Fixtures
```
./yii fixture/generate-all --count=2
ls tests/fixtures/unit
./yii fixture/load "*"
```

# Run
```
torres devel test
```

[//]: # (>>>>>TESTS)
[//]: # (<<<<<USUARIAS)
# Usuarias
```
./yii user/create software@noviolento.es admin my_secret
```

[//]: # (>>>>>USUARIAS)
# Import places to your application
```
ATTACH DATABASE 'vendor/santilin/yii2-world-repos/runtime/wrepos.db' AS wrepos;
insert into territorios SELECT null, coalesce(admin_code,''), name_es, level, null, null, null, null from repos.places where level<=4;
```

wrepos/places/import-places app\\models\\Territorio nombre:name,nuts_code:nuts_code,nivel:level level<6

wrepos/places/import-places app\\models\\Territorio nombre:name,nuts_code:nuts_code,nivel:level
