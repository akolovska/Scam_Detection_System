<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScamCategory extends Model
{
    protected $fillable = [
        'id',
        'name',
        'description',
    ];
    public function reports()
    {
        return $this->belongsToMany(
            ScamReport::class,
            'scam_report_categories'
        );
    }
}
