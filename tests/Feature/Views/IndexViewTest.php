<?php

namespace Tests\Feature\Views;

use App\Models\News;
use App\Services\NewsService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class IndexViewTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndexView()
    {
        $news = News::factory()->count(5)->create();
        $response = $this->get('/');
        $response -> assertStatus(200);
        $topNews = (new NewsService())->getLastNews();
        $allNews = $news->sortByDesc('created_at')->take(5);
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

