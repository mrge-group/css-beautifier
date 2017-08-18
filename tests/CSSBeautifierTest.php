<?php

use PHPUnit\Framework\TestCase;
use Shopping24\CSSBeautifier\CSSBeautifier;

final class CSSBeautifierTest extends TestCase
{
    /**
     * @test
     */
    public function testThatTagsCanBeBeautify()
    {
        $ugly = "h1{font-size:99px;}";
        $this->assertEquals("h1{\n    font-size:99px;\n    \n}\n\n", CSSBeautifier::run($ugly));
    }

}