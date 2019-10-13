<?php

namespace Zmaglica\RickAndMortyApiWrapper;

use GuzzleHttp\Client;
use Zmaglica\RickAndMortyApiWrapper\Api\Character;
use Zmaglica\RickAndMortyApiWrapper\Api\Episode;
use Zmaglica\RickAndMortyApiWrapper\Api\Location;

class RickAndMortyApiWrapper
{
    /**
     * The Guzzle instance used for HTTP requests
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * Guzzle HTTP request options
     * @var array
     */
    private $options = [
        'base_uri' => 'https://rickandmortyapi.com/api/',
    ];

    /**
     * RickAndMortyApiWrapper constructor.
     * @param array $options
     */
    public function __construct($options = [])
    {
        $this->options = array_merge($options, $this->options);
        $this->client = new Client($this->options);
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @param Client $client
     * @return RickAndMortyApiWrapper
     */
    public function setClient(Client $client): RickAndMortyApiWrapper
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Set Guzzle options
     * @param array $options
     * @return RickAndMortyApiWrapper
     */
    public function setOptions(array $options): RickAndMortyApiWrapper
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Wrapper for Character API
     * @return Character
     */
    public function character()
    {
        return new Character($this->client);
    }

    /**
     * Wrapper for Location API
     * @return Location
     */
    public function location()
    {
        return new Location($this->client);
    }

    /**
     * Wrapper for Episode API
     * @return Episode
     */
    public function episode()
    {
        return new Episode($this->client);
    }
}
