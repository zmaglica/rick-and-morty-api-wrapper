<?php

namespace Zmaglica\RickAndMortyApiWrapper\Model;

class Character extends AbstractModel
{
    /**
     * Get all locations without running API call. Useful if you want to perform additional filtering.
     *
     * @param bool $removeDuplicates
     * @return array|\Zmaglica\RickAndMortyApiWrapper\Api\AbstractApi
     */
    public function locations($removeDuplicates = false)
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
     * @return array|\Zmaglica\RickAndMortyApiWrapper\Api\AbstractApi
     */
    public function origins($removeDuplicates = false)
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
     * @return \Zmaglica\RickAndMortyApiWrapper\Api\AbstractApi
     */
    public function episodes($removeDuplicates = false)
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
    private function extractIdsFromResponseBasedOnKey($key, $removeDuplicates)
    {
        $ids = [];
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

        foreach ($urls as $url) {
            $ids[] = substr(strrchr($url, '/'), 1);
            ;
        }
        if (!$ids) {
            return [];
        }

        return $ids;
    }
}
