<?php

namespace App\Jobs;

use App\Industry;
use App\Scrapping\CompanyScrapping;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class IndustryParsing implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $industry;

    /**
     * Create a new job instance.
     *
     * @param Industry $industry
     */
    public function __construct(Industry $industry)
    {
        $this->industry = $industry;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $parsing = new CompanyScrapping();
        $parsing->scrapCompanies($this->industry);
    }
}
