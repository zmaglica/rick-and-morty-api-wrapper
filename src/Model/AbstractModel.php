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

    public function toArray()
    {
        return $this->data;
    }

    public function toJson()
    {
        return json_encode($this->data);
    }

    /**
     * Check if is first page of response
     * @return bool
     */
    public function isFirstPage()
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
    public function isLastPage()
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
    public function count()
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
    public function pages()
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

    public function firstPage()
    {
        if ($this->info) {
            return $this->parent->setPage(1)->sendRequest();
        }

        return null;
    }

    public function goToPage(int $page)
    {
        if ($this->info) {
            return $this->parent->setPage($page)->sendRequest();
        }
    }

    public function lastPage()
    {
        if ($this->info) {
            return $this->parent->setPage($this->info['pages'])->sendRequest();
        }

        return null;
    }
}
