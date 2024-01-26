<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
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
    public function index(): AnonymousResourceCollection
    {
        $results = $this->resultRepository->getResult();

        return ResultResource::collection($results);
    }
}
