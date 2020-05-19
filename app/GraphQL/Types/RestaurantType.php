<?php

namespace App\GraphQL\Types;

use App\Models\Restaurant;
use Rebing\GraphQL\Support\Type as GraphQLType;

class RestaurantType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Restaurant',
        'description'   => 'Responsible for food delivery in the region.',
        'model'         => Restaurant::class,
    ];

    public function fields(): array
    {
        return (new Restaurant())->fields();
    }
}