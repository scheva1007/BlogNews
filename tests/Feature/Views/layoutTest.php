<?php

namespace Tests\Feature\Views;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LayoutTest extends TestCase
{
    use DatabaseTransactions;

    public function testLayout()
    {
        $user = User::factory()->create();
        $category = Category::factory()->count(4)->create();

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee("Команда");
        $response->assertSee('Реєстрація');
        $response->assertSee('Вхід');
        $response->assertSee('Оберіть категорію');
        foreach ($categories as $category){
            $response->assertSee($category->name);
        }

        $this->actingAs($user);
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee("Команда");
        $response->assertSee('Кабінет');
        $response->assertSee('Вийти');
        $response->assertSee('Оберіть категорію');
        foreach ($categories as $category){
            $response->assertSee($category->name);
        }

        $author = User::factory()->create(['is_author' => true]);
        $this->actingAs($author);
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Команда');
        $response->assertSee('Додати новину');
        $response->assertSee('Кабінет');
        $response->assertSee('Вийти');
        $response->assertSee('Оберіть категорію');
        foreach ($categories as $category){
            $response->assertSee($category->name);
        }

        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Команда');
        $response->assertSee('Додати новину');
        $response->assertSee('Адмінпанель');
        $response->assertSee('Вийти');
        $response->assertSee('Оберіть категорію');
        foreach ($categories as $category){
            $response->assertSee($category->name);
        }
    }
}
