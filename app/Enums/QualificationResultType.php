<?php

namespace App\Enums;

enum QualificationResultType: int
{
    case Division = 1;
    case CGPA = 2;
    case GPA = 3;

    public function label(): string
    {
        return match ($this) {
            self::Division => 'Division',
            self::CGPA => 'CGPA',
            self::GPA => 'GPA',
        };
    }
}
