SELECT DISTINCT c1.NOMBRE ||':'||c2.NOMBRE
FROM entidades_es c1
JOIN entidades_es c2 ON
c1.CODIGOINE LIKE '4%' AND c2.CODIGOINE LIKE '4%' AND
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


A Amarelá:A Amarela
A Baiúca:A Baiuca
A Campá:A Campa
A Forxá:A Forxa
A Gándara:A Gandara
A Martiñá:A Martiña
A Mó:A Mo
A Quintá:A Quinta
As Pedras:AS Pedras
Alquería:Alqueria
Altrítar:Altritar
Ambás:Ambas
Andía:Andia
Anzó:Anzo
Areás:Areas
Armentía:Armentia
Arrés:Arres
Arró:Arro
As Pedras:AS Pedras
As Quintás:As Quintas
Augüera:Auguera
Baió:Baio
Balmeón:Balmeon
Barranco del Talayón:Barranco del Talayon
Barri Colomer:Barrí Colomer
Barrio de la Concepción:Barrio de la Concepcion
Base Aérea:Base Aerea
Boedo de Castrejón:Boedo de Castrejon
Bouzoá:Bouzoa
Busfrío:Busfrio
Bustió:Bustio
Béjar:Bejar
Bélmez:Belmez
Cabárceno:Cabarceno
Cabó:Cabo
Cadós:Cados
Camporrélls:Camporrells
Can Bargalló:Can Bargallo
Can Lluís:Can Lluis
Candaíl:Candail
Carballás:Carballas
Carbayín:Carbayin
Carnés:Carnes
Carretera de Chinchón:Carretera de Chinchon
Carrió:Carrio
Casa de los García:Casa de los Garcia
Casas de Cementerio de Nuestro Padre Jesús:Casas de Cementerio de Nuestro Padre Jesus
Casasoá:Casasoa
Casillas de las Erías:Casillas de las Erias
Castaño de Eirís:Castaño de Eiris
Castrejón:Castrejon
Celeiró:Celeiro
Celeirós:Celeiros
Consolación:Consolacion
Corbera d'Ebre:Corbera D'ebre
Cortijo del Marqués:Cortijo del Marques
Cortés:Cortes
Corzós:Corzos
Corés:Cores
Covás:Covas
Cuarto de Sánchez Arjona:Cuarto de Sanchez Arjona
Cuíña:Cuiña
Dehesa de Hernán Vicente:Dehesa de Hernan Vicente
Eirós:Eiros
El Cabañín:El Cabañin
El Cabrón:El Cabron
El Campetón:El Campeton
El Cerrajón:El Cerrajon
El Charcón:El Charcon
El Encín y la Canaleja:El Encin y la Canaleja
El Far d'Empordà:El Far D'empordà
El Far d'Empordà:El Far d'empordà
El Gróo:El Groo
El Mas Reixac:el Mas Reixac
El Mas Serra:el Mas Serra
El Molí:El Moli
El Palomar:el Palomar
El Perelló:el Perelló
El Pingarrón:El Pingarron
El Pla de Baix:el Pla de Baix
El Pla:el Pla
El Poblenou:el Poblenou
El Saúco:El Sauco
El Serrat de Castellnou:el Serrat de Castellnou
El Tossalet:el Tossalet
El Veïnat de Dalt:el Veïnat de Dalt
Els Manous:els Manous
Els Masets:els Masets
Els Masos de Tamúrcia:Els Masos de Tamurcia
Els Masos:els Masos
Els Vilars:els Vilars
Erías:Erias
Ferreirós:Ferreiros
Fresnéu:Fresneu
Gillué:Gillue
Goía:Goia
Grau i Platja:Grau I Platja
Gúa:Gua
H.Ontoria:H.ontoria
Hoya de Aríñez:Hoya de Ariñez
I.N.T.A.:I.n.t.a.
Instituto Leprológico:Instituto Leprologico
Jemingómez:Jemingomez
L'Amunt:l'Amunt
L'Estació:L'Estació
L'Estany:l'Estany
L'Horta:l'Horta
L.Lúmés:L.Lumés
L.Lúmés:L.lumés
La Mercoria:LA Mercoria
La Beguda Alta:la Beguda Alta
La Bisbal d'Empordà:La Bisbal d'empordà
La Forcá:La Forca
La Güería:La Güeria
La Joncosa del Montmell:la Joncosa del Montmell
La Jonquera:la Jonquera
La Jurisdicción:La Jurisdiccion
La Maerá:La Maera
La Mallá:La Malla
La Mare de Déu del Bosc:La Mare de Deu del Bosc
La Mercoria:LA Mercoria
La Móra:La Mora
La Partija-Santa Mónica:La Partija-Santa Monica
La Quemá:La Quema
La Rectoria:la Rectoria
La Rozá:La Roza
La Torre de l'Espanyol:la Torre de l'Espanyol
La Vall:la Vall
La Vega de Santa María:La Vega de Santa Maria
La Virreina:la Virreina
Lagrán:Lagran
Larráun:Larraun
Les Cases Noves:les Cases Noves
Les Pinedes de l'Armengol:les Pinedes de l'Armengol
Llamargón:Llamargon
Lougarés:Lougares
Lubián:Lubian
Lusío:Lusio
Macián:Macian
Maraón:Maraon
Martín Vicente:Martin Vicente
María Aparicio:Maria Aparicio
Mas d'En Puig:Mas d'en Puig
Masía de la Tejería:Masia de la Tejeria
Mina de la Concepción:Mina de la Concepcion
Moás:Moas
Molí de Ger:Moli de Ger
Molíns:Molins
Mont-Ras:Mont-ras
Montecalderón:Montecalderon
Monterréi:Monterrei
Moron i Mola:Moron I Mola
Mosteiró:Mosteiro
Muñón:Muñon
Navalrincón:Navalrincon
O Muíñovedro:O Muiñovedro
O Terrón:O Terron
Orderías:Orderias
Os Bouzós:Os Bouzos
Os Campós:Os Campos
Os Currás:Os Curras
Palaciós:Palacios
Palau-Solità i Plegamans:Palau-solità i Plegamans
Pardiñás:Pardiñas
Pazó:Pazo
Pexeirós:Pexeiros
Pilar de Jaravía:Pilar de Jaravia
Pinilla de los Moros:Pinilla de Los Moros
Pinós:Pinos
Piñeirós:Piñeiros
Prado del Rincón:Prado del Rincon
Pueblica de Campeán:Pueblica de Campean
Puentes del Alagón:Puentes del Alagon
Puerto de la Anunciación:Puerto de la Anunciacion
Quintá:Quinta
Quintás:Quintas
Rambla del Marqués:Rambla del Marques
Ramirás:Ramiras
Riba-Roja d'Ebre:Riba-roja d'Ebre
Ribás:Ribas
Rincón del Marqués:Rincón del Marques
Román:Roman
Rozá:Roza
Rúa de Francos:Rua de Francos
Salgueirós:Salgueiros
Salto de Torrejón:Salto de Torrejon
San Agustín:San Agustin
San Andrés:San Andres
San Antolín:San Antolin
San Antón:San Anton
San Bartolomé:San Bartolome
San Cristóbal de la Laguna:San Cristóbal de La Laguna
San Cristóbal de Monte Agudo:San Cristobal de Monte Agudo
San Cristóbal de Trabancos:San Cristobal de Trabancos
San Cristóbal de la Laguna:San Cristobal de La Laguna
San Cristóbal:San Cristobal
San Luís:San Luis
San Martín:San Martin
San Nicolás:San Nicolas
San Román el Antiguo:San Roman el Antiguo
San Román:San Roman
Sant Genís:Sant Genis
Sant Martí de Torroella:Sant Marti de Torroella
Santa Cecília:Santa Cecilia
Santa Lucía de la Sierra:Santa Lucia de la Sierra
Santa Lucía:Santa Lucia
Santa Maria de l'Avall:Santa Maria de L'Avall
Santa María Ananúñez:Santa Maria Ananuñez
Santa María de Buil:Santa Maria de Buil
Santa María de Guía:Santa María de Guia
Santa María del Camí:Santa Maria del Camí
Santa María:Santa Maria
Santibáñez del Cañedo:Santibañez del Cañedo
Sebúlcor:Sebulcor
Sequeiró:Sequeiro
Sequeirós:Sequeiros
Serranía:Serrania
Sierra del Almicerán:Sierra del Almiceran
Tabláu:Tablau
Torre-Serona:Torre-serona
Torrecilla sobre Alesanco:Torrecilla Sobre Alesanco
Trión:Trion
Truyés:Truyes
Umbría:Umbria
Urría:Urria
Valrío:Valrio
Veinat de l'Estacio:Veïnat de l'Estació
Vila-Rodona:Vila-rodona
Vila-Seca:Vila-seca
Vilarés:Vilares
Villagarcía:Villagarcia
Viñás:Viñas
Zona de los Príncipes:Zona de los Principes
El Mas Serra:el Mas Serra
El Palomar:el Palomar
El Perelló:el Perelló
El Pla de Baix:el Pla de Baix
El Veïnat de Dalt:el Veïnat de Dalt
Els Manous:els Manous
Els Masos:els Masos
L'Estany:l'Estany
La Joncosa del Montmell:la Joncosa del Montmell
La Torre de l'Espanyol:la Torre de l'Espanyol
