<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuestionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
    */
    public function test_admin_can_create_question(): void
    {
        $this->createAdminUser();

        $questionCategoryResponse = $this->actingAs($this->user)->post(route('question-categories.store'), [
            'title' => "This is title",
            'slug' => "this-is-slug",
        ]);

        $questionCategoryResponse->assertStatus(201);

        $response = $this->actingAs($this->user)->post(route('questions.store'), [
            'title' => 'Sample Question',
            'category_id' => $questionCategoryResponse->json('data.id'),
            'slug' => 'sample-question',
            'description' => 'This is a sample question description.',
            'options' => ['Option A', 'Option B', 'Option C'],
            'answer' => 'Option A',
            'status' => 1,
            'weightage' => '10',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseCount('questions', 1);
    }


    /**
     * @return void
     */
    public function test_admin_can_view_list_of_questions(): void
    {
        $this->createAdminUser();

        $response = $this->actingAs($this->user)->get(route('questions.index'));

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function test_admin_can_get_question_when_given_id(): void
    {
        $this->createAdminUser();

        $questionCategoryResponse = $this->actingAs($this->user)->post(route('question-categories.store'), [
            'title' => "This is title",
            'slug' => "this-is-slug",
        ]);

        $response = $this->actingAs($this->user)->post(route('questions.store'), [
            'title' => 'Sample Question',
            'category_id' => $questionCategoryResponse->json('data.id'),
            'slug' => 'sample-question',
            'description' => 'This is a sample question description.',
            'options' => ['Option A', 'Option B', 'Option C'],
            'answer' => 'Option A',
            'status' => 1,
            'weightage' => '10',
        ]);

        $response = $this->actingAs($this->user)->get(route('questions.show', Question::first()));

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function test_admin_can_update_question(): void
    {
    $this->createAdminUser();

    $questionCategoryResponse = $this->actingAs($this->user)->post(route('question-categories.store'), [
        'title' => "This is title",
        'slug' => "this-is-slug",
    ]);

    $sampleQuestion = $this->actingAs($this->user)->post(route('questions.store'), [
        'title' => 'Sample Question',
        'category_id' => $questionCategoryResponse->json('data.id'),
        'slug' => 'sample-question',
        'description' => 'This is a sample question description.',
        'options' => ['Option A', 'Option B', 'Option C'],
        'answer' => 'Option A',
        'status' => 1,
        'weightage' => '10',
    ]);

    $response = $this->actingAs($this->user)->put(route('questions.update', Question::first()), [
        'title' => 'Update Question',
        'category_id' => $questionCategoryResponse->json('data.id'),
        'slug' => 'update-question',
        'description' => 'This is an updated question description.',
        'options' => ['Option A', 'Option B', 'Option C'],
        'answer' => 'Option A',
        'status' => 1,
        'weightage' => '10',
    ]);

    $response->assertStatus(200);

    $question=Question::first();

    $this->assertEquals('Update Question', $question->title);
    $this->assertEquals('update-question', $question->slug);
    }

    /**
    * @return void
    */
    public function test_admin_can_delete_question():void
    {
        $this->createAdminUser();

        $questionCategoryResponse = $this->actingAs($this->user)->post(route('question-categories.store'), [
            'title' => "This is title",
            'slug' => "this-is-slug",
        ]);

        $response = $this->actingAs($this->user)->post(route('questions.store'), [
            'title' => 'Sample Question',
            'category_id' => $questionCategoryResponse->json('data.id'),
            'slug' => 'sample-question',
            'description' => 'This is a sample question description.',
            'options' => ['Option A', 'Option B', 'Option C'],
            'answer' => 'Option A',
            'status' => 1,
            'weightage' => '10',
        ]);

        $response=$this->actingAs($this->user)->delete(route('questions.destroy',Question::first()));

        $response->assertStatus(204);

        $this->assertEquals(Question::count(),0);
    }

}

