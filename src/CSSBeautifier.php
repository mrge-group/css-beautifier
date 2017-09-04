<?php

namespace Shopping24\CSSBeautifier;

class CSSBeautifier
{
    const TAP = "    ";

    private static $repair = false;

    public static function run($string, bool $repair = true)
    {
        $start = microtime(true);
        self::$repair = $repair;
        $taps = 0;

        $beautifiedArray = [];

        foreach (self::stringToArray($string) as $key => $line) {
            $line = trim($line);

            switch (true) {
                case preg_match('/(@supports)/', $line):
                case preg_match('/(@media)/', $line):
                    $line = self::checkHealthyWhiteSpaces(self::createTaps($line, $taps));
                    $taps++;
                    break;
                case preg_match('/{/', $line):
                    $line = self::checkHealthyWhiteSpaces(self::createTaps($line, $taps), false);
                    $taps++;
                    break;
                case preg_match('/}/', $line):
                    $taps--;
                    $line = self::createTaps($line, $taps);
                    break;
                default:
                    $line = self::checkHealthyWhiteSpaces(self::createTaps($line, $taps));
            }

            $beautifiedArray[$key] = self::$repair ? self::checkHealthyAttribute($line) : $line;
        }

        $s = self::arrayToString($beautifiedArray);

        var_dump((microtime(true) - $start) * 1000);
        return $s;
    }


    /**
     * This function will add "new Lines" after every "{;}".
     *
     * @param String $string
     *
     * @return String
     */
    private static function newLines($string)
    {
        return preg_replace("/}/", "\n$0", preg_replace("/[{;}]/", "$0\n", $string));
    }

    /**
     * This function will convert a string to an array.
     * Each line will be an item in the array.
     *
     * @param String $string
     *
     * @return array
     */
    private static function stringToArray($string)
    {
        return explode(PHP_EOL, self::newLines($string));
    }

    /**
     * This function convert an array to a string.
     * Each item in the array is a new line in the string.
     *
     * @param array $array
     *
     * @return string
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

    /**
     * This function will check the ';' in the end of a line and will add one if needed.
     *
     * @param string $string
     *
     * @return string
     */
    private static function checkHealthyAttribute(string $string)
    {
        if (preg_match("/[{;}]/", $string) == false && preg_match("/:/", $string) == true) {
            $string .= ";";
        }
        return $string;
    }

    /**
     * This function will check the line for a healthy structure.
     *
     * @param string $string
     * @param bool $checkDoublePoints
     *
     * @return string
     */
    private static function checkHealthyWhiteSpaces(string $string, bool $checkDoublePoints = true)
    {
        if (preg_match('/:/', $string) && !preg_match('/: /', $string) && $checkDoublePoints) {
            $string = preg_replace('/:/', ': ', $string, 1);
            if (preg_match('/(url\()/', $string)) {
                preg_match('~(url\()(.*?)\)~', $string, $result);
                $string = str_replace($result[0], preg_replace('/ /', '', $result[0]), $string);
            }
        }
        if (!preg_match('/ {/', $string)) {
            $string = preg_replace('/{/', ' {', $string);
        }
        return $string;
    }

    /**
     * This function will create the needed taps.
     *
     * @param string $string
     * @param int $taps
     *
     * @return string
     */
    private static function createTaps(string $string, int $taps)
    {
        $string = str_replace(',', ', ', $string);
        for ($i = 0; $i < $taps; $i++) {
            $string = self::TAP . $string;
        }
        return $string;
    }
}
