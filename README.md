# Laravel + GraphQL + MongoDB Example

### About Project

The application was developed using Docker, PHP, MongoDB and GraphQL. To start you only need [docker](https://docs.docker.com/engine/install/ubuntu/) 
and [docker-compose](https://docs.docker.com/compose/install/) installed on your machine.

#### How to start

```
cp .env.example .env
docker-compose up -d
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
```

#### How to run tests

```
docker-compose exec app php artisan migrate --database=mongo_testing
docker-compose exec app vendor/bin/phpunit
```

#### How to use

**POST** http://0.0.0.0:8888/graphql

```
query FetchAllRestaurants {
  Restaurants {
    tradingName,
    coverageArea {
      coordinates
    }
  }
}

// todo: add uuid
query FindRestaurantByID {
  Restaurant(id: 123123) {
    tradingName,
    address {
      type,
      coordinates
    }
  }
}

query FindRestaurantByLocation {
  Restaurants(lng: -38.59826, lat:-3.774186) {
    document,
    address {
      type,
      coordinates
    }
  }
}

mutation restaurants {
  CreateRestaurant(
    tradingName: "Pokemon bar & lanches LTDA",
    ownerName: "Ash Ketchup",
    document: "33.416.178/0001-77",
    address: {
      type: "Point",
      coordinates: [-46.57421, -21.785741]
    },
    coverageArea: {
  type: "MultiPolygon",
  coordinates: [
    [[[102.0, 2.0], [103.0, 2.0], [103.0, 3.0], [102.0, 3.0], [102.0, 2.0]]],
    [[[100.0, 0.0], [101.0, 0.0], [101.0, 1.0], [100.0, 1.0], [100.0, 0.0]],
     [[100.2, 0.2], [100.8, 0.2], [100.8, 0.8], [100.2, 0.8], [100.2, 0.2]]]
  ]
}
  ) {
    id,
    coverageArea {
      type
    }
  }
}
```

#


Made with love by [me](https://victorhugo.dev).