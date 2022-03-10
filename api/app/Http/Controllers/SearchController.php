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
        return $this->getResponse($request);
    }

    public function instagram(InstagramRequest $request)
    {
        return $this->getResponse($request);
    }

    public function twitter(TwitterRequest $request)
    {
        return $this->getResponse($request);
    }

    private function getResponse($request)
    {
        $filter = 'findBy'.ucfirst($request->filter);

        return response()->json([
            'date' => $this->service->toArray($this->service->setType(__FUNCTION__)->$filter($request->value))
        ]);
    }
}
