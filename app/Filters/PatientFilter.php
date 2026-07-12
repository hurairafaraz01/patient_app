<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class PatientFilter
{
    public function apply(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['patient_id'] ?? null, function ($q, $id) {
                $q->where('id', $id);
            })

            ->when($filters['name'] ?? null, function ($q, $name) {
                $q->where(function ($q) use ($name) {
                    $q->where('first_name', 'like', "%$name%")
                        ->orWhere('middle_name', 'like', "%$name%")
                        ->orWhere('last_name', 'like', "%$name%");
                });
            })

            ->when($filters['dob'] ?? null, fn($q, $dob) =>
                $q->whereDate('dob', $dob)
            )

            ->when($filters['phone'] ?? null, function ($q, $phone) {
                $q->where(function ($q) use ($phone) {
                    $q->where('cell_phone_no', 'like', "%$phone%")
                      ->orWhere('home_phone_no', 'like', "%$phone%");
                });
            })

            ->when($filters['email'] ?? null, fn($q, $email) =>
                $q->where('email', 'like', "%$email%")
            )

            ->when($filters['ssn'] ?? null, fn($q, $ssn) =>
                $q->where('ssn', $ssn)
            )

            ->when($filters['created_by'] ?? null, fn($q, $role) =>
                $q->whereHas('createdBy', fn($user) => 
                 $user->where('role', $role)
                 )
            )

            ->when($filters['updated_by'] ?? null, fn($q, $role) =>
                $q->whereHas('updatedBy', fn($user) =>
                $user->where('role', $role))
            )

            ->when($filters['created_at'] ?? null, fn($q, $date) =>
                $q->whereDate('created_at', $date)
            )

            ->when($filters['updated_at'] ?? null, fn($q, $date) =>
                $q->whereDate('updated_at', $date)
            );
    }
}