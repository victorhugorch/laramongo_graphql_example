<?php

declare(strict_types=1);

namespace App\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class AddressInput extends InputType
{
    protected $attributes =
        [
            'name' => 'AddressInput',
            'description' => 'Address of restaurant'
        ];


    public function fields(): array
    {
        return [
            'type' => [
                'name' => 'type',
                'type' => Type::nonNull(Type::string())
            ],
            'coordinates' =>
                [
                    'name' => 'coordinates',
                    'type' => Type::nonNull(
                        Type::listOf(
                            Type::float()
                        )
                    )
                ],
        ];
    }

}
