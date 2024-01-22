<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ResultRepository;
use App\Http\Requests\SubmitQuizStoreRequest;
use App\Http\Resources\ResultResource;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Result;
use Illuminate\Http\Request;

class SubmitQuizController extends Controller
{
    protected ResultRepository $resultRepository;

    public function __construct(ResultRepository $resultRepository)
    {
        $this->resultRepository = $resultRepository;
    }
    /**
     * @param Quiz $quiz
     * @param SubmitQuizStoreRequest $request
     * @return ResultResource
     */
    public function __invoke(Quiz $quiz, SubmitQuizStoreRequest $request):ResultResource
    {
        $data = $request->validated();
        $userId = auth()->user()->id;
        $answers = $data['answers'];

        $result = $this->resultRepository->calculateAndCreateResult($quiz, $userId, $answers, $data);

        return new ResultResource($result);
    }
}
