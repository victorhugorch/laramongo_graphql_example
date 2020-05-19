<?php

namespace App\Models;

use App\Traits\Uuids;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Restaurant extends Eloquent
{
    use Uuids;

    protected $connection = 'mongodb';
    protected $collection = 'restaurants';

    protected $fillable = ['id', 'tradingName', 'ownerName', 'document', 'coverageArea', 'address'];

    public $timestamps = false;
    public $incrementing = false;

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