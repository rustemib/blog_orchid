<?php

namespace App\Orchid\Screens\Comment;

use App\Models\Comment;
use App\Models\User;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class CommentListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'comment' => Comment::with('user', 'post')->paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Комментарии к постам';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            // Используйте Layout::table() для работы с объектами TD
            Layout::table('comment', [
                TD::make('comment.id', 'ID')
                    ->render(function ($comment) {
                        return "<a href='#'>{$comment->id}</a>";
                    }),
                TD::make('post.title', 'Название поста')
                    ->render(function ($comment) {
                        return optional($comment->post)->title;
                    }),
                TD::make('user.name', 'Имя пользователя')
                    ->render(function ($comment) {
                        return optional($comment->user)->name;
                    })->alignLeft(),

                TD::make('comment.body', 'Body')
                    ->render(function ($comment) {
                        return $comment->body;
                    }),
            ])
        ];
    }
}
