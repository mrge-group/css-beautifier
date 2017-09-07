<?php

use PHPUnit\Framework\TestCase;
use Shopping24\CSSBeautifier\CSSBeautifier;

final class CSSBeautifierTest extends TestCase
{
    /**
     * @test
     */
    public function testThatTagsCanBeBeautified()
    {
        $ugly = "h1{font-size:99px;}";
        self::assertEquals("h1 {\n    font-size: 99px;\n}", CSSBeautifier::run($ugly));
    }

    /**
     * @test
     */
    public function testThatMoreThanOneTagCanBeBeautified()
    {
        $ugly = "h1{font-size:99px;}h2{color:#123123;}";
        self::assertEquals("h1 {\n    font-size: 99px;\n}\nh2 {\n    color: #123123;\n}", CSSBeautifier::run($ugly));
    }

    /**
     * @test
     */
    public function testWithMoreThanOneFunctionCalls()
    {
        $ugly = "h1{font-size:99px;}";
        self::assertEquals("h1 {\n    font-size: 99px;\n}", CSSBeautifier::run(CSSBeautifier::run($ugly)));
    }

    /**
     * @test
     */
    public function testThatAttributesWithoutSemicolonsCanBeFixed()
    {
        $ugly = "h1{font-size:99px}";
        self::assertEquals("h1 {\n    font-size: 99px;\n}", CSSBeautifier::run($ugly));
    }

    /**
     * @test
     */
    public function testComplex()
    {
        $ugly = file_get_contents('tests/files/ugly.css');
        self::assertEquals(file_get_contents('tests/files/beauty.css'), CSSBeautifier::run($ugly, false));
    }

    /**
     * @test
     */
    public function testThreeIntendCase()
    {
        $ugly = '@asd{@media{h1{color:blue;}}}';
        var_dump(CSSBeautifier::run($ugly, false));
        self::assertEquals("@asd {\n    @media {\n        h1 {\n            color: blue;\n        }\n    }\n}", CSSBeautifier::run($ugly, false));
    }
}