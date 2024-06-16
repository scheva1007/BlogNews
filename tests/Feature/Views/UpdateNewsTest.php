<?php

namespace Tests\Feature\Views;

use App\Models\Category;
use App\Models\News;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UpdateNewsTest extends TestCase
{
    use DatabaseTransactions;

    public function testUpdateNews()
    {
        $author = User::factory()->create(['role' => 'author']);
        $categories = Category::factory()->count(4)->create();
        $tags = Tag::factory()->count(4)->create();
        $news = News::factory()->create([
            'user_id' => $author->id,
            ]
        );
        $news->tags()->attach($tags->pluck('id'));
        $this->actingAs($author);
        $response = $this->get(route('news.edit', $news->id));
        $response->assertStatus(200);
        $response->assertSee('Заголовок');
        $response->assertSee($news->title);
        $response->assertSee('Контент');
        $response->assertSee($news->content);
        $response->assertSee('Категорія');
        foreach ($categories as $category){
            $response->assertSee($category->name);
        }
        $response->assertSee('Теги');
        foreach ($tags as $tag){
            $response->assertSee($tag->name);
        }
        $response->assertSee('Зображення');
        $response->assertSee('Зберегти');
    }
}
