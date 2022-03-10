# Search service 
This is a sample test service as Interview task for Datak Company. It is built by Laravel 8 .

## Installation
In order to install service correctly follow these instructions below:
```
# clone reposity
git clone {REPOSITORY_URL}

# Run Docker Containers
docker-compose up -d

# Install composer packages
docker-compose exec php composer install

# Create .env file
docker-compose exec php cp .env.example .env

# Create Elasticsearch index
docker-compose exec php php artisan make:elastic:index

# Import dummy data
docker-compose exec php php artisan db seed
``` 

## Installation without docker
In order install the project without Docker, First You need have an Elasticsearch server, then after installation Laravel you just need to set Elasticsearch config in the file `config/database.php` or set it in `.env file`:
```
ELASTIC_TRANSPORT=http
ELASTIC_PORT=9200
ELASTIC_HOST=elasticsearch
ELASTIC_USERNAME=elastic
ELASTIC_PASSWORD=123456
ELASTIC_INDEX=search
```

## Endpoints
```
GET http://localhost:8000/api/search/(news|instagram|twitter)?filter=(date|title|username|name|source)&value=(2020-02-20|test title|username|taylor otwell|CNN)
```

## Tests
To run test use below command:
```
docker-compose exec php php artisan test
```

## Drop Elasticsearch Index
```
docker-compose exec php php artisan drop:elastic:index
```