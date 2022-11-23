<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Log;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class rss extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rss:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $url = 'http://static.feed.rbc.ru/rbc/logical/footer/news.rss';
        $response = Http::get($url);
        Log::create([
            'request_method' => 'get',
            'request_url' => $url,
            'response_http_code' => $response->status(),
            'response_body' => $response->body(),
        ]);

        $body = $response->body();
        $body = str_replace('rbc_news:', 'rbc_news', $body);

        $xmlObject = simplexml_load_string($body);
        $jsonFormatData = json_encode($xmlObject);
        $result = json_decode($jsonFormatData, true);

        foreach ($result['channel']['item'] as $item) {
            $el = [
                'title' => $item['title'],
                'link' => $item['link'],
                'description' => $item['description'],
                'pubDate' => $item['pubDate'],
            ];

            if (isset($item['author'])) {
                $el['author'] = $item['author'];
            }

            if (isset($item['rbc_newsimage'])) {
                $image = $item['rbc_newsimage'];
                isset($image['rbc_newsurl'])
                    ? $el['image'] = $image['rbc_newsurl']
                    : $el['image'] = $image[0]['rbc_newsurl'];
            }
            Article::firstOrCreate($el);

        }
        return Command::SUCCESS;
    }
}
