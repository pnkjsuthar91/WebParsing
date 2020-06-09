<?php

namespace App\Console\Commands;

use App\Company;
use App\Industry;
use App\Jobs\CompanyParsing;
use App\Jobs\IndustryParsing;
use App\Scrapping\IndustryScrapping;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class WebParsing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'web:parsing {--industry_id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command which will parse the given website and collect all the company related information and store it in a database. This will collect maximum information of company like CIN, industry, class AND ALL THE FIELDS WHICH IS available on the website.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * Web parsing data from defined URL
     * @return mixed
     */
    public function handle()
    {
        $industryId = $this->option('industry_id');
        if ($industryId) {
            Company::whereIndustryId($industryId)->chunk(1000, function ($companies) {
                CompanyParsing::dispatch($companies);
            });
        } else {
            $industries = $this->getIndustries();
            foreach ($industries as $industry) {
                IndustryParsing::dispatch($industry);
            }
        }
    }

    /**
     * @return Industry[]|\Illuminate\Database\Eloquent\Collection
     * Get a list of all industries from db or by web parsing
     */
    private function getIndustries()
    {
        $industries = Industry::all();
        if (count($industries) > 0) {
            return $industries;
        }
        $industryParsing = new IndustryScrapping();
        return $industryParsing->scrap();
    }
}
