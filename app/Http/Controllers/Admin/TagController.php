<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function create ()
    {
        $tag = Tag::all();

        return view('tag.create', compact('tag'));
    }

    public function store (Request $request)
    {
        Tag::create([
            'name' => $request->name
        ]);

        return redirect()->route('admin.index');
    }
}
