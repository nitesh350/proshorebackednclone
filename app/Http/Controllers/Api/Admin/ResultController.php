<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Result;
use App\Http\Controllers\Controller;
use App\Http\Resources\ResultResource;
use App\Http\Requests\ResultFilterRequest;
use App\Http\Repositories\ResultRepository;

class ResultController extends Controller
{
    private ResultRepository $resultRepository;

    /**
     * @param  ResultRepository  $resultRepository
     */
    public function __construct(ResultRepository $resultRepository)
    {
        $this->resultRepository = $resultRepository;
    }

    public function index()
    {
        $results = $this->resultRepository->getResult($data);

        return ResultResource::collection($results);
    }

    public function show($)
}
