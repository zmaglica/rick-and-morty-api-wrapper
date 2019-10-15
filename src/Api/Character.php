<?php

namespace Zmaglica\RickAndMortyApiWrapper\Api;

use GuzzleHttp\Client;
use Zmaglica\RickAndMortyApiWrapper\Model\Character as CharacterModel;

class Character extends AbstractApi
{
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->uri = 'character';
        $this->arguments = [];
        $this->supportedFilters = [
            'name',
            'status',
            'species',
            'type',
            'gender',
        ];
        $this->model = CharacterModel::class;
    }

    /**
     * Get origin of characters
     *
     * @param mixed $id
     * @return mixed
     */
    public function getOrigin($id = null)
    {
        $origin = $this->get($id);

        return $origin->hasErrors() ? $origin : $origin->getOrigins();
    }

    /**
     * Get location of characters
     *
     * @param mixed $id
     * @return mixed
     */
    public function getLocation($id = null)
    {
        $locations = $this->get($id);

        return $locations->hasErrors() ? $locations : $locations->getLocations();
    }

    /**
     * Query to filter dead characters
     *
     * @return $this
     */
    public function isDead()
    {
        $this->where(['status' => 'dead']);

        return $this;
    }

    /**
     * Query to filter alive characters
     *
     * @return $this
     */
    public function isAlive()
    {
        $this->where(['status' => 'alive']);

        return $this;
    }

    /**
     * Query to filter characters with unknown status
     *
     * @return $this
     */
    public function isStatusUnknown()
    {
        $this->where(['status' => 'unknown']);

        return $this;
    }

    /**
     * Query to filter female characters
     *
     * @return $this
     */
    public function isFemale()
    {
        $this->where(['gender' => 'female']);

        return $this;
    }

    /**
     * Query to filter male characters
     *
     * @return $this
     */
    public function isMale()
    {
        $this->where(['gender' => 'male']);

        return $this;
    }

    /**
     * Query to filter genderless characters
     *
     * @return $this
     */
    public function isGenderless()
    {
        $this->where(['gender' => 'genderless']);

        return $this;
    }

    /**
     * Query to filter characters with unknown gender
     *
     * @return $this
     */
    public function isGenderUnknown()
    {
        $this->where(['gender' => 'unknown']);

        return $this;
    }
}
