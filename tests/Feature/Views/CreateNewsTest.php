<?php

namespace Tests\Feature\Views;

use App\Models\Category;
use App\Models\News;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateNewsTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreateNews()
    {
        $author = User::factory()->create(['role' => 'author']);
        $categories = Category::factory()->count(4)->create();
        $tags = Tag::factory()->count(5)->create();
        $this->actingAs($author);
        $response = $this->get('/news/create');
        $response->assertStatus(200);
        $response->assertSee('Заголовок');
        $response->assertSee('Контент');
        $response->assertSee('Фото');
        $response->assertSee('Категорія');
        $response->assertSee('Тег');
        $response->assertSee('Створити');

        foreach ($categories as $category) {
            $response->assertSee($category->name);
        }

        foreach ($tags as $tag) {
            $response->assertSee($tag->name);
        }
    }

    public function testJustUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/news/create');
        $response->assertStatus(403);
    }

//    public function testUnauthenticatedUser()
//    {
//        $response = $this->get('/news/create');
//        $response->assertRedirect(route('login'));
//    }
//
}
