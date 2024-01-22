<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResultStoreRequest;
use App\Http\Resources\ResultResource;
use App\Models\Quiz;
use App\Http\Repositories\ResultRepository;
use Illuminate\Http\Request;

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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * @param ResultStoreRequest $request
     * @param Quiz $quiz
     * @return ResultResource
     */
    public function store(ResultStoreRequest $request, Quiz $quiz): ResultResource
    {
        $submittedAnswers = $request->input('answers', []);
        $userId = auth()->user()->id;
        $totalTime = $request->input('total_time', 0);

        $result = $this->resultRepository->store($userId, $quiz,$submittedAnswers, $totalTime);

        return new ResultResource($result);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
