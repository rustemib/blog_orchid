<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\View\View;

class PostIndexController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $posts = Post::orderByDesc('created_at')
            ->paginate(7);

        return view('posts.index', compact('posts'));

    }
}
