<?php

namespace Zmaglica\RickAndMortyApiWrapper\Tests\Unit\Api;

use PHPUnit\Framework\TestCase;
use Zmaglica\RickAndMortyApiWrapper\Api\Character;
use Zmaglica\RickAndMortyApiWrapper\RickAndMortyApiWrapper;

class CharacterTest extends TestCase
{
    /**
     * @var RickAndMortyApiWrapper
     */
    protected $apiInstance;

    /**
     * @var Character
     */
    protected $characterApi;

    protected function setUp()
    {
        $this->apiInstance = new RickAndMortyApiWrapper();

        $this->characterApi = $this->apiInstance->character();
    }

    protected function tearDown()
    {
        $this->characterApi->clear();
    }

    public function testGetOriginFunctionExist()
    {
        $this->assertTrue(method_exists($this->characterApi, 'getOrigin'));
    }

    public function testGetLocationFunctionExist()
    {
        $this->assertTrue(method_exists($this->characterApi, 'getLocation'));
    }

    public function testIsDeadFunctionExist()
    {
        $this->assertTrue(method_exists($this->characterApi, 'isDead'));
    }

    public function testIsDeadFunction()
    {
        $arguments = $this->characterApi->isDead()->getArguments();
        $this->assertEquals('dead', $arguments['query']['status']);
    }
    public function testIsAliveFunction()
    {
        $arguments = $this->characterApi->isAlive()->getArguments();
        $this->assertEquals('alive', $arguments['query']['status']);
    }
    public function testIsStatusUnknown()
    {
        $arguments = $this->characterApi->isStatusUnknown()->getArguments();
        $this->assertEquals('unknown', $arguments['query']['status']);
    }

    public function testIsFemale()
    {
        $arguments = $this->characterApi->isFemale()->getArguments();
        $this->assertEquals('female', $arguments['query']['gender']);
    }

    public function testIsMale()
    {
        $arguments = $this->characterApi->isMale()->getArguments();
        $this->assertEquals('male', $arguments['query']['gender']);
    }

    public function testIsGenderless()
    {
        $arguments = $this->characterApi->isGenderless()->getArguments();
        $this->assertEquals('genderless', $arguments['query']['gender']);
    }

    public function testIsGenderUnknown()
    {
        $arguments = $this->characterApi->isGenderUnknown()->getArguments();
        $this->assertEquals('unknown', $arguments['query']['gender']);
    }

    public function testNameFilterFunction()
    {
        $arguments = $this->characterApi->whereName('Rick')->getArguments();
        $this->assertEquals('Rick', $arguments['query']['name']);
    }

    public function testStatusFilterFunction()
    {
        $arguments = $this->characterApi->whereStatus('alive')->getArguments();
        $this->assertEquals('alive', $arguments['query']['status']);
    }

    public function testSpeciesFilterFunction()
    {
        $arguments = $this->characterApi->whereSpecies('Human')->getArguments();
        $this->assertEquals('Human', $arguments['query']['species']);
    }

    public function testTypeFilterFunction()
    {
        $arguments = $this->characterApi->whereType('Korblock')->getArguments();
        $this->assertEquals('Korblock', $arguments['query']['type']);
    }

    public function testGenderFilterFunction()
    {
        $arguments = $this->characterApi->whereGender('female')->getArguments();
        $this->assertEquals('female', $arguments['query']['gender']);
    }
}
