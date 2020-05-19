<?php

namespace App\Models;

use GraphQL\Type\Definition\Type;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Rebing\GraphQL\Support\Facades\GraphQL;

class Restaurant extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'restaurants';
    protected $fillable = ['id', 'tradingName', 'ownerName', 'document', 'coverageArea', 'address'];

    public $timestamps = false;

    public function fields() : array
    {
        return [
            'id' => [
                'type' => Type::string(),
                'description' => 'The identifier of the restaurant',
            ],
            'tradingName' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The restaurant name',
            ],
            'ownerName' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The owner name of restaurant',
            ],
            'document' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The document (CNPJ) of restaurant',
            ],
            'coverageArea' => [
                'name' => 'coverageArea',
                'description' => 'A delivery service coverage area',
                'type' => GraphQL::type('CoverageArea'),
                'is_relation' => false
            ],
            'address' => [
                'name' => 'address',
                'description' => 'The address of restaurant',
                'type' => GraphQL::type('Address'),
                'is_relation' => false
            ]
        ];
    }
}