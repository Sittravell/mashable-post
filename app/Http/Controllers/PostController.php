<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'page' => 'numeric',
            'itemsPerPage' => 'numeric',
        ]);

        $itemsPerPage = $request->input('itemsPerPage') ?? 25;

        $posts = Post::orderBy('published_date', 'desc')
                     ->simplePaginate($itemsPerPage);


        return responder()->success($posts)->respond();
    }

    public function store(Request $request)
    {
        $request->validate([
            'posts' => 'required|array',
            'posts.*.title' => 'string',
            'posts.*.published_date' => 'string',
            'posts.*.link' => 'string',
        ]);

        $posts = $request->input('posts');

        Post::upsert(
            $posts,
            uniqueBy: ['link'],
            update: ['title', 'published_date'],
        );

        return responder()->success()->respond();
    }
}
