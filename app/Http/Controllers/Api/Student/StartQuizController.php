<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Repositories\ResultRepository;
use App\Models\Quiz;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuizResource;
use App\Http\Repositories\QuestionRepository;
use Illuminate\Http\JsonResponse;

class StartQuizController extends Controller
{
    /**
     * @var QuestionRepository
     */
    protected QuestionRepository $questionRepository;

    /**
     * @var ResultRepository
     */
    private ResultRepository $resultRepository;

    /**
     * @param QuestionRepository $questionRepository
     * @param ResultRepository $resultRepository
     */
    public function __construct(QuestionRepository $questionRepository, ResultRepository $resultRepository)
    {
        $this->questionRepository = $questionRepository;
        $this->resultRepository = $resultRepository;
    }

    /**
     * @param Quiz $quiz
     * @return QuizResource|JsonResponse
     */
    public function __invoke(Quiz $quiz): QuizResource | JsonResponse
    {
        $user = auth()->user();

        $result = $user->results()->where('quiz_id', $quiz->id)->first();
        if($result && $result->passed){
            return response()->json([
                'message' => 'You\'ve already passed this quiz and cannot reattempt it.',
            ]);
        }
        if($result && !$result->passed){
            $retryDate = $result->created_at->addDays($quiz->retry_after);
            if(!now()->gte($retryDate)){
                return response()->json([
                    'message' => "You can reattempt this quiz after " . $retryDate->diffForHumans(),
                ]);
            }
        }

        $quiz->load('category');
        $question_categories = $quiz->questionCategories()->select("question_category_id")->pluck("question_category_id");
        $questionResource = $this->questionRepository->getQuizQuestions($question_categories);
        $this->resultRepository->store($quiz->id,$questionResource['data']['questions']?->count ?? 0);
        return (new QuizResource($quiz))->additional([
            'data' => [
                "questions" => $questionResource,
            ]
        ]);
    }
}
