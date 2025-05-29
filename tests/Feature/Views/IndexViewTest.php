<?php

namespace Tests\Feature\Views;

use App\Models\News;
use App\Repositories\NewsRepository;
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
        $newsService = app(NewsService::class);
        $newsRepository = app(NewsRepository::class);
        $topNews = $newsRepository->get5MostViewedNews();
        $allNews = $newsRepository->findPublishedAndApprovedNews();
        $response -> assertSee('Популярні новини:');
        $response->assertSee('Останні новини');

        foreach($topNews as $item){
            $response -> assertSee($item->title);
        }
        $response -> assertSee('Переглянути всі новини');

        foreach($allNews as $item){
            $response -> assertSee($item->title);
        }
    }
}

