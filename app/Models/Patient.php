<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    public $fillable = [
        'last_name',
        'first_name',
        'patronymic',
        'snils',
        'birth_date',
        'birth_place',
    ];

}
