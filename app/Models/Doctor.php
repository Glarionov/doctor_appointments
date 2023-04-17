<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    public $fillable = [
        'last_name',
        'first_name',
        'patronymic',
        'email',
        'phone',
        'start_work',
        'finish_work',
    ];
}
