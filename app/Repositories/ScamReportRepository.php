<?php

namespace App\Repositories;

use App\Models\ScamReport;
use Illuminate\Database\Eloquent\Collection;

class ScamReportRepository
{
    public function save(array $data): ScamReport
    {
        return ScamReport::create($data);
    }

    public function findAll(): Collection
    {
        return ScamReport::with('user')->get();
    }
    public function findById(int $id): ScamReport
    {
        return ScamReport::findOrFail($id);
    }
    public function query()
    {
        return ScamReport::query();
    }
}
