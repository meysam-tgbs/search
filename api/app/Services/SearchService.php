<?php

namespace App\Services;

use App\Repositories\SearchRepository;
use App\Repositories\Search;

class SearchService
{
    protected SearchRepository $repository;
    protected string $type = 'news';

    public function __construct(SearchRepository $repository)
    {
        $this->repository = $repository;
    }

    public function setType(string $type)
    {
        $this->type = $type;
        return $this;
    }

    public function findByDate(string $date)
    {
        return $this->repository->findByDate($this->type, $date);
    }

    public function findByTitle(string $title)
    {
        return $this->repository->findByTitle($this->type, $title);
    }

    public function findByUsername(string $username)
    {
        return $this->repository->findByUsername($this->type, $username);
    }

    public function findByName(string $name)
    {
        return $this->repository->findByName($this->type, $name);
    }

    public function findBySource(string $source)
    {
        return $this->repository->findBySource($this->type, $source);
    }

    public function toArray(array $searches)
    {
        return array_map(function (Search $search) {
            return $search->toArray();
        }, $searches );
    }

}
