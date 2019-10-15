<?php

namespace Zmaglica\RickAndMortyApiWrapper\Api;

use GuzzleHttp\Client;
use Zmaglica\RickAndMortyApiWrapper\Model\Location as LocationModel;

class Location extends AbstractApi
{
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->uri = 'location';
        $this->arguments = [];
        $this->supportedFilters = [
            'name',
            'type',
            'dimension',
        ];
        $this->model = LocationModel::class;
    }

    /**
     * Get residents of location
     * @param null $id
     * @return mixed
     */
    public function getResidents($id = null)
    {
        $locations = $this->get($id);

        return $locations->hasErrors() ? $locations : $locations->getResidents();
    }
}
