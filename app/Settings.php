<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = [
        'logo', 'logo_alt', 'sitename', 'slogan', 'main_title', 'main_description','main_keywords','website','owner','active'
    ];
}
