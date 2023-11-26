<?php

namespace App\Orchid\Screens\Post;

use App\Models\Post;
use App\Orchid\Screens\Link;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class PostTrashedEditScreen extends Screen
{
    /**
     * @param $id
     * @return array
     */
    public function query($id): array
    {
        return [
            'post' => Post::withTrashed()->findOrFail($id),
        ];
    }

    /**
     * The name is displayed on the user's screen and in the headers
     */
    public function name(): ?string
    {
        return 'Редактирование удаленного поста';
    }

    /**
     * Button commands.
     *
     * @return Link[]
     */
    public function commandBar(): array
    {
        return [

            Button::make('Востановить')
                ->icon('note')
                ->method('restore')
            ,

            Button::make('Удалить навсегда')
                ->icon('trash')
                ->method('forceDelete')
            ,
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                Input::make('post.title')
                    ->title('Заголовок')
                    ->placeholder('Напишите заголовок')
                    ->help('')
                    ->required(),

                Cropper::make('post.image')
                    ->title('Загрузите изображение для поста')
                    ->width(500)
                    ->height(500),

                TextArea::make('post.description')
                    ->title('Описание поста')
                    ->rows(3)
                    ->maxlength(200)
                    ->placeholder('')
                    ->required(),

                Quill::make('post.body')
                    ->title('Основной текст')
                    ->required(),
            ])
        ];
    }


    /**
     * @param $id
     * @return RedirectResponse
     */
    public function restore($id): RedirectResponse
    {
        $post = Post::withTrashed()->findOrFail($id);

        $post->restore();

        Alert::info('Пост востановлен.');

        return redirect()->route('platform.post.list');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function forceDelete($id): RedirectResponse
    {
        $post = Post::withTrashed()->findOrFail($id);

        $post->forceDelete();

        Alert::info('Пост удален навсегда.');

        return redirect()->route('platform.post.list');
    }
}
