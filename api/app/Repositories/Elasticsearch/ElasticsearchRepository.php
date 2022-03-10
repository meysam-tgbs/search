<?php

namespace App\Repositories\Elasticsearch;

use App\Exceptions\ElasticsearchRepositoryException;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Exception;
use Symfony\Component\Serializer\SerializerInterface;


abstract class ElasticsearchRepository
{
    const INDEX_TYPE_DOC = '_doc';

    protected Client $elasticClient;
    protected SerializerInterface $serializer;


    public function __construct(SerializerInterface $serializer)
    {
        $this->elasticClient = ClientBuilder::create()
            ->setHosts([
                [
                    'scheme' => config('database.elasticsearch.scheme'),
                    'port' => config('database.elasticsearch.port'),
                    'host' => config('database.elasticsearch.host'),
                    'user' => config('database.elasticsearch.username'),
                    'pass' => config('database.elasticsearch.password'),
                ]
            ])
            ->build();
        $this->serializer = $serializer;
    }

    abstract public static function getIndexName(): string;

    abstract public static function getFqcnModel(): string;

    public function getElasticClient(): Client
    {
        return $this->elasticClient;
    }

    public function createIndex(): array
    {
        try {
            return $this->elasticClient->indices()->create($this->schema());
        } catch (Exception $exception) {
            throw new ElasticsearchRepositoryException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    public function persist(ElasticsearchRepositoryModelInterface $model = null): array
    {
        try {
            return $this->elasticClient->index([
                'index' => static::getIndexName(),
                'type' => self::INDEX_TYPE_DOC,
                'body' => $model->toArray(),
            ]);
        } catch (Exception $exception) {
            throw new ElasticsearchRepositoryException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    public function update(ElasticsearchRepositoryModelInterface $model = null): array
    {
        try {
            return $this->elasticClient->index([
                'index' => static::getIndexName(),
                'type' => self::INDEX_TYPE_DOC,
                'id' => $model->getId(),
                'body' => $model->toArray(),
            ]);
        } catch (Exception $exception) {
            throw new ElasticsearchRepositoryException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    public function delete(string $id): bool
    {
        try {
            $this->elasticClient->delete([
                'index' => static::getIndexName(),
                'type' => self::INDEX_TYPE_DOC,
                'id' => $id,
            ]);
            return true;
        } catch (Exception $exception) {
            throw new ElasticsearchRepositoryException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    public function drop(): ?array
    {
        try {
            return $this->elasticClient->indices()->delete([
                'index' => static::getIndexName()
            ]);
        } catch (Exception $exception) {
            return null;
        }
    }

    public function find(string $id): ?Search
    {
        try {
            $result = $this->elasticClient->get([
                'index' => static::getIndexName(),
                'type' => self::INDEX_TYPE_DOC,
                'id' => $id,
            ]);

            return $this->deserializeResult($result);
        } catch (\Exception $exception) {
            return null;
        }
    }

    public function findAll(): ?array
    {
        try {
            $result = $this->elasticClient->search([
                'index' => static::getIndexName(),
                'type' => self::INDEX_TYPE_DOC,
            ]);

            return $this->deserializeResult($result);
        } catch (\Exception $exception) {
            return null;
        }
    }

    protected function deserializeResult(array $result)
    {

        if (isset($result['_source'])) {

            if (empty($result['_source'])) {
                return null;
            }

            try {
                $result['_source']['id'] = $result['_id'];
                return $this->serializer->deserialize(json_encode($result['_source']), static::getFqcnModel(), 'json');
            } catch (\Exception $exception) {
                return null;
            }

        }

        if (isset($result['hits']['hits'])) {

            if (empty($result['hits']['hits'])) {
                return [];
            }

            try {
                return array_map(function ($data) {
                    $data['_source']['id'] = $data['_id'];
                    return $this->serializer->deserialize(json_encode($data['_source']), static::getFqcnModel(), 'json');
                }, $result['hits']['hits']);
            } catch (\Exception $exception) {
                return [];
            }

        }
    }
}
