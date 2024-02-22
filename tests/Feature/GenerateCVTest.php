<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GenerateCVTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_student_can_generate_cv_when_authenticated_and_has_profile(): void
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
        ]);

        $profile = [
            'experience' => 'This is student experience.',
            'education' => 'This is student education.',
            'career' => 'This is student career.',
            'skills' => ['HTML', 'CSS', 'JavaScript', 'PHP', 'Laravel', 'MySql']
        ];

        $this->actingAs($user)->postJson(route('profile.store'), $profile);

        $response = $this->actingAs($user)->getJson(route('generate-cv'));

        Storage::assertExists(Str::after($response['cv'], '/localhost'));

        Storage::delete(Str::after($response['cv'], '/localhost'));

        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) => $json->has('cv')
                    ->whereType('cv', 'string')
            );
    }

    /**
     * @return void
     */
    public function test_student_cannot_generate_cv_without_profile(): void
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
        ]);

        $response = $this->actingAs($user)->getJson(route('generate-cv'));

        $response->assertStatus(503)
            ->assertJson(['message' => 'Please create profile to generate CV']);
    }

    /**
     * @return void
     */
    public function test_unauthenticated_student_cannot_generate_cv(): void
    {
        $response = $this->getJson(route('generate-cv'));

        $response->assertStatus(401)
            ->assertJson(["message" => "Unauthenticated."]);
    }
}
