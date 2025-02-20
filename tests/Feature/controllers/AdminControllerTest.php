<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\Notification;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testApprovedNews()
    {
        $author = User::create([
            'name' => 'Stepan',
            'email' => 'stepan@ukr.net',
            'password' => bcrypt('password'),
            'role' => 'author',
        ]);

        $admin = User::create([
            'name' => 'Igor',
            'email' => 'igor@ukr.net',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $news = News::create([
            'title' => 'One news',
            'text' => 'Цікава новина',
            'user_id' => $author->id,
            'category_id' => 2,
            'checked' => false,
            'approved' => false,
        ]);

        $subscriber1 = User::create([
            'name' => 'Petro',
            'email' => 'petro@ukr.net',
            'password' => bcrypt('password'),
        ]);

        $subscriber2 = User::create([
            'name' => 'Vjva',
            'email' => 'vova@ukr.net',
            'password' => bcrypt('password'),
        ]);

        Subscription::create([
            'author_id' => $author->id,
            'subscriber_id' => $subscriber1->id,
        ]);

        Subscription::create([
            'author_id' => $author->id,
            'subscriber_id' => $subscriber2->id,
        ]);

        $this->actingAs($admin);

        $response = $this->post(route('admin.approve', $news));

        $this->assertDatabaseHas('news', [
            'id' => $news->id,
            'checked' => true,
            'approved' => true,
        ]);

        $this->assertDatabaseHas('notifications', [
            'user_id' => $subscriber1->id,
            'news_id' => $news->id,
            'message_type' => 'subscription',
        ]);

        $this->assertDatabaseHas('notifications', [
            'user_id' => $subscriber2->id,
            'news_id' => $news->id,
            'message_type' => 'subscription',
        ]);

        $response->assertRedirect(route('admin.uncheckedNews'));
    }

    public function testRejectNews()
    {
        $admin = User::create([
            'name' => 'Igor',
            'email' => 'igor@ukr.net',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $author = User::create([
            'name' => 'Stepan',
            'email' => 'stepan@ukr.net',
            'password' => bcrypt('password'),
            'role' => 'author',
        ]);


        $news = News::create([
            'title' => 'One news',
            'text' => 'Цікава новина',
            'user_id' => $author->id,
            'category_id' => 2,
            'checked' => false,
            'approved' => false,
            'rejection_reason' => null,
        ]);

        $response = $this->post(route('admin.reject', $news), [
            'rejection_reason' => 'Мало інформації',
        ]);

        $this->assertDatabaseHas('news', [
            'id' => $news->id,
            'checked' => true,
            'approved' => false,
            'rejection_reason' => 'Мало інформації',
         ]);

        $response->assertRedirect(route('admin.uncheckedNews'));
    }
}
