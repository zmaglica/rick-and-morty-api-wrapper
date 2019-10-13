<?php

namespace Zmaglica\RickAndMortyApiWrapper\Api;

abstract class AbstractApi
{
    protected $client;
    protected $uri;
    protected $ids = null;
    protected $page = 1;
    protected $arguments = [];
    protected $supportedFilters = [];
    protected $model;

    /**
     * Send HTTP Request to API
     *
     * @param null $uri
     * @param null $arguments
     * @param bool $async
     * @return mixed
     */
    public function sendRequest($uri = null, $arguments = null, $async = false)
    {
        /*
         * For custom uri
         */
        if ($uri === null) {
            $uri = $this->uri;
        }
        /*
         * For raw API requests
         */
        if ($arguments === null) {
            $arguments = $this->arguments;
        }
        $promise = $this->client->getAsync($uri, $arguments);
        if (!$async) {
            $response = $promise->wait();

            return new $this->model($response, $this);
        }

        return $promise;
    }

    public function get($ids = null)
    {
        $uri = $this->getUri($ids ?? $this->ids);

        return $this->sendRequest($uri);
    }

    public function all()
    {
        return $this->sendRequest($this->getUri());
    }

    /**
     * @param array $params
     * @return $this
     */
    public function where(array $params)
    {
        if (!isset($this->arguments['query'])) {
            $this->arguments['query'] = [];
        }
        if (isset($params['id'])) {
            $this->ids = $params['id'];
            /*
             * Remove id param because id doesn't exists in filtering
             */
            unset($params['id']);
        }
        $this->arguments['query'] = array_merge($this->arguments['query'], $params);

        return $this;
    }

    /**
     * You can set ids and add additional filters and then execute API request
     *
     * @param $ids
     * @return AbstractApi
     */
    public function whereId($ids)
    {
        return $this->where(['id' => $ids]);
    }

    /**
     * Send raw uri to API
     * @param string $uri
     */
    public function raw(string $uri)
    {
        $this->sendRequest($uri, []);
    }

    /**
     * Clear all arguments and ids
     *
     * @return $this
     */
    public function clear()
    {
        $this->ids = null;
        $this->arguments['query'] = [];

        return $this;
    }

    /**
     * Get arguments/filters for API
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Set page for request
     *
     * @param int $page
     * @return $this
     */
    public function setPage(int $page)
    {
        $this->page = $page;
        $this->where(['page' => $page]);

        return $this;
    }

    /**
     * Increment page to simulate pagination
     * @return $this
     */
    public function nextPage()
    {
        $this->page++;
        $this->where(['page' => $this->page]);

        return $this;
    }

    /**
     * Decrement page to simulate pagination
     * @return $this
     */
    public function previousPage()
    {
        /*
         * Minimum page number is 1
         */
        if ($this->page < 2) {
            $this->page--;
        }

        $this->where(['page' => $this->page]);

        return $this;
    }

    /**
     * Parse ids and prepare uri
     * @param null $ids
     * @return string
     */
    public function getUri($ids = null)
    {
        $this->ids = $ids ?? $this->ids;
        if ($this->ids) {
            if (is_array($this->ids)) {
                $uri = $this->uri . '/' . implode(',', $this->ids);
            } else {
                $uri = $this->uri . '/' . $this->ids;
            }
        } else {
            $uri = $this->uri;
        }

        return $uri;
    }

    /**
     * Used for nesting where function with API filter values
     * Example: whereName('Rick') will internally call where function with argument ['name' => 'Rick']
     * @param $name
     * @param $arguments
     * @return $this
     */
    public function __call($name, $arguments)
    {
        if (strpos($name, 'where') !== 0) {
            throw new \BadFunctionCallException();
        }
        $filterValue = strtolower(substr($name, 5));
        if (!in_array($filterValue, $this->supportedFilters)) {
            throw new \BadFunctionCallException();
        }
        if (count($arguments) === 1) {
            $arguments = $arguments[0];
        }
        $this->where([$filterValue => $arguments]);

        return $this;
    }
}
