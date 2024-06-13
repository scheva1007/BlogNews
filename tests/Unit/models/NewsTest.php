<?php

namespace Tests\Unit\models;

use App\Models\Comment;
use App\Models\News;
use App\Models\Rating;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Monolog\Test\TestCase;

class NewsTest extends TestCase
{
    use DatabaseTransactions;

    public function testNewsHasManyComment()
    {
        $news = News::factory()->create();
        $comment = Comment::factory()->create(['news_id' => $news->id]);

        $this->assertTrue($news->comment->contains($comment));
    }

    public function testNewsBelongsToManyTags()
    {
        $news = News::factory()->create();
        $tag = Tag::factory()->create();
        $news->tags()->attach($tag->id);

        $this->assertTrue($news->tags->contains($tag));
    }

    public function testNewsHasManyRating()
    {
        $news = News::factory()->create();
        $rating = Rating::factory()->create(['news_id' => $news->id]);

        $this->assertTrue($news->rating->contains($rating));
    }

    public function testFormattedDateAttribute()
    {
        $news = News::factory()->create(['created_at' => now()]);
        $expectedDate = now()->format('d.m.Y, H:m');

        $this->assertEquals($expectedDate, $news->formatted_date);
    }

    public function testCommentCountAttribute()
    {
        $news = News::factory()->create();
        Comment::factory()->count(3)->create(['news_id' => $news->id]);

        $this->assertEquals(3, $news->comment_count);
    }

    public function testUserRating()
    {
        $news = News::factory()->create();
        $user = User::factory()->create();
        $rating = Rating::factory()->create(['news_id' => $news->id, 'user_id' => $user->id, 'grade' => 5]);

        $this->actingAs($user);
        $this->assertEquals(5, $news->userRating());
    }
}
