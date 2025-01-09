<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class NewsControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testStoreNews()
    {
        $user = User::create([
            'name' => 'Тестовый пользователь',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'author',
        ]);
        $this->actingAs($user);

        $categories = Category::create([
            'name' => 'Теннис'
        ]);

        $request = [
            'title' => 'Тест новый',
            'text' => 'Очень интересный текст',
            'category_id' => $categories->id,
        ];

        $response = $this->post(route('news.store'), $request);
        $response->assertRedirect(route('news.index'));

        $this->assertDatabaseHas('news', [
            'title' => 'Тест новый',
            'text' => 'Очень интересный текст',
            'category_id' => $categories->id,
        ]);
    }

    public function testUpdateNews()
    {
        $news = News::first();
        $this->assertNotNull($news, 'Новость не найдена');
        $author = User::where('id', $news->user_id)->first();
        $this->actingAs($author);
        $this->assertNotNull($author, 'Автора не знайдено');

        $request = [
            'title' => 'Привет!',
            'text' => 'Обновление',
            'category_id' => $news->category_id,
        ];

        $response = $this->put(route('news.update', $news->id), $request);
        $response->assertRedirect(route('news.index'));

        $this->assertDatabaseHas('news', [
            'id' => $news->id,
            'title' => 'Привет!',
            'text' => 'Обновление',
            'category_id' => $request['category_id'],
        ]);
    }

    public function testDestroyNews()
    {
        $news = News::first();
        $this->assertNotNull($news, 'Новость не найдена');

        $author = User::where('id', $news->user_id)->first();
        $this->actingAs($author);
        $this->assertNotNull($author, 'Автора не знайдено');

        $response = $this->delete(route('news.destroy', $news->id));
        $response->assertRedirect(route('news.index'));

        $this->assertDatabaseMissing('news', [
            'id' => $news->id,
        ]);
    }

    public function testCheckingAccessCreate()
    {
        $user = User::create([
            'name' => 'Ivan',
            'email' => 'ivan@example.com',
            'password' => bcrypt('password'),
        ]);
        $this->actingAs($user);
        $response = $this->post(route('news.store'), [
            'title' => 'Test',
            'text' => 'News',
            'category_id' => 1,
        ]);
        $response->assertStatus(403);
        $this->assertDatabaseMissing('news', [
            'title' => 'Test',
            'text' => 'News',
            'category_id' => 1,
        ]);
    }

    public function testCheckingAccessUpdate()
    {
        $user = User::create([
            'name' => 'Sergij',
            'email' => 'Serg@ukr.net',
            'password' => bcrypt('password'),
        ]);
        $this->actingAs($user);
        $news = News::first();
        $this->assertNotNull($news, 'Новость не найдена');

        $response = $this->put(route('news.update', $news->id), [
            'name' => 'Update',
            'text' => 'New content',
            'category' => $news->category_id,
        ]);
        $response->assertStatus(403);
    }

    public function testCheckingAccessDelete()
    {
        $user = User::create([
            'name' => 'Masha',
            'email' => 'Masha@ukr.net',
            'password' => bcrypt('password'),
        ]);
        $this->actingAs($user);
        $news = News::first();
        $this->assertNotNull($news, 'Новость не найдена');
        $response = $this->delete(route('news.destroy', $news->id));
        $response->assertStatus(403);
    }

}
