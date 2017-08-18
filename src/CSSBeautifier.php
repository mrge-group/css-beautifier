<?php

namespace Shopping24\CSSBeautifier;


class CSSBeautifier
{

    public static function run($string){
        $tap = "    ";

        $beautifulCssWithoutTaps = self::random($string);

        $beautifulCss = "";

        $tag = false;
        $media = false;
        foreach(explode(PHP_EOL, $beautifulCssWithoutTaps) as $line){

            if(preg_match('({)', $line)){

                if($media === true) $beautifulCss .= $tap;
                if(preg_match('(@)', $line)){

                    $media = true;

                }else{

                    $tag = true;

                }
                $beautifulCss .= $line."\n";

            }elseif(preg_match('(})', $line)){

                if($tag === true){

                    $tag = false;
                    if($media === true){

                        $beautifulCss .= $tap;

                    }

                }else{

                    $media = false;

                }
                $beautifulCss .= $line."\n";

            }else{

                if($media === true) $beautifulCss .= $tap;
                if($tag === true) $beautifulCss .= $tap;
                $beautifulCss .= $line."\n";

            }

        }
        return $beautifulCss;

    }

    private static function random($ugly){
        return preg_replace("(})", "\n$0", preg_replace("([{;}])", "$0\n", $ugly));
    }

}