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
        self::assertEquals("h1{\n    font-size:99px;\n}", CSSBeautifier::run($ugly));
    }

    /**
     * @test
     */
    public function testThatMoreThanOneTagCanBeBeautify()
    {
        $ugly = "h1{font-size:99px;}h2{color:#123123;}";
        self::assertEquals("h1{\n    font-size:99px;\n}\nh2{\n    color:#123123;\n}", CSSBeautifier::run($ugly));
    }

    /**
     * @test
     */
    public function testWithMoreThanOneFunctionCalls()
    {
        $ugly = "h1{font-size:99px;}";
        self::assertEquals("h1{\n    font-size:99px;\n}", CSSBeautifier::run(CSSBeautifier::run($ugly)));
    }

    /**
     * @test
     */
    public function testThatAttributesWithoutSemicolonsCanBeFixed()
    {
        $ugly = "h1{font-size:99px}";
        self::assertEquals("h1{\n    font-size:99px;\n}", CSSBeautifier::run($ugly));
    }
}