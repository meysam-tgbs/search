<?php

namespace App\Repositories;

use App\Repositories\Search;
use App\Repositories\Elasticsearch\ElasticsearchRepository;
use Symfony\Component\Serializer\SerializerInterface;


class SearchRepository extends ElasticsearchRepository
{
    public static function getIndexName(): string
    {
        return config('database.elasticsearch.index');
    }

    public static function getFqcnModel(): string
    {
        return Search::class;
    }

    public function schema(): array
    {
        return [
            'index' => self::getIndexName(),
            'body' => [
                'settings' => [
                    'number_of_shards' => 3
                ],
                'mappings' => [
                    'properties' => [
                        'type' => [
                            'type' => 'text'
                        ],
                        'title' => [
                            'type' => 'text'
                        ],
                        'source' => [
                            'type' => 'text',
                        ],
                        'content' => [
                            'type' => 'text',
                            'index' => false,
                        ],
                        'link' => [
                            'type' => 'text',
                            'index' => false,
                        ],
                        'avatar' => [
                            'type' => 'text',
                            'index' => false,
                        ],
                        'photo' => [
                            'type' => 'text',
                            'index' => false,
                        ],
                        'video' => [
                            'type' => 'text',
                            'index' => false,
                        ],
                        'name' => [
                            'type' => 'text',
                        ],
                        'username' => [
                            'type' => 'text'
                        ],
                        'date' => [
                            'type' => 'date'
                        ],
                        'retweet' => [
                            'type' => 'integer',
                            'index' => false,
                        ],
                    ]
                ]
            ]
        ];
    }

    public function findByDate(string $type, string $datetime): ?array
    {
        try {
            $body = [
                "query" => [
                    "bool" => [
                        "must" => [
                            [
                                "match" => [
                                    "type" => [
                                        'query' => $type,
                                        'operator' => 'and'
                                    ],
                                ]
                            ],
                            [
                                "match" => [
                                    "date" => [
                                        'query' => $datetime,
                                        'operator' => 'and'
                                    ]
                                ]
                            ]
                        ]
                    ]

                ],
            ];

            $results = $this->elasticClient->search([
                'index' => static::getIndexName(),
                'body' => $body,
            ]);

            return $this->deserializeResult($results);
        } catch (\Exception $exception) {
            return null;
        }
    }

    public function findByTitle(string $type, string $title): ?array
    {
        try {
            $body = [
                "query" => [
                    "bool" => [
                        "must" => [
                            [
                                "match" => [
                                    "type" => [
                                        'query' => $type,
                                        'operator' => 'and'
                                    ],
                                ]
                            ],
                            [
                                "match" => [
                                    "title" => [
                                        'query' => $title,
                                        'operator' => 'and'
                                    ]
                                ]
                            ]
                        ]
                    ]

                ],
            ];

            $results = $this->elasticClient->search([
                'index' => static::getIndexName(),
                'body' => $body,
            ]);

            return $this->deserializeResult($results);
        } catch (\Exception $exception) {
            return null;
        }
    }

    public function findByName(string $type, string $name): ?array
    {
        try {
            $body = [
                "query" => [
                    "bool" => [
                        "must" => [
                            [
                                "match" => [
                                    "type" => [
                                        'query' => $type,
                                        'operator' => 'and'
                                    ],
                                ]
                            ],
                            [
                                "match" => [
                                    "name" => [
                                        'query' => $name,
                                        'operator' => 'and'
                                    ]
                                ]
                            ]
                        ]
                    ]

                ],
            ];

            $results = $this->elasticClient->search([
                'index' => static::getIndexName(),
                'body' => $body,
            ]);

            return $this->deserializeResult($results);
        } catch (\Exception $exception) {
            return null;
        }
    }

    public function findByUsername(string $type, string $username): ?array
    {
        try {
            $body = [
                "query" => [
                    "bool" => [
                        "must" => [
                            [
                                "match" => [
                                    "type" => [
                                        'query' => $type,
                                        'operator' => 'and'
                                    ],
                                ]
                            ],
                            [
                                "match" => [
                                    "username" => [
                                        'query' => $username,
                                        'operator' => 'and'
                                    ]
                                ]
                            ]
                        ]
                    ]

                ],
            ];

            $results = $this->elasticClient->search([
                'index' => static::getIndexName(),
                'body' => $body,
            ]);

            return $this->deserializeResult($results);
        } catch (\Exception $exception) {
            return null;
        }
    }

    public function findBySource(string $type, string $source): ?array
    {
        try {
            $body = [
                "query" => [
                    "bool" => [
                        "must" => [
                            [
                                "match" => [
                                    "type" => [
                                        'query' => $type,
                                        'operator' => 'and'
                                    ],
                                ]
                            ],
                            [
                                "match" => [
                                    "source" => [
                                        'query' => $source,
                                        'operator' => 'and'
                                    ]
                                ]
                            ]
                        ]
                    ]

                ],
            ];

            $results = $this->elasticClient->search([
                'index' => static::getIndexName(),
                'body' => $body,
            ]);

            return $this->deserializeResult($results);
        } catch (\Exception $exception) {
            return null;
        }
    }
}
