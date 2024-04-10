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
            'items_per_page' => 'numeric',
            'start_date' => 'string|required_with:end_date',
            'end_date' => 'string|required_with:start_date',
        ]);

        $itemsPerPage = $request->input('items_per_page') ?? 25;

        $query = Post::orderBy('published_date', 'desc');

        if ($request->has('start_date')){
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');

            $query = $query->whereBetween('published_date', [$start_date, $end_date]);
        }

        $posts = $query->simplePaginate($itemsPerPage);

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
