<?php

namespace App\Exceptions;


use Throwable;
use Exception;


/**
 * Class ElasticsearchRepositoryException
 * @package App\Exceptions\Elasticsearch
 */
class ElasticsearchRepositoryException extends Exception
{
	/**
	 * ElasticsearchRepositoryException constructor.
	 * @param string $message
	 * @param int $code
	 * @param Throwable|null $previous
	 */
	public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}
