<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\JobController
 */
final class JobControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $user = User::factory()->create();

        // Napravi nekoliko oglasa (sa kategorijom) da view ima šta da prikaže
        Job::factory()->count(3)->create([
            'user_id' => $user->id,
            'category_id' => Category::factory(),
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('jobs.index'));

        $response->assertOk();
        $response->assertViewIs('job.index');
        $response->assertViewHas('jobs'); // ne forsiramo tačan collection instance
    }

    #[Test]
    public function create_displays_view(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('jobs.create'));

        $response->assertOk();
        $response->assertViewIs('job.create');
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        // Ne šaljemo user_id – controller treba da uzme auth()->id()
        $data = [
            'title' => fake()->sentence(4),
            'description' => fake()->text(),
            'budget' => fake()->numberBetween(100, 10000),
            'category_id' => $category->id,
        ];

        $response = $this
            ->actingAs($user)
            ->post(route('jobs.store'), $data);

        $response->assertRedirect(route('jobs.index'));
        $response->assertSessionHas('job.id');

        $job = Job::latest('id')->first();
        $this->assertNotNull($job);

        $this->assertDatabaseHas('job_posts', [
            'id' => $job->id,
            'title' => $data['title'],
            'description' => $data['description'],
            'budget' => $data['budget'],
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);
    }

    #[Test]
    public function show_displays_view(): void
    {
        $user = User::factory()->create();

        $job = Job::factory()->create([
            'user_id' => $user->id,
            'category_id' => Category::factory(),
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('jobs.show', $job));

        $response->assertOk();
        $response->assertViewIs('job.show');
        $response->assertViewHas('job', $job);
    }

    #[Test]
    public function edit_displays_view(): void
    {
        $user = User::factory()->create();

        $job = Job::factory()->create([
            'user_id' => $user->id,
            'category_id' => Category::factory(),
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('jobs.edit', $job));

        $response->assertOk();
        $response->assertViewIs('job.edit');
        $response->assertViewHas('job', $job);
    }

    #[Test]
    public function update_redirects_and_updates(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $job = Job::factory()->create([
            'user_id' => $user->id,
            'category_id' => Category::factory(),
        ]);

        // Ne šaljemo user_id – controller treba da zadrži auth korisnika
        $data = [
            'title' => fake()->sentence(4),
            'description' => fake()->text(),
            'budget' => fake()->numberBetween(100, 10000),
            'category_id' => $category->id,
        ];

        $response = $this
            ->actingAs($user)
            ->put(route('jobs.update', $job), $data);

        $response->assertRedirect(route('jobs.index'));
        $response->assertSessionHas('job.id');

        $job->refresh();

        $this->assertEquals($data['title'], $job->title);
        $this->assertEquals($data['description'], $job->description);
        $this->assertEquals($data['budget'], $job->budget);
        $this->assertEquals($data['category_id'], $job->category_id);
        $this->assertEquals($user->id, $job->user_id);
    }

    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $user = User::factory()->create();

        $job = Job::factory()->create([
            'user_id' => $user->id,
            'category_id' => Category::factory(),
        ]);

        $response = $this
            ->actingAs($user)
            ->delete(route('jobs.destroy', $job));

        $response->assertRedirect(route('jobs.index'));
        $this->assertModelMissing($job);
    }
}
