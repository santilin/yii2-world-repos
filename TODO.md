SELECT DISTINCT c1.NOMBRE ||':'||c2.NOMBRE
FROM entidades_es c1
JOIN entidades_es c2 ON
c1.CODIGOINE LIKE '2%' AND c2.CODIGOINE LIKE '2%' AND
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
WHERE c1.NOMBRE <> c2.NOMBRE;



# 01
Lagrán:Lagran
El Tossalet:el Tossalet
Molíns:Molins
Pilar de Jaravía:Pilar de Jaravia
Rincón del Marques:Rincón del Marques
Rambla del Marqués:Rambla del Marques
Macián:Macian
San Cristóbal de Trabancos: San Cristobal de Trabancos
Santa Lucía de la Sierra:Santa Lucia de la Sierra
Serranía:Serrania
La Rectoria:la Rectoria
Les Pinedes de l'Armengol:les Pinedes de l'Armengol
La Virreina:la Virreina
El Serrat de Castellnou:el Serrat de Castellnou
Els Masets:els Masets
L'Amunt:l'Amunt
Mas d'En Puig:Mas d'en Puig
Santa Maria de L'Avall:Santa Maria de l'Avall
La Mare de Déu del Bosc:La Mare de Deu del Bosc
Les Cases Noves:les Cases Noves
L'Estació:l'Estació
Sant Genís:Sant Genis
El Pla:el Pla
La Beguda Alta:la Beguda Alta
La Rectoria:la Rectoria
El Mas Reixac:el Mas Reixac
Palau-Solità i Plegamans:Palau-solità i Plegamans
El Poblenou:el Poblenou
Els Masets:els Masets
La Rectoria:la Rectoria
El Serrat de Castellnou:el Serrat de Castellnou
Can Bargalló:Can Bargallo
Sant Martí de Torroella:Sant Marti de Torroella
Can Bargalló:Can Bargallo
Barri Colomer:Barrí Colomer
El Mas Reixac:el Mas Reixac
Santa María Ananúñez:Santa Maria Ananuñez
Pinilla de los Moros:Pinilla de Los Moros
Valrío:Valrio
Salto de Torrejón:Salto de Torrejon
Masía de la Tejería:Masía de la Tejeria
Masía de la Tejería:Masia de la Tejería
Els Vilars:els Vilars
El Pla:el Pla
Consolación:Consolacion
Navalrincón:Navalrincon
María Aparicio:Maria Aparicio
Mina de la Concepción:Mina de la Concepcion
Os Currás:Os Curras
Os Campós:Os Campos
A Gándara:A Gandara
Trión:Trion
Lubián:Lubian
Carballás:Carballas
Castaño de Eirís:Castaño de Eiris
Lubián:Lubian
A Forxá:A Forxa
Candaíl:Candail
Rúa de Francos:Rua de Francos
Carnés:Carnes
Baió:Baio
El Far d'Empordà:El Far d'empordà
La Jonquera:la Jonquera
La Bisbal d'Empordà:La Bisbal d'empordà
El Mas Serra:el Mas Serra
Els Masos:els Masos
El Mas Serra:el Mas Serra
Molí de Ger:Moli de Ger
El Pla de Baix:el Pla de Baix
El Molí:El Moli
Mont-Ras:Mont-ras
La Móra:La Mora
El Veïnat de Dalt:el Veïnat de Dalt
El Saúco:El Sauco
Montecalderón:Montecalderon
Instituto Leprológico:Instituto Leprologico
