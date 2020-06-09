<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';

    protected $fillable = ['cin', 'company_name', 'company_url', 'class', 'status'];

    public function industry()
    {
        return $this->belongsTo(Industry::class, 'industry_id');
    }
}
