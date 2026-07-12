<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;
use App\Enums\Gender;
use App\Models\PatientCase;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'dob',
        'address',
        'city',
        'state',
        'zip_code',
        'suite_no',
        'email',
        'home_phone_no',
        'work_phone_no',
        'cell_phone_no',
        'phone_extension',
        'emergency_contact',
        'ssn',
        'is_delivery_same_as_residential',
        'd_address',
        'd_suite',
        'd_city',
        'd_state',
        'd_zip_code',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'gender' => Gender::class,
        'dob' => 'date',
        'is_delivery_same_as_residential' => 'boolean',
    ];

    protected $appends = ['age', 'full_name'];

    // Relationships
    public function patientCases(): HasMany
    {
        return $this->hasMany(PatientCase::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Accessors
    public function getFullNameAttribute(): string
    {
        return trim(collect([$this->first_name, $this->middle_name, $this->last_name])
            ->filter()
            ->join(' '));
    }

    public function getAgeAttribute(): ?int
    {
        return $this->dob ? Carbon::parse($this->dob)->age : null;
    }
}