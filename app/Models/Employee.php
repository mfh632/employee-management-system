<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'secondary_phone',
        'father_name',
        'mother_name',
        'guardian_name',
        'guardian_phone',
        'blood_group',
        'religion',
        'gender',
        'birth_date',
        'marital_status',
        'spouse_name',
        'department_id',
        'designation_id',
        'status',
        'starting_date',
        'end_date',
        'basic',
        'house_rent',
        'medical_allowance',
        'transport',
        'festival_bonus',
        'image'
    ];

    public function decrement(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class);
    }

    public function qualification(): HasMany
    {
        return $this->hasMany(Qualification::class);
    }
}
