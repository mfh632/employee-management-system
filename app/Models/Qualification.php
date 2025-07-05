<?php

namespace App\Models;

use App\Enums\QualificationResultType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Qualification extends Model
{
    protected $fillable = [
        'institute_name',
        'passing_year',
        'board_name',
        'exam_name',
        'result_type',
        'result',
        'out_of',
        'employee_id',
    ];

    protected $casts = [
        'passing_year' => 'date',
        'result_type' => QualificationResultType::class,   
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    
}
