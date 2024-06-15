<?php

namespace Tests\Feature\Views;

use App\Models\News;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class IndexViewTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndexView()
    {
        $news = News::factory()->count(15)->create();
        $response = $this->get('/');
        $response -> assertStatus(200);
        $topNews = $news->sortByDesc('views')->take(5);
        $allNews = $news->sortByDesc('created_at');
        $response -> assertSee('ТОП-5 новин:');

        foreach($topNews as $item){
        $response -> assertSee($item->title);
    }
        $response -> assertSee('Список новин');

        foreach($allNews as $item){
            $response -> assertSee($item->title);
        }
    }
}

