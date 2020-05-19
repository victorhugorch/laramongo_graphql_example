<?php

namespace App\GraphQL\Queries;

use Closure;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use App\Services\RestaurantService;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;

class RestaurantQuery extends Query
{
    private $restaurantService;

    public function __construct(RestaurantService $restaurantService)
    {
        $this->restaurantService = $restaurantService;
    }

    protected $attributes = [
        'name' => 'Restaurant',
        'description' => 'Query to Restaurant data and relations data (coverageArea, address).'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Restaurant'));
    }

    public function args(): array
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::string()],
            'lat' => ['name' => 'lat', 'type' => Type::float()],
            'lng' => ['name' => 'lng', 'type' => Type::float()]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fields = $resolveInfo->getFieldSelection($depth = 3);

        return $this->restaurantService->find($args, $fields);
    }
}