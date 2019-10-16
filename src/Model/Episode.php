<?php

namespace Zmaglica\RickAndMortyApiWrapper\Model;

use Zmaglica\RickAndMortyApiWrapper\Api\AbstractApi;

class Episode extends AbstractModel
{
    /**
     * Get all characters without running API call. Useful if you want to perform additional filtering.
     * @param bool $removeDuplicates
     * @return AbstractApi
     */
    public function characters($removeDuplicates = false): AbstractApi
    {
        $ids = $this->extractIdsFromResponseBasedOnKey('characters', $removeDuplicates);

        return $this->api->character()->whereId($ids);
    }

    /**
     * Get all episode characters
     * @param bool $removeDuplicates
     * @return mixed
     */
    public function getCharacters($removeDuplicates = false)
    {
        return $this->characters($removeDuplicates)->get();
    }

    /**
     * This helper function will extract all URL ids by key. Key can be location, residence or episode
     * @param $key
     * @param $removeDuplicates
     * @return array
     */
    private function extractIdsFromResponseBasedOnKey($key, $removeDuplicates): array
    {
        if ($this->info) {
            $urls = array_column($this->data['results'], $key);
            // flatten array to single one because there can be multiple residents per location
            $urls = array_merge(...$urls);
        } elseif (isset($this->data[0])) {
            $urls = array_column($this->data, $key);
            // flatten array to single one because there can be multiple residents per location
            $urls = array_merge(...$urls);
        } else {
            $urls = $this->data[$key];
        }

        if ($removeDuplicates) {
            $urls = array_unique($urls);
        }

        return $this->parseIdsFromUrl($urls);
    }
}
