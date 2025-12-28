<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CategoryController
 */
final class CategoryControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $user = User::factory()->create();
        Category::factory()->count(3)->create();

        $response = $this
            ->actingAs($user)
            ->get(route('categories.index'));

        $response->assertOk();
        $response->assertViewIs('category.index');
        $response->assertViewHas('categories');
    }

    #[Test]
    public function create_displays_view(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('categories.create'));

        $response->assertOk();
        $response->assertViewIs('category.create');
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $user = User::factory()->create();

        $data = [
            'name' => fake()->words(2, true),
        ];

        $response = $this
            ->actingAs($user)
            ->post(route('categories.store'), $data);

        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('category.id');

        $this->assertDatabaseHas('categories', [
            'name' => $data['name'],
        ]);
    }

    #[Test]
    public function show_displays_view(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('categories.show', $category));

        $response->assertOk();
        $response->assertViewIs('category.show');
        $response->assertViewHas('category', $category);
    }

    #[Test]
    public function edit_displays_view(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('categories.edit', $category));

        $response->assertOk();
        $response->assertViewIs('category.edit');
        $response->assertViewHas('category', $category);
    }

    #[Test]
    public function update_redirects_and_updates(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $data = [
            'name' => fake()->words(2, true),
        ];

        $response = $this
            ->actingAs($user)
            ->put(route('categories.update', $category), $data);

        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('category.id');

        $category->refresh();
        $this->assertEquals($data['name'], $category->name);
    }

    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete(route('categories.destroy', $category));

        $response->assertRedirect(route('categories.index'));
        $this->assertModelMissing($category);
    }
}
