<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\QuestionCategory;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImportQuestionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test import questions endpoint.
     *
     * @return void
     */
    public function testImportQuestions()
    {
        $this->createAdminUser();
        
        $file = UploadedFile::fake()->create('questions.xlsx');

        Excel::fake();
        $response = $this->actingAs($this->user)->post('api/admin/import-questions', [
            'file' => $file,
        ]);

        Excel::assertImported('questions.xlsx');

    
     $response->assertStatus(200);

       $response->assertJson(['message' => 'Questions imported successfully']);
     }
}
