<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class PatientCaseFilter
{
    public function apply(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['patient_id'] ?? null, fn($q, $id) =>
                $q->where('patient_id', $id)
            )
            ->when($filters['case_type_id'] ?? null, fn($q, $id) =>
                $q->where('case_type_id', $id)
            )
            ->when($filters['case_manager_id'] ?? null, fn($q, $id) =>
                $q->where('case_manager_id', $id)
            )
            ->when($filters['provider_id'] ?? null, fn($q, $id) =>
                $q->where('provider_id', $id)
            )
            ->when($filters['claim_number'] ?? null, fn($q, $claim) =>
                $q->where('claim_number', 'like', "%$claim%")
            )
            ->when($filters['doa'] ?? null, fn($q, $date) =>
                $q->whereDate('doa', $date)
            );
    }
}