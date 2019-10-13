<?php

namespace Zmaglica\RickAndMortyApiWrapper\Tests;

use GuzzleHttp\Client;
use Zmaglica\RickAndMortyApiWrapper\Api\Character;
use Zmaglica\RickAndMortyApiWrapper\Api\Episode;
use Zmaglica\RickAndMortyApiWrapper\Api\Location;
use Zmaglica\RickAndMortyApiWrapper\RickAndMortyApiWrapper;

use PHPUnit\Framework\TestCase;

class RickAndMortyApiWrapperTest extends TestCase
{
    /**
     * @var RickAndMortyApiWrapper
     */
    protected $apiInstance;

    protected function setUp()
    {
        $this->apiInstance = new RickAndMortyApiWrapper();
    }

    public function testGetOptionsFunctionExist()
    {
        $this->assertTrue(method_exists($this->apiInstance, 'getOptions'));
    }

    public function testIsApiEndpointSet()
    {
        $this->assertArrayHasKey('base_uri', $this->apiInstance->getOptions());
    }

    public function testIsCorrectApiEndpointSet()
    {
        $options = $this->apiInstance->getOptions();
        $this->assertEquals('https://rickandmortyapi.com/api/', $options['base_uri']);
    }

    public function testGetClientMethodExists()
    {
        $this->assertTrue(method_exists($this->apiInstance, 'getClient'));
    }

    public function testIsHttpClientInstanceOfGuzzleHttp()
    {
        $this->assertInstanceOf(Client::class, $this->apiInstance->getClient());
    }

    public function testSetClientMethodExist()
    {
        $this->assertTrue(method_exists($this->apiInstance, 'setClient'));
    }
    public function testSetClient()
    {
        $this->apiInstance->setClient(new Client());

        return $this->testIsHttpClientInstanceOfGuzzleHttp();
    }

    public function testCharacterFunctionExist()
    {
        $this->assertTrue(method_exists($this->apiInstance, 'character'));
    }

    public function testCharacterMethodInstance()
    {
        $this->assertInstanceOf(Character::class, $this->apiInstance->character());
    }

    public function testLocationFunctionExist()
    {
        $this->assertTrue(method_exists($this->apiInstance, 'location'));
    }

    public function testLocationMethodInstance()
    {
        $this->assertInstanceOf(Location::class, $this->apiInstance->location());
    }

    public function testEpisodeFunctionExist()
    {
        $this->assertTrue(method_exists($this->apiInstance, 'episode'));
    }

    public function testEpisodeMethodInstance()
    {
        $this->assertInstanceOf(Episode::class, $this->apiInstance->episode());
    }
}
