<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Shopping24\CSSBeautifier\CSSBeautifier;

final class CSSBeautifierTest extends TestCase
{
    /**
     * This test will check the correct structure of tags.
     *
     * @test
     */
    public function testSimpleTagBeautified()
    {
        self::assertEquals(
            file_get_contents('tests/files/simpleTagBeautified.css'),
            CSSBeautifier::run(file_get_contents('tests/files/simpleTagUglified.css'))
        );
    }

    /**
     * This test will check the correct intend if @media and @supports are in the game.
     *
     * @test
     */
    public function testThreeIntendCase()
    {
        self::assertEquals(
            file_get_contents('tests/files/threeIntendBeautified.css'),
            CSSBeautifier::run(file_get_contents('tests/files/threeIntendUglified.css'))
        );
    }

    /**
     * This test will check the repair of a structure with lost semicolons.
     *
     * @test
     */
    public function testAttributesWithoutSemicolons()
    {
        self::assertEquals(
            file_get_contents('tests/files/attributesWithoutSemicolonBeautified.css'),
            CSSBeautifier::run(file_get_contents('tests/files/attributesWithoutSemicolonUglified.css'))
        );
    }

    /**
     * This test will check that the beautifier don't break a healthy structure.
     *
     * @test
     */
    public function testSimpleTagDoubleBeautified()
    {
        self::assertEquals(
            file_get_contents('tests/files/simpleTagBeautified.css'),
            CSSBeautifier::run(CSSBeautifier::run(file_get_contents('tests/files/simpleTagUglified.css')))
        );
    }

    /**
     * This test will beautify a complex structure.
     *
     * @test
     */
    public function testComplex()
    {
        self::assertEquals(
            file_get_contents('tests/files/complexBeautified.css'),
            CSSBeautifier::run(file_get_contents('tests/files/complexUglified.css'), false)
        );
    }

    /**
     * This test will check that the beautifier don't break a complex healthy structure.
     *
     * @test
     */
    public function testComplexDoubleBeautified()
    {
        self::assertEquals(
            file_get_contents('tests/files/complexBeautified.css'),
            CSSBeautifier::run(CSSBeautifier::run(file_get_contents('tests/files/complexUglified.css'), false), false)
        );
    }
}