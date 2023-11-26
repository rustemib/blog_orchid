<?php

namespace App\Orchid\Layouts\Post;

use App\Models\Post;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PostTrashedListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'posts';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID'),
            TD::make('title', 'Заголовок удаленного поста')
                ->render(function (Post $post) {
                    return Link::make($post->title)
                        ->route('platform.post.trashed.edit', $post->id);
                }),

            TD::make('created_at', 'Создан')->alignRight(),
            TD::make('deleted_at', 'Удален')->alignRight(),
        ];
    }
}
