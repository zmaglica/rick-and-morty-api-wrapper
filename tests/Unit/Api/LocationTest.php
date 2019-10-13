<?php

namespace Zmaglica\RickAndMortyApiWrapper\Tests\Unit\Api;

use PHPUnit\Framework\TestCase;
use Zmaglica\RickAndMortyApiWrapper\Api\Character;
use Zmaglica\RickAndMortyApiWrapper\RickAndMortyApiWrapper;

class LocationTest extends TestCase
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

        $this->locationApi = $this->apiInstance->location();
    }

    protected function tearDown()
    {
        $this->locationApi->clear();
    }

    public function testGetResidentsFunctionExist()
    {
        $this->assertTrue(method_exists($this->locationApi, 'getResidents'));
    }

    public function testNameFilterFunction()
    {
        $arguments = $this->locationApi->whereName('Earth')->getArguments();
        $this->assertEquals('Earth', $arguments['query']['name']);
    }

    public function testTypeFilterFunction()
    {
        $arguments = $this->locationApi->whereType('Planet')->getArguments();
        $this->assertEquals('Planet', $arguments['query']['type']);
    }

    public function testDimensionFilterFunction()
    {
        $arguments = $this->locationApi->whereDimension('Dimension C-137')->getArguments();
        $this->assertEquals('Dimension C-137', $arguments['query']['dimension']);
    }
}
