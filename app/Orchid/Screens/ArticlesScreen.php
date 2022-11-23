<?php

namespace App\Orchid\Screens;

use App\Models\Article;
use App\Orchid\Layouts\Examples\ChartBarExample;
use App\Orchid\Layouts\Examples\ChartLineExample;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ArticlesScreen extends Screen
{

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        $table = [];
        $articles = Article::take(100)->orderBy('created_at', 'desc')->get();
        foreach ($articles as $article) {
            $table[] = new Repository($article->getAttributes());
        }
//        dd($table);
        return ['table' => $table];

    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Articles screen';
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return 'Articles ';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [

        ];
    }

    /**
     * Views.
     *
     * @return string[]|\Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [


            Layout::table('table', [
                TD::make('image', 'image')
                    ->width('150')
                    ->render(function (Repository $model) { // Please use view('path')
                        if ($model->get('image')) {
                            return "<img src='{$model->get('image')}'
                              alt='sample'
                              class='mw-100 d-block img-fluid rounded-1 w-100'>
                            <span class='small text-muted mt-1 mb-0'># {$model->get('id')}</span>";}
                    }),


                TD::make('title', 'Title')
                    ->width(200),
                TD::make('description', 'Description')
                    ->width(300),
                TD::make('link', 'Link')
                    ->width(150),
                TD::make('pubDate', 'pubDate')
                    ->width(100),
                TD::make('author', 'author')
                    ->width(150),
            ]),


        ];
    }

}
