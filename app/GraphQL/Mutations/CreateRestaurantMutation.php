<?php

namespace App\GraphQL\Mutations;

use Exception;
use GeoJson\Geometry\Point;
use GraphQL\Type\Definition\Type;
use GeoJson\Geometry\MultiPolygon;
use App\Services\RestaurantService;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\Validator;
use Rebing\GraphQL\Support\Facades\GraphQL;
use YucaDoo\LaravelGeoJsonRule\GeoJsonRule;

class CreateRestaurantMutation extends Mutation
{
    const MULTIPOLYGON = "MultiPolygon";
    private $restaurantService;

    protected $attributes = [
        'name' => 'CreateRestaurant'
    ];
    /**
     * @var mixed|null
     */
    private $errorMessage;

    public function __construct(RestaurantService $restaurantService)
    {
        $this->restaurantService = $restaurantService;
    }

    public function type(): Type
    {
        return GraphQL::type('Restaurant');
    }

    public function args(): array
    {
        return [
            /*'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::string()),
                'description' => 'The restaurant identifier',
                'rules' => ['required']
            ],*/
            'tradingName' => [
                'name' => 'tradingName',
                'type' => Type::nonNull(Type::string()),
                'description' => 'The restaurant name',
                'rules' => ['required', 'string']
            ],
            'ownerName' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The owner name of restaurant',
                'rules' => ['required', 'string']
            ],
            'document' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The document (CNPJ) of restaurant',
                'rules' => ['required', 'string']
            ],
            'address' => [
                'name' => 'address',
                'description' => 'The address of restaurant',
                'type' => GraphQL::type('AddressInput'),
                'rules' => ['required']
            ],
            'coverageArea' => [
                'name' => 'coverageArea',
                'description' => 'The coverage area of delivery service',
                'type' => GraphQL::type('CoverageAreaInput'),
                'rules' => ['required']
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $validator = $this->makeValidation($args);
        return $validator ? $this->restaurantService->create($args) : new Exception($this->errorMessage);
    }

    private function makeValidation(array $args) : bool
    {
        $validatorAddress = Validator::make(
            ['position' => json_encode($args['address'])],
            ['position' => new GeoJsonRule(Point::class)]
        );

        $geometryClass = new MultiPolygon($args['coverageArea']['coordinates']);
        $validatorCoverageArea = $this->validateGeometryClass($geometryClass, $args);

        $this->setErrorMessage($validatorAddress, $validatorCoverageArea);

        return ($validatorAddress->passes() && $validatorCoverageArea);
    }

    private function validateGeometryClass($geometryClass, $args)
    {
        return ($geometryClass->getType() == self::MULTIPOLYGON && $args['coverageArea']['type'] == self::MULTIPOLYGON);
    }

    private function setErrorMessage($validatorAddress, $validatorCoverageArea)
    {
        if ($validatorCoverageArea) {
            $this->errorMessage = "You must follow the GeoJSON Multipolygon standard to register a coverage area.";
        }

        if ($validatorAddress->fails()) {
            $this->errorMessage = $validatorAddress->messages()->get('position')[0];
        }

        if (!$validatorCoverageArea && $validatorAddress->fails()) {
            $this->errorMessage = "You must follow the GeoJSON Multipolygon standard to register a coverage area and/or 
            GeoJSON Point to register an address.";
        }
    }
}