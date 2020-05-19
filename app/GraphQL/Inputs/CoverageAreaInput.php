<?php

declare(strict_types=1);

namespace App\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CoverageAreaInput extends InputType
{
    protected $attributes =
        [
            'name' => 'CoverageAreaInput',
            'description' => 'The coverage area of delivery service'
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
                            Type::listOf(
                                Type::listOf(
                                    Type::listOf(
                                        Type::float()
                                    )
                                )
                            )
                        )
                    )
                ],
        ];
    }

}
