<?php

namespace App\Http\Controllers;

use App\Models\User;

class SubscriptionController extends Controller
{
    public function subscribe($authorId)
    {
        $user = auth()->user();
        if ($user->id == $authorId) {
            return redirect()->back()->with('error', 'Ви не можете підписатися на себе');
        }
        $user->subscriptions()->create([
            'author_id' => $authorId,
        ]);

        return redirect()->back()->with('success', 'Ви успішно підписалися на автора');
    }

    public function unsubscribe($authorId)
    {
        $user = auth()->user();

        $user->subscriptions()->where('author_id', $authorId)->delete();

        return redirect()->back()->with('success', 'Ви успішно відписалися від автора');
    }
}
