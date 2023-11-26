<?php

namespace App\Orchid\Screens\Post;

use App\Http\Requests\Post\PostUpdateRequest;
use App\Models\Post;
use App\Orchid\Screens\Link;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class PostEditScreen extends Screen
{
    /**
     * @var Post
     */
    public $post;

    /**
     * Query data.
     *
     * @param Post $post
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
     * The name is displayed on the user's screen and in the headers
     */
    public function name(): ?string
    {
        return 'Редактирование поста';
    }

    /**
     * Button commands.
     *
     * @return Link[]
     */
    public function commandBar(): array
    {
        return [

            Button::make('Обновить')
                ->icon('note')
                ->method('update')
                ->canSee($this->post->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->post->exists),
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
     * @param Post $post
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Post $post, PostUpdateRequest $request): RedirectResponse
    {
        $post->fill($request->get('post'))->save();

        $post->attachment()->syncWithoutDetaching(
            $request->input('post.attachment', [])
        );

        Alert::info('Пост обновлен.');

        return redirect()->route('platform.post.list');
    }
    /**
     * @param Post $post
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Post $post): RedirectResponse
    {
        $post->delete();

        Alert::info('Пост перемещен в удаленые посты.');

        return redirect()->route('platform.post.list');
    }
}
