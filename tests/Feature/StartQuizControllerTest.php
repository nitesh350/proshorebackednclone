<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;
use App\Models\QuizCategory;
use App\Models\Quiz;
use App\Models\Result;
use Illuminate\Testing\Fluent\AssertableJson;

class StartQuizControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @return void
     */
    public function test_authenticated_student_can_attempt_quiz(): void
    {
        $user = User::factory()->create();

        $quizCategory = QuizCategory::factory()->create();
        $quiz = Quiz::factory()->create([
            'category_id' => $quizCategory
        ]);

        $response = $this->actingAs($user)->get(route('start-quiz', $quiz));
        Storage::delete($quiz->thumbnail);
        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) => $json->has('data')
                    ->first(
                        fn (AssertableJson $json) => $json->where('id', $quiz->id)
                            ->where('title', $quiz->title)
                            ->where('slug', $quiz->slug)
                            ->where('thumbnail', asset($quiz->thumbnail))
                            ->where('description', $quiz->description)
                            ->where('time', $quiz->time)
                            ->where('retry_after', $quiz->retry_after)
                            ->where('status', $quiz->status)
                            ->where('pass_percentage', $quiz->pass_percentage)
                            ->has(
                                'category',
                                fn (AssertableJson $json) => $json->where('id', $quizCategory->id)
                                    ->where('title', $quizCategory->title)
                                    ->where('slug', $quizCategory->slug)
                            )
                            ->etc()
                    )
            );
    }

    /**
     * @return void
     */
    public function test_unauthenticated_student_cannnot_attempt_quiz(): void
    {
        $quizCategory = QuizCategory::factory()->create();
        $quiz = Quiz::factory()->create([
            'category_id' => $quizCategory
        ]);
        Storage::delete($quiz->thumbnail);
        $response = $this->get(route('start-quiz', $quiz));

        $response->assertStatus(302);
    }

    public function test_passed_quiz_cannot_be_reattempted()
    {
        $user = User::factory()->create();
        $quizCategory = QuizCategory::factory()->create();
        $quiz = Quiz::factory()->create([
            'category_id' => $quizCategory,
            'retry_after' => 2
        ]);
        Storage::delete($quiz->thumbnail);
        Result::factory()->create([
            'user_id' => $user->id,
            'quiz_id' => $quiz->id,
            'passed' => true,
            'created_at' => now()->subDays(6),
        ]);

        $response = $this->actingAs($user)
            ->get(route('start-quiz', $quiz));

        $response->assertJson([
            'message' => "You've already passed this quiz and cannot reattempt it.",
        ]);
    }

    public function test_failed_quiz_can_be_reattempted_after_retry_period()
    {
        $user = User::factory()->create();
        $quizCategory = QuizCategory::factory()->create();
        $quiz = Quiz::factory()->create([
            'retry_after' => 5,
            'category_id' => $quizCategory
        ]);
        Storage::delete($quiz->thumbnail);
        Result::factory()->create([
            'user_id' => $user->id,
            'quiz_id' => $quiz->id,
            'passed' => false,
            'created_at' => now()->subDays(6),
        ]);

        $response = $this->actingAs($user)
            ->get(route('start-quiz', $quiz));

        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) => $json->has('data')
                    ->first(
                        fn (AssertableJson $json) => $json->where('id', $quiz->id)
                            ->where('title', $quiz->title)
                            ->where('slug', $quiz->slug)
                            ->where('thumbnail', asset($quiz->thumbnail))
                            ->where('description', $quiz->description)
                            ->where('time', $quiz->time)
                            ->where('retry_after', $quiz->retry_after)
                            ->where('status', $quiz->status)
                            ->where('pass_percentage', $quiz->pass_percentage)
                            ->has(
                                'category',
                                fn (AssertableJson $json) => $json->where('id', $quizCategory->id)
                                    ->where('title', $quizCategory->title)
                                    ->where('slug', $quizCategory->slug)
                            )
                            ->etc()
                    )
            );
    }

    public function test_failed_quiz_cannot_be_reattempted_before_retry_period()
    {
        $user = User::factory()->create();
        $quizCategory = QuizCategory::factory()->create();
        $quiz = Quiz::factory()->create([
            'retry_after' => 5,
            'category_id' => $quizCategory
        ]);
        Storage::delete($quiz->thumbnail);
        
        $result = Result::factory()->create([
            'user_id' => $user->id,
            'quiz_id' => $quiz->id,
            'passed' => false,
            'created_at' => now()->subDays(4),
        ]);

        $response = $this->actingAs($user)
            ->get(route('start-quiz', $quiz));

        $response->assertJsonFragment([
            'message' => "You can reattempt this quiz after " . $result->created_at->addDays($quiz->retry_after)->diffForHumans(),
        ]);
    }
}
