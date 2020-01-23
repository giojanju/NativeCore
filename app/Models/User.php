<?php

namespace App\Models;

use App\Lib\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'email',
        'name',
        'password',
    ];
}
