<?php


namespace App\Scrapping;


use App\Industry;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use KubAT\PhpSimple\HtmlDomParser;

class IndustryScrapping
{
    use Parsing;

    public function scrap()
    {
        try {
            if (Cache::has('industry_page')) {
                $html = Cache::get('industry_page');
                $dom = HtmlDomParser::str_get_html($html);
            } else {
                $html = HtmlDomParser::file_get_html($this->siteUrl . 'industry');
                $dom = Cache::put('industry_page', (string)$html);
            }
            foreach ($dom->find('li.list-group-item a') as $li) {
                Industry::insert(['name' => $li->plaintext, 'url' => $this->siteUrl . $li->href]);
            }
        } catch (\Exception $exception) {
            Log::error($exception);
        }
        return Industry::all();
    }
}
