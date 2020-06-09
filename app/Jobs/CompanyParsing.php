<?php

namespace App\Jobs;

use App\Scrapping\CompanyScrapping;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CompanyParsing implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $companies;

    /**
     * Create a new job instance.
     *
     * @param Collection $companies
     */
    public function __construct(Collection $companies)
    {
        $this->companies = $companies;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $parsing = new CompanyScrapping();
        foreach ($this->companies as $company) {
            $parsing->scrapCompany($company);
        }
    }
}
