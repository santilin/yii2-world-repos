SELECT DISTINCT c1.NOMBRE ||':'||c2.NOMBRE
FROM entidades_es c1
JOIN entidades_es c2 ON
substring(c1.CODIGOINE,1,9)  = substring(c2.CODIGOINE,1,9) and
REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
    LOWER(c1.NOMBRE),
    'ï', 'i'),
    'ü', 'u'),
    'á', 'a'),
    'é', 'e'),
    'í', 'i'),
    'ó', 'o'),
    'ú', 'u'),
    'Á', 'A'),
    'É', 'E'),
    'Í', 'I'),
    'Ó', 'O'),
    'Ú', 'U') =
  REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
    LOWER(c2.NOMBRE),
    'ï', 'i'),
    'ü', 'u'),
    'á', 'a'),
    'é', 'e'),
    'í', 'i'),
    'ó', 'o'),
    'ú', 'u'),
    'Á', 'A'),
    'É', 'E'),
    'Í', 'I'),
    'Ó', 'O'),
    'Ú', 'U')
WHERE c1.NOMBRE <> c2.NOMBRE ORDER BY 1;


AS Pedras:As Pedras
Alqueria:Alquería
Alquería:Alqueria
Altritar:Altrítar
Altrítar:Altritar
As Pedras:AS Pedras
Balmeon:Balmeón
Balmeón:Balmeon
Barranco del Talayon:Barranco del Talayón
Barranco del Talayón:Barranco del Talayon
Barrio de la Concepcion:Barrio de la Concepción
Barrio de la Concepción:Barrio de la Concepcion
Base Aerea:Base Aérea
Base Aérea:Base Aerea
Belmez:Bélmez
Boedo de Castrejon:Boedo de Castrejón
Boedo de Castrejón:Boedo de Castrejon
Busfrio:Busfrío
Busfrío:Busfrio
Bélmez:Belmez
Cabarceno:Cabárceno
Cabárceno:Cabarceno
Carretera de Chinchon:Carretera de Chinchón
Carretera de Chinchón:Carretera de Chinchon
Casa de los Garcia:Casa de los García
Casa de los García:Casa de los Garcia
Casas de Cementerio de Nuestro Padre Jesus:Casas de Cementer
Casas de Cementerio de Nuestro Padre Jesús:Casas de Cementer
Casillas de las Erias:Casillas de las Erías
Casillas de las Erías:Casillas de las Erias
Castaño de Eiris:Castaño de Eirís
Castaño de Eirís:Castaño de Eiris
Castrejon:Castrejón
Castrejón:Castrejon
Consolacion:Consolación
Consolación:Consolacion
Corbera D'ebre:Corbera d'Ebre
Corbera d'Ebre:Corbera D'ebre
Cortijo del Marques:Cortijo del Marqués
Cortijo del Marqués:Cortijo del Marques
Cuarto de Sanchez Arjona:Cuarto de Sánchez Arjona
Cuarto de Sánchez Arjona:Cuarto de Sanchez Arjona
Dehesa de Hernan Vicente:Dehesa de Hernán Vicente
Dehesa de Hernán Vicente:Dehesa de Hernan Vicente
El Cabron:El Cabrón
El Cabrón:El Cabron
El Campeton:El Campetón
El Campetón:El Campeton
El Cerrajon:El Cerrajón
El Cerrajón:El Cerrajon
El Encin y la Canaleja:El Encín y la Canaleja
El Encín y la Canaleja:El Encin y la Canaleja
El Far D'empordà:El Far d'Empordà
El Far D'empordà:El Far d'empordà
El Far d'Empordà:El Far D'empordà
El Far d'Empordà:El Far d'empordà
El Far d'empordà:El Far D'empordà
El Far d'empordà:El Far d'Empordà
El Groo:El Gróo
El Gróo:El Groo
El Pingarron:El Pingarrón
El Pingarrón:El Pingarron
El Principe:El Príncipe
El Príncipe:El Principe
El Sauco:El Saúco
El Saúco:El Sauco
Els Manous:els Manous
Els Masos de Tamurcia:Els Masos de Tamúrcia
Els Masos de Tamúrcia:Els Masos de Tamurcia
Fresneu:Fresnéu
Fresnéu:Fresneu
Gillue:Gillué
Gillué:Gillue
Grau I Platja:Grau i Platja
Grau i Platja:Grau I Platja
Instituto Leprologico:Instituto Leprológico
Instituto Leprológico:Instituto Leprologico
Jemingomez:Jemingómez
Jemingómez:Jemingomez
LA Mercoria:La Mercoria
La Bisbal d'Empordà:La Bisbal d'empordà
La Bisbal d'empordà:La Bisbal d'Empordà
La Joncosa del Montmell:la Joncosa del Montmell
La Jurisdiccion:La Jurisdicción
La Jurisdicción:La Jurisdiccion
La Mare de Deu del Bosc:La Mare de Déu del Bosc
La Mare de Déu del Bosc:La Mare de Deu del Bosc
La Mercoria:LA Mercoria
La Partija-Santa Monica:La Partija-Santa Mónica
La Partija-Santa Mónica:La Partija-Santa Monica
La Torre de l'Espanyol:la Torre de l'Espanyol
La Vega de Santa Maria:La Vega de Santa María
La Vega de Santa María:La Vega de Santa Maria
Llamargon:Llamargón
Llamargón:Llamargon
Macian:Macián
Macián:Macian
Maraon:Maraón
Maraón:Maraon
Maria Aparicio:María Aparicio
Martin Vicente:Martín Vicente
Martín Vicente:Martin Vicente
María Aparicio:Maria Aparicio
Masia de la Tejería:Masía de la Tejeria
Masía de la Tejeria:Masia de la Tejería
Mina de la Concepcion:Mina de la Concepción
Mina de la Concepción:Mina de la Concepcion
Moli de Ger:Molí de Ger
Molins:Molíns
Molí de Ger:Moli de Ger
Molíns:Molins
Mont-Ras:Mont-ras
Mont-ras:Mont-Ras
Montecalderon:Montecalderón
Montecalderón:Montecalderon
Moron I Mola:Moron i Mola
Moron i Mola:Moron I Mola
Muñon:Muñón
Muñón:Muñon
Navalrincon:Navalrincón
Navalrincón:Navalrincon
O Muiñovedro:O Muíñovedro
O Muíñovedro:O Muiñovedro
Os Curras:Os Currás
Os Currás:Os Curras
Palau-Solità i Plegamans:Palau-solità i Plegamans
Palau-solità i Plegamans:Palau-Solità i Plegamans
Pilar de Jaravia:Pilar de Jaravía
Pilar de Jaravía:Pilar de Jaravia
Pinilla de Los Moros:Pinilla de los Moros
Pinilla de los Moros:Pinilla de Los Moros
Prado del Rincon:Prado del Rincón
Prado del Rincón:Prado del Rincon
Pueblica de Campean:Pueblica de Campeán
Pueblica de Campeán:Pueblica de Campean
Puentes del Alagon:Puentes del Alagón
Puentes del Alagón:Puentes del Alagon
Puerto de la Anunciacion:Puerto de la Anunciación
Puerto de la Anunciación:Puerto de la Anunciacion
Rambla del Marques:Rambla del Marqués
Rambla del Marqués:Rambla del Marques
Riba-Roja d'Ebre:Riba-roja d'Ebre
Riba-roja d'Ebre:Riba-Roja d'Ebre
Rincón del Marques:Rincón del Marqués
Rincón del Marqués:Rincón del Marques
Roman:Román
Román:Roman
Salto de Torrejon:Salto de Torrejón
Salto de Torrejón:Salto de Torrejon
San Andres:San Andrés
San Andrés:San Andres
San Bartolome:San Bartolomé
San Bartolomé:San Bartolome
San Cristobal de Monte Agudo:San Cristóbal de Monte Agudo
San Cristobal de Trabancos:San Cristóbal de Trabancos
San Cristóbal de La Laguna:San Cristóbal de la Laguna
San Cristóbal de Monte Agudo:San Cristobal de Monte Agudo
San Cristóbal de Trabancos:San Cristobal de Trabancos
San Cristóbal de la Laguna:San Cristóbal de La Laguna
San Roman el Antiguo:San Román el Antiguo
San Román el Antiguo:San Roman el Antiguo
Sant Marti de Torroella:Sant Martí de Torroella
Sant Martí de Torroella:Sant Marti de Torroella
Santa Lucia de la Sierra:Santa Lucía de la Sierra
Santa Lucía de la Sierra:Santa Lucia de la Sierra
Santa Maria Ananuñez:Santa María Ananúñez
Santa Maria de Buil:Santa María de Buil
Santa María Ananúñez:Santa Maria Ananuñez
Santa María de Buil:Santa Maria de Buil
Santa María de Guia:Santa María de Guía
Santa María de Guía:Santa María de Guia
Santibañez del Cañedo:Santibáñez del Cañedo
Santibáñez del Cañedo:Santibañez del Cañedo
Sebulcor:Sebúlcor
Sebúlcor:Sebulcor
Serrania:Serranía
Serranía:Serrania
Sierra del Almiceran:Sierra del Almicerán
Sierra del Almicerán:Sierra del Almiceran
Torre-Serona:Torre-serona
Torre-serona:Torre-Serona
Torrecilla Sobre Alesanco:Torrecilla sobre Alesanco
Torrecilla sobre Alesanco:Torrecilla Sobre Alesanco
Truyes:Truyés
Truyés:Truyes
Umbria:Umbría
Umbría:Umbria
Vila-Rodona:Vila-rodona
Vila-Seca:Vila-seca
Vila-rodona:Vila-Rodona
Vila-seca:Vila-Seca
Zona de los Principes:Zona de los Príncipes
Zona de los Príncipes:Zona de los Principes
els Manous:Els Manous
io de Nuestro Padre Jesus
io de Nuestro Padre Jesús
la Joncosa del Montmell:La Joncosa del Montmell
la Torre de l'Espanyol:La Torre de l'Espanyol
