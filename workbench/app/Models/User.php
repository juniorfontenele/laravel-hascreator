<?php

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use JuniorFontenele\LaravelHascreator\Traits\HasCreator;

class User extends Authenticatable
{
    use HasCreator;
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
