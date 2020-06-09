<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    protected $table = 'industries';

    protected $fillable = ['name', 'url'];

    public function companies()
    {
        return $this->hasMany(Company::class, 'industry_id');
    }
}
