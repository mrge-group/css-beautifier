<?php

namespace Shopping24\CSSBeautifier;

class CSSBeautifier
{
    public static function run($string)
    {
        $tap = "    ";
        $beautifiedArray = [];
        $tag = false;
        $media = false;
        foreach (self::stringToArray($string) as $key => $line) {
            $beautifulCss = "";
            if (preg_match('({)', $line)) {
                if ($media === true){
                    $beautifulCss .= $tap;
                }
                if (preg_match('(@)', $line)) {
                    $media = true;
                } else {
                    $tag = true;
                }
                $beautifulCss .= $line;
            } elseif (preg_match('(})', $line)) {
                if ($tag === true) {
                    $tag = false;
                    if ($media === true) {
                        $beautifulCss .= $tap;
                    }
                } else {
                    $media = false;
                }
                $beautifulCss .= $line;
            } else {
                if ($media === true){
                    $beautifulCss .= $tap;
                }
                if ($tag === true){
                    $beautifulCss .= $tap;
                }
                $beautifulCss .= $line;
            }
            $beautifiedArray[$key] = $beautifulCss;
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
     * @param Array     $array      The array to convert
     *
     * @return String   $string     The converted string
     */
    private static function arrayToString($array)
    {
        $string = "";
        foreach ($array as $key => $line) {
            if (strlen(preg_replace("( )", "", $line)) != 0) {
                if ($key != 0){
                    $string .= "\n";
                }
                $string .= $line;
            }
        }
        return $string;
    }

}
