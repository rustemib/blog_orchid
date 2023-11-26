<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\View\View;

class PostShowController extends Controller
{
    /**
     * @param $id
     * @return View
     */
    public function show($id): View
    {
        $post = Post::findOrFail($id);

        $post->body = nl2br($post->body);

        $comments = $post->comments()->get();

        return view('posts.show', compact('post', 'comments'));
    }
}
