<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_job(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->post('/jobs', [
            'title' => 'Test oglas',
            'description' => 'Opis test oglasa',
            'budget' => 100,
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);

        $response->assertRedirect('/jobs');

        // ako ti je tabela "jobs", promeni u 'jobs'
        $this->assertDatabaseHas('job_posts', [
            'title' => 'Test oglas',
        ]);
    }
}
