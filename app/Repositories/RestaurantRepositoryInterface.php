<?php

namespace App\Repositories;

interface RestaurantRepositoryInterface
{
    public function create(array $args);
    public function update(array $args);
    public function find(array $args, array $selects);
}