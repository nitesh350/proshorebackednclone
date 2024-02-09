<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminResultTest extends TestCase
{

    use RefreshDatabase;
    /**
     * Test to verify that admin can view list of result
     */
    public function test_admin_can_view_result(): void
    {
        $this->createAdminUser();

        $response = $this->actingAs($this->user)->get(route('results.index'));

        $response->assertStatus(200);
    }
}
