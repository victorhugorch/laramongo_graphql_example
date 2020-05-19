<?php

namespace App\Services;

use App\Repositories\RestaurantRepositoryInterface;

class RestaurantService
{
    const SCHEMA_NAME = 'restaurants';
    private $pdvRepository;

    public function __construct(RestaurantRepositoryInterface $pdvRepository)
    {
        $this->pdvRepository = $pdvRepository;
    }

    public function create(array $args)
    {
        return $this->pdvRepository->create($args);
    }

    public function find(array $args, array $selects)
    {
        return $this->pdvRepository->find($args, $selects);
    }
}