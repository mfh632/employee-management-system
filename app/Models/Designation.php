<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Designation extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function employee(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
