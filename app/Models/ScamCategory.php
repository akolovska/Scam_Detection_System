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
        return $this->hasMany(ScamReport::class, 'category_id');
    }
}
