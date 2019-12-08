<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    protected $fillable = [
        'name', 'url', 'short_content', 'picture','active'
    ];
}
