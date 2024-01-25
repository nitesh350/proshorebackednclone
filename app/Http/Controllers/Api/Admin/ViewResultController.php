<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Result;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ResultResource;
use App\Http\Requests\ResultFilterRequest;
use App\Http\Repositories\ResultRepository;

class ViewResultController extends Controller
{
    private ResultRepository $resultRepository;

    /**
     * @param  ResultRepository  $resultRepository
     */
    public function __construct(ResultRepository $resultRepository)
    {
        $this->resultRepository = $resultRepository;
    }

    public function __invoke(ResultFilterRequest $request)
    {
        $data = $request->validated();

        $results = $this->resultRepository->getFilteredResult($data);

        return ResultResource::collection($results);
    }
}
