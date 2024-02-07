<?php
use App\Models\Quiz;
use App\Models\QuizCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;
use App\Models\Result;

class StudentApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_list_of_students(): void
    {
        $this->createAdminUser();

        $response = $this->actingAs($this->user)->get(route('students.index'));

        $response->assertStatus(200);
    }

    public function test_admin_can_view_student_details_with_student_id(): void
    {
        $this->createAdminUser();

        $user = User::factory()->create(['user_type'=>'student']);
        $profile = Profile::factory()->create([
            'user_id' => $user->id
        ]);
        $quizCategory = QuizCategory::factory()->create();
        
        $quiz = Quiz::factory()->create([
            'id' => 1
        ]);
        $result = Result::factory()->create([
            'user_id' => $user->id, 'quiz_id' => $quiz->id
        ]);

        $response = $this->actingAs($this->user)->getJson(route('students.show', $user));

        $response->assertStatus(200)

            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'profile' => [
                        'education',
                        'skills',
                        'experience',
                        'career',
                        'avatar_url',
                    ],
                    'results' => [
                        '*' => [
                            'quiz_id',
                            'passed',
                            'total_question',
                            'total_answered',
                            'total_right_answer',
                            'total_time',
                        ],
                    ],
                ],
            ])

            ->assertJson([
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->user_type,
                    'profile' => [
                        'education' => $profile->education,
                        'skills' => json_decode($profile->skills),
                        'experience' => $profile->experience,
                        'career' => $profile->career,
                        'avatar_url' => asset($profile->avatar),
                    ],
                    'results' => [
                        [
                            'quiz_id' => $result->quiz_id,
                            'passed' => $result->passed,
                            'total_question' => $result->total_question,
                            'total_answered' => $result->total_answered,
                            'total_right_answer' => $result->total_right_answer,
                            'total_time' => $result->total_time,
                        ],
                    ],
                ],
            ]);

    }
}