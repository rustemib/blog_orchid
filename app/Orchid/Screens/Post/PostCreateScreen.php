<?php

namespace App\Orchid\Screens\Post;

use App\Http\Requests\Post\PostStoreRequest;
use App\Models\Post;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class PostCreateScreen extends Screen
{
    /**
     * @var Post
     */
    protected Post $post;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Post $post): array
    {
        return [
            'post' => $post
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Создание поста';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Создать пост')
                ->icon('pencil')
                ->method('create')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
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
    public function create(Post $post, PostStoreRequest $request)
    {
        $post->user_id = auth()->id();
        $post->fill($request->get('post'))->save();

        $post->attachment()->syncWithoutDetaching(
            $request->input('post.attachment', [])
        );

        Alert::info('Пост создан успешно.');

        return redirect()->route('platform.post.list');
    }
}
