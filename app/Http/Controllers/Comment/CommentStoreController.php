<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CommentStoreRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;

class CommentStoreController extends Controller
{
    /**
     * @param CommentStoreRequest $request
     * @param Post $post
     * @return RedirectResponse
     */
    public function store(CommentStoreRequest $request, Post $post): RedirectResponse
    {
        $validatedData = $request->validated();

        $validatedData['user_id'] = auth()->id();

        $post->comments()->create($validatedData);

        return back();
    }
}
