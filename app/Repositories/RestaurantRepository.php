<?php

namespace App\Repositories;

use App\Models\Restaurant;
use Illuminate\Support\Collection;
use Jenssegers\Mongodb\Eloquent\Builder;

class RestaurantRepository implements RestaurantRepositoryInterface
{
    public function update(array $args) : Restaurant
    {
        $restaurant = Restaurant::where('id', $args['id']);

        if ($restaurant->exists()) {
            $restaurant->update($args, ['upsert' => true]);

            return $restaurant->first();
        }
    }

    public function create(array $args) : Restaurant
    {
        return Restaurant::create($args);
    }

    public function find(array $args, array $selects) : Collection
    {
        $query = $this->makeSelect(Restaurant::query(), $selects);
        $query = $this->makeWhere($query, $args);

        return $query->get();
    }

    private function makeSelect(Builder $query, array $selects) : Builder
    {
        $selectUsed = [];

        foreach ($selects as $select => $value) {
            if (is_array($value)) {
                array_push($selectUsed, $select);

                foreach ($value as $fieldDepthKey => $fieldDepthValue) {
                    $query->addSelect("$select.$fieldDepthKey");
                }
            }

            !in_array($select, $selectUsed) ? $query->addSelect($select) : null;
        }

        return $query;
    }

    private function makeWhere(Builder $query, array $args) : Builder
    {
        if (!empty($args)) {
            if (array_key_exists("id",$args)) {
                $id = $args['id'];
                $query->where('id', $id);
            }

            if (array_key_exists("lng",$args) && array_key_exists("lat",$args)) {
                $query->where('address', 'nearSphere', [
                    '$geometry' => [
                        'type' => 'Point',
                        'coordinates' => [
                            (float) $args['lng'],
                            (float) $args['lat']
                        ],
                    ],
                    '$maxDistance' => 10000000,
                ]);
            }
        }

        return $query;
    }
}