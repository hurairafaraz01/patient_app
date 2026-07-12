<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientCase extends Model
{
    use SoftDeletes;

    protected $table = 'patient_cases';

    protected $fillable = [
        'patient_id',
        'case_type_id',
        'case_manager_id',
        'provider_id',
        'visit_type',
        'doa',
        'insurance_name',
        'claim_number',
        'policy_number',
        'wcb_number',
        'referring_office',
        'attorney_name',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'doa' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function caseType()
    {
        return $this->belongsTo(CaseType::class);
    }

    public function caseManager()
    {
        return $this->belongsTo(CaseManager::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}