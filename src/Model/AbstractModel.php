<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10.10.2019.
 * Time: 18:15
 */
namespace Zmaglica\RickAndMortyApiWrapper\Model;

use Zmaglica\RickAndMortyApiWrapper\RickAndMortyApiWrapper;

abstract class AbstractModel
{
    protected $api;

    protected $response;

    protected $data;

    protected $parent;

    protected $info;

    public function __construct($response, $parent)
    {
        $this->api = new RickAndMortyApiWrapper();
        $this->parent = $parent;
        $this->response = $response;
        $this->data = json_decode($response->getBody(), true);
        $this->info = $this->data['info'] ?? null;
    }

    /**
     * Check if there was errors on request
     * @return bool
     */
    public function hasErrors(): bool
    {
        return $this->response->getStatusCode() >= 400;
    }

    /**
     * Get response status code
     *
     * @return int
     */
    public function getResponseStatusCode(): int
    {
        return $this->response->getStatusCode();
    }

    /**
     * Get response data
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * Get data as json
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->data);
    }

    /**
     * Check if is first page of response
     * @return bool
     */
    public function isFirstPage(): bool
    {
        if ($this->info && $this->info['prev']) {
            return false;
        }

        return true;
    }

    /**
     * Check if is last page of request
     *
     * @return bool
     */
    public function isLastPage(): bool
    {
        if ($this->info && $this->info['next']) {
            return false;
        }

        return true;
    }

    /**
     * Get total number of records
     * @return int
     */
    public function count(): int
    {
        if ($this->info) {
            return $this->info['count'];
        }
        /*
         * Check if there is a multiple results (case when we send multiple ids)
         */
        if (isset($this->data[0])) {
            return count($this->data);
        }
        /*
         * When we pass single ID we got results as single (not multidimensional array)
         */
        return 1;
    }

    /** Get total number of pages
     * @return int
     */
    public function pages(): int
    {
        return $this->info['pages'] ?? 1;
    }

    /**
     * Get previous page based on api response
     * @return mixed
     */
    public function prev()
    {
        if ($this->isFirstPage()) {
            return null;
        }

        return $this->parent->prevPage()->sendRequest();
    }

    /**
     * Get next page based on api response
     * @return mixed
     */
    public function next()
    {
        if ($this->isLastPage()) {
            return null;
        }

        return $this->parent->nextPage()->sendRequest();
    }

    /**
     * Go to first page
     * @return mixed
     */
    public function firstPage()
    {
        if ($this->info) {
            return $this->parent->setPage(1)->sendRequest();
        }

        return null;
    }

    /**
     * Go to desired page
     * @param int $page
     * @return mixed
     */
    public function goToPage(int $page)
    {
        if ($this->info) {
            return $this->parent->setPage($page)->sendRequest();
        }
    }

    /**
     * Go to last page
     * @return mixed
     */
    public function lastPage()
    {
        if ($this->info) {
            return $this->parent->setPage($this->info['pages'])->sendRequest();
        }

        return null;
    }

    /**
     * Helper function to get ids from urls
     * @param array $urls
     * @return array
     */
    public function parseIdsFromUrl(array $urls) : array
    {
        $ids = [];
        foreach ($urls as $url) {
            $ids[] = substr(strrchr($url, '/'), 1);
        }

        return $ids;
    }
}
