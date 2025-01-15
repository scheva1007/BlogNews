<?php

namespace App\Http\Controllers;

use App\Models\User;

class SubscriptionController extends Controller
{
    public function subscribe(User $author)
    {
        $user = auth()->user();
        if ($user->id == $author->id) {

            return redirect()->back()->with('error', 'Ви не можете підписатися на себе');
        }

        $user->subscriptions()->create([
            'author_id' => $author->id,
        ]);

        return redirect()->back()->with('success', 'Ви успішно підписалися на автора');
    }

    public function unsubscribe(User $author)
    {
        $user = auth()->user();

        $user->subscriptions()->where('author_id', $author->id)->delete();

        return redirect()->back()->with('success', 'Ви успішно відписалися від автора');
    }
}
