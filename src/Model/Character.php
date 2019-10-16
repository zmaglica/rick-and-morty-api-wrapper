<?php

namespace Zmaglica\RickAndMortyApiWrapper\Model;

use Zmaglica\RickAndMortyApiWrapper\Api\AbstractApi;

class Character extends AbstractModel
{
    /**
     * Get all locations without running API call. Useful if you want to perform additional filtering.
     *
     * @param bool $removeDuplicates
     * @return AbstractApi
     */
    public function locations($removeDuplicates = false) : AbstractApi
    {
        $ids = $this->extractIdsFromResponseBasedOnKey('location', $removeDuplicates);

        return $this->api->location()->whereId($ids);
    }

    /**
     * Get all locations.
     * @param bool $removeDuplicates
     * @return mixed
     */
    public function getLocations($removeDuplicates = false)
    {
        return $this->locations($removeDuplicates)->get();
    }

    /**
     * Get all origin locations. Useful if you want to perform additional filtering.
     *
     * @param bool $removeDuplicates
     * @return AbstractApi
     */
    public function origins($removeDuplicates = false) : AbstractApi
    {
        $ids = $this->extractIdsFromResponseBasedOnKey('origin', $removeDuplicates);

        return $this->api->location()->whereId($ids);
    }

    /**
     * Get all origin locations.
     *
     * @param bool $removeDuplicates
     * @return mixed
     */
    public function getOrigins($removeDuplicates = false)
    {
        return $this->origins($removeDuplicates)->get();
    }

    /**
     * Get all episodes. Useful if you want to perform additional filtering.
     *
     * @param bool $removeDuplicates
     * @return AbstractApi
     */
    public function episodes($removeDuplicates = false) : AbstractApi
    {
        $ids = $this->extractIdsFromResponseBasedOnKey('episode', $removeDuplicates);

        return $this->api->episode()->whereId($ids);
    }

    /**
     * Get all episodes
     *
     * @param bool $removeDuplicates
     * @return mixed
     */
    public function getEpisodes($removeDuplicates = false)
    {
        return $this->episodes($removeDuplicates)->get();
    }

    /**
     * @param string $key
     * @param boolean $removeDuplicates
     * @return array
     */
    private function extractIdsFromResponseBasedOnKey($key, $removeDuplicates) : array
    {
        $urls = [];
        if ($this->info) {
            $urls = array_column($this->data['results'], $key);
        } elseif (isset($this->data[0])) {
            $urls = array_column($this->data, $key);
        } else {
            $urls[] = $this->data[$key];
        }
        $urls = array_column($urls, 'url');
        if ($removeDuplicates) {
            $urls = array_unique($urls);
        }

        return $this->parseIdsFromUrl($urls);
    }
}
