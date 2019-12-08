<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    protected $fillable = [
        'il_adi', 'slug', 'yayin'
    ];

    protected $table = 'il';

}
