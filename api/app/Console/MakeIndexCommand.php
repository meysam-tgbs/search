<?php


namespace App\Console;


use App\Repositories\SearchRepository;
use Illuminate\Console\Command;


/**
 * Class MakeIndexCommand
 * @package App\Console\Commands\Elasticsearch
 */
class MakeIndexCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'make:elastic:index';

    /**
     * @var string
     */
    protected $description = 'Make index in Elasticsearch.';

    protected SearchRepository $searchRepository;

    /**
     * MakeIndexCommand constructor.
     * @param SearchRepository $searchRepository
     */
    public function __construct(SearchRepository $searchRepository)
    {
        parent::__construct();
        $this->searchRepository = $searchRepository;
    }

    /**
     * @throws \App\Exceptions\ElasticsearchRepositoryException
     */
    public function handle()
    {
        $this->searchRepository->createIndex();
    }
}
