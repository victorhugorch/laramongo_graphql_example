<?php

declare(strict_types=1);

use App\GraphQL\Types\AddressType;
use App\GraphQL\Inputs\AddressInput;
use App\GraphQL\Scalars\GeoJSONType;
use App\GraphQL\Types\RestaurantType;
use App\GraphQL\Types\AreaCoverageType;
use App\GraphQL\Queries\RestaurantQuery;
use App\GraphQL\Inputs\CoverageAreaInput;
use App\GraphQL\Mutations\CreateRestaurantMutation;

return [

    'prefix' => 'graphql',
    'routes' => '{graphql_schema?}',
    'controllers' => \Rebing\GraphQL\GraphQLController::class.'@query',
    'middleware' => [],
    'route_group_attributes' => [],

    'default_schema' => 'default',

    'schemas' => [
        'default' => [
            'query' => [
                'Restaurants' => RestaurantQuery::class,
            ],
            'mutation' => [
                'CreateRestaurant' => CreateRestaurantMutation::class
            ],
            'middleware' => [],
            'method' => ['get', 'post'],
        ],
    ],

    'types' => [
        'Restaurant' => RestaurantType::class,
        'CoverageArea' => AreaCoverageType::class,
        'GeoJSON' => GeoJSONType::class,
        'Address' => AddressType::class,

        'AddressInput' => AddressInput::class,
        'CoverageAreaInput' => CoverageAreaInput::class,
    ],

    'lazyload_types' => false,
    'error_formatter' => ['\Rebing\GraphQL\GraphQL', 'formatError'],
    'errors_handler' => ['\Rebing\GraphQL\GraphQL', 'handleErrors'],
    'params_key' => 'variables',
    'security' => [
        'query_max_complexity' => null,
        'query_max_depth' => null,
        'disable_introspection' => false,
    ],
    'pagination_type' => \Rebing\GraphQL\Support\PaginationType::class,
    'graphiql' => [
        'prefix' => '/graphiql',
        'controller' => \Rebing\GraphQL\GraphQLController::class.'@graphiql',
        'middleware' => [],
        'view' => 'graphql::graphiql',
        'display' => env('ENABLE_GRAPHIQL', true),
    ],
    'defaultFieldResolver' => null,
    'headers' => [],
    'json_encoding_options' => 0,
];
