<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\View\View;

class CommentEditController extends Controller
{
    /**
     * @param Comment $comment
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Comment $comment): View
    {
        $this->authorize('update', $comment);

        return view('comments.edit', compact('comment'));
    }
}
