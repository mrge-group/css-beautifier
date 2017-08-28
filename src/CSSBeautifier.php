<?php

namespace Shopping24\CSSBeautifier;

class CSSBeautifier
{
    const TAP = "    ";

    private static $media = false;
    private static $tag = false;
    private static $repair = false;

    public static function run($string, bool $repair = true)
    {
        $start = microtime(true);
        self::$repair = $repair;

        $beautifiedArray = [];

        foreach (self::stringToArray($string) as $key => $line) {
            $line = trim($line);

            switch (true) {
                case preg_match('/@/', $line):
                    $line = preg_replace('/{/', ' {', $line);
                    self::$media = true;
                    break;
                case preg_match('/{/', $line):
                    $line = self::createTaps($line);
                    $line = preg_replace('/{/', ' {', $line);
                    self::$tag = true;
                    break;
                case preg_match('/}/', $line):
                    self::$tag ? self::$tag = false : self::$media = false;
                    $line = self::createTaps($line);
                    break;
                default:
                    $line = self::createTaps($line);
                    $line = preg_replace('/:/', ': ', $line);
            }

            //$line = !preg_match('/@/', $line) ? $line = self::createTaps($line) : $line;
            $beautifiedArray[$key] = self::$repair ? self::checkHealthyAttribute($line) : $line;
        }

        $s = self::arrayToString($beautifiedArray);


        var_dump((microtime(true) - $start) * 1000);
        return $s;
    }


    /*
     * This function will add "new Lines" after every "{;}".
     *
     * @param String    $string
     *
     * @return String
     */
    private static function newLines($string)
    {
        return preg_replace("/}/", "\n$0", preg_replace("/[{;}]/", "$0\n", $string));
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
        return explode(PHP_EOL, self::newLines($string));
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
            if (strlen(preg_replace("/ /", "", $line)) != 0) {
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
        if (preg_match("/[{;}]/", $string) == false && preg_match("/:/", $string) == true) {
            $string .= ";";
        }
        return $string;
    }

    /*
     *
     */
    private static function createTaps(string $string)
    {
        $string = str_replace(',', ', ', $string);
        $string = self::$tag ? self::TAP . $string : $string;
        $string = self::$media ? self::TAP . $string : $string;

        return $string;
    }
}
