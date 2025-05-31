<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{

    const STATUS_ACTIVE = true;
    const STATUS_DEACTIVE = false;

    const STATUS_ARRAY = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_DEACTIVE => 'Deactive'
    ];

    const MARITAL_STATUS_MARRIED = 'married';
    const MARITAL_STATUS_SINGLE = 'single';
    const MARITAL_STATUS_ARRAY = [
        self::MARITAL_STATUS_MARRIED => 'Married',
        self::MARITAL_STATUS_SINGLE => 'Single'
    ];

    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';
    const GENDER_ARRAY = [
        self::GENDER_MALE => 'Male',
        self::GENDER_FEMALE => 'Female'
    ];

    const BLOOD_GROUP_A_POSITIVE = 'A+';
    const BLOOD_GROUP_A_NEGATIVE = 'A-';
    const BLOOD_GROUP_B_POSITIVE = 'B+';
    const BLOOD_GROUP_B_NEGATIVE = 'B-';
    const BLOOD_GROUP_O_POSITIVE = 'O+';
    const BLOOD_GROUP_O_NEGATIVE = 'O-';
    const BLOOD_GROUP_AB_POSITIVE = 'AB+';
    const BLOOD_GROUP_AB_NEGATIVE = 'AB-';

    const BLOOD_GROUP_ARRAY = [
        self::BLOOD_GROUP_A_POSITIVE => 'A+',
        self::BLOOD_GROUP_A_NEGATIVE => 'A-',
        self::BLOOD_GROUP_B_POSITIVE => 'B+',
        self::BLOOD_GROUP_B_NEGATIVE => 'B-',
        self::BLOOD_GROUP_O_POSITIVE => 'O+',
        self::BLOOD_GROUP_O_NEGATIVE => 'O-',
        self::BLOOD_GROUP_AB_POSITIVE => 'AB+',
        self::BLOOD_GROUP_AB_NEGATIVE => 'AB-'
    ];

    const RELIGION_ISLAM = 'Islam';
    const RELIGION_HINDU = 'Hindu';
    const RELIGION_CHRISTIANITY = 'Christianity';
    const RELIGION_BUDDHISM = 'Buddhism';
    const RELIGION_OTHER = 'Other';

    const RELIGION_ARRAY = [
        self::RELIGION_ISLAM => 'Islam',
        self::RELIGION_HINDU => 'Hindu',
        self::RELIGION_CHRISTIANITY => 'Christianity',
        self::RELIGION_BUDDHISM => 'Buddhism',
        self::RELIGION_OTHER => 'Other'
    ];

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
        'started_at',
        'retired_at',
        'basic',
        'house_rent',
        'medical_allowance',
        'transport',
        'festival_bonus',
        'image',
        'signature'
    ];

    public function department(): BelongsTo
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

    public function getNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name . ' (' . $this->department->name . ')';
    }

    public function getIsSeniorAttribute(): string
    {

        if($this->designation->name == 'Senior') {
            return 'Yes';
        } else {
            return 'No';
        }

        return self::STATUS_ARRAY[$this->status] ?? 'Unknown';
    }

    public function getGrossSalaryAttribute(): float
    {
        $hourRent = $this->basic * $this->house_rent / 100;
        $medicalAllowance = $this->basic * $this->medical_allowance / 100;
        $transport = $this->basic * $this->transport / 100;
        //$festivalBonus = $this->basic * $this->festival_bonus / 100;
        
        return $this->basic + $hourRent + $medicalAllowance + $transport;
    }
    

    protected $appends = [
        'name',
        'full_name',
        'is_senior',
        'gross_salary'
    ];
}
