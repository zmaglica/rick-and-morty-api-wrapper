<?php

namespace Zmaglica\RickAndMortyApiWrapper\Tests\Unit\Api;

use PHPUnit\Framework\TestCase;
use Zmaglica\RickAndMortyApiWrapper\Api\Character;
use Zmaglica\RickAndMortyApiWrapper\RickAndMortyApiWrapper;

class EpisodeTest extends TestCase
{
    /**
     * @var RickAndMortyApiWrapper
     */
    protected $apiInstance;

    /**
     * @var Character
     */
    protected $locationApi;

    protected function setUp()
    {
        $this->apiInstance = new RickAndMortyApiWrapper();

        $this->locationApi = $this->apiInstance->episode();
    }

    protected function tearDown()
    {
        $this->locationApi->clear();
    }

    public function testGetCharactersFunctionExist()
    {
        $this->assertTrue(method_exists($this->locationApi, 'getCharacters'));
    }

    public function testNameFilterFunction()
    {
        $arguments = $this->locationApi->whereName('Pilot')->getArguments();
        $this->assertEquals('Pilot', $arguments['query']['name']);
    }

    public function testEpisodeFilterFunction()
    {
        $arguments = $this->locationApi->whereEpisode('S01E01')->getArguments();
        $this->assertEquals('S01E01', $arguments['query']['episode']);
    }
}
