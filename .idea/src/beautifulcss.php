<?php

namespace phil404\beautifulcss;


class beautifulcss
{

    public static function makeCssBeautifulAgain($string){
        $tap = "    ";

        $beautifulCssWithoutTaps = preg_replace("(})", "\n$0", preg_replace("([{;}])", "$0\n", $string));

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

}