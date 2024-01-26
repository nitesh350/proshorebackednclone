<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResultFilterRequest;
use App\Http\Resources\ResultResource;
use App\Http\Repositories\ResultRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ResultController extends Controller
{
    /**
     * @var ResultRepository
     */
    private ResultRepository $resultRepository;

    /**
     * @param  ResultRepository  $resultRepository
     */
    public function __construct(ResultRepository $resultRepository)
    {
        $this->resultRepository = $resultRepository;
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index(ResultFilterRequest $request): AnonymousResourceCollection
    {
        $data = $request->validated();
        $results = $this->resultRepository->getFilteredResult($data);

        return ResultResource::collection($results);
    }
}
