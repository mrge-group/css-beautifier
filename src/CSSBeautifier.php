<?php

namespace Shopping24\CSSBeautifier;

class CSSBeautifier
{
    const TAP = "    ";

    public static function run($string)
    {
        $beautifiedArray = [];

        $tag = false;
        $media = false;
        foreach (self::stringToArray($string) as $key => $line) {
            $line = trim($line);
            if (preg_match('({)', $line)) {
                $line = self::createTaps($line, $tag, $media);
                if (preg_match('(@)', $line)) {
                    $media = true;
                } else {
                    $tag = true;
                }
            } elseif (preg_match('(})', $line)) {
                if ($tag === true) {
                    $tag = false;
                } else {
                    $media = false;
                }
                $line = self::createTaps($line, $tag, $media);
            } else {
                $line = self::createTaps($line, $tag, $media);
            }
            $beautifiedArray[$key] = self::checkHealthyAttribute($line);
        }
        return self::arrayToString($beautifiedArray);
    }


    /*
     * This function will add "new Lines" after every "{;}".
     *
     * @param String    $string
     *
     * @return String
     */
    private static function random($string)
    {
        return preg_replace("(})", "\n$0", preg_replace("([{;}])", "$0\n", $string));
    }

    /*
     * This function will convert a string to an array.
     * Each line will be an item in the array.
     *
     * @param String    $string     The string to convert
     *
     * @return Array
     */
    private static function stringToArray($string)
    {
        return explode(PHP_EOL, self::random($string));
    }

    /*
     * This function convert an array to a string.
     * Each item in the array is a new line in the string.
     *
     * @param array $array The array to convert
     *
     * @return string $string The converted string
     */
    private static function arrayToString(array $array)
    {
        $string = "";
        foreach ($array as $key => $line) {
            if (strlen(preg_replace("( )", "", $line)) != 0) {
                if ($key != 0) {
                    $string .= "\n";
                }
                $string .= $line;
            }
        }
        return $string;
    }

    /*
     *
     */
    private static function checkHealthyAttribute(string $string)
    {
        if (preg_match("([{;}])", $string) == false && preg_match("(:)", $string) == true) {
            $string .= ";";
        }
        return $string;
    }

    /*
     *
     */
    private static function createTaps(string $string, bool $tag, bool $media)
    {
        if ($tag == true) {
            $string = self::TAP . $string;
        }
        if ($media == true) {
            $string = self::TAP . $string;
        }
        return $string;
    }
}
