<?php

namespace Zmaglica\RickAndMortyApiWrapper\Api;

use GuzzleHttp\Client;
use Zmaglica\RickAndMortyApiWrapper\Model\Episode as EpisodeModel;

class Episode extends AbstractApi
{
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->uri = 'episode';
        $this->arguments = [];
        $this->supportedFilters = [
            'name',
            'episode',
        ];
        $this->model = EpisodeModel::class;
    }

    /**
     * Get residents of location
     * @param null $id
     * @return mixed
     */
    public function getCharacters($id = null)
    {
        return $this->get($id)->getCharacters();
    }
}
