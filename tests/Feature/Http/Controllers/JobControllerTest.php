<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\JobController
 */
final class JobControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $jobs = Job::factory()->count(3)->create();

        $response = $this->get(route('jobs.index'));

        $response->assertOk();
        $response->assertViewIs('job.index');
        $response->assertViewHas('jobs', $jobs);
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('jobs.create'));

        $response->assertOk();
        $response->assertViewIs('job.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\JobController::class,
            'store',
            \App\Http\Requests\JobStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $title = fake()->sentence(4);
        $description = fake()->text();
        $budget = fake()->numberBetween(-10000, 10000);
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->post(route('jobs.store'), [
            'title' => $title,
            'description' => $description,
            'budget' => $budget,
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $jobs = Job::query()
            ->where('title', $title)
            ->where('description', $description)
            ->where('budget', $budget)
            ->where('user_id', $user->id)
            ->where('category_id', $category->id)
            ->get();
        $this->assertCount(1, $jobs);
        $job = $jobs->first();

        $response->assertRedirect(route('jobs.index'));
        $response->assertSessionHas('job.id', $job->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $job = Job::factory()->create();

        $response = $this->get(route('jobs.show', $job));

        $response->assertOk();
        $response->assertViewIs('job.show');
        $response->assertViewHas('job', $job);
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $job = Job::factory()->create();

        $response = $this->get(route('jobs.edit', $job));

        $response->assertOk();
        $response->assertViewIs('job.edit');
        $response->assertViewHas('job', $job);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\JobController::class,
            'update',
            \App\Http\Requests\JobUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $job = Job::factory()->create();
        $title = fake()->sentence(4);
        $description = fake()->text();
        $budget = fake()->numberBetween(-10000, 10000);
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->put(route('jobs.update', $job), [
            'title' => $title,
            'description' => $description,
            'budget' => $budget,
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $job->refresh();

        $response->assertRedirect(route('jobs.index'));
        $response->assertSessionHas('job.id', $job->id);

        $this->assertEquals($title, $job->title);
        $this->assertEquals($description, $job->description);
        $this->assertEquals($budget, $job->budget);
        $this->assertEquals($user->id, $job->user_id);
        $this->assertEquals($category->id, $job->category_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $job = Job::factory()->create();

        $response = $this->delete(route('jobs.destroy', $job));

        $response->assertRedirect(route('jobs.index'));

        $this->assertModelMissing($job);
    }
}
