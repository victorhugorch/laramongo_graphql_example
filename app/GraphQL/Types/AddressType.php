<?php

namespace App\GraphQL\Types;

use App\Models\Address;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class AddressType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Address',
        'description'   => 'The address is defined by the format GeoJSON Point',
        'model'         => Address::class,
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
                'description' => 'The partner lat and lng',
            ]
        ];
    }
}