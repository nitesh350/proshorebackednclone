<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuizCategory;
use App\Http\Resources\QuizCategoryResource;
use App\Http\Requests\QuizCategoryStoreRequest;
use App\Http\Requests\QuizCategoryUpdateRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class QuizCategoryController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $quizCategories = QuizCategory::paginate(10);
        return QuizCategoryResource::collection($quizCategories);
    }

    /**
     * @param QuizCategoryStoreRequest $request
     * @return QuizCategoryResource
     */
    public function store(QuizCategoryStoreRequest $request): QuizCategoryResource
    {
        $data = $request->validated();
        $quizCategory = QuizCategory::create($data);
        return new QuizCategoryResource($quizCategory);
    }

    /**
     * @param QuizCategory $quizCategory
     * @return QuizCategoryResource
     */
    public function show(QuizCategory $quizCategory): QuizCategoryResource
    {
        return new QuizCategoryResource($quizCategory);
    }

    /**
     * @param QuizCategoryUpdateRequest $request
     * @param QuizCategory $quizCategory
     * @return QuizCategoryResource
     */
    public function update(QuizCategoryUpdateRequest $request, QuizCategory $quizCategory): QuizCategoryResource
    {
        $data = $request->validated();
        $quizCategory->update($data);
        return new QuizCategoryResource($quizCategory);
    }

    /**
     * @param QuizCategory $quizCategory
     * @return void
     */
    public function destroy(QuizCategory $quizCategory): QuizCategoryResource
    {
        $quizCategory->delete();
        return response()->noContent();
    }
}
