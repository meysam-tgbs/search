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
                            'index' => false,
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

    public function search(string $query, string $lang, string $entityType = null, string $date = null): ?array
    {
        try {
            $body = [
                "query" => [
                    "bool" => [
                        "filter" => [
                            [
                                "query_string" => [
                                    "fields" => ["entityType"],
                                    "query" => $entityType ?? "*"
                                ]
                            ],
                            [
                                "match" => [
                                    "lang" => $lang
                                ]
                            ],
                            [
                                "bool" => [
                                    "should" => [
                                        [
                                            "query_string" => [
                                                "fields" => ["label1"],
                                                "query" => "*{$query}*"
                                            ]
                                        ],
                                        [
                                            "query_string" => [
                                                "fields" => ["label2"],
                                                "query" => "*{$query}*"
                                            ]
                                        ],
                                        [
                                            "query_string" => [
                                                "fields" => ["label3"],
                                                "query" => "*{$query}*"
                                            ]
                                        ]
                                    ],
                                ]
                            ]
                        ]
                    ]
                ],
            ];

            if ($date) {
                $body['query']['bool']['filter'][] = [
                    'range' => [
                        'metadata.date' => [
                            'gte' => $date,
                            'format' => 'strict_date_optional_time'
                        ]
                    ]
                ];
            }

            $results = $this->elasticClient->search([
                'index' => static::getIndexName(),
                'body' => $body,
            ]);

            return $this->deserializeResult($results);
        } catch (\Exception $exception) {
            return null;
        }
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
                                    "type" => $type,
                                ]
                            ],
                            [
                                "match" => [
                                    "date" => $datetime,
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
                                    "type" => $type,
                                ]
                            ],
                            [
                                "match" => [
                                    "title" => $title,
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
                                    "type" => $type,
                                ]
                            ],
                            [
                                "match" => [
                                    "username" => $username,
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
                                    "type" => $type,
                                ]
                            ],
                            [
                                "match" => [
                                    "source" => $source,
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
