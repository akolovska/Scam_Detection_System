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
        return ScamReport::with(['user', 'category'])->get();
    }
    public function findById($id): ScamReport
    {
        return ScamReport::with('category')->findOrFail($id);
    }
    public function query()
    {
        return ScamReport::query();
    }
    public function updateStatus(int $id, array $data): ScamReport
    {
        $report = ScamReport::findOrFail($id);

        $report->update($data);

        return $report;
    }
    public function delete(int $id): void
    {
        ScamReport::findOrFail($id)->delete();
    }
}
