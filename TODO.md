- Usar todas las localidades de ES.txt (Geonames)
SELECT c1.NOMBRE AS NOMBRE_with_tilde, c2.NOMBRE AS NOMBRE_without_tilde
FROM entidades_es c1
JOIN entidades_es c2 ON
  c1.CODIGOINE LIKE '30%' AND c2.CODIGOINE LIKE '30%' AND REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
    LOWER(c1.NOMBRE),
    'á', 'a'),
    'é', 'e'),
    'í', 'i'),
    'ó', 'o'),
    'ú', 'u') =
  REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
    LOWER(c2.NOMBRE),
    'á', 'a'),
    'é', 'e'),
    'í', 'i'),
    'ó', 'o'),
    'ú', 'u')
WHERE c1.NOMBRE <> c2.NOMBRE;

