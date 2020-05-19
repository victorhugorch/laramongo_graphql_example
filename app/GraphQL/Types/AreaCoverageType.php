<?php

namespace App\GraphQL\Types;

use App\Models\CoverageArea;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class AreaCoverageType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Coverage Area',
        'description'   => 'The coverageArea is defined by the format GeoJSON MultiPolygon',
        'model'         => CoverageArea::class,
    ];

    public function fields(): array
    {
        return [
            'type' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The format GeoJSON',
            ],
            'coordinates' => [
                'type' =>  Type::listOf(GraphQL::type('GeoJSON')),
                'description' => 'The pdv coordinates in GeoJSON MultiPolygon',
            ]
        ];
    }
}