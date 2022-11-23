<?php

namespace App\Orchid\Screens;

use App\Models\Article;
use App\Models\Log;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class LogsScreen extends Screen
{

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        $table = [];
        $logs = Log::take(100)->orderBy('created_at', 'desc')->get();
        foreach ($logs as $log) {
            $table[] = new Repository($log->getAttributes());
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
        return 'Logs screen';
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return 'Logs ';
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

                TD::make('created_at', 'created_at')
                    ->width(200),
                TD::make('request_method', 'method')
                    ->width(10),

                TD::make('request_url', 'request_url')
                    ->width(350),
                TD::make('response_http_code', 'response_http_code')
                    ->width(10),
                TD::make('response_body', 'response_body')
                    ->render(fn(Repository $model) => "<textarea class='w-100'> {$model->get('response_body')}</textarea>"),

            ]),


        ];
    }

}
