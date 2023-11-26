<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CommentStoreRequest;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentUpdateController extends Controller
{
    /**
     * @param CommentStoreRequest $request
     * @param Comment $comment
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(CommentStoreRequest $request, Comment $comment): RedirectResponse
    {
        $this->authorize('update', $comment);

        $comment->update($request->validated());

        $postId = $comment->post_id;

        return redirect()->route('post.show', $postId)
            ->with('success', 'Комментарий успешно обновлен');
    }
}
