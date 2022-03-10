<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\Http\Requests\InstagramRequest;
use App\Http\Requests\TwitterRequest;
use App\Services\SearchService;

class SearchController extends Controller
{
    private SearchService $service;

    public function __construct(SearchService $service)
    {
        $this->service = $service;
    }

    public function news(NewsRequest $request)
    {
        return $this->getResponse(__FUNCTION__, $request);
    }

    public function instagram(InstagramRequest $request)
    {
        return $this->getResponse(__FUNCTION__, $request);
    }

    public function twitter(TwitterRequest $request)
    {
        return $this->getResponse(__FUNCTION__, $request);
    }

    private function getResponse(string $type, $request)
    {
        $filter = 'findBy'.ucfirst($request->filter);

        return response()->json([
            'data' => $this->service->toArray($this->service->setType($type)->$filter($request->value))
        ]);
    }
}
