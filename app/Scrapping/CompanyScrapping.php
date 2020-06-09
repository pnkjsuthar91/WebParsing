<?php


namespace App\Scrapping;


use App\Company;
use App\Industry;
use Illuminate\Support\Facades\Log;
use KubAT\PhpSimple\HtmlDomParser;

class CompanyScrapping
{
    use Parsing;

    public function scrapCompanies(Industry $industry)
    {
        $currentPage = 1;
        while ($currentPage < $this->lastPage + 1) {
            $url = $industry->url . '/page/' . $currentPage;
            $html = HtmlDomParser::file_get_html($url);
            foreach ($html->find('table.table-bordered tr') as $row) {
                try {
                    $rows = $row->find('td');
                    if (count($rows) != 4) {
                        continue;
                    }
                    $companyInfo = Company::firstOrNew(['cin' => $rows[0]->plaintext]);
                    $companyInfo->cin = $rows[0]->plaintext;
                    $companyInfo->company_name = $rows[1]->plaintext;
                    $companyInfo->company_url = $this->siteUrl . $rows[1]->find('a')[0]->href;
                    $companyInfo->class = $rows[2]->plaintext;
                    $companyInfo->status = $rows[3]->plaintext;
                    $companyInfo->industry_id = $industry->id;
                    $companyInfo->save();
                } catch (\Exception $exception) {
                    Log::error($exception);
                    continue;
                }
            }
            $currentPage++;
        }
    }

    public function scrapCompany(Company $company)
    {
        try {
            $html = HtmlDomParser::file_get_html($company->company_url);
            $tableRows = $html->find('#companyinformation table tr');
            $regNo = $tableRows[4]->find('td')[1]->plaintext;
            $category = $tableRows[5]->find('td')[1]->plaintext;
            $subCategory = $tableRows[6]->find('td')[1]->plaintext;
            $roc = $tableRows[8]->find('td')[1]->plaintext;
            $totalMembers = (int)$tableRows[9]->find('td')[1]->plaintext;

            $company->reg_no = $regNo;
            $company->category = $category;
            $company->sub_category = $subCategory;
            $company->roc_code = $roc;
            $company->total_members = $totalMembers;
            $company->save();
        } catch (\Exception $exception) {
            Log::error($exception);
        }
    }
}
