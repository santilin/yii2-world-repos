/*<<<<<CLASS*/
namespace app\helpers;

class Espanol
{
/*>>>>>CLASS*/
/*<<<<<BODY*/
    public static function utf8_to_ascii(string $str): string
    {
        // Intenta transliterar (á -> a, ñ -> n, € -> EUR, etc.)
        $ascii = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $str);

        // Si iconv falla, devuelve la original
        if ($ascii === false) {
            return $str;
        }

        return $ascii;
    }
/*>>>>>BODY*/
/*<<<<<END*/
} // class Espanol
/*>>>>>END*/
